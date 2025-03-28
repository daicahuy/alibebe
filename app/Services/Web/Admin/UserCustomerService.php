<?php

namespace App\Services\Web\Admin;

use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCustomerService
{
    protected $userRepository;
    protected $userAddressRepo;

    public function __construct(UserRepository $userRepository, UserAddressRepository $userAddressRepo)
    {
        $this->userRepository = $userRepository;
        $this->userAddressRepo = $userAddressRepo;
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
        return $this->userRepository->getUserCustomerLock($request, $limit);
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

    public function getDefaultAddress($userId)
    {

        // $adr = $this->userAddressRepo->getDefaultAddressById($userId);
        $adr = $this->userRepository->getDefaultAddress($userId);

        // dd($adr);
        return $adr;
    }

}
