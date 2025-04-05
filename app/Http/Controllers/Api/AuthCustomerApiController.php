<?php

namespace App\Http\Controllers\api;

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Mail\VerifyEmail;
use App\Models\Otp;
use App\Models\User;
use App\Services\Api\Client\AuthCustomerService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Str;
use Validator;

use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


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
            $phoneNumberOrEmail = $request->input('phone_number_or_email');
            $validator->after(function ($validator) use ($credentials, $remember) {
                if (!Auth::attempt($credentials, $remember)) {
                    $validator->errors()->add('password', 'Sai mật khẩu');
                }

            });
            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();
                if ($user->status == 0) {
                    return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errorsLogin' => 'Tài khoản không còn hoạt động!']);
                }
                if ($user->status == 2) {
                    return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errorsLogin' => 'Tài khoản đã bị khóa!']);
                }
                $token = $user->createToken('token')->plainTextToken;
                return response()->json(['status' => Response::HTTP_OK, 'user' => $user, 'token' => $token], 200);
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
            if ($user->status == 0) {
                return redirect()->intended('/login')->with('error', "Tài khoản không còn hoạt động");
            }
            if ($user->status == 2) {
                return redirect()->intended('/login')->with('error', "Tài khoản đã bị khóa");
            }
            Auth::login($user);
            return redirect()->intended('/');
        } else {
            $verificationCode = Str::uuid();
            $newUser = User::create([
                'google_id' => $googleUser->id,
                'fullname' => $googleUser->name,
                'email' => $googleUser->email,
                "role" => UserRoleType::CUSTOMER,
                "status" => UserStatusType::ACTIVE,
                'code_verified_email' => $verificationCode,
                'code_verified_at' => now()->addHours(24),
                'password' => bcrypt(Str::random(16)),

            ]);

            if ($newUser) {
                $verificationUrl = route('auth.verification.verify', ['id' => $newUser->code_verified_email]); // Sử dụng ID user
                Mail::to($newUser->email)->send(new VerifyEmail($newUser, $verificationUrl));
            }

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
        if (!$user->isEmployee()) {
            return redirect()->intended('/login');

        }
        if ($user) {
            if ($user->status == 0) {
                return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errorsLogin' => 'Tài khoản không còn hoạt động']);
            }
            if ($user->status == 2) {
                return response()->json(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errorsLogin' => 'Tài khoản đã bị khóa.']);
            }
            Auth::login($user);
            return redirect()->intended('/');
        } else {
            $verificationCode = Str::uuid();

            $newUser = User::create([
                'facebook_id' => $facebookUser->id,
                'fullname' => $facebookUser->name,
                'email' => $facebookUser->email,
                "role" => UserRoleType::CUSTOMER,
                "status" => UserStatusType::ACTIVE,
                'code_verified_email' => $verificationCode,
                'code_verified_at' => now()->addHours(24),
                'password' => bcrypt(Str::random(16)),

            ]);

            if ($newUser) {
                $verificationUrl = route('auth.verification.verify', ['id' => $newUser->code_verified_email]); // Sử dụng ID user
                Mail::to($newUser->email)->send(new VerifyEmail($newUser, $verificationUrl));
            }

            // Đăng nhập người dùng mới
            Auth::login($newUser);

            // Chuyển hướng đến trang hoàn tất thông tin (nếu cần)
            return redirect()->intended('/'); // Đường dẫn đến trang hoàn tất thông tin
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function sendOtp(Request $request)
    {
        try {
            $data = $request->all();

            $rules = [
                'email' => ['required', 'email', 'max:100'],
                // 'terms_and_privacy' => 'required|boolean',
            ];

            $messages = [

                'email.required' => 'Vui lòng nhập email.',
                'email.string' => 'Email phải là chuỗi ký tự.',
                'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
                'email.max' => 'Email không được vượt quá 100 ký tự.',
                // 'terms_and_privacy.required' => 'Vui lòng chấp nhận Điều khoản và Quyền riêng tư.',
            ];


            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            $validator->after(function ($validator) use ($request) {
                $email = $request->input('email');

                $user = User::where('email', $email)->first();
                if (!$user) {
                    $validator->errors()->add('email', 'Email không tồn tại.');
                }
            });

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }


            $otp = rand(100000, 999999);
            Otp::create(['otp' => $otp, 'email' => $request->input('email'), "expire_at" => now()->addMinutes(10)]);
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Mã OTP xác thực');
            });

            return response()->json(['status' => Response::HTTP_OK, 'email' => $request->input('email'), 'message' => "oks"], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function verifyOpt(Request $request)
    {
        try {
            $data = $request->all();

            $rules = [
                'otp' => ['required', 'numeric'],
                'email' => ['required'],

            ];

            $messages = [

                'otp.required' => 'Vui lòng nhập Mã.',
                'otp.numeric' => 'Email phải là chuỗi ký tự.',
                // 'terms_and_privacy.required' => 'Vui lòng chấp nhận Điều khoản và Quyền riêng tư.',
            ];
            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            $validator->after(function ($validator) use ($request) {
                $email = $request->input('email');
                $otp = $request->input('otp');

                $dataOtp = Otp::where('email', $email)->first();

                if (!$dataOtp["otp"] || now()->greaterThan($dataOtp["expire_at"])) {
                    $validator->errors()->add('otpError', 'Mã OTP đã hết hạn!');
                } elseif ($otp != $dataOtp["otp"]) {
                    $validator->errors()->add('otpError', 'Mã OTP không chính xác!');
                }
            });

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }
            Otp::query()->where('email', $request->input('email'))->delete();
            return response()->json(['status' => Response::HTTP_OK, 'message' => "oks"], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }


    }



    public function reSendOpt(Request $request)
    {
        try {

            $email = $request->input('email');


            $otp = rand(100000, 999999);
            Otp::query()->where('email', $email)->update(['otp' => $otp, "expire_at" => now()->addMinutes(10)]);
            // Gửi OTP qua email (không cần tạo file view)
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Mã OTP xác thực');
            });

            return response()->json(['status' => Response::HTTP_OK], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $data = $request->all();

            $rules = [
                'otp_email' => ['required'],
                'password' => ['required', 'string', 'min:4', 'max:255', 'confirmed'],
                'password_confirmation' => ['required'],


                // 'terms_and_privacy' => 'required|boolean',
            ];

            $messages = [
                'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
                'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu.',
                // 'terms_and_privacy.required' => 'Vui lòng chấp nhận Điều khoản và Quyền riêng tư.',
            ];




            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }
            $user = User::where('email', $request->input('otp_email'))->first();


            $user->password = Hash::make($request->input('password'));
            $user->save();
            return response()->json(['status' => Response::HTTP_OK, 'message' => "success"], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function actionVerifyEmail($id)
    {
        try {
            $user = User::query()->where('id', $id)->first();

            $verificationUrl = route('auth.verification.verify', ['id' => $user->code_verified_email]); // Sử dụng ID user
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));

            return response()->json(['status' => Response::HTTP_OK], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }


}
