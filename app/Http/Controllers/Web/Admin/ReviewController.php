<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.pages.reviews.list');
    }

    public function show(Product $product)
    {
        return view('admin.pages.reviews.show');
    }

    public function update(Request $request, Review $review)
    {
        
    }

}
