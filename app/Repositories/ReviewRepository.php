<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewRepository extends BaseRepository
{

    public function getModel()
    {
        return Review::class;
    }
    public function getAllReviews()
    {
        $start = $this->model->select('rating')->distinct('rating')->orderBy('rating', 'DESC')->get();
        return $start;
    }
    public function getCategoryProductRatings($categoryId)
    {
        return $this->model->select('rating')
            ->distinct('rating')
            ->whereHas('product', function ($query) use ($categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('id', $categoryId);
                });
            })
            ->orderBy('rating', 'DESC')
            ->pluck('rating')
            ->toArray();
    }
    public function getReviewProducts($search = null, $startDate = null, $endDate = null)
    {
        $query = Review::selectRaw('
                product_id,
                COUNT(id) as total_reviews,
                AVG(rating) as average_rating,
                MIN(created_at) as created_at
            ')
            ->where('is_active', 1)
            ->groupBy('product_id');

        // Tìm kiếm theo tên sản phẩm
        if (!empty($search)) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%");
            });
        }

        // Lọc theo ngày
        if (!empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return $query->paginate(10);
    }

    public function getReviewsByProduct($productId, $filters = [])
    {
        $query = Review::where('product_id', $productId)
            ->where('is_active', 1)
            ->with(['user:id,fullname', 'reviewMultimedia:id,review_id,file,file_type']);

        if (!empty($filters['search'])) {
            $query->where('review_text', 'LIKE', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['sort']) && $filters['sort'] == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Debug query SQL
        // dd($query->toSql(), $query->getBindings());

        return $query->get();
    }

    public function createReview(array $data)
    {
        return Review::create($data);
    }

    public function getTotalReviews($productId)
    {
        return Review::where('product_id', $productId)
            ->where('is_active', 1)
            ->count();
    }

    public function userHasPurchasedProduct($userId, $productId)
    {
        return Order::where('user_id', $userId)
            ->whereHas('orderStatuses', function ($query) {
                $query->where('id', 5); // Kiểm tra order_status_id = 5 (Hoàn thành)
            })
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

    public function getLatestReview($productId, $userId)
    {
        return Review::where('product_id', $productId)
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    public function getReviewsByProductId(int $id)
    {
        return Review::where('product_id', $id)->where('is_active', 1)->get();
    }

    // customer detail
    public function getTimeActivity($userId)
    {
        $latestActivity = $this->model->where('user_id', $userId)->latest()->first();
        return $latestActivity;
    }

    public function getReviewByUser($userId)
    {


        // Lấy danh sách các sản phẩm mà người dùng đã đánh giá và thông tin đánh giá gần nhất
        $reviews = Product::whereHas('reviews', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->withCount([
                'reviews' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ])
            ->with([
                'reviews' => function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orderByDesc('created_at');
                    // ->with(['user', 'reviewMultimedia']);
                    // ->limit(1); // Lấy đánh giá gần nhất
                }
            ])
            ->paginate(5, ['*'], 'review_page');
        return $reviews;
    }

    public function countReviewById($userId)
    {

        $user = User::with('reviews')->findOrFail($userId);

        return $user->reviews->count();
    }
}