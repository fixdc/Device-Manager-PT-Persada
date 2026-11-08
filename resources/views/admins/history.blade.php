@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data dari controller ($records).
     * Tanggal ditulis tanpa zona waktu (YYYY-MM-DDTHH:mm:ss).
     */
    $records = [
        ['id' => '#TC-001', 'date' => '2025-11-03T14:30:00', 'device' => 'ASUS ROG',             'deviceCode' => 'LAP-ROG-001', 'location' => 'Lantai 3 - Ruang Meeting A', 'subject' => 'Layar berkedip',        'status' => 'Selesai',  'category' => 'Hardware',                       'urgency' => 'Urgent', 'reporter' => 'Andi Pratama',  'division' => 'POKJA - PPDP',           'technician' => 'Siti Aisyah',   'finishedAt' => '2025-11-04T10:15:00', 'complaint' => 'Layar laptop berkedip terus saat dipakai, terutama ketika kecerahan dinaikkan.',       'handling' => 'Kabel fleksibel layar diganti dan driver grafis diperbarui. Layar sudah normal setelah diuji 1 jam.'],
        ['id' => '#TC-002', 'date' => '2025-11-01T09:15:00', 'device' => 'Epson L3310',          'deviceCode' => 'PRN-EPS-002', 'location' => 'Lantai 2 - Ruang Arsip',     'subject' => 'Tidak bisa ngeprint',  'status' => 'Diproses', 'category' => 'Printer & Scanner',             'urgency' => 'Sedang', 'reporter' => 'Dewi Lestari',  'division' => 'POKJA - PPDP',           'technician' => 'Rina Wulandari','finishedAt' => null,                  'complaint' => 'Printer menyala tetapi dokumen tidak keluar, muncul lampu indikator tinta berkedip.',    'handling' => 'Sedang dilakukan pembersihan head printer dan pengecekan tinta.'],
        ['id' => '#TC-003', 'date' => '2025-10-28T16:20:00', 'device' => 'PC Server',            'deviceCode' => 'SRV-PC-003',  'location' => 'Ruang Server A',             'subject' => 'Restart sendiri',      'status' => 'Selesai',  'category' => 'Hardware',                       'urgency' => 'Urgent', 'reporter' => 'Budi Santoso',  'division' => 'Keuangan & Logistik',    'technician' => 'Siti Aisyah',   'finishedAt' => '2025-10-29T11:00:00', 'complaint' => 'Server restart sendiri beberapa kali dalam sehari tanpa pesan error.',                'handling' => 'Power supply diganti baru dan dilakukan uji beban selama 2 jam tanpa restart.'],
        ['id' => '#TC-004', 'date' => '2025-10-25T11:10:00', 'device' => 'Monitor LG',           'deviceCode' => 'MNT-LG-004',  'location' => 'Lantai 6 - Ruang PPDP',      'subject' => 'Layar gelap',          'status' => 'Pending',  'category' => 'Hardware',                       'urgency' => 'Sedang', 'reporter' => 'Rina Anggraini','division' => 'POKJA - PPDP',           'technician' => null,            'finishedAt' => null,                  'complaint' => 'Monitor menyala (lampu indikator hidup) tetapi layar tetap gelap.',                       'handling' => null],
        ['id' => '#TC-005', 'date' => '2025-10-22T13:45:00', 'device' => 'PS5',                  'deviceCode' => 'GAM-PS5-001', 'location' => 'Lantai 1 - Ruang Rekreasi',  'subject' => 'Baterai cepat habis',  'status' => 'Selesai',  'category' => 'Listrik / Peralatan Pendukung',  'urgency' => 'Rendah', 'reporter' => 'Dewi Puspita',  'division' => 'Operasional Kantor',     'technician' => 'Rina Wulandari','finishedAt' => '2025-10-23T09:30:00', 'complaint' => 'Daya perangkat cepat habis walaupun hanya dipakai sebentar.',                           'handling' => 'Pengaturan daya dioptimalkan dan kabel pengisi daya diganti.'],
        ['id' => '#TC-006', 'date' => '2025-10-20T08:05:00', 'device' => 'Router Mikrotik RB4011','deviceCode' => 'RTR-MKT-001', 'location' => 'Ruang Server A',             'subject' => 'Internet sering putus','status' => 'Selesai',  'category' => 'Jaringan / Internet',            'urgency' => 'Urgent', 'reporter' => 'Andi Pratama',  'division' => 'POKJA - PPDP',           'technician' => 'Siti Aisyah',   'finishedAt' => '2025-10-20T15:40:00', 'complaint' => 'Koneksi internet putus-putus setiap beberapa menit di seluruh lantai.',                 'handling' => 'Firmware router diperbarui dan konfigurasi channel Wi-Fi disesuaikan.'],
        ['id' => '#TC-007', 'date' => '2025-10-18T10:25:00', 'device' => 'UPS APC Smart-UPS 1500','deviceCode' => 'UPS-APC-001', 'location' => 'Data Center',                'subject' => 'Alarm bunyi terus',    'status' => 'Diproses', 'category' => 'Listrik / Peralatan Pendukung',  'urgency' => 'Sedang', 'reporter' => 'Budi Santoso',  'division' => 'Keuangan & Logistik',    'technician' => 'Rina Wulandari','finishedAt' => null,                  'complaint' => 'UPS berbunyi terus-menerus dan indikator baterai berwarna merah.',                        'handling' => 'Baterai sedang diuji kapasitasnya, penggantian menunggu persetujuan.'],
        ['id' => '#TC-008', 'date' => '2025-10-15T14:50:00', 'device' => 'Scanner Canon DR-C240','deviceCode' => 'SCN-CNN-001', 'location' => 'Lantai 3 - Ruang Arsip',     'subject' => 'Hasil scan bergaris',  'status' => 'Selesai',  'category' => 'Printer & Scanner',              'urgency' => 'Rendah', 'reporter' => 'Dewi Lestari',  'division' => 'POKJA - PPDP',           'technician' => 'Siti Aisyah',   'finishedAt' => '2025-10-16T10:00:00', 'complaint' => 'Hasil pindaian selalu muncul garis vertikal di tengah halaman.',                       'handling' => 'Kaca scanner dan roller dibersihkan, kalibrasi ulang dilakukan.'],
        ['id' => '#TC-009', 'date' => '2025-10-13T09:40:00', 'device' => 'Laptop Acer',          'deviceCode' => 'LAP-ACR-001', 'location' => 'Ruang Meeting A',            'subject' => 'Mati saat dicas',      'status' => 'Pending',  'category' => 'Hardware',                       'urgency' => 'Urgent', 'reporter' => 'Rina Anggraini','division' => 'POKJA - PPDP',           'technician' => null,            'finishedAt' => null,                  'complaint' => 'Laptop mati mendadak setiap kali charger dicolokkan.',                                    'handling' => null],
        ['id' => '#TC-010', 'date' => '2025-10-10T15:15:00', 'device' => 'AC Ruangan',           'deviceCode' => 'AC-RM-001',   'location' => 'Lantai 2 - Ruang Rapat',     'subject' => 'Tidak dingin',         'status' => 'Selesai',  'category' => 'Listrik / Peralatan Pendukung',  'urgency' => 'Rendah', 'reporter' => 'Dewi Puspita',  'division' => 'Operasional Kantor',     'technician' => 'Rina Wulandari','finishedAt' => '2025-10-11T13:20:00', 'complaint' => 'AC menyala tetapi udara yang keluar tidak dingin.',                                    'handling' => 'Freon ditambah dan filter udara dibersihkan.'],
    ];

    // Halaman detail lengkap (sementara semua tiket menuju halaman yang sama)
    $detailUrl = url('/admin/ticket/detail');

    // Path ikon (Heroicons outline)
    $ic = [
        'search'   => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'eye'      => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'refresh'  => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
        'pdf'      => 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
        'close'    => 'M6 18L18 6M6 6l12 12',
        'external' => 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
        'inbox'    => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
        'clip'     => 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    $selectClass = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
@endphp

{{-- Ukuran kertas saat Export PDF / cetak --}}
<style>
    @media print {
        @page { size: A4 landscape; margin: 12mm; }
        #print-area { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>

<div x-data="historyPage(@js($records), @js($detailUrl))"
     @keydown.escape.window="detail = null; sidebarOpen = false">

    {{-- ============ TAMPILAN LAYAR ============ --}}
    <div class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800 print:hidden">

        {{-- Sidebar admin --}}
        <x-sidebar role="admin" active="riwayat" />

        <div class="flex min-w-0 flex-1 flex-col">
            <x-navbar name="Fikri" role="Admin" />

            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

                {{-- Judul + Export --}}
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Riwayat Kerusakan</h1>
                        <p class="mt-1 text-sm text-slate-600">Daftar laporan kerusakan perangkat yang pernah anda buat</p>
                    </div>
                    <button type="button" @click="exportList()" :disabled="filtered.length === 0"
                            class="inline-flex shrink-0 items-center justify-center gap-2 self-start rounded-lg border border-[#10254a] bg-white px-4 py-2.5 text-sm font-semibold text-[#10254a] transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">
                        {{ $icon('pdf') }} Export PDF
                    </button>
                </div>

                {{-- Filter --}}
                <div class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-[1fr_12rem_12rem_9rem]">
                    <div class="relative sm:col-span-2 lg:col-span-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('search') }}</span>
                        <input type="search" x-model.debounce.200ms="search" placeholder="Cari riwayat kerusakan..."
                               class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    <select x-model="period" aria-label="Periode" class="{{ $selectClass }}">
                        <option value="">Pilih Periode</option>
                        <template x-for="p in periods" :key="p.key"><option :value="p.key" x-text="p.label"></option></template>
                    </select>

                    <select x-model="status" aria-label="Status" class="{{ $selectClass }}">
                        <option value="">Semua Status</option>
                        <option>Selesai</option>
                        <option>Diproses</option>
                        <option>Pending</option>
                    </select>

                    <button type="button" @click="refresh()" :disabled="refreshing"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#0b1b3a] disabled:opacity-70 sm:col-span-2 lg:col-span-1">
                        <span :class="refreshing ? 'animate-spin' : ''">{{ $icon('refresh') }}</span>
                        Refresh
                    </button>
                </div>

                {{-- Tabel --}}
                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div x-show="filtered.length === 0" x-cloak class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-8 w-8') }}</div>
                        <h3 class="text-base font-bold text-slate-800">Tidak ada riwayat ditemukan</h3>
                        <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah kata kunci pencarian, periode, atau status.</p>
                        <button type="button" @click="resetFilters()" class="mt-4 rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-200">Reset filter</button>
                    </div>

                    <div x-show="filtered.length > 0" class="overflow-x-auto">
                        <table class="w-full min-w-[820px] border-collapse text-left">
                            <thead>
                                <tr class="border-b border-slate-200 bg-[#f1f5f9] text-sm font-semibold text-slate-900">
                                    <th scope="col" class="px-5 py-4 text-center">No</th>
                                    <th scope="col" class="px-5 py-4">ID Tiket</th>
                                    <th scope="col" class="px-5 py-4">Tanggal Laporan</th>
                                    <th scope="col" class="px-5 py-4">Perangkat</th>
                                    <th scope="col" class="px-5 py-4">Subjek</th>
                                    <th scope="col" class="px-5 py-4 text-center">Status</th>
                                    <th scope="col" class="px-5 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                                <template x-for="(r, i) in pageRows" :key="r.id">
                                    <tr class="transition-colors hover:bg-slate-50/70">
                                        <td class="px-5 py-4 text-center" x-text="(page - 1) * perPage + i + 1"></td>
                                        <td class="px-5 py-4">
                                            <button type="button" @click="detail = r" x-text="r.id"
                                                    class="rounded font-medium transition-colors hover:text-blue-600 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40"></button>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-4" x-text="fmt(r.date)"></td>
                                        <td class="px-5 py-4" x-text="r.device"></td>
                                        <td class="px-5 py-4" x-text="r.subject"></td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-block min-w-[5.5rem] rounded-md px-3 py-1.5 text-xs font-semibold" :class="statusStyle[r.status]" x-text="r.status"></span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <button type="button" @click="detail = r"
                                                    class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-md border border-[#10254a] px-3.5 py-1.5 text-xs font-semibold text-[#10254a] transition-colors hover:bg-slate-50">
                                                {{ $icon('eye', 'h-3.5 w-3.5') }} Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginasi --}}
                    <div x-show="filtered.length > 0" class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-4 py-4 text-xs font-medium text-slate-600 sm:flex-row sm:px-6 sm:text-sm">
                        <span x-text="`Menampilkan ${rangeFrom} - ${rangeTo} dari ${filtered.length} riwayat`"></span>
                        <div class="flex items-center gap-1.5">
                            <button type="button" @click="page--" :disabled="page <= 1"
                                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Sebelumnya</button>
                            <template x-for="p in totalPages" :key="p">
                                <button type="button" @click="page = p" :aria-current="p === page ? 'page' : null"
                                        class="h-8 min-w-[2rem] rounded-lg px-2 font-semibold transition-colors"
                                        :class="p === page ? 'bg-[#10254a] text-white' : 'text-slate-700 hover:bg-slate-100'" x-text="p"></button>
                            </template>
                            <button type="button" @click="page++" :disabled="page >= totalPages"
                                    class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Selanjutnya</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- ============ POP UP DETAIL KERUSAKAN ============ --}}
    <div x-show="detail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 print:hidden" role="dialog" aria-modal="true" aria-labelledby="detail-title">
        <div x-show="detail" x-transition.opacity @click="detail = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="detail" x-transition class="relative flex max-h-[92vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <template x-if="detail">
                <div class="flex min-h-0 flex-1 flex-col">

                    {{-- Header --}}
                    <div class="flex shrink-0 items-start justify-between gap-3 border-b border-slate-100 p-5 sm:p-7">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <h3 id="detail-title" class="text-xl font-bold text-slate-900 sm:text-2xl">Detail Kerusakan</h3>
                                <span class="rounded-md px-2.5 py-1 text-xs font-semibold" :class="statusStyle[detail.status]" x-text="detail.status"></span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                                <span class="font-semibold text-slate-700" x-text="detail.id"></span>
                                &middot; <span x-text="detail.subject"></span>
                            </p>
                        </div>
                        <button type="button" @click="detail = null" class="shrink-0 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                    </div>

                    {{-- Isi --}}
                    <div class="min-h-0 flex-1 space-y-5 overflow-y-auto p-5 sm:p-7">
                        <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <template x-for="item in detailFields(detail)" :key="item.label">
                                <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3.5">
                                    <dt class="text-[11px] font-medium text-slate-500" x-text="item.label"></dt>
                                    <dd class="mt-1 text-sm font-semibold text-slate-900" x-text="item.value"></dd>
                                    <dd x-show="item.sub" class="mt-0.5 text-[11px] text-slate-500" x-text="item.sub"></dd>
                                </div>
                            </template>
                        </dl>

                        <div>
                            <h4 class="mb-1.5 text-xs font-bold text-slate-800">Keluhan</h4>
                            <p class="rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700" x-text="detail.complaint"></p>
                        </div>

                        <div>
                            <h4 class="mb-1.5 text-xs font-bold text-slate-800">Penanganan / Perbaikan</h4>
                            <p class="rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed"
                               :class="detail.handling ? 'text-slate-700' : 'italic text-slate-400'"
                               x-text="detail.handling || 'Belum ada catatan penanganan.'"></p>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex shrink-0 flex-col-reverse items-stretch justify-end gap-2.5 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-7">
                        <button type="button" @click="detail = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</button>
                        <button type="button" @click="exportDetail()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#10254a] px-5 py-2.5 text-sm font-semibold text-[#10254a] hover:bg-slate-50">
                            {{ $icon('pdf') }} Export PDF
                        </button>
                        <a :href="detailUrl" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a]">
                            {{ $icon('external') }} Halaman Detail
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed right-5 top-5 z-[100] rounded-xl border border-slate-700 bg-[#10254a] px-4 py-3 text-sm font-medium text-white shadow-lg print:hidden" role="status" aria-live="polite">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ AREA CETAK / PDF (hanya terlihat saat print) ============ --}}
    <div id="print-area" class="hidden text-slate-900 print:block">

        {{-- Mode daftar --}}
        <div x-show="printMode === 'list'" x-cloak>
            <div class="mb-4 flex items-start justify-between border-b-2 border-slate-800 pb-3">
                <div>
                    <h1 class="text-xl font-bold">Laporan Riwayat Kerusakan Perangkat</h1>
                    <p class="text-xs text-slate-600">P-TAMS &middot; Dinas Sosial Kota Tangerang Selatan</p>
                </div>
                <div class="text-right text-[11px] text-slate-600">
                    <div>Dicetak: <span x-text="printedAt"></span></div>
                    <div>Oleh: Fikri (Admin)</div>
                </div>
            </div>

            <p class="mb-3 text-[11px] text-slate-700" x-text="filterSummary"></p>

            <table class="w-full border-collapse text-left text-[11px]">
                <thead>
                    <tr class="bg-slate-200 font-bold">
                        <th class="border border-slate-400 px-2 py-1.5 text-center">No</th>
                        <th class="border border-slate-400 px-2 py-1.5">ID Tiket</th>
                        <th class="border border-slate-400 px-2 py-1.5">Tanggal Laporan</th>
                        <th class="border border-slate-400 px-2 py-1.5">Perangkat</th>
                        <th class="border border-slate-400 px-2 py-1.5">Subjek</th>
                        <th class="border border-slate-400 px-2 py-1.5">Pelapor</th>
                        <th class="border border-slate-400 px-2 py-1.5">Teknisi</th>
                        <th class="border border-slate-400 px-2 py-1.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(r, i) in filtered" :key="'p' + r.id">
                        <tr class="break-inside-avoid">
                            <td class="border border-slate-300 px-2 py-1.5 text-center" x-text="i + 1"></td>
                            <td class="border border-slate-300 px-2 py-1.5 font-semibold" x-text="r.id"></td>
                            <td class="whitespace-nowrap border border-slate-300 px-2 py-1.5" x-text="fmt(r.date)"></td>
                            <td class="border border-slate-300 px-2 py-1.5" x-text="r.device"></td>
                            <td class="border border-slate-300 px-2 py-1.5" x-text="r.subject"></td>
                            <td class="border border-slate-300 px-2 py-1.5" x-text="r.reporter"></td>
                            <td class="border border-slate-300 px-2 py-1.5" x-text="r.technician || '-'"></td>
                            <td class="border border-slate-300 px-2 py-1.5 text-center font-semibold" x-text="r.status"></td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <p class="mt-3 text-[11px] text-slate-700" x-text="`Total ${filtered.length} laporan: ${countBy('Selesai')} selesai, ${countBy('Diproses')} diproses, ${countBy('Pending')} pending.`"></p>
        </div>

        {{-- Mode detail satu laporan --}}
        <div x-show="printMode === 'detail' && printItem" x-cloak>
            <template x-if="printItem">
                <div>
                    <div class="mb-5 flex items-start justify-between border-b-2 border-slate-800 pb-3">
                        <div>
                            <h1 class="text-xl font-bold">Detail Laporan Kerusakan</h1>
                            <p class="text-xs text-slate-600">P-TAMS &middot; Dinas Sosial Kota Tangerang Selatan</p>
                        </div>
                        <div class="text-right text-[11px] text-slate-600">
                            <div>Dicetak: <span x-text="printedAt"></span></div>
                            <div>Oleh: Fikri (Admin)</div>
                        </div>
                    </div>

                    <div class="mb-4 flex items-center gap-3">
                        <span class="text-lg font-bold" x-text="printItem.id"></span>
                        <span class="rounded px-2.5 py-0.5 text-xs font-semibold" :class="statusStyle[printItem.status]" x-text="printItem.status"></span>
                        <span class="text-sm text-slate-700" x-text="printItem.subject"></span>
                    </div>

                    <table class="mb-5 w-full border-collapse text-left text-xs">
                        <tbody>
                            <template x-for="item in detailFields(printItem)" :key="'d' + item.label">
                                <tr class="break-inside-avoid">
                                    <th class="w-1/3 border border-slate-300 bg-slate-100 px-3 py-2 font-semibold" x-text="item.label"></th>
                                    <td class="border border-slate-300 px-3 py-2">
                                        <span x-text="item.value"></span>
                                        <span x-show="item.sub" class="block text-[10px] text-slate-500" x-text="item.sub"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <div class="mb-4 break-inside-avoid">
                        <h2 class="mb-1 text-xs font-bold">Keluhan</h2>
                        <p class="rounded border border-slate-300 p-3 text-xs leading-relaxed" x-text="printItem.complaint"></p>
                    </div>
                    <div class="break-inside-avoid">
                        <h2 class="mb-1 text-xs font-bold">Penanganan / Perbaikan</h2>
                        <p class="rounded border border-slate-300 p-3 text-xs leading-relaxed" x-text="printItem.handling || 'Belum ada catatan penanganan.'"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('historyPage', (records, detailUrl) => ({
            sidebarOpen: false,
            records,
            detailUrl,

            search: '',
            period: '',
            status: '',
            page: 1,
            perPage: 8,
            refreshing: false,

            detail: null,           // laporan yang sedang dibuka di pop up
            printMode: null,        // 'list' | 'detail' | null
            printItem: null,
            printedAt: '',
            toastMsg: '',
            toastTimer: null,

            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            monthsLong:  ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

            statusStyle: {
                Selesai:  'bg-green-100 text-green-700',
                Diproses: 'bg-yellow-100 text-yellow-700',
                Pending:  'bg-rose-100 text-rose-600',
            },

            init() {
                // Filter berubah -> kembali ke halaman 1
                this.$watch('search', () => this.page = 1);
                this.$watch('period', () => this.page = 1);
                this.$watch('status', () => this.page = 1);
            },

            // ---------- Format ----------
            pad(n) { return String(n).padStart(2, '0'); },
            fmt(iso, withTime = true) {
                if (!iso) return '-';
                const d = new Date(iso);
                const date = `${this.pad(d.getDate())} ${this.monthsShort[d.getMonth()]} ${d.getFullYear()}`;
                return withTime ? `${date}, ${this.pad(d.getHours())}:${this.pad(d.getMinutes())}` : date;
            },
            stamp() {
                const d = new Date();
                return `${d.getFullYear()}-${this.pad(d.getMonth() + 1)}-${this.pad(d.getDate())}`;
            },

            // ---------- Data turunan ----------
            get periods() {
                const keys = [...new Set(this.records.map(r => r.date.slice(0, 7)))].sort().reverse();
                return keys.map(k => {
                    const [y, m] = k.split('-');
                    return { key: k, label: `${this.monthsLong[Number(m) - 1]} ${y}` };
                });
            },
            get filtered() {
                const q = this.search.trim().toLowerCase();
                return this.records.filter(r =>
                    (!this.period || r.date.startsWith(this.period)) &&
                    (!this.status || r.status === this.status) &&
                    (!q || [r.id, r.device, r.deviceCode, r.subject, r.reporter].some(v => (v || '').toLowerCase().includes(q)))
                );
            },
            get totalPages() { return Math.max(1, Math.ceil(this.filtered.length / this.perPage)); },
            get pageRows()   { const s = (this.page - 1) * this.perPage; return this.filtered.slice(s, s + this.perPage); },
            get rangeFrom()  { return this.filtered.length ? (this.page - 1) * this.perPage + 1 : 0; },
            get rangeTo()    { return Math.min(this.page * this.perPage, this.filtered.length); },
            countBy(status)  { return this.filtered.filter(r => r.status === status).length; },

            get filterSummary() {
                const p = this.periods.find(x => x.key === this.period);
                return `Filter: Periode ${p ? p.label : 'semua'}, Status ${this.status || 'semua'}` + (this.search.trim() ? `, Kata kunci "${this.search.trim()}"` : '');
            },

            detailFields(r) {
                return [
                    { label: 'Tanggal Laporan',  value: this.fmt(r.date) },
                    { label: 'Perangkat',        value: r.device, sub: `${r.deviceCode} · ${r.location}` },
                    { label: 'Kategori',         value: r.category },
                    { label: 'Urgensi',          value: r.urgency },
                    { label: 'Pelapor',          value: r.reporter, sub: r.division },
                    { label: 'Teknisi',          value: r.technician || 'Belum ditugaskan' },
                    { label: 'Tanggal Selesai',  value: r.finishedAt ? this.fmt(r.finishedAt) : 'Belum selesai' },
                ];
            },

            // ---------- Aksi ----------
            resetFilters() { this.search = ''; this.period = ''; this.status = ''; },

            // Frontend saja. Nanti: muat ulang data dari server (mis. window.location.reload()).
            refresh() {
                if (this.refreshing) return;
                this.refreshing = true;
                this.resetFilters();
                setTimeout(() => { this.refreshing = false; this.toast('Data riwayat diperbarui.'); }, 600);
            },

            toast(msg) {
                this.toastMsg = msg;
                clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMsg = '', 3500);
            },

            // ---------- Export PDF (lewat dialog cetak browser: pilih "Save as PDF") ----------
            exportList() {
                if (!this.filtered.length) return;
                this.printMode = 'list';
                this.printItem = null;
                this.print(`Riwayat-Kerusakan-${this.stamp()}`);
            },
            exportDetail() {
                if (!this.detail) return;
                this.printMode = 'detail';
                this.printItem = this.detail;
                this.print(`Detail-Kerusakan-${this.detail.id.replace('#', '')}`);
            },
            print(filename) {
                const d = new Date();
                this.printedAt = `${this.pad(d.getDate())} ${this.monthsShort[d.getMonth()]} ${d.getFullYear()}, ${this.pad(d.getHours())}:${this.pad(d.getMinutes())} WIB`;

                // Nama file default di dialog "Save as PDF" mengikuti judul halaman
                const prevTitle = document.title;
                document.title = filename;
                const restore = () => {
                    document.title = prevTitle;
                    this.printMode = null;
                    this.printItem = null;
                    window.removeEventListener('afterprint', restore);
                };
                window.addEventListener('afterprint', restore);

                this.$nextTick(() => window.print());
            },
        }));
    });
</script>
@endsection