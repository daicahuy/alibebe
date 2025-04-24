<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class OrderRefundController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        return view('admin.pages.orders-refund.index', compact('user'));

    }
}
