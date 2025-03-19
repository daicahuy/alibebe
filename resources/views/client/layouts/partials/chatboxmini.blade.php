@auth
    <div class="container" style="margin-left: 30px">
        <!-- Chat Widget Start -->
        <div id="chatWidget" class="chat-widget position-fixed bottom-0 start-0 shadow-lg bg-white rounded-3 d-none"
            style="width: 350px; z-index: 10000; margin-bottom: 40px; margin-left: 40px;">
            <div class="text-white d-flex justify-content-between align-items-center p-3 rounded-top"
                style="background: #0da487 !important;">
                <span>Nhắn Tin Hỗ Trợ</span>
                <button class="btn-close text-white" id="toggleChat"></button>
            </div>
            <div class="chat-body overflow-auto p-3" id="chatBody" style="height: 300px;">
                <div id="chatMessages" class="chat-messages">
                    <div class="text-center text-muted">Chưa có tin nhắn nào</div>
                </div>
            </div>
            <form id="chatForm" class="chat-footer d-flex p-3 border-top">
                <input type="text" id="messageInput" class="form-control me-2 rounded-pill shadow-sm"
                    placeholder="Nhập tin nhắn...">
                <button type="submit" class="btn btn-theme rounded-pill shadow-sm">Gửi</button>
            </form>
        </div>

        <!-- Button mở chat -->
        <button id="openChat" class="btn position-fixed"
            style="bottom: 90px; left: 40px; width: 50px; height: 50px; border-radius: 50%; background-color: #0da487; color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 10000;">
            <i class="fas fa-comments"></i>
        </button>
    </div>
    <style>
        /* Chat container */
        .chat-body {
            background-color: #f8f9fa;
        }

        /* Tin nhắn từ admin */
        .admin-message {
            display: flex;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .admin-initial {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .admin-text {
            background-color: white;
            padding: 8px 12px;
            border-radius: 4px;
            max-width: 85%;
            word-break: break-word;
            margin-top: 4px;
        }

        /* Tin nhắn từ người dùng */
        .user-message {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 8px;
        }

        .user-text {
            background-color: #0da487;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            max-width: 85%;
            word-break: break-word;
            margin-top: 4px;
            position: relative;
        }

        /* Thời gian tin nhắn */
        .message-time {
            font-size: 11px;
            color: #6c757d;
            display: inline-block;
            margin-left: 8px;
        }

        .user-message .message-time {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Trạng thái tin nhắn */
        .message-status {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
            display: block;
            text-align: right;
            margin-top: 2px;
        }

        /* Nút gửi */
        .btn-theme {
            background-color: #0da487;
            color: white;
        }

        .btn-theme:hover {
            background-color: #0b9277;
            color: white;
        }
    </style>
@endauth

@push('js')
    <script>
        $(document).ready(function() {
            const loggedInUserId = {{ auth()->id() ? auth()->id() : 0 }};

            // Mở/đóng chat
            $('#openChat').click(() => {
                $('#chatWidget').removeClass('d-none').fadeIn();
                $('#openChat').fadeOut();
                getChatSession();
            });

            $('#toggleChat').click(() => {
                $('#chatWidget').fadeOut(() => {
                    $('#chatWidget').addClass('d-none');
                    $('#openChat').fadeIn();
                });
            });

            // Xử lý gửi tin nhắn
            $('#chatForm').submit(function(e) {
                e.preventDefault();
                const message = $('#messageInput').val().trim();
                if (message) sendChatMessage(message);
                $('#messageInput').val('');
            });

            // Hàm lấy tin nhắn
            function getChatSession() {
                $('#chatMessages').html(
                    '<div class="text-center py-3"><div class="spinner-border text-primary"></div></div>');

                $.ajax({
                    url: '/api/client/chat/session',
                    type: 'GET',
                    data: {
                        user_id: loggedInUserId
                    },
                    success: (response) => {
                        console.log(response)
                        if (response.status) {
                            displayChatMessages(response.messages);
                        } else {
                            showError('Lỗi tải tin nhắn: ' + response.message);
                        }
                    },
                    error: (xhr) => handleAjaxError(xhr, '#chatMessages')
                });
            }

            function sendChatMessage(message) {
                // Tạo tin nhắn tạm thời
                const tempId = 'temp-' + Date.now();
                const tempTime = new Date().toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const tempMessageHtml = `
        <div id="${tempId}" class="user-message">
            <div class="user-text">
                ${message}
                <span class="message-time">
                    ${tempTime} 
                    <i class="fas fa-spinner fa-spin"></i>
                </span>
                <span class="message-status">Đang gửi...</span>
            </div>
        </div>
    `;

                // Thêm tin nhắn tạm vào khung chat
                $('#chatMessages').append(tempMessageHtml);
                $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);

                // Gửi tin nhắn qua AJAX
                $.ajax({
                    url: '/api/client/chat/messages',
                    type: 'POST',
                    data: {
                        message: message,
                        type: 0,
                        user_id: loggedInUserId
                    },
                    success: (response) => {
                        if (response.status) {
                            // Cập nhật tin nhắn tạm khi gửi thành công
                            $(`#${tempId} .fa-spinner`).replaceWith(
                                '<i class="fas fa-check-circle text-success"></i>'
                            );
                            $(`#${tempId} .message-status`).text('Đã gửi');
                        } else {
                            // Cập nhật nếu thất bại (có thể hiển thị icon lỗi)
                            $(`#${tempId} .fa-spinner`).replaceWith(
                                '<i class="fas fa-exclamation-circle text-danger"></i>'
                            );
                            $(`#${tempId} .message-status`).text('Gửi thất bại');
                            showError('Gửi thất bại: ' + response.message);
                        }
                    },
                    error: (xhr) => {
                        // Xử lý lỗi AJAX
                        $(`#${tempId} .fa-spinner`).replaceWith(
                            '<i class="fas fa-exclamation-circle text-danger"></i>'
                        );
                        $(`#${tempId} .message-status`).text('Gửi thất bại');
                        handleAjaxError(xhr, '#chatMessages');
                    }
                });
            }
            // Hiển thị tin nhắn
            function displayChatMessages(messages) {
                const container = $('#chatMessages');
                container.empty();

                if (!messages || !messages.length) {
                    container.html('<div class="text-center text-muted py-3">Chưa có tin nhắn nào</div>');
                    return;
                }

                messages.forEach(msg => {
                    const isUserMessage = msg.sender_id == loggedInUserId;
                    const time = new Date(msg.created_at).toLocaleTimeString('vi-VN', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    let messageHtml = '';

                    if (isUserMessage) {
                        // Tin nhắn người dùng (bên phải)
                        messageHtml = `
                            <div class="user-message">
                                <div class="user-text">
                                    ${msg.message}
                                    <span class="message-time">${time}</span>
                                </div>
                            </div>
                        `;
                    } else {
                        // Tin nhắn admin (bên trái)
                        messageHtml = `
                            <div class="admin-message">
                                <div class="admin-initial">A</div>
                                <div class="admin-text">
                                    ${msg.message}
                                    <span class="message-time">${time}</span>
                                </div>
                            </div>
                        `;
                    }

                    container.append(messageHtml);
                });

                // Tự động cuộn xuống dưới
                $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
            }

            // Xử lý lỗi chung
            function handleAjaxError(xhr, selector) {
                let errorMsg = 'Lỗi kết nối máy chủ';
                if (xhr.status === 401) {
                    errorMsg = 'Vui lòng đăng nhập';
                } else if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                $(selector).append(`<div class="alert alert-danger mt-2">${errorMsg}</div>`);
            }

            // Hiển thị thông báo lỗi
            function showError(message) {
                $('#chatMessages').append(`<div class="alert alert-danger mt-2">${message}</div>`);
            }
        });
    </script>
@endpush
