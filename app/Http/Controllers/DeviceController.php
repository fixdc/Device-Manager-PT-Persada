<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DeviceController extends Controller
{
    public function index(Request $request): View
    {
        $devices = Device::query()
            ->with([
                'category:id,nama,slug',
                'user:id,nama,id_departemen,no_telp',
                'user.department:id,nama',
                'department:id,nama,lantai',
                'tickets' => function ($query) {
                    $query->latest();
                }
            ])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Device $device): array => $this->deviceData($device));

        return view('admins.device', [
            'devices' => $devices,
            'categories' => DeviceCategory::query()->orderBy('nama')->get(['id', 'nama', 'slug']),
            'departments' => Department::query()->orderBy('nama')->get(['id', 'nama', 'lantai']),
            'users' => User::query()->orderBy('nama')->get(['id', 'nama']),
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'kode_device' => ['required', 'string', 'max:255', Rule::unique('devices')],
            'nama_device' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', Rule::exists('device_categories', 'id')],
            'merek' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'nomor_seri' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['aktif', 'perbaikan', 'rusak'])],
            'id_departemen' => ['required', Rule::exists('departments', 'id')],
            'id_user' => ['nullable', Rule::exists('users', 'id')],
            'tanggal_pengadaan' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $device = Device::create(Arr::only($validated, [
            'kode_device',
            'nama_device',
            'id_kategori',
            'merek',
            'model',
            'nomor_seri',
            'status',
            'id_departemen',
            'id_user',
            'tanggal_pengadaan',
            'deskripsi',
        ]));

        return $this->respond($request, 'Perangkat berhasil ditambahkan.', $device, 201);
    }

    public function update(Request $request, Device $device): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'kode_device' => ['required', 'string', 'max:255', Rule::unique('devices')->ignore($device)],
            'nama_device' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', Rule::exists('device_categories', 'id')],
            'merek' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'nomor_seri' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['aktif', 'perbaikan', 'rusak'])],
            'id_departemen' => ['required', Rule::exists('departments', 'id')],
            'id_user' => ['nullable', Rule::exists('users', 'id')],
            'tanggal_pengadaan' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $deviceId = DB::transaction(function () use ($device, $validated): int {
            $device = Device::query()->lockForUpdate()->findOrFail($device->getKey());

            $device->fill(Arr::only($validated, [
                'kode_device',
                'nama_device',
                'id_kategori',
                'merek',
                'model',
                'nomor_seri',
                'status',
                'id_departemen',
                'id_user',
                'tanggal_pengadaan',
                'deskripsi',
            ]));

            if (! $device->save()) {
                throw new \RuntimeException('Perubahan perangkat gagal disimpan.');
            }

            return (int) $device->getKey();
        });

        // Build the response from a fresh read after the transaction commits.
        $device = Device::query()
            ->with([
                'category:id,nama,slug',
                'user:id,nama,id_departemen,no_telp',
                'user.department:id,nama',
                'department:id,nama,lantai',
            ])
            ->findOrFail($deviceId);

        foreach (['merek', 'model', 'tanggal_pengadaan'] as $field) {
            if ($request->exists($field) && ! array_key_exists($field, $validated)) {
                throw new \RuntimeException("Field {$field} tidak lolos ke data tervalidasi.");
            }

            if (! array_key_exists($field, $validated)) {
                continue;
            }

            $expected = $validated[$field];
            $actual = $device->getAttribute($field);

            if ($field === 'tanggal_pengadaan') {
                $expected = $expected ? \Carbon\Carbon::parse($expected)->format('Y-m-d') : null;
                $actual = $actual?->format('Y-m-d');
            }

            if ($actual !== $expected) {
                throw new \RuntimeException("Field {$field} tidak sama dengan nilai yang tersimpan.");
            }
        }

        return $this->respond($request, 'Perubahan perangkat berhasil disimpan.', $device);
    }

    public function destroy(Request $request, Device $device): JsonResponse|RedirectResponse
    {
        DB::transaction(function () use ($device): void {
            $device = Device::query()->lockForUpdate()->findOrFail($device->getKey());
            $device->delete(); 
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Perangkat berhasil dihapus.',
                'device' => ['id' => $device->getKey()],
            ]);
        }

        return back()->with('success', 'Perangkat berhasil dihapus.');
    }

    public function showPublic(string $kode_device)
    {
        $device = Device::with(['category', 'user.department', 'department', 'tickets.technician'])
            ->where('kode_device', $kode_device)
            ->firstOrFail();

        $deviceData = $this->deviceData($device);

        return view('device-details', compact('deviceData'));
    }

    private function deviceData(Device $device): array
    {
        return [
            'id' => $device->getKey(),
            'kode' => $device->kode_device,
            'nama' => $device->nama_device,
            'jenis' => $device->category?->nama ?? 'Lainnya',
            'kategori' => $device->id_kategori,
            'merek' => $device->merek ?? 'Belum diisi',
            'model' => $device->model ?? 'Belum diisi',
            'sn' => $device->nomor_seri ?? 'Belum diisi',
            'status' => $device->status,
            'tanggal' => $device->tanggal_pengadaan ? \Carbon\Carbon::parse($device->tanggal_pengadaan)->translatedFormat('d F Y') : 'Belum diisi',
            'tanggal_raw' => $device->tanggal_pengadaan?->format('Y-m-d') ?? '',
            'ruang' => $device->department?->nama ?? '-',
            'lantai' => $device->department?->lantai ?? '-',
            'lokasi' => $device->department ? $device->department->nama.' — '.$device->department->lantai : '-',
            'ruang_id' => $device->id_departemen,
            'pj' => $device->user?->nama ?? 'Belum diisi',
            'departemen_pj' => $device->user?->department?->nama ?? 'Belum diisi',
            'spesifikasi' => $device->deskripsi ?? '',
            'qr_url' => url('/device/' . $device->kode_device),
            'operator' => [
                'id' => $device->user?->id ?? '',
                'nama' => $device->user?->nama ?? '-',
                'divisi' => $device->user?->department?->nama ?? '-',
                'telepon' => $device->user?->no_telp ?? '-',
            ],
            'tickets' => $device->relationLoaded('tickets') ? $device->tickets->map(fn($t) => [
                'kode' => $t->kode_ticket,
                'tanggal' => $t->tanggal?->translatedFormat('d M Y, H:i'),
                'subjek' => $t->judul,
                'urgensi' => ucfirst($t->prioritas),
                'status' => ucfirst($t->status)
            ]) : [],
            'damages' => $device->relationLoaded('tickets') ? $device->tickets->where('status', '!=', 'open')->map(fn($t) => [
                'tanggal' => $t->tanggal?->translatedFormat('d M Y'),
                'judul' => $t->judul,
                'penyebab' => $t->deskripsi,
                'penanganan' => $t->catatan ?? '-',
                'teknisi' => $t->technician?->nama ?? '-',
                'status' => ucfirst($t->status)
            ])->values() : [],
        ];
    }

    private function respond(
        Request $request,
        string $message,
        Device $device,
        int $status = 200,
    ): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'device' => $this->deviceData($device->loadMissing([
                    'category:id,nama,slug', 
                    'user:id,nama,id_departemen,no_telp', 
                    'user.department:id,nama', 
                    'department:id,nama,lantai',
                    'tickets'
                ])),
            ], $status);
        }

        return back()->with('success', $message);
    }
}
