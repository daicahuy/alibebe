<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\HomeService;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    protected $HomeService;

    public function __construct(HomeService $homeService){
        $this->HomeService = $homeService;
    }

    public function detailModal(Request $request, $id)
    {
        // dd($id);
        $product = $this->HomeService->detailModal($id);
        // dd($product);
        if (!$product) {
            return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
        }

        return response()->json($product);
    }
}