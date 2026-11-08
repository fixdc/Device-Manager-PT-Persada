@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan tiket milik user yang login ($tickets).
     * Tanggal ditulis tanpa zona waktu (YYYY-MM-DDTHH:mm:ss).
     */
    $tickets = [
        ['id' => '#TC-024', 'date' => '2026-11-05T10:00:00', 'device' => 'Laptop Acer',                  'deviceCode' => 'DEV-001', 'subject' => 'Laptop mati sendiri saat dicas',  'category' => 'Hardware',                      'urgency' => 'Urgent', 'status' => 'Diproses', 'technician' => 'Riski November', 'finishedAt' => null,                  'complaint' => 'Laptop mati mendadak setiap kali charger dicolokkan, padahal baterai masih terisi.', 'handling' => 'Sedang dilakukan pengecekan adaptor dan port pengisian daya.'],
        ['id' => '#TC-021', 'date' => '2026-11-02T09:20:00', 'device' => 'Monitor LG 24 Inch UltraGear', 'deviceCode' => 'DEV-002', 'subject' => 'Layar berkedip saat kecerahan tinggi', 'category' => 'Hardware',                  'urgency' => 'Sedang', 'status' => 'Pending',  'technician' => null,             'finishedAt' => null,                  'complaint' => 'Layar berkedip setiap kali kecerahan dinaikkan di atas 70 persen.',                   'handling' => null],
        ['id' => '#TC-017', 'date' => '2026-10-17T13:10:00', 'device' => 'Laptop Acer',                  'deviceCode' => 'DEV-001', 'subject' => 'Main Valorant lag cuma dapet 20 FPS', 'category' => 'Hardware',               'urgency' => 'Sedang', 'status' => 'Selesai',  'technician' => 'Riski November', 'finishedAt' => '2026-10-20T15:00:00', 'complaint' => 'Game berat berjalan di 20 FPS walaupun pengaturan grafis sudah diturunkan.',             'handling' => 'Menambah RAM menjadi 16 GB dan memasang kartu grafis tambahan, lalu diuji 2 jam.'],
        ['id' => '#TC-012', 'date' => '2026-10-08T08:45:00', 'device' => 'Laptop Acer',                  'deviceCode' => 'DEV-001', 'subject' => 'Wi-Fi sering terputus',           'category' => 'Jaringan / Internet',           'urgency' => 'Rendah', 'status' => 'Selesai',  'technician' => 'Siti Aisyah',    'finishedAt' => '2026-10-09T11:30:00', 'complaint' => 'Koneksi Wi-Fi terputus setiap 10 menit saat meeting daring.',                           'handling' => 'Driver adapter nirkabel diperbarui dan profil jaringan direset.'],
        ['id' => '#TC-009', 'date' => '2026-09-25T14:35:00', 'device' => 'Monitor LG 24 Inch UltraGear', 'deviceCode' => 'DEV-002', 'subject' => 'Kabel HDMI longgar',              'category' => 'Hardware',                      'urgency' => 'Rendah', 'status' => 'Selesai',  'technician' => 'Rina Wulandari', 'finishedAt' => '2026-09-26T09:00:00', 'complaint' => 'Gambar sering hilang sebentar kalau kabel HDMI tersenggol.',                              'handling' => 'Kabel HDMI diganti dengan kabel baru dan konektor dikencangkan.'],
    ];

    // Halaman terkait (ganti dengan route kamu)
    $createUrl = url('/tiket/buat');
    $deviceUrl = url('/perangkat-saya');

    // Path ikon (Heroicons outline)
    $ic = [
        'search'  => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'eye'     => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'plus'    => 'M12 4v16m8-8H4',
        'close'   => 'M6 18L18 6M6 6l12 12',
        'monitor' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'inbox'   => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );
@endphp

