<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleCounterController extends Controller
{
    public function index() {
        return view('admin.pages.seo_counter');
    }
}
