<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Web\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return view('admin.pages.products.list');
    }

    public function trash()
    {
        return view('admin.pages.products.trash');
    }

    public function show(Product $product)
    {
        return view('admin.pages.products.show');
    }

    public function create()
    {
        // dd($this->productService->getData());
        return view('admin.pages.products.create', $this->productService->getData());
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit(Product $product)
    {
        return view('admin.pages.products.edit');
    }

    public function update(Request $request, Product $product)
    {

    }

    public function restore(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }
}
