<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\ListCategoriesService;
use Illuminate\Http\Request;

class ListCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected ListCategoriesService $listCategoriesService;
    public function __construct(ListCategoriesService $listCategoriesService)
    {
        $this->listCategoriesService = $listCategoriesService;
    }

    /**
     * Display the specified resource.
     */
    public function detailModal(Request $request, $id)
    {
        // dd($id);
        $product = $this->listCategoriesService->detailModal($id);
        // dd($product);
        if (!$product) {
            return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
        }

        return response()->json($product);
    }

  
}
