@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan perangkat milik user yang login, lengkap dengan riwayat tiketnya ($devices).
     * Kalau user hanya punya satu perangkat, pilihan perangkat di atas otomatis tidak tampil.
     */
    $devices = [
        [
            'id' => 'DEV-001', 'nama' => 'Laptop Acer', 'kategori' => 'Laptop', 'merek' => 'Acer', 'model' => null, 'serial' => null,
            'lokasi' => 'Lantai 6 - Ruang PPDP', 'departemen' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'pengadaan' => null,
            'kondisi' => 'Baik', 'penggunaan' => 'Sedang Digunakan',
            'tickets' => [
                ['judul' => 'Main Valorant Lag Cuma Dapet 20 FPS', 'tanggal' => '17 Oktober 2026', 'kode' => 'DV-2024-005', 'tipe' => 'Incident', 'status' => 'Selesai', 'teknisi' => 'Riski November',
                 'keluhan' => 'Saya main valorant cuma dapet 20 FPS padahal sudah rata kiri tapi tetep aja, saya jadi gabisa main dan botfrag coba dah di anu anukan saya gatau',
                 'perbaikan' => 'Menambah Ram dan di instal RTX 3050 via kabel lan sama prosessornya make mesin twin turbo V8 punya Porsche',
                 'dibuat' => '17 Oktober 2024', 'selesai' => '20 Oktober 2026'],
                ['judul' => 'Judul Masalah', 'tanggal' => '17 Oktober 2026', 'kode' => 'DV-2024-006', 'tipe' => 'Incident', 'status' => 'Diproses', 'teknisi' => 'Riski November',
                 'keluhan' => '-', 'perbaikan' => '-', 'dibuat' => '17 Oktober 2026', 'selesai' => '-'],
            ],
        ],
        [
            'id' => 'DEV-002', 'nama' => 'Monitor LG 24 Inch UltraGear', 'kategori' => 'Monitor', 'merek' => 'LG', 'model' => '24GN600', 'serial' => 'SN-8438291809281092',
            'lokasi' => 'Lantai 6 - Ruang PPDP', 'departemen' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'pengadaan' => '12 Oktober 2024',
            'kondisi' => 'Perlu Perbaikan', 'penggunaan' => 'Sedang Digunakan',
            'tickets' => [
                ['judul' => 'Layar berkedip saat kecerahan tinggi', 'tanggal' => '02 November 2026', 'kode' => 'DV-2024-009', 'tipe' => 'Problem', 'status' => 'Pending', 'teknisi' => null,
                 'keluhan' => 'Layar berkedip setiap kali kecerahan dinaikkan di atas 70 persen.', 'perbaikan' => '-', 'dibuat' => '02 November 2026', 'selesai' => '-'],
            ],
        ],
    ];

    // Kondisi & status penggunaan perangkat
    $conditionStyle = [
        'Baik'            => 'bg-green-200 text-green-700',
        'Perlu Perbaikan' => 'bg-amber-100 text-amber-700',
        'Rusak'           => 'bg-rose-100 text-rose-600',
    ];
    $usageStyle = [
        'Sedang Digunakan' => 'bg-blue-100 text-blue-700',
        'Tidak Digunakan'  => 'bg-slate-100 text-slate-600',
        'Dalam Perbaikan'  => 'bg-amber-100 text-amber-700',
    ];
    $ticketStatusStyle = [
        'Selesai'  => 'bg-green-200 text-green-700',
        'Diproses' => 'bg-amber-100 text-amber-700',
        'Pending'  => 'bg-rose-100 text-rose-600',
    ];

    // Tujuan tombol "Buat Laporan / Ticket" (halaman Buat Tiket)
    $createUrl = url('/tiket/buat');

    // Path ikon (Heroicons outline)
    $ic = [
        'chevron' => 'M5 15l7-7 7 7',
        'tag'     => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        'fire'    => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z',
        'user'    => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'check'   => 'M5 13l4 4L19 7',
        'monitor' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );
@endphp

