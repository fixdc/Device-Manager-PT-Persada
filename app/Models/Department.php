<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'nama',
        'lantai',
        'slug',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_departemen');
    }

    // Tambahan relasi ke tabel devices (Location)
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'id_departemen');
    }
}