<?php

namespace App\Providers;

use App\Services\Web\Client\CartItemService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('admin.layouts.partials.header', function ($view) {
            $view->with('user', Auth::user());
        });
        // Giúp $user luôn có trong header.blade.php mà không cần truyền từ controller.

        View::composer('client.layouts.partials.header', function ($view) {
            $cartItems = [];

            if (Auth::check()) {
            $cartItemService = app(CartItemService::class); 
            $cartItems = $cartItemService->getAllCartItem();
        }
            $view->with('cartItems', $cartItems);
        });
    }
}
