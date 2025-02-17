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
    public function handle(Request $request, Closure $next): Response
    {
         /**
         * @var User
         */
        $user = Auth::user();
        if (!Auth::check() || !$user->isAdmin() && !$user->isEmployee()) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
}
