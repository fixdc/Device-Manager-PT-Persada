<?php

namespace App\Http\Controllers;

use App\Models\DeviceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admins.categories', [
            'categories' => DeviceCategory::query()
                ->withCount('devices')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        $slug = $this->validatedSlug($validated['nama']);

        DeviceCategory::query()->create([
            'nama' => $validated['nama'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori perangkat berhasil ditambahkan.');
    }

    public function update(Request $request, DeviceCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.string' => 'Nama kategori harus berupa teks.',
            'nama.max' => 'Nama kategori maksimal 255 karakter.',
        ]);

        $slug = $this->validatedSlug($validated['nama'], $category);

        DB::transaction(function () use ($category, $validated, $slug): void {
            $category = DeviceCategory::query()->lockForUpdate()->findOrFail($category->getKey());
            $category->update([
                'nama' => $validated['nama'],
                'slug' => $slug,
            ]);
        });

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori perangkat berhasil diperbarui.');
    }

    public function destroy(DeviceCategory $category): RedirectResponse
    {
        DB::transaction(function () use ($category): void {
            $category = DeviceCategory::query()->lockForUpdate()->findOrFail($category->getKey());

            if ($category->devices()->exists()) {
                throw ValidationException::withMessages([
                    'category' => 'Kategori tidak dapat dihapus karena masih digunakan oleh perangkat.',
                ]);
            }

            $category->delete();
        });

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori perangkat berhasil dihapus.');
    }

    private function validatedSlug(string $name, ?DeviceCategory $category = null): string
    {
        $slug = Str::slug($name) ?: 'kategori';
        $uniqueRule = Rule::unique('device_categories', 'slug');

        if ($category !== null) {
            $uniqueRule->ignore($category);
        }

        Validator::make(
            ['slug' => $slug],
            ['slug' => ['required', 'string', 'max:255', $uniqueRule]],
            [
                'slug.unique' => 'Nama kategori menghasilkan slug yang sudah digunakan. Pilih nama kategori lain.',
                'slug.max' => 'Slug kategori terlalu panjang. Gunakan nama yang lebih pendek.',
            ],
        )->validate();

        return $slug;
    }
}
