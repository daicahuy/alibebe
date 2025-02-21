<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Web\Client\DetailProductService;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{

    protected DetailProductService $detailProductService;
    public function __construct(DetailProductService $detailProductService)
    {
        $this->detailProductService = $detailProductService;
    }
    public function index(Product $product)
    {
        $detail = $this->detailProductService->getProductDetail($product->id, ['*']);

        return view('client.pages.detail-product', compact('detail'));
    }
    public function getProductDetail($id)
    {
        $data = $this->detailProductService->detailModal($id);
        return response()->json($data);
    }


}
