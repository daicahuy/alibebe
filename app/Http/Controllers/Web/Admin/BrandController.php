<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\Web\Admin\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    public function index(Request $request)
    {
        $keyWord = $request->input('_keyword'); // Lấy giá trị từ input search
        $perPage = $request->get('per_page', 10); 
        $brands = $this->brandService->listBrand15BrandAsc($perPage, $keyWord);

        return view('admin.pages.brands.list', compact('brands', 'perPage', 'keyWord'));
    }


    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {

        $this->brandService->StoreBrand($request);
        return redirect()->route('admin.brands.index')->with('success', 'Thêm mới thương hiệu thành công!');

    }

    public function edit(Brand $brand)
    {
        return view('admin.pages.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->UpdateBrand($request, $brand);
        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công!');

    }

    public function destroy($id)
    {
        //    dd($id);
        $deleted = $this->brandService->destroyBrand($id);
        // return back()->with('success','Delete breand SuccessFully!');
        if ($deleted) {
            return back()->with('success', 'Xóa thương hiệu thành công!');
        } else {
            return back()->with('error', 'Không thể xóa được thương hiệu do đã có sản phẩm liên kết.');
        }


    }
}
