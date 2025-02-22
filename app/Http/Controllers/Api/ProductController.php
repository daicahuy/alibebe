<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductSingleRequest;
use App\Services\Api\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends ApiBaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function storeSingle(StoreProductSingleRequest $request)
    {
        $response = $this->productService->storeSingle($request->validated());
        return $response;
        // Create product
        // $product = Product::create($request->all());

        // return $this->sendSuccess($product, 'Product created successfully.');
    }
}
