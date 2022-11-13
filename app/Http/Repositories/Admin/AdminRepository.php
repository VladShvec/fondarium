<?php

namespace App\Http\Repositories\Admin;

use App\Models\Auto;
use App\Models\User;
use Exception;

class AdminRepository {

    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::with('auto')->get();
    }

    /**
     * @param $validationData
     * @return void
     */
    public function createUser($validationData)
    {
        try {
           return User::create($validationData);
        } catch (\Throwable $ex) {

            throw new Exception($ex->getMessage() . " Could not create new user, get error");
        }
    }

    /**
     * @param $validationData
     * @return void
     */
    public function createAuto($validationData)
    {
        try {
            return Auto::create($validationData);
        } catch (\Throwable $ex) {

            throw new Exception($ex->getMessage() . " Could not create new car, get error");
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $user = User::find($id);
            $user->delete();

        } catch (\Throwable $ex) {

            throw new Exception($ex->getMessage() . " Could not delete user, get error");
        }

        return response()->json($user->toArray()['name'] . " was deleted");
    }

    /**
     * @param $updateData
     * @return void
     */
    public function updateUser($updateData)
    {
        try {
            User::where('id', $updateData["id"])
                ->update($updateData);
        } catch (\Throwable $ex) {

            throw new Exception($ex->getMessage() . " Could not update user, get error");
        }

    }

    /**
     * @param $updateData
     * @return void
     */
    public function updateAuto($updateData)
    {
        try {
            Auto::where('id', $updateData["id"])
                ->update($updateData);
        } catch (\Throwable $ex) {

            throw new Exception($ex->getMessage() . " Could not update car, get error");
        }
    }
}
