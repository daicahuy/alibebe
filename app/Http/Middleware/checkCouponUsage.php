<?php

namespace App\Http\Middleware;

use App\Models\Coupon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkCouponUsage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->route('coupon'));
        $coupon = Coupon::with('orders')->where('id',$request->route('coupon')->id)->first();

        // dd($coupon);

        if ($coupon && $coupon->orders()->exists()) {
            return back()->withErrors(['message' => 'Mã Này Đã Sử Dụng , Không Được Chỉnh Sửa']);
        }

        return $next($request);
    }
}
