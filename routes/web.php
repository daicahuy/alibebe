<?php

use App\Http\Controllers\Web\Admin\BrandController;
use App\Http\Controllers\Web\Admin\CouponController;
use App\Http\Controllers\Web\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return '<h2>@Copyright by Huy + Anh + Manh + Hiep + Quan + Tung + Bao</h2>';
});



/*--------------ADMIN--------------*/

Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');


        Route::get('/brands', function () {
            return view('admin.pages.brands.list');
        });

        Route::get('/brands/create', function () {
            return view('admin.pages.brands.create');
        });

        Route::get('/brands/{id}/edit', function () {
            return view('admin.pages.brands.edit');
        });


        Route::get('/coupons', function () {
            return view('admin.pages.coupons.list');
        });

        Route::get('/coupons/create', function () {
            return view('admin.pages.coupons.create');
        });

        Route::get('/coupons/{id}/edit', function () {
            return view('admin.pages.coupons.edit');
        });
    });
