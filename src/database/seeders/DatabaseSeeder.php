<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * 1. Insert Resource Types.
         */
        $this->call([
            ResourceTypeSeeder::class,
        ]);

        /**
         * 2. Insert Resources.
         */
        Resource::factory(20)->create();

        /**
         * 3. Insert Resource class from Types.
         */
        $this->call([
            ResourceTypeEquipmentSeeder::class,
            ResourceTypeSpaceSeeder::class,
        ]);



    }
}
