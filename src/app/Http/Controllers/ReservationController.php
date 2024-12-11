<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Services\ReservationService;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReservationController extends Controller
{

    public function __construct(
        protected ReservationService $reservationService,
        protected ResourceService $resourceService
    ) {
    }
    /**
     * @OA\Get(
     *     path="/api/reservation",
     *     summary="Get list of reservations",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->reservationService->all();
    }

    /**
     * @OA\Post(
     *     path="/api/reservation",
     *     summary="Create a new reservation",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reservation created"
     *     )
     * )
     */
    public function store(Request $request): Reservation
    {
        $data=$request->validate([
            'resource_id' => 'required|integer',
            'user_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);


        return $this->reservationService->create($data);
    }

    /**
     * @OA\Get(
     *     path="/api/reservation/{reservation}",
     *     summary="Get a reservation by ID",
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function show($id): Reservation
    {
        return $this->reservationService->find($id);
    }


    /**
     * @OA\Put(
     *     path="/api/reservation/{reservation}",
     *     summary="Update a reservation",
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Reservation")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function update(Request $request, $id): Reservation{
        $data=$request->validate([
            'resource_id' => 'required|integer',
            'user_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        return $this->reservationService->update($id, $data);
    }

    /**
     * @OA\Delete(
     *     path="/api/reservation/{reservation}",
     *     summary="Cancel a reservation",
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Successful operation"
     *     )
     * )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        return  $this->reservationService->cancel($id);
    }

    /**
     * @OA\Put(
     *     path="/api/reservation/{reservation}/start",
     *     summary="Start a reservation",
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_checker_id"},
     *             @OA\Property(property="user_checker_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function start(Request $request,$id): Reservation
    {
        $data=$request->validate([
            'user_checker_id' => 'required|integer',
        ]);
        return $this->reservationService->started($id, $data['user_checker_id']);
    }

    /**
     * @OA\Put(
     *     path="/api/reservation/{reservation}/complete",
     *     summary="Complete a reservation",
     *     @OA\Parameter(
     *         name="reservation",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_checker_id","observations","all_correct"},
     *             @OA\Property(property="user_checker_id", type="integer"),
     *             @OA\Property(property="observations", type="string"),
     *             @OA\Property(property="all_correct", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function complete(Request $request,$id): Reservation
    {
        $data=$request->validate([
            'user_checker_id' => 'required|integer',
            'observations' => 'required|string',
            'all_correct' => 'required|boolean',
        ]);
        return $this->reservationService->completed($id,$data['observations'],$data['all_correct'], $data['user_checker_id']);
    }





}
