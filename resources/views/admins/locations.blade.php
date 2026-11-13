@extends('layouts.index')

@section('content')
@php
    $ic = [
        'edit'    => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
        'trash'   => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'close'   => 'M6 18L18 6M6 6l12 12',
        'pin'     => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );
@endphp

<div x-data="locationsPage(
        @js($locations), 
        @js(route('admin.location.store')), 
        @js(route('admin.location.update', ['location' => '__ID__'])), 
        @js(route('admin.location.destroy', ['location' => '__ID__'])), 
        @js(csrf_token())
    )"
     @keydown.escape.window="modalOpen = false; confirmTarget = null; sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar --}}
    <x-sidebar role="admin" active="location" />

    {{-- KONTEN UTAMA --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Navbar --}}
        <x-navbar name="Fikri" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Header Judul & Total Badge --}}
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Kelola Lokasi</h1>
                    <p class="mt-1 text-sm text-slate-600">Otorisasi ruang, lantai, dan alokasi zonasi operasional P-TAMS</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-xs font-medium text-slate-600 shadow-sm">
                        Total Lokasi: <strong class="text-slate-900" x-text="locations.length"></strong>
                    </span>
                    <button @click="openAdd()" class="flex items-center gap-2 rounded-lg bg-[#10254a] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Lokasi
                    </button>
                </div>
            </div>

            {{-- Baris Pencarian --}}
            <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-center">
                <div class="relative w-full md:max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" x-model="search" placeholder="Cari nama lokasi atau lantai..." class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-4 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]">
                </div>
            </div>

            {{-- Tabel Data --}}
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-slate-700">
                            <tr>
                                <th class="px-6 py-4 w-16">No</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4">Jumlah Perangkat</th>
                                <th class="px-6 py-4">Slug Sistem</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(loc, index) in filteredLocations" :key="loc.id">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 font-medium text-slate-900" x-text="index + 1"></td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900" x-text="loc.label"></div>
                                    </td>
                                    <td class="px-6 py-4" x-text="loc.devices_count"></td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500" x-text="loc.slug"></td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="openEdit(loc)" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50">
                                                {{ $icon('edit') }} Edit
                                            </button>
                                            <button @click="askDelete(loc)" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-rose-700">
                                                {{ $icon('trash') }} Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            {{-- Kondisi jika kosong --}}
                            <template x-if="!filteredLocations.length">
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">Tidak ada data lokasi yang ditemukan.</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL TAMBAH / EDIT LOKASI --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog">
        <div x-show="modalOpen" @click="modalOpen = false" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modalOpen" class="relative flex w-full max-w-lg flex-col overflow-hidden rounded-xl bg-white shadow-xl">
            <form @submit.prevent="submitForm" class="flex flex-col">
                <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-slate-900" x-text="mode === 'add' ? 'Tambah Lokasi Baru' : 'Edit Lokasi'"></h3>
                    <button type="button" @click="modalOpen = false" class="text-slate-400 hover:text-slate-600">{{ $icon('close', 'h-5 w-5') }}</button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Nama Departemen / Ruangan</label>
                        <input type="text" x-model="form.nama" placeholder="Contoh: IT Support & Operations" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:border-transparent focus:ring-2 focus:ring-[#10254a]">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Lantai / Gedung</label>
                        <input type="text" x-model="form.lantai" placeholder="Contoh: Lantai 1" required class="w-full rounded-lg border border-slate-200 p-2.5 text-sm focus:border-transparent focus:ring-2 focus:ring-[#10254a]">
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t bg-slate-50 px-6 py-4">
                    <button type="button" @click="modalOpen = false" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-lg bg-[#10254a] px-4 py-2 text-sm font-medium text-white hover:bg-[#0b1b3a]" x-text="saving ? 'Menyimpan...' : 'Simpan'"></button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL KONFIRMASI HAPUS --}}
    <div x-show="confirmTarget" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="confirmTarget" @click="confirmTarget = null" class="absolute inset-0 bg-slate-900/50"></div>
        <div x-show="confirmTarget" class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <h3 class="text-lg font-bold text-slate-900">Konfirmasi Hapus Lokasi</h3>
            <p class="mt-2 text-sm text-slate-600">Yakin ingin menghapus lokasi <strong x-text="confirmTarget?.label"></strong>? Lokasi yang masih digunakan perangkat atau pengguna tidak dapat dihapus.</p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="confirmTarget = null" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700">Batal</button>
                <button type="button" @click="executeDelete" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- TOAST NOTIFIKASI --}}
    <div x-show="toastMsg" x-cloak x-transition class="fixed right-5 top-5 z-[100] rounded-xl bg-[#10254a] px-4 py-3 text-sm text-white shadow-lg" x-text="toastMsg"></div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('locationsPage', (initialLocations, storeUrl, updateUrlTpl, destroyUrlTpl, csrfToken) => ({
            locations: initialLocations,
            search: '',
            modalOpen: false,
            mode: 'add',
            form: { id: null, nama: '', lantai: '' },
            saving: false,
            confirmTarget: null,
            toastMsg: '',

            get filteredLocations() {
                if (!this.search.trim()) return this.locations;
                const q = this.search.toLowerCase();
                return this.locations.filter(l => l.nama.toLowerCase().includes(q) || l.lantai.toLowerCase().includes(q));
            },

            openAdd() {
                this.mode = 'add';
                this.form = { id: null, nama: '', lantai: '' };
                this.modalOpen = true;
            },

            openEdit(loc) {
                this.mode = 'edit';
                this.form = { id: loc.id, nama: loc.nama, lantai: loc.lantai };
                this.modalOpen = true;
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
                    if (!res.ok) {
                        const validationMessages = Object.values(data.errors || {}).flat();
                        throw new Error(validationMessages.join(' ') || data.message || 'Gagal menyimpan data.');
                    }

                    if (this.mode === 'add') {
                        this.locations.unshift(data.location);
                    } else {
                        const idx = this.locations.findIndex(l => l.id === data.location.id);
                        if (idx !== -1) this.locations[idx] = data.location;
                    }

                    this.modalOpen = false;
                    this.showToast(data.message);
                } catch (e) {
                    this.showToast(e.message);
                } finally {
                    this.saving = false;
                }
            },

            askDelete(loc) {
                this.confirmTarget = loc;
            },

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
                    if (!res.ok) throw new Error(data.message || 'Gagal menghapus lokasi.');

                    this.locations = this.locations.filter(l => l.id !== id);
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
