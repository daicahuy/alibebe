<?php

namespace App\Http\Controllers\Web\Client;
use App\Http\Controllers\Controller;
use App\Services\Web\Client\CompareService;
use Cookie;
use Illuminate\Http\RedirectResponse;
// use Request;
use Illuminate\Http\Request;
use Log;// Import chính xác class Request từ Illuminate\Http

class CompareController extends Controller
{
    protected CompareService $compareService;
    public function __construct(CompareService $compareService)
    {
        $this->compareService = $compareService;
    }

    //get  list compare
    public function getComparedProducts(Request $request)
    {
        $compareListCookie = $_COOKIE['compare_list'] ?? null;
        $compareList = $compareListCookie ? json_decode($compareListCookie) : [];
        // dd($compareList);

        if (empty($compareList)) {
            return view('client.pages.compare', ['productsData' => [], 'isEmpty' => true]);
        }

        $productsData = $this->compareService->getComparedProductsData($compareList);
        // dd($productsData);
        

        return view('client.pages.compare', [
            'productsData' => $productsData,
            'isEmpty' => false,
        ]);
    }


}