@props([
    'label',
    'value',
    'description',
    'badge' => null,
    'iconBg' => 'bg-sky-100',
    'iconColor' => 'text-sky-600',
])

<div class="flex flex-col justify-between rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:shadow">
    <div class="mb-3 flex items-center justify-between">
        <span class="text-sm font-semibold text-slate-800">{{ $label }}</span>
        @if ($badge)
            <span class="rounded bg-amber-500 px-1.5 py-0.5 text-[10px] font-extrabold tracking-wider text-white">{{ $badge }}</span>
        @else
            <span class="flex h-7 w-7 items-center justify-center rounded-lg {{ $iconBg }} {{ $iconColor }}">
                {{ $icon ?? '' }}
            </span>
        @endif
    </div>
    <div>
        <div class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">{{ $value }}</div>
        <p class="mt-1 text-[11px] font-medium text-slate-400">{{ $description }}</p>
    </div>
</div>
