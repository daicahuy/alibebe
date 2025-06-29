@extends('admin.layouts.master')

@push('css_library')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Fontawesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('css')
    <style>
        :root {
            --primary-color: #2A8BF2;
            --secondary-color: #7F8289;
            --background-color: #F0F4F8;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Inter', sans-serif;
        }

        .user-list-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            height: calc(100vh - 40px);
            margin: 20px;
            overflow: hidden;
            display: flex;
            transition: all 0.3s ease;
        }

        /* User List */
        .user-list {
            width: 100%;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .user-list::-webkit-scrollbar {
            width: 6px;
        }

        .user-list::-webkit-scrollbar-thumb {
            background-color: rgba(42, 139, 242, 0.3);
            border-radius: 3px;
        }

        .user-search {
            padding: 20px;
            background: #F8FAFC;
            border-bottom: 1px solid #EBEDF0;
            display: flex;
            justify-content: space-between;
        }

        .user-item {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            position: relative;
        }

        .user-item:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 1px;
            background: rgba(235, 237, 240, 0.5);
        }

        .user-item:hover {
            background: #F8FAFC;
            cursor: pointer;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            margin-left: 15px;
            flex-grow: 1;
        }

        .user-name {
            font-weight: 600;
            color: #1A1D23;
            margin-bottom: 2px;
        }

        .user-status {
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-left: auto;
        }

        .online {
            background: #00C853;
            box-shadow: 0 0 0 3px rgba(0, 200, 83, 0.2);
        }

        .offline {
            background: #B0BEC5;
        }

        /* Modal styles */
        .modal-header {
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .user-list-container {
                margin: 10px;
                border-radius: 12px;
            }

            .user-item {
                padding: 12px 15px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <div class="user-list-container">
            <!-- User List -->
            <div class="user-list">
                <div class="user-search row">
                    <div class="col-md-10">
                        <input type="text" class="form-control" placeholder="Tìm kiếm..." style="border-radius: 12px;">
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.chats.closed') }}" class="btn btn-primary">
                            Đoạn Chat Lưu Trữ
                        </a>
                    </div>
                </div>

                <div class="user-list-content">
                    @foreach ($chatSessions as $chatSession)
                        @php
                            // Chỉ đếm tin nhắn của khách hàng (sender_id = customer_id) chưa được đọc (read_at is null)
                            $unreadCount = $chatSession
                                ->messages()
                                ->whereNull('read_at')
                                ->where('sender_id', $chatSession->customer_id)
                                ->count();
                        @endphp
                        <!-- Thêm attribute data-chat-session-id để JS realtime dễ xử lý -->
                        <div class="user-item chat-session-item" data-chat-session-id="{{ $chatSession->id }}">
                            <img src="{{ Storage::url($chatSession->customer->avatar) }}" class="user-avatar">
                            <div class="user-info">
                                <div class="user-name">{{ $chatSession->customer->fullname }}</div>
                                <div class="user-status">Đang hoạt động</div>
                            </div>
                            <div class="message-item">
                                <a class="btn btn-primary position-relative"
                                    href="{{ route('admin.chats.chat-session', ['id' => $chatSession->id]) }}">
                                    Mở Chat
                                    @if ($unreadCount > 0)
                                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </a>
                                <!-- Icon xóa -->
                                <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal"
                                    data-bs-target="#deleteMessageModal{{ $chatSession->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Xác Nhận Xóa -->
                        <div class="modal fade" id="deleteMessageModal{{ $chatSession->id }}" tabindex="-1"
                            aria-labelledby="deleteMessageModalLabel{{ $chatSession->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteMessageModalLabel{{ $chatSession->id }}">
                                            Xác Nhận Xóa</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa tin nhắn này không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <!-- Form xóa tin nhắn -->
                                        <form action="{{ route('admin.chats.close-chat-session', $chatSession->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="custom-pagination p-4">
                        {{ $chatSessions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_library')
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- Pusher JS -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Lấy ID của người dùng đã đăng nhập từ Laravel
            const loggedInUserId = {{ auth()->id() }};
            console.log('Logged in User ID:', loggedInUserId);

            let searchTimeout;
            const searchInput = $('.user-search input');
            const userListContent = $('.user-list-content');

            // Debug để kiểm tra jQuery đã load chưa
            console.log('jQuery loaded:', typeof $ !== 'undefined');

            // Sự kiện input với debounce cho tìm kiếm
            searchInput.on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(performSearch, 300);
            });

            function performSearch() {
                const searchTerm = searchInput.val();
                console.log('Searching for:', searchTerm); // Debug

                // Hiển thị spinner ngay lập tức
                userListContent.html(
                    '<div class="text-center p-4"><i class="fas fa-spinner fa-spin"></i> Đang tìm kiếm...</div>'
                );

                // AJAX request
                $.ajax({
                    url: '{{ route('api.admin.chats.search-users') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        user_id: loggedInUserId
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(response) {
                        console.log('Response:', response); // Debug

                        if (response.success && response.users && response.users.length > 0) {
                            let html = '';
                            response.users.forEach(function(user) {
                                html += `
                                    <div class="user-item">
                                        <img src="${user.avatar ? `http://127.0.0.1:8000/storage/${user.avatar}` : '{{ asset('assets/images/default-avatar.png') }}'}" class="user-avatar">
                                        <div class="user-info">
                                            <div class="user-name">${user.fullname}</div>
                                        </div>
                                        <div class="message-item">
                                            <form action="{{ route('admin.chats.start-chat') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="customer_id" value="${user.id}">
                                                <button type="submit" class="btn btn-primary">Mở Chat</button>
                                            </form>
                                        </div>
                                    </div>
                                `;
                            });
                            userListContent.html(html);
                        } else {
                            userListContent.html(
                                '<div class="text-center p-4">Không tìm thấy người dùng nào</div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax error:', error); // Debug
                        userListContent.html(
                            '<div class="text-center p-4 text-danger">Có lỗi xảy ra, vui lòng thử lại</div>'
                        );
                    }
                });
            }

            // ------------------ REALTIME UPDATE ------------------
            // Khởi tạo Pusher
            Pusher.logToConsole = true;
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                forceTLS: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                }
            });

            // Với mỗi chat session trong danh sách, đăng ký kênh riêng dùng data-chat-session-id
            $('.chat-session-item').each(function() {
                const chatSessionId = $(this).data('chat-session-id');
                const channelName = `private-chat.${chatSessionId}`;
                const channel = pusher.subscribe(channelName);

                channel.bind('message.sent', function(data) {
                    console.log('New message received:', data);
                    
                    // Kiểm tra nếu tin nhắn mới đến từ khách hàng
                    if (data.message && data.sender && data.sender.role === 0) {
                        // Tìm phần tử chat item dựa trên chatSessionId
                        const chatItem = $(
                            `.chat-session-item[data-chat-session-id="${chatSessionId}"]`);
                        
                        if (chatItem.length > 0) {
                            // Cập nhật badge trước
                            const btn = chatItem.find('a.btn-primary');
                            let badge = btn.find('.badge');
    
                            if (badge.length > 0) {
                                // Nếu badge đã tồn tại, tăng số đếm
                                let count = parseInt(badge.text());
                                badge.text(count + 1);
                            } else {
                                // Nếu chưa có badge, tạo mới hiển thị số 1
                                btn.append(
                                    `<span class="badge bg-danger position-absolute top-0 start-100 translate-middle">1</span>`
                                );
                            }
                            
                            // Clone chatItem để tránh mất sự kiện đã đăng ký
                            const chatItemClone = chatItem.clone(true);
                            
                            // Xóa phần tử cũ và đưa bản sao lên đầu danh sách
                            chatItem.remove();
                            userListContent.prepend(chatItemClone);
                            
                            // Làm nổi bật phần tử mới thêm bằng animation đơn giản
                            chatItemClone.css('background-color', '#f3f9ff');
                            setTimeout(function() {
                                chatItemClone.css('background-color', '');
                            }, 1000);
                        }
                    }
                });
            });
            // ------------------------------------------------------

            @if (session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: '{{ session('success') }}',
                    timer: 2000
                });
            @endif

            @if (session()->has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            @endif

        });
    </script>
@endpush
