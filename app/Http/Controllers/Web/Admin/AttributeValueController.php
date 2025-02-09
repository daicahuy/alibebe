<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
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

    public function index(Request $request,$attribute,$sortColumn = null, $sortDirection = 'desc')
    {
        $keyword = $request->input('_keyword');

        $data = $this->attributeValueService->getAllAttributeValue($request,$attribute,$keyword);
        // dd($data);
        $attribute = $data['attribute'];
        $attributeValues = $data['attributeValues'];
        return view('admin.pages.attribute_values.list',compact('attributeValues', 'attribute', 'sortColumn', 'sortDirection'));
    }

    public function hidden(Request $request,$attribute,$sortColumn = null, $sortDirection = 'desc')
    {
        $keyword = $request->input('_keyword');

        $data = $this->attributeValueService->hidden($request,$attribute,$keyword);
        // dd($data);
        $attribute = $data['attribute'];
        $attributeValues = $data['attributeValues'];
        return view('admin.pages.attribute_values.hidden',compact('attributeValues', 'attribute', 'sortColumn', 'sortDirection'));
    }

    public function create(Request $request,$attribute)
    {
        $data = $this->attributeValueService->getAllAttributeValue($request,$attribute);
        // dd($data);
        $attribute = $data['attribute'];
        return view('admin.pages.attribute_values.create',compact('attribute'));
    }

    public function store(StoreAttributeValueRequest $request, Attribute $attribute)
    {
        $this->attributeValueService->store($request, $attribute);
        return redirect()->route('admin.attributes.attribute_values.index', ['attribute' =>$attribute->id])->with('success','Thêm mới thành công!');
    }

    public function edit(Attribute $attribute, AttributeValue $attributeValue)
    {
        return view('admin.pages.attribute_values.edit',compact('attributeValue','attribute'));
    }

    public function update(UpdateAttributeValueRequest $request, Attribute $attribute, AttributeValue $attributeValue)
    {
        $this->attributeValueService->update($request, $attributeValue);
        return redirect()->route('admin.attributes.attribute_values.edit', ['attribute' =>$attribute->id,'attributeValue'=>$attributeValue->id])->with('success','Cập nhật thành công!');
    }

    public function destroy(Request $request, Attribute $attribute)
    {
        $id = $request->input('id');
        $ids = $request->input('ids',[]);
        // dd($ids);
        try {
            if($id){
                $this->attributeValueService->delete($id);
            }
            else if( $ids){
                $idsArray = explode(',', $ids); // Chuyển chuỗi IDs thành mảng
                $this->attributeValueService->deleteAll($idsArray); // Gọi phương thức xóa tất cả trong service
            }else{}
            return redirect()->route('admin.attributes.attribute_values.index', ['attribute' =>$attribute->id])->with('success','Xóa thành công!');
        } catch (\Exception $e) {
            // Trả về thông báo lỗi qua session
            return redirect()->route('admin.attributes.attribute_values.index', ['attribute' =>$attribute->id])->with('error', $e->getMessage());
        }
    }
}
