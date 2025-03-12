<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Repositories\WishlistRepository;
use App\Services\Web\Client\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected HomeService $HomeService;
    protected WishlistRepository $wishlistRepository;
    public function __construct(HomeService $HomeService, WishlistRepository $wishlistRepository)
    {
        $this->HomeService = $HomeService;
        $this->wishlistRepository = $wishlistRepository;
    }
    public function index()
    {
        $userId = auth()->id();


        $categories = $this->HomeService->listCategory();
        $trendingProducts = $this->HomeService->getTrendingProduct();
        $bestSellProductsToday = $this->HomeService->getBestSellerProductsToday();
        $topCategoriesInweek = $this->HomeService->topCategoriesInWeek();
        $bestSellingProducts = $this->HomeService->getBestSellingProduct();
        // dd($bestSellingProducts);
        $wishlistProductIds = $this->wishlistRepository->getWishlistForUserLogin()
        ->pluck('product_id')
        ->toArray();
        $aiSuggestedProducts = $userId ? $this->HomeService->getAIFakeSuggest($userId) : $this->HomeService->getTrendingProduct();

        if ($aiSuggestedProducts->isEmpty()) {
            $aiSuggestedProducts = $this->getPopularProducts(); // Nếu AI không gợi ý được, lấy sản phẩm phổ biến
        }
        
        return view('client.pages.index',
            compact('categories',
            'trendingProducts',
            'bestSellProductsToday',
            'topCategoriesInweek',
            'bestSellingProducts',
            'aiSuggestedProducts',
            'wishlistProductIds'
        ));
    }
    public function header()  {
        $categories = $this->HomeService->getAllCategories();
        $categoryIds = collect();
        foreach ($categories as $category) {
            $categoryIds = $categoryIds->merge($category->getAllChildrenIds());
        }
        return view('client.layoutspartials.header',compact('categories','categoryIds'));
    }
    
}
