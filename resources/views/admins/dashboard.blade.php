@extends('layouts.index')

@section('content')
@php
    $adminName = $adminName ?? 'Admin';

    // Path ikon (Heroicons outline)
    $ic = [
        'monitor' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'users'   => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        'ticket'  => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
        'clock'   => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'wrench'  => 'M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z',
        'plus'    => 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z',
        'userAdd' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',
        'arrow'   => 'M14 5l7 7m0 0l-7 7m7-7H3',
        'eye'     => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
    ];

    // Kartu statistik dari Database
    $stats = [
        ['Total Perangkat',   $totalPerangkat ?? 0, 'Seluruh perangkat terdaftar', 'monitor'],
        ['Total User',        $totalUser ?? 0, 'Jumlah user terdaftar',       'users'],
        ['Total Tiket',       $totalTiket ?? 0, 'Seluruh tiket masuk',         'ticket'],
        ['Tiket Pending',     $tiketPending ?? 0, 'Tiket belum ditangani',       'clock'],
        ['Sedang Diperbaiki', $tiketProses ?? 0, 'Tiket dalam proses perbaikan','wrench'],
    ];

    // Donut kondisi perangkat dari Database
    $kondisi = [
        ['label' => 'Baik',      'value' => $kondisiBaik ?? 0, 'color' => '#e6edf5'],
        ['label' => 'Perbaikan', 'value' => $kondisiPerbaikan ?? 0, 'color' => '#66779b'],
        ['label' => 'Rusak',     'value' => $kondisiRusak ?? 0, 'color' => '#10254a'],
    ];
    $kondisiTotal = collect($kondisi)->sum('value');
    $circ = 2 * pi() * 40;

    // Statistik Tiket per Bulan (Contoh mapping dinamis/fallback)
    $chartMax = 350;
    $chart = [
        ['Jan', 40, 20], ['Feb', 50, 30], ['Mar', 60, 45],
        ['Apr', 80, 60], ['Mei', 90, 75], ['Jun', 120, 100],
    ];

    $akses = [
        ['Tambah Device', 'Daftarkan perangkat baru', 'plus',    route('admin.device.index')],
        ['Tambah User',   'Buat akun pengguna baru',   'userAdd', route('admin.users.index')],
        ['Kelola Ticket', 'Periksa laporan kerusakan', 'ticket',  route('admin.tickets.index')],
    ];

    // Warna status tiket
    $statusDot = [
        'pending'  => ['text-red-600',    'bg-red-500'],
        'diproses' => ['text-yellow-500', 'bg-yellow-400'],
        'selesai'  => ['text-green-600',  'bg-green-500'],
    ];

    $statusPill = [
        'selesai'  => 'bg-green-200 text-green-800',
        'diproses' => 'bg-yellow-300 text-yellow-900',
        'pending'  => 'bg-rose-400 text-white',
    ];

    $nf = fn ($n) => number_format($n, 0, ',', '.');
@endphp

