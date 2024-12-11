<?php

namespace App\Repositories;

use App\Models\ReservationLog;

class ReservationLogRepository implements ReservationLogRepositoryInterface
{
    public function all()
    {
        return ReservationLog::all();
    }

    public function allByReservation($reservation_id)
    {
        return ReservationLog::where('active',true)->where('reservation_id', $reservation_id)->get();
    }

    public function create(array $data)
    {
        $reservationLog = new ReservationLog();
        $reservationLog->reservation_id = $data['reservation_id'];
        $reservationLog->user_checker_id = $data['user_checker_id'];
        $reservationLog->status = $data['status'];
        $reservationLog->observations = $data['observations'];

        $reservationLog->save();

        return $reservationLog;
    }

    public function delete($id)
    {
        return ReservationLog::find($id)->delete();
    }
}
