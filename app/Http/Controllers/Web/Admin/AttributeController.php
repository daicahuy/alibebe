<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttributeRequest;
use App\Models\Attribute;
use App\Services\Web\Admin\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeService;
    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }
    public function index()
    {
        $data = $this->attributeService->getAllAttributeService();
        // dd($attibutes);
        return view('admin.pages.attributes.list',compact('data'));
    }

    public function create()
    {
        return view('admin.pages.attributes.create');
    }

    public function store(CreateAttributeRequest $request)
    {
            $this->attributeService->store($request);
            return redirect()->route('admin.attributes.index')->with('create_success','Thêm mới thành công!');
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.pages.attributes.edit',compact('attribute'));
    }

    public function update(Request $request, Attribute $attribute)
    {

    }

    public function destroy(Request $request)
    {
        
    }
}
