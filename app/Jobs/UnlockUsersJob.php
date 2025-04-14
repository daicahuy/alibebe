<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserOrderCancel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class UnlockUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;

    }

    public function handle()
    {
        try {
            $user = User::find($this->userId);
            $user->update(['order_blocked_until' => null]);
            UserOrderCancel::where('user_id', $this->userId)->delete();
            Log::info("User {$user->id} unlocked.");
        } catch (\Exception $e) {
            Log::error("Error unlocking user {$user->id}: " . $e->getMessage());
        }
    }
}
