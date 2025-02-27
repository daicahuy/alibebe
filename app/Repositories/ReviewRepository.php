<?php

namespace App\Repositories;

use App\Models\Order;
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

    public function createReview(array $data)
    {
        return Review::create($data);
    }
    
    public function userHasPurchasedProduct($userId, $productId)
    {
        return Order::where('user_id', $userId)
            ->where('is_paid', 1)
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
}