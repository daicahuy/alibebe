<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\Web\Admin\BrandService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $perPage = $request->get('per_page', 15);
        $sort = $request->get('sort', 'created_at'); // Lấy giá trị cột cần sắp xếp, mặc định là `name`
        $order = $request->get('order', 'desc'); // Lấy giá trị thứ tự sắp xếp, mặc định là `desc`
        Log::info("Parameters received: ", compact('keyWord', 'perPage', 'sort', 'order'));
        $brands = $this->brandService->listBrand15BrandAsc($perPage, $keyWord,$sort,$order);

        return view('admin.pages.brands.list', compact('brands', 'perPage', 'keyWord','sort','order'));
    }
    public function hidden(Request $request) {
        $keyWord = $request->input('_keyword'); // Lấy giá trị từ input search
        $perPage = $request->get('per_page', 15);
        $sort = $request->get('sort', 'created_at'); // Lấy giá trị cột cần sắp xếp, mặc định là `name`
        $order = $request->get('order', 'desc'); // Lấy giá trị thứ tự sắp xếp, mặc định là `desc`
        Log::info("Parameters received: ", compact('keyWord', 'perPage', 'sort', 'order'));
        $brands = $this->brandService->listHidden($perPage, $keyWord,$sort,$order);

        return view('admin.pages.brands.hidden', compact('brands', 'perPage', 'keyWord','sort','order'));
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

    $result = $this->brandService->UpdateBrand($request, $brand);
    if ($result) {
        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Cập nhật thương hiệu thành công!');
    }
    return redirect()
        ->back()
        ->withErrors('Cập nhật thương hiệu thất bại!');
}

    public function destroy( Request $request)
    {
        $ids = $request->input('ids', []);  // Lấy danh sách các ids từ form
        $id = $request->input('id');
        // dd($ids);
        try {
            if($id){
                $this->brandService->delete($id);
            }
            else if (!empty($ids)) {
                $idsArray = explode(',', $ids);
                $this->brandService->deleteAll($idsArray);  // Xóa các thương hiệu
            }

            return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.brands.index')->with('error', $e->getMessage());
        }
    }


}
