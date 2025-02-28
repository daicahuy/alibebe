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

class AuthAdminController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            return back();
        }
    
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
    
            if ($user->isAdmin() || $user->isEmployee()) {
                return redirect()->route('admin.index');
            } else {
                Auth::logout(); // Đăng xuất ngay nếu không phải Admin/Nhân viên
                return redirect()->route('auth.admin.showFormLogin')
                    ->withErrors(['email' => 'Tài khoản không có quyền truy cập.']);
            }
        }
    
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }
    




    public function showFormRegister()
    {
        return view('admin.pages.auth.register');
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
       // Tạo mã OTP ngẫu nhiên 6 số
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
}
