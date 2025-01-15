<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
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

    public function store(Request $request, Attribute $attribute)
    {
        
    }

    public function edit(Attribute $attribute, AttributeValue $attributeValue)
    {
        return view('admin.pages.attribute_values.edit');
    }

    public function update(Request $request, Attribute $attribute, AttributeValue $attributeValue)
    {

    }

    public function destroy(Request $request, Attribute $attribute)
    {

    }
}
