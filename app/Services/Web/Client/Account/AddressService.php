<?php

namespace App\Services\Web\Client\Account;

use App\Enums\OrderStatusType;
use App\Repositories\OrderRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class AddressService
{
    protected UserAddressRepository $userAddressRepository;

    public function __construct(UserAddressRepository $userAddressRepository)
    {
        $this->userAddressRepository = $userAddressRepository;
    }

    public function index() {
        $addresses = $this->userAddressRepository->getAddressesForUser();
        return $addresses;
    }
    public function deleteAddress() {
        try {
            $addresses = $this->userAddressRepository->getAddressesForUser();

            dd($addresses);
            
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in ProfileService::updateInfomation", [
                'message' => $th->getMessage(),
                'data' => $user ?? 'No user data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
}
