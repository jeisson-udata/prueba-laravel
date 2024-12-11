<?php

namespace Database\Seeders;

use App\Models\ResourceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resource_type=new ResourceType();
        $resource_type->name='AUDITORIO';
        $resource_type->save();

        $resource_type=new ResourceType();
        $resource_type->name='CUBICULO';
        $resource_type->save();

        $resource_type=new ResourceType();
        $resource_type->name='PORTATIL';
        $resource_type->save();

        $resource_type=new ResourceType();
        $resource_type->name='AURICULARES';
        $resource_type->save();

        $resource_type=new ResourceType();
        $resource_type->name='PROYECTOR';
        $resource_type->save();
    }
}
