<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Web\Client\DetailProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // dd($detail->review);
        return view('client.pages.detail-product', compact('detail'));
    }
    public function getProductDetail($id)
    {
        $data = $this->detailProductService->detailModal($id);
        return response()->json($data);
    }

    public function store(StoreCommentRequest $request)
    {

        $this->detailProductService->createComment($request->product_id, $request->content);

        return response()->json(['message' => 'Comment created successfully']);
    }

    public function storeReply(StoreReplyRequest $request)
    {

        $this->detailProductService->createReply($request->comment_id, $request->content, $request->reply_user_id);

        return response()->json(['message' => 'Reply created successfully']);
    }

    public function showProductDetails(int $productId)
    {
        $reviews = $this->detailProductService->getProductReviews($productId);
      
        return view('product.details', compact('reviews', ));
    }
    public function storeReview(StoreReviewRequest $request)
    {
        Log::info('storeReview called'); // Thêm log
        $result = $this->detailProductService->createProductReviewWithFiles(
            $request->only(['product_id', 'rating', 'review_text']),
            $request->only(['images', 'videos'])
        );
    
        if (isset($result['success'])) {
            return response()->json(['success' => $result['success']]);
        } else {
            return response()->json(['error' => $result['error']], 400);
        }
    }
}
