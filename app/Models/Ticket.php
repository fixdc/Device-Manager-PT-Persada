<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $guarded = ['id'];
    
    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'id_device');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_teknisi');
    }

    public function repairHistory(): HasOne
    {
        return $this->hasOne(RepairHistory::class, 'id_ticket');
    }

    public function images(): HasMany
    {
        return $this->hasMany(TicketImage::class, 'id_ticket');
    }
}