<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\Web\Admin\ProductService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $keyword = $request->get('_keyword');

        $productData = $this->productService->getProducts($perPage, $categoryId, $stockStatus, $keyword);
        $products = $productData['products'];
        $categories = $this->productService->getCategories();

        return view('admin.pages.inventory.index', compact(
            'products',
            'categories',
            'perPage',
            'categoryId',
            'stockStatus',
            'keyword'
        ));
    }

    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $keyword = $request->get('_keyword');

        $productData = $this->productService->getProducts($perPage, $categoryId, $stockStatus, $keyword);
        $products = $productData['products'];
        $categories = $this->productService->getCategories();

        return view('admin.pages.inventory.history', compact(
            'products',
            'categories',
            'perPage',
            'categoryId',
            'stockStatus',
            'keyword'
        ));
    }
}
