<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Models\Brand;
use App\Services\Web\Admin\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    protected $brandService;
    public function __construct(BrandService $brandService) {
        $this->brandService = $brandService;
    }
    public function index()
    {
        $brands = $this->brandService->listBrand15BrandAsc(); 
        return view('admin.pages.brands.list',compact('brands'));
    }

    public function create()
    {
        return view('admin.pages.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        try {
            // dd($request->all());
            $this->brandService->StoreBrand($request);
            return redirect()->route('admin.brands.index')->with('success','Brand created successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Failed to create brand: ' . $th->getMessage());
        }
        
    }

    public function edit(Brand $brand)
    {
        return view('admin.pages.brands.edit');
    }

    public function update(Request $request, Brand $brand)
    {

    }

    public function destroy(Request $request)
    {

    }
}
