<?php
namespace App\Repositories;

interface ReservationRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function cancel($id);

    public function started($id, $checker_id);

    public function completed($id, $observations, $all_correct, $checker_id);

    public function find($id);
    public function allByResource($resource_id);

    public function existsFromResourceAtPeriod($resource_id, $start_at, $end_at);
}
