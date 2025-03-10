<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartItemRepository extends BaseRepository
{

    public function getModel()
    {
        return CartItem::class;
    }

    public function getAllCartItem()
    {
        return CartItem::with([
            'productVariant.productStock',
            'product.productStock',
            'productVariant.product.productStock',
            'productVariant.attributeValues.attribute'
        ])
        ->where('user_id', auth()->id())
        ->where(function ($query) {
            // Điều kiện cho sản phẩm đơn (không có biến thể)
            $query->whereNull('product_variant_id')
                  ->whereHas('product', function ($q) {
                      $q->where('is_active', 1);
                  })
                  ->whereHas('product.productStock', function ($q) {
                      $q->whereColumn('stock', '>=', 'cart_items.quantity');
                  });
        })
        ->orWhere(function ($query) {
            // Điều kiện cho sản phẩm có biến thể
            $query->whereNotNull('product_variant_id')
                  ->whereHas('product', function ($q) {
                      $q->where('is_active', 1);
                  })
                  ->whereHas('productVariant', function ($q) {
                      $q->where('is_active', 1);
                  })
                  ->whereHas('productVariant.productStock', function ($q) {
                      $q->whereColumn('stock', '>=', 'cart_items.quantity');
                  });
        })
        ->get();
    }
    
    
    
    public function addToCart($data)
    {
        $userId = Auth::id();
    
        // Kiểm tra nếu có `product_id` mà không có `product_variant_id`
        if (!empty($data['product_id']) && empty($data['product_variant_id'])) {
            // Kiểm tra xem sản phẩm này có biến thể không
            $product = Product::with('productVariants')->find($data['product_id']);
    
            if ($product && $product->productVariants->isNotEmpty()) {
                // Nếu sản phẩm có biến thể nhưng chưa chọn, báo lỗi
                return redirect()->back()->with('error', 'Vui lòng chọn phân loại hàng trước khi thêm vào giỏ!');
            }
        }
    
        // Tìm sản phẩm trong giỏ hàng
        $cartItem = CartItem::where('user_id', $userId)
            ->where(function ($query) use ($data) {
                if (!empty($data['product_variant_id'])) {
                    $query->where('product_variant_id', $data['product_variant_id'])->whereNull('product_id');
                } else {
                    $query->where('product_id', $data['product_id'])->whereNull('product_variant_id');
                }
            })
            ->first();
    
        if ($cartItem) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $cartItem->increment('quantity', $data['quantity']);
        } else {
            // Nếu chưa có, tạo mới
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $data['product_id'] ?? null, // Giữ nguyên product_id nếu có
                'product_variant_id' => $data['product_variant_id'] ?? null,
                'quantity' => $data['quantity'],
            ]);
        }
    
        return true; // Thêm thành công
    }
    
    

    public function delete(int $id)
    {
        $cartItem = $this->findById($id);
        
        if ($cartItem) {
            return $cartItem->delete(); 
        }
    }
    

    public function deleteAll(array $ids)
    {
        if (empty($ids)) {
            return false; 
        }
    
        return CartItem::whereIn('id', $ids)->forceDelete();
    }
    
}
