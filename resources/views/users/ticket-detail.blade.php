@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data dari controller ($ticket). Tiket ini milik user yang login.
     */
    $ticket = [
        'code'          => '#TC-024',
        'publicId'      => 'PTAMS-TC-024',
        'category'      => 'Hardware / Komputer / Laptop',
        'reportedAt'    => '12 Oktober 2026, 10:00 WIB',
        'status'        => ['label' => 'Sedang Diproses', 'text' => 'text-amber-600', 'dot' => 'bg-amber-500'],
        'priorityLabel' => 'Tinggi (Urgent)',
        'priorityLevel' => 'Level 1 – Urgent',
        'stage'         => ['current' => 3, 'total' => 4, 'name' => 'Perbaikan Fisik', 'estimate' => '~2 jam'],
        'device' => [
            'name' => 'Laptop Acer', 'serial' => 'ACR-Aspire-7729X', 'category' => 'Hardware',
            'location' => 'Ruang Meeting A', 'locationDetail' => 'Gedung utama lantai 3 – operasional',
        ],
        'reporter' => ['name' => 'Fikri', 'division' => 'Bendahara', 'nip' => '1999999999'],
        'description' => 'Laptop sering mati sendiri saat dipakai lebih dari 30 menit dan layarnya berkedip sebelum mati. Sudah dicoba dicolok ke charger dan restart, tetapi masalahnya muncul lagi. Laptop ini dipakai untuk rapat dan presentasi, jadi mohon ditangani secepatnya.',
        'attachment'    => ['name' => 'Lampiran Berkas Pendukung', 'size' => '2.4 MB', 'url' => '#'],
    ];

    // Alur penanganan. state: done | active | pending
    $stages = [
        ['no' => 1, 'state' => 'done',    'title' => 'Laporan Dibuat & Tiket Terbit', 'time' => '12 Okt 2026 • 10:00 WIB',
         'text' => 'Tiket berhasil diajukan melalui pemindaian QR Code pada stiker aset laptop oleh pelapor Fikri. Sistem otomatis memberi nomor antrean Helpdesk.'],
        ['no' => 2, 'state' => 'done',    'title' => 'Konfirmasi Kerusakan',          'time' => '12 Okt 2026 • 13:30 WIB',
         'text' => 'Kerusakan pada perangkat sedang dicek dan dikonfirmasi apakah sesuai dengan yang dilaporkan. Kami akan segera memperbaiki perangkat. Mohon maaf atas ketidaknyamanannya.'],
        ['no' => 3, 'state' => 'active',  'title' => 'Proses',                        'time' => '13 Okt 2026 • 09:15 WIB',
         'text' => 'Teknisi sedang membongkar unit untuk memeriksa baterai, port pengisian daya, dan motherboard, serta membersihkan kipas pendingin.'],
        ['no' => 4, 'state' => 'pending', 'title' => 'Selesai',                       'time' => 'Estimasi 14 Okt 2026',
         'text' => 'Menunggu pembaruan dari sisi admin.'],
    ];
    $stageLabel = ['done' => 'SELESAI', 'active' => 'SEDANG BERJALAN', 'pending' => 'MENUNGGU'];
    $stageBadge = ['done' => 'bg-emerald-100 text-emerald-700', 'active' => 'bg-[#10254a] text-white', 'pending' => 'bg-slate-200 text-slate-600'];

    $faqs = [
        ['q' => 'Bagaimana cara melaporkan kerusakan perangkat?',        'a' => 'Scan QR Code yang tersedia, kemudian isi formulir laporan dengan menjelaskan kendala yang dialami.'],
        ['q' => 'Bagaimana mengetahui status penanganan?',               'a' => 'Pelapor dapat memantau perkembangan laporan melalui halaman riwayat atau detail tiket pengaduan.'],
        ['q' => 'Berapa lama proses penanganan perangkat?',              'a' => 'Durasi penanganan bergantung pada jenis kerusakan, tingkat prioritas, dan ketersediaan komponen atau sparepart.'],
        ['q' => 'Bagaimana proses setelah perbaikan selesai?',           'a' => 'Teknisi akan memperbarui status penanganan dan mengembalikan perangkat kepada lokasi atau penanggung jawab terkait.'],
        ['q' => 'Bagaimana jika perangkat membutuhkan penanganan darurat?', 'a' => 'Hubungi administrator atau petugas IT terkait untuk mendapatkan tindak lanjut sesuai tingkat urgensi permasalahan.'],
    ];

    // Halaman terkait (ganti dengan route kamu)
    $backUrl = url('/tiket');

    // Path ikon (Heroicons outline)
    $ic = [
        'back'     => 'M10 19l-7-7m0 0l7-7m-7 7h18',
        'ticket'   => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
        'monitor'  => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'info'     => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'clip'     => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
        'photo'    => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
        'download' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4',
        'check'    => 'M5 13l4 4L19 7',
        'phone'    => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
        'chat'     => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
        'help'     => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'support'  => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z',
        'chevron'  => 'M19 9l-7 7-7-7',
        'close'    => 'M6 18L18 6M6 6l12 12',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    // QR placeholder (dipakai di kartu & pop up). Ganti dengan QR asli, mis. simplesoftwareio/simple-qrcode.
    $qr = fn ($class) => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" viewBox="0 0 140 140" role="img" aria-label="QR code tiket '.$ticket['code'].'">'
        .'<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="10"/><rect fill="#1e293b" height="16" width="16" x="20" y="20"/>'
        .'<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="94" y="10"/><rect fill="#1e293b" height="16" width="16" x="104" y="20"/>'
        .'<rect height="36" rx="4" stroke="#1e293b" stroke-width="6" width="36" x="10" y="94"/><rect fill="#1e293b" height="16" width="16" x="20" y="104"/>'
        .'<g fill="#1e293b"><rect height="8" width="8" x="56" y="14"/><rect height="8" width="10" x="74" y="14"/><rect height="8" width="16" x="56" y="32"/><rect height="18" width="6" x="80" y="32"/>'
        .'<rect height="8" width="12" x="20" y="56"/><rect height="8" width="18" x="42" y="56"/><rect height="18" width="8" x="70" y="56"/><rect height="8" width="18" x="88" y="56"/><rect height="8" width="14" x="116" y="56"/>'
        .'<rect height="8" width="18" x="14" y="74"/><rect height="18" width="8" x="42" y="74"/><rect height="8" width="18" x="60" y="80"/><rect height="8" width="14" x="94" y="74"/><rect height="18" width="12" x="118" y="74"/>'
        .'<rect height="8" width="16" x="56" y="102"/><rect height="18" width="8" x="82" y="102"/><rect height="8" width="18" x="100" y="102"/><rect height="10" width="28" x="60" y="120"/><rect height="10" width="16" x="100" y="120"/></g></svg>'
    );

    $card = 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6';
