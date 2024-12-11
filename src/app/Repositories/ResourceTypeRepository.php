<?php

namespace App\Repositories;

use App\Models\ResourceType;

class ResourceTypeRepository implements ResourceTypeRepositoryInterface
{
    public function all()
    {
        return ResourceType::where('active',true)->get();
    }

    public function create(array $data): ResourceType
    {
        $resourceType = new ResourceType();
        $resourceType->name = $data['name'];
        $resourceType->save();

        return $resourceType;
    }

    public function update(array $data, $id)
    {
        $resourceType=ResourceType::find($id);
        $resourceType->name = $data['name'];
        $resourceType->save();

        return $resourceType;
    }

    public function delete($id)
    {
        return ResourceType::find($id)->delete();
    }

    public function find($id)
    {
        return ResourceType::find($id);
    }
}
