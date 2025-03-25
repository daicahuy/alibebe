<?php

use App\Http\Controllers\api\PaymentOnlineController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\Api\CartItemController as ApiCartItemController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Web\Admin\AccountController;
use App\Http\Controllers\Web\Admin\AttributeController;
use App\Http\Controllers\Web\Admin\AttributeValueController;
use App\Http\Controllers\Web\Admin\BrandController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\CommentController;
use App\Http\Controllers\Web\Admin\CouponController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\InventoryController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\web\admin\OrderRefundController;
use App\Http\Controllers\Web\Admin\ProductController;
use App\Http\Controllers\Web\Admin\ReviewController;
use App\Http\Controllers\Web\Admin\TagController;
use App\Http\Controllers\Web\Auth\AuthAdminController;
use App\Http\Controllers\Web\Auth\AuthCustomerController;
use App\Http\Controllers\Web\Client\CheckoutController;
use App\Http\Controllers\Web\Client\CompareController;
use App\Http\Controllers\Web\Client\DetailProductController;
use App\Http\Controllers\Web\Client\HomeController;
use App\Http\Controllers\Web\Client\ListCategoriesController;
use App\Http\Controllers\Web\Admin\UserCustomerController;
use App\Http\Controllers\Web\Admin\UserEmployeeController;

use App\Http\Controllers\Web\Client\ListOrderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\Client\CartItemController;
use App\Http\Controllers\Web\Client\AccountController as AccountClientController;
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
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/categories/{slug?}', [ListCategoriesController::class, 'index'])->name('categories');
Route::get('/compare', [CompareController::class, 'getComparedProducts'])->name('compare.page');
Route::post('/compare/remove-product/{productId}', [CompareController::class, 'removeProduct'])->name('compare.removeProduct');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage']);
Route::get('/products/{product}', [DetailProductController::class, 'index'])->name('products');
Route::get('/cart-checkout', [CheckoutController::class, 'cartCheckout'])->middleware(['auth'])->name('cartCheckout');
Route::get('/list-order', [ListOrderController::class, 'index'])->middleware(['auth'])->name('listOrder');

Route::post('/payment/vnpay', [VNPayController::class, 'createPayment'])->middleware(["web"])->name('vnpay.create');
Route::get('/payment/vnpay/return', [VNPayController::class, 'handleReturn'])->middleware(["web"])->name('vnpay.return');

Route::get('/page_successfully', function () {
    return view('client.pages.checkout.page-successfully');
})->name('thankyou.page');

Route::get('/page_successfully', [CheckoutController::class, 'pageSuccessfully'])->middleware(['auth'])->name('pageSuccessfully');
Route::get('/cart', [CartItemController::class, 'index'])->name('cart')->middleware('auth');
Route::post('/cart/add', [CartItemController::class, 'addToCart'])->name('cart.add')->middleware('auth');
;
Route::delete('/cart/delete', [CartItemController::class, 'delete'])->name('cart.delete');


Route::post('/cart/count', [CartItemController::class, 'countCart'])->name('cart.count');

Route::post('/comments', [DetailProductController::class, 'store'])->middleware('auth');
Route::post('/comment-replies', [DetailProductController::class, 'storeReply'])->middleware('auth');

Route::post('/reviewsSp', [DetailProductController::class, 'storeReview'])->name('reviewsSp.store')->middleware('auth');

Route::get('/hoanhang', [ApiOrderController::class, 'hoanhang'])->name('hoanhang');

Route::name('account.')
    ->middleware(['auth'])
    ->prefix('account')
    ->controller(AccountClientController::class)
    ->group(function () {
        //profile
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/update-infomation', 'updateBasicInfomation')->name('update-infomation');
        Route::patch('/update-image', 'updateImage')->name('update-image');
        Route::patch('/update-password', 'updatePassword')->name('update-password');

        //address
        Route::get('/address', 'address')->name('address');
        Route::post('/store-address', 'storeAddress')->name('store-address');
        Route::put('/update-default-address', 'updateDefaultAddress')->name('update-default-address');
        Route::put('/update-address/{id}', 'updateAddress')->name('update-address');
        Route::delete('/delete-address/{id}', 'deleteAddress')->name('account.delete-address');

        //coupon
        Route::get('/coupon', 'coupon')->name('coupon');

        //dashboard
        Route::get('/', 'dashboard')->name('dashboard');

        //order
        Route::get('/order-history', 'order')->name('order-history');
        Route::get('/order-history/{id}', 'orderHistoryDetail')->name('order-history-detail');

        //wishlist
        Route::get('/wishlist', 'wishlist')->name('wishlist');
        Route::post('/wishlist/toggle/{id}', 'toggleWishlist')->name('wishlist-toggle');
        Route::delete('/remove-wishlist/{id}', 'removeWishlist')->name('remove-wishlist');
        Route::get('/wishlist/count', 'wishlistCount')->name('wishlist.count');

    });

/*--------------AUTHENTICATION--------------*/




Route::get('/email/verify/{id}', [AuthCustomerController::class, 'actionVerifyEmail'])->middleware(['checknotLogin'])->name('auth.verification.verify');


