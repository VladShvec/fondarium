<?php

namespace App\Http\Repositories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserRepository {
    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->user->all();
    }

    /**
     * @param $validatedData
     * @return mixed
     */
    public function create($validatedData): mixed
    {
        $newUser = User::create($validatedData);

        return $newUser;
    }

    /**
     * @param $updateData
     * @return void
     */
    public function update($updateData): void
    {
        User::where('id', Auth::id())
            ->update($updateData);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
