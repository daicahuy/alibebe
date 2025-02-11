<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\HandleLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $user = User::where('email', $login['email'])->first();

            if (!$user || $user->role != 2) {
                return back()->withErrors([
                    'email' => 'Tài khoản không tồn tại.',
                ]);
            }
            /**
             * @var User
             */

            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.index');
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

    public function showFormOtp()
    {
        return view('admin.pages.auth.otp');
    }

    public function showFormNewPassword()
    {
        return view('admin.pages.auth.new-password');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.admin.showFormLogin');
    }
}
