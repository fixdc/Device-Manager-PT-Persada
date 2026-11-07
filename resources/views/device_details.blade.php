@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data dari controller, mis: $device dan $device->tickets
     */
    $device = [
        'kode'          => 'DEV-001',
        'nama'          => 'Laptop Acer',
        'kategori'      => 'Laptop',
        'merek'         => 'Acer',
        'model'         => '',
        'serial'        => '',
        'lokasi'        => 'Lantai 6',
        'operator'      => 'Budi Santoso',
        'departemen'    => 'POKJA - Perencanaan Pengembangan dan Pengaduan',
        'tgl_pengadaan' => '',
        'kondisi'       => 'Baik',
        'penggunaan'    => 'Sedang Digunakan',
    ];

    $tickets = [
        [
            'judul'    => 'Main Valorant Lag Cuma Dapet 20 FPS',
            'tanggal'  => '17 Oktober 2026',
            'kode'     => 'DV-2024-005',
            'type'     => 'Incident',
            'status'   => 'Selesai',
            'ditangani'=> 'Riski November',
            'keluhan'  => 'Saya main valorant cuma dapet 20 FPS padahal sudah rata kiri tapi tetep aja, saya jadi gabisa main dan botfrag coba dah di anu anukan saya gatau',
            'perbaikan'=> 'Menambah Ram dan di instal RTX 3050 via kabel lan sama prosessornya make mesin twin turbo V8 punya Porsche',
            'dibuat'   => '17 Oktober 2024',
            'selesai'  => '20 Oktober 2026',
        ],
        [
            'judul'    => 'Judul Masalah',
            'tanggal'  => '17 Oktober 2026',
            'kode'     => 'DV-2024-006',
            'type'     => 'Incident',
            'status'   => 'Diproses',
            'ditangani'=> '',
            'keluhan'  => '',
            'perbaikan'=> '',
            'dibuat'   => '17 Oktober 2026',
            'selesai'  => '',
        ],
    ];

    $details = [
        'Kode Perangkat'   => $device['kode'],
        'Nama Perangkat'   => $device['nama'],
        'Kategori'         => $device['kategori'],
        'Merek'            => $device['merek'],
        'Model'            => $device['model'],
        'Serial Number'    => $device['serial'],
        'Lokasi'           => $device['lokasi'],
        'Operator Device'  => $device['operator'],
        'Departemen'       => $device['departemen'],
        'Tanggal Pengadaan'=> $device['tgl_pengadaan'],
    ];

    // Warna badge status ticket
    $ticketStatus = [
        'Selesai'  => 'bg-green-200 text-green-700',
        'Diproses' => 'bg-amber-100 text-amber-700',
        'Menunggu' => 'bg-slate-200 text-slate-600',
    ];
@endphp

