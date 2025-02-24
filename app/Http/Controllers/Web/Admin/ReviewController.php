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

    public function show(Product $product)
    {
        return view('admin.pages.reviews.show');
    }

    public function update(Request $request, Review $review)
    {
        
    }

}
