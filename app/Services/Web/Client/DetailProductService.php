<?php

namespace App\Services\Web\Client;

use App\Models\OrderItem;
use App\Models\Product;
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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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

    ) {
        $this->productRepository = $productRepository;
        $this->commentRepository = $commentRepository;
        $this->commentReplyRepository = $commentReplyRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function getProductDetail(int $id, array $columns = ['*'])
    {
        $product = $this->productRepository->detailProduct($id, $columns);

        $product->relatedProducts = $this->productRepository->getRelatedProducts($product);

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

            $productVariants = $product->productVariants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'display_price' => $variant->display_price, // **LẤY display_price TỪ REPOSITORY**
                    'original_price' => $variant->original_price, // **LẤY original_price TỪ REPOSITORY**
                    'thumbnail' => Storage::url($variant->thumbnail),
                    'attribute_values' => $variant->attributeValues->map(function ($attributeValue) {
                        return [
                            'id' => $attributeValue->id,
                            'attribute_value' => $attributeValue->value,
                            'attributes_name' => $attributeValue->attribute->name,
                            'attributes_slug' => $attributeValue->attribute->slug,
                        ];
                    }),
                    'product_stock' => $variant->productStock ?
                        [
                            "product_id" => $variant->productStock->product_id,
                            'product_variant_id' => $variant->productStock->product_variant_id,
                            'stock' => $variant->productStock->stock,
                        ] : [],
                ];
            });

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'display_price' => $product->display_price, // **LẤY display_price TỪ REPOSITORY**
                'original_price' => $product->original_price, // **LẤY original_price TỪ REPOSITORY**
                'thumbnail' => Storage::url($product->thumbnail),
                'short_description' => $product->short_description,
                'categories' => $product->categories->pluck('name')->implode(', '),
                'brand' => $product->brand ? $product->brand->name : null,
                'avgRating' => $avgRating,
                'productVariants' => $productVariants,
                'sold_count' => $product->sold_count,
                'is_sale' => $product->is_sale,
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

    public function createProductReviewWithFiles(array $data, array $files)
    {
        Log::info('createProductReviewWithFiles called', ['data' => $data, 'files_keys' => array_keys($files)]); // Log dữ liệu đầu vào

        $data['user_id'] = Auth::id();
        Log::info('User ID từ Auth: ' . $data['user_id']);

        // Order ID should now be in $data
        if (!isset($data['order_id'])) {
            Log::warning('Lỗi: Không tìm thấy order_id trong dữ liệu gửi lên.');
            return ['error' => 'Thiếu thông tin đơn hàng để đánh giá.'];
        }

        Log::info('Order ID từ request: ' . $data['order_id']);

        // Kiểm tra xem người dùng đã đánh giá sản phẩm cho đơn hàng này hay chưa
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $data['product_id'])
            ->where('order_id', $data['order_id']) // Thêm điều kiện kiểm tra order_id
            ->first();

        Log::info('Existing Review result:', ['existingReview' => $existingReview ? $existingReview->toArray() : null]); // Log kết quả ExistingReview

        if ($existingReview) {
            Log::warning('Lỗi: Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi.'); // Log cảnh báo
            return ['error' => 'Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi.'];
        }

        $data['is_active'] = 1;
        Log::info('Dữ liệu trước khi createProductReview:', ['data_to_create_review' => $data]); // Log dữ liệu trước khi tạo

        // Bắt đầu try-catch để kiểm tra lỗi trong createProductReview
        try {
            if ($this->createProductReview($data)) { // Gọi hàm createProductReview và kiểm tra thành công
                Log::info('Đánh giá tạo thành công'); // Log tạo thành công
                $review = $this->getLatestReview($data['product_id'], $data['user_id']);
                Log::info('Đánh giá mới nhất được lấy:', ['review_id' => $review->id ?? 'null']); // Log ID đánh giá vừa lấy

                if (isset($files['images'])) {
                    Log::info('Bắt đầu xử lý hình ảnh'); // Log bắt đầu xử lý ảnh
                    foreach ($files['images'] as $image) {
                        $path = $image->store('reviews', 'public');
                        $review->reviewMultimedia()->create([
                            'review_id' => $review->id,
                            'file' => $path,
                            'file_type' => 0,
                            'mime_type' => $image->getMimeType(),
                        ]);
                        Log::info('Hình ảnh đã lưu:', ['path' => $path]); // Log đường dẫn từng ảnh
                    }
                    Log::info('Hoàn tất xử lý hình ảnh'); // Log kết thúc xử lý ảnh
                }

                if (isset($files['videos'])) {
                    Log::info('Bắt đầu xử lý video'); // Log bắt đầu xử lý video
                    $video = $files['videos'];
                    $path = $video->store('reviews', 'public');
                    $review->reviewMultimedia()->create([
                        'review_id' => $review->id,
                        'file' => $path,
                        'file_type' => 1,
                        'mime_type' => $video->getMimeType(),
                    ]);
                    Log::info('Video đã lưu:', ['path' => $path]); // Log đường dẫn video
                    Log::info('Hoàn tất xử lý video'); // Log kết thúc xử lý video
                }

                Log::info('Đa phương tiện đánh giá đã tạo: ' . json_encode($review->reviewMultimedia()->get()->toArray()));
                return ['success' => 'Đánh giá thành công!'];
            } else {
                // Trường hợp này ít khả năng xảy ra nếu createProductReview trả về false khi có lỗi bên trong
                Log::error('Lỗi: createProductReview trả về false nhưng không có Exception.');
                return ['error' => 'Có lỗi xảy ra khi tạo đánh giá. (createProductReview trả về false)'];
            }
        } catch (\Exception $e) {
            // Bắt Exception xảy ra trong quá trình gọi createProductReview
            Log::error('Lỗi trong createProductReview: ' . $e->getMessage(), [
                'exception' => $e, // Log toàn bộ đối tượng Exception để xem chi tiết
                'data_passed_to_createProductReview' => $data // Log dữ liệu đầu vào của createProductReview
            ]);
            return ['error' => 'Có lỗi xảy ra khi tạo đánh giá. (Exception) - Xem log để biết chi tiết.'];
        }
    }

    public function getProductReviews(int $productId)
    {
        return $this->reviewRepository->getReviewsByProductId($productId);
    }

   


    public function checkPurchaseAndReviewStatus(Product $product, $userId = null, $specificOrderId = null)
    {
        $hasPurchased = false;
        $canReviewForOrders =false;
        $reviewPeriodExpired = true;

        if ($userId) {
            $query = OrderItem::query()
                ->where('product_id', $product->id)
                ->whereHas('order', function (Builder $q) use ($userId) {
                    $q->where('user_id', $userId)
                        ->whereHas('orderStatuses', function (Builder $sq) {
                            $sq->where('order_order_status.order_status_id', 6);
                        });
                })
                ->with(['order', 'order.orderStatuses' => function (\Illuminate\Database\Eloquent\Relations\BelongsToMany $q) {
                    $q->wherePivot('order_status_id', 6)
                      ->orderByDesc('pivot_created_at');
                }]);

            if ($specificOrderId) {
                $query->where('order_id', $specificOrderId);
            }

            $orderItems = $query->get();

            foreach ($orderItems as $orderItem) {
                if ($orderItem->order) {
                    $hasPurchased = true;
                    $completedOrderStatus = $orderItem->order->orderStatuses->where('pivot.order_status_id', 6)->first();

                    if ($completedOrderStatus && $completedOrderStatus->pivot && $completedOrderStatus->pivot->created_at) {
                        $completedAt = $completedOrderStatus->pivot->created_at;
                        $completionDate = Carbon::parse($completedAt);
                        $now = Carbon::now();
                        $daysSinceOrder = $completionDate->diffInDays($now);

                        if ($daysSinceOrder <= 3) {
                            $reviewPeriodExpired = false;
                            $orderId = $orderItem->order_id;

                            $existingReview = Review::where('user_id', $userId)
                                ->where('product_id', $product->id)
                                ->where('order_id', $orderId)
                                ->doesntExist();

                            if ($existingReview) {
                                $canReviewForOrders= $orderId;
                            }
                        }
                    }
                }
            }
        }

        return [
            'hasPurchased' => $hasPurchased,
            'canReview' => !empty($canReviewForOrders),
            'reviewPeriodExpired' => $reviewPeriodExpired,
            'eligibleOrderIds' => $canReviewForOrders,
        ];
    }
}
