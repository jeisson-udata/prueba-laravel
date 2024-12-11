<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceTypeSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all resource IDs with type IDs 1 to 2
        $resourceIds = \App\Models\Resource::whereBetween('resource_type_id', [1, 2])->pluck('id')->toArray();

        // Insert equipment for each resource
        foreach ($resourceIds as $resourceId) {
            $space = new \App\Models\ResourceTypeSpace();
            $space->capacity_of_people = fake()->numberBetween(1, 100);
            $space->location_type = fake()->randomElement(['VIRTUAL', 'FISICO']);
            $space->location_link = fake()->url();
            $space->location_information = fake()->address();
            $space->resource_id = $resourceId;
            $space->save();
        }
    }
}
