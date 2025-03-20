<?php

namespace App\Services\Web\Client\Account;

use App\Enums\OrderStatusType;
use App\Repositories\ProductRepository;
use App\Repositories\WishlistRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistService
{
    protected WishlistRepository $wishlistRepository;
    protected ProductRepository $productRepository;

    public function __construct(WishlistRepository $wishlistRepository,
    ProductRepository $productRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $wishlist = $this->wishlistRepository->getWishlistForUserLogin();
        return $wishlist;
    }
    public function add($id)
    {
        try {
            $product = $this->productRepository->findById($id);
            $userLogin = Auth::id();
            $data = [
                'user_id' => $userLogin,
                'product_id' => $product->id
            ];
            $this->wishlistRepository->create($data);
            return [
                'status' => true,
                'message' => 'Thêm Thành Công Danh Sách Yêu Thích'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in WishlistService::add", [
                'message' => $th->getMessage(),
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    public function remove($id)
    {
        try {
            $wishlist = $this->wishlistRepository->findById($id);

            if (!$wishlist) {
                return [
                    'status' => false,
                    'message' => 'Không Tìm Thấy !!!'
                ];
            }

            $wishlist->delete();
            return [
                'status' => true,
                'message' => 'Xóa Thành Công Khỏi Danh Sách Yêu Thích'
            ];
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error("Error in WishlistService::remove", [
                'message' => $th->getMessage(),
            ]);

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    public function findWishlistItem($productId) {
        $userLogin = Auth::id();
    
        // Kiểm tra sản phẩm đã có trong wishlist của người dùng hay chưa
        return $this->wishlistRepository->findByUserAndProduct($userLogin, $productId);
    }
    public function count()
{
    return $this->wishlistRepository->countWishlists();
}

}
