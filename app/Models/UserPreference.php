<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'ticket_updates', 'ticket_assignments', 'system_announcements'])]
class UserPreference extends Model
{
    use HasFactory;

    protected $attributes = [
        'ticket_updates' => true,
        'ticket_assignments' => true,
        'system_announcements' => true,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'ticket_updates' => 'boolean',
            'ticket_assignments' => 'boolean',
            'system_announcements' => 'boolean',
        ];
    }
}
