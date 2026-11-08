@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data dari controller ($ticket).
     */
    $ticket = [
        'id'            => 'TC-024',
        'code'          => '#TC-024',
        'publicId'      => 'PTAMS-TC-024',
        'qrUrl'         => 'https://p-tams.internal/tickets/public/PTAMS-TC-024',
        'category'      => 'Hardware / Komputer / Laptop',
        'reportedAt'    => '12 Oktober 2026, 10:00 WIB',
        'status'        => 'in_progress',       // in_progress | pending_parts | completed | cancelled
        'notes'         => '',
        'priorityLabel' => 'Tinggi (Urgent)',
        'priorityLevel' => 'Level 1 – Urgent',
        'stage'         => ['current' => 3, 'total' => 4, 'name' => 'Perbaikan Fisik', 'estimate' => '~2 jam'],
        'device' => [
            'name'           => 'Laptop Acer',
            'serial'         => 'ACR-Aspire-7729X',
            'category'       => 'Hardware',
            'location'       => 'Ruang Meeting A',
            'locationDetail' => 'Gedung utama lantai 3 – operasional',
        ],
        'reporter' => ['name' => 'Budi Pratama', 'division' => 'Bendahara', 'nip' => '1999999999'],
        'description' => 'Laptop sering mati sendiri saat dipakai lebih dari 30 menit dan layarnya berkedip sebelum mati. Sudah dicoba dicolok ke charger dan restart, tetapi masalahnya muncul lagi. Laptop ini dipakai untuk rapat dan presentasi, jadi mohon ditangani secepatnya.',
        'attachment'    => ['name' => 'Lampiran Berkas Pendukung', 'size' => '2.4 MB', 'url' => '#'],
    ];

    // Path ikon (Heroicons outline)
    $ic = [
        'back'     => 'M19 12H5m7-7l-7 7 7 7',
        'ticket'   => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
        'monitor'  => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'info'     => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'clip'     => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
        'doc'      => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'download' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4',
        'eye'      => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'photo'    => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
        'copy'     => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z',
        'chevron'  => 'M19 9l-7 7-7-7',
        'close'    => 'M6 18L18 6M6 6l12 12',
        'warning'  => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    $card = 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6';
@endphp

<div x-data="ticketDetail(@js(['status' => $ticket['status'], 'notes' => $ticket['notes'], 'qrUrl' => $ticket['qrUrl'], 'code' => $ticket['code']]))"
     @keydown.escape.window="modal = null; sidebarOpen = false"
     class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar admin --}}
    <x-sidebar role="admin" active="ticket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-[1400px] space-y-6">

                {{-- Tombol kembali --}}
                <div>
                    <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-[#10254a] px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">
                        {{ $icon('back', 'h-3.5 w-3.5') }}
                        Daftar Tiket
                    </a>
                </div>

                {{-- Judul + status & prioritas --}}
                <section class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-[#10254a] sm:text-2xl lg:text-3xl">Detail Laporan Kerusakan &amp; Monitoring Servis</h1>
                        <p class="mt-1 max-w-2xl text-xs leading-relaxed text-slate-500 sm:text-sm">Lacak tahapan perbaikan, verifikasi suku cadang, dan perbaruan teknisi langsung dari sistem pusat</p>
                    </div>

                    <div class="flex shrink-0 flex-wrap items-center gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Status Saat Ini</div>
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold" :class="statuses[saved.status].text">
                                <span class="inline-block h-2 w-2 rounded-full" :class="statuses[saved.status].dot"></span>
                                <span x-text="statuses[saved.status].label"></span>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Prioritas</div>
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold text-rose-600">
                                <span class="inline-block h-2 w-2 rounded-full bg-rose-600"></span>
                                {{ $ticket['priorityLabel'] }}
                            </div>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

                    {{-- ============ KOLOM KIRI ============ --}}
                    <div class="w-full space-y-6 lg:col-span-8">

                        {{-- Kartu hero tiket --}}
                        <div class="relative flex flex-col justify-between gap-5 overflow-hidden rounded-2xl bg-[#10254a] p-5 text-white shadow-md sm:flex-row sm:gap-6 sm:p-6">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/10">{{ $icon('ticket', 'h-5 w-5') }}</div>
                                    <div>
                                        <h2 class="text-sm font-semibold text-slate-100">Nomor Registrasi Tiket</h2>
                                        <p class="text-xs text-slate-400">Kategori : {{ $ticket['category'] }}</p>
                                    </div>
                                </div>
                                <div class="pt-1 text-2xl font-extrabold tracking-tight sm:text-3xl">{{ $ticket['code'] }}</div>
                                <p class="text-xs leading-relaxed text-slate-300">
                                    Kerusakan dilaporkan oleh {{ $ticket['reporter']['name'] }} (Divisi {{ $ticket['reporter']['division'] }})<br>
                                    pada {{ $ticket['reportedAt'] }}
                                </p>
                            </div>

                            <div class="w-full shrink-0 sm:w-auto sm:self-center">
                                <div class="min-w-[210px] rounded-xl border border-white/15 bg-white/10 p-4 text-left">
                                    <div class="flex items-center justify-between text-[11px] font-semibold tracking-wide text-slate-200">
                                        <span>TAHAP PENANGANAN</span>
                                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                    </div>
                                    <div class="mt-1.5 text-xs font-bold">Tahap {{ $ticket['stage']['current'] }} dari {{ $ticket['stage']['total'] }} ({{ $ticket['stage']['name'] }})</div>
                                    <div class="mt-2.5 flex gap-1" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $ticket['stage']['total'] }}" aria-valuenow="{{ $ticket['stage']['current'] }}">
                                        @for ($i = 1; $i <= $ticket['stage']['total']; $i++)
                                            <span class="h-1.5 flex-1 rounded-full {{ $i <= $ticket['stage']['current'] ? 'bg-amber-400' : 'bg-white/20' }}"></span>
                                        @endfor
                                    </div>
                                    <div class="mt-2 text-[10px] text-slate-300">Estimasi penguji operasional: {{ $ticket['stage']['estimate'] }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Spesifikasi & informasi --}}
                        <div class="{{ $card }}">
                            <div class="flex flex-col items-start gap-4 border-b border-slate-100 pb-6 sm:flex-row sm:items-center sm:gap-6">
                                <div class="mx-auto flex h-20 w-24 shrink-0 items-center justify-center sm:mx-0 sm:h-24 sm:w-32" aria-hidden="true">
                                    <svg class="h-full w-full" fill="none" viewBox="0 0 160 120">
                                        <path d="M100 20 L135 35 L135 85 L100 70 Z" fill="#93c5fd"/>
                                        <path d="M100 20 L75 32 L75 82 L100 70 Z" fill="#60a5fa"/>
                                        <path d="M75 32 L110 44 L135 35 L100 20 Z" fill="#bfdbfe"/>
                                        <path d="M25 80 L90 80 L115 102 L40 102 Z" fill="#cbd5e1" stroke="#94a3b8" stroke-width="1.5"/>
                                        <path d="M35 40 L95 40 L95 80 L35 80 Z" fill="#1e293b"/>
                                        <rect fill="#3b82f6" fill-opacity="0.8" height="32" rx="1" width="52" x="39" y="44"/>
                                        <circle cx="65" cy="60" fill="none" r="7" stroke="white" stroke-width="2"/>
                                        <circle cx="95" cy="78" fill="#3b82f6" r="8"/>
                                        <path d="M92 78 L94 80 L98 76" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                                        <rect fill="white" height="26" rx="2" stroke="#cbd5e1" stroke-width="1.5" width="22" x="18" y="55"/>
                                        <rect fill="#3b82f6" height="4" width="4" x="22" y="59"/>
                                        <rect fill="#3b82f6" height="4" width="4" x="32" y="59"/>
                                        <rect fill="#3b82f6" height="4" width="4" x="22" y="69"/>
                                        <rect fill="#3b82f6" height="2" width="2" x="28" y="65"/>
                                        <rect fill="#3b82f6" height="4" width="4" x="32" y="69"/>
                                    </svg>
                                </div>
                                <div class="pt-1 text-left">
                                    <h3 class="text-base font-bold tracking-tight text-slate-900 sm:text-lg">Spesifikasi &amp; Informasi Lengkap Laporan</h3>
                                    <p class="mt-1 text-xs leading-relaxed text-slate-500">Data terverifikasi otomatis dari master basis data aset P-TAMS</p>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-3">
                                <div class="flex flex-col justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                    <div>
                                        <div class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                                            {{ $icon('monitor', 'h-4 w-4 text-slate-600') }} Nama Perangkat
                                        </div>
                                        <div class="mt-3">
                                            <div class="text-base font-bold leading-snug text-slate-900">{{ $ticket['device']['name'] }}</div>
                                            <div class="mt-0.5 text-[11px] font-medium text-slate-500"># Serial No : {{ $ticket['device']['serial'] }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span class="inline-block rounded-md border border-blue-100 bg-blue-50 px-2.5 py-0.5 text-[10px] font-semibold text-blue-600">{{ $ticket['device']['category'] }}</span>
                                    </div>
                                </div>

                                <div class="flex flex-col justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                    <div>
                                        <div class="text-[11px] font-medium text-slate-500">Lokasi Perangkat</div>
                                        <div class="mt-2 text-sm font-bold text-slate-900">{{ $ticket['device']['location'] }}</div>
                                    </div>
                                    <div class="mt-2 text-[10px] leading-tight text-slate-500">{{ $ticket['device']['locationDetail'] }}</div>
                                </div>

                                <div class="flex flex-col justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                    <div>
                                        <div class="text-[11px] font-medium text-slate-500">Nama Pelapor</div>
                                        <div class="mt-2 text-sm font-bold text-slate-900">{{ $ticket['reporter']['name'] }}</div>
                                    </div>
                                    <div class="mt-2 text-[10px] text-slate-500">NIP : {{ $ticket['reporter']['nip'] }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Isi laporan & lampiran --}}
                        <div class="{{ $card }} space-y-6">
                            <div>
                                <h3 class="text-base font-bold tracking-tight text-slate-900 sm:text-lg">Isi Laporan / Keluhan</h3>
                                <p class="mt-0.5 text-xs text-slate-500">Detail keluhan teknis dan catatan kendala operasional yang dilaporkan oleh pengguna</p>
                            </div>

                            <div class="flex items-start gap-3 rounded-xl border border-slate-200/70 bg-slate-50 p-4">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-900 text-white">{{ $icon('info', 'h-3.5 w-3.5') }}</span>
                                <div class="space-y-1">
                                    <h4 class="text-xs font-bold text-slate-800">Deskripsi Masalah</h4>
                                    <p class="text-xs leading-relaxed text-slate-600">{{ $ticket['description'] }}</p>
                                </div>
                            </div>

                            <div class="space-y-3 pt-1">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-800">
                                    {{ $icon('clip', 'h-4 w-4 text-slate-700') }} Lampiran Berkas Pendukung
                                </div>

                                <div class="flex flex-col items-stretch gap-4 pt-1 sm:flex-row">
                                    {{-- Dokumen --}}
                                    <a href="{{ $ticket['attachment']['url'] }}" @click.prevent="toast('Mengunduh file: {{ $ticket['attachment']['name'] }}', 'info')"
                                       class="group flex w-full items-center justify-between rounded-xl border border-slate-200 bg-white p-3 text-left transition-all hover:border-slate-300 hover:shadow-sm sm:w-60">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 transition-colors group-hover:bg-sky-200">{{ $icon('doc', 'h-5 w-5') }}</span>
                                            <span class="min-w-0">
                                                <span class="block truncate text-xs font-bold leading-snug text-slate-800 transition-colors group-hover:text-blue-600">{{ $ticket['attachment']['name'] }}</span>
                                                <span class="mt-0.5 block text-[10px] text-slate-400">{{ $ticket['attachment']['size'] }}</span>
                                            </span>
                                        </div>
                                        <span class="shrink-0 pl-2 text-slate-400 group-hover:text-blue-600" title="Unduh berkas">{{ $icon('download') }}</span>
                                    </a>

                                    {{-- Foto --}}
                                    <button type="button" @click="toast('Membuka pratinjau gambar...', 'info')"
                                            class="group relative flex h-28 w-full items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-[#dbe2ed] sm:w-60">
                                        <span class="text-slate-400">{{ $icon('photo', 'h-10 w-10') }}</span>
                                        <span class="absolute inset-0 flex items-center justify-center gap-1.5 bg-slate-900/40 text-[11px] font-semibold text-white opacity-0 transition-opacity group-hover:opacity-100 group-focus-visible:opacity-100">
                                            {{ $icon('eye') }} Lihat Foto
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ============ KOLOM KANAN ============ --}}
                    <div class="w-full space-y-6 lg:col-span-4">

                        {{-- Ringkasan validitas / QR --}}
                        <div class="{{ $card }} text-center">
                            <div class="flex items-center justify-between pb-4">
                                <h3 class="text-xs font-bold tracking-wider text-slate-800">RINGKASAN VALIDITAS TIKET</h3>
                                <button type="button" @click="copyQr()" title="Salin tautan publik QR"
                                        class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-600 transition hover:bg-blue-100 active:scale-95">
                                    {{ $icon('copy', 'h-3 w-3') }} Public QR
                                </button>
                            </div>

                            <div class="mx-auto my-2 flex max-w-xs flex-col items-center rounded-2xl border border-slate-100 bg-slate-50 p-5 sm:p-6 lg:max-w-none">
                                {{-- Placeholder QR. Ganti dengan QR asli, mis. simplesoftwareio/simple-qrcode:
                                     {!! QrCode::size(180)->generate($ticket['qrUrl']) !!} --}}
                                <div class="flex h-40 w-40 items-center justify-center rounded-xl border border-slate-200 bg-white p-3 shadow-sm sm:h-48 sm:w-48" role="img" aria-label="QR code tiket {{ $ticket['code'] }}">
                                    <svg class="h-full w-full text-slate-700" fill="currentColor" viewBox="0 0 100 100">
                                        <path d="M10 10 H35 V35 H10 Z M15 15 V30 H30 V15 Z M20 20 H25 V25 H20 Z"/>
                                        <path d="M65 10 H90 V35 H65 Z M70 15 V30 H85 V15 Z M75 20 H80 V25 H75 Z"/>
                                        <path d="M10 65 H35 V90 H10 Z M15 70 V85 H30 V70 Z M20 75 H25 V80 H20 Z"/>
                                        <rect height="15" width="5" x="42" y="10"/><rect height="8" width="5" x="52" y="10"/>
                                        <rect height="5" width="15" x="42" y="30"/><rect height="10" width="10" x="45" y="40"/>
                                        <rect height="5" width="10" x="10" y="42"/><rect height="10" width="8" x="25" y="45"/>
                                        <rect height="5" width="12" x="65" y="42"/><rect height="10" width="8" x="82" y="42"/>
                                        <rect height="10" width="10" x="65" y="55"/><rect height="12" width="6" x="40" y="60"/>
                                        <rect height="6" width="6" x="52" y="62"/><rect height="6" width="12" x="78" y="68"/>
                                        <rect height="6" width="18" x="40" y="80"/><rect height="8" width="8" x="68" y="82"/>
                                        <rect height="8" width="8" x="82" y="82"/>
                                    </svg>
                                </div>
                                <div class="mt-4 text-sm font-extrabold tracking-wide text-slate-800">ID : {{ $ticket['publicId'] }}</div>
                                <p class="mt-2 px-2 text-[11px] leading-relaxed text-slate-400">Pindai barcode ini kapan saja menggunakan kamera ponsel untuk memantau status langsung tanpa login</p>
                            </div>

                            <div class="mt-5 space-y-3.5 px-1 text-left text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Nomor Registrasi :</span>
                                    <span class="font-bold text-slate-900">{{ $ticket['code'] }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Prioritas Respon :</span>
                                    <span class="rounded-md border border-rose-500 bg-rose-50/50 px-3 py-1 text-[11px] font-bold text-rose-600">{{ $ticket['priorityLevel'] }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Edit status laporan --}}
                        <div class="{{ $card }}">
                            <h3 class="text-xs font-bold tracking-wider text-slate-900">EDIT STATUS LAPORAN</h3>
                            <p class="mt-1 text-[11px] leading-relaxed text-slate-400">Perbarui status dan catatan penanganan laporan.</p>

                            <form action="#" method="POST" @submit.prevent="save()" class="mt-4 space-y-4" novalidate>
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label for="status-select" class="mb-1.5 block text-xs font-semibold text-slate-700">Status Laporan</label>
                                    <div class="relative">
                                        <select id="status-select" name="status" x-model="form.status"
                                                class="w-full cursor-pointer appearance-none rounded-lg border border-slate-200 bg-white py-2.5 pl-3 pr-9 text-xs font-medium text-slate-800 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                            <option value="in_progress">Sedang Diproses</option>
                                            <option value="pending_parts">Menunggu Konfirmasi</option>
                                            <option value="completed">Selesai</option>
                                            <option value="cancelled">Dibatalkan</option>
                                        </select>
                                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">{{ $icon('chevron') }}</span>
                                    </div>
                                </div>

                                <div>
                                    <div class="mb-1.5 flex items-center justify-between">
                                        <label for="notes-textarea" class="block text-xs font-semibold text-slate-700">Catatan Penanganan</label>
                                        <span class="font-mono text-[10px] text-slate-400" x-text="`${form.notes.length} / 1000 karakter`"></span>
                                    </div>
                                    <textarea id="notes-textarea" name="resolution_notes" rows="4" maxlength="1000" x-model="form.notes"
                                              placeholder="Tuliskan hasil pemeriksaan atau tindakan perbaikan..."
                                              class="w-full resize-none rounded-lg border border-slate-200 bg-white p-3 text-xs text-slate-700 placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]"></textarea>
                                </div>

                                <div class="flex flex-col items-center gap-3 pt-2 sm:flex-row">
                                    <button type="button" @click="requestReset()"
                                            class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-center text-xs font-bold text-slate-700 transition-colors hover:bg-slate-50 active:scale-[0.98] sm:w-1/2">
                                        Batal
                                    </button>
                                    <button type="submit" :disabled="saving || !dirty"
                                            class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-[#10254a] px-3 py-2.5 text-center text-xs font-bold text-white shadow-sm transition-all hover:bg-[#0b1b3a] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50 sm:w-1/2">
                                        <svg x-show="saving" x-cloak class="h-3.5 w-3.5 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                        </svg>
                                        <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed bottom-5 right-5 z-[100] max-w-sm rounded-xl border px-4 py-3 text-xs font-medium leading-relaxed text-white shadow-lg"
         :class="{ 'border-slate-700 bg-slate-900': toastType === 'success', 'border-slate-700 bg-[#10254a]': toastType === 'info', 'border-rose-700 bg-rose-700': toastType === 'error' }"
         role="status" aria-live="polite">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ MODAL BUANG PERUBAHAN ============ --}}
    <div x-show="modal === 'discard'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="alertdialog" aria-modal="true" aria-labelledby="modal-discard-title">
        <div x-show="modal === 'discard'" x-transition.opacity @click="modal = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'discard'" x-transition class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white p-5 shadow-2xl sm:p-7">
            <div class="mb-4 flex items-start gap-3.5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-amber-100 bg-amber-50 text-amber-600">{{ $icon('warning', 'h-5 w-5') }}</span>
                <div>
                    <h3 id="modal-discard-title" class="text-lg font-bold leading-tight text-slate-900">Buang perubahan?</h3>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Ada perubahan yang belum disimpan. Formulir akan dikembalikan ke nilai awal.</p>
                </div>
            </div>
            <div class="flex flex-col-reverse items-stretch justify-end gap-2.5 pt-2 sm:flex-row sm:items-center sm:gap-3">
                <button type="button" @click="modal = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lanjut mengedit</button>
                <button type="button" @click="reset()" class="rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a]">Ya, kembalikan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ticketDetail', (initial) => ({
            sidebarOpen: false,
            saved: { status: initial.status, notes: initial.notes },   // nilai terakhir yang tersimpan
            form:  { status: initial.status, notes: initial.notes },   // nilai di formulir
            saving: false,
            modal: null,                // 'discard' | null
            toastMsg: '',
            toastType: 'success',
            toastTimer: null,

            statuses: {
                in_progress:   { label: 'Sedang Diproses',     dot: 'bg-amber-500',   text: 'text-amber-500' },
                pending_parts: { label: 'Menunggu Konfirmasi', dot: 'bg-sky-500',     text: 'text-sky-600' },
                completed:     { label: 'Selesai',             dot: 'bg-emerald-500', text: 'text-emerald-600' },
                cancelled:     { label: 'Dibatalkan',          dot: 'bg-slate-400',   text: 'text-slate-600' },
            },

            get dirty() {
                return this.form.status !== this.saved.status || this.form.notes.trim() !== this.saved.notes.trim();
            },

            toast(msg, type = 'success') {
                this.toastMsg = msg;
                this.toastType = type;
                clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMsg = '', 4500);
            },

            // Frontend saja (simulasi 0,75 detik). Nanti ganti dengan submit ke backend.
            save() {
                if (!this.dirty || this.saving) return;
                if (this.form.status === 'completed' && !this.form.notes.trim()) {
                    return this.toast('Isi catatan penanganan sebelum menandai tiket selesai.', 'error');
                }
                this.saving = true;
                setTimeout(() => {
                    this.saved = { status: this.form.status, notes: this.form.notes };
                    this.saving = false;
                    this.toast(`Status tiket ${initial.code} berhasil diperbarui menjadi "${this.statuses[this.saved.status].label}".`);
                }, 750);
            },

            requestReset() {
                if (this.dirty) this.modal = 'discard';
                else this.toast('Tidak ada perubahan untuk dibatalkan.', 'info');
            },
            reset() {
                this.form = { ...this.saved };
                this.modal = null;
                this.toast('Formulir dikembalikan ke nilai semula.', 'info');
            },

            copyQr() {
                const done = () => this.toast('Tautan QR publik berhasil disalin ke clipboard.', 'info');
                if (navigator.clipboard?.writeText) {
                    navigator.clipboard.writeText(initial.qrUrl).then(done).catch(() => this.toast(`Tautan publik: ${initial.qrUrl}`, 'info'));
                } else {
                    this.toast(`Tautan publik: ${initial.qrUrl}`, 'info');
                }
            },
        }));
    });
</script>
@endsection