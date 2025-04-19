<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredSaleProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:update-expired-sale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status sale after expired of product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productExpiredSales = Product::where('is_sale', 1)
        ->where('sale_price_end_at', '<=', Carbon::now())
        ->get();

        foreach ($productExpiredSales as $productExpired) {
            $productExpired->update([
                'is_sale' => 0,
                'sale_price_start_at' => NULL,
                'sale_price_end_at' => NULL,
            ]);
        }

        $this->info('Cập nhật trạng thái sản phẩm đã hết sale thành công.');
    }
}
