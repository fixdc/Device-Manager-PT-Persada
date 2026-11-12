@extends('layouts.index')

@section('content')
@php
    // Path ikon (Heroicons outline)
    $ic = [
        'search'   => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'chevron'  => 'M19 9l-7 7-7-7',
        'plus'     => 'M12 4v16m8-8H4',
        'close'    => 'M6 18L18 6M6 6l12 12',
        'check'    => 'M5 13l4 4L19 7',
        'user'     => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
        'mail'     => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'phone'    => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
        'building' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
        'lock'     => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
        'eye'      => 'M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z',
        'edit'     => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
        'trash'    => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'warning'  => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    // Kelas input yang dipakai berulang
    $input = 'w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
    $inputPw = str_replace('pr-4', 'pr-10', $input); // untuk input kata sandi (ada tombol mata)
@endphp

<div x-data="usersPage(
        @js($users->items()),
        @js(route('admin.users.store')),
        @js(route('admin.users.update', ['user' => '__USER__'])),
        @js(route('admin.users.destroy', ['user' => '__USER__'])),
        @js(csrf_token()),
        @js($search),
        @js($roleFilter),
        {{ $users->firstItem() ?? 0 }},
        {{ $users->total() }}
    )"
     @keydown.escape.window="modal = null; sidebarOpen = false; typeOpen = false"
     class="flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar admin --}}
    <x-sidebar role="admin" active="user" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">

            {{-- Judul --}}
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Kelola User</h1>
                    <p class="mt-1 text-sm text-slate-600">Otorisasi hak akses, peran struktural, dan alokasi divisi personel EnterpriseAsset Core P-TAMS</p>
                </div>
                <div class="self-start rounded-lg border border-slate-200 bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-500 sm:self-auto">
                    Total Pengguna: <span class="font-bold text-slate-900" x-text="totalUsers"></span>
                </div>
            </div>

            {{-- Pencarian, filter, tambah --}}
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <form id="user-filters" x-ref="filterForm" action="{{ route('admin.users.index') }}" method="GET" class="relative flex flex-1 sm:max-w-2xl">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('search') }}</span>
                    <input type="hidden" name="role" :value="roleFilter === 'ALL' ? '' : roleFilter">
                    <input type="search" name="search" x-model="search" value="{{ $search }}" @keydown.enter="$refs.filterForm.requestSubmit()" placeholder="Lakukan pencarian..." class="{{ $input }}">
                </form>

                <div class="flex items-center gap-3">
                    {{-- Filter Type --}}
                    <div class="relative flex-1 sm:flex-none">
                        <button type="button" @click="typeOpen = !typeOpen" @click.outside="typeOpen = false" :aria-expanded="typeOpen"
                                class="flex w-full items-center justify-between rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 sm:w-40">
                            <span class="flex items-center gap-2 truncate">
                                <span class="h-2 w-2 rounded-full" :class="roleFilter === 'ALL' ? 'bg-slate-400' : roles[roleFilter].dot"></span>
                                <span x-text="roleFilter === 'ALL' ? 'Type' : formatRole(roleFilter)"></span>
                            </span>
                            <span class="ml-2 text-slate-500 transition-transform" :class="typeOpen ? 'rotate-180' : ''">{{ $icon('chevron') }}</span>
                        </button>

                        <div x-show="typeOpen" x-cloak x-transition.opacity
                             class="absolute right-0 top-full z-30 mt-1.5 w-52 space-y-0.5 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg">
                            <button type="button" @click="roleFilter = 'ALL'; typeOpen = false; $nextTick(() => $refs.filterForm.requestSubmit())"
                                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                <span class="flex items-center gap-2.5"><span class="h-2 w-2 rounded-full bg-slate-400"></span>Semua Tipe</span>
                                <span x-show="roleFilter === 'ALL'" class="text-slate-800">{{ $icon('check', 'h-3.5 w-3.5') }}</span>
                            </button>
                            <template x-for="r in Object.keys(roles)" :key="r">
                                <button type="button" @click="roleFilter = r; typeOpen = false; $nextTick(() => $refs.filterForm.requestSubmit())"
                                        class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    <span class="flex items-center gap-2.5">
                                        <span class="h-2 w-2 rounded-full" :class="roles[r].dot"></span>
                                        <span x-text="formatRole(r)"></span>
                                    </span>
                                    <span class="rounded border px-1.5 py-0.5 text-[10px] font-medium" :class="roles[r].badge" x-text="roles[r].hint"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <button type="button" @click="openAdd()"
                            class="flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#10254a] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#0b1b3a]">
                        {{ $icon('plus') }}
                        Tambah User
                    </button>
                </div>
            </div>

            {{-- ============ TABEL (desktop) ============ --}}
            <div x-show="filtered.length > 0" class="hidden overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm lg:block">
                <table class="w-full min-w-[700px] border-collapse text-left">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-sm font-bold text-slate-800">
                            <th scope="col" class="w-16 px-4 py-4 text-center">No</th>
                            <th scope="col" class="px-4 py-4">Nama Pengguna</th>
                            <th scope="col" class="px-4 py-4">Email Pengguna</th>
                            <th scope="col" class="px-4 py-4">Role</th>
                            <th scope="col" class="px-4 py-4">Departemen</th>
                            <th scope="col" class="px-4 py-4">No. Telepon</th>
                            <th scope="col" class="w-56 px-4 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                        <template x-for="(u, i) in filtered" :key="u.id">
                            <tr class="transition-colors hover:bg-slate-50/60">
                                <td class="px-6 py-4 text-center" x-text="i + indexOffset"></td>
                                <td class="px-5 py-4 font-medium" x-text="u.nama"></td>
                                <td class="px-5 py-4" x-text="u.email"></td>
                                <td class="px-5 py-4">
                                    <span class="rounded border px-2 py-0.5 text-xs font-semibold" :class="roles[u.role].badge" x-text="formatRole(u.role)"></span>
                                </td>
                                <td class="px-5 py-4" x-text="u.departemen_nama || '-'"></td>
                                <td class="px-5 py-4" x-text="u.no_telp || '-'"></td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2.5">
                                        <button type="button" @click="openEdit(u)" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 px-4 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-50">
                                            {{ $icon('edit', 'h-3.5 w-3.5 text-slate-500') }} Edit
                                        </button>
                                        <button type="button" @click="openDelete(u)" class="inline-flex items-center gap-1.5 rounded-lg bg-rose-600 px-4 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-rose-700">
                                            {{ $icon('trash', 'h-3.5 w-3.5') }} Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            {{-- ============ KARTU (tablet & mobile) ============ --}}
            <div x-show="filtered.length > 0" class="grid grid-cols-1 gap-3 lg:hidden">
                <template x-for="u in filtered" :key="u.id">
                    <div class="space-y-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-700" x-text="initials(u.nama)"></div>
                                <div class="min-w-0">
                                    <h3 class="truncate text-sm font-bold leading-tight text-slate-900" x-text="u.nama"></h3>
                                    <p class="mt-0.5 truncate text-xs text-slate-500" x-text="u.email"></p>
                                </div>
                            </div>
                            <span class="shrink-0 rounded border px-2 py-0.5 text-xs font-semibold" :class="roles[u.role].badge" x-text="formatRole(u.role)"></span>
                        </div>
                        <p class="text-xs text-slate-500"><span x-text="u.departemen_nama || 'Departemen belum diisi'"></span><span class="mx-1">·</span><span x-text="u.no_telp || 'No. telepon belum diisi'"></span></p>
                        <div class="flex items-center gap-2 border-t border-slate-100 pt-3">
                            <button type="button" @click="openEdit(u)" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-slate-300 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                {{ $icon('edit', 'h-3.5 w-3.5 text-slate-500') }} Edit
                            </button>
                            <button type="button" @click="openDelete(u)" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-rose-600 py-2 text-xs font-semibold text-white hover:bg-rose-700">
                                Hapus
                            </button>
                        </div>
                    </div>

                </template>
            </div>

            <div class="mt-5">
                {{ $users->links() }}
            </div>

            {{-- Kosong --}}
            <div x-show="filtered.length === 0" x-cloak class="rounded-xl border border-slate-200 bg-white px-4 py-14 text-center">
                <div class="mx-auto mb-3.5 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">{{ $icon('search', 'h-7 w-7') }}</div>
                <h3 class="mb-1 text-base font-bold text-slate-900">Tidak ada data pengguna ditemukan</h3>
                <p class="mx-auto mb-4 max-w-sm text-xs leading-relaxed text-slate-500">Kata kunci pencarian atau filter tipe yang dipilih tidak cocok dengan akun mana pun di sistem.</p>
                <button type="button" @click="resetFilter()" class="rounded-lg bg-slate-100 px-3.5 py-1.5 text-xs font-semibold text-slate-700 transition-colors hover:bg-slate-200">
                    Reset Filter Pencarian
                </button>
            </div>
        </main>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed right-5 top-5 z-[100] flex items-center gap-3 rounded-xl border px-4 py-3 text-sm font-medium text-white shadow-lg"
         :class="toastType === 'success' ? 'border-slate-700 bg-[#10254a]' : 'border-rose-700 bg-rose-600'" role="status">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ MODAL TAMBAH USER ============ --}}
    <div x-show="modal === 'add'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-add-title">
        <div x-show="modal === 'add'" x-transition.opacity @click="close()" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'add'" x-transition class="relative flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex shrink-0 items-start justify-between border-b border-slate-100 p-5 sm:p-7">
                <div>
                    <h3 id="modal-add-title" class="text-xl font-bold text-slate-900 sm:text-2xl">Tambah Pengguna Baru</h3>
                    <p class="mt-1 text-xs text-slate-500 sm:text-sm">Lengkapi formulir di bawah ini untuk menambahkan akun pengguna baru ke sistem P-TAMS.</p>
                </div>
                <button type="button" @click="close()" class="ml-2 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
            </div>

            <form :action="createUrl" method="POST" enctype="multipart/form-data" @submit.prevent="submitUser($event.target)" class="flex min-h-0 flex-1 flex-col">
                @csrf
                <div class="min-h-0 flex-1 space-y-4 overflow-y-auto p-5 sm:space-y-5 sm:p-7">

                    <div class="grid grid-cols-1 items-center gap-1.5 md:grid-cols-12 md:gap-3">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3">Nama Pengguna <span class="text-red-500">*</span></label>
                        <div class="relative md:col-span-9">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('user') }}</span>
                            <input type="text" name="nama" x-model="form.nama" placeholder="Contoh: Andi Pratama" required maxlength="255" class="{{ $input }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 items-center gap-1.5 md:grid-cols-12 md:gap-3">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3">Email Pengguna <span class="text-red-500">*</span></label>
                        <div class="relative md:col-span-9">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('mail') }}</span>
                            <input type="email" name="email" x-model="form.email" placeholder="contoh: andi227@gmail.com" required maxlength="255" class="{{ $input }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 items-start gap-1.5 md:grid-cols-12 md:gap-3">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3 md:pt-2">Role / Peran <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2 md:col-span-9">
                            <template x-for="r in Object.keys(roles)" :key="r">
                                <label class="flex cursor-pointer items-center gap-3 rounded-xl border-2 p-3 transition-colors"
                                       :class="form.role === r ? roles[r].active : 'border-slate-200 bg-white hover:border-slate-300'">
                                    <input type="radio" name="role" :value="r" x-model="form.role" class="sr-only">
                                    <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border bg-white" :class="form.role === r ? roles[r].ring : 'border-slate-300'">
                                        <span x-show="form.role === r" class="h-2 w-2 rounded-full" :class="roles[r].dot"></span>
                                    </span>
                                    <span>
                                        <span class="block text-sm font-bold leading-tight text-slate-900" x-text="formatRole(r)"></span>
                                        <span class="mt-0.5 block text-[11px] leading-tight text-slate-500" x-text="roles[r].desc"></span>
                                    </span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 items-center gap-1.5 md:grid-cols-12 md:gap-3">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3">Nomor Telepon / WhatsApp</label>
                        <div class="relative md:col-span-9">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('phone') }}</span>
                            <input type="text" name="no_telp" x-model="form.no_telp" placeholder="0812-xxxx-xxxx" maxlength="40" class="{{ $input }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 items-center gap-1.5 md:grid-cols-12 md:gap-3">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3">Departemen / Divisi</label>
                        <div class="relative md:col-span-9">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('building') }}</span>
                            <select name="id_departemen" x-model="form.id_departemen" class="{{ $input }}">
                                <option value="">Tanpa departemen</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 items-center gap-1.5 md:grid-cols-12 md:gap-3" x-data="{ show: false }">
                        <label class="text-xs font-semibold text-slate-800 sm:text-sm md:col-span-3">Kata Sandi Default <span class="text-red-500">*</span></label>
                        <div class="relative md:col-span-9">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('lock') }}</span>
                            <input :type="show ? 'text' : 'password'" name="kata_sandi" x-model="form.kata_sandi" placeholder="Min. 12 karakter, huruf besar/kecil, angka & simbol" required class="{{ $inputPw }}">
                            <input type="password" name="kata_sandi_confirmation" placeholder="Konfirmasi kata sandi awal" required class="{{ $input }} mt-2">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600" aria-label="Lihat kata sandi">{{ $icon('eye') }}</button>
                        </div>
                    </div>

                </div>

                <div class="flex shrink-0 flex-col-reverse items-stretch justify-end gap-2.5 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-7">
                    <button type="button" @click="close()" class="rounded-lg border border-slate-200 px-6 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" :disabled="saving" class="flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a] disabled:cursor-wait disabled:opacity-70">
                        {{ $icon('plus') }} <span x-text="saving ? 'Menyimpan...' : 'Tambah User'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL EDIT USER ============ --}}
    <div x-show="modal === 'edit'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-edit-title">
        <div x-show="modal === 'edit'" x-transition.opacity @click="close()" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'edit'" x-transition class="relative flex max-h-[92vh] w-full max-w-5xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex shrink-0 items-start justify-between border-b border-slate-100 p-5 sm:p-7">
                <div>
                    <h3 id="modal-edit-title" class="text-xl font-bold text-slate-900 sm:text-2xl">Edit Pengguna</h3>
                    <p class="mt-1 text-xs text-slate-500 sm:text-sm">Perbarui formulir di bawah ini untuk memperbarui akun pengguna di sistem P-TAMS.</p>
                </div>
                <button type="button" @click="close()" class="ml-2 rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
            </div>

            <form :action="updateUrl.replace('__USER__', form.id)" method="POST" @submit.prevent="submitUser($event.target)" class="flex min-h-0 flex-1 flex-col">
                @csrf
                @method('PUT')
                <div class="min-h-0 flex-1 overflow-y-auto p-5 sm:p-7">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-10">

                        {{-- Kiri: informasi dasar --}}
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Informasi Dasar Pengguna</h4>
                                <p class="mt-0.5 text-xs text-slate-400">Identitas utama akun dan kontak dinas pengguna</p>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Nama Pengguna <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('user') }}</span>
                                    <input type="text" name="nama" x-model="form.nama" required maxlength="255" class="{{ $input }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Email Pengguna <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('mail') }}</span>
                                    <input type="email" name="email" x-model="form.email" required maxlength="255" class="{{ $input }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Nomor Telepon / WhatsApp</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('phone') }}</span>
                                    <input type="text" name="no_telp" x-model="form.no_telp" maxlength="40" class="{{ $input }}">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Departemen / Divisi</label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('building') }}</span>
                                    <select name="id_departemen" x-model="form.id_departemen" class="{{ $input }}">
                                        <option value="">Tanpa departemen</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-1.5" x-data="{ show: false }">
                                <label class="text-xs font-semibold text-slate-700">Ubah Kata Sandi <span class="text-xs font-normal text-slate-400">(Opsional)</span></label>
                                <div class="relative">
                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">{{ $icon('lock') }}</span>
                                    <input :type="show ? 'text' : 'password'" name="kata_sandi" x-model="form.kata_sandi" placeholder="Kosongkan jika tidak ingin mengubah kata sandi" class="{{ $inputPw }}">
                                    <input type="password" name="kata_sandi_confirmation" placeholder="Konfirmasi kata sandi baru" class="{{ $input }} mt-2">
                                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600" aria-label="Lihat kata sandi">{{ $icon('eye') }}</button>
                                </div>
                            </div>
                        </div>

                        {{-- Kanan: hak akses --}}
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Hak Akses</h4>
                                <p class="mt-0.5 text-xs text-slate-400">Atur kewenangan sistem pengguna</p>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Role / Peran <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2">
                                    <template x-for="r in Object.keys(roles)" :key="r">
                                        <label class="flex cursor-pointer flex-col justify-between rounded-xl border-2 p-3 transition-colors"
                                               :class="form.role === r ? roles[r].active : 'border-slate-200 bg-white hover:border-slate-300'">
                                            <input type="radio" name="role" :value="r" x-model="form.role" class="sr-only">
                                            <span class="flex w-full items-center justify-between">
                                                <span class="text-sm font-bold text-slate-900" x-text="formatRole(r)"></span>
                                                <span class="ml-2 flex h-4 w-4 items-center justify-center rounded-full border bg-white" :class="form.role === r ? roles[r].ring : 'border-slate-300'">
                                                    <span x-show="form.role === r" class="h-2 w-2 rounded-full" :class="roles[r].dot"></span>
                                                </span>
                                            </span>
                                            <span class="mt-1 hidden text-[11px] leading-tight text-slate-500 sm:block" x-text="roles[r].desc"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="flex shrink-0 flex-col-reverse items-stretch justify-end gap-2.5 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-7">
                    <button type="button" @click="close()" class="rounded-lg border border-slate-200 px-6 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" :disabled="saving" class="flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#0b1b3a] disabled:cursor-wait disabled:opacity-70">
                        {{ $icon('check') }} <span x-text="saving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL HAPUS USER ============ --}}
    <div x-show="modal === 'delete'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="alertdialog" aria-modal="true" aria-labelledby="modal-delete-title">
        <div x-show="modal === 'delete'" x-transition.opacity @click="close()" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'delete'" x-transition class="relative w-full max-w-[480px] overflow-hidden rounded-2xl bg-white p-5 shadow-2xl sm:p-7">
            <form :action="deleteUrl.replace('__USER__', deleteTarget?.id)" method="POST" @submit.prevent="confirmDelete($event.target)">
                @csrf
                @method('DELETE')
                <div class="mb-4 flex items-start justify-between">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-red-100 bg-red-50 text-red-600 sm:h-12 sm:w-12">{{ $icon('trash', 'h-5 w-5 sm:h-6 sm:w-6') }}</div>
                        <div>
                            <h3 id="modal-delete-title" class="text-lg font-bold leading-tight text-slate-900 sm:text-xl">Konfirmasi Hapus Data</h3>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-400">Aksi kritis, perlu konfirmasi</p>
                        </div>
                    </div>
                    <button type="button" @click="close()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">{{ $icon('close', 'h-5 w-5') }}</button>
                </div>

                <div class="mb-6 space-y-3 text-xs leading-relaxed text-slate-600 sm:space-y-4 sm:text-sm">
                    <p>
                        Apakah Anda yakin ingin menghapus data
                        <strong class="font-semibold text-slate-900" x-text="deleteTarget ? '&quot;' + deleteTarget.nama + '&quot;' : 'pengguna ini'"></strong>?
                        Akun akan dihapus permanen. Akun dengan tiket sebagai pelapor dan administrator terakhir tidak dapat dihapus.
                    </p>
                    <div class="flex items-start gap-2.5 rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs leading-normal text-amber-900 sm:p-3.5">
                        <span class="mt-0.5 shrink-0 text-amber-600">{{ $icon('warning') }}</span>
                        <span><strong class="font-semibold">Perhatian:</strong> Anda tidak dapat menghapus akun sendiri atau administrator terakhir.</span>
                    </div>
                </div>

                <div class="flex flex-col-reverse items-stretch justify-end gap-2.5 pt-2 sm:flex-row sm:items-center sm:gap-3">
                    <button type="button" @click="close()" class="rounded-lg border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                    <button type="submit" :disabled="saving" class="flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:cursor-wait disabled:opacity-70">
                        {{ $icon('trash') }} <span x-text="saving ? 'Menghapus...' : 'Hapus Permanen'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('usersPage', (initialUsers, createUrl, updateUrl, deleteUrl, csrfToken, initialSearch, initialRole, indexOffset, totalUsers) => ({
            sidebarOpen: false,
            users: initialUsers,
            createUrl,
            updateUrl,
            deleteUrl,
            csrfToken,
            search: initialSearch,
            roleFilter: initialRole || 'ALL',
            indexOffset,
            totalUsers,
            typeOpen: false,
            modal: null,
            form: {},
            deleteTarget: null,
            saving: false,
            toastMsg: '',
            toastType: 'success',
            toastTimer: null,

            roles: {
                user:    { dot: 'bg-emerald-500', ring: 'border-emerald-500', badge: 'bg-emerald-50 text-emerald-700 border-emerald-200', active: 'border-emerald-500 bg-emerald-50/50', hint: 'Pelapor', desc: 'Staff Pelapor & Karyawan Umum' },
                admin:   { dot: 'bg-blue-600',    ring: 'border-blue-600',    badge: 'bg-blue-50 text-blue-700 border-blue-200',          active: 'border-blue-600 bg-blue-50/50',       hint: 'Sistem',  desc: 'Akses Penuh Kelola Sistem' },
            },

            get filtered() {
                const q = this.search.trim().toLowerCase();
                return this.users.filter(u => {
                    const okRole = this.roleFilter === 'ALL' || u.role === this.roleFilter;
                    const okSearch = !q || [u.nama, u.email, u.role, u.departemen_nama, u.no_telp].some(v => (v || '').toLowerCase().includes(q));
                    return okRole && okSearch;
                });
            },

            formatRole(role) {
                return role ? role.charAt(0).toUpperCase() + role.slice(1) : '';
            },

            initials(name) {
                const p = (name || '').trim().split(/\s+/);
                return ((p[0]?.[0] || '') + (p[1]?.[0] || p[0]?.[1] || '')).toUpperCase() || 'US';
            },

            openAdd() {
                this.form = { nama: '', email: '', role: 'user', no_telp: '', id_departemen: '', kata_sandi: '' };
                this.modal = 'add';
            },

            openEdit(user) {
                this.form = { ...user, kata_sandi: '' };
                this.modal = 'edit';
            },

            openDelete(user) {
                this.deleteTarget = user;
                this.modal = 'delete';
            },

            close() {
                this.modal = null;
                this.deleteTarget = null;
            },

            resetFilter() {
                this.search = '';
                this.roleFilter = 'ALL';
                this.$nextTick(() => this.$refs.filterForm.requestSubmit());
            },

            toast(msg, type = 'success') {
                this.toastMsg = msg;
                this.toastType = type;
                clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMsg = '', 3500);
            },

            async submitUser(formElement) {
                if (this.saving) return;

                this.saving = true;

                try {
                    const response = await fetch(formElement.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                        },
                        body: new FormData(formElement),
                        credentials: 'same-origin',
                    });
                    const result = await response.json();

                    if (!response.ok) {
                        const errors = Object.values(result.errors || {}).flat();
                        this.toast(errors.join(' ') || result.message || 'Pengguna gagal disimpan.', 'error');
                        return;
                    }

                    if (this.modal === 'delete') {
                        const index = this.users.findIndex(user => user.id === result.user.id);
                        if (index !== -1) this.users.splice(index, 1);
                        this.totalUsers--;
                    } else if (this.modal === 'edit') {
                        const index = this.users.findIndex(user => user.id === result.user.id);
                        if (index !== -1) this.users[index] = result.user;
                    } else {
                        this.users.unshift(result.user);
                        this.totalUsers++;
                    }

                    this.close();
                    this.toast(result.message);
                } catch (error) {
                    this.toast('Permintaan gagal. Periksa koneksi lalu coba kembali.', 'error');
                } finally {
                    this.saving = false;
                }
            },

            async confirmDelete(formElement) {
                if (!this.deleteTarget) return;
                await this.submitUser(formElement);
            },

        }));
    });
</script>
@endsection