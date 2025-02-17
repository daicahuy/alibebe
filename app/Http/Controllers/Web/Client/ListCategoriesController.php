<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Web\Admin\CategoryService;
use App\Services\Web\Client\ListCategoriesService;
use Illuminate\Http\Request;
use Storage;

class ListCategoriesController extends Controller
{
    protected ListCategoriesService $listCategoriesService;
    public function __construct(ListCategoriesService $listCategoriesService)
    {
        $this->listCategoriesService = $listCategoriesService;
    }
    public function index(Request $request, $category = null)
    {
        $listParentCategories = $this->listCategoriesService->listParentCate();
        $perpage = $request->input('per_page', 5);
        $sortBy = $request->input('sort_by', 'default');
        $currentFilters = $request->query();
        $listProductCate = $this->listCategoriesService->listProductCate($category, $perpage, $sortBy, $currentFilters);
        $listStar = $this->listCategoriesService->getAllReviews();
        $listVariantAttributes = $this->listCategoriesService->listVariantAttributes($category);

        // dd($currentFilters); 

        return view('client.pages.list-categories', compact(
            'listParentCategories',
            'listProductCate',
            'listVariantAttributes',
            'listStar',
            'sortBy',
            'currentFilters' //
        ));
    }

}
