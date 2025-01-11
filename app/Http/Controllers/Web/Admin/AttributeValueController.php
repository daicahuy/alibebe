<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index()
    {
        return view('admin.pages.attribute_values.list');
    }

    public function create()
    {
        return view('admin.pages.attribute_values.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit($id)
    {
        return view('admin.pages.attribute_values.edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

    public function destroyMany()
    {

    }
}
