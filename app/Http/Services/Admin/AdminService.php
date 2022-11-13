<?php

namespace App\Http\Services\Admin;

use App\Http\Repositories\Admin\AdminRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    /**
     * @var AdminRepository
     */
    private AdminRepository $adminRepository;

    /**
     * @param AdminRepository $adminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    public function index()
    {
        return $this->adminRepository->index();
    }

    /**
     * @param $validationData
     * @return void
     * @throws Exception
     */
    public function createUser($validationData)
    {
        $validationData["password"] = Hash::make($validationData["password"]);

        return $this->adminRepository->createUser($validationData);
    }

    /**
     * @param $validationData
     * @return void
     * @throws Exception
     */
    public function createAuto($validationData)
    {
        return $this->adminRepository->createAuto($validationData);
    }

    /**
     * @param $id
     * @return void
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->adminRepository->delete($id);
    }

    /**
     * @param $updateData
     * @return void
     */
    public function updateUser($updateData)
    {
        return $this->adminRepository->updateUser($updateData);
    }

    /**
     * @param $updateData
     * @return void
     */
    public function updateAuto($updateData)
    {
        return $this->adminRepository->updateAuto($updateData);
    }
}
