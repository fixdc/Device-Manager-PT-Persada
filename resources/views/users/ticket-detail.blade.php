@extends('layouts.index')

@section('content')
@php
    $statusLabels = [
        'open' => 'Pending',
        'confirmed' => 'Dikonfirmasi',
        'canceled' => 'Dibatalkan',
        'process' => 'Diproses',
        'completed' => 'Selesai',
        'failed' => 'Gagal',
    ];
    $statusStyles = [
        'open' => ['text' => 'text-rose-600', 'dot' => 'bg-rose-500'],
        'confirmed' => ['text' => 'text-sky-600', 'dot' => 'bg-sky-500'],
        'canceled' => ['text' => 'text-slate-600', 'dot' => 'bg-slate-500'],
        'process' => ['text' => 'text-amber-600', 'dot' => 'bg-amber-500'],
        'completed' => ['text' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
        'failed' => ['text' => 'text-rose-600', 'dot' => 'bg-rose-500'],
    ];
    $priorityLabels = ['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Mendesak'];
    $priorityLevels = ['rendah' => 'Prioritas rendah', 'sedang' => 'Prioritas sedang', 'tinggi' => 'Prioritas tinggi'];
    $statusLabel = $statusLabels[$ticket->status] ?? ucfirst($ticket->status);
    $statusStyle = $statusStyles[$ticket->status] ?? ['text' => 'text-slate-600', 'dot' => 'bg-slate-500'];
    $priorityLabel = $priorityLabels[$ticket->prioritas] ?? ucfirst($ticket->prioritas);
    $priorityLevel = $priorityLevels[$ticket->prioritas] ?? 'Prioritas '.ucfirst($ticket->prioritas);
    $stageCurrent = match ($ticket->status) {
        'open' => 1,
        'confirmed' => 2,
        'process' => 3,
        default => 4,
    };
    $stageNames = ['Laporan dibuat', 'Konfirmasi', 'Perbaikan', $statusLabel];
    $stageTotal = count($stageNames);
    $device = $ticket->device;
    $reporter = $ticket->reporter;
    $backUrl = route('tickets.mine');

    $stages = [
        [
            'no' => 1,
            'state' => 'done',
            'title' => 'Laporan dibuat',
            'time' => $ticket->tanggal?->format('d/m/Y H:i') ?? '-',
            'text' => $ticket->deskripsi ?? 'Tidak ada deskripsi laporan.',
        ],
    ];
    if ($ticket->repairHistory !== null) {
        $stages[] = [
            'no' => 2,
            'state' => 'done',
            'title' => 'Riwayat perbaikan',
            'time' => $ticket->repairHistory->tanggal_selesai?->format('d/m/Y H:i') ?? 'Tanggal belum dicatat',
            'text' => $ticket->repairHistory->tindakan ?? 'Tidak ada catatan tindakan perbaikan.',
        ];
    } elseif ($ticket->status !== 'open') {
        $stages[] = [
            'no' => 2,
            'state' => in_array($ticket->status, ['completed', 'canceled', 'failed'], true) ? 'done' : 'active',
            'title' => 'Status: '.$statusLabel,
            'time' => $ticket->updated_at?->format('d/m/Y H:i') ?? '-',
            'text' => $ticket->catatan ?? 'Belum ada catatan penanganan.',
        ];
    } else {
        $stages[] = [
            'no' => 2,
            'state' => 'pending',
            'title' => 'Menunggu penanganan',
            'time' => '-',
            'text' => $ticket->catatan ?? 'Belum ada catatan penanganan.',
        ];
    }
    $stageLabel = ['done' => 'SELESAI', 'active' => 'SEDANG BERJALAN', 'pending' => 'MENUNGGU'];
    $stageBadge = ['done' => 'bg-emerald-100 text-emerald-700', 'active' => 'bg-[#10254a] text-white', 'pending' => 'bg-slate-200 text-slate-600'];

    $faqs = [
        ['q' => 'Bagaimana cara melaporkan kerusakan perangkat?',        'a' => 'Scan QR Code yang tersedia, kemudian isi formulir laporan dengan menjelaskan kendala yang dialami.'],
        ['q' => 'Bagaimana mengetahui status penanganan?',               'a' => 'Pelapor dapat memantau perkembangan laporan melalui halaman riwayat atau detail tiket pengaduan.'],
        ['q' => 'Berapa lama proses penanganan perangkat?',              'a' => 'Durasi penanganan bergantung pada jenis kerusakan, tingkat prioritas, dan ketersediaan komponen atau sparepart.'],
        ['q' => 'Bagaimana proses setelah perbaikan selesai?',           'a' => 'Teknisi akan memperbarui status penanganan dan mengembalikan perangkat kepada lokasi atau penanggung jawab terkait.'],
        ['q' => 'Bagaimana jika perangkat membutuhkan penanganan darurat?', 'a' => 'Hubungi administrator atau petugas IT terkait untuk mendapatkan tindak lanjut sesuai tingkat urgensi permasalahan.'],
    ];

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
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    $card = 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6';
@endphp

<div x-data="{ sidebarOpen: false, faq: 0 }"
     @keydown.escape.window="sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="tiket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="$reporter->nama" role="User" />

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
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold {{ $statusStyle['text'] }}">
                                <span class="h-2 w-2 rounded-full {{ $statusStyle['dot'] }}"></span> {{ $statusLabel }}
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Prioritas</div>
                            <div class="mt-0.5 flex items-center gap-1.5 text-xs font-bold text-rose-600">
                                <span class="h-2 w-2 rounded-full bg-rose-600"></span> {{ $priorityLabel }}
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
                                    <p class="mt-0.5 text-xs text-slate-400">Kategori : {{ $device->category?->nama ?? 'Tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-slate-300">Subjek : {{ $ticket->judul }}</p>
                                    <p class="mt-2 text-3xl font-extrabold tracking-tight">{{ $ticket->kode_ticket }}</p>
                                    <p class="mt-2 text-[11px] leading-relaxed text-slate-400">
                                        Kerusakan dilaporkan oleh {{ $reporter->nama }} (Divisi {{ $reporter->department?->nama ?? 'Tidak tercatat' }})<br class="hidden sm:inline">
                                        pada {{ $ticket->tanggal?->format('d/m/Y H:i') ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="shrink-0 rounded-xl border border-white/15 bg-white/10 p-4 md:w-64">
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wide text-slate-200">
                                    <span>Tahap Penanganan</span><span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                </div>
                                <p class="mt-1 text-xs font-bold">Tahap {{ $stageCurrent }} dari {{ $stageTotal }} ({{ $stageNames[$stageCurrent - 1] }})</p>
                                <div class="mt-2.5 flex gap-1" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $stageTotal }}" aria-valuenow="{{ $stageCurrent }}">
                                    @for ($i = 1; $i <= $stageTotal; $i++)
                                        <span class="h-1.5 flex-1 rounded-full {{ $i <= $stageCurrent ? 'bg-amber-400' : 'bg-white/20' }}"></span>
                                    @endfor
                                </div>
                                <p class="mt-2 text-[10px] text-slate-300">Status tiket: {{ $statusLabel }}</p>
                            </div>
                        </div>

                        {{-- Spesifikasi --}}
                        <div class="{{ $card }} space-y-6">
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">Spesifikasi &amp; Informasi Lengkap Laporan</h2>
                                <p class="mt-0.5 text-xs text-slate-400">Data terverifikasi otomatis dari master basis data aset P-TAMS</p>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <div class="flex items-center gap-2 text-xs font-medium text-slate-700">{{ $icon('monitor', 'h-4 w-4 text-slate-500') }} Nama Perangkat</div>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $device->nama_device }}</h3>
                                        <p class="text-[11px] text-slate-500"># Serial No : <span class="font-semibold text-slate-700">{{ $device->nomor_seri ?? 'Belum diisi' }}</span></p>
                                        <span class="mt-2 inline-block rounded bg-sky-100 px-2 py-0.5 text-[10px] font-bold text-sky-700">{{ $device->category?->nama ?? 'Tidak tersedia' }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <span class="text-xs font-medium text-slate-700">Lokasi Perangkat</span>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $device->department?->nama ?? 'Tidak tersedia' }}</h3>
                                        <p class="mt-1 text-[11px] leading-snug text-slate-400">{{ $device->department?->lantai ? 'Lantai '.$device->department->lantai : 'Lokasi belum dicatat' }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <span class="text-xs font-medium text-slate-700">Nama Pelapor</span>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $reporter->nama }}</h3>
                                        <p class="mt-1 text-[11px] text-slate-500">Email : <span class="font-medium text-slate-700">{{ $reporter->email }}</span></p>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-between rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <span class="text-xs font-medium text-slate-700">Teknisi</span>
                                    <div class="mt-3">
                                        <h3 class="text-sm font-bold text-slate-900">{{ $ticket->technician?->nama ?? 'Belum ditugaskan' }}</h3>
                                        <p class="mt-1 text-[11px] text-slate-500">{{ $ticket->technician?->email ?? 'Informasi teknisi belum tersedia' }}</p>
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
                                    <p class="text-xs leading-relaxed text-slate-600">{{ $ticket->deskripsi ?? 'Tidak ada deskripsi laporan.' }}</p>
                                </div>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <h3 class="text-xs font-bold text-slate-800">Catatan tiket</h3>
                                <p class="mt-1 text-xs leading-relaxed text-slate-600">{{ $ticket->catatan ?? 'Belum ada catatan tambahan.' }}</p>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-800">{{ $icon('clip', 'h-4 w-4 text-slate-500') }} Foto Lampiran</div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    @forelse ($photoUrls as $photoUrl)
                                        <a href="{{ $photoUrl }}" target="_blank" rel="noopener noreferrer"
                                           class="group flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 p-3 transition-colors hover:border-slate-300 hover:bg-white">
                                            <span class="flex min-w-0 items-center gap-3">
                                                <img src="{{ $photoUrl }}" alt="Foto lampiran tiket {{ $ticket->kode_ticket }}"
                                                     class="h-14 w-14 shrink-0 rounded-lg border border-slate-200 object-cover">
                                                <span class="block truncate text-xs font-bold text-slate-800 group-hover:text-blue-600">Lampiran {{ $loop->iteration }}</span>
                                            </span>
                                            <span class="shrink-0 pl-2 text-slate-400 group-hover:text-blue-600" title="Buka foto">{{ $icon('download') }}</span>
                                        </a>
                                    @empty
                                        <p class="text-xs text-slate-500">Belum ada foto lampiran.</p>
                                    @endforelse
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

                        {{-- Ringkasan tiket --}}
                        <div class="{{ $card }} space-y-5">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Ringkasan Tiket</h3>
                                <span class="rounded bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-600">PRIVAT</span>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                                <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-xl border border-slate-100 bg-white text-[#10254a] shadow-sm">
                                    {{ $icon('ticket', 'h-10 w-10') }}
                                </span>
                                <div class="mt-4">
                                    <h4 class="text-xs font-extrabold tracking-wider text-slate-800">{{ $ticket->kode_ticket }}</h4>
                                    <p class="mx-auto mt-1 max-w-[220px] text-[10px] leading-relaxed text-slate-500">Informasi tiket ini hanya tersedia untuk pengguna yang berwenang.</p>
                                </div>
                            </div>

                            <div class="space-y-3 pt-1 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Nomor Registrasi :</span>
                                    <span class="font-bold text-slate-900">{{ $ticket->kode_ticket }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Prioritas Respon :</span>
                                    <span class="rounded-md border border-rose-500 px-3 py-1 text-[11px] font-bold text-rose-600">{{ $priorityLevel }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="font-medium text-slate-600">Teknisi :</span>
                                    <span class="font-bold text-slate-900">{{ $ticket->technician?->nama ?? 'Belum ditugaskan' }}</span>
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

    {{-- Pop up scan QR (dibuka dari tombol "Mulai Scan QR" di sidebar) --}}
    <x-qr-scan-modal />
</div>
@endsection