<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\CartItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
    protected $cartItemService;
    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }
    public function index()
    {
        $data = $this->cartItemService->getAllCartItem();
        // $productVariant = $this->cartItemService->getProductVariant(); 

        // dd($data);
        return view('client.pages.cart-item', compact('data'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);
    
        // Nếu là sản phẩm biến thể, lấy product_id từ bảng product_variants
        if (!empty($data['product_variant_id'])) {
            $productId = DB::table('product_variants')
                ->where('id', $data['product_variant_id'])
                ->value('product_id');
        } else {
            $productId = $data['product_id'];
        }
    
        // ✅ Kiểm tra tồn kho từ bảng product_stocks
        $stockQuery = DB::table('product_stocks');
        
        if (!empty($data['product_variant_id'])) {
            // Nếu là biến thể, kiểm tra stock theo `product_variant_id`
            $stockQuery->where('product_variant_id', $data['product_variant_id']);
        } else {
            // Nếu là sản phẩm đơn, kiểm tra stock theo `product_id`
            $stockQuery->where('product_id', $productId);
        }
    
        $stock = $stockQuery->value('stock');
    
        // ❌ Nếu không có tồn kho hoặc số lượng mua lớn hơn stock
        if (!$stock || $stock < $data['quantity']) {
            return redirect()->back()->with('error', 'Sản phẩm không đủ hàng trong kho!');
        }
    
        // ✅ Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartQuery = DB::table('cart_items')
            ->where('user_id', auth()->id()) // Thay thế bằng session ID nếu không dùng auth
            ->where('product_id', $productId);
    
        if (!empty($data['product_variant_id'])) {
            // Nếu có biến thể, kiểm tra theo `product_variant_id`
            $cartQuery->where('product_variant_id', $data['product_variant_id']);
        }
    
        $existingCartItem = $cartQuery->first();
    
        if ($existingCartItem) {
            // ✅ Nếu đã có trong giỏ hàng, cập nhật số lượng
            $newQuantity = $existingCartItem->quantity + $data['quantity'];
    
            if ($newQuantity > $stock) {
                return redirect()->back()->with('error', 'Không thể thêm số lượng lớn hơn tồn kho!');
            }
    
            DB::table('cart_items')
                ->where('id', $existingCartItem->id)
                ->update(['quantity' => $newQuantity]);
        } else {
            // ✅ Nếu chưa có trong giỏ hàng, thêm sản phẩm mới
            DB::table('cart_items')->insert([
                'user_id' => auth()->id(), // Thay bằng session ID nếu cần
                'product_id' => $productId,
                'product_variant_id' => $data['product_variant_id'] ?? null,
                'quantity' => $data['quantity'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    



    public function delete(Request $request)
    {
        $id = $request->input('id');
        $ids = $request->input('ids', []);
        // dd($ids);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_map('intval', (array) $ids);

        if ($id) {
            $this->cartItemService->delete($id);
        } elseif (!empty($ids)) {
            $this->cartItemService->deleteAll($ids);
        } else {
            return back()->with('error', 'Không có sản phẩm nào để xóa.');
        }

        return back()->with('success', 'Xóa thành công!');
    }

    public function countCart()
    {
        $data = $this->cartItemService->getAllCartItem();
        return response()->json([
            'code' => 200,
            'data' => $data
        ]);
    }
}
