<?php

namespace App\Jobs;

use App\Exceptions\DiscountCodeException;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $dataOrderCustomer = [];

    /**
     * Create a new job instance.
     */
    public function __construct($dataOrderCustomer)
    {
        //
        $this->dataOrderCustomer = $dataOrderCustomer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        try {
            // $discountCode = $this->dataOrderCustomer['coupon_code'];
            // $totalAmount = $this->dataOrderCustomer['total_amount_discounted'];
            // $userId = $this->dataOrderCustomer['user_id'];

            Order::create([
                'user_id' => "229",
                'code' => "123123",
                'fullname' => "123123",
                'note' => "!23123123",
                'email' => "!23123123",
                'phone_number' => "!@3123123",
                'address' => "!23123123",
                'payment_id' => "2",
                'is_paid' => "1",
                'coupon_id' => "",
                'coupon_discount_type' => "",
                'coupon_discount_value' => "",
                'total_amount' => "123123",
                'coupon_code' => "",
            ]);


            // Kiểm tra mã giảm giá
            // if ($discountCode) {
            //     $discount = Coupon::where('code', $discountCode)->first();

            //     if (!$discount || (INT) $discount->usage_limit - (INT) $discount->usage_count <= 0) {
            //         throw new DiscountCodeException('Mã giảm giá đã hết.');
            //     } else {
            //         $discount->usage_count += 1;
            //         $discount->save();
            //     }
            // }

            // $currentTime = now()->format('dmYHis.v'); // Định dạng: DDMMYYYYHHMMSS.mili giây
            // $orderCode = "ORDER-{$currentTime}-{$userId}";
            // Thêm đơn hàng vào cơ sở dữ liệu
            // $order = Order::create([
            //     'user_id' => $this->dataOrderCustomer['user_id'],
            //     'code' => $orderCode,
            //     'fullname' => $this->dataOrderCustomer['fullname'],
            //     'note' => $this->dataOrderCustomer['note'],
            //     'email' => $this->dataOrderCustomer['email'],
            //     'phone_number' => $this->dataOrderCustomer['phone_number'],
            //     'address' => $this->dataOrderCustomer['address'],
            //     'payment_id' => $this->dataOrderCustomer['payment_id'],
            //     'is_paid' => $this->dataOrderCustomer['is_paid'],
            //     'coupon_id' => $this->dataOrderCustomer['coupon_id'],
            //     'coupon_discount_type' => $this->dataOrderCustomer['coupon_discount_type'],
            //     'coupon_discount_value' => $this->dataOrderCustomer['coupon_discount_value'],
            //     'total_amount' => $totalAmount,
            //     'coupon_code' => $discountCode,
            // ]);


        } catch (\Throwable $e) {
            // Ghi log lỗi hoặc xử lý ngoại lệ
            \Log::error('Error in CreateOrder Job: ' . $e->getMessage());
            throw $e; // Hoặc xử lý lỗi theo cách của bạn
        }
    }

}
