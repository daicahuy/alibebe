<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\api\BrandApiController;
use App\Http\Controllers\API\AttributeController;
use App\Http\Controllers\API\AttributeValueController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Web\Admin\CouponController;
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


Route::prefix('/categories')
    ->name('api.categories.')
    ->controller(CategoryController::class)
    ->group(function () {

        Route::patch('/{category}/active', 'toggleActive')->name('toggleActive'); // Cập nhật trạng thái active
    
    });
Route::put('/brands/{brand}/status',[BrandApiController::class,'update'])->name('updateStatus');
Route::prefix('/attributes')
    ->name('attributes.')
    ->controller(AttributeController::class)
    ->group(function () {
        Route::put('/{attribute}', 'update')->name('update');
        Route::prefix('{attribute}/attribute_values')
        ->name('attribute_values.')
        ->controller(AttributeValueController::class)
        ->where(['attribute' => '[0-9]+'])
        ->group(function () {
            Route::put('/{attributeValue}', 'update')->name('update');
        });
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
Route::post('/orders/uploadImgConfirm/{idOrder}', [OrderController::class, 'uploadImgConfirm'])->name('uploadImgConfirm');
Route::post('/orders/invoice/{idOrder}', [OrderController::class, 'generateInvoice'])->name('generateInvoice');
Route::get('/orders/{idOrder}', [OrderController::class, 'getOrderDetail'])->name('getOrderDetail');
// api
Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {
        // COUPONS
        Route::prefix('/coupons')
            ->name('coupons.')
            ->controller(CouponController::class)
            ->group(function () {
                Route::post('/update-coupon-status/{id}',  'apiUpdateStatus');
            });
    });
