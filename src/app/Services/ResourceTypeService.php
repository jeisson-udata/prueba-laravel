<?php

namespace App\Services;

use App\Repositories\ResourceTypeRepositoryInterface;

class ResourceTypeService
{
    protected ResourceTypeRepositoryInterface $resourceTypeRepository;

    public function __construct(ResourceTypeRepositoryInterface $resourceTypeRepository)
    {
        $this->resourceTypeRepository = $resourceTypeRepository;
    }

    public function all()
    {
        return $this->resourceTypeRepository->all();
    }

    public function create(array $data)
    {
        return $this->resourceTypeRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->resourceTypeRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->resourceTypeRepository->delete($id);
    }

    public function find($id)
    {
        return $this->resourceTypeRepository->find($id);
    }

}
