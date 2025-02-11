<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function index($product)
    {
        return view('client.pages.detail-product');
    }
}
