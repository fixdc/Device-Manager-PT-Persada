{{--
    Pop up "Scan QR Perangkat" (simulasi)
    Lokasi  : resources/views/components/qr-scan-modal.blade.php
    Pemakaian: <x-qr-scan-modal />   (cukup sekali per halaman, atau sekali di layouts/index.blade.php
               supaya tombol "Mulai Scan QR" di sidebar jalan di semua halaman)

    Dibuka lewat event: $dispatch('open-qr-scan')  (sudah dipasang di tombol sidebar)

    Nanti ganti viewfinder palsu ini dengan pemindai kamera sungguhan (mis. library html5-qrcode)
    dan arahkan ke URL perangkat hasil pindaian.
--}}
<div x-data="{ open: false, toastMsg: '', timer: null,
               simulate() {
                   this.open = false;
                   this.toastMsg = 'QR terdeteksi: Laptop Acer (DEV-001)';
                   clearTimeout(this.timer);
                   this.timer = setTimeout(() => this.toastMsg = '', 3500);
               } }"
     @open-qr-scan.window="open = true"
     @keydown.escape.window="open = false">

    <div x-show="open" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="qr-scan-title">
        <div x-show="open" x-transition.opacity @click="open = false" class="absolute inset-0 bg-slate-950/60"></div>

        <div x-show="open" x-transition class="relative w-full max-w-sm rounded-2xl bg-white p-6 text-center shadow-2xl">
            <button type="button" @click="open = false" class="absolute right-4 top-4 rounded-full p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tutup">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-800">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm8-2h2v2h-2v-2zm4 0h4v2h-4v-2zm-4 4h2v4h-2v-4zm4 2h4v2h-4v-2z"/></svg>
            </div>
            <h3 id="qr-scan-title" class="mb-1 text-base font-bold text-slate-900">Scan QR Perangkat</h3>
            <p class="mb-5 text-xs text-slate-500">Arahkan kamera ke stiker QR pada perangkat untuk melihat riwayatnya secara otomatis.</p>

            <div class="relative mx-auto mb-5 flex h-48 w-48 items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-blue-500 bg-slate-900/5">
                <div class="relative flex h-36 w-36 items-center justify-center rounded-lg border border-blue-400/40">
                    <div class="absolute h-0.5 w-full animate-pulse bg-blue-500"></div>
                    <span class="font-mono text-[10px] text-blue-600">ARAHKAN KODE</span>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="button" @click="open = false" class="flex-1 rounded-lg py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100">Batal</button>
                <button type="button" @click="simulate()" class="flex-1 rounded-lg bg-[#10254a] py-2.5 text-xs font-semibold text-white hover:bg-[#0b1b3a]">Simulasi Sukses</button>
            </div>
        </div>
    </div>

    <div x-show="toastMsg" x-cloak x-transition class="fixed bottom-5 right-5 z-[100] rounded-xl border border-slate-700 bg-[#10254a] px-4 py-3 text-sm font-medium text-white shadow-lg" role="status" aria-live="polite">
        <span x-text="toastMsg"></span>
    </div>
</div>