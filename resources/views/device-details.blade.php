@extends('layouts.index')

@section('content')
@php
    // Memetakan rincian detail dari variabel $deviceData yang dikirim controller
    $details = [
        'Kode Perangkat'   => $deviceData['kode'] ?? '-',
        'Nama Perangkat'   => $deviceData['nama'] ?? '-',
        'Kategori'         => $deviceData['jenis'] ?? '-',
        'Merek'            => $deviceData['merek'] ?? 'Belum diisi',
        'Model'            => $deviceData['model'] ?? 'Belum diisi',
        'Serial Number'    => $deviceData['sn'] ?? 'Belum diisi',
        'Lokasi'           => $deviceData['lokasi'] ?? '-',
        'Operator Device'  => $deviceData['pj'] ?? 'Belum diisi',
        'Departemen'       => $deviceData['departemen_pj'] ?? 'Belum diisi',
        'Tanggal Pengadaan'=> $deviceData['tanggal'] ?? 'Belum diisi',
    ];

    $tickets = $deviceData['tickets'] ?? [];

    // Warna badge status ticket
    $ticketStatus = [
        'Selesai'   => 'bg-green-200 text-green-700',
        'Diproses'  => 'bg-amber-100 text-amber-700',
        'Menunggu'  => 'bg-slate-200 text-slate-600',
        'Completed' => 'bg-green-200 text-green-700',
        'Process'   => 'bg-amber-100 text-amber-700',
        'Open'      => 'bg-slate-200 text-slate-600',
    ];
@endphp

