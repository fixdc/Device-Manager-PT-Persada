@extends('layouts.index')

@section('content')
@php
    $initialName = old('nama', '');
    $initialCategoryId = old('_category_id');
    $initialMode = old('_form_mode', 'add');
    $inputClass = 'w-full rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
@endphp

<div
    x-data="categoriesPage(
        @js($categories),
        @js(route('admin.categories.store')),
        @js(route('admin.categories.update', ['category' => '__ID__'])),
        @js(route('admin.categories.destroy', ['category' => '__ID__'])),
        @js($errors->has('nama') || $errors->has('slug')),
        @js($initialMode),
        @js($initialCategoryId),
        @js($initialName)
    )"
    @keydown.escape.window="modalOpen = false; confirmTarget = null; sidebarOpen = false"
    class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800"
>
    <x-sidebar role="admin" active="category" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar :name="auth()->user()->nama" role="Admin" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Kelola Kategori Perangkat</h1>
                    <p class="mt-1 text-sm text-slate-600">Atur kategori yang digunakan pada data perangkat.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <span class="rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-medium text-slate-600 shadow-sm">
                        Total Kategori: <strong class="text-slate-900">{{ $categories->count() }}</strong>
                    </span>
                    <button
                        type="button"
                        @click="openAdd()"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a]"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kategori
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <p class="font-semibold">Perubahan kategori belum berhasil disimpan.</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-5 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <label for="category-search" class="sr-only">Cari kategori</label>
                <div class="relative w-full md:max-w-md">
                    <svg class="pointer-events-none absolute inset-y-0 left-0 my-auto ml-3.5 h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        id="category-search"
                        type="search"
                        x-model.debounce.150ms="search"
                        placeholder="Cari nama atau slug kategori..."
                        class="{{ $inputClass }} pl-10"
                    >
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="font-bold text-slate-900">Daftar Kategori</h2>
                    <span class="text-xs font-medium text-slate-500" x-text="`${filteredCategories.length} kategori`"></span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-200 bg-[#f1f5f9] text-xs font-semibold uppercase tracking-wide text-slate-700">
                                <th scope="col" class="w-16 px-5 py-4">No.</th>
                                <th scope="col" class="px-5 py-4">Nama Kategori</th>
                                <th scope="col" class="px-5 py-4">Slug</th>
                                <th scope="col" class="px-5 py-4">Perangkat</th>
                                <th scope="col" class="px-5 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                            <template x-for="(category, index) in filteredCategories" :key="category.id">
                                <tr class="transition-colors hover:bg-slate-50/70">
                                    <td class="px-5 py-4 font-medium text-slate-500" x-text="index + 1"></td>
                                    <td class="px-5 py-4 font-semibold text-slate-900" x-text="category.nama"></td>
                                    <td class="px-5 py-4 font-mono text-xs text-slate-500" x-text="category.slug"></td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700" x-text="category.devices_count"></span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button
                                                type="button"
                                                @click="openEdit(category)"
                                                :aria-label="`Edit kategori ${category.nama}`"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                @click="askDelete(category)"
                                                :aria-label="`Hapus kategori ${category.nama}`"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm transition-colors hover:bg-rose-700"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-if="filteredCategories.length === 0">
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">
                                        Tidak ada kategori yang cocok dengan pencarian.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="category-modal-title">
        <div x-show="modalOpen" x-transition.opacity @click="modalOpen = false" class="absolute inset-0 bg-slate-900/50"></div>
        <div x-show="modalOpen" x-transition class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl">
            <form method="POST" :action="formAction" @submit="saving = true">
                @csrf
                <template x-if="mode === 'edit'">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="_form_mode" :value="mode">
                <input type="hidden" name="_category_id" :value="form.id || ''">

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
                    <div>
                        <h2 id="category-modal-title" class="text-lg font-bold text-slate-900" x-text="mode === 'add' ? 'Tambah Kategori' : 'Edit Kategori'"></h2>
                        <p class="mt-0.5 text-xs text-slate-500">Slug akan dibuat otomatis dari nama kategori.</p>
                    </div>
                    <button type="button" @click="modalOpen = false" class="rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700" aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-2 p-5 sm:p-6">
                    <label for="category-name" class="block text-xs font-semibold text-slate-700">Nama Kategori</label>
                    <input
                        id="category-name"
                        type="text"
                        name="nama"
                        x-model="form.nama"
                        maxlength="255"
                        required
                        autofocus
                        placeholder="Contoh: Komputer & Laptop"
                        class="{{ $inputClass }}"
                    >
                    <p class="text-[11px] text-slate-500">Slug kategori tidak perlu diisi secara manual.</p>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <button type="button" @click="modalOpen = false" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50">Batal</button>
                    <button type="submit" :disabled="saving" class="rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0b1b3a] disabled:cursor-wait disabled:opacity-70" x-text="saving ? 'Menyimpan...' : 'Simpan Kategori'"></button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="confirmTarget" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" role="alertdialog" aria-modal="true" aria-labelledby="category-delete-title">
        <div x-show="confirmTarget" x-transition.opacity @click="confirmTarget = null" class="absolute inset-0 bg-slate-900/50"></div>
        <div x-show="confirmTarget" x-transition class="relative w-full max-w-md rounded-2xl bg-white p-5 shadow-2xl sm:p-6">
            <h2 id="category-delete-title" class="text-lg font-bold text-slate-900">Konfirmasi Hapus Kategori</h2>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Yakin ingin menghapus kategori <strong class="text-slate-900" x-text="confirmTarget?.nama"></strong>?
                Kategori yang masih digunakan perangkat tidak dapat dihapus.
            </p>
            <form method="POST" :action="deleteAction" class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                @csrf
                @method('DELETE')
                <button type="button" @click="confirmTarget = null" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-rose-700">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('categoriesPage', (initialCategories, storeUrl, updateUrlTemplate, destroyUrlTemplate, hasNameErrors, initialMode, initialCategoryId, initialName) => ({
            categories: initialCategories,
            storeUrl,
            updateUrlTemplate,
            destroyUrlTemplate,
            search: '',
            modalOpen: hasNameErrors,
            mode: initialMode,
            form: {
                id: initialCategoryId,
                nama: initialName,
            },
            confirmTarget: null,
            saving: false,

            init() {
                if (this.modalOpen && this.mode === 'edit') {
                    const category = this.categories.find(item => String(item.id) === String(this.form.id));
                    if (!category) {
                        this.modalOpen = false;
                    }
                }
            },

            get filteredCategories() {
                const query = this.search.trim().toLocaleLowerCase();
                if (!query) {
                    return this.categories;
                }

                return this.categories.filter(category =>
                    category.nama.toLocaleLowerCase().includes(query)
                    || category.slug.toLocaleLowerCase().includes(query)
                );
            },

            get formAction() {
                return this.mode === 'add'
                    ? this.storeUrl
                    : this.updateUrlTemplate.replace('__ID__', encodeURIComponent(this.form.id));
            },

            get deleteAction() {
                return this.confirmTarget
                    ? this.destroyUrlTemplate.replace('__ID__', encodeURIComponent(this.confirmTarget.id))
                    : '';
            },

            openAdd() {
                this.mode = 'add';
                this.form = { id: null, nama: '' };
                this.saving = false;
                this.modalOpen = true;
            },

            openEdit(category) {
                this.mode = 'edit';
                this.form = { id: category.id, nama: category.nama };
                this.saving = false;
                this.modalOpen = true;
            },

            askDelete(category) {
                this.confirmTarget = category;
            },
        }));
    });
</script>
@endsection
