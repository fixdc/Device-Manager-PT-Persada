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
            <div class="flex items-center gap-2.5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=0D8ABC&color=fff" alt="Avatar {{ $name }}" class="h-9 w-9 rounded-full object-cover">
                <div class="hidden text-xs leading-tight sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ $name }}</p>
                    <p class="text-slate-500">{{ $role }}</p>
                </div>
            </div>
        @endif
    </div>
</header>