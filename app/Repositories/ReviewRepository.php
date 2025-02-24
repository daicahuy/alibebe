<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository extends BaseRepository {
    
    public function getModel()
    {
        return Review::class;
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
}