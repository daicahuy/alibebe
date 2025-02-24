<?php

namespace App\Services\Web\Admin;

use App\Repositories\ReviewRepository;

class ReviewService
{
    protected $reviewRepository;
    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }
    public function getReviewsWithProduct($search, $startDate, $endDate)
    {
        return $this->reviewRepository->getReviewProducts($search, $startDate, $endDate);
    }

    public function getReviewByProduct($productId, $filters = [])
    {
        $reviews = $this->reviewRepository->getReviewsByProduct($productId, $filters);
        return $reviews;
    }

    public function getTotalReview($productId)
    {
        return $this->reviewRepository->getTotalReviews($productId);
    }
}
