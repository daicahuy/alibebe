<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    public function showFormLogin()
    {
        return view('admin.pages.auth.login');
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
}
