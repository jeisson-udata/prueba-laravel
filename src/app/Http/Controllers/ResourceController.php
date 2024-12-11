<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceType;
use App\Services\ReservationService;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ResourceController extends Controller
{

    public function __construct(
        protected ResourceService $resourceService,
        protected ReservationService $reservationService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/resource",
     *     summary="Get list of resources",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->resourceService->all();
    }

    /**
     * @OA\Post(
     *     path="/api/resource",
     *     summary="Create a new resource",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Resource")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource created"
     *     )
     * )
     */
    public function store(Request $request): Resource
    {
       return $this->resourceService->create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/resource/{resource}",
     *     summary="Get a resource by ID",
     *     @OA\Parameter(
     *         name="resource",
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
    public function show(Resource $resource): Resource
    {
        return $this->resourceService->find($resource->id);
    }

    /**
     * @OA\Put(
     *     path="/api/resource/{resource}",
     *     summary="Update a resource",
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Resource")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resource updated"
     *     )
     * )
     */
    public function update(Request $request, Resource $resource): Resource
    {
        return $this->resourceService->update($request->all(), $resource->id);
    }

    /**
     * @OA\Delete(
     *     path="/api/resource/{resource}",
     *     summary="Delete a resource",
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Resource deleted"
     *     )
     * )
     */
    public function destroy(Resource $resource): \Illuminate\Http\JsonResponse
    {
        $resource->delete();
        return response()->json([], 204);
    }

   /**
     * @OA\Get(
     *     path="/api/resource-type/{resourceType}/resource",
     *     summary="Get resources by resource type",
     *     @OA\Parameter(
     *     name="resourceType",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function allByResourceType(ResourceType $resourceType): \Illuminate\Database\Eloquent\Collection
    {
        return $this->resourceService->allByResourceType($resourceType->id);
    }

    /**
     * @OA\Get(
     *     path="/api/resource/{resource}/availability",
     *     summary="Get available resources",
     *     @OA\Parameter(
     *         name="resource",
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
    public function availability(Resource $resource): \Illuminate\Database\Eloquent\Collection
    {
        return $this->resourceService->allAvailable();
    }
    /**
     * @OA\Post(
     *     path="/api/resource/{resource}/reservation",
     *     summary="Get reservations by resource",
     *     @OA\Parameter(
     *         name="resource",
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
    public function reservations(Resource $resource): \Illuminate\Database\Eloquent\Collection
    {
        return $this->reservationService->allByResource($resource->id);
    }

    /**
     * @OA\Get(
     *     path="/api/resource/{resource}/availability/start/{start_at}/minutes/{minutes}",
     *     summary="Get available resources from a period",
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="start_at",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="minutes",
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
    public function availabilityFromPeriod(Resource $resource, $start_at, $minutes): \Illuminate\Database\Eloquent\Collection
    {
        return $this->resourceService->availabilityFromPeriod($resource->id, $start_at, $minutes);
    }



}