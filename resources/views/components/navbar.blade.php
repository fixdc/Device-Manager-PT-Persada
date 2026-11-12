{{--
    Komponen Navbar
    Lokasi : resources/views/components/navbar.blade.php

    Pemakaian:
      Admin/user dengan sidebar : <x-navbar name="Fikri" role="Admin" />
      Halaman tanpa sidebar     : <x-navbar :with-sidebar="false" guest />   (logo + tombol Login)
      Tanpa sidebar tapi login  : <x-navbar :with-sidebar="false" name="Fikri" role="User" />

    Catatan: kalau with-sidebar = true, butuh state Alpine `sidebarOpen` dari elemen induk (x-data).
--}}
@props(['name' => 'Fikri', 'role' => 'Admin', 'withSidebar' => true, 'guest' => false])

@if (! $guest && auth()->check())
    @php
        $account = auth()->user();
        $preferences = $account->preferences;
        $departments = \App\Models\Department::query()->orderBy('nama')->get(['id', 'nama']);
        $accountSettings = [
            'profile' => [
                'nama' => $account->nama,
                'email' => $account->email,
                'no_telp' => $account->no_telp,
                'id_departemen' => $account->id_departemen,
                'role' => $account->role,
            ],
            'notifications' => [
                'ticket_updates' => $preferences?->ticket_updates ?? true,
                'ticket_assignments' => $preferences?->ticket_assignments ?? true,
                'system_announcements' => $preferences?->system_announcements ?? true,
            ],
        ];
    @endphp
    <div
        x-data="accountSettingsModal(
            @js($accountSettings),
            @js(csrf_token()),
            @js(route('account-settings.profile.update')),
            @js(route('account-settings.notifications.update')),
            @js(route('account-settings.password.update')),
            @js(route('account-settings.sessions.index')),
            @js(route('account-settings.sessions.destroy-others'))
        )"
        @open-account-settings.window="openModal($event.detail?.tab || 'profile')"
        @keydown.escape.window="if (isOpen) closeModal()"
    >
@endif

