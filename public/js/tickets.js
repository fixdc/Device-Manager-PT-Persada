document.addEventListener('DOMContentLoaded', () => {
    const $ = (selector, parent = document) => parent.querySelector(selector);
    const $$ = (selector, parent = document) => [...parent.querySelectorAll(selector)];

    const state = {
        selectedIds: new Set(),
        filters: {
            query: '',
            range: 'Last 7 Days',
            priority: 'Urgent',
            type: 'Incident',
            sortBy: 'Newest',
            sortColumn: null,
            sortDirection: 'asc',
        },
        currentPage: 1,
        perPage: 10,
    };

    const sidebar = $('#sidebar-drawer');
    const backdrop = $('#sidebar-backdrop');

    function openDrawer() {
        sidebar?.classList.remove('-translate-x-full');
        backdrop?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDrawer() {
        sidebar?.classList.add('-translate-x-full');
        backdrop?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    $('#open-sidebar-btn')?.addEventListener('click', openDrawer);
    $('#close-sidebar-btn')?.addEventListener('click', closeDrawer);
    backdrop?.addEventListener('click', closeDrawer);

    const tableBody = $('#tickets-table-body');
    const checkAll = $('#check-all');
    const filterGroup = $('#filter-group');
    const actionGroup = $('#action-group');
    const editButton = $('#btn-edit');
    const selectedCounter = $('#selected-counter-badge');

    function updateSelection() {
        const rowCheckboxes = $$('.ticket-row-check');
        const checked = rowCheckboxes.filter((checkbox) => checkbox.checked);

        state.selectedIds = new Set(checked.map((checkbox) => checkbox.dataset.ticketId));

        if (checkAll) {
            checkAll.checked = checked.length > 0 && checked.length === rowCheckboxes.length;
            checkAll.indeterminate = checked.length > 0 && checked.length < rowCheckboxes.length;
        }

        const hasSelection = checked.length > 0;
        filterGroup?.classList.toggle('hidden', hasSelection);
        filterGroup?.classList.toggle('flex', !hasSelection);
        actionGroup?.classList.toggle('hidden', !hasSelection);
        actionGroup?.classList.toggle('flex', hasSelection);

        if (selectedCounter) selectedCounter.textContent = `${checked.length} terpilih`;

        if (editButton) {
            const disabled = checked.length !== 1;
            editButton.disabled = disabled;
            editButton.classList.toggle('bg-[#CBD5E1]', disabled);
            editButton.classList.toggle('cursor-not-allowed', disabled);
            editButton.classList.toggle('opacity-60', disabled);
            editButton.classList.toggle('bg-[#112340]', !disabled);
            editButton.classList.toggle('hover:bg-slate-700', !disabled);
        }
    }

    checkAll?.addEventListener('change', (event) => {
        $$('.ticket-row-check').forEach((checkbox) => {
            checkbox.checked = event.target.checked;
        });
        updateSelection();
    });

    tableBody?.addEventListener('change', (event) => {
        if (event.target.matches('.ticket-row-check')) updateSelection();
    });

    function closeAllDropdowns() {
        $$('.dropdown-container').forEach((container) => {
            $('.dropdown-menu', container)?.classList.add('hidden');
            $('.chevron-icon', container)?.classList.remove('rotate-180');
            $('.dropdown-trigger', container)?.setAttribute('aria-expanded', 'false');
        });
    }

    $$('.dropdown-container').forEach((container) => {
        const trigger = $('.dropdown-trigger', container);
        const menu = $('.dropdown-menu', container);
        if (!trigger || !menu) return;

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            const wasOpen = !menu.classList.contains('hidden');
            closeAllDropdowns();

            if (!wasOpen) {
                menu.classList.remove('hidden');
                trigger.setAttribute('aria-expanded', 'true');
                $('.chevron-icon', container)?.classList.add('rotate-180');
            }
        });

        $$('.dropdown-option', container).forEach((option) => {
            option.addEventListener('click', (event) => {
                event.stopPropagation();

                const value = option.dataset.value || option.textContent.trim();
                const filterType = option.dataset.filterType;
                const label = $('.trigger-label', container);

                if (label) label.textContent = value;
                if (filterType) state.filters[filterType] = value;

                $$('.dropdown-option', container).forEach((item) => {
                    item.classList.remove('font-semibold', 'bg-slate-50', 'bg-slate-100');
                    item.classList.add('font-medium');
                });

                option.classList.remove('font-medium');
                option.classList.add('font-semibold', 'bg-slate-50');
                closeAllDropdowns();
                state.currentPage = 1;
                renderTable();
            });
        });
    });

    document.addEventListener('click', closeAllDropdowns);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAllDropdowns();
            closeDrawer();
        }
    });

    const searchInput = $('#global-search-input');
    let searchTimeout;
    searchInput?.addEventListener('input', (event) => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            state.filters.query = event.target.value.trim().toLowerCase();
            state.currentPage = 1;
            renderTable();
        }, 250);
    });

    $('#per-page-select')?.addEventListener('change', (event) => {
        state.perPage = Number.parseInt(event.target.value, 10) || 10;
        state.currentPage = 1;
        renderTable();
    });

    const sortableHeaders = $$('th[data-sort-key]');
    sortableHeaders.forEach((header) => {
        header.addEventListener('click', () => {
            const key = header.dataset.sortKey;
            state.filters.sortDirection =
                state.filters.sortColumn === key && state.filters.sortDirection === 'asc' ? 'desc' : 'asc';
            state.filters.sortColumn = key;

            sortableHeaders.forEach((item) => {
                const icon = $('.sort-icon', item);
                icon?.classList.remove('text-blue-600', 'rotate-180');
                icon?.classList.add('text-slate-400');
            });

            const activeIcon = $('.sort-icon', header);
            activeIcon?.classList.remove('text-slate-400');
            activeIcon?.classList.add('text-blue-600');
            if (state.filters.sortDirection === 'desc') activeIcon?.classList.add('rotate-180');

            renderTable();
        });
    });

    function getFilteredRows() {
        let rows = $$('#tickets-table-body tr');

        const query = state.filters.query;
        if (query) {
            rows = rows.filter((row) => row.textContent.toLowerCase().includes(query));
        }

        if (state.filters.priority !== 'All Priority') {
            rows = rows.filter((row) => row.dataset.priority === state.filters.priority);
        }

        if (state.filters.type !== 'All Type') {
            rows = rows.filter((row) => $('[data-field="type"]', row)?.textContent.trim() === state.filters.type);
        }

        if (state.filters.sortColumn) {
            const key = state.filters.sortColumn;
            rows.sort((a, b) => {
                const aValue = $(`[data-field="${key}"]`, a)?.textContent.trim() || '';
                const bValue = $(`[data-field="${key}"]`, b)?.textContent.trim() || '';
                const result = aValue.localeCompare(bValue, 'id', { numeric: true });
                return state.filters.sortDirection === 'asc' ? result : -result;
            });
        } else if (state.filters.sortBy !== 'All') {
            rows.sort((a, b) => {
                const result = new Date(a.dataset.createdAt) - new Date(b.dataset.createdAt);
                return state.filters.sortBy === 'Newest' ? -result : result;
            });
        }

        return rows;
    }

    function renderPagination(total) {
        const pageCount = Math.max(1, Math.ceil(total / state.perPage));
        state.currentPage = Math.min(state.currentPage, pageCount);

        const start = total === 0 ? 0 : (state.currentPage - 1) * state.perPage + 1;
        const end = Math.min(state.currentPage * state.perPage, total);

        $('#pagination-info').textContent = `Menampilkan ${start} - ${end} dari ${total} data tiket`;

        const pages = $('#pagination-pages');
        pages.innerHTML = '';

        for (let page = 1; page <= pageCount; page++) {
            if (pageCount > 5 && page > 3 && page < pageCount) {
                if (page === 4) {
                    const dots = document.createElement('span');
                    dots.className = 'px-1 font-bold text-slate-400';
                    dots.textContent = '...';
                    pages.append(dots);
                }
                continue;
            }

            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = page;
            button.className = page === state.currentPage
                ? 'h-8 w-8 rounded-lg bg-[#112340] text-xs font-bold text-white'
                : 'h-8 w-8 rounded-lg text-xs font-semibold text-slate-700 transition hover:bg-slate-100';
            button.addEventListener('click', () => {
                state.currentPage = page;
                renderTable();
            });
            pages.append(button);
        }

        const previous = $('#pagination-prev');
        const next = $('#pagination-next');
        previous.disabled = state.currentPage === 1;
        next.disabled = state.currentPage === pageCount;
        previous.onclick = () => {
            if (state.currentPage > 1) {
                state.currentPage--;
                renderTable();
            }
        };
        next.onclick = () => {
            if (state.currentPage < pageCount) {
                state.currentPage++;
                renderTable();
            }
        };
    }

    function renderTable() {
        const allRows = $$('#tickets-table-body tr');
        const filteredRows = getFilteredRows();
        const startIndex = (state.currentPage - 1) * state.perPage;
        const visibleRows = new Set(filteredRows.slice(startIndex, startIndex + state.perPage));

        allRows.forEach((row) => {
            row.classList.toggle('hidden', !visibleRows.has(row));
        });

        const empty = $('#table-empty-state');
        const content = $('#table-content-container');
        empty?.classList.toggle('hidden', filteredRows.length !== 0);
        empty?.classList.toggle('flex', filteredRows.length === 0);
        content?.classList.toggle('hidden', filteredRows.length === 0);

        renderPagination(filteredRows.length);
        updateSelection();
    }

    document.addEventListener('click', (event) => {
        const actionButton = event.target.closest('[data-action]');
        if (!actionButton) return;

        const action = actionButton.dataset.action;
        const ticketId = actionButton.dataset.ticketId;

        // Placeholder: sambungkan ke route/controller Laravel untuk operasi database.
        switch (action) {
            case 'view':
                console.info('[Ticket: View]', ticketId);
                break;
            case 'edit':
                console.info('[Ticket: Edit]', ticketId);
                break;
            case 'delete':
                console.info('[Ticket: Delete]', ticketId);
                break;
            case 'bulk-edit':
                if (state.selectedIds.size === 1) {
                    console.info('[Ticket: Bulk Edit]', [...state.selectedIds]);
                }
                break;
            case 'bulk-delete':
                console.info('[Ticket: Bulk Delete]', [...state.selectedIds]);
                break;
        }
    });

    renderTable();
});
