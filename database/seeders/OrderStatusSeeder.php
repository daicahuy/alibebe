<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->realOrderStatus();
    }

    public function realOrderStatus()
    {
        
        $statuses = [
            [
                'name' => 'Chờ xử lý',
            ],
            [
                'name' => 'Đang xử lý',
            ],
            [
                'name' => 'Đang giao hàng',
            ],
            [
                'name' => 'Đã giao hàng',
            ],
            [
                'name' => 'Giao hàng thất bại',
            ],
            [
                'name' => 'Hoàn thành',
            ],
            [
                'name' => 'Đã hủy',
            ],
        ];

        DB::table('order_statuses')->insert($statuses);
    }
}
