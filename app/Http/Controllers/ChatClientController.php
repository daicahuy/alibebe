<?php

namespace App\Http\Controllers;

use App\Services\Web\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatClientController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function getSession(Request $request)
    {
        $result = $this->chatService->getClientSession(Auth::id());
        return $this->jsonResponse($result);
    }

    public function sendMessage(Request $request)
    {
        $result = $this->chatService->sendClientMessage(
            Auth::id(),
            $request->input('message'),
            $request->input('type', 1)
        );
        return $this->jsonResponse($result);
    }

    public function getMessages(Request $request)
    {
        $result = $this->chatService->getClientMessages(Auth::id());
        return $this->jsonResponse($result);
    }

    private function jsonResponse($result)
    {
        $status = $result['status'] ? 200 : 400;
        return response()->json($result, $status);
    }
}