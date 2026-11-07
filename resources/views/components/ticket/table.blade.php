<div class="flex flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm" data-purpose="tickets-table-container">
    <div id="table-loading-state" class="hidden flex-col items-center justify-center space-y-3 bg-white p-12">
        <div class="h-8 w-8 animate-spin rounded-full border-4 border-slate-200 border-t-[#0284C7]"></div>
        <p class="text-sm font-semibold text-slate-500">Memuat data tiket...</p>
    </div>

    <div id="table-empty-state" class="hidden flex-col items-center justify-center p-12 text-center">
        <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
        </div>
        <h3 class="text-base font-bold text-slate-800">Tidak ada tiket ditemukan</h3>
        <p class="mt-1 max-w-sm text-xs text-slate-400">Coba ubah kata kunci pencarian atau sesuaikan opsi filter Anda.</p>
    </div>

    <div id="table-content-container" class="table-scroll-wrapper overflow-x-auto">
        <table id="tickets-table" class="w-full min-w-[760px] border-collapse text-left">
            <thead>
                <tr class="rounded-t-2xl border-b border-slate-200/80 bg-[#F0F5FA] text-xs font-semibold text-slate-800">
                    <th scope="col" class="w-16 rounded-tl-2xl py-4 pl-6 pr-2">
                        <input id="check-all" type="checkbox" aria-label="Pilih semua tiket" class="ticket-checkbox">
                    </th>
                    @foreach (['ticketCode' => 'ID Tiket', 'subject' => 'Subjek', 'deviceId' => 'ID Perangkat', 'type' => 'Jenis', 'urgency' => 'Urgensi'] as $key => $heading)
                        <th scope="col" data-sort-key="{{ $key }}" class="cursor-pointer select-none px-4 py-4 font-bold transition-colors hover:text-blue-600">
                            <span class="inline-flex items-center gap-1.5">
                                {{ $heading }}
                                <svg class="sort-icon h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                            </span>
                        </th>
                    @endforeach
                    <th scope="col" class="w-12 rounded-tr-2xl py-4 pl-2 pr-6 text-center"></th>
                </tr>
            </thead>
            <tbody id="tickets-table-body" class="divide-y divide-slate-100 text-sm">
                @foreach ($tickets as $ticket)
                    <tr class="transition-colors hover:bg-slate-50/70"
                        data-ticket-id="{{ $ticket['id'] }}"
                        data-status="{{ $ticket['status'] }}"
                        data-priority="{{ $ticket['priorityLevel'] }}"
                        data-created-at="{{ $ticket['createdAt'] }}">
                        <td class="py-4 pl-6 pr-2">
                            <input type="checkbox" class="ticket-row-check ticket-checkbox"
                                   data-ticket-id="{{ $ticket['id'] }}"
                                   aria-label="Pilih tiket {{ $ticket['ticketCode'] }}">
                        </td>
                        <td class="whitespace-nowrap px-4 py-4 font-bold text-slate-900" data-field="ticketCode">{{ $ticket['ticketCode'] }}</td>
                        <td class="max-w-[220px] truncate px-4 py-4 font-normal text-slate-700" data-field="subject" title="{{ $ticket['subject'] }}">{{ $ticket['subject'] }}</td>
                        <td class="whitespace-nowrap px-4 py-4 font-normal text-slate-600" data-field="deviceId">{{ $ticket['deviceId'] }}</td>
                        <td class="whitespace-nowrap px-4 py-4 font-semibold text-slate-800" data-field="type">{{ $ticket['type'] }}</td>
                        <td class="whitespace-nowrap px-4 py-4" data-field="urgency">
                            @php
                                $urgencyStyle = match ($ticket['urgency']) {
                                    'Mendesak' => ['dot' => 'bg-red-500', 'text' => 'text-red-600'],
                                    'Sedang' => ['dot' => 'bg-amber-500', 'text' => 'text-amber-500'],
                                    default => ['dot' => 'bg-emerald-500', 'text' => 'text-emerald-500'],
                                };
                            @endphp
                            <div class="inline-flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full {{ $urgencyStyle['dot'] }}"></span>
                                <span class="font-semibold {{ $urgencyStyle['text'] }}">{{ $ticket['urgency'] }}</span>
                            </div>
                        </td>
                        <td class="relative py-4 pl-2 pr-6 text-right">
                            <div class="relative inline-block dropdown-container">
                                <button type="button" aria-label="Opsi tiket {{ $ticket['ticketCode'] }}" aria-expanded="false" aria-haspopup="true"
                                        class="row-action-btn dropdown-trigger rounded-lg p-1.5 text-slate-700 transition hover:bg-slate-100 hover:text-slate-900">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                                </button>
                                <div class="dropdown-menu absolute right-0 z-40 mt-1 hidden w-32 rounded-xl border border-slate-200/80 bg-white py-1.5 text-left shadow-lg" role="menu">
                                    <button type="button" role="menuitem" class="row-option w-full px-4 py-2 text-left text-sm font-medium text-slate-800 transition-colors hover:bg-slate-50" data-action="view" data-ticket-id="{{ $ticket['id'] }}">View</button>
                                    <button type="button" role="menuitem" class="row-option w-full px-4 py-2 text-left text-sm font-medium text-slate-800 transition-colors hover:bg-slate-50" data-action="edit" data-ticket-id="{{ $ticket['id'] }}">Edit</button>
                                    <button type="button" role="menuitem" class="row-option w-full px-4 py-2 text-left text-sm font-medium text-red-600 transition-colors hover:bg-red-50" data-action="delete" data-ticket-id="{{ $ticket['id'] }}">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.ticket.pagination')
</div>
