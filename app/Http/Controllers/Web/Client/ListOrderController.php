<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListOrderController extends Controller
{
    public function index()
    {
        return view('client.pages.list-order-user');
    }
}