<div x-data="myTickets(@js($tickets), @js($deviceUrl))"
     @keydown.escape.window="detail = null; sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="tiket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul + Buat Tiket --}}
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Tiket Saya</h1>
                    <p class="mt-1 text-sm text-slate-600">Pantau status laporan kerusakan perangkat yang Anda buat</p>
                </div>
                <a href="{{ $createUrl }}" class="inline-flex shrink-0 items-center justify-center gap-2 self-start rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]">
                    {{ $icon('plus') }} Buat Tiket
                </a>
            </div>

            {{-- Tab status + pencarian --}}
            <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1" role="tablist" aria-label="Filter status tiket">
                    <template x-for="tab in tabs" :key="tab">
                        <button type="button" role="tab" @click="status = tab" :aria-selected="status === tab"
                                class="inline-flex shrink-0 items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition-colors"
                                :class="status === tab ? 'border-[#10254a] bg-[#10254a] text-white' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'">
                            <span x-text="tab"></span>
                            <span class="rounded-full px-2 py-0.5 text-[11px] font-bold"
                                  :class="status === tab ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600'" x-text="countOf(tab)"></span>
                        </button>
                    </template>
                </div>

                <div class="relative w-full lg:max-w-sm">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('search') }}</span>
                    <input type="search" x-model.debounce.200ms="search" placeholder="Cari tiket..."
                           class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                </div>
            </div>

            {{-- Tabel --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div x-show="filtered.length === 0" x-cloak class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-8 w-8') }}</div>
                    <h3 class="text-base font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
                    <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah kata kunci pencarian atau pilih status lain.</p>
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
                                <th scope="col" class="px-5 py-4">Urgensi</th>
                                <th scope="col" class="px-5 py-4 text-center">Status</th>
                                <th scope="col" class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                            <template x-for="(t, i) in pageRows" :key="t.id">
                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="px-5 py-4 text-center" x-text="(page - 1) * perPage + i + 1"></td>
                                    <td class="px-5 py-4">
                                        <button type="button" @click="detail = t" x-text="t.id"
                                                class="rounded font-medium transition-colors hover:text-blue-600 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40"></button>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4" x-text="fmt(t.date)"></td>
                                    <td class="px-5 py-4" x-text="t.device"></td>
                                    <td class="max-w-[240px] truncate px-5 py-4" x-text="t.subject" :title="t.subject"></td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex items-center gap-2 font-semibold" :class="urgencyStyle[t.urgency].text">
                                            <span class="h-2 w-2 rounded-full" :class="urgencyStyle[t.urgency].dot"></span>
                                            <span x-text="t.urgency"></span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-block min-w-[5.5rem] rounded-md px-3 py-1.5 text-xs font-semibold" :class="statusStyle[t.status]" x-text="t.status"></span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <button type="button" @click="detail = t"
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
                    <span x-text="`Menampilkan ${rangeFrom} - ${rangeTo} dari ${filtered.length} tiket`"></span>
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

    {{-- ============ POP UP DETAIL TIKET ============ --}}
    <div x-show="detail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="detail-title">
        <div x-show="detail" x-transition.opacity @click="detail = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="detail" x-transition class="relative flex max-h-[92vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <template x-if="detail">
                <div class="flex min-h-0 flex-1 flex-col">
                    <div class="flex shrink-0 items-start justify-between gap-3 border-b border-slate-100 p-5 sm:p-7">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <h3 id="detail-title" class="text-xl font-bold text-slate-900 sm:text-2xl">Detail Tiket</h3>
                                <span class="rounded-md px-2.5 py-1 text-xs font-semibold" :class="statusStyle[detail.status]" x-text="detail.status"></span>
                            </div>
                            <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                                <span class="font-semibold text-slate-700" x-text="detail.id"></span> &middot; <span x-text="detail.subject"></span>
                            </p>
                        </div>
                        <button type="button" @click="detail = null" class="shrink-0 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                    </div>

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
                            <h4 class="mb-1.5 text-xs font-bold text-slate-800">Keluhan Anda</h4>
                            <p class="rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700" x-text="detail.complaint"></p>
                        </div>

                        <div>
                            <h4 class="mb-1.5 text-xs font-bold text-slate-800">Penanganan Teknisi</h4>
                            <p class="rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed"
                               :class="detail.handling ? 'text-slate-700' : 'italic text-slate-400'"
                               x-text="detail.handling || 'Belum ada penanganan. Tiket Anda menunggu teknisi.'"></p>
                        </div>
                    </div>

                    <div class="flex shrink-0 flex-col-reverse items-stretch justify-end gap-2.5 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-7">
                        <button type="button" @click="detail = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Tutup</button>
                        <a :href="deviceUrl" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a]">
                            {{ $icon('monitor') }} Lihat Perangkat
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('myTickets', (tickets, deviceUrl) => ({
            sidebarOpen: false,
            tickets,
            deviceUrl,

            tabs: ['Semua', 'Pending', 'Diproses', 'Selesai'],
            status: 'Semua',
            search: '',
            page: 1,
            perPage: 8,
            detail: null,

            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],

            statusStyle: {
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
                this.$watch('search', () => this.page = 1);
                this.$watch('status', () => this.page = 1);
            },

            pad(n) { return String(n).padStart(2, '0'); },
            fmt(iso) {
                if (!iso) return '-';
                const d = new Date(iso);
                return `${this.pad(d.getDate())} ${this.monthsShort[d.getMonth()]} ${d.getFullYear()}, ${this.pad(d.getHours())}:${this.pad(d.getMinutes())}`;
            },

            countOf(tab) { return tab === 'Semua' ? this.tickets.length : this.tickets.filter(t => t.status === tab).length; },

            get filtered() {
                const q = this.search.trim().toLowerCase();
                return this.tickets.filter(t =>
                    (this.status === 'Semua' || t.status === this.status) &&
                    (!q || [t.id, t.device, t.deviceCode, t.subject].some(v => (v || '').toLowerCase().includes(q)))
                );
            },
            get totalPages() { return Math.max(1, Math.ceil(this.filtered.length / this.perPage)); },
            get pageRows()   { const s = (this.page - 1) * this.perPage; return this.filtered.slice(s, s + this.perPage); },
            get rangeFrom()  { return this.filtered.length ? (this.page - 1) * this.perPage + 1 : 0; },
            get rangeTo()    { return Math.min(this.page * this.perPage, this.filtered.length); },

            resetFilters() { this.search = ''; this.status = 'Semua'; },

            detailFields(t) {
                return [
                    { label: 'Tanggal Laporan', value: this.fmt(t.date) },
                    { label: 'Perangkat',       value: t.device, sub: t.deviceCode },
                    { label: 'Kategori',        value: t.category },
                    { label: 'Urgensi',         value: t.urgency },
                    { label: 'Ditangani oleh',  value: t.technician || 'Belum ditugaskan' },
                    { label: 'Tanggal Selesai', value: t.finishedAt ? this.fmt(t.finishedAt) : 'Belum selesai' },
                ];
            },
        }));
    });
</script>
@endsection