<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return view('admin.pages.attributes.list');
    }

    public function create()
    {
        return view('admin.pages.attributes.create');
    }

    public function store(Request $request)
    {
        
    }

    public function edit($id)
    {
        return view('admin.pages.attributes.edit');
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
