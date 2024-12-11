<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'resource_type_id'=>fake()->numberBetween(1, 5),
            'code' => fake()->unique()->bothify('???-#####'),
            'name' => fake()->name(),
            'detail' => fake()->sentence(),
            'is_available' => fake()->boolean(),
            'availability_schedule' => json_encode([
                'monday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'tuesday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'wednesday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'thursday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'friday' => [
                    'start' => '08:00',
                    'end' => '17:00',
                ],
                'saturday' => [
                    'start' => '09:00',
                    'end' => '12:00',
                ]
            ]),
            'recommendations' => fake()->sentence(),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
