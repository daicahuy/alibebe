<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\CartItemService;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    protected $cartItemService;
    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }
    public function index()
    {
        $data = $this->cartItemService->getAllCartItem();
        // $productVariant = $this->cartItemService->getProductVariant(); 

        // dd($productVariant);
        return view('client.pages.cart-item', compact('data'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);
    
        // Nhận kết quả từ Service
        $result = $this->cartItemService->addToCart($data);
    
        // Nếu Service trả về redirect (tức là có lỗi), return luôn
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }
    
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    
    public function delete(Request $request)
    {
        $id = $request->input('id');
        // $ids = $request->input('ids',[]);
        try {
            // if($id){
                $a = $this->cartItemService->delete($id);
                // dd($a);
            // }else if( $ids){
            //     $idsArray = explode(',', $ids); // Chuyển chuỗi IDs thành mảng
            //     $this->cartItemService->deleteAll($idsArray); // Gọi phương thức xóa tất cả trong service
            // }else{}
            return back()->with('success','Xóa thành công!');
        } catch (\Exception $e) {
            // Trả về thông báo lỗi qua session
            return back()->with('error', $e->getMessage());
        }
    } 
}
