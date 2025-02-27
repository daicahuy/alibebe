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
        // Kiểm tra xem người dùng đã có địa chỉ chưa
        $hasAddress = $this->userAddressRepository->countAddress() > 0;

        // Đặt rule cho field 'address'
        $addressRule = $hasAddress ? 'nullable|string' : 'required|string';

        request()->validate([
            'address' => $addressRule,
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')
            ],
            'fullname' => [
                'required',
                'string',
                'max:100'
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:20'
            ],
            'id_default' => [
                'nullable',
                'integer',
                Rule::in([0, 1])
            ]
        ]);
        try {
            // Lấy thông tin người dùng đang đăng nhập
            $userLogin = $this->accountRepository->findUserLogin();
            $userId = $userLogin->id;

            // Kiểm tra số lượng địa chỉ đã lưu
            $count = $this->userAddressRepository->countAddress();
            if ($count >= 12) {
                return [
                    'status' => false,
                    'message' => 'Bạn chỉ được lưu tối đa 12 địa chỉ!'
                ];
            }

            // Xử lý dữ liệu địa chỉ
            $id_default = request('id_default');
            $data = [
                'user_id' => $userId,
                'fullname' => request('fullname') ?: $userLogin->fullname,
                'phone_number' => request('phone_number') ?: $userLogin->phone_number,
                'address' => request('address'),
                'id_default' => $id_default ?? 0
            ];

            // Tạo địa chỉ mới
            $address = $this->userAddressRepository->create($data);

            // Nếu địa chỉ mới là mặc định và đã có địa chỉ mặc định, thì cập nhật địa chỉ cũ
            $addressDefault = $this->accountRepository->getUserProfileData()->defaultAddress;
            if ($address->id_default == 1 && $addressDefault) {
                $addressDefault->update(['id_default' => 0]);
            }

            return [
                'status' => true,
                'message' => 'Tạo mới thành công địa chỉ!'
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
        // Validate request
        request()->validate([
            'address' => 'required|string',
            'user_id' => [
                'nullable',
                Rule::exists('users', 'id')
            ],
            'fullname' => [
                'nullable',
                'string',
                'max:100'
            ],
            'phone_number' => [
                'nullable',
                'string',
                'max:20'
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

            // Tìm địa chỉ hiện tại của người dùng
            $address = $this->userAddressRepository->findById($id);

            // Lấy địa chỉ mặc định hiện tại
            $addressDefault = $this->accountRepository->getUserProfileData()->defaultAddress;

            // Chuẩn bị dữ liệu cập nhật
            $id_default = request('id_default');

            if ($id_default == 0 && $addressDefault->id_default) {
                return [
                    'status' => false,
                    'message' => 'Bạn Không Thể Tắt đi địa chỉ mặc định !'
                ];
            }

            $data = [
                'user_id' => $userId,
                'address' => request('address'),
                'fullname' => request('fullname') ?: $userLogin->fullname,
                'phone_number' => request('phone_number') ?: $userLogin->phone_number,
                'id_default' => isset($id_default) ? $id_default : 0
            ];
            // Cập nhật địa chỉ
            $address->update($data);

            // Nếu địa chỉ mới là mặc định (id_default = 1)
            if ($id_default == 1 && $address->id != $addressDefault->id) {
                // Cập nhật tất cả các địa chỉ khác của người dùng thành không mặc định (id_default = 0)
                if ($addressDefault && $addressDefault->id !== $id) {
                    $addressDefault->update(['id_default' => 0]);
                }
            }

            return [
                'status' => true,
                'message' => 'Chỉnh Sửa Địa Chỉ Thành Công!'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in AddressService::updateAddress", [
                'message' => $th->getMessage(),
                'data' => $address ?? 'No address data'
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
}
