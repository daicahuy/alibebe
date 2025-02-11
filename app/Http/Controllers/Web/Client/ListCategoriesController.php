<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ListCategoriesController extends Controller
{
    public function index($category = null)
    {
        return view('client.pages.list-categories');
    }
}
