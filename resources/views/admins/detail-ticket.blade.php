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
    $priorityClasses = ['rendah' => 'text-emerald-700', 'sedang' => 'text-amber-700', 'tinggi' => 'text-rose-700'];
    $card = 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6';
    $inputClass = 'w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
@endphp

<div class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">
    <x-sidebar role="admin" active="ticket" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="auth()->user()->nama" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mx-auto w-full max-w-[1400px] space-y-6">
                <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#10254a] px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7-7l-7 7 7 7"/></svg>
                    Daftar Tiket
                </a>

                @if (session('success'))
                    <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <p class="font-semibold">Perubahan belum disimpan.</p>
                        <ul class="mt-1 list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-[#10254a] sm:text-2xl lg:text-3xl">Detail Laporan Kerusakan</h1>
                        <p class="mt-1 max-w-2xl text-xs leading-relaxed text-slate-500 sm:text-sm">Informasi laporan dan pembaruan penanganan tiket dari database.</p>
                    </div>
                    <div class="flex shrink-0 flex-wrap items-center gap-3">
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Status Saat Ini</div>
                            <span class="mt-1 inline-flex rounded-md px-2.5 py-1 text-xs font-bold {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $statusLabels[$ticket->status] ?? $ticket->status }}
                            </span>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                            <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Prioritas</div>
                            <div class="mt-1 text-xs font-bold {{ $priorityClasses[$ticket->prioritas] ?? 'text-slate-700' }}">
                                {{ $priorityLabels[$ticket->prioritas] ?? $ticket->prioritas }}
                            </div>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">
                    <div class="w-full space-y-6 lg:col-span-8">
                        <section class="rounded-2xl bg-[#10254a] p-5 text-white shadow-md sm:p-6">
                            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                                <div>
                                    <div class="text-xs font-semibold text-slate-300">Nomor Registrasi Tiket</div>
                                    <h2 class="mt-1 text-2xl font-extrabold tracking-tight sm:text-3xl">{{ $ticket->kode_ticket }}</h2>
                                    <p class="mt-3 text-xs leading-relaxed text-slate-300">
                                        Dilaporkan oleh <span class="font-semibold text-white">{{ $ticket->reporter?->nama ?? '-' }}</span>
                                        pada {{ $ticket->tanggal?->format('d M Y, H:i') ?? '-' }}
                                    </p>
                                </div>
                                <div class="rounded-xl border border-white/15 bg-white/10 p-4 sm:min-w-52">
                                    <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-300">Admin Penanggung Jawab</div>
                                    <div class="mt-1 text-sm font-bold">{{ $ticket->technician?->nama ?? 'Belum disetujui' }}</div>
                                </div>
                            </div>
                        </section>

                        <section class="{{ $card }}">
                            <div class="border-b border-slate-100 pb-4">
                                <h3 class="text-base font-bold tracking-tight text-slate-900 sm:text-lg">Perangkat &amp; Pelapor</h3>
                                <p class="mt-1 text-xs text-slate-500">Informasi perangkat dan pengguna yang membuat laporan.</p>
                            </div>
                            <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                    <div class="text-[11px] font-medium text-slate-500">Perangkat</div>
                                    <div class="mt-1 text-sm font-bold text-slate-900">{{ $ticket->device?->nama_device ?? 'Perangkat tidak tersedia' }}</div>
                                    <div class="mt-1 text-xs text-slate-500">Kode: {{ $ticket->device?->kode_device ?? '-' }}</div>
                                    <div class="mt-2 text-xs text-slate-600">
                                        {{ $ticket->device?->category?->nama ?? 'Kategori tidak tersedia' }}
                                        &middot; {{ $ticket->device?->department?->nama ?? 'Lokasi tidak tersedia' }}
                                    </div>
                                </div>
                                <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                                    <div class="text-[11px] font-medium text-slate-500">Pelapor</div>
                                    <div class="mt-1 text-sm font-bold text-slate-900">{{ $ticket->reporter?->nama ?? '-' }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $ticket->reporter?->email ?? '-' }}</div>
                                    <div class="mt-2 text-xs text-slate-600">{{ $ticket->reporter?->department?->nama ?? 'Unit kerja tidak tersedia' }}</div>
                                </div>
                            </div>
                        </section>

                        <section class="{{ $card }} space-y-5">
                            <div>
                                <h3 class="text-base font-bold tracking-tight text-slate-900 sm:text-lg">Isi Laporan / Keluhan</h3>
                                <p class="mt-1 text-xs text-slate-500">Subjek: <span class="font-semibold text-slate-700">{{ $ticket->judul }}</span></p>
                                <p class="mt-3 whitespace-pre-line rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700">{{ $ticket->deskripsi ?: 'Tidak ada deskripsi yang dicatat.' }}</p>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Catatan Penanganan</h3>
                                <p class="mt-2 whitespace-pre-line rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700">{{ $ticket->catatan ?: 'Belum ada catatan penanganan.' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Riwayat Perbaikan</h3>
                                <p class="mt-2 whitespace-pre-line rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-sm leading-relaxed text-slate-700">{{ $ticket->repairHistory?->tindakan ?: 'Belum ada ringkasan tindakan perbaikan.' }}</p>
                                @if ($ticket->repairHistory?->tanggal_selesai)
                                    <p class="mt-2 text-xs text-slate-500">Hasil akhir dicatat pada {{ $ticket->repairHistory->tanggal_selesai->format('d M Y, H:i') }}</p>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Foto Tiket</h3>
                                @if ($photos->isEmpty())
                                    <p class="mt-2 text-xs text-slate-500">Tidak ada foto pendukung.</p>
                                @else
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        @foreach ($photos as $photo)
                                            <a href="{{ $photo['url'] }}" target="_blank" rel="noopener" class="block overflow-hidden rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                                                <img src="{{ $photo['url'] }}" alt="Foto tiket {{ $ticket->kode_ticket }}" class="h-32 w-40 object-cover">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    <aside class="w-full space-y-6 lg:col-span-4">
                        <section class="{{ $card }}">
                            <h3 class="text-sm font-bold tracking-wide text-slate-900">PENANGGUNG JAWAB</h3>
                            <p class="mt-1 text-xs leading-relaxed text-slate-500">Admin yang menyetujui tiket menjadi penanggung jawab penanganannya.</p>
                            <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-3 text-sm font-semibold text-slate-800">
                                {{ $ticket->technician?->nama ?? 'Menunggu persetujuan tiket' }}
                            </div>
                        </section>

                        <section class="{{ $card }}">
                            <h3 class="text-sm font-bold tracking-wide text-slate-900">PERBARUI TIKET</h3>
                            <p class="mt-1 text-xs leading-relaxed text-slate-500">Ikuti tahapan persetujuan, penanganan, dan hasil akhir tiket.</p>
                            <form x-data="{ status: @js(old('status', $ticket->status)) }" action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="mt-4 space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="status" class="mb-1.5 block text-xs font-semibold text-slate-700">Status Tiket</label>
                                    <select id="status" name="status" x-model="status" required class="{{ $inputClass }}">
                                        @foreach ($availableStatuses as $value => $label)
                                            <option value="{{ $value }}" @selected(old('status', $ticket->status) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <div class="mb-1.5 flex items-center justify-between">
                                        <label for="catatan" class="block text-xs font-semibold text-slate-700">Catatan Penanganan</label>
                                        <span class="text-[10px] text-slate-400">Maksimal 1000 karakter</span>
                                    </div>
                                    <textarea id="catatan" name="catatan" rows="6" maxlength="1000" :required="status === 'completed' || status === 'failed'" placeholder="Tuliskan hasil pemeriksaan atau tindakan perbaikan..." class="{{ $inputClass }}">{{ old('catatan', $ticket->catatan) }}</textarea>
                                    <p x-show="status === 'completed' || status === 'failed'" x-cloak class="mt-1.5 text-xs font-medium text-rose-700">Catatan wajib diisi untuk hasil akhir.</p>
                                </div>
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <a href="{{ route('admin.tickets.index') }}" class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-center text-xs font-bold text-slate-700 transition-colors hover:bg-slate-50">Batal</a>
                                    <button type="submit" class="w-full rounded-lg bg-[#10254a] px-3 py-2.5 text-center text-xs font-bold text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">Simpan Perubahan</button>
                                </div>
                            </form>
                        </section>
                    </aside>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
