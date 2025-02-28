<?php

namespace App\Http\Controllers\api;

use App\Exceptions\DiscountCodeException;
use App\Http\Controllers\Controller;
use App\Jobs\CreateOrder;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\HistoryOrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOrderStatus;
use App\Models\ProductStock;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderCustomerControllerApi extends Controller
{
    public function addOrderCustomerAction(Request $request)
    {


        try {
            $dataOrderCustomer = $request->input('dataOrder');
            $ordersItem = $request->input('ordersItem');

            DB::beginTransaction();

            $couponCode = $dataOrderCustomer['coupon_code'] ?? null;
            $discountValue = 0;
            $coupon = null;

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

                if (!$coupon) {
                    return response()->json(["status" => "error", "message" => "Mã giảm giá không hợp lệ."]);
                }

                if ((INT) ($coupon->usage_limit ?? 0) - (INT) ($coupon->usage_count ?? 0) == 0) {
                    return response()->json(["status" => "error", "message" => "Mã giảm giá đã hết lượt sử dụng."]);
                }

                if (
                    $coupon->is_expired == 1 &&
                    (($coupon->start_date && now()->lt($coupon->start_date)) ||
                        ($coupon->end_date && now()->gt($coupon->end_date)))
                ) {
                    return response()->json(["status" => "error", "message" => "Mã giảm giá đã hết hạn."]);
                }

                $couponUser = CouponUser::where('coupon_id', $coupon->id)->first();

                if (!$couponUser) {
                    return response()->json(["status" => "error", "message" => "Không tìm thấy người dùng mã giảm giá."]);
                }

                if ($couponUser->amount <= 0) {
                    return response()->json(["status" => "error", "message" => "Số lượng mã giảm giá không đủ."]);
                }

                $coupon->usage_count = (INT) $coupon->usage_count + 1;
                $coupon->save();

                // Cập nhật amount của couponUser
                $dataNewAmount = (INT) $couponUser->amount - 1;

                // Cách 1: Sử dụng instance
                $couponUser->amount = $dataNewAmount;
                $couponUser->save();

            }

            $currentTime = now();
            $formattedTime = $currentTime->format('dmYHis.v');
            $userId = $dataOrderCustomer["user_id"];
            $codeOrder = "ORDER-{$formattedTime}-{$userId}";

            $order = Order::create([
                'code' => $codeOrder,
                'user_id' => $dataOrderCustomer['user_id'],
                'fullname' => $dataOrderCustomer['fullname'],
                'phone_number' => $dataOrderCustomer['phone_number'],
                'email' => $dataOrderCustomer['email'],
                'address' => $dataOrderCustomer['address'],
                'note' => $dataOrderCustomer['note'],
                'payment_id' => $dataOrderCustomer['payment_id'],
                'total_amount' => $dataOrderCustomer['total_amount_discounted'],
                'is_paid' => $dataOrderCustomer['is_paid'], // Giả sử đơn hàng chưa được thanh toán
                'coupon_id' => isset($coupon) ? $coupon->id : null,
                'coupon_discount_value' => $dataOrderCustomer["coupon_discount_value"],
                'coupon_discount_type' => $dataOrderCustomer["coupon_discount_type"],
                'coupon_code' => $dataOrderCustomer["coupon_code"],
            ]);

            foreach ($ordersItem as $item) {
                if ($item["product_variant_id"]) {
                    $productStock = ProductStock::where('product_variant_id', $item['product_variant_id'])
                        ->lockForUpdate()
                        ->first();
                    if (!$productStock || $productStock->stock < $item['quantity']) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " không còn đủ số lượng trong kho"]);
                    }
                } else {
                    $productStock = ProductStock::where('product_id', $item['product_id'])
                        ->lockForUpdate()
                        ->first();
                    if (!$productStock || $productStock->stock < $item['quantity']) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " không còn đủ số lượng trong kho"]);
                    }
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'old_price' => $item['old_price'],
                    'quantity' => $item['quantity'],
                    'name_variant' => $item['name_variant'],
                    'price_variant' => $item['price_variant'],
                    'old_price_variant' => $item['old_price_variant'],
                    'quantity_variant' => $item['quantity_variant'],
                ]);

                if ($item["product_variant_id"]) {
                    $productStock->stock -= $item['quantity_variant'];
                    $productStock->save();
                } else {
                    $productStock->stock -= $item['quantity'];
                    $productStock->save();
                }

                if ($item["product_variant_id"]) {
                    $cartItem = CartItem::where('user_id', $dataOrderCustomer['user_id'])
                        ->where('product_variant_id', $item['product_variant_id'])->first();


                    if ($cartItem->quantity == $item['quantity_variant']) {
                        $cartItem->delete();
                    } else {


                        $quantityCartItems = $cartItem->quantity;
                        $coupon->quantity = (INT) $quantityCartItems - (INT) $item['quantity_variant'];

                        $cartItem->save();

                    }
                } else {
                    $cartItem = CartItem::where('user_id', $dataOrderCustomer['user_id'])
                        ->where('product_id', $item['product_id'])->first();

                    if ($cartItem->quantity == $item['quantity']) {
                        $cartItem->delete();
                    } else {
                        $quantityCartItems = $cartItem->quantity;
                        $coupon->quantity = (INT) $quantityCartItems - (INT) $item['quantity'];

                        $cartItem->save();

                    }
                }
            }


            $user = User::where('id', $dataOrderCustomer["user_id"]);

            $user->loyalty_points = $user->loyalty_points + 10;
            $user->save();

            OrderOrderStatus::create([
                "order_status_id" => "1",
                "order_id" => $order->id,
            ]);

            HistoryOrderStatus::create([
                "order_status_id" => "1",
                "order_id" => $order->id,
            ]);

            DB::commit();

            session()->forget('selectedProducts');
            session()->forget('totalPrice');

            return response()->json(["status" => Response::HTTP_OK, "Messager" => "Đơn hàng đã thành công"]);


        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }

    }
}
