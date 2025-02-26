<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreProductSingleRequest;
use App\Http\Requests\Api\StoreProductVariantRequest;
use App\Services\Api\Admin\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_CREATED,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }

    public function storeVariant(StoreProductVariantRequest $request)
    {
        $response = $this->productService->storeVariant($request->validated());
        
        if ($response['success']) {
            return $this->sendSuccess(
                statusCode: Response::HTTP_CREATED,
                message: $response['message'],
            );
        }

        return $this->sendError(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: $response['message']
        );
    }
}
