<?php

namespace App\Repositories;

use App\Models\Resource;
use App\Models\ResourceType;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function all()
    {
        return Resource::where('active',true)->get();
    }

    public function create(array $data)
    {
        $resource = new Resource();
        $resource->resource_type_id = $data->resource_type_id;
        $resource->name = $data->name;
        $resource->code = $data->code;
        $resource->detail = $data->detail;
        $resource->availability_schedule = json_encode($data->availability_schedule);
        $resource->recommendations = $data->recommendations;
        $resource->save();

        return $resource;
    }

    public function update(array $data, $id)
    {

        $resource = Resource::find($id);
        $resource->resource_type_id = $data->resource_type_id;
        $resource->name = $data->name;
        $resource->code = $data->code;
        $resource->detail = $data->detail;
        $resource->availability_schedule = json_encode($data->availability_schedule);
        $resource->recommendations = $data->recommendations;
        $resource->save();

        return $resource;

    }

    public function delete($id)
    {
        return Resource::find($id)->delete();
    }

    public function find($id)
    {
        return Resource::find($id);
    }

    public function setAvailable($available, $id)
    {
        return Resource::find($id)->update(['is_available' => $available]);
    }

    public function allByResourceType($resource_type_id)
    {
        return Resource::where('active',true)->where('resource_type_id', $resource_type_id)->get();
    }

    public function allAvailable()
    {
        return Resource::where('active',true)->where('is_available',true)->get();
    }


}
