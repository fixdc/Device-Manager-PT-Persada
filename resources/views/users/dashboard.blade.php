@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data milik user yang login: $userName, $tickets, $activities.
     */
    $userName = 'Fikri';

    $tickets = [
        ['id' => '#TC-001', 'device' => 'PC Kantor',  'reporter' => 'Fikri', 'status' => 'Pending'],
        ['id' => '#TC-002', 'device' => 'Printer',    'reporter' => 'Fikri', 'status' => 'Diproses'],
        ['id' => '#TC-003', 'device' => 'AC Ruangan', 'reporter' => 'Fikri', 'status' => 'Selesai'],
        ['id' => '#TC-004', 'device' => 'Laptop',     'reporter' => 'Fikri', 'status' => 'Pending'],
        ['id' => '#TC-005', 'device' => 'Hp',         'reporter' => 'Fikri', 'status' => 'Diproses'],
    ];

    $activities = [
        ['tone' => 'amber',   'icon' => 'clipboard', 'title' => 'Teknisi Haikal telah memulai menangani tiket #TC-104 (Laptop Thinkpad T14)', 'sub' => 'Notifikasi perkembangan pengerjaan perangkat anda', 'time' => '16 jam yang lalu'],
        ['tone' => 'emerald', 'icon' => 'doc',       'title' => 'Tiket #TC-098 (Printer Epson L3110) telah selesai diperbaiki',                'sub' => 'Perangkat siap diambil di ruang IT Support',         'time' => '2 jam yang lalu'],
        ['tone' => 'sky',     'icon' => 'clock',     'title' => 'Tiket #TC-105 (AC Ruangan 204) berhasil disubmit & menunggu verifikasi',     'sub' => 'Menunggu penetapan teknisi',                         'time' => '7 jam yang lalu'],
    ];

    // Halaman terkait (ganti dengan route kamu)
    $detailUrl  = url('/tiket/detail');
    $ticketsUrl = url('/tiket');

    // Gaya per tone / status
    $toneStyle = [
        'amber'   => 'bg-amber-50 text-amber-500 ring-amber-50/60',
        'emerald' => 'bg-emerald-50 text-emerald-500 ring-emerald-50/60',
        'sky'     => 'bg-sky-50 text-sky-500 ring-sky-50/60',
    ];

    // Path ikon (Heroicons outline)
    $ic = [
        'monitor'   => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'clock'     => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'cog'       => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z',
        'check'     => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'clipboard' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
        'doc'       => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'search'    => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'chevron'   => 'M9 5l7 7-7 7',
        'arrow'     => 'M14 5l7 7m0 0l-7 7m7-7H3',
        'inbox'     => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    $count = fn ($status) => collect($tickets)->where('status', $status)->count();

    // Kartu ringkasan: [label, jumlah, keterangan, ikon, warna ikon]
    $stats = [
        ['Total Laporan Saya', count($tickets),      'Total laporan dibuat',        'monitor', null],
        ['Tiket Pending',      $count('Pending'),    'Menunggu penanganan',         'clock',   'text-amber-500'],
        ['Sedang Diperbaiki',  $count('Diproses'),   'Dalam proses perbaikan',      'cog',     'text-rose-500'],
        ['Tiket Selesai',      $count('Selesai'),    'Perbaikan sudah selesai',     'check',   'text-emerald-500'],
    ];
@endphp

<div x-data="userDashboard(@js($tickets), @js($detailUrl))"
     @keydown.escape.window="sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="dashboard" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="$userName" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-7xl space-y-6">

                {{-- Sapaan --}}
                <section>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 md:text-3xl">Selamat Datang, {{ $userName }}</h1>
                    <p class="mt-1 text-sm text-slate-500">Pantau status perbaikan dan riwayat laporan anda</p>
                </section>

                {{-- Kartu ringkasan --}}
                <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($stats as $i => [$label, $total, $caption, $iconKey, $iconColor])
                        @php $dark = $i === 0; @endphp
                        <div class="flex flex-col justify-between rounded-xl p-5 shadow-sm transition-shadow hover:shadow-md {{ $dark ? 'bg-[#10254a] text-white' : 'border border-slate-100 bg-white text-slate-900' }}">
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-sm font-semibold {{ $dark ? 'text-slate-200' : 'text-slate-900' }}">{{ $label }}</span>
                                @if ($dark)
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-[#10254a]">{{ $icon($iconKey) }}</span>
                                @else
                                    <span class="{{ $iconColor }}">{{ $icon($iconKey, 'h-5 w-5') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <div class="mb-1 text-3xl font-bold tracking-tight md:text-4xl">{{ $total }}</div>
                                <p class="text-xs {{ $dark ? 'text-slate-300' : 'text-slate-500' }}">{{ $caption }}</p>
                            </div>
                        </div>
                    @endforeach
                </section>

                {{-- Pembaruan status terkini --}}
                <section class="rounded-xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col justify-between gap-2 border-b border-slate-100 pb-5 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Pembaruan Status Terkini</h2>
                            <p class="mt-0.5 text-xs text-slate-400">Notifikasi perkembangan pengerjaan perangkat anda</p>
                        </div>
                        <a href="{{ $ticketsUrl }}" class="group inline-flex items-center self-start text-xs font-medium text-slate-500 transition-colors hover:text-slate-800 sm:self-auto">
                            Lihat semua aktivitas
                            <span class="ml-1 transition-transform group-hover:translate-x-0.5">{{ $icon('chevron', 'h-3.5 w-3.5') }}</span>
                        </a>
                    </div>

                    <div class="divide-y divide-slate-50 pt-1">
                        @foreach ($activities as $activity)
                            <a href="{{ $detailUrl }}" class="flex items-start justify-between gap-4 rounded-lg px-2 py-4 transition-colors hover:bg-slate-50/70">
                                <div class="flex min-w-0 items-start gap-3.5">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full ring-4 {{ $toneStyle[$activity['tone']] }}">{{ $icon($activity['icon'], 'h-5 w-5') }}</span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold leading-snug text-slate-900">{{ $activity['title'] }}</span>
                                        <span class="mt-1 block text-[11px] text-slate-400">{{ $activity['sub'] }}</span>
                                    </span>
                                </div>
                                <span class="shrink-0 whitespace-nowrap pt-0.5 text-right text-[11px] text-slate-400">{{ $activity['time'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- Riwayat laporan tiket saya --}}
                <section class="space-y-5 rounded-xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                        <div>
                            <h2 class="text-base font-bold text-slate-900">Riwayat Laporan Tiket Saya</h2>
                            <p class="mt-0.5 text-xs text-slate-400">Menampilkan laporan kerusakan yang pernah anda buat.</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="relative w-full sm:w-64">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">{{ $icon('search') }}</span>
                                <input type="search" x-model.debounce.200ms="search" placeholder="Lakukan pencarian..."
                                       class="w-full rounded-lg border border-slate-200 py-2 pl-9 pr-3 text-xs text-slate-700 placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                            </div>
                            <select x-model="status" aria-label="Filter status"
                                    class="cursor-pointer rounded-lg border border-slate-200 bg-white py-2 pl-3 pr-8 text-xs font-medium text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                <option value="Semua">Semua Status</option>
                                <option>Pending</option>
                                <option>Diproses</option>
                                <option>Selesai</option>
                            </select>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg border border-slate-100">
                        <div x-show="filtered.length === 0" x-cloak class="flex flex-col items-center justify-center p-10 text-center">
                            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-6 w-6') }}</div>
                            <h3 class="text-sm font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
                            <p class="mt-1 text-xs text-slate-400">Coba ubah kata kunci atau status yang dipilih.</p>
                        </div>

                        <div x-show="filtered.length > 0" class="overflow-x-auto">
                            <table class="w-full min-w-[520px] border-collapse text-left text-xs">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50/70 font-semibold text-slate-800">
                                        <th scope="col" class="px-6 py-3">ID Tiket</th>
                                        <th scope="col" class="px-6 py-3">Perangkat</th>
                                        <th scope="col" class="px-6 py-3">Pelapor</th>
                                        <th scope="col" class="px-6 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                                    <template x-for="t in filtered" :key="t.id">
                                        <tr class="transition-colors hover:bg-slate-50/60">
                                            <td class="px-6 py-3.5">
                                                <a :href="detailUrl" x-text="t.id" class="rounded font-medium text-slate-900 transition-colors hover:text-blue-600 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40"></a>
                                            </td>
                                            <td class="px-6 py-3.5 text-slate-600" x-text="t.device"></td>
                                            <td class="px-6 py-3.5 text-slate-600" x-text="t.reporter"></td>
                                            <td class="px-6 py-3.5">
                                                <span class="inline-flex items-center font-semibold" :class="statusStyle[t.status].text">
                                                    <span class="mr-2 h-1.5 w-1.5 rounded-full" :class="statusStyle[t.status].dot"></span>
                                                    <span x-text="t.status"></span>
                                                </span>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex justify-end pt-1">
                        <a href="{{ $ticketsUrl }}" class="inline-flex items-center rounded-lg bg-[#10254a] px-4 py-2.5 text-xs font-semibold tracking-wide text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">
                            Lihat Semuanya
                            <span class="ml-2">{{ $icon('arrow', 'h-3.5 w-3.5') }}</span>
                        </a>
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- Pop up scan QR (dibuka dari tombol "Mulai Scan QR" di sidebar) --}}
    <x-qr-scan-modal />
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userDashboard', (tickets, detailUrl) => ({
            sidebarOpen: false,
            tickets,
            detailUrl,
            search: '',
            status: 'Semua',

            statusStyle: {
                Pending:  { text: 'text-red-500',     dot: 'bg-red-500' },
                Diproses: { text: 'text-amber-500',   dot: 'bg-amber-500' },
                Selesai:  { text: 'text-emerald-500', dot: 'bg-emerald-500' },
            },

            get filtered() {
                const q = this.search.trim().toLowerCase();
                return this.tickets.filter(t =>
                    (this.status === 'Semua' || t.status === this.status) &&
                    (!q || [t.id, t.device, t.reporter].some(v => (v || '').toLowerCase().includes(q)))
                );
            },
        }));
    });
</script>
@endsection