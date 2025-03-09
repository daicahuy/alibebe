<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected HomeService $HomeService;
    public function __construct(HomeService $HomeService)
    {
        $this->HomeService = $HomeService;
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
        if($userId){
            $aiSuggestedProducts = $this->HomeService->getAIFakeSuggest($userId);
        }else{
            $aiSuggestedProducts = $this->HomeService->getTrendingProduct();
        }
        return view('client.pages.index',
            compact('categories',
            'trendingProducts',
            'bestSellProductsToday',
            'topCategoriesInweek',
            'bestSellingProducts',
            'aiSuggestedProducts'
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