@endphp

<div x-data="{ sidebarOpen: false, qrOpen: false, faq: 0 }"
     @keydown.escape.window="sidebarOpen = false; qrOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="tiket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="$ticket['reporter']['name']" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-[1400px] space-y-6">

                {{-- Kembali --}}
                <div>
                    <a href="{{ $backUrl }}" class="inline-flex items-center gap-2 rounded-lg bg-[#10254a] px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">
                        {{ $icon('back') }} Tiket Saya
                    </a>
                </div>

                {{-- Judul + status & prioritas --}}
                <section class="flex flex-col justify-between gap-4 lg:flex-row lg:items-center">
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-[#10254a] sm:text-2xl lg:text-3xl">Detail Laporan Kerusakan &amp; Monitoring Servis</h1>
                        <p class="mt-1 text-xs text-slate-500 sm:text-sm">Lacak tahapan perbaikan, verifikasi suku cadang, dan perbaruan teknisi langsung dari sistem pusat</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status Saat Ini</div>
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold {{ $ticket['status']['text'] }}">
                                <span class="h-2 w-2 rounded-full {{ $ticket['status']['dot'] }}"></span> {{ $ticket['status']['label'] }}
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Prioritas</div>
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold text-rose-600">
                                <span class="h-2 w-2 rounded-full bg-rose-600"></span> {{ $ticket['priorityLabel'] }}
                            </div>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

                    {{-- ============ KOLOM KIRI ============ --}}
                    <div class="w-full space-y-6 lg:col-span-8">

                        {{-- Hero tiket --}}
                        <div class="flex flex-col justify-between gap-6 overflow-hidden rounded-2xl bg-[#10254a] p-5 text-white shadow-md sm:p-7 md:flex-row md:items-center">
                            <div class="flex items-start gap-4">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-white/15 bg-white/10 text-sky-300">{{ $icon('ticket', 'h-6 w-6') }}</span>
                                <div>
                                    <h2 class="text-sm font-semibold text-slate-200">Nomor Registrasi Tiket</h2>
                                    <p class="mt-0.5 text-xs text-slate-400">Kategori : {{ $ticket['category'] }}</p>
                                    <p class="mt-2 text-3xl font-extrabold tracking-tight">{{ $ticket['code'] }}</p>
                                    <p class="mt-2 text-[11px] leading-relaxed text-slate-400">
                                        Kerusakan dilaporkan oleh {{ $ticket['reporter']['name'] }} (Divisi {{ $ticket['reporter']['division'] }})<br class="hidden sm:inline">
                                        pada {{ $ticket['reportedAt'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="shrink-0 rounded-xl border border-white/15 bg-white/10 p-4 md:w-64">
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wide text-slate-200">
                                    <span>Tahap Penanganan</span><span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                </div>
                                <p class="mt-1 text-xs font-bold">Tahap {{ $ticket['stage']['current'] }} dari {{ $ticket['stage']['total'] }} ({{ $ticket['stage']['name'] }})</p>
                                <div class="mt-2.5 flex gap-1" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $ticket['stage']['total'] }}" aria-valuenow="{{ $ticket['stage']['current'] }}">
                                    @for ($i = 1; $i <= $ticket['stage']['total']; $i++)
                                        <span class="h-1.5 flex-1 rounded-full {{ $i <= $ticket['stage']['current'] ? 'bg-amber-400' : 'bg-white/20' }}"></span>
                                    @endfor
                                </div>
                                <p class="mt-2 text-[10px] text-slate-300">Estimasi penguji operasional: {{ $ticket['stage']['estimate'] }}</p>
                            </div>
                        </div>

                        {{-- Spesifikasi --}}
                        <div class="{{ $card }} space-y-6">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Spesifikasi &amp; Informasi Lengkap Laporan</h2>
                                <p class="mt-0.5 text-xs text-slate-400">Data terverifikasi otomatis dari master basis data aset P-TAMS</p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">{{ $icon('monitor', 'h-4 w-4 text-slate-500') }} Nama Perangkat</div>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $ticket['device']['name'] }}</h3>
                                        <p class="text-[11px] text-slate-500"># Serial No : <span class="font-semibold text-slate-700">{{ $ticket['device']['serial'] }}</span></p>
                                        <span class="mt-2 inline-block rounded bg-sky-100 px-2 py-0.5 text-[10px] font-bold text-sky-700">{{ $ticket['device']['category'] }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <span class="text-xs font-medium text-slate-700">Lokasi Perangkat</span>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $ticket['device']['location'] }}</h3>
                                        <p class="mt-1 text-[11px] leading-snug text-slate-400">{{ $ticket['device']['locationDetail'] }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <span class="text-xs font-medium text-slate-700">Nama Pelapor</span>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $ticket['reporter']['name'] }}</h3>
                                        <p class="mt-1 text-[11px] text-slate-500">NIP : <span class="font-medium text-slate-700">{{ $ticket['reporter']['nip'] }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Isi laporan & lampiran --}}
                        <div class="{{ $card }} space-y-6">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Isi Laporan / Keluhan</h2>
                                <p class="mt-0.5 text-xs text-slate-400">Detail keluhan teknis dan catatan kendala operasional yang dilaporkan oleh pengguna</p>
                            </div>

                            <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-900 text-white">{{ $icon('info', 'h-3.5 w-3.5') }}</span>
                                <div class="space-y-1">
                                    <h3 class="text-xs font-bold text-slate-800">Deskripsi Masalah</h3>
                                    <p class="text-xs leading-relaxed text-slate-600">{{ $ticket['description'] }}</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-800">{{ $icon('clip', 'h-4 w-4 text-slate-500') }} Lampiran Berkas Pendukung</div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <a href="{{ $ticket['attachment']['url'] }}" class="group flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3 transition-colors hover:border-slate-300 hover:bg-white">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-teal-200 bg-teal-50 text-teal-600">{{ $icon('photo', 'h-5 w-5') }}</span>
                                            <span class="min-w-0">
                                                <span class="block truncate text-xs font-bold text-slate-800 group-hover:text-blue-600">{{ $ticket['attachment']['name'] }}</span>
                                                <span class="block text-[10px] text-slate-400">{{ $ticket['attachment']['size'] }}</span>
                                            </span>
                                        </div>
                                        <span class="shrink-0 pl-2 text-slate-400 group-hover:text-blue-600" title="Unduh berkas">{{ $icon('download') }}</span>
                                    </a>
                                    <div class="flex h-28 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-200/70 text-slate-400">{{ $icon('photo', 'h-8 w-8') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Riwayat & alur penanganan --}}
                        <div class="{{ $card }} space-y-6">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Riwayat &amp; Alur Penanganan Servis</h2>
                                <p class="mt-0.5 text-xs text-slate-400">Pantau setiap tahap penanganan laporan Anda secara berurutan</p>
                            </div>

                            <ol class="space-y-4 pt-1">
                                @foreach ($stages as $stage)
                                    <li class="relative flex items-start gap-4" {!! $stage['state'] === 'active' ? 'aria-current="step"' : '' !!}>
                                        @unless ($loop->last)
                                            <span class="absolute bottom-[-16px] left-[15px] top-8 w-0.5 bg-slate-200" aria-hidden="true"></span>
                                        @endunless

                                        {{-- Penanda tahap --}}
                                        @if ($stage['state'] === 'done')
                                            <span class="z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 border-emerald-500 bg-white text-emerald-600">{{ $icon('check', 'h-4 w-4') }}</span>
                                        @elseif ($stage['state'] === 'active')
                                            <span class="z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 border-[#10254a] bg-[#10254a]"><span class="h-2.5 w-2.5 rounded-full bg-white"></span></span>
                                        @else
                                            <span class="z-10 flex h-8 w-8 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 bg-white"><span class="h-2 w-2 rounded-full bg-slate-300"></span></span>
                                        @endif

                                        <div class="flex-1 rounded-xl border border-slate-200 bg-slate-50 p-4">
                                            <div class="flex flex-col justify-between gap-1 sm:flex-row sm:items-center">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="rounded px-2 py-0.5 text-[10px] font-bold {{ $stageBadge[$stage['state']] }}">TAHAP {{ $stage['no'] }} • {{ $stageLabel[$stage['state']] }}</span>
                                                    <h3 class="text-xs font-bold text-slate-900">{{ $stage['title'] }}</h3>
                                                </div>
                                                <span class="text-[11px] text-slate-400">{{ $stage['time'] }}</span>
                                            </div>
                                            <p class="mt-2 text-[11px] leading-relaxed {{ $stage['state'] === 'pending' ? 'text-slate-400' : 'text-slate-600' }}">{{ $stage['text'] }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    {{-- ============ KOLOM KANAN ============ --}}
                    <div class="w-full space-y-6 lg:col-span-4">

                        {{-- Ringkasan validitas / QR --}}
                        <div class="{{ $card }} space-y-5">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Ringkasan Validitas Tiket</h3>
                                <button type="button" @click="qrOpen = true" class="rounded bg-blue-100 px-2 py-1 text-[10px] font-bold text-blue-800 transition-colors hover:bg-blue-200">PUBLIC QR</button>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                                <button type="button" @click="qrOpen = true" class="inline-block rounded-xl border border-slate-100 bg-white p-3 shadow-sm transition-transform hover:scale-[1.02]" aria-label="Perbesar QR code">
                                    {{ $qr('h-36 w-36') }}
                                </button>
                                <div class="mt-4">
                                    <h4 class="text-xs font-extrabold tracking-wider text-slate-800">ID : {{ $ticket['publicId'] }}</h4>
                                    <p class="mx-auto mt-1 max-w-[220px] text-[10px] leading-relaxed text-slate-500">Pindai barcode ini kapan saja menggunakan kamera ponsel untuk memantau status langsung tanpa login</p>
                                </div>
                            </div>

                            <div class="space-y-3 pt-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Nomor Registrasi :</span>
                                    <span class="font-bold text-slate-900">{{ $ticket['code'] }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Prioritas Respon :</span>
                                    <span class="rounded-md border border-rose-500 px-3 py-1 text-[11px] font-bold text-rose-600">{{ $ticket['priorityLevel'] }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Pusat bantuan --}}
                        <div class="{{ $card }} space-y-4">
                            <div class="flex items-center gap-2 text-slate-700">{{ $icon('support') }}<h3 class="text-sm font-bold text-slate-900">Pusat Bantuan</h3></div>

                            <div class="space-y-2.5">
                                <a href="tel:4022" class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-3 transition-colors hover:bg-slate-100/70">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-100/70 text-blue-700">{{ $icon('phone') }}</span>
                                        <span>
                                            <span class="block text-xs font-bold text-slate-800">IT Helpdesk Extension</span>
                                            <span class="block text-[10px] text-slate-400">Jam kerja 08:00 - 17:00</span>
                                        </span>
                                    </div>
                                    <span class="text-xs font-bold text-blue-950">ext. 4022</span>
                                </a>
                                <a href="https://wa.me/628112090400" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/60 p-3 transition-colors hover:bg-slate-100/70">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-100/70 text-emerald-700">{{ $icon('chat') }}</span>
                                        <span>
                                            <span class="block text-xs font-bold text-slate-800">Hotline WhatsApp Servis</span>
                                            <span class="block text-[10px] text-slate-400">Respon cepat kendala aset</span>
                                        </span>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-800">+62 811-2090-400</span>
                                </a>
                            </div>
                        </div>

                        {{-- Panduan & FAQ --}}
                        <div class="{{ $card }} space-y-4">
                            <div class="flex items-center gap-2 text-slate-700">{{ $icon('help') }}<h3 class="text-sm font-bold text-slate-900">Panduan Pelapor &amp; FAQ</h3></div>

                            <div class="divide-y divide-slate-100 text-xs">
                                @foreach ($faqs as $i => $faq)
                                    <div class="py-2.5">
                                        <button type="button" @click="faq = faq === {{ $i }} ? null : {{ $i }}" :aria-expanded="faq === {{ $i }}" aria-controls="faq-{{ $i }}"
                                                class="flex w-full items-start justify-between gap-3 text-left font-bold text-slate-800 transition-colors hover:text-blue-700">
                                            <span>{{ $faq['q'] }}</span>
                                            <span class="mt-0.5 shrink-0 text-slate-400 transition-transform" :class="faq === {{ $i }} ? 'rotate-180' : ''">{{ $icon('chevron', 'h-4 w-4') }}</span>
                                        </button>
                                        <div id="faq-{{ $i }}" x-show="faq === {{ $i }}" x-cloak x-transition.opacity class="mt-1.5 pr-6 text-[11px] leading-relaxed text-slate-500">{{ $faq['a'] }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between border-t border-slate-100 pt-3 text-[11px]">
                                <span class="text-slate-400">SOP Pemeliharaan Sarana IT v4.2</span>
                                <a href="#" class="font-bold text-slate-800 transition-colors hover:text-blue-600">Unduh PDF SOP</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- ============ POP UP QR PUBLIK ============ --}}
    <div x-show="qrOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="qr-title">
        <div x-show="qrOpen" x-transition.opacity @click="qrOpen = false" class="absolute inset-0 bg-slate-950/60"></div>
        <div x-show="qrOpen" x-transition class="relative w-full max-w-sm space-y-4 rounded-2xl bg-white p-6 text-center shadow-2xl">
            <button type="button" @click="qrOpen = false" class="absolute right-4 top-4 rounded-full p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
            <h3 id="qr-title" class="text-sm font-bold uppercase tracking-wider text-slate-900">Public Ticket QR Code</h3>
            <div class="inline-block rounded-xl border border-slate-200 bg-slate-50 p-4">{{ $qr('mx-auto h-48 w-48') }}</div>
            <p class="text-xs font-bold text-slate-800">{{ $ticket['code'] }} • {{ $ticket['publicId'] }}</p>
            <button type="button" @click="qrOpen = false" class="w-full rounded-lg bg-[#10254a] py-2.5 text-xs font-semibold text-white transition-colors hover:bg-[#0b1b3a]">Selesai</button>
        </div>
    </div>

    {{-- Pop up scan QR (dibuka dari tombol "Mulai Scan QR" di sidebar) --}}
    <x-qr-scan-modal />
</div>
@endsection