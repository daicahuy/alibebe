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

        $listParentCategories = $this->listCategoriesService->listParentCate(); // list danh mục (cha)

        $perpage = $request->input('per_page', 5); // perpage
        // dd($request);
        $sortBy = $request->input('sort_by', 'default');
        $listProductCate = $this->listCategoriesService->listProductCate($category, $perpage, $sortBy); // list sản phẩm

        // Lấy danh sách thuộc tính biến thể
        $listVariantAttributes = $this->listCategoriesService->listVariantAttributes($category);

        $listStar = $this->listCategoriesService->getAllReviews(); // start

        // dd($listStar);
        return view('client.pages.list-categories', compact(
            'listParentCategories',
            'listProductCate',
            'listVariantAttributes',
            'listStar',
            'sortBy'
        ));
    }

}
