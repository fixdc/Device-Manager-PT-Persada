<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Ticket;
use App\Models\TicketImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:Pending,Diproses,Selesai'],
        ]);
        $userId = Auth::id();
        $statusCounts = Ticket::query()
            ->where('id_user', $userId)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusFilter = match ($filters['status'] ?? null) {
            'Pending' => ['open'],
            'Diproses' => ['confirmed', 'process'],
            'Selesai' => ['completed'],
            default => null,
        };
        $search = trim($filters['search'] ?? '');

        $ticketQuery = Ticket::query()
            ->with(['device', 'technician', 'images', 'repairHistory'])
            ->where('id_user', $userId);

        if ($statusFilter !== null) {
            $ticketQuery->whereIn('status', $statusFilter);
        }

        if ($search !== '') {
            $searchTerm = '%'.$search.'%';
            $ticketQuery->where(function (Builder $query) use ($searchTerm): void {
                $query->where('kode_ticket', 'like', $searchTerm)
                    ->orWhere('judul', 'like', $searchTerm)
                    ->orWhereHas('device', function (Builder $deviceQuery) use ($searchTerm): void {
                        $deviceQuery->where('nama_device', 'like', $searchTerm)
                            ->orWhere('kode_device', 'like', $searchTerm);
                    });
            });
        }

        $tickets = $ticketQuery
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(8)
            ->withQueryString();

        return view('users.ticket', [
            'tickets' => $tickets,
            'search' => $search,
            'selectedStatus' => $filters['status'] ?? 'Semua',
            'statusCounts' => [
                'Semua' => (int) $statusCounts->sum(),
                'Pending' => (int) $statusCounts->get('open', 0),
                'Diproses' => (int) $statusCounts->get('confirmed', 0) + (int) $statusCounts->get('process', 0),
                'Selesai' => (int) $statusCounts->get('completed', 0),
            ],
            'userName' => Auth::user()->nama,
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
            ->where('id_user', Auth::id())
            ->findOrFail($ticket);
        $photoUrls = $ticket->images->map(
            fn (TicketImage $image): string => Storage::disk('public')->url($image->path)
        );

        return view('users.ticket-detail', [
            'ticket' => $ticket,
            'photoUrls' => $photoUrls,
        ]);
    }

    public function create(): View
    {
        $devices = Device::query()
            ->where('id_user', Auth::id())
            ->orderBy('nama_device')
            ->get(['id', 'kode_device', 'nama_device']);

        return view('users.create-ticket', [
            'devices' => $devices,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'device_id' => [
                'required',
                'integer',
                Rule::exists('devices', 'id')->where('id_user', Auth::id()),
            ],
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10', 'max:1000'],
            'urgency' => ['required', 'in:Rendah,Sedang,Mendesak'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $photo = $request->file('photo');
        $imageFilename = $photo === null
            ? null
            : Str::uuid()->toString().'.'.$photo->extension();
        $imagePath = $imageFilename === null
            ? null
            : 'ticket-images/'.$imageFilename;

        try {
            $ticket = DB::transaction(function () use ($validated, $photo, $imageFilename, $imagePath): Ticket {
                $ticket = Ticket::query()->create([
                    'kode_ticket' => 'TKT-'.Str::upper((string) Str::ulid()),
                    'id_device' => $validated['device_id'],
                    'id_user' => Auth::id(),
                    'judul' => $validated['title'],
                    'deskripsi' => $validated['description'],
                    'prioritas' => [
                        'Rendah' => 'rendah',
                        'Sedang' => 'sedang',
                        'Mendesak' => 'tinggi',
                    ][$validated['urgency']],
                    'tanggal' => now(),
                ]);

                if ($photo !== null && $imageFilename !== null && $imagePath !== null) {
                    $storedPath = Storage::disk('public')->putFileAs(
                        'ticket-images',
                        $photo,
                        $imageFilename,
                    );

                    if (! is_string($storedPath)) {
                        throw new RuntimeException('Foto tiket gagal disimpan.');
                    }

                    $ticket->images()->create([
                        'path' => $storedPath,
                    ]);
                }

                return $ticket;
            });
        } catch (Throwable $exception) {
            if ($imagePath !== null) {
                try {
                    if (! Storage::disk('public')->delete($imagePath)) {
                        throw new RuntimeException('Foto tiket gagal dibersihkan setelah penyimpanan gagal.');
                    }
                } catch (Throwable $cleanupException) {
                    report($cleanupException);
                }
            }

            throw $exception;
        }

        $message = 'Tiket berhasil dibuat.';
        $redirect = route('tickets.mine');

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'ticket' => [
                    'id' => $ticket->getKey(),
                    'kode_ticket' => $ticket->kode_ticket,
                ],
                'redirect' => $redirect,
            ], 201);
        }

        return redirect()->to($redirect)->with('success', $message);
    }
}
