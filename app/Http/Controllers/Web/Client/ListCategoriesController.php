<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListCategoriesFilterRequest;
use App\Models\Category;
use App\Repositories\WishlistRepository;
use App\Services\Web\Admin\CategoryService;
use App\Services\Web\Client\CompareService;
use App\Services\Web\Client\ListCategoriesService;
use Illuminate\Http\Request;
use Storage;

class ListCategoriesController extends Controller
{
    protected ListCategoriesService $listCategoriesService;
    protected WishlistRepository $wishlistRepository;
    protected CompareService $compareService;
    public function __construct(ListCategoriesService $listCategoriesService, WishlistRepository $wishlistRepository, CompareService $compareService)
    {
        $this->listCategoriesService = $listCategoriesService;
        $this->wishlistRepository = $wishlistRepository;
        $this->compareService = $compareService;
    }
    public function index(ListCategoriesFilterRequest $request, $slug = null)
    {
        // dd($request->all());
        $listParentCategories = $this->listCategoriesService->listParentCate();

        $perpage = $request->input('per_page', 12);
        $sortBy = $request->input('sort_by', 'default');
        $currentFilters = $request->query();
        $filters = []; // mảng lưu id của category, và các dư liệu từ currentFilters
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $filters['category'] = [$category->id];

            } else {
                abort(404, "Danh mục không tồn tại");
            }
        }

        $filters = array_merge($filters, $currentFilters);

        $wishlistProductIds = $this->wishlistRepository->getWishlistForUserLogin()
            ->pluck('product_id')
            ->toArray();
        $listProductCate = $this->listCategoriesService->listProductCate($perpage, $sortBy, $filters);
        $listStar = $this->listCategoriesService->getAllReviews($slug ? $category->id : null);
        $listVariantAttributes = $this->listCategoriesService->listVariantAttributes($slug ? $category->id : null);

        // dd($request->cookies->get('compare_list'));
        // compare
        $compareCookie = $request->cookie('compare_list');
        $compareCount = $this->compareService->CompareCount($compareCookie);
        // dd($listProductCate); 


        return view('client.pages.list-categories', compact(
            'listParentCategories',
            'listProductCate',
            'listVariantAttributes',
            'listStar',
            'sortBy',
            'currentFilters',
            'wishlistProductIds',
            'compareCount',
        ));
    }



}
