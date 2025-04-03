<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function cartCheckout()
    {
        $user = Auth::user();
        $cart = Session::get('selectedProducts', []);

        // dd($cart);
        foreach ($cart as $cartItem) {
            if (!empty($cartItem['product_variant_id'])) {
                // Kiểm tra biến thể sản phẩm
                $variant = ProductVariant::where('id', $cartItem['product_variant_id'])
                    ->where('product_id', $cartItem['product_id'])
                    ->first();
                // dd($variant);
                $product = Product::where('id', $cartItem['product_id'])->first();
                // Lấy stock của biến thể
                $stock = ProductStock::where('product_variant_id', $cartItem['product_variant_id'])->first();
                // Kiểm tra hết hàng
                if (!$stock || $stock->stock == 0) {
                    return back()->with('error', 'Sản phẩm biến thể đã hết hàng.');
                }
                // TH1: Biến thể bị tắt và sản phẩm gốc cũng bị tắt -> Báo lỗi
                if (!$variant || $variant->is_active == 0 || !$product || $product->is_active == 0) {
                    return back()->with('error', 'Sản phẩm biến thể không còn hoạt động.');
                }

                // TH2: Nếu sản phẩm biến thể có sale nhưng giá sale bị thay đổi -> Báo lỗi
                if (!empty($variant->sale_price) && $variant->sale_price > 0) {
                    if ($variant->sale_price != $cartItem['price_variant']) {
                        // dd('123');
                        return back()->with('error', 'Giá khuyến mãi sản phẩm biến thể đã thay đổi, vui lòng kiểm tra lại.');
                    }
                } else {
                    // TH3: Nếu sản phẩm biến thể không có sale nhưng giá price bị thay đổi -> Báo lỗi
                    if ($variant->price != $cartItem['price_variant']) {
                        return back()->with('error', 'Giá sản phẩm biến thể đã thay đổi, vui lòng kiểm tra lại.');
                    }
                }
            } else {
                // Kiểm tra sản phẩm chính (nếu không có biến thể)
                $product = Product::where('id', $cartItem['product_id'])->first();
                $stock = ProductStock::where('product_id', $cartItem['product_id'])->whereNull('product_variant_id')->first();
                if (!$stock || $stock->stock == 0) {
                    return back()->with('error', 'Sản phẩm đã hết hàng.');
                }
                // TH4: Sản phẩm đơn bị tắt -> Báo lỗi
                if (!$product || $product->is_active == 0) {
                    return back()->with('error', 'Sản phẩm không còn hoạt động.');
                }

                if ($product->is_sale != $cartItem['is_sale']) {
                    return back()->with('error', 'Sản phẩm đã thay đổi, vui lòng kiểm tra lại.');
                }

                // TH5: Nếu sản phẩm đơn có sale nhưng giá sale bị thay đổi -> Báo lỗi
                // if ($product->is_sale == 1 && $product->sale_price > 0) {
                //     if ($product->sale_price != $cartItem['price']) {
                //         return back()->with('error', 'Giá khuyến mãi sản phẩm đã thay đổi, vui lòng kiểm tra lại.');
                //     }
                // }
                // if ($product->is_sale == 0 && $product->price > 0) {
                //     // TH6: Nếu sản phẩm đơn không có sale mà giá gốc bị thay đổi -> Báo lỗi
                //     if ($product->price != $cartItem['old_price']) {
                //         return back()->with('error', 'Giá sản phẩm đã thay đổi, vui lòng kiểm tra lại.');
                //     }
                // }
            }
        }

        return view('client.pages.checkout.cart-checkout', compact('user'));
    }

    public function pageSuccessfully()
    {
        return view('client.pages.checkout.page_successfully');
    }
}
