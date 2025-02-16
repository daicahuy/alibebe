<?php

namespace App\Http\Controllers\api;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Api\Client\AuthCustomerService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Str;
use Validator;


class AuthCustomerApiController extends Controller
{
    protected $authCustomerService;

    public function __construct(AuthCustomerService $authCustomerService)
    {
        $this->authCustomerService = $authCustomerService;
    }
    public function registerCustomer(Request $request)
    {
        try {
            //code...
            $data = $request->all();
            $result = $this->authCustomerService->register($data);
            return response()->json($result);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function loginCustomer(Request $request)
    {
        try {
            $rules = [
                'phone_number_or_email' => 'required|max:100',
                'password' => 'required|min:4|string|max:255',
                'remember_me' => 'boolean',
            ];

            $messages = [
                'phone_number_or_email.required' => 'Vui lòng nhập email hoặc số điện thoại.',
                'phone_number_or_email.max' => 'Email không được vượt quá 100 ký tự.',
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
                'phone_number_or_email.custom' => 'Tên đăng nhập không hợp lệ hoặc không tồn tại.', // Custom message for custom rule
            ];


            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            // Thêm custom rule để kiểm tra email hoặc số điện thoại tồn tại
            $validator->after(function ($validator) use ($request) {
                $phoneNumberOrEmail = $request->input('phone_number_or_email');
                if (!filter_var($phoneNumberOrEmail, FILTER_VALIDATE_EMAIL) && !is_numeric($phoneNumberOrEmail)) {
                    $validator->errors()->add('phone_number_or_email', 'Vui lòng nhập email hoặc số điện thoại hợp lệ');
                    return;
                }
                $user = User::where('email', $phoneNumberOrEmail)->orWhere('phone_number', $phoneNumberOrEmail)->first();
                if (!$user) {
                    $validator->errors()->add('phone_number_or_email', 'Tên đăng nhập không tồn tại.');
                }
            });


            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            $credentials = request()->only('phone_number_or_email', 'password');

            // Thêm điều kiện kiểm tra nếu là email hoặc số điện thoại
            if (filter_var(request('phone_number_or_email'), FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $credentials['phone_number_or_email'];
                unset($credentials['phone_number_or_email']);
            } else {
                $credentials['phone_number'] = $credentials['phone_number_or_email'];
                unset($credentials['phone_number_or_email']);
            }
            $remember = $request->boolean('remember_me');

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                if (!$user) {
                    // Ghi rõ lỗi
                    \Log::error('User is null after successful login');
                }
                $token = $user->createToken('token')->plainTextToken;
                return response()->json(['status' => 'success', 'user' => $user, 'token' => $token], 200);
            }

            return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => ['phone_number_or_email' => ['Tên đăng nhập hoặc mật khẩu không đúng']]], 422);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();

    }

    public function googleAuthentication()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();
        if ($user) {

            Auth::login($user);
            return redirect()->intended('/');
        } else {
            $newUser = User::create([
                'google_id' => $googleUser->id,
                'fullname' => $googleUser->name,
                'email' => $googleUser->email,
                "role" => UserRoleType::CUSTOMER,
                "status" => UserStatusType::ACTIVE,
                'password' => bcrypt(Str::random(16)),

            ]);

            // Đăng nhập người dùng mới
            Auth::login($newUser);

            // Chuyển hướng đến trang hoàn tất thông tin (nếu cần)
            return redirect()->intended('/'); // Đường dẫn đến trang hoàn tất thông tin
        }

    }

    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();

    }

    public function facebookAuthentication()
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $user = User::where('email', $facebookUser->getEmail())->first();
        if ($user) {

            Auth::login($user);
            return redirect()->intended('/');
        } else {
            $newUser = User::create([
                'facebook_id' => $facebookUser->id,
                'fullname' => $facebookUser->name,
                'email' => $facebookUser->email,
                "role" => UserRoleType::CUSTOMER,
                "status" => UserStatusType::ACTIVE,
                'password' => bcrypt(Str::random(16)),

            ]);

            // Đăng nhập người dùng mới
            Auth::login($newUser);

            // Chuyển hướng đến trang hoàn tất thông tin (nếu cần)
            return redirect()->intended('/'); // Đường dẫn đến trang hoàn tất thông tin
        }

    }

    public function logout()
    {
        Auth::logout();


        return redirect('/'); // Thay đổi đường dẫn này theo yêu cầu của bạn
    }


}
