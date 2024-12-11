<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceTypeEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all resource IDs with type IDs 3 to 5
        $resourceIds = \App\Models\Resource::whereBetween('resource_type_id', [3, 5])->pluck('id')->toArray();

        // Insert equipment for each resource
        foreach ($resourceIds as $resourceId) {
            $equipment = new \App\Models\ResourceTypeEquipment();
            $equipment->warehouse_location = 'BODEGA';
            $equipment->resource_id = $resourceId;
            $equipment->save();
        }

    }
}
