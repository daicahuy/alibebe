<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Charts\Analysis;

class DashboardController extends Controller
{
    public function index()
    {
        $chart = new Analysis(); // Khởi tạo biểu đồ mẫu
        return view('admin.pages.index', compact('chart'));
    }

    public function index2()
    {
        return view('admin.pages.index2');
    }
}
