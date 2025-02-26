<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository extends BaseRepository {
    
    public function getModel()
    {
        return Review::class;
    }
    public function getAllReviews(){
        $start = $this->model->select('id','rating')->get();
        return $start;
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
    

    
    public function getTotalReviews($productId)
    {
        return Review::where('product_id', $productId)
            ->where('is_active', 1)
            ->count();
    }
}