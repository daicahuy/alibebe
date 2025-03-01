<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Bỏ qua kiểm tra nếu truy cập trang đăng nhập admin
        if ($request->is('admin/login')) {
            return $next($request);
        }
    
        /**
         * @var User
         */
        $user = Auth::user();
    
        // Nếu không có user hoặc user không phải Admin/Nhân viên
        if (!$user || (!$user->isAdmin() && !$user->isEmployee())) {
            Auth::logout(); // Đăng xuất người dùng
            session()->invalidate(); // Xóa toàn bộ session
            session()->regenerateToken(); // Tạo token mới tránh lỗi bảo mật
    
            return redirect()->route('auth.admin.showFormLogin')
                ->with('error', 'Bạn không có quyền truy cập!');
        }
    
        return $next($request);
    }
    
}
