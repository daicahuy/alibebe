<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        return view('admin.pages.product.index');
    }
    public function add()
    {
        return view('admin.pages.product.add');
    }

    public function add2()
    {
        return view('admin.pages.product.add2');
    }

    public function show()
    {
        return view('admin.pages.product.show');
    }
}
