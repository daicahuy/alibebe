<?php

namespace App\Http\Controllers;

use App\Services\Web\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatClientController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function getSession(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $result = $this->chatService->getClientSession($user_id);
            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            Log::error('ChatClientController::getSession error', [
                'user_id' => $user_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->jsonResponse([
                'status' => false,
                'message' => 'Không thể tải phiên chat'
            ], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $message = $request->input('message');
            $type = $request->input('type', 1);

            // Log incoming message request
            Log::info('Chat message request', [
                'user_id' => $user_id,
                'message_length' => strlen($message),
                'type' => $type
            ]);

            $result = $this->chatService->sendClientMessage(
                $user_id,
                $message,
                $type
            );

            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            Log::error('ChatClientController::sendMessage error', [
                'user_id' => $user_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->jsonResponse([
                'status' => false,
                'message' => 'Gửi tin nhắn thất bại'
            ], 500);
        }
    }

    public function getMessages(Request $request)
    {
        try {
            $user_id = $request->user_id;
            $result = $this->chatService->getClientMessages($user_id);
            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            Log::error('ChatClientController::getMessages error', [
                'user_id' => $user_id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $this->jsonResponse([
                'status' => false,
                'message' => 'Không thể tải tin nhắn'
            ], 500);
        }
    }

    private function jsonResponse($result, $overrideStatus = null)
    {
        $status = $overrideStatus ?? ($result['status'] ? 200 : 400);
        return response()->json($result, $status);
    }
}
