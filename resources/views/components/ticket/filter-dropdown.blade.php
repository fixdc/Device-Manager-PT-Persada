{{--
    Dropdown filter (dipakai di halaman Ticket)
    Lokasi  : resources/views/components/ticket/filter-dropdown.blade.php

    Pemakaian:
      <x-ticket.filter-dropdown name="priority" :options="['All Priority', 'Urgent', 'Medium', 'Low']" />

    Butuh state Alpine dari halaman induk:
      filters[name], openDd, label(name), setFilter(name, value)
--}}
@props(['name', 'options' => [], 'align' => 'right', 'width' => ''])

<div class="relative flex-1 sm:flex-initial" @click.outside="if (openDd === '{{ $name }}') openDd = null">
    <button type="button"
            @click="openDd = openDd === '{{ $name }}' ? null : '{{ $name }}'"
            :aria-expanded="openDd === '{{ $name }}'" aria-haspopup="menu"
            class="inline-flex w-full items-center justify-between gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition-colors hover:bg-slate-50 {{ $width }}">
        <span class="truncate" x-text="label('{{ $name }}')"></span>
        <svg class="h-4 w-4 shrink-0 text-slate-600 transition-transform duration-200" :class="openDd === '{{ $name }}' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div x-show="openDd === '{{ $name }}'" x-cloak x-transition.opacity.duration.100ms role="menu"
         class="absolute {{ $align === 'left' ? 'left-0' : 'right-0' }} z-30 mt-1.5 w-44 rounded-xl border border-slate-200 bg-white py-1.5 shadow-lg">
        @foreach ($options as $option)
            <button type="button" role="menuitem"
                    @click="setFilter('{{ $name }}', '{{ $option }}')"
                    class="flex w-full items-center justify-between px-4 py-2 text-left text-sm transition-colors hover:bg-slate-50"
                    :class="filters.{{ $name }} === '{{ $option }}' ? 'bg-slate-50 font-semibold text-slate-900' : 'font-medium text-slate-700'">
                {{ $option }}
                <svg x-show="filters.{{ $name }} === '{{ $option }}'" class="h-4 w-4 text-[#10254a]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        @endforeach
    </div>
</div>