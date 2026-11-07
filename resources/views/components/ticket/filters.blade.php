<div class="flex flex-col items-stretch justify-between gap-3 pt-2 sm:flex-row sm:items-center" data-purpose="table-filter-and-actions">
    <div class="relative shrink-0 dropdown-container">
        <button id="time-filter-btn" type="button" aria-expanded="false" aria-haspopup="true"
                class="dropdown-trigger inline-flex w-full items-center justify-between rounded-xl border border-slate-200/90 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50 sm:w-auto sm:min-w-[155px]">
            <span class="trigger-label">Last 7 Days</span>
            <svg class="chevron-icon ml-3 h-4 w-4 shrink-0 text-slate-700 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        </button>
        <div class="dropdown-menu absolute left-0 z-30 mt-1.5 hidden w-44 rounded-xl border border-slate-200/80 bg-white py-1.5 shadow-lg" role="menu">
            @foreach (['All Time', 'Today', 'Last 7 Days', 'This Month'] as $range)
                <button type="button" role="menuitem" data-filter-type="range" data-value="{{ $range }}"
                        @class(['dropdown-option w-full px-4 py-2 text-left text-sm transition-colors hover:bg-slate-50', 'bg-slate-50 font-semibold' => $range === 'Last 7 Days', 'font-medium text-slate-800' => $range !== 'Last 7 Days'])>{{ $range }}</button>
            @endforeach
        </div>
    </div>

    <div class="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:gap-3">
        <div id="filter-group" class="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:gap-3">
            @php
                $filters = [
                    'priority' => ['label' => 'Urgent', 'options' => ['All Priority', 'Urgent', 'Medium', 'Low'], 'icon' => 'priority'],
                    'type' => ['label' => 'Incident', 'options' => ['All Type', 'Incident', 'Problem', 'Question', 'Suggestion'], 'icon' => 'type'],
                    'sortBy' => ['label' => 'Sort By', 'options' => ['All', 'Newest', 'Oldest'], 'icon' => 'sort'],
                ];
            @endphp

            @foreach ($filters as $key => $filter)
                <div class="relative flex-1 dropdown-container sm:flex-initial">
                    <button id="{{ $key }}-filter-btn" type="button" aria-expanded="false" aria-haspopup="true"
                            class="dropdown-trigger inline-flex w-full items-center justify-between gap-2 rounded-xl border border-slate-200/90 bg-white px-3 py-2.5 text-xs font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50 sm:justify-start sm:px-4 sm:text-sm">
                        <span class="trigger-label truncate">{{ $filter['label'] }}</span>
                        <svg class="chevron-icon ml-1 h-3.5 w-3.5 shrink-0 text-slate-700 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                    </button>
                    <div class="dropdown-menu absolute right-0 z-30 mt-1.5 hidden w-44 rounded-xl border border-slate-200/80 bg-white py-1.5 shadow-lg" role="menu">
                        @foreach ($filter['options'] as $option)
                            <button type="button" role="menuitem" data-filter-type="{{ $key }}" data-value="{{ $option }}"
                                    @class(['dropdown-option w-full px-4 py-2 text-left text-sm transition-colors hover:bg-slate-50', 'bg-slate-50 font-semibold' => $option === $filter['label'], 'font-medium text-slate-800' => $option !== $filter['label']])>{{ $option }}</button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div id="action-group" class="hidden w-full items-center gap-3 sm:w-auto">
            <span id="selected-counter-badge" class="mr-1 hidden text-xs font-semibold text-slate-500 sm:inline">0 terpilih</span>
            <button id="btn-edit" type="button" data-action="bulk-edit"
                    class="flex-1 cursor-pointer rounded-xl bg-[#112340] px-6 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 sm:w-32">
                Edit
            </button>
            <button id="btn-delete" type="button" data-action="bulk-delete"
                    class="flex-1 rounded-xl bg-[#BA1A1A] px-6 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 sm:w-32">
                Delete
            </button>
        </div>
    </div>
</div>
