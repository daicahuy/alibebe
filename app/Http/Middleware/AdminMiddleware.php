<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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

        if (!$user || !$user->isAdmin()) {  
            return redirect()->route('auth.admin.showFormLogin'); // Điều hướng nếu không phải admin
        }
        return $next($request);
    }
}
