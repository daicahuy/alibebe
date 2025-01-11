<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.pages.products.list');
    }

    public function trash()
    {
        return view('admin.pages.products.trash');
    }

    public function show($id)
    {
        return view('admin.pages.products.show');
    }

    public function create()
    {
        return view('admin.pages.products.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit($id)
    {
        return view('admin.pages.products.edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function restore($id)
    {

    }

    public function restoreMany()
    {

    }

    public function delete($id)
    {

    }

    public function deleteMany()
    {

    }

    public function destroy($id)
    {

    }

    public function destroyMany()
    {

    }
}
