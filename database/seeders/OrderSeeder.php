<?php

namespace Database\Seeders;

use App\Models\HistoryOrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->fakeOrder();
        $this->fakeOrderItems();
        $this->fakeOrderStatus();
    }

    public function fakeOrder()
    {
        // ORDERS
        $batchSize = 100;
        $orders = [];
        $users = User::with('addresses')->where('id', '>', 11)->get();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(15, 30); $i++) {
                $subdays = rand(0, 30);
                $orders[] = [
                    'code' => fake()->randomElement(['HN-', 'HCM-', 'HP-', 'NA-', 'TH-']) . fake()->unique()->numberBetween(1000, 90000),
                    'user_id' => $user->id,
                    'payment_id' => 2,
                    'phone_number' => $user->phone_number,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'address' => $user->addresses->value('address') ?? 'Chưa có địa chỉ',
                    'note' => fake()->randomElement(['Giao hàng nhanh nhé, tôi đang cần gấp', 'Không cần giao nhanh đâu, cứ thoải mái đi', 'Tôi đang cần gấp, giao nhanh cho tôi tôi bo thêm tiền nha cưng']),
                    'total_amount' => rand(1000000, 100000000),
                    'is_paid' => 1,
                    'coupon_id' => null,
                    'coupon_code' => null,
                    'coupon_description' => null,
                    'coupon_discount_type' => null,
                    'coupon_discount_value' => null,
                    'created_at' => now()->subDays($subdays),
                    'updated_at' => now()->subDays($subdays - 2),
                ];
            }
            if (count($orders) >= $batchSize) {
                DB::table('orders')->insert($orders);
                $orders = [];
            }
        }

        if (!empty($orders)) {
            DB::table('orders')->insert($orders);
        }

    }

    public function fakeOrderItems()
    {
        // ORDER ITEMS
        $batchSize = 100;
        $orders = Order::all();
        $orderItems = [];

        foreach ($orders as $order) {
            for ($i = 1; $i <= rand(1, 3); $i++) {
                $product = Product::query()->inRandomOrder()->first();
                if ($product->isVariant()) {
                    $productVariant = ProductVariant::query()->where('product_id', $product->id)->inRandomOrder()->first();
                    $nameVariant = '';

                    foreach ($productVariant->attributeValues as $attributeValue) {
                        $nameVariant .= $attributeValue->value . ' ';
                    }

                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $productVariant->id,
                        'name' => $product->name,
                        'price' => 0,
                        'quantity' => null,
                        'name_variant' => $nameVariant,
                        'attributes_variant' => null,
                        'price_variant' => $productVariant->sale_price ? $productVariant->sale_price : $productVariant->price,
                        'quantity_variant' => rand(1, 3),
                    ];
                } else if ($product->isSingle()) {
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => null,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => rand(1, 3),
                        'name_variant' => 'Không có phân loại',
                        'attributes_variant' => null,
                        'price_variant' => 0,
                        'quantity_variant' => null,
                    ];
                }
            }

            if (count($orderItems) >= $batchSize) {
                DB::table('order_items')->insert($orderItems);
                $orderItems = [];
            }
        }

        if (!empty($orderItems)) {
            DB::table('order_items')->insert($orderItems);
        }
    }

    public function fakeOrderStatus()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $orderStatus = $this->renderOrderStatus();
            $userId = rand(2, 11);
            $order->orderStatuses()->attach([
                $orderStatus => [
                    'modified_by' => $userId,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]
            ]);
            HistoryOrderStatus::query()->create([
                'order_id' => $order->id,
                'order_status_id' => $orderStatus,
                'user_id' => $userId,
                'created_at' => $order->updated_at,
                'updated_at' => $order->updated_at,
            ]);
        }
    }

    public function renderOrderStatus() {
        $choices = [
            5 => 93,
            6 => 5,
            4 => 2,
        ];
    
        $rand = rand(1, 100);
        $cumulative = 0;
    
        foreach ($choices as $value => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $value;
            }
        }
    }
}
