<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakePayment();
    }

    public function fakePayment()
    {
        
        $payments = [
            [
                'name' => 'Thanh toán khi nhận hàng',
                'logo' => 'payments/payment_cash_on_delivery.png',
                'is_active' => 1,
            ],
            [
                'name' => 'Ví Momo',
                'logo' => 'payments/payment_momo.png',
                'is_active' => 1,
            ],
            [
                'name' => 'VNPay',
                'logo' => 'payments/payment_paypal.png',
                'is_active' => 1,
            ],
            [
                'name' => 'Paypal',
                'logo' => 'payments/payment_vnpay.png',
                'is_active' => 1,
            ]
        ];

        DB::table('payments')->insert($payments);
    }
}
