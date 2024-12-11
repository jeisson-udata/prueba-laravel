<?php

namespace App\Services;

use App\Repositories\ReservationLogRepositoryInterface;
use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\ResourceRepositoryInterface;

class ReservationService
{
    protected ReservationRepositoryInterface $reservationRepository;
    protected ReservationLogRepositoryInterface $reservationLogRepository;
    protected  ResourceRepositoryInterface $resourceRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository, ReservationLogRepositoryInterface $reservationLogRepository,ResourceRepositoryInterface $resourceRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->reservationLogRepository = $reservationLogRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function all()
    {
        return $this->reservationRepository->all();
    }

    public function create(array $data)
    {
        // check if resource is available
        $exists=$this->reservationRepository->existsFromResourceAtPeriod($data['resource_id'], $data['start_at'], $data['end_at']);

        // if exists throw exception
        if($exists){
            throw new \Exception('Resource is not available in that period');
        }

        // create reservation
        $reservation= $this->reservationRepository->create($data);

        // log
        $this->reservationLogRepository->create([
            'reservation_id' => $reservation->id,
            'user_checker_id' => $data['user_id'],
            'status' => $reservation->status,
            'observations' => 'Reservation created'
        ]);

        return $reservation;
    }

    public function update(array $data, $id)
    {
        // update reservation
        $reservation= $this->reservationRepository->update($data, $id);

        // log
        $this->reservationLogRepository->create([
            'reservation_id' => $reservation->id,
            'user_checker_id' => $data['user_id'],
            'status' => $reservation->status,
            'observations' => 'Reservation updated'
        ]);

        return $reservation;
    }

    public function delete($id)
    {
        return $this->reservationRepository->delete($id);
    }

    public function find($id)
    {
        return $this->reservationRepository->find($id);
    }

    public function allByResource($resource_id)
    {
        return $this->reservationRepository->allByResource($resource_id);
    }

    public function cancel($id)
    {
        // cancel reservation
        $reservation = $this->reservationRepository->cancel($id);

        // log
        $this->reservationLogRepository->create([
            'reservation_id' => $reservation->id,
            'user_checker_id' => $reservation->user_id,
            'status' => $reservation->status,
            'observations' => 'Reservation cancelled'
        ]);

        return $reservation;
    }

    public function started($id, $checker_id)
    {
        // approve reservation
        $reservation = $this->reservationRepository->started($id, $checker_id);

        // log
        $this->reservationLogRepository->create([
            'reservation_id' => $reservation->id,
            'user_checker_id' => $checker_id,
            'status' => $reservation->status,
            'observations' => 'Reservation started'
        ]);

        // set resource as unavailable
        $this->resourceRepository->setAvailable(false, $reservation->resource_id);

        return $reservation;
    }

    public function completed($id, $observations, $all_correct, $checker_id)
    {
        // complete reservation
        $reservation = $this->reservationRepository->completed($id,$observations, $all_correct, $checker_id);

        // log
        $this->reservationLogRepository->create([
            'reservation_id' => $reservation->id,
            'user_checker_id' => $checker_id,
            'status' => $reservation->status,
            'observations' => 'Reservation completed'
        ]);

        // set resource as available
        $this->resourceRepository->setAvailable(true, $reservation->resource_id);

        return $reservation;
    }

}
