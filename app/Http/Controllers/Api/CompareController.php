<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Web\Client\CompareService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Log;

class CompareController extends Controller
{
    protected CompareService $compareService;
    public function __construct(CompareService $compareService)
    {
        $this->compareService = $compareService;
    }


    // add compare 
    public function addToCompareWithCheck(Request $request, $productId)
    {
        $compareList = $request->compareList ?? [];
        $productToAdd = Product::with('categories')->find($productId);
        if (!$productToAdd) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm.'], 400);
        }
        $compareProducts = Product::with('categories')->whereIn('id', $compareList)->get();

        if ($compareProducts->isNotEmpty()) {
            $firstComparedProduct = $compareProducts->first();
            $firstCompareCategories = $firstComparedProduct->categories;

            $validCategoryIds = collect([]); // Khởi tạo Collection để chứa các ID danh mục hợp lệ (cùng nhóm)

            foreach ($firstCompareCategories as $firstCategory) {
                // Lấy danh mục cha gốc của danh mục đầu tiên (nếu có)
                $rootCategory = $firstCategory;
                while ($rootCategory->parentCategory) {
                    $rootCategory = $rootCategory->parentCategory;
                }

                // Lấy danh sách ID của danh mục gốc và tất cả danh mục con cháu của nó
                $hierarchyCategoryIds = $rootCategory->getAllChildrenIds();
                $validCategoryIds = $validCategoryIds->merge($hierarchyCategoryIds); // Gộp vào danh sách các ID hợp lệ
                $validCategoryIds = $validCategoryIds->push($rootCategory->id); // Thêm ID của danh mục gốc vào danh sách hợp lệ
            }
            $validCategoryIds = $validCategoryIds->unique();// loại bỏ ID trùng lặp nếu có


            $productToAddCategories = $productToAdd->categories;
            $hasValidCategory = false;

            foreach ($productToAddCategories as $productCategory) {
                if ($validCategoryIds->contains($productCategory->id)) {
                    $hasValidCategory = true;
                    break;
                }
            }


            if (!$hasValidCategory) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng chọn sản phẩm cùng nhóm danh mục.',
                ], 400);
            }
        }

        if ($compareProducts->count() >= 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chỉ có thể so sánh tối đa 3 sản phẩm.',
            ], 400);
        }

        return response()->json(['status' => 'success']);
    }







   

}
