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
        // **Controller có thể không cần format dữ liệu thêm nữa, Service đã trả về cấu trúc phù hợp**

        return view('client.pages.compare', [
            'productsData' => $productsData,
            'isEmpty' => false,
        ]);
    }
    public function removeProduct(Request $request, $productId)
{
    // Ép kiểu productId thành int
    $productId = (int)$productId;

    // Lấy danh sách từ cookie (đã ép kiểu int)
    $compareList = $this->getCompareListFromCookie($request);

    // Tìm index của productId
    $index = array_search($productId, $compareList);

    if ($index === false) {
        return response()->json([
            'status' => 'error',
            'message' => 'Sản phẩm không tồn tại trong danh sách so sánh.'
        ], 400);
    }

    // Xóa và lưu cookie
    unset($compareList[$index]);
    $this->saveCompareListCookie(array_values($compareList));

    return response()->json([
        'status' => 'success',
        'compareList' => $compareList
    ]);
}

    


    // **Hàm dùng chung để lấy compareList từ cookie (KHÔNG MÃ HÓA)**
    private function getCompareListFromCookie(Request $request): array
    {
        // Đọc cookie và kiểm tra tồn tại
        $compareCookie = $request->cookie('compare_list');
        if (empty($compareCookie)) {
            return [];
        }
    
        // Giải mã JSON và kiểm tra lỗi
        $compareList = json_decode($compareCookie, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            logger()->error('Invalid compare_list cookie format', [
                'cookie_value' => $compareCookie,
                'error' => json_last_error_msg()
            ]);
            return [];
        }
    
        // Đảm bảo các ID là số nguyên
        $compareList = array_map('intval', $compareList);
        return is_array($compareList) ? $compareList : [];
    }


    // **Hàm dùng chung để lưu compareList vào cookie (KHÔNG MÃ HÓA)**
    protected function saveCompareListCookie($compareList)
    {
        logger("[ListCategoriesController@saveCompareListCookie] saveCompareListCookie called");
        Cookie::queue(Cookie::raw('compareList', json_encode($compareList), 2628000)); // Sử dụng Cookie::raw() để set cookie KHÔNG mã hóa
    }

}