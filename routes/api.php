<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/orders')
    ->name('api.orders.')
    ->group(function () {

        Route::get('/list', [OrderController::class, 'index'])->name('index');
        Route::get('/list/count', [OrderController::class, 'countByStatus'])->name('countByStatus');
        Route::post('/updateOrderStatus', [OrderController::class, 'changeStatusOrder'])->name('changeStatusOrder');
        Route::post('/getOrderStatus', [OrderController::class, 'getOrderOrderByStatus'])->name('getOrderOrderByStatus');
        Route::post('/invoice', [OrderController::class, 'generateInvoiceAll'])->name('generateInvoiceAll');


    });
Route::post('/orders/invoice/{idOrder}', [OrderController::class, 'generateInvoice'])->name('generateInvoice');
Route::get('/orders/{idOrder}', [OrderController::class, 'getOrderDetail'])->name('getOrderDetail');