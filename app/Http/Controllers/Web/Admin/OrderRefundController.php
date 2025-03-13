<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderRefundController extends Controller
{
    //
    public function index()
    {
        return view('admin.pages.orders-refund.index');

    }
}
