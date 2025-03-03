<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\api\AuthCustomerApiController;
use App\Http\Controllers\api\AuthCustomerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\api\CouponApiController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\api\OrderCustomerControllerApi;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\PaymentOnlineController;
use App\Http\Controllers\api\UserAddressController;
use App\Http\Controllers\Web\Admin\CouponController;
use App\Http\Controllers\Api\ListCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Web\Admin\AccountController;
use App\Http\Controllers\Web\Client\AccountController as ClientAccountController;
use App\Http\Controllers\Web\Client\DetailProductController;

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

Route::post('/cart/update', [CartItemController::class, 'update'])->middleware('web')->name('cart.update');
Route::post('/cart/save-session', [CartItemController::class, 'saveSession'])->middleware('web')->name('cart.saveSession');

Route::get('/productListCate/{id}', [ListCategoryController::class, 'detailModal']);
Route::get('/products/{id}', [DetailProductController::class, 'getProductDetail']);

// Route::post('/comments', [DetailProductController::class, 'storeComment']);
// Route::post('/reply-comments', [DetailProductController::class, 'storeReply']);
Route::patch('/products/{product}/active', [ProductController::class, 'toggleActive']);

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
        Route::post('/listByUser', [OrderController::class, 'getOrdersByUser'])->name('getOrdersByUser');
        Route::get('/list/count', [OrderController::class, 'countByStatus'])->name('countByStatus');
        Route::post('/updateOrderStatus', [OrderController::class, 'changeStatusOrder'])->name('changeStatusOrder');
        Route::post('/updateOrderStatusWithUserCheck', [OrderController::class, 'updateOrderStatusWithUserCheck'])->name('updateOrderStatusWithUserCheck');
        Route::post('/getOrderStatus', [OrderController::class, 'getOrderOrderByStatus'])->name('getOrderOrderByStatus');
        Route::post('/invoice', [OrderController::class, 'generateInvoiceAll'])->name('generateInvoiceAll');

    });

Route::post('/orders/uploadImgConfirm/{idOrder}', [OrderController::class, 'uploadImgConfirm'])->name('uploadImgConfirm');
Route::post('/orders/invoice/{idOrder}', [OrderController::class, 'generateInvoice'])->name('generateInvoice');
Route::get('/orders/{idOrder}', [OrderController::class, 'getOrderDetail'])->name('getOrderDetail');


Route::get("/payment/list", [PaymentController::class, 'getPaymentList'])->middleware(['guest'])->name('getPaymentList');
Route::get("/listDiscountsByUser/{idUser}", [CouponApiController::class, "listCouponByUser"])->middleware(["guest"])->name("listCouponByUser");
Route::post("/getValueDiscount", [CouponApiController::class, "getValueDiscount"])->middleware(['guest'])->name('getValueDiscount');

Route::post("/createOrder", [OrderCustomerControllerApi::class, "addOrderCustomerAction"])->middleware(['guest']);


Route::prefix('/address')
    ->name('api.address.')
    ->middleware('guest')
    ->group(function () {
        Route::get('/list/{id}', [UserAddressController::class, 'listAddress'])->name('listAddress');
        Route::post('/add-address-user', [UserAddressController::class, 'addAddressUser'])->name('addAddressUser');
        Route::post('/update-address-user', [UserAddressController::class, 'updateAddressUser'])->name('updateAddressUser');
        Route::get('/get-address-edit/{id}', [UserAddressController::class, 'getDataAddress'])->name('getDataAddress');
        Route::get('/get-address-one/{id}', [UserAddressController::class, 'getDataAddressOne'])->name('getDataAddressOne');

    });

Route::prefix('/coupons')
    ->name('coupons.')
    ->controller(CouponController::class)
    ->group(function () {
        Route::post('/update-coupon-status/{id}', 'apiUpdateStatus');
    });

Route::put('/brands/{brand}/status', [BrandController::class, 'update'])->name('updateStatus');



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
        Route::post('/sendOpt', [AuthCustomerApiController::class, "sendOtp"])->name('sendOtp');
        Route::post('/reSendOpt', [AuthCustomerApiController::class, "reSendOpt"])->name('reSendOpt');
        Route::post('/verifyOpt', [AuthCustomerApiController::class, "verifyOpt"])->name('verifyOpt');
        Route::post('/changePassword', [AuthCustomerApiController::class, "changePassword"])->name('changePassword');


        Route::get('/email/verify', function () {
            return view('client.pages.auth.verify-email');
        })->middleware('auth')->name('verification.notice');


        Route::get('/email/verify/{id}', [AuthCustomerApiController::class, 'actionVerifyEmail'])->name('verification.verify');


    });


Route::get('/product/{id}', action: [HomeController::class, 'detailModal']);

Route::prefix('/products')
    ->name('api.products.')
    ->group(function () {
        Route::post('/single', [ProductController::class, 'storeSingle'])->name('storeSingle');
        Route::post('/variant', [ProductController::class, 'storeVariant'])->name('storeVariant');
        Route::put('/single/{id}', [ProductController::class, 'updateSingle'])->name('updateSingle')->where(['id' => '[0-9]+']);
        Route::put('/variant/{id}', [ProductController::class, 'updateVariant'])->name('updateVariant')->where(['id' => '[0-9]+']);
    });

// STOCK
Route::prefix('stocks')
    ->name('api.stocks.')
    ->group(function() {
        Route::post('/import-single', [StockController::class, 'importSingle'])->name('importSingle');
        Route::post('/import-variant', [StockController::class, 'importVariant'])->name('importVariant');
    });
