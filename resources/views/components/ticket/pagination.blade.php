<div id="table-pagination-toolbar" class="flex flex-col items-center justify-between gap-4 border-t border-slate-200/80 bg-white px-6 py-4 text-xs font-medium text-slate-600 sm:flex-row sm:text-sm">
    <div class="flex w-full items-center justify-between gap-4 sm:w-auto sm:justify-start">
        <span id="pagination-info">Menampilkan 1 - 6 dari 6 data tiket</span>
        <div class="flex items-center gap-2">
            <label for="per-page-select" class="hidden text-xs text-slate-400 md:inline">Per halaman:</label>
            <select id="per-page-select" class="cursor-pointer rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <div class="flex w-full items-center justify-center gap-1.5 sm:w-auto sm:justify-end">
        <button id="pagination-prev" type="button" aria-label="Halaman sebelumnya" disabled
                class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-500 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40">Sebelumnya</button>
        <div id="pagination-pages" class="flex items-center gap-1"></div>
        <button id="pagination-next" type="button" aria-label="Halaman selanjutnya"
                class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 transition hover:bg-slate-50">Selanjutnya</button>
    </div>
</div>
