<?php

namespace Database\Seeders;

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
        $users = User::with('addresses')->where('id', '<>', 1)->get();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(0, 10); $i++) {
                $orders[] = [
                    'code' => fake()->randomElement(['HN-', 'HCM-', 'HP-', 'NA-', 'TH-']) . fake()->unique()->numberBetween(1000, 90000),
                    'user_id' => $user->id,
                    'payment_id' => rand(1, 2),
                    'phone_number' => $user->phone_number,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'address' => $user->addresses->value('address') ?? 'Chưa có địa chỉ',
                    'note' => fake()->text(),
                    'total_amount' => rand(100000, 10000000),
                    'is_paid' => array_rand([0, 1], 1),
                    'coupon_id' => null,
                    'coupon_code' => null,
                    'coupon_description' => null,
                    'coupon_discount_type' => null,
                    'coupon_discount_value' => null,
                    'created_at' => now()->subDays(rand(0, 90)),
                    'updated_at' => now(),
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
            for ($i = 1; $i <= rand(1, 5); $i++) {
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
                        'quantity_variant' => rand(1, 5),
                    ];
                }
                else if ($product->isSingle()) {
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => null,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => rand(1, 5),
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
            $order->orderStatuses()->attach(1);
        }
    }
}
