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
        $perPage = $request->get('per_page', 10); // Mặc định là 10 nếu không có tham số
        $brands = $this->brandService->listBrand15BrandAsc($perPage);
        return view('admin.pages.brands.list', compact('brands', 'perPage'));
    }


    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {

        $this->brandService->StoreBrand($request);
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');

    }

    public function edit(Brand $brand)
    {
        return view('admin.pages.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->UpdateBrand($request, $brand);
        return redirect()->route('admin.brands.index')->with('success', 'Brand Update Successfully!');

    }

    public function destroy($id)
    {
        //    dd($id);
        $deleted = $this->brandService->destroyBrand($id);
        // return back()->with('success','Delete breand SuccessFully!');
        if ($deleted) {
            return back()->with('success', 'Delete Brand Successfully!');
        } else {
            return back()->with('error', 'This brand has products and cannot be deleted.');
        }


    }
}