<div x-data="{ openTicket: 0 }" class="min-h-screen bg-[#fafafa] text-slate-800">

    {{-- Halaman ini tanpa sidebar: navbar menampilkan logo + tombol Login --}}
    <x-navbar :with-sidebar="false" guest />

    <main class="mx-auto w-full max-w-6xl p-4 md:p-6">

            {{-- ============ KARTU DETAIL ============ --}}
            <section class="rounded-3xl border border-slate-100 bg-white px-5 py-8 shadow-sm sm:px-8 lg:px-10">

                {{-- Judul --}}
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">{{ $device['nama'] }}</h1>
                    <p class="mt-2 text-sm text-slate-500 sm:text-base">{{ $device['kode'] }} &middot; {{ $device['kategori'] }}</p>
                </div>

                {{-- Informasi Perangkat --}}
                <h2 class="mb-4 mt-10 text-base font-semibold text-slate-900 sm:mt-12">Informasi Perangkat</h2>

                <div>
                    <div class="grid grid-cols-2 gap-4 border-b border-slate-300 pb-1.5">
                        <p class="text-base font-semibold text-red-700">Detail</p>
                        <p class="text-base font-semibold text-red-700">Informasi</p>
                    </div>
                    @foreach ($details as $label => $value)
                        <div class="grid grid-cols-2 gap-4 border-b border-slate-200 py-2.5 text-sm text-slate-600">
                            <p>{{ $label }}</p>
                            <p class="{{ $value ? '' : 'text-slate-500' }}">{{ $value ?: 'Belum diisi' }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Status Perangkat --}}
                <h2 class="mb-4 mt-10 text-base font-semibold text-red-700">Status Perangkat</h2>
                <div class="space-y-4 text-sm text-slate-600">
                    <div class="flex items-center gap-4">
                        <span class="shrink-0">Kondisi Perangkat</span>
                        <span class="flex-1 border-b border-dotted border-slate-300"></span>
                        <span class="rounded-full bg-green-200 px-5 py-1.5 text-sm font-semibold text-green-700">{{ $device['kondisi'] }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="shrink-0">Status Penggunaan</span>
                        <span class="flex-1 border-b border-dotted border-slate-300"></span>
                        <span class="rounded-full bg-blue-100 px-5 py-1.5 text-sm font-semibold text-blue-700">{{ $device['penggunaan'] }}</span>
                    </div>
                </div>

                {{-- Riwayat Perbaikan / Ticket --}}
                <h2 class="mb-4 mt-10 text-base font-semibold text-red-700">Riwayat Perbaikan / Ticket</h2>

                <div class="space-y-4">
                    @foreach ($tickets as $i => $t)
                        <div class="overflow-hidden rounded-lg shadow-sm">

                            {{-- Header accordion --}}
                            <button type="button" @click="openTicket = openTicket === {{ $i }} ? null : {{ $i }}"
                                    class="flex w-full items-center justify-between gap-3 bg-[#e5e9f2] px-4 py-4 text-left sm:px-6"
                                    :aria-expanded="openTicket === {{ $i }}">
                                <span class="min-w-0 truncate text-sm font-semibold text-slate-900 sm:text-base">{{ $t['judul'] }}</span>
                                <span class="flex shrink-0 items-center gap-3 sm:gap-5">
                                    <span class="text-sm font-semibold text-slate-800 sm:text-base">{{ $t['tanggal'] }}</span>
                                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-[#10254a] text-white">
                                        <svg class="h-4 w-4 transition-transform duration-200" :class="openTicket === {{ $i }} ? '' : 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                                    </span>
                                </span>
                            </button>

                            {{-- Isi accordion --}}
                            <div x-show="openTicket === {{ $i }}" x-cloak x-transition.opacity.duration.200ms class="bg-white px-4 pb-4 pt-4 sm:px-6">
                                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-[1fr_1fr_1.4fr_1.4fr]">

                                    {{-- Kolom 1: kode & status --}}
                                    <div class="flex flex-col justify-between gap-5">
                                        <div>
                                            <p class="text-xs text-slate-500">Kode Ticket</p>
                                            <p class="mt-1 flex items-center gap-1.5 text-base font-medium text-slate-900">
                                                <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                                {{ $t['kode'] }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Status :</p>
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-md px-3 py-1.5 text-xs font-semibold {{ $ticketStatus[$t['status']] ?? 'bg-slate-200 text-slate-600' }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                                                {{ $t['status'] }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Kolom 2: type & ditanggapi --}}
                                    <div class="flex flex-col justify-between gap-5">
                                        <div>
                                            <p class="text-xs text-slate-500">Type Kerusakan</p>
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-md bg-[#e5e9f2] px-3 py-1.5 text-xs font-semibold text-slate-800">
                                                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2s5 4.5 5 10a5 5 0 01-10 0c0-2 1-3.5 2-4.5 0 2 1 3 2 3 0-3-1-5 1-8.5z"/></svg>
                                                {{ $t['type'] }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Di Tanggapi oleh :</p>
                                            <span class="mt-2 inline-flex items-center gap-1.5 rounded-md bg-[#e5e9f2] px-3 py-1.5 text-xs font-semibold text-slate-800">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                                                {{ $t['ditangani'] ?: 'Belum ditanggapi' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Kolom 3: keluhan --}}
                                    <div>
                                        <p class="text-xs text-slate-500">Keluhan :</p>
                                        <div class="mt-2 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-xs leading-relaxed text-slate-800">
                                            {{ $t['keluhan'] ?: '-' }}
                                        </div>
                                    </div>

                                    {{-- Kolom 4: perbaikan --}}
                                    <div>
                                        <p class="text-xs text-slate-500">Perbaikan :</p>
                                        <div class="mt-2 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-xs leading-relaxed text-slate-800">
                                            {{ $t['perbaikan'] ?: '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 pt-3 text-[11px] text-slate-500">
                                    <span>{{ $t['dibuat'] }}</span>
                                    @if ($t['selesai'])
                                        <span>Berakhir di {{ $t['selesai'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Tombol buat laporan --}}
            <a href="#" class="mb-4 mt-6 flex h-14 w-full items-center justify-center rounded-full bg-[#10254a] text-base font-bold text-white transition-colors hover:bg-[#0b1b3a] sm:h-16">
                Buat Laporan / Ticket
            </a>
    </main>
</div>
@endsection