<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false"
     class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar admin --}}
    <x-sidebar role="admin" active="dashboard" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul --}}
            <div class="mb-5">
                <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Selamat Datang, {{ $adminName }}</h1>
                <p class="mt-1 text-sm text-slate-600 md:text-base">Pantau dan kelola seluruh aktivitas perangkat serta penanganan kerusakan</p>
            </div>

            {{-- ============ KARTU STATISTIK ============ --}}
            <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                @foreach ($stats as $i => [$label, $count, $caption, $icon])
                    @php $dark = $i === 0; @endphp
                    <div class="rounded-lg p-4 shadow-sm {{ $dark ? 'bg-[#0b1b3a] text-white' : 'border border-slate-100 bg-white text-slate-900' }}">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm {{ $dark ? 'text-slate-100' : 'text-slate-600' }}">{{ $label }}</p>
                                <h2 class="mt-1 text-2xl font-bold">{{ $nf($count) }}</h2>
                            </div>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md {{ $dark ? 'bg-white text-[#0b1b3a]' : 'bg-slate-100 text-slate-600' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic[$icon] }}"/></svg>
                            </span>
                        </div>
                        <p class="mt-3 text-[11px] {{ $dark ? 'text-slate-200' : 'text-slate-500' }}">{{ $caption }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ============ GRAFIK & AKSES CEPAT ============ --}}
            <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">

                {{-- Kondisi Perangkat (donut) --}}
                <section class="rounded-lg bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="text-base font-semibold text-slate-900">Kondisi Perangkat</h2>
                    </div>

                    <div class="mt-3 flex justify-center">
                        <svg viewBox="0 0 100 100" class="h-40 w-40" role="img" aria-label="Diagram kondisi perangkat">
                            @php $acc = 0; @endphp
                            @if($kondisiTotal > 0)
                                @foreach ($kondisi as $k)
                                    @php $len = $k['value'] / $kondisiTotal * $circ; @endphp
                                    <circle cx="50" cy="50" r="40" fill="none" stroke="{{ $k['color'] }}" stroke-width="14"
                                            stroke-dasharray="{{ round($len, 2) }} {{ round($circ - $len, 2) }}"
                                            stroke-dashoffset="{{ round(-$acc, 2) }}"
                                            transform="rotate(-90 50 50)"/>
                                    @php $acc += $len; @endphp
                                @endforeach
                            @else
                                <circle cx="50" cy="50" r="40" fill="none" stroke="#e2e8f0" stroke-width="14"/>
                            @endif
                            <text x="50" y="52" text-anchor="middle" font-size="11" font-weight="700" fill="#0f172a">{{ $nf($kondisiTotal) }}</text>
                            <text x="50" y="62" text-anchor="middle" font-size="5" fill="#64748b">Total perangkat</text>
                        </svg>
                    </div>

                    <div class="mt-3 flex items-start justify-between gap-2">
                        @foreach ($kondisi as $k)
                            <div class="text-xs text-slate-500">
                                <div class="flex items-center gap-1.5">
                                    <span class="h-3 w-3 rounded-full border border-slate-200" style="background: {{ $k['color'] }}"></span>
                                    {{ $k['label'] }}
                                </div>
                                <p class="mt-1 pl-[18px] text-sm font-semibold text-slate-900">{{ $nf($k['value']) }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- Statistik Tiket (bar) --}}
                <section class="rounded-lg bg-white p-5 shadow-sm">
                    <h2 class="text-base font-semibold text-slate-900">Statistik Tiket Bulanan</h2>
                    <div class="mt-4 flex gap-3">
                        <div class="flex h-44 flex-col justify-between text-[11px] leading-none text-slate-600">
                            @foreach ([150, 120, 90, 60, 30, 0] as $y)
                                <span class="text-right">{{ $y }}</span>
                            @endforeach
                        </div>
                        <div class="flex-1">
                            <div class="flex h-44 items-end justify-between border-b border-slate-100 px-1">
                                @foreach ($chart as [$bulan, $total, $selesai])
                                    <div class="relative h-full w-5" title="{{ $bulan }}: {{ $selesai }} dari {{ $total }} tiket">
                                        <div class="absolute bottom-0 w-full rounded-sm bg-slate-100" style="height: {{ ($total / 150) * 100 }}%"></div>
                                        <div class="absolute bottom-0 left-1/2 w-2.5 -translate-x-1/2 rounded-sm bg-[#10254a]" style="height: {{ ($selesai / 150) * 100 }}%"></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-2 flex justify-between px-1 text-xs text-slate-700">
                                @foreach ($chart as [$bulan])
                                    <span class="w-5 text-center">{{ $bulan }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Akses Cepat --}}
                <section class="rounded-lg bg-white p-5 shadow-sm">
                    <h2 class="text-base font-semibold text-slate-900">Akses Cepat</h2>
                    <p class="mt-0.5 text-[11px] text-slate-500">Akses cepat ke fitur utama pengelolaan sistem.</p>
                    <div class="mt-4 space-y-2.5">
                        @foreach ($akses as [$judul, $desc, $icon, $href])
                            <a href="{{ $href }}" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2.5 transition-colors hover:bg-slate-50">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-[#10254a] text-white">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic[$icon] }}"/></svg>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-xs font-semibold text-slate-900">{{ $judul }}</span>
                                    <span class="block truncate text-[11px] text-slate-500">{{ $desc }}</span>
                                </span>
                                <svg class="h-4 w-4 shrink-0 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic['arrow'] }}"/></svg>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>

            {{-- ============ TIKET TERBARU ============ --}}
            <section class="mb-6 rounded-lg bg-white p-4 shadow-sm sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Tiket Terbaru</h2>
                        <p class="mt-1 text-sm text-slate-500">Menampilkan laporan kerusakan yang baru masuk.</p>
                    </div>
                </div>

                <div class="mt-5 overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full min-w-[560px] text-left text-sm">
                        <thead class="bg-[#f1f5f9] text-base text-slate-900">
                            <tr>
                                <th class="px-6 py-3.5 font-medium">ID Tiket</th>
                                <th class="px-6 py-3.5 font-medium">Perangkat</th>
                                <th class="px-6 py-3.5 font-medium">Pelapor</th>
                                <th class="px-6 py-3.5 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-800">
                            @forelse ($tiketBaru ?? [] as $t)
                                @php $st = strtolower($t->status); @endphp
                                <tr class="border-t border-slate-200">
                                    <td class="px-6 py-4 font-mono font-semibold">{{ $t->kode_ticket ?? '#TC-00'.$t->id }}</td>
                                    <td class="px-6 py-4">{{ $t->device->nama_device ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $t->user->nama ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 text-base font-medium {{ $statusDot[$st][0] ?? 'text-slate-600' }}">
                                            <span class="h-2 w-2 rounded-full {{ $statusDot[$st][1] ?? 'bg-slate-400' }}"></span>{{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada tiket masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#0b1b3a]">
                        Lihat Semuanya
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $ic['arrow'] }}"/></svg>
                    </a>
                </div>
            </section>

            {{-- ============ RIWAYAT KERUSAKAN ============ --}}
            <section class="rounded-lg bg-white p-4 shadow-sm sm:p-6">
                <h2 class="text-xl font-semibold text-slate-900">Riwayat Kerusakan</h2>
                <p class="mt-1 text-sm text-slate-500">Daftar laporan kerusakan perangkat terbaru dalam sistem</p>

                <div class="mt-5 overflow-x-auto rounded-lg border border-slate-200">
                    <table class="w-full min-w-[820px] text-left text-sm">
                        <thead class="bg-[#f1f5f9] text-base text-slate-900">
                            <tr>
                                <th class="px-5 py-3.5 font-medium">No</th>
                                <th class="px-5 py-3.5 font-medium">ID Tiket</th>
                                <th class="px-5 py-3.5 font-medium">Tanggal Laporan</th>
                                <th class="px-5 py-3.5 font-medium">Perangkat</th>
                                <th class="px-5 py-3.5 font-medium">Subjek</th>
                                <th class="px-5 py-3.5 text-center font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-800">
                            @forelse ($riwayat ?? [] as $n => $r)
                                @php $st = strtolower($r->status); @endphp
                                <tr class="border-t border-slate-200">
                                    <td class="px-5 py-4">{{ $n + 1 }}</td>
                                    <td class="px-5 py-4 font-mono font-semibold text-blue-600">{{ $r->kode_ticket ?? '#TC-00'.$r->id }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">{{ $r->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $r->device->nama_device ?? '-' }}</td>
                                    <td class="px-5 py-4">{{ $r->judul ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-block min-w-[6.5rem] rounded-md px-3 py-2 text-xs font-semibold {{ $statusPill[$st] ?? 'bg-slate-200 text-slate-700' }}">{{ ucfirst($r->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-400">Belum ada riwayat kerusakan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>
</div>
@endsection