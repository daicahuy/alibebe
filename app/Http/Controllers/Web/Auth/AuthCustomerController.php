<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthCustomerController extends Controller
{
    public function showFormLogin()
    {
        return view('client.pages.auth.login');
    }

    public function showFormRegister()
    {
        return view('client.pages.auth.register');
    }

    public function showFormForgotPassword()
    {
        return view('client.pages.auth.forgot-password');
    }

    public function showFormOtp()
    {
        return view('client.pages.auth.otp');
    }

    public function showFormNewPassword()
    {
        return view('client.pages.auth.new-password');
    }
}
