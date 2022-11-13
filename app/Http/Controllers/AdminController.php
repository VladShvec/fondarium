<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAutoRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    protected AdminService $adminService;

    /**
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @return bool|string
     *
     * @OA\Get(
     *     path="/api/admin",
     *     tags={"Admin"},
     *     summary="Get all users with cars",
     *     description="Multiple status values can be provided with comma separated string",
     *     operationId="indexAdmin",
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
    public function index()
    {
        $response = $this->adminService->index();

        return $this->makeJsonResponse($response);
    }

    /**
     * @param UserRequest $request
     * @return void
     * @throws \Exception
     *
     * @OA\Post(
     *     path="/api/admin/create-users",
     *     tags={"Admin"},
     *     summary="Create user",
     *     description="This can only be done by the logged in user.",
     *     operationId="createAdminUser",
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
     *    )
     * )
    */
    public function createUser(UserRequest $request)
    {
        $validationData = $request->validated();

        return $this->adminService->createUser($validationData);
    }

    /**
     * @param AdminAutoRequest $request
     * @return void
     * @throws \Exception
     *
     * @OA\Post(
     *     path="/api/admin/create-autos",
     *     tags={"Admin"},
     *     summary="Create car",
     *     description="This can only be done by the logged in user.",
     *     operationId="createAdminCar",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Create car object",
     *       @OA\JsonContent(
     *       required={"auto_mark","auto_number", "auto_color", "user_id"},
     *       @OA\Property(property="auto_mark", type="string", format="text", example="Volkswagen"),
     *       @OA\Property(property="auto_number", type="string", format="text", example="123456"),
     *       @OA\Property(property="user_id", type="string", format="text", example="4"),
     *       @OA\Property(property="auto_color", type="string", format="text", example="DarkRed"),
     *     ),
     *     )
     * )
    */
    public function createAuto(AdminAutoRequest $request)
    {
        $validationData = $request->validated();

        return $this->adminService->createAuto($validationData);
    }

    /**
     * @param Request $request
     * @return void
     *
     * @OA\Put(
     *     path="/api/admin/update-users",
     *     tags={"Admin"},
     *     summary="Update user",
     *     description="This can only be done by the logged in user.",
     *     operationId="updateAdminUser",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Update user object",
     *       @OA\JsonContent(
     *       @OA\Property(property="email", type="email", format="text", example="testmail@example.org"),
     *       @OA\Property(property="password", type="string", format="text", example="123456"),
     *       @OA\Property(property="role_id", type="string", format="text", example="2"),
     *       @OA\Property(property="name", type="string", format="text", example="Andrey"),
     *    ),
     *    )
     * )
     */
    public function updateUser(Request $request)
    {
        $updateData = $request->toArray();

        $this->adminService->updateUser($updateData);
    }

    /**
     * @param Request $request
     * @return void
     *
     * @OA\Put(
     *     path="/api/admin/update-autos",
     *     tags={"Admin"},
     *     summary="Update car",
     *     description="This can only be done by the logged in user.",
     *     operationId="updateAdminCar",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Update car object",
     *       @OA\JsonContent(
     *       required={"auto_mark","auto_number", "auto_color", "user_id"},
     *       @OA\Property(property="auto_mark", type="string", format="text", example="Volkswagen"),
     *       @OA\Property(property="auto_number", type="string", format="text", example="123456"),
     *       @OA\Property(property="user_id", type="string", format="text", example="4"),
     *       @OA\Property(property="auto_color", type="string", format="text", example="DarkRed"),
     *     ),
     *     )
     * )
     */
    public function updateAuto(Request $request)
    {
        $updateData = $request->toArray();

        $this->adminService->updateAuto($updateData);
    }

    /**
     * @param $id
     * @return void
     * @throws \Exception
     *
     * @OA\Delete(
     *     path="/api/admin/{id}",
     *     tags={"Admin"},
     *     summary="Delete user with car",
     *     description="This can only be done by the logged in user.",
     *     operationId="deleteCar",
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
        return $this->adminService->delete($id);
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
