<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRoleChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newRole;

    public function __construct($user, $newRole)
    {
        $this->user = $user;
        $this->newRole = $newRole;
    }

    public function build()
    {
        return $this->subject('Thông báo thay đổi quyền tài khoản')
                    ->view('client.pages.auth.emails.user_role_changed')
                    ->with([
                        'user' => $this->user,
                        'newRole' => $this->newRole,
                    ]);
    }
}