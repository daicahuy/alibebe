<?php

namespace App\Console\Commands;

use App\Services\Web\Admin\CouponService;
use Illuminate\Console\Command;

class DeleteOldTrashedItems extends Command
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        parent::__construct();
        $this->couponService = $couponService;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-trashed-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa Các Mã Giảm Giá Trong Thùng Rác Sau 7 Ngày !!!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->couponService->deleteOldTrashedCoupon(7);

        $this->info('Đã Xóa Các Mã Giảm Giá Trong Thùng Rác > 7 Ngày !!!');
    }
}
