<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function cartCheckout()
    {
        return view('client.pages.cart-checkout');
    }
}
