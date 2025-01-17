<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
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
    public function index(Request $request)
    {
        $filter = $request->input('filter', null);
        $data = $this->attributeService->getAllAttributeService($request,$filter);
        // dd($attibutes);
        return view('admin.pages.attributes.list',compact('data'));
    }

    public function create()
    {
        return view('admin.pages.attributes.create');
    }

    public function store(StoreAttributeRequest $request)
    {
            $this->attributeService->store($request);
            return redirect()->route('admin.attributes.index')->with('success','Thêm mới thành công!');
    }

    public function edit(Attribute $attribute)
    {
        return view('admin.pages.attributes.edit',compact('attribute'));
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $this->attributeService->update($request,$attribute);
        return redirect()->route('admin.attributes.edit',$attribute->id)->with('success','Cập nhật thành công!');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id'); 
        $this->attributeService->delete($id);
        return redirect()->route('admin.attributes.index')->with('success','Xóa thành công!');
    }
}
