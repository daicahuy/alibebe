<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.pages.coupons.list');
    }

    public function show()
    {

    }

    public function create()
    {
        return view('admin.pages.coupons.create');
    }

    public function store()
    {

    }

    public function edit()
    {
        return view('admin.pages.coupons.edit');
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function destroyMany()
    {

    }

}
