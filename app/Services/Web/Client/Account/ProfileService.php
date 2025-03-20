<?php

namespace App\Services\Web\Client\Account;

use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\AccountRepository;
use App\Repositories\UserAddressRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function updateInformation()
    {
        // Validate dữ liệu đầu vào
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
                    Rule::in([0, 1, 2]) // 0: Khác, 1: Nam, 2: Nữ
                ],
                'birthday' => [
                    'required',
                    'date',
                    'before_or_equal:today'
                ],
                'address' => [
                    'nullable', // Địa chỉ cũ
                    'integer',
                    Rule::exists('user_addresses', 'id')
                ],
                'new_address' => [
                    'nullable',
                    'string',
                    'max:255' // Địa chỉ mới nếu không có mặc định
                ],
                'phone_number' => [
                    'nullable',
                    'string',
                    'regex:/^[0-9]{10,11}$/',  // Kiểm tra số điện thoại 10-11 số
                    Rule::unique('users')->ignore($this->accountRepository->findUserLogin()->id),
                ]
            ],
            [
                'birthday.before_or_equal' => 'Ngày sinh không được vượt quá ngày hôm nay (' . now()->format('d/m/Y') . ').',
            ]
        );

        try {
            // Thực hiện transaction
            DB::transaction(function () use ($data) {
                // Tìm user đang đăng nhập
                $user = $this->accountRepository->findUserLogin();

                // Kiểm tra xem user có tồn tại hay không
                if (!$user) {
                    throw new \Exception('Không tìm thấy người dùng!');
                }

                // Lấy dữ liệu hợp lệ trừ ảnh đại diện
                $dataValidated = collect($data)->except('avatar', 'new_address')->all();

                // Lấy địa chỉ mặc định hiện tại
                $addressDefault = $this->accountRepository->getUserProfileData()->defaultAddress;

                // Nếu có địa chỉ mới, tạo mới trong bảng user_addresses
                if (!empty($data['new_address'])) {
                    // Tạo địa chỉ mới và đặt là mặc định
                    $newAddress = $this->userAddressRepository->create([
                        'user_id' => $user->id,
                        'address' => $data['new_address'],
                        'phone_number' => $user->phone_number,
                        'fullname' => $user->fullname,
                        'is_default' => 1, // Đặt làm mặc định
                    ]);

                    // Loại bỏ địa chỉ cũ khỏi mảng dữ liệu cập nhật
                    $dataValidated['address'] = $newAddress->id;
                } else if (!empty($data['address'])) {
                    // Nếu có địa chỉ cũ được chọn, đặt nó là mặc định
                    $oldDefaultAddress = $this->userAddressRepository->findById($data['address']);
                    if ($oldDefaultAddress && $oldDefaultAddress->is_default == 0) {

                        $oldDefaultAddress->update(['is_default' => 1]);

                        if ($addressDefault) {
                            $addressDefault->update(['is_default' => 0]);
                        }
                    }
                }

                // Cập nhật thông tin user
                $user->update($dataValidated);

                // Xử lý avatar mới nếu có
                if (request()->hasFile('avatar')) {
                    $oldImage = $user->avatar;
                    $imagePath = Storage::put('users', request()->file('avatar'));

                    // Cập nhật ảnh đại diện mới
                    $user->update(['avatar' => $imagePath]);

                    // Xóa avatar cũ nếu tồn tại
                    if (!empty($oldImage) && Storage::exists($oldImage)) {
                        Storage::delete($oldImage);
                    }
                }
            });

            return [
                'status' => true,
                'message' => 'Cập nhật thông tin thành công!'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in ProfileService::updateInformation", [
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

            // Kiểm tra xem người dùng đăng nhập bằng Google và chưa có mật khẩu
            $isGoogleUserWithoutPassword = $user->google_id && !$user->password;

            // Nếu không phải người dùng Google hoặc người dùng đã có mật khẩu
            if (!$isGoogleUserWithoutPassword) {
                // Kiểm tra mật khẩu cũ có đúng không
                if (!isset($data['current_password']) || !Hash::check($data['current_password'], $user->password)) {
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
            }

            // Cập nhật mật khẩu mới
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);

            $message = $isGoogleUserWithoutPassword ?
                'Đã tạo mật khẩu thành công! Vui lòng đăng nhập lại.' :
                'Cập nhật mật khẩu thành công! Vui lòng đăng nhập lại.';

            return [
                'status' => true,
                'message' => $message,
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
