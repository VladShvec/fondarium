<?php

namespace App\Http\Services\User;

use App\Http\Repositories\User\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->userRepository->index();
    }

    /**
     *
     * @param $validatedData
     *
     * @return mixed
     * @throws Exception
     */
    public function create($validatedData): mixed
    {
        $validatedData["password"] = Hash::make($validatedData["password"]);

        try {
            return $this->userRepository->create($validatedData);
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not create new user, get error", 400);
        }
    }

    /**
     * @param $updateData
     * @return JsonResponse
     * @throws Exception
     */
    public function update($updateData): JsonResponse
    {
        try {
            if($updateData["password"]) {
                $updateData["password"] = Hash::make($updateData["password"]);
            }

            $this->userRepository->update($updateData);
            return response()->json("Updated successful");
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not create new user, get error", 400);
        }
    }

    /**
     * @param $id
     * @return JsonResponse|void
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            if ((int)$id === Auth::id()) {
                $this->userRepository->delete((int)$id);
                return response()->json("User deleted successful!");
            } else {
                throw new Exception;
            }
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not delete user, get error", 400);
        }
    }
}
