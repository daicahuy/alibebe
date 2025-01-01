<?php

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

        // Category
        Route::get('/categories', function () {
            return view('admin.pages.categories.list');
        });

        Route::get('/categories/edit/{id}', function () {
            return view('admin.pages.categories.edit');
        });

        Route::get('/categories/detail/{id}', function () {
            return view('admin.pages.categories.detail');
        });

        Route::get('/categories/create', function () {
            return view('admin.pages.categories.create');
        });
        //
        Route::get('/category', function () {
            return view('admin.pages.categories.category');
        });

        Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('index');

        Route::get('/products-add', [\App\Http\Controllers\ProductController::class, 'add'])->name('add');

        Route::get('/products-add2', [\App\Http\Controllers\ProductController::class, 'add2'])->name('add2');

        Route::get('/products-show', [\App\Http\Controllers\ProductController::class, 'show'])->name('show');


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

        Route::get('reviews', function () {
            return view('admin.pages.review.list');
        });
        Route::get('reviews/detail', function () {
            return view('admin.pages.review.detail');
        });

        Route::get('orders', function () {
            return view('admin.pages.orders.list');
        });
        Route::get('orders/detail/{id}', function () {
            return view('admin.pages.orders.detail');
        });
    });
