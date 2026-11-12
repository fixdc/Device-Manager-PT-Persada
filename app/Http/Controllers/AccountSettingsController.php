<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountSettingsController extends Controller
{
    public function updateProfile(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $request->merge([
            'email' => is_string($request->input('email'))
                ? Str::lower($request->input('email'))
                : $request->input('email'),
        ]);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'no_telp' => ['nullable', 'string', 'max:40'],
            'id_departemen' => ['nullable', Rule::exists('departments', 'id')],
        ]);

        $user->fill([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_telp' => $validated['no_telp'] ?? null,
            'id_departemen' => $validated['id_departemen'] ?? null,
        ]);

        $user->save();

        return $this->respond($request, 'Profil berhasil diperbarui.', [
            'user' => $this->profileData($user),
        ]);
    }

    public function updateNotifications(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'ticket_updates' => ['required', 'boolean'],
            'ticket_assignments' => ['required', 'boolean'],
            'system_announcements' => ['required', 'boolean'],
        ]);

        $preferences = $request->user()->preferences()->firstOrNew();
        $preferences->fill($validated)->save();

        return $this->respond($request, 'Preferensi notifikasi berhasil disimpan.', [
            'preferences' => $preferences->only([
                'ticket_updates',
                'ticket_assignments',
                'system_announcements',
            ]),
        ]);
    }

    public function updatePassword(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $request->user()->forceFill([
            'kata_sandi' => $validated['password'],
        ])->save();

        Auth::logoutOtherDevices($validated['password']);

        return $this->respond($request, 'Kata sandi berhasil diperbarui.');
    }

    public function sessions(Request $request): JsonResponse
    {
        if (config('session.driver') !== 'database') {
            return response()->json([
                'supported' => false,
                'sessions' => [],
            ]);
        }

        $connection = DB::connection(config('session.connection'));
        $table = (string) config('session.table', 'sessions');

        if (! $connection->getSchemaBuilder()->hasTable($table)) {
            return response()->json([
                'supported' => false,
                'sessions' => [],
            ]);
        }

        $sessions = $connection->table($table)
            ->where('user_id', $request->user()->getKey())
            ->where('last_activity', '>=', now()->subMinutes((int) config('session.lifetime'))->timestamp)
            ->orderByDesc('last_activity')
            ->get(['id', 'ip_address', 'user_agent', 'last_activity'])
            ->map(function (object $session) use ($request): array {
                $userAgent = (string) $session->user_agent;

                return [
                    'device' => $this->deviceName($userAgent),
                    'browser' => $this->browserName($userAgent),
                    'ip_address' => $session->ip_address,
                    'last_activity' => now()->setTimestamp((int) $session->last_activity)->toIso8601String(),
                    'current' => hash_equals($request->session()->getId(), (string) $session->id),
                ];
            })
            ->values();

        return response()->json([
            'supported' => true,
            'sessions' => $sessions,
        ]);
    }

    public function logoutOtherDevices(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:web'],
        ]);

        Auth::logoutOtherDevices($validated['current_password']);

        return $this->respond($request, 'Perangkat lain berhasil dikeluarkan.');
    }

    private function profileData(User $user): array
    {
        return [
            'nama' => $user->nama,
            'email' => $user->email,
            'no_telp' => $user->no_telp,
            'id_departemen' => $user->id_departemen,
            'departemen_nama' => $user->department?->nama,
            'role' => $user->role,
        ];
    }

    private function respond(Request $request, string $message, array $data = []): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                ...$data,
            ]);
        }

        return back()->with('success', $message);
    }

    private function browserName(string $userAgent): string
    {
        return match (true) {
            Str::contains($userAgent, ['Edg/', 'Edge/']) => 'Microsoft Edge',
            Str::contains($userAgent, 'Firefox/') => 'Mozilla Firefox',
            Str::contains($userAgent, 'Chrome/') => 'Google Chrome',
            Str::contains($userAgent, 'Safari/') => 'Safari',
            default => 'Browser tidak dikenal',
        };
    }

    private function deviceName(string $userAgent): string
    {
        $platform = match (true) {
            Str::contains($userAgent, ['iPhone', 'iPad', 'iPod']) => 'iOS',
            Str::contains($userAgent, 'Android') => 'Android',
            Str::contains($userAgent, 'Windows') => 'Windows',
            Str::contains($userAgent, ['Macintosh', 'Mac OS']) => 'macOS',
            Str::contains($userAgent, 'Linux') => 'Linux',
            default => 'Perangkat',
        };
        $device = Str::contains($userAgent, ['Mobile', 'Android', 'iPhone', 'iPad'])
            ? 'Seluler'
            : 'Desktop';

        return $device.' · '.$platform;
    }
}
