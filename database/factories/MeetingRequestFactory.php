<?php

namespace Database\Factories;

use App\Models\MeetingRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MeetingRequest>
 */
class MeetingRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id'  => null,
            'judul'      => fake()->sentence(3),
            'deskripsi'  => fake()->paragraph(),
            'start_time' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'durasi'     => fake()->randomElement([15, 30, 40]),
            'status'     => 'pending',
        ];
    }
}