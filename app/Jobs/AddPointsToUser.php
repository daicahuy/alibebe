<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Refund;
use App\Models\User;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddPointsToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $orderId;
    /**
     * Create a new job instance.
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orderRefund = Refund::where('order_id', $this->orderId)->first();

        if (!$orderRefund) {
            $order = Order::with('user')->find($this->orderId);

            if (!$order) {
                throw new \Exception('Order not found');
            }

            $user = $order->user;

            if (!$user) {
                throw new \Exception('User not found');
            }

            DB::transaction(function () use ($user) {
                $user->loyalty_points += 10;
                $user->save();
            });
        }
    }
}
