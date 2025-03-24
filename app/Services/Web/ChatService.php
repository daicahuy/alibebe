<?php

namespace App\Services\Web;

use App\Enums\ChatSessionStatusType;
use App\Enums\MessageType;
use App\Enums\UserRoleType;
use App\Events\NewMessageSent;
use App\Models\Message;
use App\Repositories\ChatSessionRepository;
use App\Repositories\MessageRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ChatService
{
    protected $chatSessionRepository;
    protected $messageRepository;
    public function __construct(
        ChatSessionRepository $chatSessionRepository,
        MessageRepository $messageRepository
    ) {
        $this->chatSessionRepository = $chatSessionRepository;
        $this->messageRepository = $messageRepository;
    }
    // lấy tất cả phiên chat với mối quan hệ liên quan
    public function getAllChatsSession()
    {
        $data =  $this->chatSessionRepository->getAllChatSessionWithRelation();
        return $data;
    }
    // Lấy Những Đoạn Chat Đã Đóng
    public function getAllChatsIsClosed()
    {
        $data = $this->chatSessionRepository->getAllChatSessionWithRelationClosed();
        return $data;
    }
    // Lấy thông tin chi tiết của 1 phiên chat dựa vào ID
    public function getChatSession($chatSessionId)
    {
        try {
            $chatSession = $this->chatSessionRepository->getChatSession($chatSessionId);

            if ($chatSession) {
                $this->messageRepository->markAllSessionMessagesAsRead($chatSessionId, Auth()->id());
            }

            return $chatSession;
        } catch (\Throwable $th) {
            // Ghi log lỗi
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            // Trả về phản hồi lỗi
            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    // Gửi Tin nhắn cho một phiên chat
    public function sendMessage($sessionId)
    {
        // Validate input
        request()->validate([
            'message' => 'required|string',
            'type' => [
                'integer',
                Rule::in([MessageType::TEXT, MessageType::FILE, MessageType::VIDEO])
            ]
        ]);

        try {
            $user = Auth::user();
            $chatSession = $this->chatSessionRepository->getChatSession($sessionId);

            if (!$chatSession) {
                // Nếu không có phiên chat thì tạo mới - nếu là khách hàng
                if ($user->role == UserRoleType::CUSTOMER) {
                    // Tạo mới phiên chat mới danh cho khách hàng nhưng chưa có nhân viên 
                    $chatSession = $this->chatSessionRepository->create([
                        'customer_id' => $user->id,
                        'status' => ChatSessionStatusType::OPEN
                    ]);
                    $sessionId = $chatSession->id;
                } else {
                    return [
                        'status' => false,
                        'message' => 'Không tìm thấy phiên chat!'
                    ];
                }
            } else {
                // Gán nhân viên cho phiên chat nếu cần thiết
                if (($user->role == UserRoleType::EMPLOYEE || $user->role == UserRoleType::ADMIN) && !$chatSession->employee_id) {
                    $this->chatSessionRepository->assignEmployeeToSession($sessionId, $user->id);
                }

                // Kiểm tra quyền của nhân viên đối với phiên chat
                if (
                    $user->role == UserRoleType::EMPLOYEE &&
                    $chatSession->employee_id &&
                    $chatSession->employee_id != $user->id
                ) {
                    return [
                        'status' => false,
                        'message' => 'Phiên chat này đã được phân công cho nhân viên khác!'
                    ];
                }
            }

            $sender_id = $user->id;
            $message = request('message');
            $type = request('type') ?? MessageType::TEXT;

            // Thay thế đoạn tạo message cũ
            $message = $this->messageRepository->create([
                'chat_session_id' => $sessionId,
                'sender_id' => $sender_id,
                'message' => $message,
                'type' => $type
            ]);

            // Load chat session với relationships
            $chatSession = $this->chatSessionRepository->getChatSessionWithRelations($sessionId);

            // Broadcast event
            event(new NewMessageSent($message, $chatSession));

            return [
                'status' => true,
                'message' => 'Gửi tin nhắn thành công!',
                'data' => $message->load('sender')
            ];
        } catch (\Throwable $th) {
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    // Bắt đầu phiên chat mới cho khách hàng và gán nhân viên nếu có
    public function startChat($customerId, $employeeId = null)
    {
        try {
            // Tìm phiên chat đã có mở cho khách hàng
            $existingSession = $this->chatSessionRepository->findActiveChatSession($customerId);

            if ($existingSession) {
                // Gán nhân viên nếu có và phiên chat chưa có nhân viên
                if ($employeeId && !$existingSession->employee_id) {
                    $this->chatSessionRepository->assignEmployeeToSession($existingSession->id, $employeeId);
                    return [
                        'status' => true,
                        'message' => 'Nhân viên đã được phân công cho phiên chat!',
                        'session_id' => $existingSession->id
                    ];
                }

                return [
                    'status' => true,
                    'message' => 'Đã có phiên chat mở cho khách hàng này!',
                    'session_id' => $existingSession->id
                ];
            }

            // nếu chưa tồn tại tạo mới chat
            $sessionData = [
                'customer_id' => $customerId,
                'employee_id' => $employeeId,
                'status' => ChatSessionStatusType::OPEN,
                'created_date' => now()
            ];

            $chatSession = $this->chatSessionRepository->create($sessionData);

            return [
                'status' => true,
                'message' => 'Khởi tạo phiên chat thành công!',
                'session_id' => $chatSession->id
            ];
        } catch (\Throwable $th) {
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    // đóng phiên chat dựa vào id
    public function closeChatSession($sessionId)
    {
        try {
            $user = Auth::user();
            $chatSession = $this->chatSessionRepository->getChatSession($sessionId);

            if (!$chatSession) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy phiên chat!'
                ];
            }

            // Kiểm tra quyền đóng chat (nhân viên hoặc admin)
            if (
                $user->role == UserRoleType::EMPLOYEE &&
                $chatSession->employee_id != $user->id &&
                $user->role != UserRoleType::ADMIN
            ) {
                return [
                    'status' => false,
                    'message' => 'Bạn không có quyền đóng phiên chat này!'
                ];
            }

            $this->chatSessionRepository->updateChatSessionStatus($sessionId, ChatSessionStatusType::CLOSED);

            return [
                'status' => true,
                'message' => 'Đã đóng phiên chat thành công!'
            ];
        } catch (\Throwable $th) {
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }
    // mở lại phiên chat cho khách hàng
    public function reopenCustomerChat($sessionId)
    {
        try {
            $user = Auth::user();
            $chatSession = $this->chatSessionRepository->getChatSessionClosed($sessionId);

            if (!$chatSession) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy phiên chat!'
                ];
            }

            // Kiểm tra quyền Mở chat (nhân viên hoặc admin)
            if ($user->role == UserRoleType::EMPLOYEE && $chatSession->employee_id != $user->id) {
                return [
                    'status' => false,
                    'message' => 'Bạn không có quyền mở phiên chat này!'
                ];
            }

            $this->chatSessionRepository->updateChatSessionStatus($chatSession->id, ChatSessionStatusType::OPEN);

            return [
                'status' => true,
                'message' => 'Mở lại phiên chat thành công!',
                'session_id' => $sessionId
            ];
        } catch (\Throwable $th) {
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    public function forceDestroy($sessionId)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $chatSession = $this->chatSessionRepository->getChatSessionClosed($sessionId);

            if (!$chatSession) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy phiên chat!'
                ];
            }

            // Kiểm tra quyền đóng chat (nhân viên hoặc admin)
            if (
                $user->role == UserRoleType::EMPLOYEE &&
                $chatSession->employee_id != $user->id &&
                $user->role != UserRoleType::ADMIN
            ) {
                return [
                    'status' => false,
                    'message' => 'Bạn không có quyền cóa phiên chat này!'
                ];
            }

            Message::where('chat_session_id', $sessionId)->delete();

            $chatSession->delete();

            DB::commit();

            return [
                'status' => true,
                'message' => 'Đã Xóa Phiên Chat !!!'
            ];
        } catch (\Throwable $th) {
            Log::error(
                "Error In " . __CLASS__ . "@" . __FUNCTION__,
                [
                    'message' => $th->getMessage(),
                    'data' => $data ?? 'No data'
                ]
            );

            DB::rollBack();

            return [
                'status' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!'
            ];
        }
    }

    public function searchUsers($searchTerm)
    {
        return $this->chatSessionRepository->searchUsers($searchTerm);
    }

    //======================= Client ====================

    public function getClientSession($userId)
    {
        try {
            $session = $this->chatSessionRepository->findActiveChatSession($userId);

            if (!$session) {
                $newSession = $this->startChat($userId);
                $session = $this->chatSessionRepository->getChatSession($newSession['session_id'], $userId);
            }

            return [
                'status' => true,
                'session' => $session,
                'messages' => $session->messages,
                'employee' => $session->employee,
                'customer' => $session->customer
            ];
        } catch (\Exception $e) {
            Log::error('Client session error: ' . $e);
            return $this->formatError('Không thể khởi tạo phiên chat');
        }
    }

    public function sendClientMessage($userId, $message, $type = 1)
    {
        try {
            $session = $this->chatSessionRepository->findActiveChatSession($userId);

            if (!$session) {
                $newSession = $this->startChat($userId);
                $sessionId = $newSession['session_id'];
            } else {
                $sessionId = $session->id;
            }


            $message = $this->messageRepository->create([
                'chat_session_id' => $sessionId,
                'sender_id' => $userId,
                'message' => $message,
                'type' => $type
            ]);

            $chatSession = $this->chatSessionRepository->getChatSessionWithRelations($sessionId);
            event(new NewMessageSent($message, $chatSession));

            return [
                'status' => true,
                'message' => 'Tin nhắn đã được gửi',
                'data' => $message->load('sender')
            ];
        } catch (\Exception $e) {
            Log::error('Client send message error: ' . $e->getMessage());
            return $this->formatError('Gửi tin nhắn thất bại');
        }
    }

    public function getClientMessages($userId)
    {
        try {
            $session = $this->chatSessionRepository->findActiveChatSession($userId);

            if (!$session) {
                return $this->formatError('Không tìm thấy phiên chat', false);
            }

            return [
                'status' => true,
                'messages' => $this->messageRepository->getMessagesBySession($session->id)
            ];
        } catch (\Exception $e) {
            Log::error('Client get messages error: ' . $e->getMessage());
            return $this->formatError('Lỗi tải tin nhắn');
        }
    }

    private function formatError($message, $logError = true)
    {
        if ($logError) {
            Log::error($message);
        }

        return [
            'status' => false,
            'message' => $message
        ];
    }
}