Route::name('auth.')
    ->group(function () {


        Route::name('customer.')
            ->middleware(["guest"])
            ->controller(AuthCustomerController::class)
            ->group(function () {

                Route::get('/login', 'showFormLogin')->name('showFormLogin');
                Route::get('/register', 'showFormRegister')->name('showFormRegister');
                Route::get('/forgot-password', 'showFormForgotPassword')->name('showFormForgotPassword');
                Route::get('/otp', 'showFormOtp')->name('showFormOtp');
                Route::get('/new-password', 'showFormNewPassword')->name('showFormNewPassword');
            });


        Route::name('admin.')
            ->prefix('admin')
            ->controller(AuthAdminController::class)
            ->group(function () {


                Route::get('/login', 'showFormLogin')->name('showFormLogin')->middleware(['isAdmin']);
                Route::get('/logout', 'logout')->name('logout');
                Route::post('/handle', 'handleLogin')->name('handleLogin');
                Route::get('/register', 'showFormRegister')->name('showFormRegister');
                Route::get('/forgot-password', 'showFormForgotPassword')->name('showFormForgotPassword');
                Route::post('/send-otp', 'sendOtp')->name('sendOtp');
                Route::get('/otp', 'showFormOtp')->name('showFormOtp')->middleware('check.reset.flow');
                Route::post('/resend-otp', 'resendOtp')->name('resendOtp');

                Route::post('/verify-otp', 'verifyOtp')->name('verifyOtp');
                Route::get('/new-password', 'showFormNewPassword')->name('showFormNewPassword')->middleware('check.reset.flow');
                ;
                Route::post('/update-password', 'updatePassword')->name('updatePassword')->middleware('check.reset.flow');
                ;
            });
    });

/*--------------ADMIN--------------*/

