<?php

namespace App\Http\Repositories\Auto;

use App\Models\Auto;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class AutoRepository
{
    /**
     * @var Auto
     */
    private Auto $auto;

    public function __construct(Auto $auto)
    {
        $this->auto = $auto;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->auto->all();
    }

    /**
     * @param $validatedData
     * @return mixed
     */
    public function create($validatedData): mixed
    {
        $newAuto = Auto::create($validatedData);

        return $newAuto;
    }

    /**
     * @param $updateData
     * @return void
     */
    public function update($updateData): void
    {
        Auto::where('user_id', $updateData["user_id"])
            ->update($updateData);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function delete($id)
    {
        try {
            $auto = $this->auto->where("id", $id)->where("user_id", Auth::id());

            if ($auto->get()->count()) {
                $auto->delete();
                return response()->json("Car deleted successful!");
            } else {
                throw new Exception;
            }
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . " Could not delete car, get error", 400);
        }


    }
}
