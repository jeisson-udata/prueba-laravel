<?php
namespace App\Repositories;

interface ResourceRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);
    public function find($id);
    public function setAvailable($available, $id);

    public function allByResourceType($resource_type);

    public function allAvailable();

}
