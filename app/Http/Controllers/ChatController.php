<?php

namespace App\Http\Controllers;

use App\Enums\ChatSessionStatusType;
use App\Services\Web\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Hiển thị danh sách tất cả các phiên chat
     */
    public function index()
    {
        $chatSessions = $this->chatService->getAllChatsSession();
        return view('admin.pages.chatbox.index', compact('chatSessions'));
    }

    /**
     * Hiển thị một phiên chat cụ thể
     */
    public function show($sessionId)
    {
        $chatSession = $this->chatService->getChatSession($sessionId);
        
        // Kiểm tra nếu không tìm thấy phiên chat hoặc không có quyền truy cập
        if (!$chatSession || !is_object($chatSession)) {
            return redirect()->route('admin.chats.index')
                ->with('error', $chatSession['message'] ?? 'Không tìm thấy phiên chat hoặc bạn không có quyền truy cập!');
        }
        
        return view('admin.pages.chatbox.show', compact('chatSession'));
    }

    /**
     * Bắt đầu một phiên chat mới
     */
    public function startChat(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:users,id',
            'employee_id' => 'nullable|integer|exists:users,id'
        ]);

        $result = $this->chatService->startChat(
            $request->customer_id,
            $request->employee_id
        );

        if ($result['status']) {
            return redirect()->route('admin.pages.chatbox.show', $result['session_id'])
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Gửi tin nhắn trong phiên chat
     */
    public function sendMessage(Request $request, $sessionId)
    {
        $request->validate([
            'message' => 'required|string',
            'type' => 'nullable|integer'
        ]);

        $result = $this->chatService->sendMessage($sessionId);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Đóng phiên chat
     */
    public function closeChat($sessionId)
    {
        $result = $this->chatService->closeChatSession($sessionId);

        if ($result['status']) {
            return redirect()->route('admin.pages.chatbox.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Mở lại phiên chat cho khách hàng
     */
    public function reopenChat(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer|exists:users,id'
        ]);

        $result = $this->chatService->reopenCustomerChat($request->customer_id);

        if ($result['status']) {
            return redirect()->route('admin.pages.chatbox.show', $result['session_id'])
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }
}