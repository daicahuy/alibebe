<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.pages.coupons.list');
    }

    public function show(Coupon $coupon)
    {

    }

    public function create()
    {
        return view('admin.pages.coupons.create');
    }

    public function store(Request $request)
    {

    }

    public function edit(Coupon $coupon)
    {
        return view('admin.pages.coupons.edit');
    }

    public function update(Request $request, Coupon $coupon)
    {

    }

    public function destroy(Request $request)
    {

    }

}
