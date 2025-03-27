<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use App\Services\Web\Admin\ProductService;
use App\Services\Web\Admin\StockMovementService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected ProductService $productService;
    protected StockMovementService $stockMovementService;

    public function __construct(
        ProductService $productService,
        StockMovementService $stockMovementService
    )
    {
        $this->productService = $productService;
        $this->stockMovementService = $stockMovementService;
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
        $stockMovementStatus = $request->get('stock_movement_type');
        $keyword = $request->get('_keyword');

        $stockMovements = $this->stockMovementService->getList($perPage, $stockMovementStatus, $keyword);

        return view('admin.pages.inventory.history', compact(
            'stockMovements',
            'perPage',
            'stockMovementStatus',
            'keyword'
        ));
    }

    public function detail(StockMovement $stockMovement)
    {
        $stockMovement->load([
            'user',
            'stockMovementDetail',
            'stockMovementDetail.product',
            'stockMovementDetail.productVariant',
            'stockMovementDetail.productVariant.product',
            'stockMovementDetail.productVariant.attributeValues'
        ]);

        return view('admin.pages.inventory.detail', compact('stockMovement'));
    }
}
