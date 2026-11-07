@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only) - 3 device.
     * Nanti ganti dengan data dari controller, mis: @foreach ($devices as $device)
     */
    $devices = [
        ['id' => 1, 'kode' => 'DV-2024-001', 'kode1' => 'MNTR', 'kode2' => 'PPDP', 'kode3' => '001', 'nama' => 'Monitor LG 14 Inch', 'jenis' => 'Monitor', 'kategori' => 'MNTR', 'sn' => 'SN-8438291809281092', 'status' => 'aktif', 'tanggal' => '12 Oktober 2024', 'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Lantai 6', 'pj' => 'Budi Santoso', 'spesifikasi' => 'Resolusi 1920x1080 144Hz IPS Panel, Port HDMI & DisplayPort, Garansi distributor hingga Oktober 2026.'],
        ['id' => 2, 'kode' => 'DV-2024-003', 'kode1' => 'SCN', 'kode2' => 'PPDP', 'kode3' => '003', 'nama' => 'Scanner Canon DR-C240', 'jenis' => 'Scanner', 'kategori' => 'SCN', 'sn' => 'SN-5521903847261', 'status' => 'rusak', 'tanggal' => '15 Oktober 2024', 'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Lantai 3', 'pj' => 'Budi Santoso', 'spesifikasi' => ''],
        ['id' => 3, 'kode' => 'DV-2024-002', 'kode1' => 'PRN', 'kode2' => 'PPDP', 'kode3' => '002', 'nama' => 'Printer Epson L380', 'jenis' => 'Printer', 'kategori' => 'PRN', 'sn' => 'SN-3309182746550', 'status' => 'perbaikan', 'tanggal' => '14 Oktober 2024', 'ruang' => 'POKJA - Perencanaan Pengembangan dan Pengaduan', 'lantai' => 'Ruang Server A', 'pj' => 'Budi Santoso', 'spesifikasi' => ''],
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

    $total     = count($devices);
    $countAktif = collect($devices)->where('status', 'aktif')->count();
    $countPerbaikan = collect($devices)->where('status', 'perbaikan')->count();
    $countRusak = collect($devices)->where('status', 'rusak')->count();
@endphp

<div
    x-data="{
        sidebarOpen: false,
        modalOpen: false,
        mode: 'add',
        blank: { kode1: '', kode2: '', kode3: '', nama: '', kategori: '', sn: '', status: 'aktif', ruang: '', lantai: '', pj: '', spesifikasi: '' },
        form: {},
        openAdd() { this.mode = 'add'; this.form = { ...this.blank }; this.modalOpen = true; },
        openEdit(device) { this.mode = 'edit'; this.form = { ...device }; this.modalOpen = true; }
    }"
    x-init="form = { ...blank }"
    @keydown.escape.window="modalOpen = false; sidebarOpen = false"
    class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800"
>

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

            {{-- Kartu statistik --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="relative flex items-center gap-4 overflow-hidden rounded-lg bg-[#10254a] p-5 text-white shadow-sm">
                    <div class="flex h-20 w-14 shrink-0 rotate-[-8deg] items-center justify-center rounded-xl border border-rose-300/30 bg-rose-400/25">
                        <svg class="h-8 w-8 text-rose-200" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm8-2h2v2h-2v-2zm4 0h4v2h-4v-2zm-4 4h2v4h-2v-4zm4 2h4v2h-4v-2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-slate-200">Total Perangkat</p>
                        <h2 class="mt-1 text-3xl font-bold">{{ $total }}</h2>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Aktif</p>
                            <h2 class="mt-1 text-2xl font-bold text-slate-900">{{ $countAktif }}</h2>
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
                            <h2 class="mt-1 text-2xl font-bold text-slate-900">{{ $countPerbaikan }}</h2>
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
                            <h2 class="mt-1 text-2xl font-bold text-slate-900">{{ $countRusak }}</h2>
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

            {{-- Daftar device --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($devices as $device)
                    @php $st = $statusMap[$device['status']]; @endphp
                    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                        {{-- Header kartu --}}
                        <div class="flex items-center gap-3 bg-[#ececec] px-4 py-3">
                            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons['Monitor'] }}"/></svg>
                            <h3 class="truncate text-base font-bold text-slate-800">{{ $device['nama'] }}</h3>
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
                                    <button type="button" @click='openEdit(@js($device))' class="rounded-md bg-[#10254a] p-2 text-white transition-colors hover:bg-[#0b1b3a]" aria-label="Edit {{ $device['nama'] }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </button>
                                    {{-- Hapus --}}
                                    <button type="button" class="rounded-md bg-rose-500 p-2 text-white transition-colors hover:bg-rose-600" aria-label="Hapus {{ $device['nama'] }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
                        <svg x-show="mode === 'add'" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span x-text="mode === 'add' ? 'Simpan Perangkat' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection