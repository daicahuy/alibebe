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
        
    });


