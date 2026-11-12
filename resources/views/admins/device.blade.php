@extends('layouts.index')

@section('content')
@php
    $ic = [
        'edit'    => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
        'trash'   => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'close'   => 'M6 18L18 6M6 6l12 12',
        'qr'      => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );
@endphp

<div x-data="devicesPage(
        @js($devices), 
        @js($categories),
        @js(route('admin.device.store')), 
        @js(route('admin.device.update', ['device' => '__ID__'])), 
        @js(route('admin.device.destroy', ['device' => '__ID__'])), 
        @js(csrf_token())
    )"
     @keydown.escape.window="modalOpen = false; detail = null; confirmTarget = null; sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar --}}
    <x-sidebar active="device" />

    {{-- KONTEN UTAMA --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Navbar --}}
        <x-navbar name="Fikri" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul + Tombol Tambah --}}
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

            {{-- Kartu Statistik --}}
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
                    <p class="mt-3 text-[11px] text-slate-500">Perangkat normal & siap</p>
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
                    <p class="mt-3 text-[11px] text-slate-500">Dalam antrean servis</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-700">Rusak</p>
                            <h2 class="mt-1 text-2xl font-bold text-slate-900" x-text="count('rusak')"></h2>
                        </div>
                        <div class="rounded-lg bg-rose-50 p-2 text-rose-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <p class="mt-3 text-[11px] text-slate-500">Non-operasional</p>
                </div>
            </div>

            {{-- Pencarian --}}
            <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="relative w-full md:max-w-3xl md:flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" x-model="search" placeholder="Cari berdasarkan nama atau kode device..." class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                </div>
            </div>

            {{-- Daftar Device --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                <template x-for="device in filteredDevices" :key="device.id">
                    <div @click="openDetail(device.id)"
                         class="cursor-pointer overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-all hover:shadow-md">
                        <div class="flex items-center gap-3 bg-[#ececec] px-4 py-3">
                            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <h3 class="min-w-0 flex-1 truncate text-base font-bold text-slate-850" x-text="device.nama"></h3>
                        </div>

                        <div class="p-4">
                            <div class="mb-4 flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-[11px] text-slate-500">Kode Device</p>
                                    <div class="mt-1 text-sm font-medium text-slate-800" x-text="device.kode"></div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[11px] text-slate-500">Jenis</p>
                                    <div class="mt-1 text-sm font-medium text-slate-800" x-text="device.jenis"></div>
                                </div>
                            </div>

                            <div class="flex items-end justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <p class="text-[11px] text-slate-500">Status</p>
                                    <span class="mt-1 inline-flex items-center gap-1.5 text-sm font-semibold" :class="statusStyle[device.status]?.text || 'text-slate-600'">
                                        <span class="h-2 w-2 rounded-full" :class="statusStyle[device.status]?.dot || 'bg-slate-400'"></span>
                                        <span x-text="statusStyle[device.status]?.label || device.status"></span>
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    {{-- Tombol Cetak Stiker Label QR Kecil --}}
                                    <button type="button" @click.stop="printQRLabel(device)" class="rounded-md bg-emerald-600 p-2 text-white hover:bg-emerald-700 transition-colors" title="Cetak Stiker QR">
                                        {{ $icon('qr') }}
                                    </button>
                                    <button type="button" @click.stop="openEdit(device)" class="rounded-md bg-[#10254a] p-2 text-white hover:bg-[#0b1b3a] transition-colors" title="Edit">
                                        {{ $icon('edit') }}
                                    </button>
                                    <button type="button" @click.stop="askDelete(device)" class="rounded-md bg-rose-500 p-2 text-white hover:bg-rose-600 transition-colors" title="Hapus">
                                        {{ $icon('trash') }}
                                    </button>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-[11px] text-slate-500">
                                <span x-text="device.tanggal"></span>
                                <span x-text="`Lokasi: ${device.lantai}`"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </main>
    </div>

    {{-- AREA KHUSUS CETAK STIKER LABEL KECIL --}}
    <div id="qr-label-print-area" class="hidden print:flex flex-col items-center justify-center p-0 m-0 bg-white">
        <div class="text-center bg-white" style="width: 40mm; height: 30mm; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden;">
            <p style="font-size: 8px; font-weight: bold; text-transform: uppercase; margin: 0 0 2px 0; padding: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 38mm;" x-text="activeQRDevice?.nama"></p>
            <img :src="`https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=${encodeURIComponent(activeQRDevice?.qr_url)}`" style="width: 65px; height: 65px; margin: 1px auto; display: block;" alt="QR">
            <p style="font-size: 9px; font-family: monospace; font-weight: bold; margin: 2px 0 0 0; padding: 0;" x-text="activeQRDevice?.kode"></p>
        </div>
    </div>

    {{-- POP UP DETAIL PERANGKAT (DENGAN TRANSISI SMOOTH & TAB NAVIGASI) --}}
    <div x-show="detail" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true">
        
        <div @click="detail = null" class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs"></div>

        <div x-show="detail" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative flex max-h-[92vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            
            <template x-if="detail">
                <div class="flex min-h-0 flex-1 flex-col">
                    
                    {{-- Header Modal & Info Dasar --}}
                    <div class="flex shrink-0 items-start justify-between gap-3 border-b border-slate-100 px-6 py-5 bg-white">
                        <div class="text-center w-full">
                            <h2 class="text-2xl font-bold text-slate-900" x-text="detail.nama"></h2>
                            <p class="mt-1 text-xs text-slate-500"><span class="font-semibold text-slate-700" x-text="detail.kode"></span> &middot; <span x-text="detail.jenis"></span></p>
                        </div>
                        <button type="button" @click="detail = null" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 absolute right-5 top-5 transition-colors">{{ $icon('close', 'h-5 w-5') }}</button>
                    </div>

                    {{-- TAB NAVIGASI SMOOTH DI ATAS --}}
                    <div class="flex shrink-0 gap-1 border-b border-slate-100 px-6 bg-slate-50">
                        <template x-for="t in tabs" :key="t.key">
                            <button type="button" @click="tab = t.key"
                                    class="-mb-px border-b-2 px-4 py-3 text-sm font-semibold transition-all duration-200"
                                    :class="tab === t.key ? 'border-[#10254a] text-[#10254a]' : 'border-transparent text-slate-500 hover:text-slate-800'"
                                    x-text="t.label"></button>
                        </template>
                    </div>

                    {{-- KONTEN TAB DENGAN TRANSISI SMOOTH --}}
                    <div class="min-h-0 flex-1 overflow-y-auto p-6 space-y-6 bg-white relative">
                        
                        {{-- TAB 1: DETAIL PERANGKAT & QR CODE --}}
                        <div x-show="tab === 'detail'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-6">
                            
                            {{-- QR Code & Info --}}
                            <div class="flex flex-col sm:flex-row gap-6 items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <div class="bg-white p-3 rounded-lg border shadow-sm shrink-0 text-center">
                                    <img :src="`https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=${encodeURIComponent(detail.qr_url)}`" alt="QR Code" class="w-28 h-28 mx-auto">
                                    <span class="text-[10px] text-slate-400 mt-1 block font-mono" x-text="detail.kode"></span>
                                </div>
                                <div class="text-xs text-slate-600 space-y-1.5 flex-1">
                                    <p class="font-semibold text-slate-800 text-sm">Informasi Scan QR:</p>
                                    <p>Scan QR code di samping menggunakan kamera smartphone untuk langsung mengakses halaman data perangkat ini.</p>
                                    <p class="text-[11px] text-slate-400 break-all font-mono" x-text="detail.qr_url"></p>
                                    <button type="button" @click="printQRLabel(detail)" class="mt-2 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700 transition-colors">
                                        {{ $icon('qr', 'h-3.5 w-3.5') }} Cetak Stiker Label QR Kecil
                                    </button>
                                </div>
                            </div>

                            {{-- Tabel Informasi Perangkat --}}
                            <div>
                                <h4 class="text-sm font-bold text-red-700 mb-3 uppercase tracking-wider">Informasi Perangkat</h4>
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="border-b border-slate-200 text-xs font-bold text-red-700">
                                            <th class="py-2.5 px-3 w-1/3">Detail</th>
                                            <th class="py-2.5 px-3 w-2/3">Informasi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 text-xs">
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Kode Perangkat</td><td class="py-2.5 px-3 font-semibold text-slate-900" x-text="detail.kode"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Nama Perangkat</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.nama"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Kategori</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.jenis"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Merek</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.merek"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Model</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.model"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Serial Number</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.sn"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Lokasi</td><td class="py-2.5 px-3 text-slate-900" x-text="`${detail.ruang} (${detail.lantai})`"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Operator Device</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.pj"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Departemen</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.departemen_pj"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Tanggal Pengadaan</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.tanggal"></td></tr>
                                        <tr><td class="py-2.5 px-3 font-medium text-slate-600">Spesifikasi / Deskripsi</td><td class="py-2.5 px-3 text-slate-900" x-text="detail.spesifikasi || '-'"></td></tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Status Perangkat --}}
                            <div>
                                <h4 class="text-sm font-bold text-red-700 mb-3 uppercase tracking-wider">Status Perangkat</h4>
                                <table class="w-full text-left text-sm border-collapse">
                                    <tbody class="divide-y divide-slate-100 text-xs">
                                        <tr>
                                            <td class="py-2.5 px-3 font-medium text-slate-600 w-1/3">Kondisi Perangkat</td>
                                            <td class="py-2.5 px-3 w-2/3">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold" :class="statusStyle[detail.status]?.bg || 'bg-slate-100 text-slate-700'" x-text="statusStyle[detail.status]?.label || detail.status"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2.5 px-3 font-medium text-slate-600">Status Penggunaan</td>
                                            <td class="py-2.5 px-3">
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Sedang Digunakan</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TAB 2: RIWAYAT KERUSAKAN --}}
                        <div x-show="tab === 'damage'" x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-4">
                            <template x-for="(d, i) in detail.damages" :key="i">
                                <div class="rounded-xl border border-slate-200 p-4 space-y-2 bg-slate-50">
                                    <div class="flex items-center justify-between">
                                        <h5 class="text-sm font-bold text-slate-900" x-text="d.judul"></h5>
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded bg-amber-100 text-amber-700" x-text="d.status"></span>
                                    </div>
                                    <p class="text-xs text-slate-600"><strong class="text-slate-700">Penyebab/Keluhan:</strong> <span x-text="d.penyebab"></span></p>
                                    <p class="text-xs text-slate-600"><strong class="text-slate-700">Penanganan:</strong> <span x-text="d.penanganan"></span></p>
                                    <div class="flex justify-between items-center pt-2 border-t border-slate-200 text-[11px] text-slate-500">
                                        <span x-text="`Tanggal: ${d.tanggal}`"></span>
                                        <span x-text="`Teknisi: ${d.teknisi}`"></span>
                                    </div>
                                </div>
                            </template>
                            <div x-show="!detail.damages.length" class="py-12 text-center text-slate-400">
                                Belum ada riwayat kerusakan untuk perangkat ini.
                            </div>
                        </div>

                        {{-- TAB 3: RIWAYAT TICKET --}}
                        <div x-show="tab === 'ticket'" x-cloak 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="space-y-3">
                            <template x-for="(t, i) in detail.tickets" :key="i">
                                <div class="rounded-xl border border-slate-200 p-4 flex justify-between items-center bg-white shadow-sm">
                                    <div class="space-y-1">
                                        <div class="text-xs font-mono font-semibold text-slate-500" x-text="t.kode"></div>
                                        <div class="text-sm font-bold text-slate-900" x-text="t.subjek"></div>
                                        <div class="text-[11px] text-slate-400" x-text="t.tanggal"></div>
                                    </div>
                                    <div class="text-right space-y-1">
                                        <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-700" x-text="t.urgensi"></span>
                                        <div class="text-xs font-semibold text-emerald-600" x-text="t.status"></div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="!detail.tickets.length" class="py-12 text-center text-slate-400">
                                Belum ada riwayat tiket untuk perangkat ini.
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-3 border-t bg-slate-50 px-6 py-4">
                        <button type="button" @click="detail = null" class="rounded-lg border px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition-colors">Tutup</button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT PERANGKAT DENGAN AUTO-GENERATE KODE --}}
    <div x-show="modalOpen" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog">
        
        <div @click="modalOpen = false" class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs"></div>
        
        <div x-show="modalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative flex max-h-[92vh] w-full max-w-2xl flex-col overflow-hidden rounded-xl bg-white shadow-xl">
            
            <form @submit.prevent="submitForm" class="flex min-h-0 flex-1 flex-col">
                <div class="overflow-y-auto p-6 space-y-4">
                    <h3 class="text-lg font-bold text-slate-900" x-text="mode === 'add' ? 'Tambah Perangkat Baru' : 'Edit Perangkat'"></h3>
                    
                    {{-- Nama Perangkat --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Perangkat</label>
                        <input type="text" x-model="form.nama_device" placeholder="Contoh: Laptop Asus ROG" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    {{-- Kategori (Memicu Auto-Generate Kode) --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Kategori</label>
                        <select x-model="form.id_kategori" @change="generateDeviceCode()" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Merek (Memicu Auto-Generate Kode) --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Merek</label>
                        <input type="text" x-model="form.merek" @input="generateDeviceCode()" placeholder="Contoh: Asus / Acer / HP" class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    {{-- Model --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Model / Tipe</label>
                        <input type="text" x-model="form.model" placeholder="Contoh: ROG Strix G15" class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    {{-- Kode Device Otomatis (Format: Kategori3-Merek3-Random3) --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-medium text-slate-700">Kode Perangkat (Auto-Generated)</label>
                            <button type="button" @click="generateDeviceCode()" class="text-[11px] text-[#10254a] font-semibold hover:underline">Generate Ulang Kode</button>
                        </div>
                        <input type="text" x-model="form.kode_device" readonly required class="w-full rounded-lg border border-slate-200 bg-slate-50 p-2.5 text-sm font-mono text-slate-600 focus:outline-none">
                    </div>

                    {{-- Nomor Seri --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nomor Seri (S/N)</label>
                        <input type="text" x-model="form.nomor_seri" placeholder="Nomor seri pabrik" class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    {{-- Tanggal Pengadaan --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Pengadaan</label>
                        <input type="date" x-model="form.tanggal_pengadaan" class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status Kondisi</label>
                        <select x-model="form.status" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                            <option value="aktif">Baik (Aktif)</option>
                            <option value="perbaikan">Perbaikan</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>

                    {{-- Lokasi / Departemen --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Lokasi / Departemen</label>
                        <select x-model="form.id_departemen" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                            <option value="">Pilih Lokasi</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nama }} ({{ $dept->lantai }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Penanggung Jawab (User) --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Penanggung Jawab (User)</label>
                        <select x-model="form.id_user" class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]">
                            <option value="">Pilih User</option>
                            @foreach ($users as $usr)
                                <option value="{{ $usr->id }}">{{ $usr->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Deskripsi / Spesifikasi --}}
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Spesifikasi / Deskripsi</label>
                        <textarea x-model="form.deskripsi" rows="3" placeholder="Spesifikasi hardware..." class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:ring-2 focus:ring-[#10254a]"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t bg-slate-50 px-6 py-4">
                    <button type="button" @click="modalOpen = false" class="rounded-lg border px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition-colors">Batal</button>
                    <button type="submit" class="rounded-lg bg-[#10254a] px-4 py-2 text-sm text-white hover:bg-[#0b1b3a] transition-colors" x-text="saving ? 'Menyimpan...' : 'Simpan'"></button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS (DENGAN TRANSISI SMOOTH) --}}
    <div x-show="confirmTarget" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <div @click="confirmTarget = null" class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs"></div>
        
        <div x-show="confirmTarget" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            
            <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus</h3>
            <p class="mt-2 text-sm text-slate-600">Yakin ingin menghapus perangkat <strong x-text="confirmTarget?.nama"></strong>?</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="confirmTarget = null" class="rounded-lg border px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 transition-colors">Batal</button>
                <button type="button" @click="executeDelete" class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700 transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- TOAST NOTIFIKASI --}}
    <div x-show="toastMsg" x-cloak x-transition class="fixed right-5 top-5 z-[100] rounded-xl bg-[#10254a] px-4 py-3 text-sm text-white shadow-lg" x-text="toastMsg"></div>
</div>

{{-- CSS KHUSUS CETAK STIKER LABEL KECIL --}}
<style>
    @media print {
        body * {
            visibility: hidden !important;
        }
        #qr-label-print-area, #qr-label-print-area * {
            visibility: visible !important;
        }
        #qr-label-print-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('devicesPage', (initialDevices, categoriesList, storeUrl, updateUrlTpl, destroyUrlTpl, csrfToken) => ({
            devices: initialDevices,
            categories: categoriesList,
            search: '',
            modalOpen: false,
            mode: 'add',
            form: { 
                id: null, 
                kode_device: '', 
                nama_device: '', 
                id_kategori: '', 
                merek: '', 
                model: '', 
                nomor_seri: '', 
                tanggal_pengadaan: '', 
                status: 'aktif', 
                id_departemen: '', 
                id_user: '', 
                deskripsi: '' 
            },
            saving: false,
            detail: null,
            tab: 'detail',
            tabs: [
                { key: 'detail', label: 'Detail' },
                { key: 'damage', label: 'Riwayat Kerusakan' },
                { key: 'ticket', label: 'Riwayat Ticket' }
            ],
            activeQRDevice: null,
            confirmTarget: null,
            toastMsg: '',

            statusStyle: {
                aktif: { label: 'Baik', bg: 'bg-emerald-100 text-emerald-700', text: 'text-emerald-600', dot: 'bg-emerald-500' },
                perbaikan: { label: 'Perbaikan', bg: 'bg-amber-100 text-amber-700', text: 'text-amber-500', dot: 'bg-amber-500' },
                rusak: { label: 'Rusak', bg: 'bg-rose-100 text-rose-700', text: 'text-rose-500', dot: 'bg-rose-500' },
            },

            get filteredDevices() {
                if (!this.search.trim()) return this.devices;
                const q = this.search.toLowerCase();
                return this.devices.filter(d => d.nama.toLowerCase().includes(q) || d.kode.toLowerCase().includes(q));
            },

            count(status) {
                if (status === 'total') return this.devices.length;
                return this.devices.filter(d => d.status === status).length;
            },

            // Fungsi Auto-Generate Kode (Format: Kategori3-Merek3-Random3)
            generateDeviceCode() {
                if (this.mode === 'edit') return; // Jangan ubah kode saat mode edit agar tidak broken link QR

                let catCode = 'DEV';
                if (this.form.id_kategori) {
                    const cat = this.categories.find(c => c.id == this.form.id_kategori);
                    if (cat && cat.nama) {
                        catCode = cat.nama.replace(/[^a-zA-Z]/g, '').substring(0, 3).toUpperCase();
                    }
                }

                let brandCode = 'XXX';
                if (this.form.merek && this.form.merek.trim() !== '') {
                    brandCode = this.form.merek.replace(/[^a-zA-Z]/g, '').substring(0, 3).toUpperCase();
                }

                const randomNum = Math.floor(100 + Math.random() * 900); // 3 digit angka random

                this.form.kode_device = `${catCode}-${brandCode}-${randomNum}`;
            },

            openAdd() {
                this.mode = 'add';
                this.form = { 
                    id: null, 
                    kode_device: '', 
                    nama_device: '', 
                    id_kategori: '', 
                    merek: '', 
                    model: '', 
                    nomor_seri: '', 
                    tanggal_pengadaan: '', 
                    status: 'aktif', 
                    id_departemen: '', 
                    id_user: '', 
                    deskripsi: '' 
                };
                this.generateDeviceCode();
                this.modalOpen = true;
            },

            openEdit(device) {
                this.mode = 'edit';
                this.form = { 
                    id: device.id, 
                    kode_device: device.kode, 
                    nama_device: device.nama, 
                    id_kategori: device.kategori, 
                    merek: device.merek !== 'Belum diisi' ? device.merek : '',
                    model: device.model !== 'Belum diisi' ? device.model : '',
                    nomor_seri: device.sn !== 'Belum diisi' ? device.sn : '', 
                    tanggal_pengadaan: device.tanggal_raw || '',
                    status: device.status, 
                    id_departemen: device.ruang_id || '', 
                    id_user: device.operator?.id || '', 
                    deskripsi: device.spesifikasi 
                };
                this.modalOpen = true;
            },

            openDetail(id) {
                this.detail = this.devices.find(d => d.id === id);
                this.tab = 'detail';
            },

            printQRLabel(device) {
                this.activeQRDevice = device;
                setTimeout(() => {
                    window.print();
                }, 200);
            },

            async submitForm() {
                if (this.saving) return;
                this.saving = true;

                const url = this.mode === 'add' ? storeUrl : updateUrlTpl.replace('__ID__', this.form.id);
                const method = this.mode === 'add' ? 'POST' : 'PUT';

                try {
                    const res = await fetch(url, {
                        method: method,
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify(this.form)
                    });
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Gagal menyimpan.');

                    if (this.mode === 'add') {
                        this.devices.unshift(data.device);
                    } else {
                        const idx = this.devices.findIndex(d => d.id === data.device.id);
                        if (idx !== -1) this.devices[idx] = data.device;
                    }

                    this.modalOpen = false;
                    this.showToast(data.message);
                } catch (e) {
                    this.showToast(e.message);
                } finally {
                    this.saving = false;
                }
            },

            askDelete(device) { this.confirmTarget = device; },

            async executeDelete() {
                if (!this.confirmTarget) return;
                const id = this.confirmTarget.id;
                const url = destroyUrlTpl.replace('__ID__', id);

                try {
                    const res = await fetch(url, {
                        method: 'DELETE',
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                    });
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Gagal menghapus.');

                    this.devices = this.devices.filter(d => d.id !== id);
                    this.confirmTarget = null;
                    this.showToast(data.message);
                } catch (e) {
                    this.showToast(e.message);
                }
            },

            showToast(msg) {
                this.toastMsg = msg;
                setTimeout(() => this.toastMsg = '', 3500);
            }
        }));
    });
</script>
@endsection