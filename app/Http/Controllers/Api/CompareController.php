<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\Web\Client\CompareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class CompareController extends Controller
{
    protected CompareService $compareService;
    public function __construct(CompareService $compareService)
    {
        $this->compareService = $compareService;
    }

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


    // add queue
//     public function addToCompare(Request $request, $productId)
// {
//     $this->compareService->addProductToCompareList($productId);
//     return response()->json([
//         'status' => 'success',
//         'compareList' => $this->compareService->getCompareList()
//     ]);
// }

// public function removeFromCompare(Request $request, $productId)
// {
//     $this->compareService->removeProductFromCompareList($productId);
//     return response()->json([
//         'status' => 'success',
//         'compareList' => $this->compareService->getCompareList()
//     ]);
// }

    

    // public function getComparedProducts(Request $request)
    // {
    //     $compareListCookie = $_COOKIE['compare_list'] ?? null;
    //     $compareList = $compareListCookie ? json_decode($compareListCookie) : [];

    //     if (empty($compareList)) {
    //         return view('client.pages.compare.compare', ['productsData' => [], 'isEmpty' => true]);
    //     }

    //     $productsData = $this->compareService->getComparedProductsData($compareList);
    //     dd($productsData);
    //     // **Controller có thể không cần format dữ liệu thêm nữa, Service đã trả về cấu trúc phù hợp**

    //     return view('client.pages.compare', [
    //         'productsData' => $productsData,
    //         'isEmpty' => false,
    //     ]);

    // }
    // public function addToCompare(Request $request, $productId)
    // {
    //     \Log::info('[CompareController::addToCompare] START', ['productId' => $productId, 'request' => $request->all()]); // Log đầu method

    //     try {
    //         $count = $this->compareService->addProductToCompare($productId);
    //         \Log::info('[CompareController::addToCompare] SUCCESS', ['count' => $count]); // Log thành công
    //         return response()->json(['count' => $count], 200);
    //     } catch (\Throwable $th) {
    //         \Log::error('[CompareController::addToCompare] ERROR', ['message' => $th->getMessage(), 'productId' => $productId, 'trace' => $th->getTraceAsString()]); // Log lỗi chi tiết
    //         return response()->json(['message' => $th->getMessage()], 400);
    //     }
    // }

    // public function removeFromCompare(Request $request, $productId)
    // {
    //     \Log::info('[CompareController::removeFromCompare] START', ['productId' => $productId, 'request' => $request->all()]); // Log đầu method

    //     $count = $this->compareService->removeProductFromCompare($productId);
    //     \Log::info('[CompareController::removeFromCompare] END', ['count' => $count]); // Log kết thúc
    //     return response()->json(['count' => $count], 200);
    // }

    // public function getCompareCount()
    // {
    //     \Log::info('[CompareController::getCompareCount] START'); // Log đầu method

    //     $count = $this->compareService->getCompareCount();
    //     \Log::info('[CompareController::getCompareCount] END', ['count' => $count]); // Log kết thúc
    //     return response()->json(['count' => $count], 200);
    // }

    // public function getComparedProducts()
    // {
    //     try {
    //         \Log::info('[CompareController::getComparedProducts] START');
    //         $products = $this->compareService->getComparedProducts();
    //         \Log::info('[CompareController::getComparedProducts] END', ['product_count' => count($products)]);
    //         return response()->json(['products' => $products], 200);
    //     } catch (\Exception $e) {
    //         \Log::error('[CompareController::getComparedProducts] ERROR', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    // public function clearCompareSession()
    // {
    //     \Log::info('[CompareController::clearCompareSession] START'); // Log đầu method

    //     $this->compareService->clearCompareSession();
    //     \Log::info('[CompareController::clearCompareSession] END'); // Log kết thúc
    //     return response()->json(['message' => 'Đã xóa'], 200);
    // }

}
