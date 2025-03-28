<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Product;
use App\Services\Web\Client\DetailProductService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListOrderController extends Controller
{
    protected DetailProductService $detailProductService;

    public function __construct(
        DetailProductService $detailProductService,

    ) {
        $this->detailProductService = $detailProductService;
    }
    public function index(Product $product, Request $request)
    {

        $user = Auth::user();
        // $detail = $this->detailProductService->getProductDetail($product->id, ['*']);
        return view('client.pages.list-order-user', compact('user',));
    }
    public function storeReview(StoreReviewRequest $request)
    {
        Log::info('storeReview called');
        $result = $this->detailProductService->createProductReviewWithFiles(
            $request->only(['product_id', 'rating', 'review_text', 'order_id']),
            $request->only(['images', 'videos'])
        );

        if (isset($result['success'])) {
            return response()->json(['success' => $result['success']]);
        } else {
            return response()->json(['error' => $result['error']], 400);
        }
    }
}
