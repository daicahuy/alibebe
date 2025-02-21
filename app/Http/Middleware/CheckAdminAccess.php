<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {  /**
        * @var User
        */
       $user = Auth::user();

        // Nếu người dùng đã đăng nhập nhưng không phải admin hoặc nhân viên
        if ($user && !$user->isAdmin() && !$user->isEmployee()) {
            Auth::logout(); // Đăng xuất
            return redirect()->route('auth.admin.showFormLogin')->with('error', 'Bạn không có quyền truy cập vào trang admin!');
        }

        return $next($request);
    }
}
