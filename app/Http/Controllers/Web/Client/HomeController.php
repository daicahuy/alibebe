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
        $productForYou = $this->HomeService->bestSellingProduct();

        $wishlistProductIds = $this->wishlistRepository->getWishlistForUserLogin()
        ->pluck('product_id')
        ->toArray();
        $getProductByView =  $this->HomeService->getProductByView();
        return view('client.pages.index',
            compact('categories',
            'trendingProducts',
            'bestSellProductsToday',
            'topCategoriesInweek',
            'getProductByView',
            'wishlistProductIds',
            'productForYou'
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
    
    public function getSuggestions(Request $request)
    {
        $query = $request->input('query'); 

        if ($query) {
            $suggestions = $this->HomeService->getSuggestions($query);
            return response()->json($suggestions);
        }

        return response()->json();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = $this->HomeService->getProductsByQuery($query);
        $wishlistProductIds = $this->wishlistRepository->getWishlistForUserLogin()
        ->pluck('product_id')
        ->toArray();
        // dd($results);
        return view('client.pages.tim-kiem', compact('query','results','wishlistProductIds'));
    }
    
}
