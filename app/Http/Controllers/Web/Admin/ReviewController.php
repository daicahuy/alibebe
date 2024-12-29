<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.pages.review.index');
    }
    public function show()
    {
        return view('admin.pages.review.show');
    }
}
