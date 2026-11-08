@extends('layouts.index')

@section('content')
@php
    /*
     * DATA DUMMY (frontend only).
     * Nanti ganti dengan data dari controller: $devices (perangkat milik user) dan $categories.
     */
    $devices = [
        ['id' => 'DEV-001', 'name' => 'Laptop Acer'],
        ['id' => 'DEV-002', 'name' => 'Monitor LG 24 Inch UltraGear'],
        ['id' => 'DEV-003', 'name' => 'Printer Epson L380'],
    ];

    $categories = ['Hardware', 'Software / Aplikasi', 'Jaringan / Internet', 'Printer & Scanner', 'Listrik / Peralatan Pendukung', 'Lainnya'];

    // Tujuan tombol Batal. Ganti dengan route kamu, mis. route('user.tickets.index')
    $cancelUrl = url('/dashboard');

    // Path ikon (Heroicons outline)
    $ic = [
        'monitor' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'tag'     => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
        'chevron' => 'M19 9l-7 7-7-7',
        'upload'  => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12',
        'send'    => 'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5',
        'close'   => 'M6 18L18 6M6 6l12 12',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
    ];
    $icon = fn ($key, $class = 'h-4 w-4') => new \Illuminate\Support\HtmlString(
        '<svg class="'.$class.'" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="'.$ic[$key].'"/></svg>'
    );

    // Kelas input yang dipakai berulang
    $field = 'w-full rounded-lg border bg-white py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#10254a]';
    $row   = 'grid grid-cols-1 items-start gap-1.5 sm:grid-cols-[11rem_1fr] sm:gap-4';
    $label = 'pt-0 text-xs font-semibold text-slate-800 sm:pt-2.5';
@endphp

