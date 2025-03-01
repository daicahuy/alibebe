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
        $selectedProducts = [];

        if (!empty($request->selectedProducts)) {
            foreach ($request->selectedProducts as $product) {
                // Xử lý ảnh để loại bỏ URL đầy đủ
                $imagePath = $product['image'] ?? 'products/default.jpg';

                if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                    $imagePath = parse_url($imagePath, PHP_URL_PATH); // Lấy phần đường dẫn
                    $imagePath = ltrim(str_replace('/storage/', '', $imagePath), '/'); // Loại bỏ /storage/
                }


                Log::info('Original Image Path: ' . ($product['image'] ?? 'NULL'));
                Log::info('Final Image Path: ' . $imagePath);
                $selectedProducts[] = [
                    'id' => $product['id'] ?? null,
                    'product_id' => $product['product_id'] ?? null,
                    'product_variant_id' => $product['product_variant_id'] ?? null,
                    'name' => $product['name'] ?? 'Sản phẩm không xác định',
                    'name_variant' => $product['name_variant'] ?? "Không có biến thể",
                    'image' => $imagePath,
                    'quantity' => $product['quantity'] ?? null,
                    'quantity_variant' => $product['quantity_variant'] ?? null,
                    'price' => $product['price'] ?? 0,
                    'old_price' => isset($product['old_price']) ? $product['old_price'] : null,
                    'price_variant' => $product['price_variant'] ?? 0,
                    'old_price_variant' => isset($product['old_price_variant']) ? $product['old_price_variant'] : null,
                ];
            }

    // 🔥 XÓA SESSION CŨ TRƯỚC KHI LƯU DỮ LIỆU MỚI
    session()->forget('selectedProducts');

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
