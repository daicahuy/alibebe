<?php

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
