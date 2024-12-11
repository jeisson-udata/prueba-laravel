<?php

namespace App\Repositories;

use App\Models\ResourceType;

class ResourceTypeRepository implements ResourceTypeRepositoryInterface
{
    public function all()
    {
        return ResourceType::where('active',true)->get();
    }

    public function create(array $data)
    {
        return ResourceType::create($data);
    }

    public function update(array $data, $id)
    {
        return ResourceType::find($id)->update($data);
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
