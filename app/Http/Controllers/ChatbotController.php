<?php

namespace App\Http\Controllers;

use App\Services\Web\Client\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('sendMessage');

        $response = $this->chatbotService->generateText($userMessage);
        if (isset($response['error'])) {
            return response()->json(['error' => 'Lỗi từ ChatbotService: ' . $response['error']], 500);
        }
        // Log toàn bộ response để xem cấu trúc
        \Log::info('Gemini API Response:', $response);

        // Xử lý response từ Gemini
        if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            return response()->json([
                'reply' => $response['candidates'][0]['content']['parts'][0]['text']
            ]);
        }

        return response()->json(['error' => 'Không thể xử lý yêu cầu'], 500);
    }
}