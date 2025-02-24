<?php

namespace App\Http\Controllers\Api;

use ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;

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
    
            // Lấy giá từ quan hệ sản phẩm
            $productPrice = $cartItem->productVariant->sale_price ?? $cartItem->product->price;
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
        $selectedProducts = [];
    
        if (!empty($request->selectedProducts)) {
            foreach ($request->selectedProducts as $product) {
                $selectedProducts[] = [
                    'id' => $product['id'] ?? null, // ID của giỏ hàng
                    'product_id' => $product['product_id'] ?? null,
                    'product_variant_id' => $product['product_variant_id'] ?? null,
                    'name' => $product['name'] ?? 'Sản phẩm không xác định',
                    'name_variant' => isset($product['name_variant']) ? $product['name_variant'] : "Không có biến thể",
                    'image' => $product['image'] ?? asset('default-image.jpg'),
                    'quantity' => $product['quantity'] ?? null, 
                    'quantity_variant' => $product['quantity_variant'] ?? null, 
                    'price' => $product['price'] ?? 0,  
                    'price_variant' => $product['sale_price'] ?? null,
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
    
        return response()->json([
            'message' => 'Không có sản phẩm nào được chọn!',
            'sessionData' => []
        ], 400);
    }
    
    
    
    
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
