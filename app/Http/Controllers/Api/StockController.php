<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreStockProductSingleRequest;
use App\Http\Requests\Api\StoreStockProductVariantRequest;
use App\Services\Api\Admin\StockService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StockController extends ApiBaseController
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function importSingle(StoreStockProductSingleRequest $request)
    {
        $response = $this->stockService->importSingle($request->validated());

        if ($response['success']) {
            return $this->sendSuccess(
                message: $response['message'],
                statusCode: Response::HTTP_CREATED,
            );
        }

        return $this->sendError(
            message: $response['message'],
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    public function importVariant(StoreStockProductVariantRequest $request)
    {
        $response = $this->stockService->importVariant($request->validated());

        if ($response['success']) {
            return $this->sendSuccess(
                message: $response['message'],
                statusCode: $response['status'],
            );
        }

        return $this->sendError(
            message: $response['message'],
            statusCode: $response['status'],
        );
    }
}
