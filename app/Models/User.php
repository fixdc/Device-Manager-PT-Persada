<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'nama',
    'email',
    'role',
    'no_telp',
    'kata_sandi',
    'id_departemen',
])]
#[Hidden(['kata_sandi', 'remember_token'])]
class User extends Authenticatable
{
    public const ROLES = ['admin', 'user'];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $attributes = [
        'role' => 'user',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'id_departemen');
    }

    public function preferences(): HasOne
    {
        return $this->hasOne(UserPreference::class);
    }

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed',
        ];
    }
}
