<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        return view('admin.pages.products.index');
    }
    public function add()
    {
        return view('admin.pages.products.add');
    }

    public function add2()
    {
        return view('admin.pages.products.add2');
    }

    public function show()
    {
        return view('admin.pages.products.show');
    }
}
