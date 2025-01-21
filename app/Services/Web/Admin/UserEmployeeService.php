<?php

namespace App\Services\Web\Admin;

use App\Repositories\UserEmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserEmployeeService
{
    protected $userRepository;

    public function __construct(UserEmployeeRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsersActivate(Request $request)
    {
        return $this->userRepository->getUsersActivate($request);
    }
    
    public function countUserLock()
    {
        return $this->userRepository->countUserLock();
    }

    public function showUser(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUser($id, $columns);
    }
    public function getUsersLock(Request $request)
    {
        return $this->userRepository->getUserLock($request);
    }
    public function createUser($data)
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function UpdateUser($id, $data)
    {
        try {
            return $this->userRepository->update($id, $data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }
   
}
