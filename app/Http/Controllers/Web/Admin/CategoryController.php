<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function show(Category $category)
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

    public function edit(Category $category)
    {
        return view('admin.pages.categories.edit');
    }

    public function update(Request $request, Category $category)
    {

    }

    public function restore(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }

}
