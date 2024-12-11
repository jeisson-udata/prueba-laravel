<?php

namespace App\Repositories;

interface ReservationLogRepositoryInterface
{
    public function all();
    public function allByReservation($reservation_id);

    public function create(array $data);

    public function delete($id);
}
