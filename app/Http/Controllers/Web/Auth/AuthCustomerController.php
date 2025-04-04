<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function actionVerifyEmail($id)
    {

        $user = User::query()->where('code_verified_email', $id)->first();

        if (!$user) {
            $data = ['status' => 404];
            return view('client.pages.auth.emails.view-verify-email', $data);
        }

        if (!$user['code_verified_at'] || now()->greaterThan($user["code_verified_at"])) {
            $data = ["message" => "Đường link không còn khả dụng", 'status' => 404];
            return view('client.pages.auth.emails.view-verify-email', $data);
        } else {
            User::query()->where('code_verified_email', $id)->update(['email_verified_at' => now(), 'code_verified_at' => null]);
            $data = ["message" => "Xác minh thành công", 'status' => 200];

            return view('client.pages.auth.emails.view-verify-email', $data);

        }
    }
}
