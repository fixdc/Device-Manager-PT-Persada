@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only) - 3 device.
     * Nanti ganti dengan data dari controller, mis: @foreach ($devices as $device)
     * 'operator', 'damages' (riwayat kerusakan) dan 'tickets' (riwayat tiket) ikut diambil dari relasi device.
     */
    $devices = [
        [
            'id' => 1, 'kode' => 'DV-2024-001', 'kode1' => 'MNTR', 'kode2' => 'PPDP', 'kode3' => '001', 'nama' => 'Monitor LG 14 Inch', 'jenis' => 'Monitor', 'kategori' => 'MNTR', 'sn' => 'SN-8438291809281092', 'status' => 'aktif', 'tanggal' => '12 Oktober 2024',
            'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Lantai 6', 'pj' => 'Budi Santoso',
            'spesifikasi' => 'Resolusi 1920x1080 144Hz IPS Panel, Port HDMI & DisplayPort, Garansi distributor hingga Oktober 2026.',
            'operator' => ['nama' => 'Budi Santoso', 'divisi' => 'POKJA - PPDP', 'telepon' => '0852-3341-9012'],
            'damages' => [
                ['tanggal' => '03 Nov 2025', 'judul' => 'Layar berkedip', 'penyebab' => 'Kabel fleksibel layar longgar', 'penanganan' => 'Kabel diganti dan driver grafis diperbarui. Layar normal setelah diuji 1 jam.', 'teknisi' => 'Siti Aisyah', 'status' => 'Selesai'],
            ],
            'tickets' => [
                ['kode' => '#TC-001', 'tanggal' => '03 Nov 2025, 14:30', 'subjek' => 'Layar berkedip',   'urgensi' => 'Urgent', 'status' => 'Selesai'],
                ['kode' => '#TC-004', 'tanggal' => '25 Okt 2025, 11:10', 'subjek' => 'Layar gelap sesaat', 'urgensi' => 'Sedang', 'status' => 'Selesai'],
            ],
        ],
        [
            'id' => 2, 'kode' => 'DV-2024-003', 'kode1' => 'SCN', 'kode2' => 'PPDP', 'kode3' => '003', 'nama' => 'Scanner Canon DR-C240', 'jenis' => 'Scanner', 'kategori' => 'SCN', 'sn' => 'SN-5521903847261', 'status' => 'rusak', 'tanggal' => '15 Oktober 2024',
            'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Lantai 3', 'pj' => 'Dewi Lestari',
            'spesifikasi' => '',
            'operator' => ['nama' => 'Dewi Lestari', 'divisi' => 'POKJA - PPDP', 'telepon' => '0819-4456-1188'],
            'damages' => [
                ['tanggal' => '02 Nov 2025', 'judul' => 'Roller penarik kertas aus',  'penyebab' => 'Pemakaian harian tinggi',        'penanganan' => 'Menunggu pengadaan roller pengganti.',                 'teknisi' => 'Rina Wulandari', 'status' => 'Pending'],
                ['tanggal' => '15 Okt 2025', 'judul' => 'Hasil scan bergaris',        'penyebab' => 'Kaca scanner kotor',             'penanganan' => 'Kaca dan roller dibersihkan, kalibrasi ulang dilakukan.', 'teknisi' => 'Siti Aisyah',    'status' => 'Selesai'],
            ],
            'tickets' => [
                ['kode' => '#TC-011', 'tanggal' => '02 Nov 2025, 08:50', 'subjek' => 'Kertas tidak tertarik',  'urgensi' => 'Sedang', 'status' => 'Pending'],
                ['kode' => '#TC-008', 'tanggal' => '15 Okt 2025, 14:50', 'subjek' => 'Hasil scan bergaris',    'urgensi' => 'Rendah', 'status' => 'Selesai'],
            ],
        ],
        [
            'id' => 3, 'kode' => 'DV-2024-002', 'kode1' => 'PRN', 'kode2' => 'PPDP', 'kode3' => '002', 'nama' => 'Printer Epson L380', 'jenis' => 'Printer', 'kategori' => 'PRN', 'sn' => 'SN-3309182746550', 'status' => 'perbaikan', 'tanggal' => '14 Oktober 2024',
            'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Ruang Server A', 'pj' => 'Rina Wulandari',
            'spesifikasi' => '',
            'operator' => ['nama' => 'Rina Wulandari', 'divisi' => 'Teknik & Infrastruktur', 'telepon' => '0821-5542-1200'],
            'damages' => [
                ['tanggal' => '01 Nov 2025', 'judul' => 'Head printer tersumbat', 'penyebab' => 'Tinta mengering karena lama tidak dipakai', 'penanganan' => 'Sedang dilakukan pembersihan head dan pengecekan tinta.', 'teknisi' => 'Rina Wulandari', 'status' => 'Diproses'],
            ],
            'tickets' => [
                ['kode' => '#TC-002', 'tanggal' => '01 Nov 2025, 09:15', 'subjek' => 'Tidak bisa ngeprint', 'urgensi' => 'Sedang', 'status' => 'Diproses'],
            ],
        ],
    ];

    // Label & warna per status
    $statusMap = [
        'aktif'     => ['label' => 'Aktif',     'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500'],
        'perbaikan' => ['label' => 'Perbaikan', 'text' => 'text-amber-500',   'dot' => 'bg-amber-500'],
        'rusak'     => ['label' => 'Rusak',     'text' => 'text-rose-500',    'dot' => 'bg-rose-500'],
    ];

    // Path ikon per jenis device (Heroicons outline)
    $typeIcons = [
        'Monitor' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'Printer' => 'M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z',
        'Scanner' => 'M4 7V5a1 1 0 011-1h2m10 0h2a1 1 0 011 1v2m0 10v2a1 1 0 01-1 1h-2M7 20H5a1 1 0 01-1-1v-2m0-5h16',
    ];

    // Ikon lain
    $ic = [
        'edit'    => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
        'trash'   => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'close'   => 'M6 18L18 6M6 6l12 12',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        'phone'   => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
        'pin'     => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
        'inbox'   => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
        'external'=> 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    // Halaman detail tiket (sementara semua tiket menuju halaman yang sama)
    $ticketUrl = url('/admin/ticket/detail');
@endphp

<div x-data="devicesPage(@js($devices), @js($ticketUrl))"
     @keydown.escape.window="modalOpen = false; detail = null; confirmTarget = null; sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar (components/sidebar.blade.php) --}}
    <x-sidebar active="device" />

    {{-- ============ KONTEN UTAMA ============ --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Navbar (components/navbar.blade.php) --}}
        <x-navbar name="Fikri" role="Admin" />

        {{-- Area scroll --}}
        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul + tombol Tambah --}}
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Device Manager</h1>
                    <p class="mt-1 text-sm text-slate-600">Pantau dan kelola seluruh perangkat disini</p>
                </div>
                <button @click="openAdd()" class="flex shrink-0 items-center gap-2 rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </button>
            </div>

            {{-- Kartu statistik (ikut berubah saat ada perangkat yang dihapus) --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="relative flex items-center gap-4 overflow-hidden rounded-lg bg-[#10254a] p-5 text-white shadow-sm">
                    <div class="flex h-20 w-14 shrink-0 rotate-[-8deg] items-center justify-center rounded-xl border border-rose-300/30 bg-rose-400/25">
                        <svg class="h-8 w-8 text-rose-200" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm8-2h2v2h-2v-2zm4 0h4v2h-4v-2zm-4 4h2v4h-2v-4zm4 2h4v2h-4v-2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-200">Total Perangkat</p>
                        <h2 class="mt-1 text-3xl font-bold" x-text="count('total')"></h2>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Aktif</p>
                            <h2 class="mt-1 text-2xl font-bold text-slate-900" x-text="count('aktif')"></h2>
                        </div>
                        <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-500">Seluruh tiket masuk</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Perbaikan</p>
                            <h2 class="mt-1 text-2xl font-bold text-slate-900" x-text="count('perbaikan')"></h2>
                        </div>
                        <div class="rounded-lg bg-amber-50 p-2 text-amber-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-500">Tiket belum ditangani</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Sedang Diperbaiki</p>
                            <h2 class="mt-1 text-2xl font-bold text-slate-900" x-text="count('rusak')"></h2>
                        </div>
                        <div class="rounded-lg bg-rose-50 p-2 text-rose-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-500">Tiket dalam proses perbaikan</p>
                </div>
            </div>

            {{-- Pencarian & filter --}}
            <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="relative w-full md:max-w-3xl md:flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" placeholder="Lakukan pencarian..." class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                </div>
                <div class="flex w-full gap-3 md:w-auto">
                    <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#10254a] md:w-36">
                        <option>Type</option>
                    </select>
                    <select class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#10254a] md:w-36">
                        <option>Sort By</option>
                    </select>
                </div>
            </div>

            {{-- Daftar device (klik kartu untuk melihat detail) --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($devices as $device)
                    @php $st = $statusMap[$device['status']]; @endphp
                    <div x-show="!isDeleted({{ $device['id'] }})" @click="openDetail({{ $device['id'] }})"
                         class="cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                        {{-- Header kartu --}}
                        <div class="flex items-center gap-3 bg-[#ececec] px-4 py-3">
                            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$device['jenis']] ?? $typeIcons['Monitor'] }}"/></svg>
                            <h3 class="min-w-0 flex-1 truncate text-base font-bold text-slate-800">
                                <button type="button" @click.stop="openDetail({{ $device['id'] }})" class="max-w-full truncate rounded text-left hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40" aria-label="Lihat detail {{ $device['nama'] }}">{{ $device['nama'] }}</button>
                            </h3>
                        </div>

                        {{-- Isi kartu --}}
                        <div class="p-4">
                            <div class="mb-4 flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-[11px] text-slate-500">Kode Device</p>
                                    <div class="mt-1 flex items-center gap-1.5 text-sm font-medium text-slate-800">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        {{ $device['kode'] }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[11px] text-slate-500">Jenis Device</p>
                                    <div class="mt-1 flex items-center justify-end gap-1.5 text-sm font-medium text-slate-800">
                                        <svg class="h-4 w-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$device['jenis']] ?? $typeIcons['Monitor'] }}"/></svg>
                                        {{ $device['jenis'] }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-end justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <p class="text-[11px] text-slate-500">Status</p>
                                    <span class="mt-1 inline-flex items-center gap-1.5 text-sm font-semibold {{ $st['text'] }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $st['label'] }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    {{-- Edit --}}
                                    <button type="button" @click.stop="openEdit(findDevice({{ $device['id'] }}))" class="rounded-md bg-[#10254a] p-2 text-white transition-colors hover:bg-[#0b1b3a]" aria-label="Edit {{ $device['nama'] }}" title="Edit">
                                        {{ $icon('edit') }}
                                    </button>
                                    {{-- Hapus --}}
                                    <button type="button" @click.stop="askDelete(findDevice({{ $device['id'] }}))" class="rounded-md bg-rose-500 p-2 text-white transition-colors hover:bg-rose-600" aria-label="Hapus {{ $device['nama'] }}" title="Hapus">
                                        {{ $icon('trash') }}
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                <span>{{ $device['tanggal'] }}</span>
                                <span>Lokasi: {{ $device['lantai'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>

    {{-- ============ POP UP DETAIL PERANGKAT ============ --}}
    <div x-show="detail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="detail-title">
        <div x-show="detail" x-transition.opacity @click="detail = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="detail" x-transition class="relative flex max-h-[92vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <template x-if="detail">
                <div class="flex min-h-0 flex-1 flex-col">

                    {{-- Header --}}
                    <div class="flex shrink-0 items-start justify-between gap-3 border-b border-slate-100 px-5 pb-0 pt-5 sm:px-7 sm:pt-6">
                        <div class="min-w-0 pb-4">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <h3 id="detail-title" class="text-xl font-bold text-slate-900 sm:text-2xl" x-text="detail.nama"></h3>
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold" :class="statusBadge[detail.status]">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                    <span x-text="statusLabel[detail.status]"></span>
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500 sm:text-sm"><span class="font-semibold text-slate-700" x-text="detail.kode"></span> &middot; <span x-text="detail.jenis"></span></p>
                        </div>
                        <button type="button" @click="detail = null" class="shrink-0 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                    </div>

                    {{-- Tab --}}
                    <div class="flex shrink-0 gap-1 overflow-x-auto border-b border-slate-100 px-3 sm:px-5" role="tablist" aria-label="Informasi perangkat">
                        <template x-for="t in tabs" :key="t.key">
                            <button type="button" role="tab" @click="tab = t.key" :aria-selected="tab === t.key"
                                    class="-mb-px inline-flex shrink-0 items-center gap-2 border-b-2 px-3 py-3 text-sm font-semibold transition-colors"
                                    :class="tab === t.key ? 'border-[#10254a] text-[#10254a]' : 'border-transparent text-slate-500 hover:text-slate-800'">
                                <span x-text="t.label"></span>
                                <span x-show="t.key !== 'detail'" class="rounded-full px-2 py-0.5 text-[11px] font-bold"
                                      :class="tab === t.key ? 'bg-[#10254a] text-white' : 'bg-slate-100 text-slate-600'" x-text="tabCount(t.key)"></span>
                            </button>
                        </template>
                    </div>

                    {{-- Isi tab --}}
                    <div class="min-h-0 flex-1 overflow-y-auto p-5 sm:p-7">

                        {{-- TAB: Detail (detail device, operator, lokasi) --}}
                        <div x-show="tab === 'detail'" class="space-y-6">
                            <section>
                                <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">Detail Device</h4>
                                <dl class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <template x-for="item in detailFields(detail)" :key="item.label">
                                        <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-3.5">
                                            <dt class="text-[11px] font-medium text-slate-500" x-text="item.label"></dt>
                                            <dd class="mt-1 text-sm font-semibold text-slate-900" x-text="item.value"></dd>
                                        </div>
                                    </template>
                                </dl>
                                <div class="mt-3 rounded-xl border border-slate-100 bg-slate-50/70 p-3.5">
                                    <div class="text-[11px] font-medium text-slate-500">Spesifikasi &amp; Keterangan</div>
                                    <p class="mt-1 text-sm leading-relaxed" :class="detail.spesifikasi ? 'text-slate-700' : 'italic text-slate-400'" x-text="detail.spesifikasi || 'Belum ada spesifikasi.'"></p>
                                </div>
                            </section>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <section>
                                    <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">Operator</h4>
                                    <div class="flex items-center gap-3.5 rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#10254a] text-sm font-bold text-white" x-text="initials(detail.operator.nama)"></span>
                                        <div class="min-w-0">
                                            <div class="truncate text-sm font-bold text-slate-900" x-text="detail.operator.nama"></div>
                                            <div class="truncate text-xs text-slate-500" x-text="detail.operator.divisi"></div>
                                            <div class="mt-1 flex items-center gap-1.5 text-xs text-slate-600">
                                                {{ $icon('phone', 'h-3.5 w-3.5 text-slate-400') }}
                                                <span x-text="detail.operator.telepon"></span>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <h4 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500">Lokasi</h4>
                                    <div class="flex items-start gap-3.5 rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-600">{{ $icon('pin', 'h-5 w-5') }}</span>
                                        <div class="min-w-0">
                                            <div class="text-sm font-bold text-slate-900" x-text="detail.lantai"></div>
                                            <div class="text-xs leading-snug text-slate-500" x-text="detail.ruang"></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        {{-- TAB: Riwayat Kerusakan --}}
                        <div x-show="tab === 'damage'" x-cloak class="space-y-3">
                            <template x-for="(d, i) in detail.damages" :key="i">
                                <article class="rounded-xl border border-slate-200 p-4">
                                    <div class="flex flex-wrap items-start justify-between gap-2">
                                        <div>
                                            <h5 class="text-sm font-bold text-slate-900" x-text="d.judul"></h5>
                                            <p class="mt-0.5 text-[11px] text-slate-400" x-text="d.tanggal"></p>
                                        </div>
                                        <span class="rounded-md px-2.5 py-1 text-xs font-semibold" :class="recordStyle[d.status]" x-text="d.status"></span>
                                    </div>
                                    <dl class="mt-3 grid grid-cols-1 gap-3 text-xs sm:grid-cols-2">
                                        <div><dt class="font-semibold text-slate-500">Penyebab</dt><dd class="mt-0.5 text-slate-700" x-text="d.penyebab"></dd></div>
                                        <div><dt class="font-semibold text-slate-500">Teknisi</dt><dd class="mt-0.5 text-slate-700" x-text="d.teknisi || 'Belum ditugaskan'"></dd></div>
                                        <div class="sm:col-span-2"><dt class="font-semibold text-slate-500">Penanganan</dt><dd class="mt-0.5 leading-relaxed text-slate-700" x-text="d.penanganan"></dd></div>
                                    </dl>
                                </article>
                            </template>
                            <div x-show="detail.damages.length === 0" class="flex flex-col items-center py-10 text-center">
                                <span class="mb-2 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-6 w-6') }}</span>
                                <p class="text-sm font-semibold text-slate-700">Belum ada riwayat kerusakan</p>
                                <p class="text-xs text-slate-400">Perangkat ini belum pernah dilaporkan rusak.</p>
                            </div>
                        </div>

                        {{-- TAB: Riwayat Ticket --}}
                        <div x-show="tab === 'ticket'" x-cloak class="space-y-2.5">
                            <template x-for="(t, i) in detail.tickets" :key="i">
                                <a :href="ticketUrl" class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 p-4 transition-colors hover:border-slate-300 hover:bg-slate-50/70">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-sm font-bold text-slate-900" x-text="t.kode"></span>
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold" :class="urgencyStyle[t.urgensi].text">
                                                <span class="h-1.5 w-1.5 rounded-full" :class="urgencyStyle[t.urgensi].dot"></span><span x-text="t.urgensi"></span>
                                            </span>
                                        </div>
                                        <p class="mt-0.5 truncate text-sm text-slate-700" x-text="t.subjek"></p>
                                        <p class="mt-0.5 text-[11px] text-slate-400" x-text="t.tanggal"></p>
                                    </div>
                                    <span class="shrink-0 rounded-md px-2.5 py-1 text-xs font-semibold" :class="recordStyle[t.status]" x-text="t.status"></span>
                                </a>
                            </template>
                            <div x-show="detail.tickets.length === 0" class="flex flex-col items-center py-10 text-center">
                                <span class="mb-2 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-6 w-6') }}</span>
                                <p class="text-sm font-semibold text-slate-700">Belum ada riwayat tiket</p>
                                <p class="text-xs text-slate-400">Belum ada tiket untuk perangkat ini.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex shrink-0 flex-col-reverse items-stretch justify-end gap-2.5 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-7">
                        <button type="button" @click="detail = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</button>
                        <button type="button" @click="editFromDetail()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a]">
                            {{ $icon('edit') }} Edit Perangkat
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- ============ MODAL KONFIRMASI HAPUS ============ --}}
    <div x-show="confirmTarget" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="alertdialog" aria-modal="true" aria-labelledby="delete-title">
        <div x-show="confirmTarget" x-transition.opacity @click="confirmTarget = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="confirmTarget" x-transition class="relative w-full max-w-[480px] overflow-hidden rounded-2xl bg-white p-5 shadow-2xl sm:p-7">
            <form action="#" method="POST" @submit.prevent="confirmDelete()">
                @csrf
                @method('DELETE')
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-600 sm:h-12 sm:w-12">{{ $icon('trash', 'h-5 w-5 sm:h-6 sm:w-6') }}</div>
                        <div>
                            <h3 id="delete-title" class="text-lg font-bold leading-tight text-slate-900 sm:text-xl">Konfirmasi Hapus Perangkat</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-400">Aksi kritis, perlu konfirmasi</p>
                        </div>
                    </div>
                    <button type="button" @click="confirmTarget = null" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                </div>

                <div class="mb-6 space-y-3 text-xs leading-relaxed text-slate-600 sm:space-y-4 sm:text-sm">
                    <p>
                        Apakah Anda yakin ingin menghapus perangkat
                        <strong class="font-semibold text-slate-900" x-text="confirmTarget ? confirmTarget.nama + ' (' + confirmTarget.kode + ')' : ''"></strong>?
                        Tindakan ini bersifat <strong class="font-semibold text-slate-900">permanen</strong> dan data yang telah dihapus tidak dapat dipulihkan.
                    </p>
                    <div class="flex items-start gap-2.5 rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs leading-normal text-amber-900 sm:p-3.5">
                        <span class="mt-0.5 shrink-0 text-amber-600">{{ $icon('warning') }}</span>
                        <span><strong class="font-semibold">Perhatian:</strong> Riwayat kerusakan dan riwayat tiket yang terhubung dengan perangkat ini juga akan terhapus.</span>
                    </div>
                </div>

                <div class="flex flex-col-reverse items-stretch justify-end gap-2.5 pt-2 sm:flex-row sm:items-center sm:gap-3">
                    <button type="button" @click="confirmTarget = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                        {{ $icon('trash') }} Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed right-5 top-5 z-[100] rounded-xl border border-slate-700 bg-[#10254a] px-4 py-3 text-sm font-medium text-white shadow-lg" role="status" aria-live="polite">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ MODAL TAMBAH / EDIT PERANGKAT ============ --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        {{-- Overlay --}}
        <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-slate-900/50"></div>

        {{-- Panel --}}
        <div x-show="modalOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 sm:scale-100"
             x-transition:leave-end="opacity-0 sm:scale-95"
             class="relative flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-xl bg-white shadow-xl">

            <form action="#" method="POST" enctype="multipart/form-data" class="flex min-h-0 flex-1 flex-col">
                @csrf

                <div class="min-h-0 flex-1 overflow-y-auto px-5 pb-6 pt-6 sm:px-8">
                    {{-- Judul --}}
                    <div class="mb-5 border-b border-slate-100 pb-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 id="modal-title" class="text-base font-bold text-slate-900" x-text="mode === 'add' ? 'Tambah Perangkat Baru' : 'Edit Perangkat'"></h3>
                            <span x-show="mode === 'edit'" x-cloak class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold"
                                  :class="{
                                      'bg-emerald-50 text-emerald-600': form.status === 'aktif',
                                      'bg-amber-50 text-amber-600': form.status === 'perbaikan',
                                      'bg-rose-50 text-rose-600': form.status === 'rusak'
                                  }">
                                <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                <span x-text="form.status ? form.status.charAt(0).toUpperCase() + form.status.slice(1) : ''"></span>
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500"
                           x-text="mode === 'add' ? 'Lengkapi formulir di bawah ini untuk mendaftarkan aset perangkat baru ke sistem P-TAMS.' : 'Perbarui informasi dan spesifikasi perangkat inventaris P-TAMS.'"></p>
                    </div>

                    <div class="space-y-4 text-sm">

                        {{-- Kode Device --}}
                        <div class="grid grid-cols-1 items-center gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="text-xs font-medium text-slate-700">Kode Device <span class="text-red-500">*</span></label>
                            <div class="flex overflow-hidden rounded-lg border border-slate-200 bg-slate-100 text-xs font-semibold text-slate-500">
                                <input type="text" x-model="form.kode1" placeholder="AAA" class="w-1/4 border-r border-slate-200 bg-transparent px-3 py-2 text-center uppercase focus:bg-white focus:outline-none">
                                <input type="text" x-model="form.kode2" placeholder="BBB" class="w-1/4 border-r border-slate-200 bg-transparent px-3 py-2 text-center uppercase focus:bg-white focus:outline-none">
                                <input type="text" x-model="form.kode3" placeholder="000" class="w-1/2 bg-transparent px-3 py-2 text-slate-800 focus:bg-white focus:outline-none">
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="grid grid-cols-1 items-center gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="text-xs font-medium text-slate-700">Nama Perangkat <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons['Monitor'] }}"/></svg>
                                <input type="text" x-model="form.nama" placeholder="Contoh: Monitor LG 24 Inch UltraGear atau Router RB4011" class="w-full rounded-lg border border-slate-200 py-2 pl-9 pr-3 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                            </div>
                        </div>

                        {{-- Kategori --}}
                        <div class="grid grid-cols-1 items-center gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="text-xs font-medium text-slate-700">Jenis / Kategori Device <span class="text-red-500">*</span></label>
                            <select x-model="form.kategori" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                <option value="" disabled>Pilih Kategori Perangkat</option>
                                <option value="MNTR">MNTR - MONITOR</option>
                                <option value="PRN">PRN - PRINTER</option>
                                <option value="SCN">SCN - SCANNER</option>
                                <option value="RTR">RTR - ROUTER</option>
                            </select>
                        </div>

                        {{-- Nomor Seri --}}
                        <div class="grid grid-cols-1 items-center gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="text-xs font-medium text-slate-700">Nomor Seri (S/N) <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.sn" placeholder="CONTOH: SN-849204810293" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                        </div>

                        {{-- Status Perangkat (sama seperti Edit) --}}
                        <div class="grid grid-cols-1 items-start gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="pt-2 text-xs font-medium text-slate-700">Status Perangkat <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                @foreach ([
                                    ['aktif', 'Aktif', 'Siap Digunakan / Normal', 'bg-emerald-500', 'border-emerald-500 bg-emerald-50'],
                                    ['perbaikan', 'Perbaikan', 'Dalam Antrean Servis', 'bg-amber-500', 'border-amber-400 bg-amber-50'],
                                    ['rusak', 'Rusak', 'Non-Operasional / Perlu Ganti', 'bg-rose-500', 'border-rose-400 bg-rose-50'],
                                ] as [$val, $label, $desc, $dot, $active])
                                    <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border p-3 transition-colors"
                                           :class="form.status === '{{ $val }}' ? '{{ $active }}' : 'border-slate-200 bg-white hover:bg-slate-50'">
                                        <input type="radio" name="status" value="{{ $val }}" x-model="form.status" class="sr-only">
                                        <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white">
                                            <span x-show="form.status === '{{ $val }}'" x-cloak class="h-2 w-2 rounded-full bg-[#10254a]"></span>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="flex items-center gap-1.5 text-sm font-semibold text-slate-900">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>{{ $label }}
                                            </span>
                                            <span class="block text-[10px] text-slate-500">{{ $desc }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Lokasi & PJ --}}
                        <div class="grid grid-cols-1 items-center gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="text-xs font-medium text-slate-700">Lokasi & Penanggung Jawab <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-[2fr_1fr_1.5fr]">
                                <select x-model="form.ruang" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                    <option value="" disabled>Pilih Ruang Penempatan</option>
                                    <option value="POKJA - Perencanaan Pengembangan dan Pengaduan">POKJA - Perencanaan Pengembangan dan Pengaduan</option>
                                </select>
                                <select x-model="form.lantai" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                    <option value="" disabled>Pilih Lantai</option>
                                    <option value="Lantai 1">Lantai 1</option>
                                    <option value="Lantai 3">Lantai 3</option>
                                    <option value="Lantai 6">Lantai 6</option>
                                    <option value="Ruang Server A">Ruang Server A</option>
                                </select>
                                <input type="text" x-model="form.pj" placeholder="Budi Santoso" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                            </div>
                        </div>

                        {{-- Spesifikasi --}}
                        <div class="grid grid-cols-1 items-start gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="pt-2 text-xs font-medium text-slate-700">Spesifikasi & Keterangan</label>
                            <textarea rows="3" x-model="form.spesifikasi" placeholder="Jelaskan detail spesifikasi teknis atau catatan tambahan..." class="w-full resize-none rounded-lg border border-slate-200 px-3 py-2 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]"></textarea>
                        </div>

                        {{-- Upload Foto --}}
                        <div class="grid grid-cols-1 items-start gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4">
                            <label class="pt-2 text-xs font-medium text-slate-700">Upload Foto <span class="font-normal text-slate-400">(Opsional)</span></label>
                            <label class="flex cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-slate-200 px-6 py-8 text-center transition-colors hover:bg-slate-50">
                                <svg class="mb-2 h-5 w-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span class="text-xs font-semibold text-slate-800">Seret dan lepas file di sini, atau klik untuk memilih</span>
                                <span class="mt-1 text-[10px] text-slate-400">Format: JPG, PNG (maks. 5 MB)</span>
                                <input type="file" name="foto" accept="image/png,image/jpeg" class="sr-only">
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-100 bg-white px-5 py-4 sm:px-8">
                    <button type="button" @click="modalOpen = false" class="rounded-lg border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="flex items-center gap-2 rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#0b1b3a]">
                        <svg x-show="mode === 'edit'" x-cloak class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg x-show="mode === 'add'" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        <span x-text="mode === 'add' ? 'Simpan Perangkat' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('devicesPage', (devices, ticketUrl) => ({
            sidebarOpen: false,
            devices,
            ticketUrl,
            deleted: [],                // id perangkat yang sudah dihapus (hanya di browser)

            // Modal tambah / edit
            modalOpen: false,
            mode: 'add',
            blank: { kode1: '', kode2: '', kode3: '', nama: '', kategori: '', sn: '', status: 'aktif', ruang: '', lantai: '', pj: '', spesifikasi: '' },
            form: {},

            // Pop up detail
            detail: null,
            tab: 'detail',
            tabs: [
                { key: 'detail', label: 'Detail' },
                { key: 'damage', label: 'Riwayat Kerusakan' },
                { key: 'ticket', label: 'Riwayat Ticket' },
            ],

            // Hapus & toast
            confirmTarget: null,
            toastMsg: '',
            toastTimer: null,

            statusLabel: { aktif: 'Aktif', perbaikan: 'Perbaikan', rusak: 'Rusak' },
            statusBadge: {
                aktif:     'bg-emerald-50 text-emerald-600',
                perbaikan: 'bg-amber-50 text-amber-600',
                rusak:     'bg-rose-50 text-rose-600',
            },
            recordStyle: {
                Selesai:  'bg-green-100 text-green-700',
                Diproses: 'bg-yellow-100 text-yellow-700',
                Pending:  'bg-rose-100 text-rose-600',
            },
            urgencyStyle: {
                Urgent: { dot: 'bg-red-500',     text: 'text-red-600' },
                Sedang: { dot: 'bg-amber-500',   text: 'text-amber-500' },
                Rendah: { dot: 'bg-emerald-500', text: 'text-emerald-600' },
            },

            init() {
                this.form = { ...this.blank };
            },

            // ---------- Data ----------
            findDevice(id) { return this.devices.find(d => d.id === id); },
            isDeleted(id)  { return this.deleted.includes(id); },
            get visible()  { return this.devices.filter(d => !this.deleted.includes(d.id)); },
            count(status)  { return status === 'total' ? this.visible.length : this.visible.filter(d => d.status === status).length; },

            initials(name) {
                const p = (name || '').trim().split(/\s+/);
                return ((p[0]?.[0] || '') + (p[1]?.[0] || p[0]?.[1] || '')).toUpperCase() || '?';
            },

            // ---------- Tambah / Edit ----------
            openAdd()      { this.mode = 'add'; this.form = { ...this.blank }; this.modalOpen = true; },
            openEdit(d)    { this.mode = 'edit'; this.form = { ...d }; this.modalOpen = true; },

            // ---------- Detail ----------
            openDetail(id) { this.detail = this.findDevice(id); this.tab = 'detail'; },
            editFromDetail() { const d = this.detail; this.detail = null; this.openEdit(d); },
            tabCount(key)  { return !this.detail ? 0 : (key === 'damage' ? this.detail.damages.length : this.detail.tickets.length); },
            detailFields(d) {
                return [
                    { label: 'Kode Device',         value: d.kode },
                    { label: 'Nama Perangkat',      value: d.nama },
                    { label: 'Jenis / Kategori',    value: `${d.jenis} (${d.kategori})` },
                    { label: 'Nomor Seri (S/N)',    value: d.sn },
                    { label: 'Status Perangkat',    value: this.statusLabel[d.status] },
                    { label: 'Tanggal Terdaftar',   value: d.tanggal },
                ];
            },

            // ---------- Hapus (frontend saja, nanti ganti dengan submit form DELETE ke backend) ----------
            askDelete(d)   { this.confirmTarget = d; },
            confirmDelete() {
                if (!this.confirmTarget) return;
                const d = this.confirmTarget;
                this.deleted.push(d.id);
                this.confirmTarget = null;
                this.toast(`Perangkat "${d.nama}" berhasil dihapus.`);
            },

            toast(msg) {
                this.toastMsg = msg;
                clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMsg = '', 3500);
            },
        }));
    });
</script>
@endsection