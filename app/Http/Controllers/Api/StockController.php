<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreStockProductExcelRequest;
use App\Http\Requests\Api\StoreStockProductRequest;
use App\Http\Requests\Api\StoreStockProductSingleRequest;
use App\Http\Requests\Api\StoreStockProductVariantRequest;
use App\Imports\StockMovementDetailsImport;
use App\Services\Api\Admin\StockService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends ApiBaseController
{
    protected StockService $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function importStock(StoreStockProductRequest $request)
    {
        $response = $this->stockService->importStock($request->validated());

        if ($response['success']) {
            return $this->sendSuccess(
                message: $response['message'],
                statusCode: $response['status'],
            );
        }

        return $this->sendError(
            message: $response['message']
        );
    }

    public function importStockExcel(StoreStockProductExcelRequest $request)
    {
        $response = $this->stockService->importStockExcel($request->validated());

        if ($response['success']) {
            return $this->sendSuccess(
                message: $response['message'],
                statusCode: $response['status'],
            );
        }

        return $this->sendError(
            message: $response['message']
        );
    }
}
