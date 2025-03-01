<?php

namespace App\Services\Web\Client\Account;

use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\AccountRepository;
use App\Repositories\UserAddressRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileService
{
    protected AccountRepository $accountRepository;
    protected UserAddressRepository $userAddressRepository;

    public function __construct(AccountRepository $accountRepository, UserAddressRepository $userAddressRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->userAddressRepository = $userAddressRepository;
    }

    public function index()
    {
        $user = $this->accountRepository->getUserProfileData();
        return $user;
    }

    public function updateInfomation()
    {
        $data = request()->validate(
            [
                'avatar' => [
                    'nullable',
                    'image',
                    'max:2048'
                ],
                'fullname' => [
                    'required',
                    'string',
                    'max:100'
                ],
                'gender' => [
                    'nullable',
                    Rule::in([0, 1, 2])
                ],
                'birthday' => [
                    'required',
                    'date',
                    'before_or_equal:today'
                ],
                'address' => [
                    'required',
                    'integer',
                    Rule::exists('user_addresses', 'id')
                ]
            ],
            [
                'birthday.before_or_equal' => 'Ngày sinh không được vượt quá ngày hôm nay (' . now()->format('d/m/Y') . ').',
            ]
        );

        try {
            // Tìm user đang đăng nhập
            $user = $this->accountRepository->findUserLogin();

            // Kiểm tra xem user có tồn tại hay không
            if (!$user) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy người dùng!'
                ];
            }

            $dataValidated = collect($data)->except('avatar')->all();

            // Kiểm tra địa chỉ mặc định hiện tại của user
            $oldDefaultAddress = $this->accountRepository->getUserProfileData()->defaultAddress;

            // Nếu có địa chỉ mặc định, cập nhật địa chỉ cũ về không mặc định
            if ($oldDefaultAddress) {
                $oldDefaultAddress->update(['id_default' => 0]);
            }

            // Cập nhật địa chỉ mới làm địa chỉ mặc định
            $newAddress = $this->userAddressRepository->findById($dataValidated['address']);
            if ($newAddress) {
                $newAddress->update(['id_default' => 1]);
            }
            // Cập nhật thông tin của user
            $user->update($dataValidated);

            // Kiểm tra và lưu ảnh đại diện mới nếu có
            if (request()->hasFile('avatar')) {
                $oldImage = $user->avatar;

                // Lưu ảnh mới vào thư mục 'users' trên Storage
                $imagePath = Storage::put('users', request()->file('avatar'));

                // Cập nhật ảnh đại diện mới
                $user->update(['avatar' => $imagePath]);

                // Xóa avatar cũ nếu tồn tại
                if (!empty($oldImage) && Storage::exists($oldImage)) {
                    Storage::delete($oldImage);
                }
            }

            // Trả về phản hồi thành công
            return [
                'status' => true,
                'message' => 'Cập nhật thông tin thành công!'
            ];
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

    public function createOrUpdateImage()
    {
        request()->validate(
            ['avatar' => 'image|max:2048']
        );

        try {
            $user = $this->accountRepository->findUserLogin();

            $oldImage = $user->avatar;

            if (request()->hasFile('avatar')) {
                $imagePath = Storage::put('users', request()->file('avatar'));

                $user->update(['avatar' => $imagePath]);

                if (!empty($oldImage) && Storage::exists($oldImage)) {
                    Storage::delete($oldImage);
                }

                return [
                    'status' => true,
                    'message' => 'Cập nhật ảnh thành công!'
                ];
            }

            return [
                'status' => false,
                'message' => 'Ảnh không hợp lệ hoặc không được chọn.'
            ];
        } catch (\Throwable $th) {
            Log::error("Error in ProfileService::createOrUpdateImage", [
                'message' => $th->getMessage(),
                'data' => $user ?? 'No user data'
            ]);

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    public function updatePasswordService($data)
    {
        try {
            $user = $this->accountRepository->findUserLogin();

            // Kiểm tra mật khẩu cũ có đúng không
            if (!Hash::check($data['current_password'], $user->password)) {
                return [
                    'status' => false,
                    'message' => 'Mật khẩu cũ không đúng!'
                ];
            }

            // Không cho phép nhập mật khẩu mới giống mật khẩu cũ
            if (Hash::check($data['new_password'], $user->password)) {
                return [
                    'status' => false,
                    'message' => 'Vui lòng không nhập lại mật khẩu cũ!'
                ];
            }

            // Cập nhật mật khẩu mới
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);

            return [
                'status' => true,
                'message' => 'Cập nhật mật khẩu thành công! Vui lòng đăng nhập lại.',
                'logout_required' => true
            ];
        } catch (\Throwable $th) {
            Log::error("Lỗi trong ProfileService::updatePasswordService", [
                'message' => $th->getMessage(),
                'user_id' => $user->id ?? null
            ]);

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
}
