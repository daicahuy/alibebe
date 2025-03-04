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
            WHEN products.type = 1 THEN (
                SELECT price 
                FROM product_variants 
                WHERE product_variants.product_id = products.id
                ORDER BY product_variants.price ASC LIMIT 1
            )
            ELSE products.price 
         END ');

        $soldCountSubQuery = DB::raw('(SELECT COALESCE(SUM(order_items.quantity),0)
         FROM order_items
         JOIN orders ON order_items.order_id = orders.id
         JOIN order_order_status ON orders.id = order_order_status.order_id
         JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
         WHERE order_items.product_id = products.id
         AND order_statuses.name = "Hoàn thành") as sold_count');


        $query->select(
            'id',
            'name',
            'thumbnail',
            DB::raw('COALESCE(NULLIF(sale_price, 0), ' . $priceFiled->getValue(DB::connection()->getQueryGrammar()) . ') as display_price'), // Nội suy giá trị của $priceFiled
            'sale_price',
            'price',
            'short_description',
            'views',
            'type',
            $soldCountSubQuery
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
                };
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
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('order_order_status', function ($join) {
                $join->on('orders.id', '=', 'order_order_status.order_id')
                    ->where('order_order_status.order_status_id', '=', 6);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->leftJoin('attribute_value_product_variant', 'product_variants.id', '=', 'attribute_value_product_variant.product_variant_id')
            ->leftJoin('attribute_values', 'attribute_value_product_variant.attribute_value_id', '=', 'attribute_values.id')
            ->select(
                DB::raw('IFNULL(product_variants.id, products.id) as product_id'),
                DB::raw('IFNULL(CONCAT(products.name, " - ", GROUP_CONCAT(attribute_values.value SEPARATOR ", ")), products.name) as product_name'),
                DB::raw('IFNULL(product_variants.price, products.price) as price'),
                DB::raw('IFNULL(
                    CASE 
                        WHEN product_variants.thumbnail LIKE "http%" THEN product_variants.thumbnail
                        ELSE CONCAT("/storage/", product_variants.thumbnail) 
                    END,
                    CASE 
                        WHEN products.thumbnail LIKE "http%" THEN products.thumbnail
                        ELSE CONCAT("/storage/", products.thumbnail) 
                    END
                ) as thumbnail'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('product_id', 'products.name', 'price', 'thumbnail')
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

    public function countTrash()
    {
        return $this->model->onlyTrashed()->count();
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
            $product->categories()->detach();// xóa reation liên quan
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
                $product->categories()->detach();// chỉ dùng cho belongtomany
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
                    $query->where('is_active', 1)->with(['attributeValues' => function ($query) {
                        $query->with('attribute');
                    }]);
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
        // Hàm này lấy giá đại diện của sản phẩm, tìm giá sale_price NHỎ NHẤT trong tất cả biến thể,
        // sau đó fallback về sale_price của sản phẩm chính, rồi đến price của sản phẩm chính.
        $getProductRepresentativePrice = function (Product $prod) {
            $minVariantPrice = null; // Khởi tạo giá biến thể nhỏ nhất là null
    
            // Duyệt qua tất cả biến thể của sản phẩm
            foreach ($prod->productVariants as $variant) {
                if ($variant->sale_price > 0) {
                    if ($minVariantPrice === null || $variant->sale_price < $minVariantPrice) {
                        $minVariantPrice = $variant->sale_price; // Cập nhật giá nhỏ nhất nếu tìm thấy giá nhỏ hơn
                    }
                }
            }
    
            // Nếu tìm thấy giá biến thể nhỏ nhất hợp lệ, trả về nó
            if ($minVariantPrice !== null) {
                return $minVariantPrice;
            }
    
            // Nếu không có giá biến thể hợp lệ, fallback về giá của sản phẩm chính
            if ($prod->sale_price > 0) {
                return $prod->sale_price;
            }
            return $prod->price > 0 ? $prod->price : 1; // Fallback cuối cùng
        };
    
        // Lấy giá đại diện của sản phẩm hiện tại để so sánh
        $comparePrice = $getProductRepresentativePrice($product);
    
        $relatedProducts = Product::with('reviews', 'productVariants') // Load thêm 'variants' relationship
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->whereBetween(
                'sale_price', // Vẫn filter ban đầu trên 'sale_price' của bảng 'products'
                [
                    $comparePrice * 0.8,
                    $comparePrice * 1.2
                ]
            )
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('category_id', $product->categories->pluck('id'));
            })
            ->orderByRaw('brand_id = ? DESC, ABS(price - ?) ASC', [$product->brand_id, $comparePrice]) // Vẫn sort ban đầu trên 'price' của bảng 'products'
            ->limit($limit)
            ->get();
    
        // Lọc lại và sắp xếp sản phẩm dựa trên giá ĐẠI DIỆN (bao gồm giá biến thể nhỏ nhất)
        $relatedProducts = $relatedProducts->filter(function ($relatedProduct) use ($comparePrice, $getProductRepresentativePrice) {
            $relatedProductPrice = $getProductRepresentativePrice($relatedProduct);
            return $relatedProductPrice >= $comparePrice * 0.8 && $relatedProductPrice <= $comparePrice * 1.2; // Lọc lại theo khoảng giá đại diện
        })->sortBy(function ($relatedProduct) use ($comparePrice, $getProductRepresentativePrice) {
            $relatedProductPrice = $getProductRepresentativePrice($relatedProduct);
            return [$relatedProduct->brand_id != $relatedProduct->brand_id, abs($relatedProductPrice - $comparePrice)]; // Sắp xếp lại, vẫn ưu tiên brand và độ lệch giá
        });
    
        $relatedProducts = $relatedProducts->take($limit); // Giới hạn lại số lượng sau lọc và sắp xếp
    
    
        // Tính số sao (không thay đổi)
        foreach ($relatedProducts as $relatedProduct) { 
            $averageRating = $relatedProduct->reviews->avg('rating') ?? 0;
            $relatedProduct->average_rating = number_format($averageRating, 1);
        }
    
        return $relatedProducts->values();
    }

    public function detailModal($id)
    {
        $soldCountSubQuerySql = '(SELECT COALESCE(SUM(order_items.quantity),0)
            FROM order_items
            JOIN orders ON order_items.order_id = orders.id
            JOIN order_order_status ON orders.id = order_order_status.order_id
            JOIN order_statuses ON order_order_status.order_status_id = order_statuses.id
            WHERE order_items.product_id = products.id
            AND order_statuses.name = "Hoàn thành")';

        return $this->model->selectRaw("products.*, {$soldCountSubQuerySql} as sold_count")
            ->with([
                'categories',
                'brand',
                'reviews',
                'productVariants' => function ($q) {
                    $q->orderBy('price', 'ASC')->select(
                        'product_id',
                        'price',
                        'sale_price',
                        'thumbnail',
                        'id',
                    );
                },
                'productVariants.attributeValues.attribute',
                'productVariants.productStock'
            ])
            ->find($id);
    }
   

    

    

   
}
