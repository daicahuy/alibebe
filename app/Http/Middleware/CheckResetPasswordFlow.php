<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;


class CheckResetPasswordFlow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('otp_email')) {
            return redirect()->route('auth.admin.showFormForgotPassword')->with('error', 'Bạn cần nhập email trước!');
        }
        
             // Kiểm tra nếu chưa xác thực OTP, không cho vào trang đổi mật khẩu
             if (in_array($request->route()->getName(), ['auth.admin.showFormNewPassword', 'auth.admin.updatePassword'])) {
                if (!Session::has('otp_verified') || Session::get('otp_verified') !== true) {
                    return redirect()->route('auth.admin.showFormOtp')->with('error', 'Bạn cần xác thực OTP trước!');
                }
            }
        return $next($request);
    }
}
