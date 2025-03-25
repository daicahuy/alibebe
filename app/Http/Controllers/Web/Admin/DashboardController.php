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
        $splineChart = (new Analysis())->getSplineChart();
        $columnChart = (new Analysis())->getColumnChart();
        return view('admin.pages.index', compact('splineChart', 'columnChart'));
    }

    public function indexNhanVien()
    {
        return view('admin.pages.indexNhanVien');
    }
}
