<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get all users for REST API",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="index",
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Per page count",
     *         required=false,
     *         explode=true,
     *         @OA\Schema(
     *             default="10",
     *             type="integer",
     *         )
     *     ),
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
        $response = $this->userService->index();

        return $this->makeJsonResponse($response);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create user",
     *     description="This can only be done by the logged in user.",
     *     operationId="create",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Create user object",
     *       @OA\JsonContent(
     *       required={"name","email", "role_id", "password"},
     *       @OA\Property(property="email", type="email", format="text", example="mercedes68@example.org"),
     *       @OA\Property(property="password", type="string", format="text", example="123456"),
     *       @OA\Property(property="role_id", type="string", format="text", example="2"),
     *       @OA\Property(property="name", type="string", format="text", example="Andrey"),
     *    ),
     *     )
     * )
     */
    public function create(UserRequest $request): mixed
    {
        $validatedData = $request->validated();

        return $this->userService->create($validatedData);
    }

    /**
     * @OA\Put(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Update user",
     *     description="This can only be done by the logged in user.",
     *     operationId="update",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Update user object",
     *       @OA\JsonContent(
     *       required={"name","email", "role_id", "password"},
     *       @OA\Property(property="email", type="email", format="text", example="testmail@example.org"),
     *       @OA\Property(property="password", type="string", format="text", example="123456"),
     *       @OA\Property(property="role_id", type="string", format="text", example="2"),
     *       @OA\Property(property="name", type="string", format="text", example="Andrey"),
     *    ),
     *     )
     * )
     */
    public function update(Request $request): JsonResponse
    {
        $updateData = $request->toArray();

        return $this->userService->update($updateData);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Autos"},
     *     summary="Delete user",
     *     description="This can only be done by the logged in user.",
     *     operationId="deleteCar",
     *     @OA\Parameter(
     *         name="Car id",
     *         in="path",
     *         description="Car id to delete",
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
        return $this->userService->delete($id);
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
