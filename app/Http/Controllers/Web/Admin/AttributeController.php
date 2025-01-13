<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
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

    public function edit(Attribute $attribute)
    {
        return view('admin.pages.attributes.edit');
    }

    public function update(Request $request, Attribute $attribute)
    {

    }

    public function destroy(Request $request)
    {
        
    }
}
