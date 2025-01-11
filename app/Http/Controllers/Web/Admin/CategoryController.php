<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.pages.categories.list');
    }

    public function trash()
    {
        return view('admin.pages.categories.trash');
    }

    public function show($id)
    {
        return view('admin.pages.categories.show');
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit($id)
    {
        return view('admin.pages.categories.edit');
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
