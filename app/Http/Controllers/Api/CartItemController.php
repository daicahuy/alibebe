<?php

namespace App\Http\Controllers\Api;

use ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartItemController extends Controller
{
    // protected ApiBaseController $apiBaseController;
    // public function __construct(ApiBaseController $apiBaseController)
    // {
    //     $this->apiBaseController = $apiBaseController;
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $cartItem = CartItem::findOrFail($request->id);
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Kiểm tra sản phẩm có biến thể hay không
            if ($cartItem->productVariant) {
                // Nếu có biến thể, ưu tiên sale_price, nếu null thì lấy price
                $productPrice = $cartItem->productVariant->sale_price ?? $cartItem->productVariant->price;
            } else {
                // Nếu không có biến thể, ưu tiên sale_price của sản phẩm, nếu null thì lấy price
                $productPrice = $cartItem->product->sale_price ?? $cartItem->product->price;
            }

            // Tính tổng tiền sản phẩm này
            $newSubtotal = number_format($cartItem->quantity * $productPrice, 0, ',', '.') . 'đ';

            return response()->json([
                'success' => true,
                'newSubtotal' => $newSubtotal
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }




    public function saveSession(Request $request)
    {
        if (empty($request->selectedProducts)) {
            session()->forget('selectedProducts');
            session()->forget('total');
            session()->forget('cartHeader'); // ❗ Xóa session DropCart khi vào thanh toán
    
            return response()->json([
                'message' => 'Giỏ hàng trống, session đã được xoá!',
                'sessionData' => session('selectedProducts', []),
                'total' => session('total', 0)
            ]);
        }
    
        session()->forget('selectedProducts'); // ❗ Xóa session cũ trước khi lưu mới
        session()->forget('cartHeader'); // ❗ Đảm bảo DropCart không còn dữ liệu
    
        $selectedProducts = [];
    
        foreach ($request->selectedProducts as $product) {
            $selectedProducts[] = [
                'id' => $product['id'] ?? null,
                'product_id' => $product['product_id'] ?? null,
                'product_variant_id' => $product['product_variant_id'] ?? null,
                'name' => $product['name'] ?? 'Sản phẩm không xác định',
                'name_variant' => $product['name_variant'] ?? "Không có biến thể",
                'image' => $product['image'] ?? 'products/default.jpg',
                'quantity' => $product['quantity'] ?? null,
                'quantity_variant' => $product['quantity_variant'] ?? null,
                'price' => $product['price'] ?? 0,
                'old_price' => isset($product['old_price']) ? $product['old_price'] : null,
                'price_variant' => $product['price_variant'] ?? 0,
                'old_price_variant' => isset($product['old_price_variant']) ? $product['old_price_variant'] : null,
            ];
        }
    
        session(['selectedProducts' => $selectedProducts]);
        session(['totalPrice' => $request->total ?? 0]);
    
        return response()->json([
            'message' => 'Giỏ hàng đã được lưu vào session!',
            'sessionData' => session('selectedProducts'),
            'total' => session('totalPrice')
        ]);
    }
    

    













    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
