<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketImage extends Model
{
    use HasFactory;

    protected $table = 'ticket_images';
    protected $guarded = ['id'];

    /**
     * Relasi balik ke tiket.
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'id_ticket');
    }
}