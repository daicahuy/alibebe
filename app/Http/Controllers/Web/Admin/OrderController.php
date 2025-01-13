<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.pages.orders.list');
    }

    public function show(Order $order)
    {
        return view('admin.pages.orders.detail');
    }

    public function update(Request $request, Order $order)
    {

    }

}
