<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutoRequest;
use App\Http\Services\Auto\AutoService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AutoController extends Controller
{
    /**
     * @var AutoService
     */
    protected AutoService $autoService;

    /**
     * @param AutoService $autoService
     */
    public function __construct(AutoService $autoService)
    {
        $this->autoService = $autoService;
    }

    /**
     * Return autos list in json format
     *
     * @return bool|string
     *
     * @OA\Get(
     *     path="/api/autos",
     *     tags={"Autos"},
     *     summary="Get all cars for REST API",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="indexCar",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
    */
    public function index(): bool|string
    {
        $response = $this->autoService->index();

        return $this->makeJsonResponse($response);
    }

    /**
     * @param AutoRequest $request
     * @return mixed
     * @throws Exception
     *
     * @OA\Post(
     *     path="/api/autos",
     *     tags={"Autos"},
     *     summary="Create car",
     *     description="This can only be done by the logged in user.",
     *     operationId="createCar",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Create car object",
     *       @OA\JsonContent(
     *       required={"auto_mark","auto_number", "auto_color"},
     *       @OA\Property(property="auto_mark", type="string", format="text", example="Volkswagen"),
     *       @OA\Property(property="auto_number", type="string", format="text", example="123456"),
     *       @OA\Property(property="auto_color", type="string", format="text", example="DarkRed"),
     *     ),
     *     )
     * )
     */
    public function create(AutoRequest $request): mixed
    {
        $validatedData = $request->validated();

        return $this->autoService->create($validatedData);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     *
     * @OA\Put(
     *     path="/api/autos",
     *     tags={"Autos"},
     *     summary="Update car",
     *     description="This can only be done by the logged in user.",
     *     operationId="updateCar",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Update car object",
     *       @OA\JsonContent(
     *       required={"auto_mark","auto_number", "auto_color"},
     *       @OA\Property(property="auto_mark", type="string", format="text", example="Volkswagen"),
     *       @OA\Property(property="auto_number", type="string", format="text", example="123456"),
     *       @OA\Property(property="auto_color", type="string", format="text", example="DarkRed"),
     *     ),
     *     )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $updateData = $request->toArray();

        return $this->autoService->update($updateData);
    }

    /**
     * @param $id
     * @return JsonResponse|void
     * @throws Exception
     *
     * @OA\Delete(
     *     path="/api/autos/{id}",
     *     tags={"Users"},
     *     summary="Delete user",
     *     description="This can only be done by the logged in user.",
     *     operationId="delete",
     *     @OA\Parameter(
     *         name="User id",
     *         in="path",
     *         description="User id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     * )
     */
    public function delete($id)
    {
        return $this->autoService->delete($id);
    }

    /**
     * Convert collection data to json
     *
     * @param $response
     * @return bool|string
     */
    private function makeJsonResponse($response): bool|string
    {
        return json_encode($response);
    }
}
