@extends('layouts.index')

@section('content')
@php
    $priorityLabels = ['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Mendesak'];
    $priorityStyles = [
        'rendah' => ['dot' => 'bg-emerald-500', 'text' => 'text-emerald-600'],
        'sedang' => ['dot' => 'bg-amber-500', 'text' => 'text-amber-500'],
        'tinggi' => ['dot' => 'bg-red-500', 'text' => 'text-red-600'],
    ];
    $statusLabels = [
        'open' => 'Pending',
        'confirmed' => 'Diproses',
        'process' => 'Diproses',
        'completed' => 'Selesai',
        'canceled' => 'Dibatalkan',
        'failed' => 'Gagal',
    ];
    $statusStyles = [
        'open' => 'bg-rose-100 text-rose-600',
        'confirmed' => 'bg-yellow-100 text-yellow-700',
        'process' => 'bg-yellow-100 text-yellow-700',
        'completed' => 'bg-green-100 text-green-700',
        'canceled' => 'bg-slate-100 text-slate-600',
        'failed' => 'bg-rose-100 text-rose-600',
    ];

    $ic = [
        'search'  => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'eye'     => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'inbox'   => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );
@endphp

<div x-data="{ sidebarOpen: false }"
     @keydown.escape.window="sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="tiket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="$userName" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul + Buat Tiket --}}
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Tiket Saya</h1>
                    <p class="mt-1 text-sm text-slate-600">Pantau status laporan kerusakan perangkat yang Anda buat</p>
                </div>
            </div>

            {{-- Tab status + pencarian --}}
            <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="-mx-1 flex gap-2 overflow-x-auto px-1 pb-1" role="tablist" aria-label="Filter status tiket">
                    @foreach ($statusCounts as $tab => $count)
                        @php
                            $filterParameters = [];
                            if ($search !== '') {
                                $filterParameters['search'] = $search;
                            }
                            if ($tab !== 'Semua') {
                                $filterParameters['status'] = $tab;
                            }
                        @endphp
                        <a href="{{ route('tickets.mine', $filterParameters) }}" role="tab"
                           aria-selected="{{ $selectedStatus === $tab ? 'true' : 'false' }}"
                           class="inline-flex shrink-0 items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold transition-colors {{ $selectedStatus === $tab ? 'border-[#10254a] bg-[#10254a] text-white' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' }}">
                            {{ $tab }}
                            <span class="rounded-full px-2 py-0.5 text-[11px] font-bold {{ $selectedStatus === $tab ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $count }}</span>
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('tickets.mine') }}" class="relative w-full lg:max-w-sm">
                    @if ($selectedStatus !== 'Semua')
                        <input type="hidden" name="status" value="{{ $selectedStatus }}">
                    @endif
                    <input type="search" name="search" value="{{ $search }}" placeholder="Cari tiket..."
                           class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                    <button type="submit" aria-label="Cari tiket" class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        {{ $icon('search') }}
                    </button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                @if ($tickets->isEmpty())
                    <div class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">{{ $icon('inbox', 'h-8 w-8') }}</div>
                        <h3 class="text-base font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
                        <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah kata kunci pencarian atau pilih status lain.</p>
                        <a href="{{ route('tickets.mine') }}" class="mt-4 rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-200">Reset filter</a>
                    </div>
                @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[980px] border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-200 bg-[#f1f5f9] text-sm font-semibold text-slate-900">
                                <th scope="col" class="px-5 py-4 text-center">No</th>
                                <th scope="col" class="px-5 py-4">ID Tiket</th>
                                <th scope="col" class="px-5 py-4">Tanggal Laporan</th>
                                <th scope="col" class="px-5 py-4">Perangkat</th>
                                <th scope="col" class="px-5 py-4">Subjek</th>
                                <th scope="col" class="px-5 py-4">Prioritas</th>
                                <th scope="col" class="px-5 py-4 text-center">Status</th>
                                <th scope="col" class="px-5 py-4">Teknisi</th>
                                <th scope="col" class="px-5 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                            @foreach ($tickets as $ticket)
                                @php
                                    $priorityLabel = $priorityLabels[$ticket->prioritas] ?? ucfirst($ticket->prioritas);
                                    $priorityStyle = $priorityStyles[$ticket->prioritas] ?? $priorityStyles['sedang'];
                                    $statusLabel = $statusLabels[$ticket->status] ?? ucfirst($ticket->status);
                                    $statusStyle = $statusStyles[$ticket->status] ?? 'bg-slate-100 text-slate-600';
                                @endphp
                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="px-5 py-4 text-center">{{ $tickets->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-4">
                                        <a href="{{ route('tickets.mine.show', ['ticket' => $ticket->getKey()]) }}"
                                           class="rounded font-medium transition-colors hover:text-blue-600 hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#10254a]/40">
                                            {{ $ticket->kode_ticket }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">{{ $ticket->tanggal->format('d/m/Y H:i') }}</td>
                                    <td class="px-5 py-4">{{ $ticket->device?->nama_device ?? 'Perangkat tidak tersedia' }}</td>
                                    <td class="max-w-[240px] truncate px-5 py-4" title="{{ $ticket->judul }}">{{ $ticket->judul }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex items-center gap-2 font-semibold {{ $priorityStyle['text'] }}">
                                            <span class="h-2 w-2 rounded-full {{ $priorityStyle['dot'] }}"></span>
                                            {{ $priorityLabel }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="inline-block min-w-[5.5rem] rounded-md px-3 py-1.5 text-xs font-semibold {{ $statusStyle }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="px-5 py-4">{{ $ticket->technician?->nama ?? 'Belum ditugaskan' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ route('tickets.mine.show', ['ticket' => $ticket->getKey()]) }}"
                                           class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-md border border-[#10254a] px-3.5 py-1.5 text-xs font-semibold text-[#10254a] transition-colors hover:bg-slate-50">
                                            {{ $icon('eye', 'h-3.5 w-3.5') }} Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-4 py-4 text-xs font-medium text-slate-600 sm:flex-row sm:px-6 sm:text-sm">
                    <span>Menampilkan {{ $tickets->firstItem() }} - {{ $tickets->lastItem() }} dari {{ $tickets->total() }} tiket</span>
                    <div class="flex items-center gap-1.5">
                        @if ($tickets->onFirstPage())
                            <span class="cursor-not-allowed rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 opacity-40">Sebelumnya</span>
                        @else
                            <a href="{{ $tickets->previousPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50">Sebelumnya</a>
                        @endif
                        @foreach ($tickets->getUrlRange(1, $tickets->lastPage()) as $page => $url)
                            @if ($page === $tickets->currentPage())
                                <span aria-current="page" class="h-8 min-w-[2rem] rounded-lg bg-[#10254a] px-2 py-1 font-semibold text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="h-8 min-w-[2rem] rounded-lg px-2 py-1 font-semibold text-slate-700 transition-colors hover:bg-slate-100">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if ($tickets->hasMorePages())
                            <a href="{{ $tickets->nextPageUrl() }}" class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition-colors hover:bg-slate-50">Selanjutnya</a>
                        @else
                            <span class="cursor-not-allowed rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 opacity-40">Selanjutnya</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </main>
    </div>
</div>

@endsection