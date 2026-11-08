@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY TICKET (frontend only).
     * Nanti ganti dengan data dari controller ($tickets).
     * createdAt dibuat relatif terhadap hari ini supaya filter waktu (Today / Last 7 Days / This Month) bisa dicoba.
     */
    $tickets = [
        ['id' => 'tc-001', 'ticketCode' => '#TC-001', 'subject' => 'PC tiba-tiba mati sendiri padahal baru dinyalakan', 'deviceId' => 'PC-PPDP-001',    'type' => 'Incident',   'urgency' => 'Mendesak', 'priorityLevel' => 'Urgent', 'status' => 'DALAM_PENGERJAAN', 'createdAt' => now()->subHours(3)->toIso8601String(),  'reporterName' => 'Andi Saputra',  'department' => 'IT Operations'],
        ['id' => 'tc-002', 'ticketCode' => '#TC-002', 'subject' => 'Printer rusak',                                       'deviceId' => 'LAP-PPM-010',    'type' => 'Problem',    'urgency' => 'Sedang',   'priorityLevel' => 'Medium', 'status' => 'MENUNGGU',          'createdAt' => now()->subHours(8)->toIso8601String(),  'reporterName' => 'Dewi Lestari',  'department' => 'Finance'],
        ['id' => 'tc-003', 'ticketCode' => '#TC-003', 'subject' => 'AC nya ora dingin mas',                               'deviceId' => 'RTR-PDDPB-001',  'type' => 'Question',   'urgency' => 'Rendah',   'priorityLevel' => 'Low',    'status' => 'BARU',              'createdAt' => now()->subDays(1)->toIso8601String(),   'reporterName' => 'Rian Hidayat',  'department' => 'General Affairs'],
        ['id' => 'tc-004', 'ticketCode' => '#TC-004', 'subject' => 'Gaji saya belum cair',                                'deviceId' => 'PRN-PPKR-001',   'type' => 'Suggestion', 'urgency' => 'Mendesak', 'priorityLevel' => 'Urgent', 'status' => 'BARU',              'createdAt' => now()->subDays(2)->toIso8601String(),   'reporterName' => 'Budi Setiawan', 'department' => 'HR'],
        ['id' => 'tc-005', 'ticketCode' => '#TC-005', 'subject' => 'Is this thing working?',                              'deviceId' => 'SCN-PPSE-001',   'type' => 'Incident',   'urgency' => 'Sedang',   'priorityLevel' => 'Medium', 'status' => 'DALAM_PENGERJAAN', 'createdAt' => now()->subDays(4)->toIso8601String(),   'reporterName' => 'Maya Sari',     'department' => 'Marketing'],
        ['id' => 'tc-006', 'ticketCode' => '#TC-006', 'subject' => 'Nigerundayo!!!',                                       'deviceId' => 'CAM-PPPB-001',   'type' => 'Problem',    'urgency' => 'Mendesak', 'priorityLevel' => 'Urgent', 'status' => 'DALAM_PENGERJAAN', 'createdAt' => now()->subDays(6)->toIso8601String(),   'reporterName' => 'Fikri',         'department' => 'Security'],
    ];

    // URL halaman detail. Sementara semua baris menuju halaman yang sama (belum terhubung ke database).
    // Nanti: url('/admin/ticket/__ID__') atau route('admin.tickets.show', ['ticket' => '__ID__']),
    // lalu aktifkan baris .replace('__ID__', ...) di fungsi detailUrl().
    $detailUrl = url('/admin/ticket/detail');

    // Path ikon (Heroicons outline)
    $ic = [
        'ticket'    => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z',
        'clipboard' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
        'clock'     => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        'check'     => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'trash'     => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'warning'   => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        'close'     => 'M6 18L18 6M6 6l12 12',
        'inbox'     => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
        'sort'      => 'M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4',
        'eye'       => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'edit'      => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    // Kartu statistik: [label, kunci status ('total' = semua), keterangan, ikon, warna ikon]
    $stats = [
        ['Total Tiket',       'total',            'Akumulasi keseluruhan tiket masuk',    'ticket',    'bg-sky-100 text-sky-600'],
        ['Tiket Baru',        'BARU',             'Tiket yang belum ditangani',           null,        null],
        ['Dalam Pengerjaan',  'DALAM_PENGERJAAN', 'Tiket yang sedang berlangsung',        'clipboard', 'bg-rose-50 text-rose-500'],
        ['Menunggu',          'MENUNGGU',         'Tertunda ketersediaan sparepart',      'clock',     'bg-amber-50 text-amber-500'],
        ['Selesai',           'SELESAI',          'Tiket yang sudah diproses dan selesai','check',     'bg-emerald-50 text-emerald-500'],
    ];

    // Kolom tabel yang bisa diurutkan
    $columns = ['ticketCode' => 'ID Tiket', 'subject' => 'Subjek', 'deviceId' => 'ID Perangkat', 'type' => 'Jenis', 'urgency' => 'Urgensi'];
@endphp

<div x-data="ticketsPage(@js($tickets), @js($detailUrl))"
     @keydown.escape.window="modal = null; menu = null; openDd = null; sidebarOpen = false"
     class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar admin --}}
    <x-sidebar role="admin" active="ticket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Ticket</h1>
                <p class="mt-1 text-sm text-slate-600">Pantau dan kelola seluruh aktivitas perangkat serta penanganan kerusakan</p>
            </div>

            {{-- ============ KARTU STATISTIK ============ --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($stats as [$label, $key, $caption, $iconKey, $iconColor])
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow">
                        <div class="mb-3 flex items-center justify-between gap-2">
                            <span class="text-sm font-semibold text-slate-800">{{ $label }}</span>
                            @if ($iconKey)
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $iconColor }}">{{ $icon($iconKey) }}</span>
                            @else
                                <span class="rounded bg-amber-500 px-1.5 py-0.5 text-[10px] font-extrabold tracking-wider text-white">NEW</span>
                            @endif
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl" x-text="count('{{ $key }}')"></div>
                            <p class="mt-1 text-[11px] font-medium text-slate-400">{{ $caption }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ============ FILTER / AKSI MASSAL ============ --}}
            <div class="mb-5 flex flex-col items-stretch justify-between gap-3 sm:flex-row sm:items-center">

                <x-ticket.filter-dropdown name="range" align="left" width="sm:min-w-[160px]" :options="['All Time', 'Today', 'Last 7 Days', 'This Month']" />

                {{-- Filter biasa (tampil kalau belum ada yang dipilih) --}}
                <div x-show="selected.length === 0" x-transition.opacity class="flex w-full items-center gap-2 sm:w-auto sm:gap-3">
                    <x-ticket.filter-dropdown name="priority" :options="['All Priority', 'Urgent', 'Medium', 'Low']" />
                    <x-ticket.filter-dropdown name="type" :options="['All Type', 'Incident', 'Problem', 'Question', 'Suggestion']" />
                    <x-ticket.filter-dropdown name="sort" :options="['Default', 'Newest', 'Oldest']" />
                </div>

                {{-- Aksi massal (muncul kalau ada tiket yang dipilih) --}}
                <div x-show="selected.length > 0" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex w-full flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2 shadow-sm sm:w-auto sm:flex-nowrap sm:justify-end sm:border-0 sm:bg-transparent sm:p-0 sm:shadow-none">

                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex h-7 min-w-[1.75rem] items-center justify-center rounded-full bg-[#10254a] px-2 text-xs font-bold text-white" x-text="selected.length"></span>
                        <span class="text-sm font-semibold text-slate-600">tiket terpilih</span>
                        <button type="button" @click="selected = []" class="rounded-md px-2 py-1 text-xs font-semibold text-slate-500 underline-offset-2 transition-colors hover:text-slate-800 hover:underline">
                            Batal pilih
                        </button>
                    </div>

                    <div class="flex items-center gap-2.5">
                        <button type="button" @click="bulkEdit()" :disabled="selected.length !== 1"
                                :title="selected.length !== 1 ? 'Pilih satu tiket saja untuk mengedit' : 'Edit tiket'"
                                class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold shadow-sm transition-colors sm:w-28"
                                :class="selected.length === 1 ? 'bg-[#10254a] text-white hover:bg-[#0b1b3a]' : 'cursor-not-allowed bg-slate-100 text-slate-400 shadow-none'">
                            {{ $icon('edit') }} Edit
                        </button>
                        <button type="button" @click="askDelete(selected)"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-red-700 sm:w-32">
                            {{ $icon('trash') }} Delete
                        </button>
                    </div>
                </div>
            </div>

            {{-- ============ TABEL ============ --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Kosong --}}
                <div x-show="filtered.length === 0" x-cloak class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-8 w-8') }}</div>
                    <h3 class="text-base font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
                    <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah opsi filter yang dipilih.</p>
                    <button type="button" @click="resetFilters()" class="mt-4 rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-200">Reset filter</button>
                </div>

                <div x-show="filtered.length > 0" class="overflow-x-auto">
                    <table class="w-full min-w-[760px] border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-200 bg-[#f0f5fa] text-xs text-slate-800">
                                <th scope="col" class="w-16 py-4 pl-6 pr-2">
                                    <x-ticket.checkbox label="Pilih semua tiket di halaman ini"
                                                x-bind:checked="allPageSelected"
                                                x-on:change="toggleAll($event.target.checked)"
                                                indeterminate="somePageSelected && !allPageSelected" />
                                </th>
                                @foreach ($columns as $key => $heading)
                                    <th scope="col" class="px-4 py-4 font-bold" :aria-sort="sortKey === '{{ $key }}' ? (sortDir === 'asc' ? 'ascending' : 'descending') : 'none'">
                                        <button type="button" @click="sortBy('{{ $key }}')" class="inline-flex items-center gap-1.5 transition-colors hover:text-[#10254a]">
                                            {{ $heading }}
                                            <span :class="sortKey === '{{ $key }}' && filters.sort === 'Default' ? 'text-[#10254a]' : 'text-slate-400'">{{ $icon('sort', 'h-3.5 w-3.5') }}</span>
                                        </button>
                                    </th>
                                @endforeach
                                <th scope="col" class="w-12 py-4 pl-2 pr-6"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <template x-for="t in pageRows" :key="t.id">
                                <tr class="cursor-pointer transition-colors" @click="goDetail(t)"
                                    :class="selected.includes(t.id) ? 'bg-[#f1f5fb]' : 'hover:bg-slate-50/70'">
                                    <td class="py-4 pl-6 pr-2" @click.stop>
                                        <x-ticket.checkbox x-bind:checked="selected.includes(t.id)"
                                                    x-on:change="toggle(t.id)"
                                                    x-bind:aria-label="'Pilih tiket ' + t.ticketCode" />
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-4 font-bold text-slate-900">
                                        {{-- Link asli: bisa di-klik tengah / buka di tab baru, dan terbaca keyboard & screen reader --}}
                                        <a :href="detailUrl(t)" @click.stop x-text="t.ticketCode"
                                           class="rounded transition-colors hover:text-[#10254a] hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40"></a>
                                    </td>
                                    <td class="max-w-[260px] truncate px-4 py-4 text-slate-700" x-text="t.subject" :title="t.subject"></td>
                                    <td class="whitespace-nowrap px-4 py-4 text-slate-600" x-text="t.deviceId"></td>
                                    <td class="whitespace-nowrap px-4 py-4 font-semibold text-slate-800" x-text="t.type"></td>
                                    <td class="whitespace-nowrap px-4 py-4">
                                        <span class="inline-flex items-center gap-2 font-semibold" :class="urgencyStyle[t.urgency].text">
                                            <span class="h-2 w-2 rounded-full" :class="urgencyStyle[t.urgency].dot"></span>
                                            <span x-text="t.urgency"></span>
                                        </span>
                                    </td>
                                    <td class="py-4 pl-2 pr-6 text-right" @click.stop>
                                        <button type="button" @click.stop="openMenu($event, t)" aria-haspopup="menu"
                                                :aria-expanded="menu && menu.id === t.id"
                                                :aria-label="'Opsi tiket ' + t.ticketCode"
                                                class="rounded-lg p-1.5 text-slate-700 transition-colors hover:bg-slate-100 hover:text-slate-900"
                                                :class="menu && menu.id === t.id ? 'bg-slate-100' : ''">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div x-show="filtered.length > 0" class="flex flex-col items-center justify-between gap-4 border-t border-slate-200 px-4 py-4 text-xs font-medium text-slate-600 sm:flex-row sm:px-6 sm:text-sm">
                    <div class="flex w-full items-center justify-between gap-4 sm:w-auto sm:justify-start">
                        <span x-text="`Menampilkan ${rangeFrom} - ${rangeTo} dari ${filtered.length} data tiket`"></span>
                        <label class="flex items-center gap-2">
                            <span class="hidden text-xs text-slate-400 md:inline">Per halaman:</span>
                            <select x-model.number="perPage" @change="page = 1" class="cursor-pointer rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                <option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                            </select>
                        </label>
                    </div>
                    <div class="flex w-full items-center justify-center gap-1.5 sm:w-auto sm:justify-end">
                        <button type="button" @click="page--" :disabled="page <= 1"
                                class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Sebelumnya</button>
                        <template x-for="p in pageNumbers" :key="p">
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

    {{-- ============ MENU AKSI BARIS (fixed supaya tidak terpotong tabel) ============ --}}
    <div x-show="menu" x-cloak x-transition.opacity.duration.100ms @click.outside="menu = null" role="menu"
         class="fixed z-50 w-36 rounded-xl border border-slate-200 bg-white py-1.5 shadow-lg"
         :style="menu ? `top:${menu.top}px; right:${menu.right}px` : ''">
        <button type="button" role="menuitem" @click="viewTicket(menu.ticket); menu = null" class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-slate-800 transition-colors hover:bg-slate-50">
            {{ $icon('eye', 'h-4 w-4 text-slate-500') }} View
        </button>
        <button type="button" role="menuitem" @click="editTicket(menu.ticket); menu = null" class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-slate-800 transition-colors hover:bg-slate-50">
            {{ $icon('edit', 'h-4 w-4 text-slate-500') }} Edit
        </button>
        <button type="button" role="menuitem" @click="askDelete([menu.id]); menu = null" class="flex w-full items-center gap-2.5 px-4 py-2 text-left text-sm font-medium text-red-600 transition-colors hover:bg-red-50">
            {{ $icon('trash', 'h-4 w-4') }} Delete
        </button>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed right-5 top-5 z-[100] rounded-xl border border-slate-700 bg-[#10254a] px-4 py-3 text-sm font-medium text-white shadow-lg" role="status">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ MODAL KONFIRMASI HAPUS ============ --}}
    <div x-show="modal === 'delete'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="alertdialog" aria-modal="true" aria-labelledby="modal-delete-title">
        <div x-show="modal === 'delete'" x-transition.opacity @click="modal = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'delete'" x-transition class="relative w-full max-w-[480px] overflow-hidden rounded-2xl bg-white p-5 shadow-2xl sm:p-7">
            <form action="#" method="POST" @submit.prevent="confirmDelete()">
                @csrf
                @method('DELETE')
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-600 sm:h-12 sm:w-12">{{ $icon('trash', 'h-5 w-5 sm:h-6 sm:w-6') }}</div>
                        <div>
                            <h3 id="modal-delete-title" class="text-lg font-bold leading-tight text-slate-900 sm:text-xl">Konfirmasi Hapus Tiket</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-400">Aksi kritis, perlu konfirmasi</p>
                        </div>
                    </div>
                    <button type="button" @click="modal = null" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                </div>

                <div class="mb-6 space-y-3 text-xs leading-relaxed text-slate-600 sm:space-y-4 sm:text-sm">
                    <p>
                        Apakah Anda yakin ingin menghapus
                        <strong class="font-semibold text-slate-900" x-text="deleteLabel"></strong>?
                        Tindakan ini bersifat <strong class="font-semibold text-slate-900">permanen</strong> dan data yang telah dihapus tidak dapat dipulihkan kembali.
                    </p>
                    <div class="flex items-start gap-2.5 rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs leading-normal text-amber-900 sm:p-3.5">
                        <span class="mt-0.5 shrink-0 text-amber-600">{{ $icon('warning') }}</span>
                        <span><strong class="font-semibold">Perhatian:</strong> Riwayat perbaikan yang terhubung dengan tiket ini juga akan terhapus.</span>
                    </div>
                </div>

                <div class="flex flex-col-reverse items-stretch justify-end gap-2.5 pt-2 sm:flex-row sm:items-center sm:gap-3">
                    <button type="button" @click="modal = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                        {{ $icon('trash') }} Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ticketsPage', (initialTickets, detailUrlBase) => ({
            sidebarOpen: false,
            tickets: initialTickets,

            // Filter & urutan
            filters: { range: 'Last 7 Days', priority: 'All Priority', type: 'All Type', sort: 'Default' },
            defaults: { range: 'Last 7 Days', priority: 'All Priority', type: 'All Type', sort: 'Default' },
            openDd: null,
            sortKey: null,
            sortDir: 'asc',

            // Paginasi
            page: 1,
            perPage: 10,

            // Pilihan baris & UI
            selected: [],
            menu: null,             // { id, ticket, top, right }
            modal: null,            // 'delete' | null
            deleteIds: [],
            toastMsg: '',
            toastTimer: null,

            urgencyStyle: {
                Mendesak: { dot: 'bg-red-500',     text: 'text-red-600' },
                Sedang:   { dot: 'bg-amber-500',   text: 'text-amber-500' },
                Rendah:   { dot: 'bg-emerald-500', text: 'text-emerald-600' },
            },

            init() {
                // Saat filter berubah: kembali ke halaman 1 & buang pilihan yang sudah tidak terlihat
                this.$watch('filters', () => {
                    this.page = 1;
                    this.selected = this.selected.filter(id => this.filtered.some(t => t.id === id));
                }, { deep: true });

                // Jaga nomor halaman tetap valid
                this.$watch('totalPages', (n) => { if (this.page > n) this.page = n; });

                // Tutup menu baris saat area mana pun di-scroll / layar diubah ukurannya
                document.addEventListener('scroll', () => { this.menu = null; }, true);
                window.addEventListener('resize', () => { this.menu = null; });
            },

            // ---------- Data turunan ----------
            count(status) {
                return status === 'total' ? this.tickets.length : this.tickets.filter(t => t.status === status).length;
            },

            inRange(t) {
                const d = new Date(t.createdAt), now = new Date();
                switch (this.filters.range) {
                    case 'Today':       return d.toDateString() === now.toDateString();
                    case 'Last 7 Days': return now - d <= 7 * 24 * 60 * 60 * 1000;
                    case 'This Month':  return d.getMonth() === now.getMonth() && d.getFullYear() === now.getFullYear();
                    default:            return true;
                }
            },

            get filtered() {
                const f = this.filters;
                let list = this.tickets.filter(t =>
                    this.inRange(t) &&
                    (f.priority.startsWith('All') || t.priorityLevel === f.priority) &&
                    (f.type.startsWith('All') || t.type === f.type)
                );
                if (f.sort === 'Newest')      list.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
                else if (f.sort === 'Oldest') list.sort((a, b) => new Date(a.createdAt) - new Date(b.createdAt));
                else if (this.sortKey) {
                    const dir = this.sortDir === 'asc' ? 1 : -1;
                    list.sort((a, b) => String(a[this.sortKey]).localeCompare(String(b[this.sortKey]), 'id', { numeric: true }) * dir);
                }
                return list;
            },

            get totalPages()  { return Math.max(1, Math.ceil(this.filtered.length / this.perPage)); },
            get pageRows()    { const s = (this.page - 1) * this.perPage; return this.filtered.slice(s, s + this.perPage); },
            get rangeFrom()   { return this.filtered.length ? (this.page - 1) * this.perPage + 1 : 0; },
            get rangeTo()     { return Math.min(this.page * this.perPage, this.filtered.length); },
            get pageNumbers() {
                const total = this.totalPages, cur = this.page;
                const start = Math.max(1, Math.min(cur - 2, total - 4)), end = Math.min(total, start + 4);
                return Array.from({ length: end - start + 1 }, (_, i) => start + i);
            },

            // ---------- Pilihan baris ----------
            get allPageSelected()  { return this.pageRows.length > 0 && this.pageRows.every(t => this.selected.includes(t.id)); },
            get somePageSelected() { return this.pageRows.some(t => this.selected.includes(t.id)); },

            toggle(id) {
                this.selected = this.selected.includes(id) ? this.selected.filter(x => x !== id) : [...this.selected, id];
            },
            toggleAll(checked) {
                const ids = this.pageRows.map(t => t.id);
                this.selected = checked
                    ? [...new Set([...this.selected, ...ids])]
                    : this.selected.filter(id => !ids.includes(id));
            },

            // ---------- Filter ----------
            label(name) {
                if (name === 'sort') return this.filters.sort === 'Default' ? 'Sort By' : this.filters.sort;
                return this.filters[name];
            },
            setFilter(name, value) {
                this.filters[name] = value;
                if (name === 'sort') this.sortKey = null;   // dropdown Sort By menggantikan urutan kolom
                this.openDd = null;
            },
            sortBy(key) {
                this.filters.sort = 'Default';
                if (this.sortKey === key) this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
                else { this.sortKey = key; this.sortDir = 'asc'; }
            },
            resetFilters() { this.filters = { ...this.defaults }; this.sortKey = null; },

            // ---------- Menu baris ----------
            openMenu(e, t) {
                if (this.menu && this.menu.id === t.id) { this.menu = null; return; }
                const r = e.currentTarget.getBoundingClientRect();
                const height = 130;                                      // perkiraan tinggi menu
                const top = (window.innerHeight - r.bottom < height + 8) ? r.top - height - 4 : r.bottom + 4;
                this.menu = { id: t.id, ticket: t, top, right: window.innerWidth - r.right };
            },

            // ---------- Aksi (frontend saja, sambungkan ke route backend nanti) ----------
            detailUrl(t)  { return detailUrlBase; /* nanti: detailUrlBase.replace('__ID__', encodeURIComponent(t.id)) */ },
            goDetail(t)   { window.location.href = this.detailUrl(t); },
            viewTicket(t) { this.goDetail(t); },
            editTicket(t) { this.toast(`Edit ${t.ticketCode}: sambungkan ke route edit tiket.`); },
            bulkEdit() {
                const t = this.tickets.find(x => x.id === this.selected[0]);
                if (this.selected.length === 1 && t) this.editTicket(t);
            },

            askDelete(ids) {
                this.deleteIds = [...ids];
                this.modal = 'delete';
            },
            get deleteLabel() {
                if (this.deleteIds.length === 1) {
                    const t = this.tickets.find(x => x.id === this.deleteIds[0]);
                    return t ? `tiket ${t.ticketCode}` : 'tiket ini';
                }
                return `${this.deleteIds.length} tiket terpilih`;
            },
            confirmDelete() {
                const n = this.deleteIds.length;
                this.tickets = this.tickets.filter(t => !this.deleteIds.includes(t.id));
                this.selected = this.selected.filter(id => !this.deleteIds.includes(id));
                this.deleteIds = [];
                this.modal = null;
                this.toast(`${n} tiket berhasil dihapus.`);
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