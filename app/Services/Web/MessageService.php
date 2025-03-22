<?php 

namespace App\Services\Web;

use App\Repositories\MessageRepository;

class MessageService
{
    protected $messageRepository;

    public function __construct(
        MessageRepository $messageRepository
    ) {
        $this->messageRepository = $messageRepository;
    }
}