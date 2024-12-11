<?php

namespace App\Services;

use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\ResourceRepositoryInterface;

class ResourceService
{
    protected ResourceRepositoryInterface $resourceRepository;
    protected ReservationRepositoryInterface $reservationRepository;

    public function __construct(ResourceRepositoryInterface $resourceRepository,ReservationRepositoryInterface $reservationRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function all()
    {
        return $this->resourceRepository->all();
    }

    public function create(array $data)
    {
        return $this->resourceRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->resourceRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->resourceRepository->delete($id);
    }

    public function find($id)
    {
        return $this->resourceRepository->find($id);
    }

    public function allByResourceType($resource_type)
    {
        return $this->resourceRepository->allByResourceType($resource_type);
    }

    public function allAvailable()
    {
        return $this->resourceRepository->allAvailable();
    }

    public  function availabilityFromPeriod($resource_id,$start_at,$minutes)
    {
        // calculate end_at
        $end_at = date('Y-m-d H:i:s', strtotime($start_at) + $minutes*60);

        // check if there is any reservation in that period
        return $this->reservationRepository->existsFromResourceAtPeriod($resource_id,$start_at,$end_at);

    }

}
