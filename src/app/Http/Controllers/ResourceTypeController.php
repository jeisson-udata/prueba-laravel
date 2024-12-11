<?php

namespace App\Http\Controllers;

use App\Models\ResourceType;
use App\Services\ResourceTypeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ResourceTypeController extends Controller
{

    public function __construct(
        protected ResourceTypeService $resourceTypeService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/resource-type",
     *     summary="Get list of resource types",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->resourceTypeService->all();
    }

    /**
     * @OA\Post(
     *     path="/api/resource-type",
     *     summary="Create a new resource type",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ResourceType")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Resource type created"
     *     )
     * )
     */
    public function store(Request $request): ResourceType
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        return $this->resourceTypeService->create($data);

    }

    /**
     * @OA\Get(
     *     path="/api/resource-type/{resourceType}",
     *     summary="Get a resource type by ID",
     *     @OA\Parameter(
     *         name="resourceType",
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
    public function show($id): ResourceType
    {
        return $this->resourceTypeService->find($id);
    }

    /**
     * @OA\Put(
     *     path="/api/resource-type/{resourceType}",
     *     summary="Update a resource type",
     *     @OA\Parameter(
     *         name="resourceType",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ResourceType")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resource type updated"
     *     )
     * )
     */
    public function update(Request $request, $id): ResourceType
    {
        $data = $request->validate([
            'name' => 'required',
        ]);

        return $this->resourceTypeService->update($data, $id);
    }

    /**
     * @OA\Delete(
     *     path="/api/resource-type/{resourceType}",
     *     summary="Delete a resource type",
     *     @OA\Parameter(
     *         name="resourceType",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Resource type deleted"
     *     )
     * )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $this->resourceTypeService->delete($id);
        return response()->json([], 204);
    }




}
