<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\HandleLoginRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Enums\UserStatusType;

class AuthAdminController extends Controller
{
    public function showFormLogin()
    {
        return view('admin.pages.auth.login');
    }

    public function handleLogin(HandleLoginRequest $request)
    {
        $login = $request->validated();
    
        if (Auth::attempt($login)) {
            $request->session()->regenerate();
    
            /**
             * @var User
             */
            $user = Auth::user();
            $userFromDb = User::find($user->id);
            if ($user->status == UserStatusType::LOCK) {
                Auth::logout(); // Đăng xuất ngay nếu tài khoản bị khóa
                return redirect()->route('auth.admin.showFormLogin')
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.Vui lòng check mail']);
            }
            if ($userFromDb->status != $user->status) {
                // Nếu trạng thái đã thay đổi, đăng xuất và thông báo
                Auth::logout(); // Đăng xuất người dùng
                return redirect()->route('auth.admin.showFormLogin')
                    ->withErrors(['email' => 'Trạng thái tài khoản của bạn đã thay đổi. Vui lòng đăng nhập lại.']);
            }
            if ($user->status == UserStatusType::ACTIVE) {
                if ($user->isAdmin() || $user->isEmployee()) {
                    return redirect()->route($user->isAdmin() ? 'admin.index' : 'admin.index-employee')
                        ->with('success', 'Đăng nhập thành công!');
                } else {
                    Auth::logout(); // Đăng xuất ngay nếu không phải Admin/Nhân viên
                    return redirect()->route('auth.admin.showFormLogin')
                        ->withErrors(['email' => 'Tài khoản không có quyền truy cập.']);
                }
            } else {
                Auth::logout(); // Đăng xuất nếu tài khoản bị khóa
                return redirect()->route('auth.admin.showFormLogin')
                    ->withErrors(['email' => 'Tài khoản của bạn đã bị khóa.']);
            }
        }
    
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    public function showFormForgotPassword()
    {
        return view('admin.pages.auth.forgot-password');
    }

    public function sendOtp(ForgotPasswordRequest $request)
    {
        $request->validated();
        $email = $request->input('email');

          //    Kiểm tra email có trong database
        $user = User::where('email', $email)->first();
    // dd($email, $user);
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại!']);
        }
       // Tạo mã OTP ngẫu nhiên 5 số
       $otp = rand(10000, 99999);

       // Lưu OTP vào session (thời gian sống 5 phút)
       Session::put('otp', $otp);
       Session::put('otp_email', $request->email);
       Session::put('otp_expire', now()->addMinutes(5));

       // Gửi OTP qua email (không cần tạo file view)
       Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
           $message->to($request->email)
                   ->subject('Mã OTP xác thực');
       });

       return redirect()->route('auth.admin.showFormOtp')->with('message', 'Mã OTP đã được gửi!');
    }



    public function showFormOtp()
    {
        return view('admin.pages.auth.otp');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $email = $request->input('email');

        // Kiểm tra OTP từ session
        
        $otpStored = Session::get('otp');
        $otpExpire = Session::get('otp_expire');

        if (!$otpStored || now()->greaterThan($otpExpire)) {
            return back()->with('error', 'Mã OTP đã hết hạn!');
        }

        if ($request->otp != $otpStored) {
            return back()->with('error', 'Mã OTP không chính xác!');
        }

        Session::put('otp_verified', true);

        // Lưu email vào session để đổi mật khẩu
        Session::put('otp_email', $email);
        Session::forget('otp'); // Xóa OTP sau khi xác thực thành công

        return redirect()->route('auth.admin.showFormNewPassword')->with('success', 'Xác minh thành công!');
    }




    public function showFormNewPassword()
    {
        // dd(Session::all());
        return view('admin.pages.auth.new-password');
    }




    public function updatePassword(UpdatePasswordRequest $request)
    {
    
        $request->validated();
        // Lấy email từ session
        $email = Session::get('otp_email');
    
        if (!$email) {
            return redirect()->route('auth.admin.showFormForgotPassword')
                ->with('error', 'Phiên đặt lại mật khẩu đã hết hạn.');
        }
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password_confirmation' => 'Xác nhận mật khẩu không khớp.']);
        }
        // Cập nhật mật khẩu mới
        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);
    
        // Xóa session sau khi đổi mật khẩu thành công
        Session::forget(['otp_email', 'otp']);
    
        return redirect()->route('auth.admin.showFormLogin')
            ->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }
    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.admin.showFormLogin');
    }
    public function resendOtp(Request $request)
    {
        // Lấy email từ session đã lưu trước đó
        $email = session('otp_email');
        
        // Kiểm tra nếu không có email trong session
        if (!$email) {
            return back()->withErrors(['email' => 'Không tìm thấy email để gửi lại mã OTP.']);
        }
    
        // Tạo lại mã OTP mới (5 chữ số ngẫu nhiên)
        $otp = rand(10000, 99999);
    
        // Cập nhật lại mã OTP và thời gian hết hạn trong session (5 phút)
        session(['otp' => $otp, 'otp_expire' => now()->addMinutes(5)]);
    
        // Gửi lại OTP qua email
        try {
            Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Mã OTP xác thực');
            });
    
            // Trả về thông báo thành công
            return redirect()->route('auth.admin.showFormOtp')->with('message', 'Mã OTP đã được gửi lại!');
        } catch (\Exception $e) {
            // Nếu có lỗi khi gửi email
            return back()->withErrors(['email' => 'Đã xảy ra lỗi khi gửi lại mã OTP.']);
        }
    }
    
}
