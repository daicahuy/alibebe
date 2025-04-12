<?php

namespace App\Jobs;

use App\Events\UserLocked;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\UserLockedMail; 
use Illuminate\Support\Facades\Mail;

class SendUserLockedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $reason;

    /**
     * Create a new job instance.
     *
     * @param  int  $userId
     * @param  string  $reason
     * @return void
     */
    public function __construct(int $userId, string $reason)
    {
        $this->userId = $userId;
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::findOrFail($this->userId); // Truy vấn lại user từ database
        event(new UserLocked($user->id, $this->reason));
        Mail::to($user->email)->send(new UserLockedMail($user, $this->reason));
    }
}