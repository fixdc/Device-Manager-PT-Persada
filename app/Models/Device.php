<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';
    protected $guarded = ['id']; // Membolehkan semua kolom diisi kecuali ID

    protected function casts(): array
    {
        return [
            'tanggal_pengadaan' => 'datetime',
        ];
    }

    // Relasi ke tabel device_categories
    public function category()
    {
        return $this->belongsTo(DeviceCategory::class, 'id_kategori');
    }

    // Relasi ke tabel users (Pemilik/Operator perangkat)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke tabel departments (Lokasi perangkat)
    public function department()
    {
        return $this->belongsTo(Department::class, 'id_departemen');
    }

    // Relasi ke tabel tickets (Riwayat kerusakan/tiket)
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_device')->orderBy('created_at', 'desc');
    }
}
