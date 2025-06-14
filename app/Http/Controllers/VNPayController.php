<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Events\OrderCreateUpdate;
use App\Events\OrderCustomer;
use App\Events\OrderPendingCountUpdated;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\HistoryOrderStatus;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderOrderStatus;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    // Khởi tạo thanh toán qua VNPay
    public function createPayment(Request $request)
    {


        try {
            $dataOrderCustomer = $request->input('dataOrder');
            $ordersItem = $request->input('ordersItem');

            $couponCode = $dataOrderCustomer['coupon_code'] ?? null;
            $discountValue = 0;
            $coupon = null;

            $userCheckVerify = User::where('id', $dataOrderCustomer["user_id"])->first();

            if (!$userCheckVerify->email_verified_at) {
                return redirect('/cart-checkout')->with('error', "Xác minh tài khoản trước khi mua hàng!");
            }
            if ($userCheckVerify->order_blocked_until) {
                return response()->json(["status" => "error", "message" => "Khóa đặt hàng đến " . Carbon::parse($userCheckVerify->order_blocked_until)->format('H:i:s d/m/Y')]);

            }
            if (!$dataOrderCustomer['fullname']) {
                return response()->json(["status" => "error", "message" => "Vui lòng nhập địa chỉ người nhận"]);
            }

            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();
                if (!$coupon || (int) $coupon->usage_limit - (int) $coupon->usage_count == 0) {
                    return response()->json(["status" => "error", "message" => "Mã giảm giá không hợp lệ hoặc đã hết."]);
                }
                if ($coupon->is_expired == 1 && (now()->lt($coupon->start_date) || now()->gt($coupon->end_date))) {
                    return response()->json(["status" => "error", "message" => "Mã giảm giá hết hạn."]);
                }

                $couponUser = CouponUser::where('coupon_id', $coupon->id)->where("user_id", $dataOrderCustomer["user_id"])->first();

                if (!$couponUser) {
                    return response()->json(["status" => "error", "message" => "Không tìm thấy người dùng mã giảm giá."]);
                }

                if ($couponUser->amount <= 0) {
                    return response()->json(["status" => "error", "message" => "Số lượng mã giảm giá không đủ."]);
                }
            }

            foreach ($ordersItem as $item) {
                if ($item["product_variant_id"]) {
                    $productStock = ProductStock::where('product_variant_id', $item['product_variant_id'])
                        ->lockForUpdate()
                        ->first();
                    $product_product_variant_id = Product::where('id', $item['product_id'])->where('is_active', 1)
                        ->lockForUpdate()
                        ->first();
                    if (!$product_product_variant_id) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " không còn được lưu hành"]);
                    }
                    if (!$productStock || $productStock->stock < $item['quantity']) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " không còn đủ số lượng trong kho"]);
                    }
                } else {
                    $productStock = ProductStock::where('product_id', $item['product_id'])
                        ->lockForUpdate()
                        ->first();
                    $product_product_id = Product::where('id', $item['product_id'])->where('is_active', 1)
                        ->lockForUpdate()
                        ->first();

                    if (!$product_product_id) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " không còn được lưu hành"]);
                    }
                    if (!$productStock || $productStock->stock < $item['quantity']) {
                        DB::rollBack();
                        return response()->json(["status" => "error", "message" => "Sản phẩm " . $item["name"] . " không còn đủ số lượng trong kho"]);
                    }
                }



                if ($item["product_variant_id"]) {
                    $cartItem = CartItem::where('user_id', $dataOrderCustomer['user_id'])
                        ->where('product_variant_id', $item['product_variant_id'])->first();


                    if ($cartItem->quantity != $item['quantity_variant']) {
                        DB::rollBack();

                        return response()->json(["status" => "error", "type" => "errCart", "message" => "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " đã bị thay đổi số lượng trong giỏ hàng"]);
                    }
                } else {
                    $cartItem = CartItem::where('user_id', $dataOrderCustomer['user_id'])
                        ->where('product_id', $item['product_id'])->first();

                    if ($cartItem->quantity != $item['quantity']) {
                        DB::rollBack();

                        return response()->json(["status" => "error", "type" => "errCart", "message" => "Sản phẩm " . $item["name"] . " đã bị thay đổi số lượng trong giỏ hàng"]);
                    }
                }
            }

            $request->session()->put('order_data_customer', $dataOrderCustomer);
            $request->session()->put('order_item_data_customer', $ordersItem);

            // \Log::info($request->session()->all());

            $vnp_TmnCode = "2FY9THKI"; // Mã TMN từ VNPay
            $vnp_HashSecret = "Y748M2B408D0C0IBE3EME1SAJL1UAD0T"; // Chuỗi bí mật từ VNPay
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán (sandbox hoặc production)
            $vnp_ReturnUrl = route('vnpay.return'); // URL nhận kết quả thanh toán

            $orderId = uniqid(); // Mã đơn hàng duy nhất
            $amount = $request->input('amount'); // Số tiền
            $orderInfo = "Thanh toán đơn hàng #$orderId";
            $locale = 'vn'; // Ngôn ngữ
            $ipAddr = $request->ip(); // Lấy địa chỉ IP của người dùng

            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $amount * 100, // VNPay yêu cầu số tiền phải nhân 100
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $ipAddr,
                "vnp_Locale" => $locale,
                "vnp_OrderInfo" => $orderInfo,
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_TxnRef" => $orderId,
            ];

            // Sắp xếp dữ liệu theo thứ tự key
            ksort($inputData);
            $query = "";
            $i = 0;

            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;

            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            return response()->json(['url' => $vnp_Url]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    // Xử lý phản hồi từ VNPay
    public function handleReturn(Request $request)
    {
        $vnp_HashSecret = "Y748M2B408D0C0IBE3EME1SAJL1UAD0T"; // Chuỗi bí mật từ VNPay
        $inputData = $request->all();

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($inputData['vnp_ResponseCode'] == '00') {

                try {

                    $dataOrderCustomer = $request->session()->get('order_data_customer');
                    $ordersItem = $request->session()->get('order_item_data_customer');

                    // Thanh toán thành công

                    DB::beginTransaction();

                    $couponCode = $dataOrderCustomer['coupon_code'] ?? null;
                    $discountValue = 0;
                    $coupon = null;

                    $userCheckVerify = User::where('id', $dataOrderCustomer["user_id"])->first();

                    if (!$userCheckVerify->email_verified_at) {
                        return redirect('/cart-checkout')->with('error', "Xác minh tài khoản trước khi mua hàng!");
                    }
                    if ($userCheckVerify->order_blocked_until) {
                        return response()->json(["status" => "error", "message" => "Khóa đặt hàng đến " . Carbon::parse($userCheckVerify->order_blocked_until)->format('H:i:s d/m/Y')]);

                    }

                    if ($couponCode) {
                        $coupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

                        if (!$coupon) {
                            return redirect('/cart-checkout')->with('error', "Mã giảm giá không hợp lệ.");

                        }

                        if ((int) ($coupon->usage_limit ?? 0) - (int) ($coupon->usage_count ?? 0) == 0) {
                            return response()->json(["status" => "error", "message" => "Mã giảm giá đã hết lượt sử dụng."]);
                        }

                        if (
                            $coupon->is_expired == 1 &&
                            (($coupon->start_date && now()->lt($coupon->start_date)) ||
                                ($coupon->end_date && now()->gt($coupon->end_date)))
                        ) {
                            return redirect('/cart-checkout')->with('error', "Mã giảm giá đã hết hạn.");

                        }

                        $couponUser = CouponUser::where('coupon_id', $coupon->id)->where("user_id", $dataOrderCustomer["user_id"])->first();

                        if (!$couponUser) {
                            return redirect('/cart-checkout')->with('error', "Không tìm thấy người dùng mã giảm giá.");

                        }

                        if ($couponUser->amount <= 0) {
                            return redirect('/cart-checkout')->with('error', "Số lượng mã giảm giá không đủ.hàng!");

                        }

                        $coupon->usage_count = (int) $coupon->usage_count + 1;
                        $coupon->save();

                        // Cập nhật amount của couponUser
                        $dataNewAmount = (int) $couponUser->amount - 1;

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
                        'is_paid' => 1,
                        'coupon_id' => isset($coupon) ? $coupon->id : null,
                        'coupon_discount_value' => $dataOrderCustomer["coupon_discount_value"],
                        'coupon_discount_type' => $dataOrderCustomer["coupon_discount_type"],
                        'coupon_code' => $dataOrderCustomer["coupon_code"],
                        'max_discount_value' => $dataOrderCustomer["max_discount_value"],

                    ]);

                    foreach ($ordersItem as $item) {
                        if ($item["product_variant_id"]) {
                            $productStock = ProductStock::where('product_variant_id', $item['product_variant_id'])
                                ->lockForUpdate()
                                ->first();
                            $product_product_variant_id = Product::where('id', $item['product_id'])->where('is_active', 1)
                                ->lockForUpdate()
                                ->first();
                            if (!$product_product_variant_id) {
                                DB::rollBack();
                                return redirect('/cart-checkout')->with('errorCart', "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " không còn được lưu hành");
                            }
                            if (!$productStock || $productStock->stock < $item['quantity']) {
                                DB::rollBack();
                                return redirect('/cart-checkout')->with('error', "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " không còn đủ số lượng trong kho");
                            }
                        } else {
                            $productStock = ProductStock::where('product_id', $item['product_id'])
                                ->lockForUpdate()
                                ->first();
                            $product_product_id = Product::where('id', $item['product_id'])->where('is_active', 1)
                                ->lockForUpdate()
                                ->first();

                            if (!$product_product_id) {
                                DB::rollBack();
                                return redirect('/cart-checkout')->with('error', "Sản phẩm " . $item["name"] . " không còn được lưu hành");
                            }
                            if (!$productStock || $productStock->stock < $item['quantity']) {
                                DB::rollBack();
                                return redirect('/cart-checkout')->with('error', "Sản phẩm " . $item["name"] . " không còn đủ số lượng trong kho");
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
                                return redirect('/cart-checkout')->with('error', "Sản phẩm " . $item["name"] . " loai " . $item["name_variant"] . " đã bị thay đổi số lượng trong giỏ hàng");
                            }
                        } else {
                            $cartItem = CartItem::where('user_id', $dataOrderCustomer['user_id'])
                                ->where('product_id', $item['product_id'])->first();

                            if ($cartItem->quantity == $item['quantity']) {
                                $cartItem->delete();
                            } else {
                                return redirect('/cart-checkout')->with('error', "Sản phẩm " . $item["name"] . " đã bị thay đổi số lượng trong giỏ hàng");
                            }
                        }
                    }


                    OrderOrderStatus::create([
                        "order_status_id" => "1",
                        "order_id" => $order->id,
                    ]);

                    HistoryOrderStatus::create([
                        "order_status_id" => "1",
                        "order_id" => $order->id,
                    ]);

                    $user = User::where('id', $dataOrderCustomer["user_id"])->first();


                    $admins = User::where('role', 2)
                        ->orWhere('role', 1)
                        ->get();

                    $message = "Đơn Hàng {$order->code} Mới Được thanh toán online thành công !";

                    foreach ($admins as $admin) {
                        Notification::create([
                            'user_id' => $admin->id,
                            'message' => $message,
                            'read' => false,
                            'type' => NotificationType::Order,
                            'order_id' => $order->id
                        ]);
                    }

                    event(new OrderCustomer($order, $message));
                    event(new OrderCreateUpdate($order));
                    event(new OrderPendingCountUpdated());

                    DB::commit();
                    session()->forget('selectedProducts');
                    session()->forget('totalPrice');
                    $request->session()->forget('order_data_customer');
                    $request->session()->forget('order_item_data_customer');


                    return redirect('/page_successfully')->with('success', 'Thanh toán thành công.');
                    //code...
                } catch (\Throwable $th) {
                    DB::rollBack();
                    Log::error($th);
                    $request->session()->forget('order_data_customer');
                    $request->session()->forget('order_item_data_customer');
                    return redirect('/cart-checkout')->with('error', 'Có lỗi xảy ra trong quá trình tạo đơn hàng - Tiền sẽ được hoàn lại cho bạn trong thời gian ngắn nhất.');
                }
            } else {
                // Thanh toán thất bại
                $request->session()->forget('order_data_customer');
                $request->session()->forget('order_item_data_customer');
                return redirect('/cart-checkout')->with('error', 'Thanh toán không thành công.');
            }
        } else {
            // Sai chữ ký
            $request->session()->forget('order_data_customer');
            $request->session()->forget('order_item_data_customer');
            return redirect('/cart-checkout')->with('error', 'Có lỗi xảy ra trong quá trình thanh toán.');
        }
    }
}