<div x-data="{ openTicket: null }" class="min-h-screen bg-[#fafafa] text-slate-800">

    {{-- Halaman publik scan QR (tanpa sidebar) --}}
    <x-navbar :with-sidebar="false" guest />

    <main class="mx-auto w-full max-w-6xl p-4 md:p-6">

        {{-- ============ KARTU DETAIL ============ --}}
        <section class="rounded-3xl border border-slate-100 bg-white px-5 py-8 shadow-sm sm:px-8 lg:px-10">

            {{-- Judul & QR Code Singkat --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 border-b border-slate-100 pb-8">
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">{{ $deviceData['nama'] }}</h1>
                    <p class="mt-2 text-sm text-slate-500 sm:text-base">
                        <span class="font-semibold text-slate-700">{{ $deviceData['kode'] }}</span> &middot; {{ $deviceData['jenis'] }}
                    </p>
                    <span class="mt-3 inline-block rounded-full px-3.5 py-1 text-xs font-semibold 
                        {{ $deviceData['status'] === 'aktif' ? 'bg-emerald-100 text-emerald-700' : ($deviceData['status'] === 'perbaikan' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                        Status: {{ ucfirst($deviceData['status']) }}
                    </span>
                </div>

                {{-- QR Code Card --}}
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-center shrink-0">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data={{ urlencode($deviceData['qr_url']) }}" alt="QR Code" class="w-24 h-24 mx-auto">
                    <span class="text-[10px] text-slate-400 mt-1 block font-mono">Scan for info</span>
                </div>
            </div>

            {{-- Informasi Perangkat --}}
            <h2 class="mb-4 mt-8 text-base font-semibold text-slate-900">Informasi Perangkat</h2>

            <div>
                <div class="grid grid-cols-2 gap-4 border-b border-slate-300 pb-1.5">
                    <p class="text-base font-semibold text-red-700">Detail</p>
                    <p class="text-base font-semibold text-red-700">Informasi</p>
                </div>
                @foreach ($details as $label => $value)
                    <div class="grid grid-cols-2 gap-4 border-b border-slate-200 py-2.5 text-sm text-slate-600">
                        <p>{{ $label }}</p>
                        <p class="{{ $value && $value !== 'Belum diisi' && $value !== '-' ? 'font-medium text-slate-800' : 'text-slate-400' }}">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Status Perangkat --}}
            <h2 class="mb-4 mt-10 text-base font-semibold text-red-700">Status Perangkat</h2>
            <div class="space-y-4 text-sm text-slate-600">
                <div class="flex items-center gap-4">
                    <span class="shrink-0">Kondisi Perangkat</span>
                    <span class="flex-1 border-b border-dotted border-slate-300"></span>
                    <span class="rounded-full px-5 py-1.5 text-sm font-semibold 
                        {{ $deviceData['status'] === 'aktif' ? 'bg-green-200 text-green-700' : ($deviceData['status'] === 'perbaikan' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                        {{ $deviceData['status'] === 'aktif' ? 'Baik' : ucfirst($deviceData['status']) }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="shrink-0">Status Penggunaan</span>
                    <span class="flex-1 border-b border-dotted border-slate-300"></span>
                    <span class="rounded-full bg-blue-100 px-5 py-1.5 text-sm font-semibold text-blue-700">Sedang Digunakan</span>
                </div>
            </div>

            {{-- Riwayat Perbaikan / Ticket --}}
            <h2 class="mb-4 mt-10 text-base font-semibold text-red-700">Riwayat Perbaikan / Ticket</h2>

            <div class="space-y-4">
                @forelse ($tickets as $i => $t)
                    <div class="overflow-hidden rounded-lg shadow-sm border border-slate-200">

                        {{-- Header accordion --}}
                        <button type="button" @click="openTicket = openTicket === {{ $i }} ? null : {{ $i }}"
                                class="flex w-full items-center justify-between gap-3 bg-[#e5e9f2] px-4 py-4 text-left sm:px-6"
                                :aria-expanded="openTicket === {{ $i }}">
                            <span class="min-w-0 truncate text-sm font-semibold text-slate-900 sm:text-base">{{ $t['subjek'] ?? 'Keluhan Perangkat' }}</span>
                            <span class="flex shrink-0 items-center gap-3 sm:gap-5">
                                <span class="text-sm font-semibold text-slate-800 sm:text-base">{{ $t['tanggal'] ?? '-' }}</span>
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
                                            {{ $t['status'] }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Kolom 2: urgensi & teknisi --}}
                                <div class="flex flex-col justify-between gap-5">
                                    <div>
                                        <p class="text-xs text-slate-500">Urgensi</p>
                                        <span class="mt-2 inline-flex items-center gap-1.5 rounded-md bg-[#e5e9f2] px-3 py-1.5 text-xs font-semibold text-slate-800">
                                            {{ $t['urgensi'] ?? 'Normal' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Ditanggapi oleh :</p>
                                        <span class="mt-2 inline-flex items-center gap-1.5 rounded-md bg-[#e5e9f2] px-3 py-1.5 text-xs font-semibold text-slate-800">
                                            {{ $t['teknisi'] ?? 'Belum ditanggapi' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Kolom 3: deskripsi / keluhan --}}
                                <div>
                                    <p class="text-xs text-slate-500">Keluhan :</p>
                                    <div class="mt-2 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-xs leading-relaxed text-slate-800">
                                        {{ $t['subjek'] ?? '-' }}
                                    </div>
                                </div>

                                {{-- Kolom 4: perbaikan --}}
                                <div>
                                    <p class="text-xs text-slate-500">Perbaikan / Catatan :</p>
                                    <div class="mt-2 min-h-[7rem] rounded-lg bg-[#e5e9f2] p-3 text-xs leading-relaxed text-slate-800">
                                        {{ $t['catatan'] ?? 'Belum ada catatan perbaikan.' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl">
                        Belum ada riwayat tiket atau perbaikan untuk perangkat ini.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Tombol buat laporan --}}
        <a href="{{ route('tickets.create') }}" class="mb-4 mt-6 flex h-14 w-full items-center justify-center rounded-full bg-[#10254a] text-base font-bold text-white transition-colors hover:bg-[#0b1b3a] sm:h-16 shadow-md">
            Buat Laporan / Ticket Kerusakan
        </a>
    </main>
</div>
@endsection
