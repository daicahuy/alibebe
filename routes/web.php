<?php

use App\Http\Controllers\Web\Admin\AttributeController;
use App\Http\Controllers\Web\Admin\AttributeValueController;
use App\Http\Controllers\Web\Admin\BrandController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\CouponController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\Web\Admin\ProductController;
use App\Http\Controllers\Web\Admin\ReviewController;
use App\Http\Controllers\Web\Admin\TagController;
use App\Http\Controllers\Web\Admin\UserController;
use App\Http\Controllers\Web\Auth\AuthAdminController;
use App\Http\Controllers\Web\Auth\AuthCustomerController;
use App\Http\Controllers\Web\Client\DetailProductController;
use App\Http\Controllers\Web\Client\HomeController;
use App\Http\Controllers\Web\Client\ListCategoriesController;
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

/*--------------CLIENT--------------*/
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/categories/{category?}', [ListCategoriesController::class, 'index'])->name('categories');
Route::get('/products/{product}', [DetailProductController::class, 'index'])->name('products');


/*--------------AUTHENTICATION--------------*/
Route::name('auth.')
    ->group(function() {

        Route::name('customer.')
            ->controller(AuthCustomerController::class)
            ->group(function() {

                Route::get('/login', 'showFormLogin')->name('showFormLogin');
                Route::get('/register', 'showFormRegister')->name('showFormRegister');
                Route::get('/forgot-password', 'showFormForgotPassword')->name('showFormForgotPassword');
                Route::get('/otp', 'showFormOtp')->name('showFormOtp');
                Route::get('/new-password', 'showFormNewPassword')->name('showFormNewPassword');
            
            });

        Route::name('admin.')
            ->prefix('admin')
            ->controller(AuthAdminController::class)
            ->group(function() {

                Route::get('/login', 'showFormLogin')->name('showFormLogin');
                Route::get('/forgot-password', 'showFormForgotPassword')->name('showFormForgotPassword');
                Route::get('/otp', 'showFormOtp')->name('showFormOtp');
                Route::get('/new-password', 'showFormNewPassword')->name('showFormNewPassword');
            
            });


    });



/*--------------ADMIN--------------*/

Route::prefix('/admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');


        // CATEGORIES
        Route::prefix('/categories')
            ->name('categories.')
            ->controller(CategoryController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/trash', 'trash')->name('trash');

                Route::get('/hidden',  'hidden')->name('hidden');

                Route::get('/{category}', 'show')->name('show')->where(['category' => '[0-9]+']);

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{category}', 'edit')->name('edit');

                Route::put('/{category}', 'update')->name('update')->where(['category' => '[0-9]+']);

                Route::put('/{category}/restore', 'restore')->name('restore');              

                Route::delete('{category}/delete', 'delete')->name('delete');
                
                Route::delete('/{category}', 'destroy')->name('destroy');


                // bulk
                Route::post('/bulk-restore',  'bulkRestore')->name('bulkRestore');

                Route::post('/bulk-destroy',  'bulkDestroy')->name('bulkDestroy');

                Route::post('/bulk-trash', 'bulkTrash')->name('bulkTrash');

                // search
                route::get('/search','search')->name('search');

            });
//


        // PRODUCTS
        Route::prefix('/products')
            ->name('products.')
            ->controller(ProductController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/trash', 'trash')->name('trash');

                Route::get('/{product}', 'show')->name('show')->where(['product' => '[0-9]+']);

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{product}', 'edit')->name('edit');

                Route::put('/{product}', 'update')->name('update');

                Route::put('/restore', 'restore')->name('restore');              

                Route::delete('/delete', 'delete')->name('delete');

                Route::delete('/destroy', 'destroy')->name('destroy');

            });

        // ATTRIBUTES
        Route::prefix('/attributes')
            ->name('attributes.')
            ->controller(AttributeController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{attribute}', 'edit')->name('edit');

                Route::put('/{attribute}', 'update')->name('update');   

                Route::delete('/destroy', 'destroy')->name('destroy');

                // Attribute Values
                Route::prefix('{attribute}/attribute_values')
                    ->name('attribute_values.')
                    ->controller(AttributeValueController::class)
                    ->where(['attribute' => '[0-9]+'])
                    ->group(function() {

                        Route::get('/', 'index')->name('index');

                        Route::get('/create', 'create')->name('create');

                        Route::post('/', 'store')->name('store');

                        Route::get('/edit/{attributeValue}', 'edit')->name('edit');

                        Route::put('/{attributeValue}', 'update')->name('update');   

                        Route::delete('/destroy', 'destroy')->name('destroy');
                    
                    });

            });


        // BRANDS
        Route::prefix('/brands')
            ->name('brands.')
            ->controller(BrandController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{brand}', 'edit')->name('edit');

                Route::put('/{brand}', 'update')->name('update');   

                Route::delete('/destroy', 'destroy')->name('destroy');

            });

        // TAGS
        Route::prefix('/tags')
            ->name('tags.')
            ->controller(TagController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{tag}', 'edit')->name('edit');

                Route::put('/{tag}', 'update')->name('update');   

                Route::delete('/destroy', 'destroy')->name('destroy');

            });

        // ORDERS
        Route::prefix('/orders')
            ->name('orders.')
            ->controller(OrderController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/{order}', 'show')->name('show')->where(['order' => '[0-9]+']);

                Route::put('/{order}', 'update')->name('update');

            });

        // USERS
        Route::prefix('/users')
            ->name('users.')
            ->controller(UserController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/lock', 'lock')->name('lock');

                Route::get('/{user}', 'show')->name('show');

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{user}', 'edit')->name('edit');

                Route::put('/{user}', 'update')->name('update');

            });
        

        // REVIEWS
        Route::prefix('/reviews')
            ->name('reviews.')
            ->controller(ReviewController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/{product}', 'show')->name('show')->where(['product' => '[0-9]+']);

                Route::put('/{review}', 'update')->name('update');

            });
        
        // COUPONS
        Route::prefix('/coupons')
            ->name('coupons.')
            ->controller(CouponController::class)
            ->group(function() {

                Route::get('/', 'index')->name('index');

                Route::get('/{coupon}', 'show')->name('show')->where(['coupon' => '[0-9]+']);

                Route::get('/create', 'create')->name('create');

                Route::post('/', 'store')->name('store');

                Route::get('/edit/{coupon}', 'edit')->name('edit');

                Route::put('/{coupon}', 'update')->name('update');   

                Route::delete('/destroy', 'destroy')->name('destroy');

            });

        
    });
