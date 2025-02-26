<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository extends BaseRepository
{
    public function getModel()
    {
        return Product::class;
    }

    // Lấy danh sách sản phẩm theo category
    public function getAllProductCate($perpage = 5, $sortBy = 'default', $filters = [])
    {

        $query = $this->model->query();

        //  giá sản phẩm thường và biến thể
        $priceFiled = DB::raw('
        CASE 
            WHEN products.type = 1 THEN (
                SELECT price 
                FROM product_variants 
                WHERE product_variants.product_id = products.id
                ORDER BY product_variants.price ASC LIMIT 1
            )
            ELSE products.price 
         END ');

        $query->select(
            'id',
            'name',
            'thumbnail',
            DB::raw('COALESCE(NULLIF(sale_price, 0), ' . $priceFiled->getValue(DB::connection()->getQueryGrammar()) . ') as display_price'), // Nội suy giá trị của $priceFiled
            'sale_price',
            'price',
            'short_description',
            'views',
            'type'
        );

        // filters
        if (!empty($filters)) {



            // lọc theo danh mục
            Log::info('Applying filters in ProductRepository: ' . json_encode($filters)); //log mangr theem json_endcode
            if (isset($filters['category'])) {
                $categoryFilters = $filters['category']; // id cha từ category  
                Log::info('Giá trị mảng $category: ' . json_encode($categoryFilters));
                $categoryIdsToFilter = []; // all id (parent + child)
                foreach ($categoryFilters as $parentCategoryID) {
                    $parentID = $parentCategoryID;
                    $childCateIds = Category::where('parent_id', $parentID)
                        ->pluck('id')
                        ->toArray();
                    // gộp id cha và con 
                    $categoryIds = array_merge([$parentID], $childCateIds);
                    $categoryIdsToFilter = array_merge($categoryIdsToFilter, $categoryIds);
                }
                $categoryIdsToFilter = array_map('intval', array_unique($categoryIdsToFilter)); // lọc trùng, chuyến sang int
                $query->whereHas('categories', function ($q) use ($categoryIdsToFilter) {
                    $q->whereIn('categories.id', $categoryIdsToFilter)->where('is_active', 1);
                });
            } //end filter category




            if (isset($filters['min_price']) && isset($filters['max_price'])) { // Search Price Range

                $minPrice = $filters['min_price'];
                $maxPrice = $filters['max_price'];

                // check input
                // if (is_numeric($minPrice) && is_numeric($maxPrice) && $minPrice >= 0 && $maxPrice >= 0 && $minPrice <= $maxPrice) {
                //     Log::info('min: ' . $minPrice . ' max: ' . $maxPrice);
                //     $query->whereBetween('price', [$minPrice, $maxPrice]);
                // } else {
                //     Log::warning('warning' . 'min: ' . $minPrice . ' max: ' . $maxPrice);
                // }
                $query->where(function ($q) use ($minPrice, $maxPrice) {
                    $q->where('type', 0)
                        ->whereBetween('price', [$minPrice, $maxPrice])
                        ->orWhere(function ($q) use ($minPrice, $maxPrice) {
                            $q->where('type', 1)
                                ->whereHas('productVariants', function ($variantQuery) use ($minPrice, $maxPrice) {
                                    $variantQuery->whereBetween('price', [$minPrice, $maxPrice]);
                                });
                        });

                });

            } //end search price



            if (isset($filters['rating'])) { //filter rating
                $ratingFilter = $filters['rating'];
                // Log::info('Rating filter:' . $ratingFilter);
                if (is_array($ratingFilter)) { // nhiều rating
                    $query->whereHas('reviews', function ($q) use ($ratingFilter) {
                        $q->whereIn('rating', $ratingFilter);
                    });
                } else if (is_numeric($ratingFilter)) { // chỉ chọn một rating
                    $query->whereHas('reviews', function ($q) use ($ratingFilter) {
                        $q->whereIn('rating', '=', $ratingFilter);
                    });
                }
            } //end filter rating



            if (isset($filters['search']) && !empty($filters['search'])) { // search basic
                $searchItem = $filters['search'];
                Log:
                info('Search name: ' . $searchItem);
                $query->where('name', 'LIKE', '%' . $searchItem . '%');
            } // end search


            // Lọc theo thuộc tính - biến thể

            $variantAttributeFilters = [];
            foreach ($filters as $filterName => $filterValues) {
                if (in_array($filterName, ['kich-thuoc-man-hinh', 'bo-nho-ram', 'mau-sac'])) { // tạo mảng với key
                    if (is_array($filterValues)) { // check mảng 
                        $variantAttributeFilters[$filterName] = $filterValues; // gán giá trị vào mảng
                    }
                }
                ;
            }

            if (!empty($variantAttributeFilters)) {
                Log::info('variant: ' . json_encode($variantAttributeFilters));
                $query->whereHas('productVariants', function ($variantQuery) use ($variantAttributeFilters) {
                    foreach ($variantAttributeFilters as $attributeSlug => $attributeValues) {
                        $variantQuery->whereHas('attributeValues', function ($attributeValueQuery) use ($attributeSlug) {
                            $attributeValueQuery->whereHas('attribute', function ($attributeQuery) use ($attributeSlug) {
                                $attributeQuery->where('slug', $attributeSlug);
                            });
                        })->whereHas('attributeValues', function ($attributeValueQuery) use ($attributeValues) {
                            $attributeValueQuery->whereIn('value', $attributeValues);
                        });
                    }
                });
            } //end filter attribute variant
            // dd($filters);



        } else { // không có điều kiện lọc
            $query->whereHas('categories', function ($q) {
                $q->where('is_active', 1);
            });
        }

        // sort by
        switch ($sortBy) {
            case 'low':
                $query->orderBy('display_price', 'ASC');
                break;
            case 'high':
                $query->orderBy('display_price', 'DESC');
                break;
            case 'aToz':
                $query->orderBy('name', 'ASC');
                break;
            case 'zToa':
                $query->orderBy('name', 'DESC');
                break;
            case 'sellWell':
                $query->orderByDesc(function ($query) {
                    $query->selectRaw('COALESCE(SUM(order_items.quantity),0)')
                        ->from('order_items')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->join('order_order_status', 'orders.id', '=', 'order_order_status.order_id')
                        ->join('order_statuses', 'order_order_status.order_status_id', '=', 'order_statuses.id')
                        ->whereColumn('order_items.product_id', 'products.id')
                        ->where('order_statuses.name', '=', 'Hoàn thành');
                });
                break;
            case 'manyViews':
                $query->orderBy('views', 'DESC');
                break;
            case 'rating':
                $query->orderByDesc(function ($query) {
                    $query->selectRaw('COALESCE(AVG(reviews.rating),0)')
                        ->from('reviews')
                        ->whereColumn('reviews.product_id', 'products.id');
                });
                // dd("Đang sắp xếp rating", $query->toSql(), $query->getBindings());
                break;
            default:
                $query->orderBy('updated_at', 'DESC');


        }


        // ->with('categories:id,name')->with('reviews');
        $query->with([
            'categories:id,name',
            'reviews',
            'productVariants' => function ($q) {
                $q->orderBy('price', 'ASC')->select('product_id', 'price');
            }
        ]);
        $products = $query->paginate($perpage)->appends(['sort_by' => $sortBy]); // Lưu  $products
        // dd($products);
        return $products;
    }


    public function getTrendingProducts()
    {
        return $this->model->trending()->latest()->get();
    }

    public function getBestSellerProductsToday()
    {
        $today = Carbon::today();
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('reviews', function ($join) {
                $join->on('reviews.product_id', '=', 'products.id')
                    ->where('reviews.is_active', 1);
            })
            ->leftJoin(DB::raw('(SELECT product_id, SUM(stock) as total_stock FROM product_stocks GROUP BY product_id) as ps'), function ($join) {
                $join->on('ps.product_id', '=', 'products.id');
            })
            ->whereDate('orders.created_at', $today)
            ->where('products.is_active', 1)
            ->select(
                'products.id',
                DB::raw('GROUP_CONCAT(DISTINCT products.name ORDER BY order_items.product_variant_id DESC SEPARATOR " | ") as product_names'),
                'products.slug',
                'products.price',
                'products.sale_price',
                'products.thumbnail',
                'products.is_active',
                DB::raw('SUM(order_items.quantity + COALESCE(order_items.quantity_variant, 0)) as total_sold'),
                DB::raw('ROUND(COALESCE(AVG(reviews.rating), 0), 1) as average_rating'),
                DB::raw('COUNT(DISTINCT reviews.id) as total_reviews'),
                DB::raw('COALESCE(ps.total_stock, 0) as stock_quantity')
            )
            ->groupBy(
                'products.id',
                'products.slug',
                'products.price',
                'products.sale_price',
                'products.thumbnail',
                'products.is_active',
                'ps.total_stock'
            )
            ->orderByDesc('total_sold')
            ->limit(24)
            ->get();
    }

    public function getBestSellingProducts()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->select(
                DB::raw('products.name as product_name'),
                DB::raw('COALESCE(
                CASE 
                    WHEN product_variants.thumbnail LIKE "http%" THEN product_variants.thumbnail
                    ELSE CONCAT("/storage/", product_variants.thumbnail) 
                END,
                CASE 
                    WHEN products.thumbnail LIKE "http%" THEN products.thumbnail
                    ELSE CONCAT("/storage/", products.thumbnail) 
                END
            ) as thumbnail'),
                DB::raw('COALESCE(product_variants.price, products.price) as price'),
                DB::raw('COALESCE(product_variants.id, products.id) as product_id'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'product_variants.thumbnail',
                'products.thumbnail',
                'product_variants.price',
                'products.price',
                'product_variants.id'
            )
            ->orderByDesc('total_sold')
            ->limit(24)
            ->get();
    }


    public function getPopularProducts()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                'products.name',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('SUM(order_items.quantity) as total_sold'),
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price')
            ->orderByDesc('total_sold')
            ->limit(24)
            ->get();
    }

    public function getUserRecommendations($userId)
    {
        // Lấy danh sách sản phẩm người dùng đã mua
        $purchasedProducts = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->pluck('order_items.product_id')
            ->toArray();

        // Nếu chưa mua sản phẩm nào => gợi ý sản phẩm phổ biến
        if (empty($purchasedProducts)) {
            return $this->getPopularProducts();
        }

        // Truy vấn sản phẩm gợi ý dựa trên lịch sử mua hàng
        $suggestedProducts = DB::table('order_items as oi1')
            ->join('order_items as oi2', function ($join) use ($purchasedProducts) {
                $join->on('oi1.order_id', '=', 'oi2.order_id')
                    ->whereIn('oi1.product_id', $purchasedProducts)
                    ->whereColumn('oi1.product_id', '!=', 'oi2.product_id');
            })
            ->join('products', 'products.id', '=', 'oi2.product_id')
            ->leftJoin('reviews', 'reviews.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating'),
                DB::raw('COUNT(oi2.product_id) as frequency'),
                'products.stock_quantity'
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price', 'products.stock_quantity')
            ->orderByDesc('frequency')
            ->limit(24)
            ->get();

        // Nếu không tìm thấy sản phẩm => gợi ý sản phẩm phổ biến
        return $suggestedProducts->isNotEmpty() ? $suggestedProducts : $this->getPopularProducts();
    }

    // Mạnh - admin - list - delete - products
    public function getProducts($perPage = 15, $categoryId, $stockStatus = null, $keyword = null, $filters = [])
    {
        $query = $this->model->query();

        $query->select(
            'id',
            'sku',
            'thumbnail',
            'name',
            'price',
            'is_active',
            'type',
        )
            ->with(['categories', 'productStock', 'productVariants.productStock'])
            ->where('deleted_at', null)
            ->orderBy('updated_at', 'DESC');



        // Category
        if (isset($categoryId) && $categoryId) {
            // Log::info('Filtering by category ID: ' . $categoryId);

            $selectCategory = Category::findOrFail($categoryId);
            $categoryIdsToFilter = $selectCategory->getAllChildrenIds()->toArray();

            // Log::info('Category IDs to filter: ' . json_encode($categoryIdsToFilter));

            $query->whereHas('categories', function ($q) use ($categoryIdsToFilter) {
                $q->whereIn('categories.id', $categoryIdsToFilter);
            });

        }


        // search
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('products.name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('products.sku', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('productVariants', function ($variantQuery) use ($keyword) {
                        $variantQuery->where(function ($variant) use ($keyword) {
                            $variant->where('name', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('sku', 'LIKE', '%' . $keyword . '%');
                        });
                    });
            });
        }



        $products = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            'category_id' => $categoryId,
            'stock_status' => $stockStatus,
            '_keyword' => $keyword,
        ]);

        $products->getCollection()->each(function ($product) {
            // Lấy tổng stock quantity thông qua Accessor (thuộc tính ảo) đã được eager load quan hệ!**
            $stockQuantity = $product->totalStockQuantity;
            $product->stock_quantity = $stockQuantity;
        });

        // dd($products);

        return $products;
    }

    // Xóa mềm sản phẩm
    public function delete($productId)
    {
        $product = $this->model->find($productId);
        if (!$product) {
            return false;
        }

        if ($product->type == 1) {
            $product->productVariants()->delete();
        }

        return $product->delete();
    }
    public function find($productId)
    {
        return $this->model->find($productId);
    }


    public function detailProduct(int $id, array $columns = ['*'])
    {
        return Product::select($columns)
            ->with([
                'productGallery',
                'productAccessories',
                'reviews.user',
                'reviews.ReviewMultimedia',
                'attributeValues.attribute',
                'productVariants.productStock',
                'productStock',
                'productVariants.attributeValues.attribute',
                'comments.commentReplies',
            ])
            ->with(['attributeValues' => function ($query) {
                $query->whereHas('attribute', function ($q) {
                    $q->where('name', 'Bộ nhớ trong');
                });
            }])
            ->with(['productVariants' => function ($query) {
                $query->with(['attributeValues' => function ($query) {
                    $query->with('attribute');
                }]);
            }])
            ->findOrFail($id);
    }

    public function getProductAttributes(Product $product, array $attributeNames)
    {
        $attributes = [];
        $displayedValues = [];

        foreach ($product->productVariants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                if (in_array($attrValue->attribute->name, $attributeNames) && !in_array($attrValue->value, $displayedValues[$attrValue->attribute->name] ?? [])) {
                    $attributes[$attrValue->attribute->name][] = $attrValue;
                    $displayedValues[$attrValue->attribute->name][] = $attrValue->value;
                }
            }
        }

        return $attributes;
    }


    public function getRelatedProducts(Product $product, int $limit = 6)
    {
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->whereBetween('sale_price', [$product->sale_price * 0.8, $product->sale_price * 1.2])
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('category_id', $product->categories->pluck('id')); // Lấy tất cả danh mục của sản phẩm
            })
            ->orderByRaw('brand_id = ? DESC, ABS(price - ?) ASC', [$product->brand_id, $product->sale_price]) // Ưu tiên cùng brand
            ->limit($limit)
            ->get();

        // Nếu không tìm thấy sản phẩm tương tự, lấy sản phẩm trong cùng danh mục
        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::where('id', '!=', $product->id)
                ->where('is_active', 1)
                ->whereHas('categories', function ($query) use ($product) {
                    $query->whereIn('category_id', $product->categories->pluck('id'));
                })
                ->orderByRaw('brand_id = ? DESC, ABS(price - ?) ASC', [$product->brand_id, $product->sale_price])
                ->limit($limit)
                ->get();
        }

        return $relatedProducts;
    }

    public function detailModal($id)
    {
        $product = $this->model->with(['categories', 'brand', 'productVariants.attributeValues.attribute', 'reviews', 'productVariants.productStock'])->find($id);
        // dd($product);
        return $product;
    }
    public function createComment($data)
    {
        return Comment::create($data);
    }

    public function createReply($data)
    {
        return CommentReply::create($data);
    }

    public function createReview(array $data)
    {
        return Review::create($data);
    }

    public function userHasPurchasedProduct($userId, $productId)
    {
        return Order::where('user_id', $userId)
            ->where('is_paid', 1) 
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }

    public function getLatestReview($productId, $userId)
    {
        return Review::where('product_id', $productId)
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    public function getReviewsByProductId(int $id)
    {
        return Review::where('product_id', $id)->where('is_active', 1)->get();
    }
}
