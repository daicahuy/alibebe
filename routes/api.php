<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\api\AuthCustomerApiController;
use App\Http\Controllers\api\AuthCustomerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ListCategoryController;
use App\Http\Controllers\Api\HomeController;
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

// client
// show modal
// routes/api.php
Route::get('/productListCate/{id}', [ListCategoryController::class, 'detailModal']);

Route::prefix('/categories')
    ->name('api.categories.')
    ->controller(CategoryController::class)
    ->group(function () {

        Route::patch('/{category}/active', 'toggleActive')->name('toggleActive'); // Cập nhật trạng thái active
    
    });

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

Route::prefix('/coupons')
    ->name('coupons.')
    ->controller(CouponController::class)
    ->group(function () {
        Route::post('/update-coupon-status/{id}', 'apiUpdateStatus');
    });
    
Route::put('/brands/{brand}/status',[BrandController::class,'update'])->name('updateStatus');



Route::put('/brands/{brand}/status', [BrandController::class, 'update'])->name('updateStatus');


Route::prefix('/auth')
    ->name('api.auth.')
    ->group(function () {
        Route::post('/registerCustomer', [AuthCustomerApiController::class, "registerCustomer"])->name('registerCustomer');
        Route::post('/loginCustomer', [AuthCustomerApiController::class, "loginCustomer"])->name('loginCustomer')->middleware(['web']);
        Route::get('/logout', [AuthCustomerApiController::class, "logout"])->name('logout')->middleware(['web']);
        Route::get('/googleLogin', [AuthCustomerApiController::class, "googleLogin"])->name('googleLogin')->middleware(['web']);
        Route::get('/google-callback', [AuthCustomerApiController::class, "googleAuthentication"])->name('googleAuthentication')->middleware(['web']);
        Route::get('/facebookLogin', [AuthCustomerApiController::class, "facebookLogin"])->name('facebookLogin')->middleware(['web']);
        Route::get('/facebook-callback', [AuthCustomerApiController::class, "facebookAuthentication"])->name('facebookAuthentication')->middleware(['web']);

    });


// Route::middleware(['ApiSession'])->group(function () {

//     Route::prefix('/auth')
//         ->name('api.auth.')
//         ->group(function () {
//         });
// });

Route::get('/product/{id}', action: [HomeController::class, 'detailModal']);

