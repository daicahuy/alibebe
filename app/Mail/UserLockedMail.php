<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLockedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reason;

    public function __construct($user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    public function build()
    {
     
        return $this->subject('Tài khoản của bạn đã bị khóa')
                    ->view('client.pages.auth.emails.user_locked')
                    ->with([
                        'user' => $this->user,
                        'reason' => $this->reason,
                    ]);
    }
}