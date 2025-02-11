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
    public function index(Request $request,$sortColumn = null, $sortDirection = 'desc')
    {
        $filter = $request->input('filter', null);
        $keyword = $request->input('_keyword');
        // $sortColumn = $request->input('sortColumn');
        // $sortDirection = $request->input('sortDirection', 'desc');
        $data = $this->attributeService->getAllAttributeService($request,$filter,$keyword);
        // dd($attibutes);
        return view('admin.pages.attributes.list',compact('data', 'sortColumn', 'sortDirection'));
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
        $ids = $request->input('ids',[]);
        try {
            if($id){
                $this->attributeService->delete($id);
            }else if( $ids){
                $idsArray = explode(',', $ids); // Chuyển chuỗi IDs thành mảng
                $this->attributeService->deleteAll($idsArray); // Gọi phương thức xóa tất cả trong service
            }else{}
            return back()->with('success','Xóa thành công!');
        } catch (\Exception $e) {
            // Trả về thông báo lỗi qua session
            return back()->with('error', $e->getMessage());
        }
    }   
     public function hidden(Request $request,$sortColumn = null, $sortDirection = 'desc')
    {
        $filter = $request->input('filter', null);
        $keyword = $request->input('_keyword');
        // $sortColumn = $request->input('sortColumn');
        // $sortDirection = $request->input('sortDirection', 'desc');
        $data = $this->attributeService->hidden($request,$filter,$keyword);
        // dd($attibutes);
        return view('admin.pages.attributes.hidden',compact('data', 'sortColumn', 'sortDirection'));
    }

    
}
