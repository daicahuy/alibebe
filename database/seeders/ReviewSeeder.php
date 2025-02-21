<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $this->fakeReview();
        
    }

    public function fakeReview()
    {  
        $reviews = [
            [
                'product_id' => 1,
                'order_id' => 10,
                'user_id' => 2,
                'rating' => 5,
                'review_text' => 'Sản phẩm rất tốt, đúng mô tả. Giao hàng nhanh!',
                'reason' => null, // Chỉ định rõ null
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'order_id' => 11,
                'user_id' => 3,
                'rating' => 4,
                'review_text' => 'Hàng đẹp, nhưng đóng gói chưa thực sự chắc chắn.',
                'reason' => null, // Đảm bảo cột có giá trị hợp lệ
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'order_id' => 12,
                'user_id' => 4,
                'rating' => 3,
                'review_text' => 'Sản phẩm ổn, nhưng thời gian giao hơi lâu.',
                'reason' => 'Giao hàng chậm',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'order_id' => 13,
                'user_id' => 5,
                'rating' => 2,
                'review_text' => 'Sản phẩm bị lỗi nhẹ, nhưng shop hỗ trợ đổi trả nhanh.',
                'reason' => 'Sản phẩm lỗi',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'order_id' => 14,
                'user_id' => 6,
                'rating' => 1,
                'review_text' => 'Không giống mô tả, chất lượng không tốt.',
                'reason' => 'Không đúng mô tả',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('reviews')->insert($reviews);
        

    }
}