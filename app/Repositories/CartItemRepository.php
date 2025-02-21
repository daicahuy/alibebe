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
            'productVariant.product',
            'productVariant.attributeValues.attribute'
        ])->where('user_id', auth()->id())->get();
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
                'product_id' => empty($data['product_variant_id']) ? $data['product_id'] : null,
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
    

    // public function deleteAll(array $ids)
    // {
    //     $cartItems = CartItem::whereIn('id', $ids)->get();
    //     $cartItemIds = [];

    //     // Kiểm tra các thuộc tính bị ràng buộc
    //     foreach ($cartItems as $cartItem) {
    //         // Kiểm tra liên kết trong bảng attribute_values
    //         if ($cartItem->attributeValues()->exists()) {
    //             $attributeIds[] = $attribute->id;
    //         }
    //     }
    //     // Loại bỏ các giá trị trùng lặp
    //     $attributeIds = array_unique($attributeIds);

    //     // Nếu có thuộc tính không thể xóa, tạo thông báo lỗi
    //     if (!empty($attributeIds)) {
    //         $attributeIdsList = implode(', ', $attributeIds);
    //         throw new \Exception("Không thể xóa thuộc tính {$attributeIdsList} vì giá trị thuộc tính đang được sử dụng.");
    //     }

    //     return Attribute::whereIn('id', $ids)->forceDelete();
    // }
}
