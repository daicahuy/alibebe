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
}
