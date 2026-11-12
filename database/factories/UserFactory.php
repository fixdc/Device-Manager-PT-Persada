<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'user',
            'no_telp' => fake()->phoneNumber(),
            'kata_sandi' => static::$password ??= Hash::make('password'),
            'id_departemen' => null,
            'remember_token' => Str::random(10),
        ];
    }
}
