<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairHistory extends Model
{
    protected $table = 'repair_histories';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_selesai' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}