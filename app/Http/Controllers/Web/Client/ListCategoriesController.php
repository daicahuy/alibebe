<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListCategoriesFilterRequest;
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
    public function index(ListCategoriesFilterRequest $request, $category = null)
    {
        // dd($request->all());
        $listParentCategories = $this->listCategoriesService->listParentCate();

        $perpage = $request->input('per_page', 5);
        $sortBy = $request->input('sort_by', 'default');
        $currentFilters = $request->query();
        $filters = []; // mảng lưu id của category, và các dư liệu từ currentFilters
        if ($category) {
            $filters['category'] = [$category];
        }

        $filters = array_merge($filters, $currentFilters);

        $listProductCate = $this->listCategoriesService->listProductCate($perpage, $sortBy, $filters);
        $listStar = $this->listCategoriesService->getAllReviews();
        $listVariantAttributes = $this->listCategoriesService->listVariantAttributes($category);

        // dd($listProductCate); 

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