<div x-data="createTicket(@js($cancelUrl))"
     @keydown.escape.window="modal = null; sidebarOpen = false"
     class="relative flex h-screen overflow-hidden bg-[#fafafa] text-slate-800">

    {{-- Sidebar user --}}
    <x-sidebar role="user" active="buat" />

    <div class="flex min-w-0 flex-1 flex-col">
        <x-navbar name="Fikri" role="User" />

        <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
            <section class="w-full rounded-xl bg-white p-5 shadow-sm sm:p-8">

                <div class="mb-6 border-b border-slate-200 pb-4">
                    <h1 class="text-lg font-bold text-slate-900 sm:text-xl">Buat Tiket Kerusakan</h1>
                    <p class="mt-0.5 text-xs text-slate-500 sm:text-sm">Laporkan kendala atau kerusakan perangkat yang Anda gunakan.</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" @submit.prevent="submit()" novalidate class="space-y-5">
                    @csrf

                    {{-- Perangkat --}}
                    <div class="{{ $row }}">
                        <label for="device" class="{{ $label }}">Perangkat <span class="text-red-500">*</span></label>
                        <div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">{{ $icon('monitor') }}</span>
                                <select id="device" name="device_id" x-model="form.device" @change="errors.device = ''"
                                        :aria-invalid="!!errors.device" aria-describedby="err-device"
                                        class="{{ $field }} appearance-none pl-10 pr-10" :class="errors.device ? 'border-red-400' : 'border-slate-200'">
                                    <option value="" disabled>Pilih perangkat</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device['id'] }}">{{ $device['name'] }} ({{ $device['id'] }})</option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">{{ $icon('chevron') }}</span>
                            </div>
                            <p id="err-device" x-show="errors.device" x-cloak x-text="errors.device" class="mt-1 text-xs text-red-600"></p>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="{{ $row }}">
                        <label for="category" class="{{ $label }}">Kategori Kerusakan <span class="text-red-500">*</span></label>
                        <div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">{{ $icon('tag') }}</span>
                                <select id="category" name="category" x-model="form.category" @change="errors.category = ''"
                                        :aria-invalid="!!errors.category" aria-describedby="err-category"
                                        class="{{ $field }} appearance-none pl-10 pr-10" :class="errors.category ? 'border-red-400' : 'border-slate-200'">
                                    <option value="" disabled>Pilih kategori kerusakan</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">{{ $icon('chevron') }}</span>
                            </div>
                            <p id="err-category" x-show="errors.category" x-cloak x-text="errors.category" class="mt-1 text-xs text-red-600"></p>
                        </div>
                    </div>

                    {{-- Judul --}}
                    <div class="{{ $row }}">
                        <label for="title" class="{{ $label }}">Judul Laporan <span class="text-red-500">*</span></label>
                        <div>
                            <input id="title" type="text" name="title" maxlength="120" x-model="form.title" @input="errors.title = ''"
                                   placeholder="Contoh: Layar laptop tidak menyala"
                                   :aria-invalid="!!errors.title" aria-describedby="err-title"
                                   class="{{ $field }} px-3.5" :class="errors.title ? 'border-red-400' : 'border-slate-200'">
                            <p id="err-title" x-show="errors.title" x-cloak x-text="errors.title" class="mt-1 text-xs text-red-600"></p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="{{ $row }}">
                        <label for="description" class="{{ $label }}">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                        <div>
                            <textarea id="description" name="description" rows="6" maxlength="1000" x-model="form.description" @input="errors.description = ''"
                                      placeholder="Jelaskan detail kendala atau kerusakan yang terjadi.."
                                      :aria-invalid="!!errors.description" aria-describedby="err-description"
                                      class="{{ $field }} resize-none px-3.5 py-3" :class="errors.description ? 'border-red-400' : 'border-slate-200'"></textarea>
                            <div class="mt-1 flex items-start justify-between gap-3">
                                <p id="err-description" x-show="errors.description" x-cloak x-text="errors.description" class="text-xs text-red-600"></p>
                                <span class="ml-auto font-mono text-[10px] text-slate-400" x-text="`${form.description.length} / 1000 karakter`"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Urgensi --}}
                    <div class="{{ $row }}">
                        <span id="urgency-label" class="{{ $label }}">Urgensi Kerusakan <span class="text-red-500">*</span></span>
                        <div role="radiogroup" aria-labelledby="urgency-label" class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <template x-for="u in Object.keys(urgencies)" :key="u">
                                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg border px-4 py-3.5 shadow-sm transition-colors focus-within:ring-2 focus-within:ring-[#10254a]/40"
                                       :class="form.urgency === u ? urgencies[u].active : 'border-slate-200 bg-white hover:bg-slate-50'">
                                    <input type="radio" name="urgency" :value="u" x-model="form.urgency" class="sr-only">
                                    <span class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full border bg-white" :class="form.urgency === u ? 'border-[#10254a]' : 'border-slate-300'">
                                        <span x-show="form.urgency === u" class="h-2 w-2 rounded-full bg-[#10254a]"></span>
                                    </span>
                                    <span class="flex items-center gap-1.5 text-sm font-semibold text-slate-900">
                                        <span class="h-1.5 w-1.5 rounded-full" :class="urgencies[u].dot"></span>
                                        <span x-text="u"></span>
                                    </span>
                                </label>
                            </template>
                        </div>
                    </div>

                    {{-- Upload foto --}}
                    <div class="{{ $row }}">
                        <span class="{{ $label }}">Upload Foto <span class="font-normal text-slate-400">(Opsional)</span></span>
                        <div>
                            {{-- Dropzone --}}
                            <label x-show="!photo"
                                   @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false"
                                   @drop.prevent="dragging = false; onDrop($event)"
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed px-6 py-9 text-center transition-colors focus-within:ring-2 focus-within:ring-[#10254a]/40"
                                   :class="dragging ? 'border-[#10254a] bg-slate-50' : (errors.photo ? 'border-red-400' : 'border-slate-200 hover:bg-slate-50')">
                                <span class="mb-2 text-slate-600">{{ $icon('upload', 'h-5 w-5') }}</span>
                                <span class="text-xs font-semibold text-slate-800">Seret dan lepas file di sini, atau klik untuk memilih</span>
                                <span class="mt-1 text-[11px] text-slate-400">Format: JPG, PNG (maks. 5 MB)</span>
                                <input x-ref="file" type="file" name="photo" accept="image/png,image/jpeg" @change="onPick($event)" class="sr-only">
                            </label>

                            {{-- Pratinjau --}}
                            <div x-show="photo" x-cloak class="flex items-center justify-between gap-3 rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <img :src="photo?.url" alt="Pratinjau foto" class="h-14 w-14 shrink-0 rounded-md border border-slate-200 object-cover">
                                    <div class="min-w-0">
                                        <div class="truncate text-xs font-semibold text-slate-900" x-text="photo?.name"></div>
                                        <div class="text-[11px] text-slate-400" x-text="photo?.size"></div>
                                    </div>
                                </div>
                                <button type="button" @click="removePhoto()" class="shrink-0 rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-200 hover:text-slate-700" aria-label="Hapus foto">{{ $icon('close', 'h-4 w-4') }}</button>
                            </div>

                            <p x-show="errors.photo" x-cloak x-text="errors.photo" class="mt-1 text-xs text-red-600" role="alert"></p>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="flex flex-col-reverse items-stretch justify-end gap-3 pt-4 sm:flex-row sm:items-center">
                        <button type="button" @click="cancel()"
                                class="rounded-lg border border-slate-200 bg-white px-8 py-2.5 text-center text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit" :disabled="sending"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#10254a] px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#0b1b3a] disabled:cursor-not-allowed disabled:opacity-60">
                            <svg x-show="sending" x-cloak class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            <span x-show="!sending" class="flex items-center gap-2">{{ $icon('send') }}</span>
                            <span x-text="sending ? 'Mengirim...' : 'Kirim Tiket'"></span>
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    {{-- ============ TOAST ============ --}}
    <div x-show="toastMsg" x-cloak x-transition
         class="fixed right-5 top-5 z-[100] max-w-sm rounded-xl border px-4 py-3 text-sm font-medium text-white shadow-lg"
         :class="toastType === 'success' ? 'border-slate-700 bg-[#10254a]' : 'border-rose-700 bg-rose-600'" role="status" aria-live="polite">
        <span x-text="toastMsg"></span>
    </div>

    {{-- ============ MODAL BUANG ISIAN ============ --}}
    <div x-show="modal === 'discard'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="alertdialog" aria-modal="true" aria-labelledby="modal-discard-title">
        <div x-show="modal === 'discard'" x-transition.opacity @click="modal = null" class="absolute inset-0 bg-slate-900/50"></div>

        <div x-show="modal === 'discard'" x-transition class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white p-5 shadow-2xl sm:p-7">
            <div class="mb-4 flex items-start gap-3.5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-amber-100 bg-amber-50 text-amber-600">{{ $icon('warning', 'h-5 w-5') }}</span>
                <div>
                    <h3 id="modal-discard-title" class="text-lg font-bold leading-tight text-slate-900">Batalkan pembuatan tiket?</h3>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600">Isian yang sudah Anda tulis belum dikirim dan akan hilang.</p>
                </div>
            </div>
            <div class="flex flex-col-reverse items-stretch justify-end gap-2.5 pt-2 sm:flex-row sm:items-center sm:gap-3">
                <button type="button" @click="modal = null" class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Lanjut mengisi</button>
                <button type="button" @click="leave()" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700">Ya, batalkan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('createTicket', (cancelUrl) => ({
            sidebarOpen: false,
            form: { device: '', category: '', title: '', description: '', urgency: 'Rendah' },
            errors: {},
            photo: null,            // { name, size, url }
            dragging: false,
            sending: false,
            modal: null,            // 'discard' | null
            toastMsg: '',
            toastType: 'success',
            toastTimer: null,

            urgencies: {
                Rendah: { dot: 'bg-emerald-500', active: 'border-emerald-500 bg-emerald-50' },
                Sedang: { dot: 'bg-amber-500',   active: 'border-amber-400 bg-amber-50' },
                Urgent: { dot: 'bg-red-500',     active: 'border-red-400 bg-red-50' },
            },

            get dirty() {
                const f = this.form;
                return !!(f.device || f.category || f.title.trim() || f.description.trim() || f.urgency !== 'Rendah' || this.photo);
            },

            toast(msg, type = 'success') {
                this.toastMsg = msg;
                this.toastType = type;
                clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => this.toastMsg = '', 4000);
            },

            // ---------- Foto ----------
            onPick(e) { this.handleFile(e.target.files[0]); },
            onDrop(e) {
                const file = e.dataTransfer.files[0];
                if (!file) return;
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.file.files = dt.files;      // supaya ikut terkirim saat form disubmit
                this.handleFile(file);
            },
            handleFile(file) {
                if (!file) return;
                this.errors.photo = '';
                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    this.errors.photo = 'Format file harus JPG atau PNG.';
                    this.$refs.file.value = '';
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    this.errors.photo = 'Ukuran file maksimal 5 MB.';
                    this.$refs.file.value = '';
                    return;
                }
                if (this.photo) URL.revokeObjectURL(this.photo.url);
                this.photo = { name: file.name, size: (file.size / 1024 / 1024).toFixed(2) + ' MB', url: URL.createObjectURL(file) };
            },
            removePhoto() {
                if (this.photo) URL.revokeObjectURL(this.photo.url);
                this.photo = null;
                this.errors.photo = '';
                if (this.$refs.file) this.$refs.file.value = '';
            },

            // ---------- Form ----------
            validate() {
                const f = this.form, e = {};
                if (!f.device)   e.device = 'Pilih perangkat yang bermasalah.';
                if (!f.category) e.category = 'Pilih kategori kerusakan.';
                if (!f.title.trim()) e.title = 'Judul laporan wajib diisi.';
                if (f.description.trim().length < 10) e.description = 'Jelaskan kerusakan minimal 10 karakter.';
                this.errors = { ...e, photo: this.errors.photo || '' };
                return Object.keys(e).length === 0 && !this.errors.photo;
            },

            // Frontend saja (simulasi). Nanti: setelah validate() lolos, kirim form ke backend
            // (mis. $el.closest('form').submit() atau fetch ke route store).
            submit() {
                if (this.sending) return;
                if (!this.validate()) {
                    this.toast('Lengkapi data yang bertanda bintang terlebih dahulu.', 'error');
                    this.$nextTick(() => document.querySelector('[aria-invalid="true"]')?.focus());
                    return;
                }
                this.sending = true;
                setTimeout(() => {
                    const title = this.form.title.trim();
                    this.sending = false;
                    this.resetForm();
                    this.toast(`Tiket "${title}" berhasil dikirim.`);
                }, 900);
            },
            resetForm() {
                this.form = { device: '', category: '', title: '', description: '', urgency: 'Rendah' };
                this.errors = {};
                this.removePhoto();
            },

            // ---------- Batal ----------
            cancel() { this.dirty ? this.modal = 'discard' : this.leave(); },
            leave()  { window.location.href = cancelUrl; },
        }));
    });
</script>
@endsection