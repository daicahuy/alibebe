<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRoleAdminOrEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    
        /**
         * @var User
         */
        $user = Auth::user();
        
        if ($user->isAdmin() || $user->isEmployee()) {
            return $next($request);
        }
    
        return back()->with('error', 'Bạn không có quyền truy cập!');
    }
    
}
