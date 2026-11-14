@extends('layouts.index')

@section('content')
@php
    $statusLabels = [
        'open' => 'Baru / Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'canceled' => 'Dibatalkan',
        'process' => 'Dalam Pengerjaan',
        'completed' => 'Normal/Berhasil',
        'failed' => 'Rusak',
    ];
    $statusClasses = [
        'open' => 'bg-sky-50 text-sky-700',
        'confirmed' => 'bg-amber-50 text-amber-700',
        'canceled' => 'bg-slate-100 text-slate-600',
        'process' => 'bg-indigo-50 text-indigo-700',
        'completed' => 'bg-emerald-50 text-emerald-700',
        'failed' => 'bg-rose-50 text-rose-700',
    ];
    $priorityLabels = ['rendah' => 'Rendah', 'sedang' => 'Sedang', 'tinggi' => 'Mendesak'];
    $priorityClasses = [
        'rendah' => 'text-emerald-700',
        'sedang' => 'text-amber-700',
        'tinggi' => 'text-rose-700',
    ];
    $statCards = [
        ['Total Tiket', 'total', 'Akumulasi keseluruhan tiket'],
        ['Tiket Baru', 'new', 'Belum ditangani'],
        ['Dalam Pengerjaan', 'in_process', 'Sedang ditangani'],
        ['Menunggu', 'waiting', 'Menunggu tindak lanjut'],
        ['Normal/Berhasil', 'completed', 'Sudah selesai ditangani'],
    ];
    $inputClass = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
@endphp

<div class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">
    <x-sidebar role="admin" active="ticket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="auth()->user()->nama" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Ticket</h1>
                <p class="mt-1 text-sm text-slate-600">Pantau dan kelola seluruh aktivitas perangkat serta penanganan kerusakan</p>
            </div>

            @if (session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($statCards as [$label, $key, $caption])
                    <div class="flex flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <span class="text-sm font-semibold text-slate-800">{{ $label }}</span>
                        <div class="mt-3">
                            <div class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">{{ number_format($stats[$key]) }}</div>
                            <p class="mt-1 text-[11px] font-medium text-slate-400">{{ $caption }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <form method="GET" action="{{ route('admin.tickets.index') }}" class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-6">
                    <label class="sm:col-span-2 lg:col-span-2">
                        <span class="mb-1.5 block text-xs font-semibold text-slate-600">Cari tiket</span>
                        <input type="search" name="search" value="{{ $filters['search'] }}" placeholder="Kode, judul, perangkat, atau pelapor"
                               class="{{ $inputClass }}">
                    </label>
                    <label>
                        <span class="mb-1.5 block text-xs font-semibold text-slate-600">Dari tanggal</span>
                        <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="{{ $inputClass }}">
                    </label>
                    <label>
                        <span class="mb-1.5 block text-xs font-semibold text-slate-600">Sampai tanggal</span>
                        <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="{{ $inputClass }}">
                    </label>
                    <label>
                        <span class="mb-1.5 block text-xs font-semibold text-slate-600">Prioritas</span>
                        <select name="priority" class="{{ $inputClass }}">
                            <option value="">Semua Prioritas</option>
                            @foreach ($priorityLabels as $value => $label)
                                <option value="{{ $value }}" @selected($filters['priority'] === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span class="mb-1.5 block text-xs font-semibold text-slate-600">Urutan</span>
                        <select name="sort" class="{{ $inputClass }}">
                            <option value="newest" @selected($filters['sort'] === 'newest')>Terbaru</option>
                            <option value="oldest" @selected($filters['sort'] === 'oldest')>Terlama</option>
                        </select>
                    </label>
                </div>
                <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-slate-500">Filter jenis laporan tidak tersedia karena kategori belum disimpan pada skema tiket.</p>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.tickets.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50">Reset</a>
                        <button type="submit" class="rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]">Terapkan Filter</button>
                    </div>
                </div>
                @if ($errors->any())
                    <p role="alert" class="mt-3 text-sm font-medium text-rose-700">{{ $errors->first() }}</p>
                @endif
            </form>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="font-bold text-slate-900">Daftar Tiket</h2>
                    <span class="text-xs font-medium text-slate-500">{{ number_format($tickets->total()) }} tiket</span>
                </div>
                @if ($tickets->isEmpty())
                    <div class="flex flex-col items-center justify-center p-12 text-center">
                        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
                        <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah kata kunci atau filter yang dipilih.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[980px] border-collapse text-left">
                            <thead>
                                <tr class="border-b border-slate-200 bg-[#f0f5fa] text-xs text-slate-800">
                                    <th scope="col" class="px-5 py-4 font-bold">Kode Tiket</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Judul</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Perangkat</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Pelapor</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Prioritas</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Status</th>
                                    <th scope="col" class="px-4 py-4 font-bold">Tanggal</th>
                                    <th scope="col" class="px-5 py-4 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach ($tickets as $ticket)
                                    <tr class="transition-colors hover:bg-slate-50/70">
                                        <td class="whitespace-nowrap px-5 py-4 font-bold text-slate-900">{{ $ticket->kode_ticket }}</td>
                                        <td class="max-w-[260px] px-4 py-4 text-slate-700">{{ $ticket->judul }}</td>
                                        <td class="px-4 py-4">
                                            <div class="font-semibold text-slate-800">{{ $ticket->device?->nama_device ?? 'Perangkat tidak tersedia' }}</div>
                                            <div class="mt-0.5 text-xs text-slate-500">{{ $ticket->device?->kode_device ?? '-' }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-slate-700">{{ $ticket->reporter?->nama ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-4 font-semibold {{ $priorityClasses[$ticket->prioritas] ?? 'text-slate-600' }}">
                                            {{ $priorityLabels[$ticket->prioritas] ?? $ticket->prioritas }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4">
                                            <span class="inline-flex rounded-md px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-700' }}">
                                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-4 text-slate-600">{{ $ticket->tanggal?->format('d M Y, H:i') ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-5 py-4 text-right">
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-[#10254a] px-3 py-1.5 text-xs font-semibold text-[#10254a] transition-colors hover:bg-slate-50">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="border-t border-slate-200 px-4 py-4 sm:px-6">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
