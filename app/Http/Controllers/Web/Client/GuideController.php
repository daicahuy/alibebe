<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function muaHang() {
        return view('client.pages.mua-hang');
    }
    public function hoanHang() {
        return view('client.pages.hoan-hang');
    }
}
