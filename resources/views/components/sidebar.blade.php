{{--
    Komponen Sidebar (beda menu untuk admin dan user)
    Lokasi    : resources/views/components/sidebar.blade.php

    Pemakaian : <x-sidebar role="admin" active="dashboard" />
                <x-sidebar role="user"  active="perangkat" />

    Admin : dashboard | device | user | ticket | riwayat
    User  : dashboard | perangkat | tiket | buat

    Catatan   : butuh state Alpine `sidebarOpen` dari elemen induk (x-data).
                Ganti href '#' dengan route kamu, mis. route('admin.devices.index').
--}}
@props(['role' => 'admin', 'active' => 'dashboard'])

@php
    $icons = [
        'dashboard' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
        'device'    => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'user'      => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        'ticket'    => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
        'history'   => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'plus'      => 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z',
    ];

    $menusByRole = [
        'admin' => [
            ['key' => 'dashboard', 'label' => 'Dashboard',         'href' => '#', 'icon' => $icons['dashboard']],
            ['key' => 'device',    'label' => 'Kelola Device',     'href' => '#', 'icon' => $icons['device']],
            ['key' => 'user',      'label' => 'Kelola User',       'href' => '#', 'icon' => $icons['user']],
            ['key' => 'ticket',    'label' => 'Kelola Ticket',     'href' => '#', 'icon' => $icons['ticket']],
            ['key' => 'riwayat',   'label' => 'Riwayat Kerusakan', 'href' => '#', 'icon' => $icons['history']],
        ],
        'user' => [
            ['key' => 'dashboard', 'label' => 'Dashboard',       'href' => '#', 'icon' => $icons['dashboard']],
            ['key' => 'perangkat', 'label' => 'Perangkat saya',  'href' => '#', 'icon' => $icons['device']],
            ['key' => 'tiket',     'label' => 'Tiket Saya',      'href' => '#', 'icon' => $icons['ticket']],
            ['key' => 'buat',      'label' => 'Buat Tiket',      'href' => '#', 'icon' => $icons['plus']],
        ],
    ];

    $menus = $menusByRole[$role] ?? $menusByRole['user'];
@endphp

{{-- Overlay (mobile) --}}
<div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
     class="fixed inset-0 z-30 bg-slate-900/50 md:hidden"></div>

<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 flex h-full w-64 shrink-0 flex-col justify-between overflow-y-auto border-r border-slate-200 bg-white transition-transform duration-300 md:static md:z-auto md:w-60 md:translate-x-0 lg:w-64"
>
    <div>
        {{-- Logo: tingginya sama dengan navbar (h-16) supaya garis bawahnya sejajar --}}
        <div class="flex h-16 items-center justify-between border-b border-slate-200 px-4 md:justify-center">
            <div class="flex items-center gap-2 text-lg font-bold text-[#10254a]">
                <svg class="h-7 w-7" viewBox="0 0 28 28" fill="#10254a" aria-hidden="true">
                    <path d="M14 3a11 11 0 000 22V3z"/>
                    <path d="M17 3.6a11 11 0 010 20.8V3.6z" opacity=".55"/>
                </svg>
                P-TAMS
            </div>
            <button @click="sidebarOpen = false" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 md:hidden" aria-label="Tutup menu">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Menu --}}
        <nav class="space-y-1 p-4 text-sm font-medium text-slate-600">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] }}"
                   @if ($active === $menu['key']) aria-current="page" @endif
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ $active === $menu['key'] ? 'bg-[#10254a] text-white' : 'hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/></svg>
                    {{ $menu['label'] }}
                </a>
            @endforeach

            {{-- Logout --}}
            <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-red-600 hover:bg-red-50">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </a>
        </nav>
    </div>

    {{-- Kartu Scan QR (admin & user) --}}
    <div class="m-4 rounded-lg bg-[#0b1b3a] p-4 text-white">
        <div class="mb-3 flex h-8 w-8 items-center justify-center rounded-md bg-white text-[#0b1b3a]">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm8-2h2v2h-2v-2zm4 0h4v2h-4v-2zm-4 4h2v4h-2v-4zm4 2h4v2h-4v-2z"/></svg>
        </div>
        <h4 class="text-base font-bold leading-tight">Scan<br>QR Perangkat</h4>
        <p class="mt-2 text-[11px] leading-relaxed text-slate-300">Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.</p>
        <button type="button" class="mt-4 w-full rounded-md bg-white/15 py-2 text-xs font-medium transition-colors hover:bg-white/25">
            Mulai Scan QR
        </button>
    </div>
</aside>