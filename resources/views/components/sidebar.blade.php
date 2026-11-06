<div id="sidebar-backdrop"
     class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 lg:hidden"></div>

<aside id="sidebar-drawer"
       class="fixed bottom-0 left-0 top-0 z-50 flex min-h-screen w-[280px] -translate-x-full shrink-0 flex-col justify-between overflow-y-auto border-r border-slate-200/90 bg-white px-6 py-7 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
    <div>
        <div class="mb-8 flex items-center justify-between px-2">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#1E293B] text-white">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/>
                    </svg>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">P-TAMS</span>
            </div>

            <button id="close-sidebar-btn" type="button" aria-label="Tutup menu"
                    class="rounded-lg p-1.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-800 lg:hidden">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </button>
        </div>

        <nav class="space-y-1.5 text-sm font-medium" aria-label="Navigasi utama">
            @php
                $navigation = [
                    ['label' => 'Dashboard', 'url' => '#', 'icon' => 'grid'],
                    ['label' => 'Kelola Device', 'url' => '#', 'icon' => 'device'],
                    ['label' => 'Kelola User', 'url' => '#', 'icon' => 'users'],
                    ['label' => 'Kelola Ticket', 'url' => '#', 'icon' => 'ticket'],
                    ['label' => 'Riwayat Kerusakan', 'url' => '#', 'icon' => 'history'],
                ];
            @endphp

            @foreach ($navigation as $item)
                <a href="{{ $item['url'] }}"
                   @class([
                       'flex items-center gap-3.5 rounded-xl px-3.5 py-3 transition-colors',
                       'bg-[#112340] font-semibold text-white shadow-sm' => $item['label'] === 'Kelola Ticket',
                       'text-slate-600 hover:text-slate-900' => $item['label'] !== 'Kelola Ticket',
                   ])>
                    <span class="h-5 w-5 shrink-0">
                        @switch($item['icon'])
                            @case('grid')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2"/></svg>
                                @break
                            @case('device')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" stroke-width="2"/><path d="M8 21h8m-4-4v4" stroke-linecap="round" stroke-width="2"/></svg>
                                @break
                            @case('users')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                @break
                            @case('ticket')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                @break
                            @case('history')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                @break
                        @endswitch
                    </span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach

            <div class="pt-2">
                <a href="#" class="flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 font-semibold text-red-600 transition-colors hover:text-red-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </div>

    <div class="relative mt-6 overflow-hidden rounded-2xl bg-[#0B1527] p-5 text-white shadow-md">
        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-white/10">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h4v4h-4zM14 20h3v1h-3z"/></svg>
        </div>
        <h2 class="mb-2 text-base font-bold leading-snug">Scan<br>QR Perangkat</h2>
        <p class="mb-4 text-xs font-normal leading-relaxed text-slate-300">
            Pindai kode QR untuk melihat informasi detail perangkat dan riwayat perbaikannya dengan mudah.
        </p>
        <button type="button" class="w-full rounded-xl bg-[#3B4D68] px-4 py-2.5 text-center text-xs font-semibold text-white transition hover:bg-[#485C7D]">
            Mulai Scan QR
        </button>
    </div>
</aside>
