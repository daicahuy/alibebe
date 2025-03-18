<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
    WHEN products.type = 1 THEN (  -- Sản phẩm biến thể
        SELECT
            CASE
                WHEN products.is_sale = 1 THEN  -- Sản phẩm GỐC ĐANG SALE
                    CASE
                        WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price)
                        ELSE MIN(product_variants.price)
                    END
                ELSE  -- Sản phẩm GỐC KHÔNG SALE
                    MIN(product_variants.price)  -- Đảm bảo lấy giá thấp nhất của các biến thể
            END
        FROM product_variants
        WHERE product_variants.product_id = products.id AND product_variants.is_active = 1 AND product_variants.price > 0 
    )
    ELSE  -- Sản phẩm đơn (type != 1)
        CASE
            WHEN products.is_sale = 1 THEN  -- Sản phẩm đơn ĐANG SALE
                CASE
                    WHEN products.sale_price > 0 THEN products.sale_price
                    ELSE products.price
                END
            ELSE  -- Sản phẩm đơn KHÔNG SALE
                products.price
        END
END');

        // Giá gốc (original_price) - để hiển thị gạch ngang khi sale
        $originalPriceFiled = DB::raw('
CASE
    WHEN products.type = 1 THEN ( -- Sản phẩm biến thể
        SELECT 
            CASE 
                WHEN COUNT(*) > 0 THEN MAX(product_variants.price)  -- Lấy giá gốc CAO NHẤT
                ELSE products.price  -- Fallback nếu không có biến thể
            END
        FROM product_variants
        WHERE product_variants.product_id = products.id AND product_variants.is_active = 1 AND product_variants.price > 0  
    )
    ELSE products.price -- Sản phẩm đơn
END');


        $soldCountSubQuery = DB::raw('(
    SELECT COALESCE(SUM(order_items.quantity), 0)
    FROM order_items
    JOIN orders ON order_items.order_id = orders.id
    JOIN order_order_status ON orders.id = order_order_status.order_id
    JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
    WHERE order_items.product_id = products.id
    AND order_statuses.name = "Hoàn thành"
) as sold_count');

        // Phần select trong query
        $query->select(
            'id',
            'name',
            'thumbnail',
            // Logic display_price - CHỈ HIỂN THỊ GIÁ SALE KHI is_sale = 1
            DB::raw('CASE 
        WHEN products.is_sale = 1 THEN ' . $priceFiled->getValue(DB::connection()->getQueryGrammar()) . ' 
        ELSE ' . $priceFiled->getValue(DB::connection()->getQueryGrammar()) . ' 
     END as display_price'),  // Luôn lấy giá theo logic $priceFiled
            // Logic original_price - LUÔN LẤY GIÁ GỐC CAO NHẤT ĐỂ GẠCH NGANG KHI SALE
            DB::raw($originalPriceFiled->getValue(DB::connection()->getQueryGrammar()) . ' as original_price'),
            'sale_price',
            'is_sale',
            'price',
            'short_description',
            'views',
            'type',
            'slug',
            // $soldCountSubQuery
        )->where('is_active', 1);


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



            // Search Price Range
            if (isset($filters['min_price']) && isset($filters['max_price'])) {

                $minPrice = $filters['min_price'];
                $maxPrice = $filters['max_price'];



                $query->where(function ($q) use ($minPrice, $maxPrice) {
                    // Type  = 0
                    $q->where(function ($q) use ($minPrice, $maxPrice) {
                        $q->where('type', 0)
                            ->where(function ($q) use ($minPrice, $maxPrice) {
                                // is_sale = 1 && sale_price not null
                                $q->where(function ($q) use ($minPrice, $maxPrice) {
                                    $q->where('is_sale', 1)
                                        ->whereNotNull('sale_price')
                                        ->whereBetween('sale_price', [$minPrice, $maxPrice]);
                                })
                                    // is_sale == 0 or sale_price null
                                    ->orwhere(function ($q) use ($minPrice, $maxPrice) {
                                    $q->where(function ($q) {
                                        $q->where('is_sale', 0)
                                            ->orWhereNull('sale_price');
                                    })->whereBetween('price', [$minPrice, $maxPrice]);
                                });
                            });
                    })
                        // type = 1
                        ->orWhere(function ($q) use ($minPrice, $maxPrice) {
                            $q->where('type', 1)
                                ->whereHas('productVariants', function ($variantQuery) use ($minPrice, $maxPrice) {
                                    $variantQuery->where('is_active', 1)->where(function ($q) use ($minPrice, $maxPrice) {
                                        // sale true
                                        $q->where(function ($q) use ($minPrice, $maxPrice) {
                                            $q->where('is_sale', 1)
                                                ->WhereNotNull('sale_price')
                                                ->whereBetween('sale_price', [$minPrice, $maxPrice]);
                                        })
                                            // sale false
                                            ->orWhere(function ($q) use ($minPrice, $maxPrice) {
                                            $q->where(function ($q) {
                                                $q->where('is_sale', 0)
                                                    ->orWhereNull('sale_price');
                                            })->whereBetween('price', [$minPrice, $maxPrice]);
                                        });
                                    });
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
                    $variantQuery->where('is_active', 1);
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



        }
        // else { // không có category 
        if (!isset($filters['category'])) {
            $query->whereHas('categories', function ($q) {
                $q->where('is_active', 1);
            });
            // }
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
                    $query->selectRaw('(' . (new Product)->getSoldQuantitySubQuery() . ')'); // Sử dụng subquery từ Model Product
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
                $q->where('is_active', 1)->orderBy('price', 'ASC')->select('product_id', 'price');
            }
        ]);
        $products = $query->paginate($perpage)->appends($filters); // Lưu  $products
        // dd($products);
        return $products;
    }


    public function getTrendingProducts()
    {
        return $this->model->trending()->get();
    }
    public function getBestSellerProductsToday($limit = 12)
    {
        $today = Carbon::today()->toDateString(); // 'YYYY-MM-DD'
    
        $totalSoldSubQuery = "
            (SELECT COALESCE(SUM(order_items.quantity), 0) + COALESCE(SUM(order_items.quantity_variant), 0)
            FROM order_items
            JOIN orders ON order_items.order_id = orders.id
            JOIN order_order_status ON orders.id = order_order_status.order_id
            JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
            WHERE order_statuses.name = 'Hoàn thành'
            AND DATE(orders.created_at) = '{$today}'
            AND (
                order_items.product_id = products.id 
                OR order_items.product_variant_id IN (
                    SELECT id FROM product_variants WHERE product_variants.product_id = products.id
                )
            )) as total_sold";
    
        $averageRatingSubQuery = "
            (SELECT COALESCE(AVG(reviews.rating), 0)
            FROM reviews
            WHERE reviews.product_id = products.id AND reviews.is_active = 1) as average_rating";
    
        $displayPriceSubQuery = "
            (CASE
                WHEN products.type = 1 THEN (
                    SELECT 
                        CASE 
                            WHEN products.is_sale = 1 THEN 
                                CASE 
                                    WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price) 
                                    ELSE MIN(product_variants.price) 
                                END
                            ELSE MIN(product_variants.price)
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE 
                    CASE
                        WHEN products.is_sale = 1 THEN 
                            CASE 
                                WHEN products.sale_price > 0 THEN products.sale_price
                                ELSE products.price 
                            END
                        ELSE products.price
                    END
            END) as display_price";
    
        $originalPriceSubQuery = "
            (CASE
                WHEN products.type = 1 THEN (
                    SELECT 
                        CASE 
                            WHEN COUNT(*) > 0 THEN MAX(product_variants.price) 
                            ELSE products.price  
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE products.price
            END) as original_price";
    
            return Product::query()
            ->selectRaw("
                products.id, 
                products.name, 
                products.thumbnail, 
                {$displayPriceSubQuery}, 
                {$originalPriceSubQuery}, 
                products.sale_price, 
                products.views, 
                COALESCE(product_stocks.stock, 0) as stock_quantity, 
                {$totalSoldSubQuery}, 
                {$averageRatingSubQuery}
            ")
            ->leftJoin('product_stocks', 'product_stocks.product_id', '=', 'products.id')
            ->where('products.is_active', 1)
            ->having('total_sold', '>', 0) // ✅ Chỉ lấy sản phẩm có lượt bán
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.sale_price', 'products.views', 'product_stocks.stock')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }
    
    

    public function getBestSellingProduct($limit = 12)
    {
        $query = $this->model->query();
    
        // Tổng số lượng bán (bao gồm cả sản phẩm đơn và biến thể)
        $totalSoldSubQuery = DB::raw('(
            SELECT COALESCE(SUM(order_items.quantity), 0) + COALESCE(SUM(order_items.quantity_variant), 0)
            FROM order_items
            JOIN orders ON order_items.order_id = orders.id
            JOIN order_order_status ON orders.id = order_order_status.order_id
            JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
            WHERE order_statuses.name = "Hoàn thành"
            AND (
                order_items.product_id = products.id 
                OR order_items.product_variant_id IN (
                    SELECT id FROM product_variants WHERE product_variants.product_id = products.id
                )
            )
        ) as total_sold');
    
        // Trung bình đánh giá
        $averageRatingSubQuery = DB::raw('(
            SELECT COALESCE(AVG(reviews.rating), 0)
            FROM reviews
            WHERE reviews.product_id = products.id AND reviews.is_active = 1
        ) as average_rating');
    
        // ✅ Giá hiển thị (display_price)
        $displayPriceSubQuery = DB::raw('(
            CASE
                WHEN products.type = 1 THEN (  -- Sản phẩm có biến thể
                    SELECT 
                        CASE 
                            WHEN products.is_sale = 1 THEN 
                                CASE 
                                    WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price) 
                                    ELSE MIN(product_variants.price) 
                                END
                            ELSE 
                                MIN(product_variants.price)
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE  -- Sản phẩm đơn (type = 0)
                    CASE
                        WHEN products.is_sale = 1 THEN 
                            CASE 
                                WHEN products.sale_price > 0 THEN products.sale_price
                                ELSE products.price 
                            END
                        ELSE 
                            products.price
                    END
            END
        ) as display_price');
    
        // ✅ Giá gốc (original_price)
        $originalPriceSubQuery = DB::raw('(
            CASE
                WHEN products.type = 1 THEN ( -- Sản phẩm có biến thể
                    SELECT 
                        CASE 
                            WHEN COUNT(*) > 0 THEN MAX(product_variants.price) 
                            ELSE products.price  
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE products.price
            END
        ) as original_price');
    
        $query->select(
            'products.id',
            'products.name',
            'products.thumbnail',
            $displayPriceSubQuery,
            $originalPriceSubQuery,
            'products.sale_price',
            'products.views',
            DB::raw('COALESCE(product_stocks.stock, 0) as stock_quantity'),
            $totalSoldSubQuery,
            $averageRatingSubQuery
        )
        ->leftJoin('product_stocks', 'product_stocks.product_id', '=', 'products.id')
        ->where('products.is_active', 1)
        ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.sale_price', 'products.views', 'product_stocks.stock')
        ->orderByDesc('total_sold')
        ->limit($limit);
    
        return $query->get();
    }
    
    

    public function getPopularProducts($limit = 12)
    {
        $query = Product::query();
    
        // Tổng số lượng bán được (bao gồm cả sản phẩm đơn và biến thể)
        $totalSoldSubQuery = DB::raw('(
            SELECT COALESCE(SUM(order_items.quantity), 0) + COALESCE(SUM(order_items.quantity_variant), 0)
            FROM order_items
            JOIN orders ON order_items.order_id = orders.id
            JOIN order_order_status ON orders.id = order_order_status.order_id
            JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
            WHERE order_statuses.name = "Hoàn thành"
            AND (
                order_items.product_id = products.id 
                OR order_items.product_variant_id IN (
                    SELECT id FROM product_variants WHERE product_variants.product_id = products.id
                )
            )
        ) as total_sold');
    
        // Trung bình đánh giá
        $averageRatingSubQuery = DB::raw('(
            SELECT COALESCE(AVG(reviews.rating), 0)
            FROM reviews
            WHERE reviews.product_id = products.id AND reviews.is_active = 1
        ) as average_rating');
    
        // ✅ Giá hiển thị (display_price)
        $displayPriceSubQuery = DB::raw('(
            CASE
                WHEN products.type = 1 THEN (  -- Sản phẩm có biến thể
                    SELECT 
                        CASE 
                            WHEN products.is_sale = 1 THEN 
                                CASE 
                                    WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price) 
                                    ELSE MIN(product_variants.price) 
                                END
                            ELSE 
                                MIN(product_variants.price)
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE  -- Sản phẩm đơn (type = 0)
                    CASE
                        WHEN products.is_sale = 1 THEN 
                            CASE 
                                WHEN products.sale_price > 0 THEN products.sale_price
                                ELSE products.price 
                            END
                        ELSE 
                            products.price
                    END
            END
        ) as display_price');
    
        // ✅ Giá gốc (original_price)
        $originalPriceSubQuery = DB::raw('(
            CASE
                WHEN products.type = 1 THEN ( -- Sản phẩm có biến thể
                    SELECT 
                        CASE 
                            WHEN COUNT(*) > 0 THEN MAX(product_variants.price) 
                            ELSE products.price  
                        END
                    FROM product_variants
                    WHERE product_variants.product_id = products.id 
                    AND product_variants.is_active = 1
                    AND product_variants.price > 0
                )
                ELSE products.price
            END
        ) as original_price');
    
        $query->select(
            'products.id',
            'products.name',
            'products.thumbnail',
            $displayPriceSubQuery,
            $originalPriceSubQuery,
            'products.sale_price',
            'products.views',
            DB::raw('COALESCE(product_stocks.stock, 0) as stock_quantity'),
            $totalSoldSubQuery,
            $averageRatingSubQuery
        )
        ->leftJoin('product_stocks', 'product_stocks.product_id', '=', 'products.id')
        ->where('products.is_active', 1)
        ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.sale_price', 'products.views', 'product_stocks.stock')
        ->orderByDesc('total_sold')
        ->limit($limit);
    
        $popularProducts = $query->get();
        return $popularProducts;
    }
    
    
    

    
    public function getUserRecommendations($userId)
    {
        // 🔹 Lấy danh sách sản phẩm đã mua trong các đơn hàng hoàn thành
        $purchasedProducts = Order::where('user_id', $userId)
            ->whereHas('orderStatuses', fn($query) => $query->where('order_status_id', 6))
            ->with('orderItems.product')
            ->get()
            ->pluck('orderItems.*.product_id')
            ->flatten()
            ->unique()
            ->toArray();
    
        // 🔹 Nếu chưa mua sản phẩm nào, gợi ý sản phẩm phổ biến
        if (empty($purchasedProducts)) {
            return $this->getTrendingProducts();
        }
    
        // 🔹 Lấy danh sách sản phẩm gợi ý theo nhiều tiêu chí
        $suggestedProducts = Product::whereHas('orderItems.order', function ($query) use ($purchasedProducts) {
            $query->whereHas('orderItems', fn($q) => $q->whereIn('product_id', $purchasedProducts))
                ->whereHas('orderStatuses', fn($q) => $q->where('order_status_id', 6));
        })
            ->whereNotIn('id', $purchasedProducts)
            ->limit(6)
            ->pluck('id')
            ->toArray();
    
        $categoryProducts = Product::whereHas('categories.products', fn($q) => $q->whereIn('id', $purchasedProducts))
            ->whereNotIn('id', array_merge($purchasedProducts, $suggestedProducts))
            ->limit(4)
            ->pluck('id')
            ->toArray();
    
        $brandProducts = Product::whereHas('brand.products', fn($q) => $q->whereIn('id', $purchasedProducts))
            ->whereNotIn('id', array_merge($purchasedProducts, $suggestedProducts, $categoryProducts))
            ->limit(4)
            ->pluck('id')
            ->toArray();
    
        $accessoryProducts = Product::whereHas('productAccessories', fn($query) => $query->whereIn('id', $purchasedProducts))
            ->whereNotIn('id', array_merge($purchasedProducts, $suggestedProducts, $categoryProducts, $brandProducts))
            ->limit(4)
            ->pluck('id')
            ->toArray();
    
        // 🔹 Tổng hợp danh sách ID sản phẩm
        $allSuggestedProductIds = array_merge($suggestedProducts, $categoryProducts, $brandProducts, $accessoryProducts);
    
        // 🔹 Truy vấn sản phẩm theo danh sách ID, với đầy đủ thông tin như getPopularProducts
        return Product::query()
            ->select(
                'products.id',
                'products.name',
                'products.thumbnail',
                'products.price',
                'products.sale_price',
                'products.views',
                'products.is_sale',
                DB::raw('(SELECT COALESCE(SUM(order_items.quantity), 0) + COALESCE(SUM(order_items.quantity_variant), 0)
                          FROM order_items
                          JOIN orders ON order_items.order_id = orders.id
                          JOIN order_order_status ON orders.id = order_order_status.order_id
                          JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
                          WHERE order_statuses.name = "Hoàn thành"
                          AND (order_items.product_id = products.id 
                               OR order_items.product_variant_id IN (SELECT id FROM product_variants WHERE product_variants.product_id = products.id))) as total_sold'),
                DB::raw('(SELECT COALESCE(AVG(reviews.rating), 0) FROM reviews WHERE reviews.product_id = products.id AND reviews.is_active = 1) as average_rating'),
                DB::raw('(SELECT COALESCE(product_stocks.stock, 0) FROM product_stocks WHERE product_stocks.product_id = products.id) as stock_quantity'),
                DB::raw('(CASE
                            WHEN products.type = 1 THEN (
                                SELECT CASE 
                                    WHEN products.is_sale = 1 THEN (CASE WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price) ELSE MIN(product_variants.price) END)
                                    ELSE MIN(product_variants.price) 
                                END FROM product_variants WHERE product_variants.product_id = products.id AND product_variants.is_active = 1 AND product_variants.price > 0)
                            ELSE (CASE 
                                    WHEN products.is_sale = 1 THEN (CASE WHEN products.sale_price > 0 THEN products.sale_price ELSE products.price END)
                                    ELSE products.price
                                  END)
                        END) as display_price')
            )
            ->whereIn('products.id', $allSuggestedProductIds)
            ->where('products.is_active', 1)
            ->groupBy('products.id', 'products.name', 'products.thumbnail', 'products.price', 'products.sale_price', 'products.is_sale')
            ->orderByDesc('total_sold')
            ->limit(12)
            ->get();
    }
    





    // Mạnh - admin - list - delete - products
    public function getProducts($perPage = 15, $categoryId, $stockStatus = null, $keyword = null, $filters = [])
    {
        $query = $this->model->query();

        $query->select(
            'id',
            'slug',
            'sku',
            'thumbnail',
            'name',
            'price',
            'is_active',
            'type',
            'is_sale',
            'sale_price'
        )
            ->with(['categories', 'productStock', 'productVariants.productStock'])
            ->where(['deleted_at' => null, 'is_active' => 1])
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
            $product->stock = $stockQuantity;
        });

        // dd($products);

        return $products;
    }

    public function countTrash()
    {
        return $this->model->onlyTrashed()->count();
    }
    public function countHidden()
    {
        return $this->model->where('is_active', 0)->count();
    }

    // get trash
    public function getTrash($perPage = 15, $keyword = null)
    {

        $query = $this->model->onlyTrashed();

        $query
            ->select(
                'id',
                'sku',
                'thumbnail',
                'name',
                'price',
                'is_active',
                'type',
                'is_sale',
                'sale_price',
            )
            ->with([
                'categories' => function ($query) {
                    $query->withTrashed();
                },
                'productStock', //   (HasOne) không dùng withTrashed()
                'productVariants' => function ($query) {
                    $query->with('productStock');
                },
            ])
            ->orderBy('updated_at', 'DESC');


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

        $listTrashs = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            '_keyword' => $keyword,
        ]);
        return $listTrashs;
    }

    // get hidden
    public function getHidden($perPage = 15, $keyword = null)
    {

        $query = $this->model->query();

        $query
            ->select(
                'id',
                'sku',
                'thumbnail',
                'name',
                'price',
                'is_active',
                'type',
                'is_sale',
                'sale_price',
            )
            ->with([
                'categories' => function ($query) {
                    $query->withTrashed();
                },
                'productStock', //   (HasOne) không dùng withTrashed()
                'productVariants' => function ($query) {
                    $query->with('productStock');
                },
            ])
            ->where('is_active', 0)
            ->orderBy('updated_at', 'DESC');


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

        $listHidden = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            '_keyword' => $keyword,
        ]);
        // dd($listHidden);
        return $listHidden;
    }

    // Xóa mềm sản phẩm
    public function delete($productId)
    {
        $product = $this->model->find($productId);
        if (!$product) {
            return false;
        }

        $product->is_active = 0;
        $product->save();
        // if ($product->type == 1) {
        //     // $product->productVariants()->update(['is_active' => 0]);
        //     $product->productVariants()->delete();
        // }



        return $product->delete();
    }
    public function find($productId)
    {
        return $this->model->find($productId);
    }

    // Xóa cứng sản phẩm
    public function forceDeleteProduct($productId)
    {
        $product = $this->model->withTrashed()->find($productId);
        if (!$product) {
            return false;
        }

        try {
            $product->categories()->detach(); // xóa reation liên quan
            $product->productStock()->delete();
            $product->attributeValues()->detach();
            $product->cartItems()->delete();
            $product->comments()->delete();
            $product->reviews()->delete();
            $product->wishlists()->delete();
            $product->productGallery()->delete();
            $product->productMovement()->delete();
            $product->tags()->detach();
            $product->productAccessories()->detach();

            if ($product->type == 1) {
                foreach ($product->productVariants()->get() as $variant) {
                    $variant->attributeValues()->detach();
                    $variant->productStock()->delete();
                    $variant->cartItems()->delete();
                    $variant->productMovement()->delete();
                    if ($variant->thumbnail && Storage::exists($variant->thumbnail)) {
                        Storage::delete($variant->thumbnail);
                    }
                    $variant->delete();
                }
            }
            if ($product->thumbnail && Storage::exists($product->thumbnail)) {
                Storage::delete($product->thumbnail);
            }
            $product->forceDelete();
            return true;
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . ' - Error force deleting product ID: ' . $productId, ['error' => $th->getMessage()]);
            return false; // Xóa cứng thất bại
        }
    }


    // restore 
    public function restore($id)
    {
        $product = $this->findTrash($id);
        if (!$product) {
            return false;
        }


        // Khôi phục sản phẩm chính

        $product->is_active = 1;
        $product->save();


        // if ($product->type == 1) {

        //     $variantQueryBuilder = $product->productVariants()->withTrashed(); // bỏ đk deleted_at null

        //     // $variantQueryBuilder->update(['is_active' => 1]);

        //     $product->productVariants()->restore();
        // }

        return $product->restore();
    }

    public function findTrash($id)
    {
        return $this->model->onlyTrashed()->find($id);
    }

    // xóa mềm nhiều 
    public function getBulkTrash($ids)
    {
        return $this->model->whereIn('id', $ids)->with(['productVariants', 'orderItems'])->get();
    }
    // lấy mảng ids sản phẩm đã xóa mềm 
    public function getwithTrashIds($ids)
    {
        return $this->model->withTrashed()->whereIn('id', $ids);
    }


    // khôi phục nhiều
    public function bulkRestoreTrash($productIds)
    {
        $count = 0;

        // lấy sản phẩm xóa mềm và biến thể
        $products = $this->model->withTrashed()
            ->whereIn('id', $productIds)
            // ->with(['productVariants'])
            ->get();
        foreach ($products as $product) {
            if ($product->restore()) {
                $count++;
                // if ($product->type == 1) {
                //     $product->productVariants()->withTrashed()->restore();
                //     // $product->productVariants->update(['is_active' => 1]);
                // }
                $product->update(['is_active' => 1]);
            }
        }
        return $count;
    }


    // Xóa cứng nhiều 
    public function bulkForceDeleteTrash($productIds)
    {
        $deleteCount = 0;
        $products = $this->model->withTrashed()
            ->whereIn('id', $productIds)
            ->with('productVariants')
            ->get();

        foreach ($products as $product) {
            try {
                $product->categories()->detach(); // chỉ dùng cho belongtomany
                $product->productStock()->delete();
                $product->attributeValues()->detach();
                $product->cartItems()->delete();
                $product->comments()->delete();
                $product->reviews()->delete();
                $product->wishlists()->delete();
                $product->productGallery()->delete();
                $product->productMovement()->delete();
                $product->tags()->detach();
                $product->productAccessories()->detach();

                if ($product->type == 1) {
                    foreach ($product->productVariants()->get() as $variant) {
                        $variant->attributeValues()->detach();
                        $variant->productStock()->delete();
                        $variant->cartItems()->delete();
                        $variant->productMovement()->delete();

                        if ($variant->thumbnail && Storage::exists($variant->thumbnail)) {
                            Storage::delete($variant->thumbnail);
                        }
                        $variant->delete();
                    }
                }

                if ($product->thumbnail && Storage::exists($product->thumbnail)) {
                    Storage::delete($product->thumbnail);
                }
                $product->forceDelete();
                $deleteCount++;
            } catch (\Throwable $th) {
                Log::error(__METHOD__ . ' - Error  product ID: ' . $product->id, ['error' => $th->getMessage()]);
            }
        }
        return $deleteCount;
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
            ->with(
                [
                    'productVariants' => function ($query) {
                        $query->where('is_active', 1)->with([
                            'attributeValues' => function ($query) {
                                $query->with('attribute');
                            }
                        ]);
                    },
                    'attributeValues' => function ($query) {
                        $query->whereHas('attribute', function ($q) {
                            $q->where('is_variant', '0');
                        });
                    },
                ]
            )
            ->where('is_active', 1)
            ->findOrFail($id);
    }

    public function getProductAttributes(Product $product)
    {
        $attributes = [];
        foreach ($product->productVariants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attributeName = $attrValue->attribute->name;
                $attributeValueId = $attrValue->id; // Lấy ID của giá trị thuộc tính

                if (!isset($attributes[$attributeName])) {
                    $attributes[$attributeName] = [];
                }

                // Kiểm tra xem giá trị thuộc tính đã tồn tại chưa bằng cách sử dụng ID
                if (!isset($attributes[$attributeName][$attributeValueId])) {
                    $attributes[$attributeName][$attributeValueId] = $attrValue;
                }
            }
        }

        // Chuyển đổi mảng liên kết thành mảng tuần tự để hiển thị trên view
        foreach ($attributes as $attributeName => $attributeValues) {
            $attributes[$attributeName] = array_values($attributeValues);
        }

        return $attributes;
    }


    public function getRelatedProducts(Product $product, int $limit = 6)
    {
        $comparePrice = $this->getProductRepresentativePrice($product);
        $relatedProducts = collect();

        // **Bước 1: Tìm sản phẩm TƯƠNG TỰ THEO GIÁ, CÙNG BRAND và CÙNG CATEGORY (mở rộng thêm parent_id nếu không đủ)**
        $relatedByPriceBrandCategory = Product::with('reviews', 'productVariants', 'categories')
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            // ->where('brand_id', $product->brand_id)
            ->where(function ($query) use ($product) {
                $categoryIds = $product->categories->pluck('id');
                $parentCategoryIds = Category::whereIn('parent_id', $categoryIds)->pluck('id');
                $allRelatedCategoryIds = $categoryIds->merge($parentCategoryIds)->unique();
                $query->whereHas('categories', function ($categoryQuery) use ($allRelatedCategoryIds) {
                    $categoryQuery->whereIn('category_id', $allRelatedCategoryIds);
                });
            })
            ->where(function ($query) use ($comparePrice) {
                $query->whereHas('productVariants', function ($variantQuery) use ($comparePrice) {
                    $variantQuery->whereBetween('sale_price', [$comparePrice * 0.8, $comparePrice * 1.2])
                        ->where('is_active', 1);
                })
                    ->orWhere(function ($productQuery) use ($comparePrice) {
                        $productQuery->whereBetween('sale_price', [$comparePrice * 0.8, $comparePrice * 1.2])
                            ->where('is_sale', 1);
                    })
                    ->orWhere(function ($productQuery) use ($comparePrice) {
                        $productQuery->whereBetween('price', [$comparePrice * 0.8, $comparePrice * 1.2])
                            ->where('is_sale', 0);
                    });
            })
            ->orderByRaw('brand_id = ? DESC, ABS(price - ?) ASC', [$product->brand_id, $comparePrice])
            ->limit($limit * 2)
            ->get();
        $relatedProducts = $relatedProducts->concat($relatedByPriceBrandCategory);
        // Log::info('Step 1 Related Products Count: ' . $relatedProducts->count());



        if ($relatedProducts->count() < $limit) {
            // Log::info('Count before Step 2 Check: ' . $relatedProducts->count());
            // Log::info('Entering Step 2');
            // **Bước 2: Nếu chưa đủ sản phẩm, tìm thêm theo DANH MỤC (Ưu tiên thứ ba) - ĐÃ SỬA ĐỔI**
            $productCategoryIds = $product->categories->pluck('id');
            $relatedByCategory = Product::with('reviews', 'productVariants', 'categories')
                ->where('id', '!=', $product->id)
                ->where('is_active', 1)
                ->whereHas('categories', function ($query) use ($productCategoryIds) { // Chỉ tìm theo categoryIds
                    $query->whereIn('category_product.category_id', $productCategoryIds);
                })
                ->limit($limit - $relatedProducts->count()) // Chỉ lấy số lượng còn thiếu
                ->get();

            $relatedProducts = $relatedProducts->concat($relatedByCategory); // Gộp kết quả danh mục vào
        }


        // **Bước 3: Tính số sao đánh giá và Giới hạn số lượng cuối cùng (giữ nguyên)**
        $relatedProducts = $relatedProducts->unique('id')->take($limit);
        foreach ($relatedProducts as $relatedProduct) {
            $averageRating = $relatedProduct->reviews->avg('rating') ?? 0;
            $relatedProduct->average_rating = number_format($averageRating, 1);
        }

        $relatedProducts = $relatedProducts->unique('id')->take($limit);
        foreach ($relatedProducts as $relatedProduct) {
            $averageRating = $relatedProduct->reviews->avg('rating') ?? 0;
            $relatedProduct->average_rating = number_format($averageRating, 1);
            $relatedProduct->representative_price = $this->getProductRepresentativePrice($relatedProduct);
        }

        return $relatedProducts->values();
    }


    private function getProductRepresentativePrice(Product $prod)
    {
        $minVariantPrice = null;

        foreach ($prod->productVariants as $variant) {
            if ($variant->sale_price > 0) {
                if ($minVariantPrice === null || $variant->sale_price < $minVariantPrice) {
                    $minVariantPrice = $variant->sale_price;
                }
            }
        }

        if ($minVariantPrice !== null) {
            return $minVariantPrice;
        }

        if ($prod->sale_price > 0) {
            return $prod->sale_price;
        }
        return $prod->price > 0 ? $prod->price : 1;
    }

    public function detailModal($id)
    {
        // Giá hiển thị (display_price) - RAW SQL expression (GIỮ NGUYÊN cho sản phẩm GỐC)
        $priceFiled = DB::raw('
        CASE
            WHEN products.type = 1 THEN (  
                SELECT
                    CASE
                        WHEN EXISTS (SELECT 1 FROM product_variants WHERE product_variants.product_id = products.id AND product_variants.sale_price > 0) THEN
                            CASE
                                WHEN MIN(product_variants.sale_price) > 0 THEN MIN(product_variants.sale_price)
                                ELSE MIN(product_variants.price)
                            END
                        ELSE
                            MIN(product_variants.price)
                    END
                FROM product_variants
                WHERE product_variants.product_id = products.id AND product_variants.price > 0
            )
            ELSE  
                CASE
                    WHEN products.is_sale = 1 THEN
                        CASE
                            WHEN products.sale_price > 0 THEN products.sale_price
                            ELSE products.price
                        END
                    ELSE
                        products.price
                END
        END');

        // Giá gốc (original_price) - RAW SQL expression (GIỮ NGUYÊN cho sản phẩm GỐC)
        $originalPriceFiled = DB::raw('
        CASE
            WHEN products.type = 1 THEN ( 
                SELECT
                    CASE
                        WHEN COUNT(*) > 0 THEN MAX(product_variants.price)
                        ELSE products.price
                    END
                FROM product_variants
                WHERE product_variants.product_id = products.id AND product_variants.price > 0
            )
            ELSE products.price 
        END');

        $soldCountSubQuerySql = '
        (SELECT COALESCE(SUM(order_items.quantity), 0)
        FROM order_items
        JOIN orders ON order_items.order_id = orders.id
        JOIN order_order_status ON orders.id = order_order_status.order_id
        JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
        WHERE (order_items.product_id = products.id OR order_items.product_variant_id IN
            (SELECT id FROM product_variants WHERE product_variants.product_id = products.id))
        AND order_statuses.name = "Hoàn thành")';

        //  product_stock CHO CẢ HAI TYPE
        $stockField = DB::raw('
    CASE
        WHEN products.type = 0 THEN ( 
            SELECT COALESCE(SUM(ps.stock), 0)
            FROM product_stocks ps
            WHERE ps.product_id = products.id 
        )
        WHEN products.type = 1 THEN (  
            SELECT COALESCE(SUM(ps.stock), 0)
            FROM product_variants pv
            LEFT JOIN product_stocks ps ON pv.id = ps.product_variant_id
            WHERE pv.product_id = products.id 
        )
        ELSE 0 -- Trường hợp khác (nếu có type khác) - trả về 0 hoặc tùy chỉnh
    END');
        return $this->model->selectRaw("
            products.*,
            {$soldCountSubQuerySql} as sold_count,
            " . $priceFiled->getValue(DB::connection()->getQueryGrammar()) . " as display_price,
            " . $originalPriceFiled->getValue(DB::connection()->getQueryGrammar()) . " as original_price,
            " . $stockField->getValue(DB::connection()->getQueryGrammar()) . " as stock
        ")
            ->with([
                'categories',
                'brand',
                'reviews',
                'productVariants' => function ($q) use ($priceFiled, $originalPriceFiled) {
                    // **CHỈNH SỬA QUAN TRỌNG: JOIN bảng products vào subquery productVariants**
                    $q->join('products', 'products.id', '=', 'product_variants.product_id')
                        ->orderBy('product_variants.price', 'ASC')
                        ->selectRaw("
                product_variants.*,
                product_variants.is_active,
                -- **CHỈNH SỬA LOGIC GIÁ CHO BIẾN THỂ: Tham chiếu bảng `product_variants` (alias `pv`)**
                CASE
                  -- **Giá hiển thị (display_price) cho BIẾN THỂ**
                  WHEN product_variants.sale_price > 0 THEN -- Nếu biến thể có giá sale
                    product_variants.sale_price -- Sử dụng giá sale của biến thể
                  ELSE
                    product_variants.price -- Ngược lại dùng giá gốc của biến thể
                END as display_price,
                CASE
                  -- **Giá gốc (original_price) cho BIẾN THỂ**
                  WHEN product_variants.price > 0 THEN -- Nếu biến thể có giá gốc
                    product_variants.price -- Sử dụng giá gốc của biến thể
                  ELSE
                    0 -- Trường hợp không có giá gốc (có thể tùy chỉnh)
                END as original_price
              ");
                },
                'productVariants.attributeValues.attribute',
                'productVariants.productStock'
            ])
            ->find($id);
    }


    // compare - Mạnh
    public function getByid($productId)
    {
        $product = $this->model->with('categories')->findOrFail($productId);
        return $product;
    }

    public function getByIds($productIds)
    {
        if (empty($productIds)) {
            return collect([]);
        }
        $products = $this->model->whereIn('id', $productIds)->get();
        return $products;
    }

    public function getProductsWithDetailsByIds(array $productIds, array $with = [])
    {
        return $this->model->with([
            'attributeValues' => function ($query) {
                $query->where('is_active', 1);
            },
            'productVariants.attributeValues' => function ($query) {
                $query->where('is_active', 1);
            }
        ])
            ->whereIn('id', $productIds)
            // ->where('is_active', 1)
            ->get();
    }

}