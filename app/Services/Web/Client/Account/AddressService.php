<?php

namespace App\Services\Web\Client\Account;

use App\Enums\OrderStatusType;
use App\Repositories\AccountRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AddressService
{
    protected UserAddressRepository $userAddressRepository;
    protected AccountRepository $accountRepository;

    public function __construct(
        UserAddressRepository $userAddressRepository,
        AccountRepository $accountRepository
    ) {
        $this->userAddressRepository = $userAddressRepository;
        $this->accountRepository = $accountRepository;
    }
    public function index()
    {
        $addresses = $this->userAddressRepository->getAddressesForUser();
        return $addresses;
    }
    public function createAddress()
    {
        request()->validate([
            'address' => 'required|string',
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')
            ],
            'id_default' => [
                'nullable',
                'integer',
                Rule::in([0, 1])
            ]
        ]);
        try {
            $userLogin = $this->accountRepository->findUserLogin();
            $userId = $userLogin->id;

            $addressDefault  = $this->accountRepository->getUserProfileData()->defaultAddress;

            $count = $this->userAddressRepository->countAddress();

            if ($count > 11) {
                return [
                    'status' => false,
                    'message' => 'Bạn Chỉ Được Lưu Tối Đa 12 Địa Chỉ !'
                ];
            }

            $id_default = request('id_default');

            $data = [
                'user_id' => $userId,
                'address' => request('address'),
                'id_default' => isset($id_default) ? $id_default : 0
            ];

            $address = $this->userAddressRepository->create($data);

            if ($address->id_default == 1 && $addressDefault) {
                Log::info("message");
                $addressDefault->update(['id_default' => 0]);
            }

            return [
                'status' => true,
                'message' => 'Tạo Mới Thành Công Địa Chỉ !!!'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in AddressService::createAddress", [
                'message' => $th->getMessage(),
                'data' => $data ?? 'No data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    public function deleteAddress($id)
    {
        try {
            $address = $this->userAddressRepository->findById($id);
            if ($address->id_default === 1) {
                return [
                    'status' => false,
                    'message' => 'Địa Chỉ Đang Là Mặc Định , Không Được Xóa !'
                ];
            }

            $address->delete();

            return [
                'status' => true,
                'message' => 'Xóa Thành Công !'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in AddressService::deleteAddress", [
                'message' => $th->getMessage(),
                'data' => $address ?? 'No user data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    public function updateIdDefault()
    {
        try {

            $addressId = request('address_id');

            $addressDefault  = $this->accountRepository->getUserProfileData()->defaultAddress;

            $address = $this->userAddressRepository->findById($addressId);

            if ($address->id_default !== 1) {
                $address->update([
                    'id_default' => 1
                ]);

                $addressDefault->update([
                    'id_default' => 0
                ]);
            }

            return [
                'status' => true,
                'message' => 'Chỉnh Sửa Địa Chỉ Mặc Định Thành Công !'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in AddressService::updateIdDefault", [
                'message' => $th->getMessage(),
                'data' => $addresses ?? 'No user data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    public function updateAddressService($id)
    {
        request()->validate([
            'address' => 'required|string',
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')
            ],
            'id_default' => [
                'nullable',
                'integer',
                Rule::in([0, 1])
            ]
        ]);
        
        try {
            $userLogin = $this->accountRepository->findUserLogin();
            $userId = $userLogin->id;

            $addressDefault  = $this->accountRepository->getUserProfileData()->defaultAddress;

            $id_default = request('id_default');

            $data = [
                'user_id' => $userId,
                'address' => request('address'),
                'id_default' => isset($id_default) ? $id_default : 0
            ];

            $address = $this->userAddressRepository->findById($id);

            $address->update($data);

            if ($address->id_default == 1 && $addressDefault) {
                Log::info("message");
                $addressDefault->update(['id_default' => 0]);
            }
            return [
                'status' => true,
                'message' => 'Chỉnh Sửa Địa Chỉ Thành Công !'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in AddressService::deleteAddress", [
                'message' => $th->getMessage(),
                'data' => $address ?? 'No user data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
}
