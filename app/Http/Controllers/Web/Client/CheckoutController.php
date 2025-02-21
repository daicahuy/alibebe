<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function cartCheckout()
    {
        $user = Auth::user();

        return view('client.pages.checkout.cart-checkout', compact('user'));
    }

    public function pageSuccessfully()
    {
        return view('client.pages.checkout.page_successfully');

    }
}
