<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ListOrderController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        return view('client.pages.list-order-user', compact('user'));
    }
}
