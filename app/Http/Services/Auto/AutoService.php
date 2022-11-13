<?php

namespace App\Http\Services\Auto;

use App\Http\Repositories\Auto\AutoRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AutoService
{
    /**
     * @var AutoRepository
     */
    private AutoRepository $autoRepository;

    /**
     * @param AutoRepository $autoRepository
     */
    public function __construct(AutoRepository $autoRepository)
    {
        $this->autoRepository = $autoRepository;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->autoRepository->index();
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
        try {
            $validatedData["user_id"] = Auth::id();

            return $this->autoRepository->create($validatedData);
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not create new car, get error", 400);
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
            $updateData["user_id"] = Auth::id();

            $this->autoRepository->update($updateData);
            return response()->json("Updated successful");
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not update new car, get error", 400);
        }
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->autoRepository->delete((int) $id);
    }
}
