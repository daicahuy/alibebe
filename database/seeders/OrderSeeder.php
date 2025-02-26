<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
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
    }

    public function fakeOrder()
    {
        // ORDERS

        $orders = [];
        $users = User::with('addresses')->where('id', '<>', 1)->get();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $orders[] = [
                    'code' => fake()->randomElement(['HN-', 'HCM-', 'HP-', 'NA-', 'TH-']) . fake()->unique()->numberBetween(1000, 90000),
                    'user_id' => $user->id,
                    'payment_id' => rand(1, 2),
                    'phone_number' => $user->phone_number,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'address' => $user->addresses[0]->address,
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
        }

        DB::table('orders')->insert($orders);

    }

    public function fakeOrderItems()
    {
        // ORDER ITEMS
        $orders = Order::all();
        $orderItems = [];

        foreach ($orders as $order) {
            $numItems = rand(1, 5);
            for ($i = 1; $i <= $numItems; $i++) {
                $product = Product::query()->find(fake()->randomElement([$i, $i + 1, $i + 2]));
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => rand(1, 5),
                    'name_variant' => null,
                    'attributes_variant' => '[]',
                    'price_variant' => null,
                    'quantity_variant' => null,
                ];
            }
        }

        DB::table('order_items')->insert($orderItems);
    }
}
