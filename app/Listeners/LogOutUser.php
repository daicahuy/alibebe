<?php

namespace App\Listeners;

use App\Events\UserStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogOutUser
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserStatusChanged  $event
     * @return void
     */
    public function handle(UserStatusChanged $event)
    {
        if ($event->user->status == 0) {
            try {
                Auth::logout();
                Log::info("User {$event->user->id} logged out due to status change.");
            } catch (\Exception $e) {
                Log::error("Error logging out user {$event->user->id}: " . $e->getMessage());
            }
        }
    }
}
