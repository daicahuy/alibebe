<?php

namespace App\Services\Web\Admin;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserEmployeeService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserEmployee(Request $request, $limit)
    {
        return $this->userRepository->getUserEmployee($request, $limit);
    }

    public function countUserEmployeeLock()
    {
        return $this->userRepository->countUserEmployeeLock();
    }

    public function showUserEmployee(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUserEmployee($id, $columns);
    }
    public function getUserEmployeeLock(Request $request, $limit)
    {
        return $this->userRepository->getUserEmployeeLock($request, $limit);
    }
    public function createUserEmployee($data)
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function UpdateUserEmployee($ids, $data)
    {
        try {
            
            if (is_array($ids)) {
                return $this->userRepository->listByIds($ids, $data['status']);
            }
    
            return $this->userRepository->update($ids, $data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    
    }
}
