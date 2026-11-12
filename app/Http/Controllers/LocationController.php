<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = Department::query()
            ->orderBy('nama')
            ->get()
            ->map(fn (Department $department): array => $this->locationData($department));

        return view('admins.locations', [
            'locations' => $locations,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('departments')],
            'lantai' => ['required', 'string', 'max:255'],
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $department = Department::create(Arr::only($validated, [
            'nama',
            'lantai',
            'slug',
        ]));

        return $this->respond($request, 'Lokasi departemen berhasil ditambahkan.', $department, 201);
    }

    public function update(Request $request, Department $location): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('departments')->ignore($location)],
            'lantai' => ['required', 'string', 'max:255'],
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $location = DB::transaction(function () use ($location, $validated): Department {
            $location = Department::query()->lockForUpdate()->findOrFail($location->getKey());

            $location->fill(Arr::only($validated, [
                'nama',
                'lantai',
                'slug',
            ]));

            $location->save();

            return $location;
        });

        return $this->respond($request, 'Perubahan lokasi departemen berhasil disimpan.', $location);
    }

    public function destroy(Request $request, Department $location): JsonResponse|RedirectResponse
    {
        DB::transaction(function () use ($location): void {
            $location = Department::query()->lockForUpdate()->findOrFail($location->getKey());

            if (DB::table('users')->where('id_departemen', $location->getKey())->exists() || 
                DB::table('devices')->where('id_departemen', $location->getKey())->exists()) {
                throw ValidationException::withMessages([
                    'location' => 'Lokasi tidak dapat dihapus karena masih digunakan oleh perangkat atau pengguna.',
                ]);
            }

            $location->delete();
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Lokasi berhasil dihapus.',
                'location' => ['id' => $location->getKey()],
            ]);
        }

        return back()->with('success', 'Lokasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function locationData(Department $department): array
    {
        return [
            'id' => $department->getKey(),
            'nama' => $department->nama,
            'lantai' => $department->lantai,
            'slug' => $department->slug,
        ];
    }

    private function respond(
        Request $request,
        string $message,
        Department $department,
        int $status = 200,
    ): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'location' => $this->locationData($department),
            ], $status);
        }

        return back()->with('success', $message);
    }
}