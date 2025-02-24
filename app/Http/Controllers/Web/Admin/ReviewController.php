<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Services\Web\Admin\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService) {
        $this->reviewService = $reviewService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $reviewsWithProduct = $this->reviewService->getReviewsWithProduct($search, $startDate, $endDate);
        
        return view('admin.pages.reviews.list',compact('reviewsWithProduct','search','startDate','endDate'));
    }

    public function show(Product $product, Request $request)
{
    // Nhận dữ liệu từ request để lọc
    $filters = [
        'search'    => $request->input('search'),
        'rating'    => $request->input('rating'),
        'date_from' => $request->input('date_from'),
        'date_to'   => $request->input('date_to'),
        'sort'      => $request->input('sort'),
    ];
    $reviews = $this->reviewService->getReviewByProduct($product->id, $filters);
    $totalReviews = $this->reviewService->getTotalReview($product->id);

    return view('admin.pages.reviews.show', compact('product', 'reviews', 'totalReviews'));
}

}