<div x-data="{ sidebarOpen: false, current: @js($devices[0]['id'] ?? null) }"
     @keydown.escape.window="sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="perangkat" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-6xl space-y-5">

                @if (count($devices) === 0)
                    {{-- Belum punya perangkat --}}
                    <section class="rounded-3xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm">
                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('monitor', 'h-8 w-8') }}</div>
                        <h1 class="text-lg font-bold text-slate-900">Belum ada perangkat</h1>
                        <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Belum ada perangkat yang terdaftar atas nama Anda. Hubungi admin untuk mendaftarkan perangkat.</p>
                    </section>
                @else

                    {{-- Pilihan perangkat (hanya tampil kalau lebih dari satu) --}}
                    @if (count($devices) > 1)
                        <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="Pilih perangkat">
                            @foreach ($devices as $device)
                                <button type="button" role="tab" @click="current = '{{ $device['id'] }}'"
                                        :aria-selected="current === '{{ $device['id'] }}'"
                                        class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition-colors"
                                        :class="current === '{{ $device['id'] }}' ? 'border-[#10254a] bg-[#10254a] text-white' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'">
                                    {{ $icon('monitor') }}
                                    {{ $device['nama'] }}
                                    <span class="text-xs font-medium opacity-70">{{ $device['id'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    @foreach ($devices as $device)
                        @php
                            $rows = [
                                'Kode Perangkat'    => $device['id'],
                                'Nama Perangkat'    => $device['nama'],
                                'Kategori'          => $device['kategori'],
                                'Merek'             => $device['merek'],
                                'Model'             => $device['model'],
                                'Serial Number'     => $device['serial'],
                                'Lokasi'            => $device['lokasi'],
                                'Departemen'        => $device['departemen'],
                                'Tanggal Pengadaan' => $device['pengadaan'],
                            ];
                        @endphp

                        <section x-show="current === '{{ $device['id'] }}'" {!! $loop->first ? '' : 'x-cloak' !!}
                                 class="rounded-3xl border border-slate-200 bg-white px-5 py-8 shadow-sm sm:px-8 md:px-10 md:py-10">

                            {{-- Judul --}}
                            <div class="text-center">
                                <h1 class="text-3xl font-bold text-slate-900 md:text-4xl">{{ $device['nama'] }}</h1>
                                <p class="mt-2 text-base text-slate-500">{{ $device['id'] }} &middot; {{ $device['kategori'] }}</p>
                            </div>

                            {{-- Informasi perangkat --}}
                            <div class="mt-10 md:mt-12">
                                <h2 class="text-lg font-semibold text-slate-900">Informasi Perangkat</h2>
                                <div class="mt-5 text-sm md:text-base">
                                    <div class="grid grid-cols-[1fr_1.4fr] gap-4 border-b border-slate-300 pb-1.5 text-lg font-semibold text-red-700 md:grid-cols-2">
                                        <span>Detail</span><span>Informasi</span>
                                    </div>
                                    @foreach ($rows as $label => $value)
                                        <div class="grid grid-cols-[1fr_1.4fr] gap-4 border-b border-slate-300 py-3 md:grid-cols-2">
                                            <span class="text-slate-700">{{ $label }}</span>
                                            <span class="{{ $value ? 'text-slate-600' : 'text-slate-400' }}">{{ $value ?: 'Belum diisi' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Status perangkat --}}
                            <div class="mt-10">
                                <h2 class="text-lg font-semibold text-red-700">Status Perangkat</h2>
                                <div class="mt-5 space-y-4">
                                    <div class="flex items-center gap-4">
                                        <span class="shrink-0 text-slate-700">Kondisi Perangkat</span>
                                        <span class="flex-1 border-t border-dotted border-slate-300"></span>
                                        <span class="rounded-full px-5 py-1.5 text-sm font-semibold {{ $conditionStyle[$device['kondisi']] ?? 'bg-slate-100 text-slate-600' }}">{{ $device['kondisi'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="shrink-0 text-slate-700">Status Penggunaan</span>
                                        <span class="flex-1 border-t border-dotted border-slate-300"></span>
                                        <span class="rounded-full px-5 py-1.5 text-sm font-semibold {{ $usageStyle[$device['penggunaan']] ?? 'bg-slate-100 text-slate-600' }}">{{ $device['penggunaan'] }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Riwayat perbaikan / ticket --}}
                            <div class="mt-10">
                                <h2 class="text-lg font-semibold text-red-700">Riwayat Perbaikan / Ticket</h2>

                                <div class="mt-5 space-y-5">
                                    @forelse ($device['tickets'] as $ticket)
                                        <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="overflow-hidden rounded-lg shadow-sm">
                                            <button type="button" @click="open = !open" :aria-expanded="open"
                                                    class="flex w-full items-center justify-between gap-3 bg-[#e5e9f2] px-4 py-4 text-left sm:px-6">
                                                <span class="min-w-0 flex-1 truncate text-base font-semibold text-slate-900 md:text-lg">{{ $ticket['judul'] }}</span>
                                                <span class="hidden shrink-0 text-base font-semibold text-slate-900 sm:block md:text-lg">{{ $ticket['tanggal'] }}</span>
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-[#10254a] text-white">
                                                    <svg class="h-4 w-4 transition-transform" :class="open ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $ic['chevron'] }}"/></svg>
                                                </span>
                                            </button>

                                            <div x-show="open" x-cloak x-transition.opacity class="border-x border-b border-slate-100 bg-white px-4 pb-4 pt-5 sm:px-6">
                                                <p class="mb-3 text-sm font-semibold text-slate-900 sm:hidden">{{ $ticket['tanggal'] }}</p>

                                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1.4fr_1.4fr]">
                                                    <div class="space-y-6">
                                                        <div>
                                                            <p class="text-xs text-slate-500">Kode Ticket</p>
                                                            <p class="mt-1 flex items-center gap-1.5 text-base font-medium text-slate-900">{{ $icon('tag', 'h-4 w-4 text-slate-600') }} {{ $ticket['kode'] }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Status :</p>
                                                            <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-semibold {{ $ticketStatusStyle[$ticket['status']] ?? 'bg-slate-100 text-slate-600' }}">
                                                                {{ $icon('check', 'h-3.5 w-3.5') }} {{ $ticket['status'] }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-6">
                                                        <div>
                                                            <p class="text-xs text-slate-500">Type Kerusakan</p>
                                                            <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800">
                                                                {{ $icon('fire', 'h-3.5 w-3.5') }} {{ $ticket['tipe'] }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Di Tanggapi oleh :</p>
                                                            <span class="mt-1.5 inline-flex items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-800">
                                                                {{ $icon('user', 'h-3.5 w-3.5') }} {{ $ticket['teknisi'] ?? 'Belum ditugaskan' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <p class="text-xs text-slate-500">Keluhan :</p>
                                                        <p class="mt-1.5 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-sm leading-snug text-slate-800">{{ $ticket['keluhan'] }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Perbaikan :</p>
                                                        <p class="mt-1.5 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-sm leading-snug text-slate-800">{{ $ticket['perbaikan'] }}</p>
                                                    </div>
                                                </div>

                                                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-3 text-[11px] text-slate-500">
                                                    <span>{{ $ticket['dibuat'] }}</span>
                                                    <span>Berakhir di {{ $ticket['selesai'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="rounded-lg bg-slate-50 p-6 text-center text-sm text-slate-500">Belum ada riwayat perbaikan untuk perangkat ini.</p>
                                    @endforelse
                                </div>
                            </div>
                        </section>
                    @endforeach

                    {{-- Tombol buat laporan --}}
                    <a href="{{ $createUrl }}"
                       class="flex h-14 w-full items-center justify-center rounded-full bg-[#10254a] text-base font-bold text-white transition-colors hover:bg-[#0b1b3a] sm:h-16 sm:text-lg">
                        Buat Laporan / Ticket
                    </a>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection