<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VNPayController extends Controller
{
    // Khởi tạo thanh toán qua VNPay
    public function createPayment(Request $request)
    {
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
                // Thanh toán thành công
                return redirect('/page_successfully')->with('success', 'Thanh toán thành công.');
            } else {
                // Thanh toán thất bại
                return redirect('/cart-checkout')->with('error', 'Thanh toán không thành công.');
            }
        } else {
            // Sai chữ ký
            return redirect('/cart-checkout')->with('error', 'Có lỗi xảy ra trong quá trình thanh toán.');
        }
    }
}