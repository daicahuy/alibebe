<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\Web\Admin\AttributeValueService;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    protected $attributeValueService;
    
    public function __construct(AttributeValueService $attributeValueService){
        $this->attributeValueService = $attributeValueService;
    }

    public function index($attribute)
    {
        $data = $this->attributeValueService->getAllAttributeValue($attribute);
        // dd($data);
        $attribute = $data['attribute'];
        $attributeValues = $data['attributeValues'];
        return view('admin.pages.attribute_values.list',compact('attributeValues', 'attribute'));
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
