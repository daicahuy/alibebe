<?php
namespace App\Services\Api\Client;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Repositories\AuthCustomerRepository;
use Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

use Str;
use Validator;

class AuthCustomerService
{

    protected $authCustomerRepository;

    public function __construct(AuthCustomerRepository $authCustomerRepository)
    {
        $this->authCustomerRepository = $authCustomerRepository;

    }


    public function register(array $data)
    {

        $rules = [
            'fullname' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^0\d{9,10}$/', Rule::unique('users')],
            'email' => ['required', 'email', 'max:100', Rule::unique('users')],
            'password' => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
            'password_confirmation' => 'required',
            // 'terms_and_privacy' => 'required|boolean',
        ];

        $messages = [
            'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam.',
            'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'fullname.required' => 'Vui lòng nhập họ tên.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'email.required' => 'Vui lòng nhập email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'fullname.string' => 'Họ tên phải là chuỗi ký tự.',
            'fullname.max' => 'Họ tên không được vượt quá 100 ký tự.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'phone_number.unique' => 'Số điện thoại này đã được sử dụng.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.max' => 'Email không được vượt quá 100 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu.',
            // 'terms_and_privacy.required' => 'Vui lòng chấp nhận Điều khoản và Quyền riêng tư.',
        ];


        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
        }


        $verificationCode = Str::uuid();
        $dataRegister = [
            'fullname' => $data['fullname'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => $data['password'],
            'code_verified_email' => $verificationCode,
            'code_verified_at' => now()->addHours(24),
            "role" => UserRoleType::CUSTOMER,
            "status" => UserStatusType::ACTIVE
        ];



        $this->authCustomerRepository->registerCustomer($dataRegister);
        $user = User::query()->where('email', $dataRegister['email'])->first();
        if ($user) {
            $verificationUrl = route('auth.verification.verify', ['id' => $user->code_verified_email]); // Sử dụng ID user
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));
        }

        return ['status' => 'success', 'message' => 'Đăng ký thành công!', 'user' => $user];



    }

    public function changePassword($email, $password)
    {
        $this->authCustomerRepository->changePassword($email, $password);
        return ['status' => 'success', 'message' => 'Đổi thành công'];
    }




}

?>