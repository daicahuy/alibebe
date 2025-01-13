<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.pages.brands.list');
    }

    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit(Brand $brand)
    {
        return view('admin.pages.brands.edit');
    }

    public function update(Request $request, Brand $brand)
    {

    }

    public function destroy(Request $request)
    {

    }
}
