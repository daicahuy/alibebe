<?php

namespace App\Console\Commands;

use App\Enums\NotificationType;
use App\Enums\UserRoleType;
use App\Events\CouponExpired;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupons:check-expired-coupons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra các mã giảm giá đã hết hạn và gửi thông báo!';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Bắt đầu kiểm tra mã giảm giá hết hạn : ' . now()->format('Y-m-d H:i:s'));

        $expiredCoupons = Coupon::where('is_active', 1)
            ->where('is_expired', 1)
            ->where('end_date', '<', now())
            ->where(function ($query) {
                $query->where('is_notified',0)
                ->orWhereNull('is_notified');
            })
            ->get();

        $count = 0;

        foreach ($expiredCoupons as $coupon) {
            $message = "Mã giảm giá {$coupon->code} đã hết hạn .";

            $admins = User::where('role', UserRoleType::ADMIN)
                ->orWhere('role', UserRoleType::EMPLOYEE)
                ->get();

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => $message,
                    'read'    => false,
                    'type'    => NotificationType::Coupon,
                    'coupon_id' => $coupon->id
                ]);
            }

            event(new CouponExpired($coupon, $message));

            $coupon->is_notified = 1;
            $coupon->saveQuietly();

            $count++;
        }
        Log::info("Hoàn tất kiểm tra: Đã xử lý $count mã giảm giá hết hạn.");
        $this->info("Đã xử lý $count mã giảm giá hết hạn.");
    }
}
