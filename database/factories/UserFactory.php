<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Password default untuk semua user factory.
     */
    protected static ?string $password;

    /**
     * Definisi state default untuk model User.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'     => fake()->name(),
            'email'    => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role'     => 'client', // default sebagai client
        ];
    }

    /**
     * State untuk membuat user dengan role admin.
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * State untuk membuat user dengan role client.
     */
    public function client(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => 'client',
        ]);
    }
}
