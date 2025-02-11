<?php

namespace App\Services\Web\Admin;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCustomerService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserCustomer(Request $request, $limit)
{
    return $this->userRepository->getUserCustomer($request, $limit);
}


    public function showUserCustomer(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUserCustomer($id, $columns);
    }
    public function getUserCustomerLock(Request $request, $limit)
    {
        return $this->userRepository->getUserCustomerLock($request,$limit);
    }

    public function countUserCustomerLock()
    {
        return $this->userRepository->countUserCustomerLock();
    }

    public function UpdateUserCustomer($ids, $data)
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
