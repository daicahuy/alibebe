<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('client.pages.accounts.index');
    }
    public function address()
    {
        return view('client.pages.accounts.address');
    }

    public function order() {
        return view('client.pages.accounts.order');
    }

    public function profile() {
        return view('client.pages.accounts.profile');
    }

    public function wishlist() {
        return view('client.pages.accounts.wishlist');
    }
}
