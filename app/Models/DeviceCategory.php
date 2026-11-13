<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceCategory extends Model
{
    protected $table = 'device_categories';

    protected $guarded = ['id'];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'id_kategori');
    }
}
