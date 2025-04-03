<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Services\Web\Admin\UserCustomerService;
use App\Services\Web\Client\HomeService;
use Illuminate\Http\Request;

class UserController extends ApiBaseController
{
    protected UserCustomerService $userCustomerService;

    public function __construct(UserCustomerService $userCustomerService)
    {
        $this->userCustomerService = $userCustomerService;
    }

    public function detailReview($userId, $productId)
    {

        try {
            // Kiểm tra xem user và product có tồn tại không (tùy chọn nhưng nên có)
            // $user = User::findOrFail($userId);
            // $product = Product::findOrFail($productId); // Giả sử có model Product

            // Lấy các đánh giá của user cụ thể cho sản phẩm cụ thể
            $product = Product::with([
                'reviews' => function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->with(['user', 'reviewMultimedia']);
                },
                'reviews.user',
                'reviews.reviewMultimedia'
            ])->findOrFail($productId);
            // dd($product->reviews);
            return response()->json($product->reviews);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Xử lý nếu user hoặc product không tìm thấy
            return response()->json(['message' => 'Không tìm thấy người dùng hoặc sản phẩm.'], 404);
        } catch (\Exception $e) {
            // Bắt các lỗi khác có thể xảy ra
            // Log lỗi lại để debug
            \Log::error('Lỗi khi lấy review: ' . $e->getMessage());
            return response()->json(['message' => 'Đã xảy ra lỗi khi lấy dữ liệu đánh giá.'], 500);
        }
    }
}

// 