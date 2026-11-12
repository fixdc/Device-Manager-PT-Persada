@props(['departments'])

<div
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[70] flex items-center justify-center p-3 sm:p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="account-settings-title"
    @click.self="closeModal()"
>
    <div x-show="isOpen" x-transition.opacity @click="closeModal()" class="absolute inset-0 bg-slate-950/60"></div>

    <section x-show="isOpen" x-transition class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
        <header class="flex shrink-0 items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-7">
            <div>
                <h2 id="account-settings-title" class="text-lg font-bold text-[#10254a] sm:text-xl">Account Settings</h2>
                <p class="mt-0.5 text-xs text-slate-500">Kelola profil, preferensi, dan keamanan akun Anda.</p>
            </div>
            <button type="button" @click="closeModal()" class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup pengaturan">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </header>

        <div class="flex min-h-0 flex-1 flex-col md:flex-row">
            <nav class="flex shrink-0 gap-1 overflow-x-auto border-b border-slate-100 bg-slate-50 p-2 md:w-56 md:flex-col md:gap-1.5 md:border-b-0 md:border-r md:p-4" aria-label="Menu pengaturan akun">
                <button type="button" @click="selectTab('profile')" :aria-current="activeTab === 'profile' ? 'page' : null" class="flex shrink-0 items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-semibold transition-colors md:w-full" :class="activeTab === 'profile' ? 'bg-[#10254a] text-white' : 'text-slate-600 hover:bg-white hover:text-[#10254a]'">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </button>
                <button type="button" @click="selectTab('notifications')" :aria-current="activeTab === 'notifications' ? 'page' : null" class="flex shrink-0 items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-semibold transition-colors md:w-full" :class="activeTab === 'notifications' ? 'bg-[#10254a] text-white' : 'text-slate-600 hover:bg-white hover:text-[#10254a]'">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Notifications
                </button>
                <button type="button" @click="selectTab('security')" :aria-current="activeTab === 'security' ? 'page' : null" class="flex shrink-0 items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-semibold transition-colors md:w-full" :class="activeTab === 'security' ? 'bg-[#10254a] text-white' : 'text-slate-600 hover:bg-white hover:text-[#10254a]'">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Security
                </button>
            </nav>

            <div class="min-h-0 flex-1 overflow-y-auto p-5 sm:p-7">
                <template x-if="activeTab === 'profile'">
                <section id="settings-profile-panel" aria-labelledby="settings-profile-title">
                    <div class="mb-6">
                        <h3 id="settings-profile-title" class="text-base font-bold text-slate-900">Profile</h3>
                        <p class="mt-1 text-sm text-slate-500">Informasi profil ini hanya berlaku untuk akun Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('account-settings.profile.update') }}" @submit.prevent="saveProfile($event.target)" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Nama lengkap
                                <input type="text" name="nama" x-model="profileForm.nama" required maxlength="255" class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                            </label>
                            <label class="block text-sm font-medium text-slate-700">
                                Email
                                <input type="email" name="email" x-model="profileForm.email" required maxlength="255" class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                            </label>
                            <label class="block text-sm font-medium text-slate-700">
                                Nomor telepon
                                <input type="text" name="no_telp" x-model="profileForm.no_telp" maxlength="40" class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                            </label>
                            <label class="block text-sm font-medium text-slate-700">
                                Departemen
                                <select name="id_departemen" x-model="profileForm.id_departemen" class="mt-1.5 w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                                    <option value="">Tanpa departemen</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->nama }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <p class="text-xs text-slate-500">Role akun: <span class="font-semibold text-slate-700" x-text="formatRole(profile.role)"></span>. Perubahan role hanya dapat dilakukan oleh administrator.</p>
                        <div class="flex justify-end border-t border-slate-100 pt-4">
                            <button type="submit" :disabled="saving === 'profile'" class="rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a] disabled:cursor-wait disabled:opacity-70">
                                <span x-text="saving === 'profile' ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                            </button>
                        </div>
                    </form>
                </section>
                </template>

                <template x-if="activeTab === 'notifications'">
                <section id="settings-notifications-panel" aria-labelledby="settings-notifications-title">
                    <div class="mb-6">
                        <h3 id="settings-notifications-title" class="text-base font-bold text-slate-900">Notifications</h3>
                        <p class="mt-1 text-sm text-slate-500">Preferensi ini tersimpan di akun dan siap dipakai modul notifikasi.</p>
                    </div>

                    <div class="divide-y divide-slate-100 rounded-xl border border-slate-200 px-4">
                        <label class="flex cursor-pointer items-center justify-between gap-4 py-4">
                            <span>
                                <span class="block text-sm font-semibold text-slate-800">Pembaruan status tiket</span>
                                <span class="mt-1 block text-xs text-slate-500">Perubahan status tiket yang Anda ikuti.</span>
                            </span>
                            <input type="checkbox" x-model="notifications.ticket_updates" @change="saveNotifications()" :disabled="saving === 'notifications'" class="h-4 w-4 accent-[#10254a]">
                        </label>
                        <label class="flex cursor-pointer items-center justify-between gap-4 py-4">
                            <span>
                                <span class="block text-sm font-semibold text-slate-800">Penugasan teknisi</span>
                                <span class="mt-1 block text-xs text-slate-500">Informasi saat teknisi ditugaskan ke tiket Anda.</span>
                            </span>
                            <input type="checkbox" x-model="notifications.ticket_assignments" @change="saveNotifications()" :disabled="saving === 'notifications'" class="h-4 w-4 accent-[#10254a]">
                        </label>
                        <label class="flex cursor-pointer items-center justify-between gap-4 py-4">
                            <span>
                                <span class="block text-sm font-semibold text-slate-800">Informasi dan pengumuman sistem</span>
                                <span class="mt-1 block text-xs text-slate-500">Informasi layanan dan pengumuman P-TAMS.</span>
                            </span>
                            <input type="checkbox" x-model="notifications.system_announcements" @change="saveNotifications()" :disabled="saving === 'notifications'" class="h-4 w-4 accent-[#10254a]">
                        </label>
                    </div>
                    <p class="mt-4 text-xs text-slate-500" role="status" x-show="saving === 'notifications'">Menyimpan preferensi...</p>
                </section>
                </template>

                <template x-if="activeTab === 'security'">
                <section id="settings-security-panel" aria-labelledby="settings-security-title">
                    <div class="mb-6">
                        <h3 id="settings-security-title" class="text-base font-bold text-slate-900">Security</h3>
                        <p class="mt-1 text-sm text-slate-500">Gunakan kata sandi yang kuat untuk menjaga keamanan akun.</p>
                    </div>

                    <form method="POST" action="{{ route('account-settings.password.update') }}" @submit.prevent="savePassword($event.target)" class="space-y-4 rounded-xl border border-slate-200 p-4 sm:p-5">
                        @csrf
                        @method('PUT')
                        <h4 class="text-sm font-bold text-slate-800">Ganti kata sandi</h4>
                        <label class="block text-sm font-medium text-slate-700">
                            Kata sandi saat ini
                            <input type="password" name="current_password" x-model="currentPassword" autocomplete="current-password" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                        </label>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block text-sm font-medium text-slate-700">
                                Kata sandi baru
                                <input type="password" name="password" x-model="newPassword" autocomplete="new-password" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                            </label>
                            <label class="block text-sm font-medium text-slate-700">
                                Konfirmasi kata sandi baru
                                <input type="password" name="password_confirmation" x-model="newPasswordConfirmation" autocomplete="new-password" required class="mt-1.5 w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                            </label>
                        </div>
                        <p class="text-xs text-slate-500">Minimal 12 karakter dengan huruf besar/kecil, angka, dan simbol.</p>
                        <div class="flex justify-end">
                            <button type="submit" :disabled="saving === 'password'" class="rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#0b1b3a] disabled:cursor-wait disabled:opacity-70">
                                <span x-text="saving === 'password' ? 'Menyimpan...' : 'Simpan Kata Sandi'"></span>
                            </button>
                        </div>
                    </form>

                    <div class="mt-5 rounded-xl border border-slate-200 p-4 sm:p-5">
                        <div class="mb-4 flex items-start justify-between gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Perangkat aktif</h4>
                                <p class="mt-1 text-xs text-slate-500">Daftar sesi aktif dari penyimpanan sesi database.</p>
                            </div>
                            <button type="button" @click="loadSessions()" :disabled="loadingSessions" class="text-xs font-semibold text-[#10254a] hover:underline disabled:opacity-60">
                                <span x-text="loadingSessions ? 'Memuat...' : 'Muat ulang'"></span>
                            </button>
                        </div>

                        <p x-show="loadingSessions" class="text-sm text-slate-500">Memuat informasi perangkat...</p>
                        <p x-show="!loadingSessions && !sessionsSupported" class="text-sm text-slate-500">Informasi sesi aktif tidak tersedia pada driver sesi saat ini.</p>
                        <p x-show="!loadingSessions && sessionsSupported && sessions.length === 0" class="text-sm text-slate-500">Tidak ada sesi aktif lain yang tercatat.</p>

                        <ul x-show="!loadingSessions && sessionsSupported && sessions.length > 0" class="space-y-3">
                            <template x-for="(session, index) in sessions" :key="index">
                                <li class="flex flex-col gap-1 rounded-lg bg-slate-50 px-3 py-2.5 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800"><span x-text="session.device"></span> · <span x-text="session.browser"></span></p>
                                        <p class="mt-0.5 text-xs text-slate-500"><span x-text="session.ip_address || 'Alamat IP tidak tersedia'"></span> · <span x-text="new Date(session.last_activity).toLocaleString('id-ID')"></span></p>
                                    </div>
                                    <span x-show="session.current" class="self-start rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">Perangkat ini</span>
                                </li>
                            </template>
                        </ul>

                        <form x-show="sessionsSupported" method="POST" action="{{ route('account-settings.sessions.destroy-others') }}" @submit.prevent="logoutOtherDevices($event.target)" class="mt-5 border-t border-slate-100 pt-4">
                            @csrf
                            <h4 class="text-sm font-semibold text-slate-800">Sign out all other devices</h4>
                            <p class="mt-1 text-xs text-slate-500">Masukkan kata sandi saat ini untuk mengeluarkan sesi lain.</p>
                            <div class="mt-3 flex flex-col gap-2 sm:flex-row">
                                <input type="password" name="current_password" x-model="deviceLogoutPassword" autocomplete="current-password" required placeholder="Kata sandi saat ini" class="min-w-0 flex-1 rounded-lg border border-slate-200 px-3.5 py-2 text-sm focus:border-[#10254a] focus:outline-none focus:ring-2 focus:ring-[#10254a]/15">
                                <button type="submit" :disabled="saving === 'devices'" class="rounded-lg border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50 disabled:cursor-wait disabled:opacity-70">
                                    <span x-text="saving === 'devices' ? 'Memproses...' : 'Sign out other devices'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
                </template>
            </div>
        </div>
    </section>

    <div x-show="toastMessage" x-cloak x-transition class="fixed bottom-5 right-5 z-[90] max-w-sm rounded-xl border px-4 py-3 text-sm font-medium text-white shadow-lg" :class="toastType === 'success' ? 'border-slate-700 bg-[#10254a]' : 'border-rose-700 bg-rose-600'" role="status" aria-live="polite">
        <span x-text="toastMessage"></span>
    </div>
</div>
