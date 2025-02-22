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
            $productPrice = $cartItem->productVariant->price ?? $cartItem->product->price;
            $newSubtotal = number_format($cartItem->quantity * $productPrice, 0, ',', '.') . 'đ';
    
            return response()->json([
                'success' => true,
                'newSubtotal' => $newSubtotal
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
