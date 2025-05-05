<?php

namespace App\Jobs;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Throwable;

class UnlockOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderId;
    protected $timeout;


    public function __construct(int $orderId, int $timeout = 60)
    {
        $this->orderId = $orderId;
        $this->timeout = $timeout;
    }


    public function handle()
    {
        $order = Order::find($this->orderId);
        if ($order) {
            if ($order->locked_status) {
                $order->locked_status = 0;
                $order->save();
                event(new OrderStatusUpdated($this->orderId, "", ""));

            } else {
                Log::info("Order {$this->orderId} was already unlocked.");
            }
        } else {
            Log::error("Order {$this->orderId} not found.");
        }
    }

    public function failed(Throwable $exception)
    {
        Log::error("Job UnlockOrderJob failed for order {$this->orderId}: " . $exception->getMessage());
    }
}
