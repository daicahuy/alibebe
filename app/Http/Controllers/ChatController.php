<?php

namespace App\Http\Controllers;

use App\Enums\ChatSessionStatusType;
use App\Enums\UserRoleType;
use App\Models\ChatSession;
use App\Services\Web\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
     * Hiển thị danh sách Chat Lưu Trữ
     */
    public function closed()
    {
        $chatSessions = $this->chatService->getAllChatsIsClosed();
        return view('admin.pages.chatbox.closed', compact('chatSessions'));
    }

    /**
     * Hiển thị một phiên chat cụ thể
     */
    public function show($sessionId)
    {
        $chatSession = $this->chatService->getChatSession($sessionId);

        // Kiểm tra nếu không tìm thấy phiên chat hoặc không có quyền truy cập
        if (!$chatSession) {
            return redirect()->route('admin.chats.index')
                ->with('error', 'Không tìm thấy phiên chat hoặc bạn không có quyền truy cập!');
        }

        return view('admin.pages.chatbox.show', compact('chatSession'));
    }

    /**
     * Bắt đầu một phiên chat mới
     */
    public function startChat(Request $request)
    {
        request()->validate([
            'customer_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', UserRoleType::CUSTOMER)
            ],
            'employee_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->whereIn('role', [UserRoleType::EMPLOYEE]);
                    })
            ]
        ]);

        // Gọi service và truyền cả customer_id và employee_id
        $result = $this->chatService->startChat($request->customer_id, $request->employee_id);

        Log::info('Chat service result:', $result);

        if ($result['status']) {
            return redirect()->route('admin.chats.chat-session', $result['session_id'])
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
            return redirect()->route('admin.chats.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * thoát phiên chat cho nhân viên
     */
    public function exitChat($sessionId) {
        $chat = ChatSession::findOrFail($sessionId);

        $chat->update([
            'employee_id' => null
        ]);

        return redirect()->route('admin.chats.index')->with('success', 'Đã thoát chat.');
    }

    /**
     * Mở lại phiên chat cho khách hàng
     */
    public function reOpenChat($id)
    {
        $result = $this->chatService->reopenCustomerChat($id);

        if ($result['status']) {
            return redirect()->route('admin.chats.chat-session', $result['session_id'])
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /** 
     * Xóa Phiên CHat
     */
    public function forceDelete($id)
    {
        $result = $this->chatService->forceDestroy($id);

        if ($result['status']) {
            return redirect()->route('admin.chats.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()->with('error', $result['message']);
    }

    /**
     * Tìm Kiếm người dùng cho admin
     */
    public function searchUsers()
    {
        $searchTerm = request('search');
        $users = $this->chatService->searchUsers($searchTerm);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }
}
