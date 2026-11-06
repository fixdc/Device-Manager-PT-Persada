<div class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200/90 bg-white px-4 py-3 shadow-sm lg:hidden">
    <div class="flex items-center gap-3">
        <button id="open-sidebar-btn" type="button" aria-label="Buka menu"
                class="rounded-xl p-2 text-slate-700 transition hover:bg-slate-100">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        </button>
        <span class="text-lg font-extrabold tracking-tight text-slate-900">P-TAMS</span>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" aria-label="Notifikasi" class="relative p-1.5 text-slate-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
        </button>
        <div class="h-8 w-8 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-slate-200">
            <img alt="Avatar Fikri" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9qwX-psvyD0uR_FIo4bpO5E_uTAUcDYGa7PCxXdIUALUHn4yS1RERCe3UUs6wB1Nq_y9q_UAIgeNnYZceJp2-vfsiij9GfHAZqtzkeutJzv3c6UHiDeRFdtvFiep-GkHbu7cKJPX1u13hY7jajx8bDNyUcGo4VDgx-aWlXxvwQ4tRAqLFbhpSXhGYrWi7TF61W1s0PgW0tJc_JI46VsQt8_aGVoey89LHVnJ6Ufc">
        </div>
    </div>
</div>

<header class="flex flex-col justify-between gap-4 bg-transparent px-4 py-4 sm:px-6 md:flex-row md:items-center lg:h-20 lg:px-8" data-purpose="top-navigation-header">
    <div class="w-full lg:max-w-2xl">
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            </span>
            <input id="global-search-input" type="search" placeholder="Lakukan pencarian..."
                   class="w-full rounded-xl border border-slate-200/90 bg-white py-2.5 pl-11 pr-4 text-sm shadow-sm placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
        </div>
    </div>

    <div class="ml-6 hidden shrink-0 items-center gap-6 lg:flex">
        <button type="button" aria-label="Notifikasi" class="relative text-slate-700 transition hover:text-slate-900">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
            <span class="absolute right-0 top-0 h-2.5 w-2.5 rounded-full border-2 border-white bg-red-500"></span>
        </button>
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full border border-slate-200 bg-slate-200">
                <img alt="Avatar Fikri" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9qwX-psvyD0uR_FIo4bpO5E_uTAUcDYGa7PCxXdIUALUHn4yS1RERCe3UUs6wB1Nq_y9q_UAIgeNnYZceJp2-vfsiij9GfHAZqtzkeutJzv3c6UHiDeRFdtvFiep-GkHbu7cKJPX1u13hY7jajx8bDNyUcGo4VDgx-aWlXxvwQ4tRAqLFbhpSXhGYrWi7TF61W1s0PgW0tJc_JI46VsQt8_aGVoey89LHVnJ6Ufc">
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold leading-tight text-slate-800">Fikri</span>
                <span class="text-xs font-medium text-slate-400">Admin</span>
            </div>
        </div>
    </div>
</header>
