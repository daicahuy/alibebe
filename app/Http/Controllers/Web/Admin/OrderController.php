<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;
use App\Enums\OrderStatusType;

class OrderController extends Controller
{




    public function index()
    {
        $user = Auth::user();
        return view('admin.pages.orders.list', compact('user'));
    }

    public function show(Order $order)
    {
        $user = Auth::user();

        return view('admin.pages.orders.detail', compact('user'));
    }

    public function update(Request $request, Order $order)
    {

    }

}
