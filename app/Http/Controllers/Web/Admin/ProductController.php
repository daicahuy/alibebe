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
        $products = $this->productService->getProducts();
        return view('admin.pages.products.list', compact(
            'products'
        ));
    }

    public function trash()
    {
        return view('admin.pages.products.trash');
    }

    public function show(Product $product)
    {
        // dd($product);
        $product->load(['brand', 'tags', 'productAccessories', 'productGallery', 'attributeValues', 'attributeValues.attribute', 'productStock']);

        if ($product->type === 1) {
            $product->load(['productVariants', 'productVariants.attributeValues', 'productVariants.attributeValues.attribute', 'productVariants.productStock']);
        }

        return view('admin.pages.products.show', ['product' => $product ,...$this->productService->getData()]);
    }

    public function create()
    {
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
