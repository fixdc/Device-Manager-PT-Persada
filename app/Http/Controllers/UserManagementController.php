<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', Rule::in(User::ROLES)],
        ]);
        $search = trim($validated['search'] ?? '');

        $users = User::query()
            ->with('department:id,nama')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('nama', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%')
                        ->orWhere('role', 'like', '%'.$search.'%')
                        ->orWhere('no_telp', 'like', '%'.$search.'%')
                        ->orWhereHas('department', fn (Builder $department) => $department->where('nama', 'like', '%'.$search.'%'));
                });
            })
            ->when(isset($validated['role']), fn (Builder $query) => $query->where('role', $validated['role']))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (User $user): array => $this->userData($user));

        return view('admins.user', [
            'users' => $users,
            'departments' => Department::query()->orderBy('nama')->get(['id', 'nama']),
            'search' => $search,
            'roleFilter' => $validated['role'] ?? '',
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->merge([
            'email' => is_string($request->input('email'))
                ? Str::lower($request->input('email'))
                : $request->input('email'),
        ]);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')],
            'role' => ['required', Rule::in(User::ROLES)],
            'id_departemen' => ['nullable', Rule::exists('departments', 'id')],
            'no_telp' => ['nullable', 'string', 'max:40'],
            'kata_sandi' => [
                'required',
                'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = User::create(Arr::only($validated, [
            'nama',
            'email',
            'role',
            'id_departemen',
            'no_telp',
            'kata_sandi',
        ]));

        return $this->respond($request, 'Pengguna berhasil ditambahkan.', $user, 201);
    }

    public function update(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $request->merge([
            'email' => is_string($request->input('email'))
                ? Str::lower($request->input('email'))
                : $request->input('email'),
        ]);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required', Rule::in(User::ROLES)],
            'id_departemen' => ['nullable', Rule::exists('departments', 'id')],
            'no_telp' => ['nullable', 'string', 'max:40'],
            'kata_sandi' => [
                'nullable',
                'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = DB::transaction(function () use ($user, $validated): User {
            $user = User::query()->lockForUpdate()->findOrFail($user->getKey());

            if ($user->role === 'admin' && $validated['role'] !== 'admin') {
                $this->ensureAnotherAdministratorExists();
            }

            $user->fill(Arr::only($validated, [
                'nama',
                'email',
                'role',
                'id_departemen',
                'no_telp',
            ]));

            if (! empty($validated['kata_sandi'])) {
                $user->kata_sandi = $validated['kata_sandi'];
            }

            $user->save();

            return $user->load('department:id,nama');
        });

        return $this->respond($request, 'Perubahan pengguna berhasil disimpan.', $user);
    }

    public function destroy(Request $request, User $user): JsonResponse|RedirectResponse
    {
        abort_if($user->is($request->user()), 403, 'Anda tidak dapat menghapus akun sendiri.');

        DB::transaction(function () use ($user): void {
            $user = User::query()->lockForUpdate()->findOrFail($user->getKey());

            if ($user->role === 'admin') {
                $this->ensureAnotherAdministratorExists();
            }

            if (DB::table('tickets')->where('id_user', $user->getKey())->exists()) {
                throw ValidationException::withMessages([
                    'user' => 'Akun tidak dapat dihapus karena masih tercatat sebagai pelapor tiket.',
                ]);
            }

            $user->delete();
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pengguna berhasil dihapus.',
                'user' => ['id' => $user->getKey()],
            ]);
        }

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    private function ensureAnotherAdministratorExists(): void
    {
        $administratorIds = User::query()
            ->where('role', 'admin')
            ->orderBy('id')
            ->lockForUpdate()
            ->pluck('id');

        if ($administratorIds->count() <= 1) {
            throw ValidationException::withMessages([
                'role' => 'Administrator terakhir tidak dapat diturunkan perannya atau dihapus.',
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function userData(User $user): array
    {
        return [
            'id' => $user->getKey(),
            'nama' => $user->nama,
            'email' => $user->email,
            'role' => $user->role,
            'id_departemen' => $user->id_departemen,
            'departemen_nama' => $user->department?->nama,
            'no_telp' => $user->no_telp,
        ];
    }

    private function respond(
        Request $request,
        string $message,
        User $user,
        int $status = 200,
    ): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'user' => $this->userData($user->loadMissing('department:id,nama')),
            ], $status);
        }

        return back()->with('success', $message);
    }
}
