<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use App\Services\Web\Client\CartItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // dd($data);
        return view('client.pages.cart-item', compact('data'));
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);
    
        // Kiểm tra tồn kho từ bảng product_stocks
        $stock = DB::table('product_stocks')
            ->where(function ($query) use ($data) {
                $query->where('product_id', $data['product_id']);
                if (!empty($data['product_variant_id'])) {
                    $query->where('product_variant_id', $data['product_variant_id']);
                }
            })
            ->value('stock');
    
        // Nếu không có stock hoặc stock < số lượng cần mua, báo lỗi
        if (!$stock || $stock < $data['quantity']) {
            return redirect()->back()->with('error', 'Sản phẩm không đủ hàng trong kho!');
        }
    
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
            $ids = $request->input('ids', []);
            // dd($ids);
            if (is_string($ids)) {
                $ids = explode(',', $ids);
            }
            $ids = array_map('intval', (array) $ids);
    
            if ($id) {
                $this->cartItemService->delete($id);
            } elseif (!empty($ids)) {
                $this->cartItemService->deleteAll($ids);
            } else {
                return back()->with('error', 'Không có sản phẩm nào để xóa.');
            }
    
            return back()->with('success', 'Xóa thành công!');
        
    }
    
    public function countCart() {
        $data = $this->cartItemService->getAllCartItem();
        return response()->json([
            'code' => 200,
            'data' => $data
        ]);
    }
}
