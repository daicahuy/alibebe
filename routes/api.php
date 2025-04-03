<?php

use App\Http\Controllers\api\ApiRefundOrderController;
use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\AttributeValueController;
use App\Http\Controllers\api\AuthCustomerApiController;
use App\Http\Controllers\api\AuthCustomerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompareController;
use App\Http\Controllers\api\CouponApiController;
use App\Http\Controllers\Api\CustomerDetailController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\api\OrderCustomerControllerApi;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\PaymentOnlineController;
use App\Http\Controllers\api\UserAddressController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Web\Admin\CouponController;
use App\Http\Controllers\Api\ListCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\ChatClientController;
use App\Http\Controllers\Web\Admin\AccountController;
use App\Http\Controllers\Web\Admin\CommentController;
use App\Http\Controllers\Web\Client\AccountController as ClientAccountController;
use App\Http\Controllers\Web\Client\DetailProductController;
use App\Http\Controllers\Web\Client\HomeController as ClientHomeController;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
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


Route::get('/search/suggestions', [ClientHomeController::class, 'getSuggestions']);
// Route for searching users
Route::get('admin/chats/search-users', [ChatController::class, 'searchUsers'])
    ->name('api.admin.chats.search-users');

// Route for starting a new chat with a user
Route::get('admin/chats/start-chat', [ChatController::class, 'startChat'])
    ->name('admin.chats.start-chat');

Route::prefix('client/chat')
    ->group(function () {
        Route::get('/session', [ChatClientController::class, 'getSession']);
        Route::post('/messages', [ChatClientController::class, 'sendMessage']);
        Route::get('/messages', [ChatClientController::class, 'getMessages']);
    });


Route::post('/cart/update', [CartItemController::class, 'update'])->middleware('web')->name('cart.update');
Route::post('/cart/save-session', [CartItemController::class, 'saveSession'])->middleware('web')->name('cart.saveSession');
Route::get('/comments/{commentId}/replies', [CommentController::class, 'getCommentReplies'])->name('comments.replies');
Route::delete('/comments/{id}', [CommentController::class, 'deleteComment'])->name('comments.delete');
Route::delete('/comment-replies/{id}', [CommentController::class, 'deleteReply'])->name('comment-replies.delete');

Route::get('/productListCate/{id}', [ListCategoryController::class, 'detailModal']);
Route::get('/products/{id}', [DetailProductController::class, 'getProductDetail']);

// Route::post('/comments', [DetailProductController::class, 'storeComment']);
// Route::post('/reply-comments', [DetailProductController::class, 'storeReply']);
// Route::patch('/products/{product}/active', [ProductController::class, 'toggleActive']);

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


Route::prefix('/refund-orders')
    ->name('api.refund_orders.')
    ->group(function () {
        Route::get('/list', [ApiRefundOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [ApiRefundOrderController::class, 'getDataOrderRefund'])->name('getDataOrderRefund');
        Route::get('/list/countPending', [ApiRefundOrderController::class, 'countPending'])->name('countPending');
        Route::post('/changeStatus', [ApiRefundOrderController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/changeStatusCancelOrder', [ApiRefundOrderController::class, 'changeStatusCancelOrder'])->name('changeStatusCancelOrder');
        Route::post('/changeStatusWithImg', [ApiRefundOrderController::class, 'changeStatusWithImg'])->name('changeStatusWithImg');
        Route::post('/createOrderRefund', [ApiRefundOrderController::class, 'createOrderRefund'])->name('createOrderRefund');
        Route::post('/getOrdersRefundByUser', [ApiRefundOrderController::class, 'getOrdersRefundByUser'])->name('getOrdersRefundByUser');
        Route::post('/sentConfirmBank', [ApiRefundOrderController::class, 'sentConfirmBank'])->name('sentConfirmBank');
        Route::post('/confirmBank', [ApiRefundOrderController::class, 'confirmBank'])->name('confirmBank');
        Route::post('/userCheckReceivedBank', [ApiRefundOrderController::class, 'userCheckReceivedBank'])->name('userCheckReceivedBank');
    });

Route::prefix('/orders')
    ->name('api.orders.')
    ->group(function () {

        Route::get('/list', [OrderController::class, 'index'])->name('index');
        Route::post('/listByUser', [OrderController::class, 'getOrdersByUser'])->name('getOrdersByUser');
        Route::get('/list/count', [OrderController::class, 'countByStatus'])->name('countByStatus');
        Route::get('/list/countPending', [OrderController::class, 'countPending'])->name('countPending');
        Route::post('/updateOrderStatus', [OrderController::class, 'changeStatusOrder'])->name('changeStatusOrder');
        Route::post('/updateOrderStatusWithUserCheck', [OrderController::class, 'updateOrderStatusWithUserCheck'])->name('updateOrderStatusWithUserCheck');
        Route::post('/getOrderStatus', [OrderController::class, 'getOrderOrderByStatus'])->name('getOrderOrderByStatus');
        Route::post('/invoice', [OrderController::class, 'generateInvoiceAll'])->name('generateInvoiceAll');
        Route::post('changeStatusRefundMoney', [OrderController::class, 'changeStatusRefundMoney'])->name('changeStatusRefundMoney');
        Route::post('userCheckRefundMoney', [OrderController::class, 'userCheckRefundMoney'])->name('userCheckRefundMoney');
    });


Route::post('/orders/uploadImgConfirm/{idOrder}', [OrderController::class, 'uploadImgConfirm'])->name('uploadImgConfirm');
Route::post('/orders/invoice/{idOrder}', [OrderController::class, 'generateInvoice'])->name('generateInvoice');
Route::get('/orders/{idOrder}', [OrderController::class, 'getOrderDetail'])->name('getOrderDetail');
Route::get('/orders/getOrder/{idOrder}', [OrderController::class, 'getOrder'])->name('getOrder');


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
        Route::get('/', [ProductController::class, 'getAll'])->name('getAll');
        Route::post('/single', [ProductController::class, 'storeSingle'])->name('storeSingle');
        Route::post('/variant', [ProductController::class, 'storeVariant'])->name('storeVariant');
        Route::put('/single/{id}', [ProductController::class, 'updateSingle'])->name('updateSingle')->where(['id' => '[0-9]+']);
        Route::put('/variant/{id}', [ProductController::class, 'updateVariant'])->name('updateVariant')->where(['id' => '[0-9]+']);
        Route::patch('/{id}/active', [ProductController::class, 'toggleActive'])->name('toggleActive')->where(['id' => '[0-9]+']);
        ;
    });

// STOCK
Route::prefix('stocks')
    ->name('api.stocks.')
    ->group(function () {
        Route::post('/import', [StockController::class, 'importStock'])->name('importStock');
    });

// compare
Route::prefix('compare')
    ->name('api.compare.')
    // ->middleware(StartSession::class)
    ->group(function () {
        Route::post('/add-with-check/{productId}', [CompareController::class, 'addTocompareWithCheck'])->name('add.with.check');
        Route::get('/compareDetail/{id}', [CompareController::class, 'detailModal']);
    });

// customer detail
Route::prefix('user/{userId}')
    ->name('api.user.')
    ->group(function () {
        Route::get('/products/{productId}/reviews', [UserController::class, 'detailReview'])->name('reviews');
    });
