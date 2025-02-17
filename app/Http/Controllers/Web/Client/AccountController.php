<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\Account\OrderService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }

    public function dashboard()
    {
        return view('client.pages.accounts.dashboard');
    }

    public function address()
    {
        return view('client.pages.accounts.address');
    }

    public function order() {
        $orders = $this->orderService->index();
        return view('client.pages.accounts.order',compact('orders'));
    }

    public function orderDetail() {
        return view('client.pages.accounts.order_detail');
    }

    public function profile() {
        return view('client.pages.accounts.profile');
    }

    public function wishlist() {
        return view('client.pages.accounts.wishlist');
    }
}
