<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\WishlistRepository;
use App\Services\Web\Client\DetailProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{

    protected DetailProductService $detailProductService;
    protected WishlistRepository $wishlistRepository;
    public function __construct(
        DetailProductService $detailProductService,
        WishlistRepository $wishlistRepository,
    ) {
        $this->detailProductService = $detailProductService;
        $this->wishlistRepository = $wishlistRepository;
    }
    public function index(Product $product, Request $request)
    {
        $detail = $this->detailProductService->getProductDetail($product->id, ['*']);
        $wishlistProductIds = $this->wishlistRepository->getWishlistForUserLogin()
            ->pluck('product_id')
            ->toArray();

        $purchaseReviewStatus = ['hasPurchased' => false, 'canReview' => false, 'reviewPeriodExpired' => true, 'eligibleOrderIds' => true];
        if (Auth::check()) {
            $orderIdFromParam = $request->query('order_id'); // Lấy order_id từ query parameter
            $purchaseReviewStatus = $this->detailProductService->checkPurchaseAndReviewStatus($product, Auth::id(), $orderIdFromParam); // Truyền orderId này vào service
        }

        return view('client.pages.detail-product', compact('detail', 'wishlistProductIds', 'purchaseReviewStatus'));
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

        return view('product.details', compact('reviews',));
    }
    public function storeReview(StoreReviewRequest $request)
    {
        Log::info('storeReview called'); // Thêm log
        $result = $this->detailProductService->createProductReviewWithFiles(
            $request->only(['product_id', 'rating', 'review_text', 'order_id']), // Include order_id
            $request->only(['images', 'videos'])
        );

        if (isset($result['success'])) {
            return response()->json(['success' => $result['success']]);
        } else {
            return response()->json(['error' => $result['error']], 400);
        }
    }
}
