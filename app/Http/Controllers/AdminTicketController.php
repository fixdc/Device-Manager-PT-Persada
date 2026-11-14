<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminTicketController extends Controller
{
    private const STATUSES = ['open', 'confirmed', 'canceled', 'process', 'completed', 'failed'];

    private const STATUS_LABELS = [
        'open' => 'Baru / Menunggu',
        'confirmed' => 'Dikonfirmasi',
        'canceled' => 'Dibatalkan',
        'process' => 'Dalam Pengerjaan',
        'completed' => 'Normal/Berhasil',
        'failed' => 'Rusak',
    ];

    private const ALLOWED_TRANSITIONS = [
        'open' => ['open', 'confirmed', 'canceled'],
        'confirmed' => ['confirmed', 'process', 'canceled'],
        'process' => ['process', 'completed', 'failed', 'canceled'],
        'completed' => ['completed', 'failed', 'process'],
        'failed' => ['failed', 'completed', 'process'],
        'canceled' => ['canceled'],
    ];

    private const FINAL_STATUSES = ['completed', 'failed'];

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'priority' => ['nullable', Rule::in(['rendah', 'sedang', 'tinggi'])],
            'sort' => ['nullable', Rule::in(['newest', 'oldest'])],
        ]);

        $tickets = Ticket::query()
            ->with(['device', 'reporter', 'technician'])
            ->when($validated['search'] ?? null, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('kode_ticket', 'like', "%{$search}%")
                        ->orWhere('judul', 'like', "%{$search}%")
                        ->orWhereHas('device', function (Builder $deviceQuery) use ($search): void {
                            $deviceQuery->where('nama_device', 'like', "%{$search}%")
                                ->orWhere('kode_device', 'like', "%{$search}%");
                        })
                        ->orWhereHas('reporter', fn (Builder $reporterQuery) => $reporterQuery->where('nama', 'like', "%{$search}%"));
                });
            })
            ->when($validated['date_from'] ?? null, fn (Builder $query, string $date) => $query->whereDate('tanggal', '>=', $date))
            ->when($validated['date_to'] ?? null, fn (Builder $query, string $date) => $query->whereDate('tanggal', '<=', $date))
            ->when($validated['priority'] ?? null, fn (Builder $query, string $priority) => $query->where('prioritas', $priority))
            ->orderBy('tanggal', ($validated['sort'] ?? 'newest') === 'oldest' ? 'asc' : 'desc')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $statusCounts = Ticket::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admins.ticket', [
            'tickets' => $tickets,
            'filters' => [
                'search' => $validated['search'] ?? '',
                'date_from' => $validated['date_from'] ?? '',
                'date_to' => $validated['date_to'] ?? '',
                'priority' => $validated['priority'] ?? '',
                'sort' => $validated['sort'] ?? 'newest',
            ],
            'stats' => [
                'total' => $statusCounts->sum(),
                'new' => $statusCounts->get('open', 0),
                'in_process' => $statusCounts->get('process', 0),
                'waiting' => $statusCounts->get('confirmed', 0),
                'completed' => $statusCounts->get('completed', 0),
            ],
        ]);
    }

    public function show(int $ticket): View
    {
        $ticket = Ticket::query()
            ->with([
                'device.category',
                'device.department',
                'reporter.department',
                'technician',
                'images',
                'repairHistory',
            ])
            ->findOrFail($ticket);

        return view('admins.detail-ticket', [
            'ticket' => $ticket,
            'availableStatuses' => collect(self::ALLOWED_TRANSITIONS[$ticket->status] ?? [$ticket->status])
                ->mapWithKeys(fn (string $status): array => [$status => self::STATUS_LABELS[$status]])
                ->all(),
            'photos' => $ticket->images->map(fn (TicketImage $image): array => [
                'url' => Storage::disk('public')->url($image->path),
                'path' => $image->path,
            ]),
        ]);
    }

    public function update(Request $request, int $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(self::STATUSES)],
            'catatan' => ['nullable', 'required_if:status,completed,failed', 'string', 'max:1000'],
        ], [
            'catatan.required_if' => 'Catatan penanganan wajib diisi untuk hasil akhir Normal/Berhasil atau Rusak.',
        ]);

        DB::transaction(function () use ($ticket, $validated): void {
            $ticket = Ticket::query()->lockForUpdate()->findOrFail($ticket);
            $newStatus = $validated['status'];

            if (! in_array($newStatus, self::ALLOWED_TRANSITIONS[$ticket->status] ?? [], true)) {
                throw ValidationException::withMessages([
                    'status' => 'Transisi status tiket tidak diperbolehkan. Periksa kembali tahapan penanganannya.',
                ]);
            }

            $isFinalStatus = in_array($newStatus, self::FINAL_STATUSES, true);
            $wasFinalStatus = in_array($ticket->status, self::FINAL_STATUSES, true);
            $notes = $validated['catatan'] ?? null;

            if ($wasFinalStatus && ! $isFinalStatus) {
                $notes = null;
            }

            $attributes = [
                'status' => $newStatus,
                'catatan' => $notes,
            ];

            if ($ticket->status === 'open' && $newStatus === 'confirmed') {
                $attributes['id_teknisi'] = Auth::id();
            }

            $ticket->update($attributes);

            if ($isFinalStatus) {
                $ticket->repairHistory()->updateOrCreate(
                    ['id_ticket' => $ticket->getKey()],
                    [
                        'tindakan' => $notes,
                        'tanggal_selesai' => now(),
                    ],
                );

                return;
            }

            $ticket->repairHistory()->delete();
        });

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with('success', 'Status dan catatan penanganan tiket berhasil diperbarui.');
    }

    public function history(): View
    {
        $records = Ticket::query()
            ->whereIn('status', self::FINAL_STATUSES)
            ->with([
                'device.category',
                'device.department',
                'reporter.department',
                'technician',
                'repairHistory',
            ])
            ->latest('updated_at')
            ->get()
            ->map(function (Ticket $ticket): array {
                $history = $ticket->repairHistory;
                $device = $ticket->device;
                $date = $history?->tanggal_selesai ?? $ticket->updated_at ?? $ticket->tanggal;

                return [
                    'id' => $ticket->kode_ticket,
                    'ticketId' => $ticket->getKey(),
                    'date' => $date?->toIso8601String(),
                    'finishedAt' => $date?->toIso8601String(),
                    'device' => $device?->nama_device ?? '-',
                    'deviceCode' => $device?->kode_device ?? '-',
                    'location' => $device?->department?->nama ?? '-',
                    'subject' => $ticket->judul,
                    'status' => self::STATUS_LABELS[$ticket->status],
                    'priority' => $ticket->prioritas,
                    'reporter' => $ticket->reporter?->nama ?? '-',
                    'division' => $ticket->reporter?->department?->nama ?? '-',
                    'technician' => $ticket->technician?->nama,
                    'complaint' => $ticket->deskripsi ?? '',
                    'handling' => $history?->tindakan ?? $ticket->catatan ?? '',
                ];
            })
            ->values();

        return view('admins.history', [
            'records' => $records,
            'adminName' => auth()->user()->nama,
        ]);
    }
}
