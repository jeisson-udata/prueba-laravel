<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resource_id' => 1,
            'user_id' => 1,
            'start_at' => $this->faker->dateTimeBetween('now', '+1 hour'),
            'end_at' => $this->faker->dateTimeBetween('+1 hour', '+2 hours'),
            'status' => 'PENDING',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
