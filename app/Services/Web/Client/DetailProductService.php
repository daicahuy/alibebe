<?php

namespace App\Services\Web\Client;

use App\Models\OrderItem;
use App\Repositories\CommentReplyRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Repositories\CommentRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ReviewRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DetailProductService
{
    protected $productRepository;
    protected $commentRepository;
    protected $commentReplyRepository;
    protected $reviewRepository;
    public function __construct(
        ProductRepository $productRepository,
        CommentRepository $commentRepository,
        CommentReplyRepository $commentReplyRepository,
        ReviewRepository $reviewRepository

        )
    {
        $this->productRepository = $productRepository;
        $this->commentRepository = $commentRepository;
        $this->commentReplyRepository = $commentReplyRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function getProductDetail(int $id, array $columns = ['*'])
    {
        $product = $this->productRepository->detailProduct($id, $columns);

        $product->related_products = $this->productRepository->getRelatedProducts($product);

        $totalReviews = $product->reviews->count();
        $averageRating = $totalReviews > 0 ? round($product->reviews->avg('rating'), 1) : 0;

        $product->totalReviews = $totalReviews;
        $product->averageRating = $averageRating;
        $product->review = $this->reviewRepository->getReviewsByProductId($id);

        // Lấy thuộc tính sản phẩm
        $product->attributes = $this->productRepository->getProductAttributes($product);

        return $product;
    }
    public function detailModal($id)
    {
        try {
            $product = $this->productRepository->detailModal($id) ?? 0;

            if (!$product) {
                throw new ModelNotFoundException('Không tìm thấy sản phẩm.');
            }
            $avgRating = $product->reviews->avg('rating');
            // dd($product);
            $productVariants = $product->productVariants->map(function ($variant) { //sản phẩm biến thể
                return [
                    // 'sku' => $variant->sku,
                    'id' => $variant->id, // id biến thể
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'thumbnail' => Storage::url($variant->thumbnail),
                    'attribute_values' => $variant->attributeValues->map(function ($attributeValue) { //bảng attribute_values (giá trị thuộc tính, xanh 4GB..)
                        return [
                            'id' => $attributeValue->id, //id giá trị thuộc tính
                            // 'attribute_id' => $attributeValue->attribute_id,//id liên kết thuộc tính
                            'attribute_value' => $attributeValue->value,            //Giá trị thuộc tính 
                            'attributes_name' => $attributeValue->attribute->name, //tên thuộc tính (table attributes)
                            'attributes_slug' => $attributeValue->attribute->slug, //tên thuộc tính (table attributes)
                        ];
                    }),
                    'product_stock' => $variant->productStock ? //hAS ONE :))))
                         [
                            "product_id" => $variant->productStock->product_id,
                            'product_variant_id' => $variant->productStock->product_variant_id,            
                            'stock' => $variant->productStock->stock, 
                        ] : [],
                    


                ];
            });
            // dd($productVariants);

            return [
                'id' => $product->id, //id sản phẩm
                'name' => $product->name,
                'price' => $product->price,
                'thumbnail' => Storage::url($product->thumbnail),
                'description' => $product->description,
                'categories' => $product->categories->pluck('name')->implode(', '),
                'brand' => $product->brand ? $product->brand->name : null,
                // 'reviews' => $product->reviews ? $product->reviews : null,
                'avgRating' => $avgRating,
                'productVariants' => $productVariants,
            ];
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function storeComment($productId, $content)
{
    $userId = Auth::id();
    
    if (!$userId) {
        return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);
    }

    return $this->productRepository->create([
        'user_id' => $userId,
        'product_id' => $productId,
        'content' => $content
    ]);
}


    /**
     * Lưu phản hồi bình luận
     */
    public function createComment(int $productId, string $content)
    {
        $userId = Auth::id();
        return $this->commentRepository->createComment([
            'product_id' => $productId,
            'user_id' => $userId,
            'content' => $content,
        ]);
    }

    public function createReply(int $commentId, string $content, int $replyUserId)
    {
        $userId = Auth::id();
        return $this->commentReplyRepository->createReply([
            'comment_id' => $commentId,
            'user_id' => $userId,
            'reply_user_id' => $replyUserId,
            'content' => $content,
        ]);
    }

    public function createProductReview(array $data)
    {
        $userId = Auth::id();
        $productId = $data['product_id'];

        if (!$this->reviewRepository->userHasPurchasedProduct($userId, $productId)) {
            return false;
        }

        return $this->reviewRepository->createReview($data);
    }

    public function getLatestReview($productId, $userId)
    {
        return $this->reviewRepository->getLatestReview($productId, $userId);
    }

    public function createProductReviewWithFiles(array $data, array $files = [])
    {
        Log::info('createProductReviewWithFiles called');
        $data['user_id'] = Auth::id();
    
        // Lấy order_id từ order_items
        $orderItem = OrderItem::where('product_id', $data['product_id'])
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id())
                    ->where('is_paid', 1);
            })
            ->first();
    
        if (!$orderItem) {
            return ['error' => 'Bạn phải mua sản phẩm này trước khi đánh giá.'];
        }
    
        $data['order_id'] = $orderItem->order_id;
    
        // Kiểm tra xem người dùng đã đánh giá sản phẩm hay chưa
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $data['product_id'])
            ->first();
    
        if ($existingReview) {
            return ['error' => 'Bạn đã đánh giá sản phẩm này rồi.'];
        }
        $data['is_active'] = 1;
        if ($this->createProductReview($data)) {
            Log::info('Review created');
            $review = $this->getLatestReview($data['product_id'], $data['user_id']);
            Log::info('Review created: ' . $review->id);
    
            if (isset($files['images'])) {
                Log::info('Images processing');
                foreach ($files['images'] as $image) {
                    $path = $image->store('reviews', 'public');
                    $review->reviewMultimedia()->create([
                        'review_id' => $review->id,
                        'file' => $path,
                        'file_type' => 0,
                        'mime_type' => $image->getMimeType(),
                    ]);
                }
            }
    
            if (isset($files['videos'])) {
                Log::info('Videos processing');
                foreach ($files['videos'] as $video) {
                    $path = $video->store('reviews', 'public');
                    $review->reviewMultimedia()->create([
                        'review_id' => $review->id,
                        'file' => $path,
                        'file_type' => 1,
                        'mime_type' => $video->getMimeType(),
                    ]);
                }
            }
            Log::info('Review Multimedia created');
            Log::info('Review Multimedia created: ' . json_encode($review->reviewMultimedia()->get()->toArray()));
    
            return ['success' => 'Đánh giá thành công!'];
        } else {
            return ['error' => 'Có lỗi xảy ra khi tạo đánh giá.'];
        }
    }

    public function getProductReviews(int $productId)
    {
        return $this->reviewRepository->getReviewsByProductId($productId);
    }
}
