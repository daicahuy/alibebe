<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        /**
         * @var User
         */
        $user = Auth::user();
        
        if ($role === 'admin') {
            if ($user->isAdmin()) {
                return $next($request);
            }
        }

        if ($role === 'employee') {
            if ($user->isEmployee()) {
                return $next($request);
            }
        }

        return back()->with('error', 'Bạn không có quyền truy cập!');
    }
}
