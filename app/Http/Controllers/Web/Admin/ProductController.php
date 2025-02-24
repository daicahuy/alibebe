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

        $perPage = $request->get('per_page', 5);
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $keyword = $request->get('_keyword');
        // dd($categoryId);
        $products = $this->productService->getProducts($perPage, $categoryId, $stockStatus, $keyword);
        $categories = $this->productService->getCategories();

        return view('admin.pages.products.list', compact(
            'products',
            'categories',
            'perPage',
            'categoryId',
            'stockStatus',
            'keyword',
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
        // dd($this->productService->getData());
        return view('admin.pages.products.create', $this->productService->getData());
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

    public function delete(Request $request, $product)
    {
        // dd($product);
        $deleteResult = $this->productService->delete($product);
        if ($deleteResult['success']) {
            return
                redirect()
                    ->route('admin.products.index')
                    ->with([
                        'msg' => $deleteResult['message'],
                        'type' => 'success'
                    ]);
        } else {
            return redirect()->route('admin.products.index')->with([
                'msg' => $deleteResult['message'],
                'type' => 'error'
            ]);
        }
    }

    public function destroy(Request $request)
    {

    }
}
