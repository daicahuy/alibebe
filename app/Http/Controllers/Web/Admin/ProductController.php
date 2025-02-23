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
    public function index(Request $request)
    {

        $perPage = $request->get('per_page',5);

        $products = $this->productService->getProducts($perPage);
        $categories = $this->productService->getCategories();
        return view('admin.pages.products.list', compact(
            'products',
            'categories'
        ));
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
        return view('admin.pages.products.create');
    }

    public function store(Request $request)
    {

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