Route::prefix('/admin')
    ->name('admin.')
    ->middleware(['isAdmin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/nhanvien', [DashboardController::class, 'indexNhanVien'])->name('indexNhanVien');


        Route::prefix('/chats')
            ->name('chats.')
            ->controller(ChatController::class)
            ->group(function () {
                // Hiển thị danh sách tất cả các phiên chat
                Route::get('/', 'index')->name('index');

                // Hiển thị danh sách chat đã đóng
                Route::get('/closed', 'closed')->name('closed');

                // Hiển thị một phiên chat cụ thể
                Route::get('/chat-session/{id}', 'show')->name('chat-session');

                // Gửi tin nhắn trong phiên chat
                Route::post('/chat-session/{id}/send', 'sendMessage')->name('send-message');

                // Đóng phiên chat
                Route::patch('/chat-session/{id}/close', 'closeChat')->name('close-chat-session');

                // Mở Phiên chat
                Route::patch('/chat-session/{id}/reopen', 'reOpenChat')->name('restore-chat-session');

                Route::delete('/chat-sesson/{id}/force-delete','forceDelete')->name('force-delete');
                
                //admin.chats.start-chat
                Route::post('/chat-session/start', 'startChat')->name('start-chat');
            });


        Route::prefix('/account')
            ->name('account.')
            ->controller(AccountController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::put('/{user}/update-provider', 'updateProvider')->name('updateProvider');

                Route::put('/{user}/update-password', 'updatePassword')->name('updatePassword');
            });



        // CATEGORIES
        Route::prefix('/categories')
            ->name('categories.')
            ->controller(CategoryController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/trash', 'trash')->name('trash');

            Route::get('/hidden', 'hidden')->name('hidden');

            Route::get('/{category}', 'show')->name('show')->where(['category' => '[0-9]+']);

            Route::get('/create', 'create')->name('create');

            Route::post('/', 'store')->name('store');

            Route::get('/edit/{category}', 'edit')->name('edit');

            Route::put('/{category}', 'update')->name('update')->where(['category' => '[0-9]+']);

            Route::put('/{category}/restore', 'restore')->name('restore');

            Route::delete('{category}/delete', 'delete')->name('delete');

            Route::delete('/{category}', 'destroy')->name('destroy');


            // bulk
            Route::post('/bulk-restore', 'bulkRestore')->name('bulkRestore');

            Route::post('/bulk-destroy', 'bulkDestroy')->name('bulkDestroy');

            Route::post('/bulk-trash', 'bulkTrash')->name('bulkTrash');

            // search
            route::get('/search', 'search')->name('search');
        });



        // PRODUCTS
        Route::prefix('/products')
            ->name('products.')
            ->controller(ProductController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/trash', 'trash')->name('trash');

            Route::get('/show/{slug}', 'show')->name('show');

            Route::get('/hidden', 'hidden')->name('hidden');

            Route::get('/create', 'create')->name('create');

            Route::post('/', 'store')->name('store');

            Route::get('/edit/{slug}', 'edit')->name('edit');

            Route::put('/{product}', 'update')->name('update');

            Route::put('/restore/{product}', 'restore')->name('restore');

            Route::delete('/delete/{product}', 'delete')->name('delete');

            Route::delete('/destroy/{product}', 'destroy')->name('destroy');

            //Bulk
            Route::post('/bulk-trash', 'bulkTrash')->name('bulkTrash');

            Route::post('/bulk-restore', 'bulkRestore')->name('bulkRestore');

            Route::post('/bulk-destroy', 'bulkDestroy')->name('bulkDestroy');
        });

        // INVENTORY
        Route::prefix('/inventory')
            ->name('inventory.')
            ->controller(InventoryController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/history', 'history')->name('history');

        });

        // ATTRIBUTES
        Route::prefix('/attributes')
            ->name('attributes.')
            ->controller(AttributeController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/hidden', 'hidden')->name('hidden');

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
                ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::get('/hidden', 'hidden')->name('hidden');

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
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/hidden', 'hidden')->name('hidden');

            Route::get('/brands/{brand}/products', 'showProduct')->name('showProduct');

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
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/create', 'create')->name('create');

            Route::get('/{tag}/products', 'showProducts')->name('showProducts');

            Route::post('/', 'store')->name('store');

            Route::get('/edit/{tag}', 'edit')->name('edit');

            Route::put('/{tag}', 'update')->name('update');

            Route::delete('/destroy', 'destroy')->name('destroy');
        });

        Route::prefix('/orderRefund')
            ->name('orderRefund.')
            ->controller(OrderRefundController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');
            });

        Route::prefix('/orders')
            ->name('orders.')
            ->controller(OrderController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');
                Route::get('/', 'index')->name('index');

                Route::get('/{order}', 'show')->name('show')->where(['order' => '[0-9]+']);
                Route::get('/{order}', 'show')->name('show')->where(['order' => '[0-9]+']);

                Route::put('/{order}', 'update')->name('update');
            });





        // USERS
        Route::prefix('/users')
            ->name('users.')
            ->group(function () {

            Route::prefix('/customer')
                ->name('customer.')
                ->controller(UserCustomerController::class)
                ->group(function () {

                    Route::get('/', 'index')->name('index');

                    Route::post('/', 'store')->name('store');

                    Route::get('/show/{user}', 'show')->name('show');

                    Route::get('/edit/{user}', 'edit')->name('edit');

                    Route::put('/update/{user}', 'update')->name('update');

                    Route::get('/lock', 'lock')->name('lock');

                    Route::put('/lockUser/{user}', 'lockUser')->name('lockUser');

                    Route::post('lock-multiple', 'lockMultipleUsers')->name('lockMultipleUsers');

                    Route::post('unLock-multiple', 'unLockMultipleUsers')->name('unLockMultipleUsers');

                    Route::post('update-status', 'updateStatus')->name('update-status');
                });

            Route::prefix('/employee')
                ->name('employee.')
                ->controller(UserEmployeeController::class)
                ->group(function () {

                    Route::get('/', 'index')->name('index');

                    Route::get('/create', 'create')->name('create');

                    Route::post('/', 'store')->name('store');

                    Route::get('/show/{user}', 'show')->name('show');

                    Route::get('/edit/{user}', 'edit')->name('edit');

                    Route::put('/update/{user}', 'update')->name('update');

                    Route::get('/lock', 'lock')->name('lock');

                    Route::put('/lockUser/{user}', 'lockUser')->name('lockUser');

                    Route::post('lock-multiple', 'lockMultipleUsers')->name('lockMultipleUsers');

                    Route::post('unLock-multiple', 'unLockMultipleUsers')->name('unLockMultipleUsers');

                    Route::post('update-status', 'updateStatus')->name('update-status');
                });
        });


        // REVIEWS
        Route::prefix('/reviews')
            ->name('reviews.')
            ->controller(ReviewController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/{product}', 'show')->name('show')->where(['product' => '[a-zA-Z0-9-_]+']);
        });


        // Comments
        Route::prefix('/comments')
            ->name('comments.')
            ->controller(CommentController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::get('/{product}', 'show')->name('show');

                Route::get('/comments/{commentId}/replies', 'getCommentReplies')->name('comments.replies');
        });


        // COUPONS
        Route::prefix('/coupons')
            ->name('coupons.')
            ->controller(CouponController::class)
            ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/hide', 'hide')->name('hide');

            Route::get('/{coupon}', 'show')->name('show')->where(['coupon' => '[0-9]+']);

            Route::get('/create', 'create')->name('create');

            Route::post('/', 'store')->name('store');

            Route::get('/edit/{coupon}', 'edit')->name('edit')->middleware(['check.coupon.usage']);

            Route::put('/{coupon}', 'update')->name('update');

            Route::delete('/{coupon}/destroy', 'destroy')->name('destroy');

            Route::get('/trash', 'trash')->name('trash');

            Route::post('/{coupon}/restore', 'restore')->name('restore');

            Route::post('/restore-selected', 'restoreSelected')->name('restore-selected');

            Route::delete('/{coupon}/force-destroy', 'forceDestroy')->name('force-destroy');

            Route::delete('/destroy-selected', 'destroySelected')->name('destroy-selected');

            Route::delete('/force-destroy-selected', 'forceDestroySelected')->name('force-destroy-selected');

            Route::get('/search', 'searchCoupon')->name('search');
        });
    });
