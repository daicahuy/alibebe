<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.pages.reviews.list');
    }

    public function show()
    {
        return view('admin.pages.reviews.show');
    }

    public function update()
    {
        
    }

}
