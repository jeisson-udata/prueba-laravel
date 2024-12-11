<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function all()
    {
        return Reservation::where('active',true)->get();
    }

    public function create(array $data)
    {

        $reservation = new Reservation();
        $reservation->resource_id = $data['resource_id'];
        $reservation->user_id = $data['user_id'];
        $reservation->start_at = $data['start_at'];
        $reservation->end_at = $data['end_at'];
        $reservation->status = 'PENDING';

        $reservation->save();


        return $reservation;
    }

    public function update(array $data, $id)
    {
        $reservation = Reservation::find($id);
        $reservation->resource_id = $data['resource_id'];
        $reservation->user_id = $data['user_id'];
        $reservation->start_at = $data['start_at'];
        $reservation->end_at = $data['end_at'];

        $reservation->save();


        return $reservation;

    }

    public function delete($id)
    {
        return Reservation::find($id)->delete();
    }

    public function find($id)
    {
        return Reservation::find($id);
    }

    public function allByResource($resource_id)
    {
        return Reservation::where('active',true)->where('resource_id', $resource_id)->where('status','!=','CANCELLED')->get();
    }

    public function cancel($id)
    {
        $reservation = Reservation::find($id);
        $reservation->status = 'CANCELLED';
        $reservation->save();

        return $reservation;
    }

    public function started($id, $checker_id)
    {
        $reservation = Reservation::find($id);
        $reservation->status = 'STARTED';
        $reservation->user_checker_id = $checker_id;
        $reservation->save();

        return $reservation;
    }

    public function completed($id, $observations, $all_correct, $checker_id)
    {
        $reservation = Reservation::find($id);
        $reservation->status = 'FINISHED';
        $reservation->observations = $observations;
        $reservation->all_correct = $all_correct;
        $reservation->user_checker_id = $checker_id;
        $reservation->save();

        return $reservation;
    }

    public function existsFromResourceAtPeriod($resource_id, $start_at, $end_at)
    {
        return Reservation::where('active',true)
            ->where('status','!=','CANCELLED')
            ->where('status','!=','FINISHED')
            ->where('resource_id', $resource_id)
            ->where('start_at', '<=', $end_at)
            ->where('end_at', '>=', $start_at)
            ->exists();
    }
}