{{-- h-16 sama dengan area logo di sidebar, jadi garis bawahnya sejajar --}}
<header class="flex h-16 shrink-0 items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 md:px-6">
    <div class="flex min-w-0 flex-1 items-center gap-3 md:gap-6">
        @if ($withSidebar)
            {{-- Hamburger (mobile) di kiri atas --}}
            <button @click="sidebarOpen = true" class="rounded-lg p-1.5 text-slate-600 hover:bg-slate-100 md:hidden" aria-label="Buka menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        @else
            {{-- Logo (dipakai kalau tidak ada sidebar) --}}
            <a href="/" class="flex shrink-0 items-center gap-2 text-lg font-bold text-[#10254a]">
                <svg class="h-7 w-7" viewBox="0 0 28 28" fill="#10254a" aria-hidden="true">
                    <path d="M14 3a11 11 0 000 22V3z"/>
                    <path d="M17 3.6a11 11 0 010 20.8V3.6z" opacity=".55"/>
                </svg>
                P-TAMS
            </a>
        @endif

        <div class="relative hidden w-full max-w-xl sm:block">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input type="text" placeholder="Lakukan pencarian..." class="w-full rounded-lg border border-slate-200 bg-white py-2 pl-9 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
        </div>
    </div>

    <div class="flex shrink-0 items-center gap-4">
        @if ($guest)
            {{-- Tombol Login --}}
            <a href="/login" class="flex items-center gap-2 rounded-lg bg-[#10254a] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Login
            </a>
        @else
            <button class="relative text-slate-500 hover:text-slate-700" aria-label="Notifikasi">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span class="absolute right-0 top-0 h-2 w-2 rounded-full bg-red-500"></span>
            </button>
            <button type="button" @click="openModal('profile')" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-[#10254a]" aria-label="Pengaturan akun">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.3 4.3c.4-1.8 3-1.8 3.4 0a1.7 1.7 0 002.5 1.1c1.6-.9 3.3.8 2.4 2.4a1.7 1.7 0 001 2.5c1.8.4 1.8 3 0 3.4a1.7 1.7 0 00-1 2.5c.9 1.6-.8 3.3-2.4 2.4a1.7 1.7 0 00-2.5 1.1c-.4 1.8-3 1.8-3.4 0a1.7 1.7 0 00-2.5-1.1c-1.6.9-3.3-.8-2.4-2.4a1.7 1.7 0 00-1-2.5c-1.8-.4-1.8-3 0-3.4a1.7 1.7 0 001-2.5c-.9-1.6.8-3.3 2.4-2.4a1.7 1.7 0 002.5-1.1z"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/></svg>
            </button>
            <div class="flex items-center gap-2.5">
                <span x-text="initials(profile.nama)" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#10254a] text-xs font-bold text-white"></span>
                <div class="hidden text-xs leading-tight sm:block">
                    <p class="text-sm font-bold text-slate-800" x-text="profile.nama"></p>
                    <p class="text-slate-500" x-text="formatRole(profile.role)"></p>
                </div>
            </div>
        @endif
    </div>
</header>

@if (! $guest && auth()->check())
    <x-account-settings-modal :departments="$departments" />
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('accountSettingsModal', (settings, csrfToken, profileUrl, notificationsUrl, passwordUrl, sessionsUrl, logoutOthersUrl) => ({
                isOpen: false,
                activeTab: 'profile',
                profile: { ...settings.profile },
                profileForm: { ...settings.profile },
                notifications: { ...settings.notifications },
                savedNotifications: { ...settings.notifications },
                csrfToken,
                profileUrl,
                notificationsUrl,
                passwordUrl,
                sessionsUrl,
                logoutOthersUrl,
                currentPassword: '',
                newPassword: '',
                newPasswordConfirmation: '',
                deviceLogoutPassword: '',
                sessions: [],
                sessionsSupported: true,
                loadingSessions: false,
                saving: null,
                toastMessage: '',
                toastType: 'success',
                toastTimer: null,

                openModal(tab = 'profile') {
                    this.profileForm = { ...this.profile };
                    this.selectTab(tab);
                    this.isOpen = true;
                },

                selectTab(tab) {
                    this.activeTab = ['profile', 'notifications', 'security'].includes(tab) ? tab : 'profile';

                    if (this.activeTab === 'security') this.loadSessions();
                },

                closeModal() {
                    this.isOpen = false;
                },

                initials(name) {
                    return (name || '')
                        .trim()
                        .split(/\s+/)
                        .slice(0, 2)
                        .map(part => part[0] || '')
                        .join('')
                        .toUpperCase() || 'US';
                },

                formatRole(role) {
                    return role ? role.charAt(0).toUpperCase() + role.slice(1) : '';
                },

                async request(url, method, body, json = false) {
                    const headers = {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                    };

                    if (json) headers['Content-Type'] = 'application/json';

                    const response = await fetch(url, {
                        method,
                        headers,
                        body,
                        credentials: 'same-origin',
                    });
                    const result = await response.json().catch(() => ({
                        message: `Permintaan gagal (HTTP ${response.status}).`,
                    }));

                    if (!response.ok) {
                        const error = new Error(result.message || 'Permintaan gagal.');
                        error.validationErrors = result.errors || null;
                        throw error;
                    }

                    return result;
                },

                errorMessage(error) {
                    return error.validationErrors
                        ? Object.values(error.validationErrors).flat().join(' ')
                        : error.message;
                },

                toast(message, type = 'success') {
                    this.toastMessage = message;
                    this.toastType = type;
                    clearTimeout(this.toastTimer);
                    this.toastTimer = setTimeout(() => this.toastMessage = '', 4000);
                },

                async saveProfile(formElement) {
                    if (this.saving) return;

                    this.saving = 'profile';

                    try {
                        const result = await this.request(
                            this.profileUrl,
                            'POST',
                            new FormData(formElement),
                        );
                        this.profile = { ...this.profile, ...result.user };
                        this.profileForm = { ...this.profile };
                        this.toast(result.message);
                    } catch (error) {
                        this.toast(this.errorMessage(error), 'error');
                    } finally {
                        this.saving = null;
                    }
                },

                async saveNotifications() {
                    if (this.saving) return;

                    const previous = { ...this.savedNotifications };
                    this.saving = 'notifications';

                    try {
                        const result = await this.request(
                            this.notificationsUrl,
                            'PATCH',
                            JSON.stringify(this.notifications),
                            true,
                        );
                        this.notifications = { ...result.preferences };
                        this.savedNotifications = { ...result.preferences };
                        this.toast(result.message);
                    } catch (error) {
                        this.notifications = previous;
                        this.toast(this.errorMessage(error), 'error');
                    } finally {
                        this.saving = null;
                    }
                },

                async savePassword(formElement) {
                    if (this.saving) return;

                    this.saving = 'password';

                    try {
                        const result = await this.request(
                            this.passwordUrl,
                            'POST',
                            new FormData(formElement),
                        );
                        formElement.reset();
                        this.currentPassword = '';
                        this.newPassword = '';
                        this.newPasswordConfirmation = '';
                        this.toast(result.message);
                    } catch (error) {
                        this.toast(this.errorMessage(error), 'error');
                    } finally {
                        this.saving = null;
                    }
                },

                async loadSessions() {
                    if (this.loadingSessions) return;

                    this.loadingSessions = true;

                    try {
                        const result = await this.request(this.sessionsUrl, 'GET');
                        this.sessionsSupported = result.supported;
                        this.sessions = result.sessions;
                    } catch (error) {
                        this.toast(this.errorMessage(error), 'error');
                    } finally {
                        this.loadingSessions = false;
                    }
                },

                async logoutOtherDevices(formElement) {
                    if (this.saving) return;

                    this.saving = 'devices';

                    try {
                        const result = await this.request(
                            this.logoutOthersUrl,
                            'POST',
                            new FormData(formElement),
                        );
                        formElement.reset();
                        this.deviceLogoutPassword = '';
                        await this.loadSessions();
                        this.toast(result.message);
                    } catch (error) {
                        this.toast(this.errorMessage(error), 'error');
                    } finally {
                        this.saving = null;
                    }
                },
            }));
        });
    </script>
@endif
