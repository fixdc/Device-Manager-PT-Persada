{{--
    Checkbox custom (tidak pakai tampilan bawaan browser)
    Lokasi  : resources/views/components/ticket/checkbox.blade.php

    Pemakaian:
      <x-ticket.checkbox label="Pilih semua" x-bind:checked="allSelected" x-on:change="toggleAll($event.target.checked)" />
      <x-ticket.checkbox x-model="form.agree" />

    Prop `indeterminate` berisi ekspresi Alpine (string). Kalau true, kotak menampilkan tanda "-".
    Pakai atribut x-bind:... / x-on:... (bukan :checked) supaya tidak dibaca Blade sebagai ekspresi PHP.
--}}
@props(['label' => '', 'indeterminate' => 'false'])

<label class="relative inline-flex h-[18px] w-[18px] shrink-0 cursor-pointer items-center justify-center">
    {{-- Input asli: transparan, menutupi seluruh kotak (tetap bisa diklik & difokus keyboard) --}}
    <input type="checkbox"
           {{ $attributes->merge([
               'class' => 'peer absolute inset-0 z-10 m-0 h-full w-full cursor-pointer opacity-0',
               'aria-label' => $label !== '' ? $label : null,
           ]) }}>

    {{-- Kotak --}}
    <span class="pointer-events-none h-full w-full rounded-[5px] border-2 border-slate-300 bg-white transition-colors peer-checked:border-[#10254a] peer-checked:bg-[#10254a] peer-focus-visible:ring-2 peer-focus-visible:ring-[#10254a]/30 peer-focus-visible:ring-offset-1"></span>

    {{-- Tanda centang --}}
    <svg class="pointer-events-none absolute h-3 w-3 text-white opacity-0 transition-opacity peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>

    {{-- Tanda strip (sebagian dipilih) --}}
    <span x-show="{{ $indeterminate }}" x-cloak class="pointer-events-none absolute inset-0 flex items-center justify-center rounded-[5px] bg-[#10254a]">
        <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" d="M6 12h12"/>
        </svg>
    </span>
</label>