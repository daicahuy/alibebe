@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
    <div class="container-fluid p-0 h-100">
        <div class="d-flex flex-column h-100 rounded-3 shadow bg-white">
            <!-- Header với thông tin khách hàng và nút thoát -->
            <div class="d-flex align-items-center justify-content-between p-3 bg-primary text-white rounded-top shadow">
                <div class="d-flex align-items-center">
                    <img src="{{ Storage::url($chatSession->customer->avatar) }}" alt="User"
                        class="rounded-circle me-3 img-fluid" style="width: 50px;">
                    <span class="fs-5 fw-bold">{{ $chatSession->customer->fullname }}</span>
                </div>
                <a class="btn btn-outline-light btn-sm rounded-pill" href="{{ route('admin.chats.index') }}">Thoát</a>
            </div>

            <!-- Khu vực tin nhắn -->
            <div id="chatMessages" class="flex-grow-1 p-3 overflow-auto bg-light border-bottom" style="max-height: 430px;">
                @foreach ($chatSession->messages as $message)
                    @if ($message->sender_id == $chatSession->customer_id)
                        <!-- Tin nhắn của khách hàng -->
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/50" alt="Customer"
                                class="rounded-circle me-2 border border-primary" style="width: 50px;">
                            <div class="bg-white border rounded p-3 shadow-sm position-relative w-75">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-muted position-absolute end-0 bottom-0 me-2 mb-1">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <!-- Tin nhắn của admin -->
                        <div class="d-flex mb-3 justify-content-end">
                            <div class="bg-primary text-white border rounded p-3 shadow-sm position-relative w-75">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-white-50 position-absolute end-0 bottom-0 me-2 mb-1">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </small>
                            </div>
                            <img src="https://via.placeholder.com/50" alt="Admin"
                                class="rounded-circle ms-2 border border-light" style="width: 50px;">
                        </div>
                    @endif
                @endforeach
                <div id="endOfChat"></div>
            </div>

            <!-- Form gửi tin nhắn và file -->
            <form id="chatForm" action="{{ route('admin.chats.send-message', $chatSession->id) }}" method="POST"
                enctype="multipart/form-data" class="d-flex align-items-center p-3 border-top bg-light shadow">
                @csrf
                <div class="input-group">
                    <input type="text" id="messageInput" name="message" class="form-control rounded-pill shadow-sm"
                        placeholder="Nhập tin nhắn...">
                    <button type="submit" class="btn btn-primary rounded-pill ms-2">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Cuộn xuống cuối khi có tin nhắn mới
        var chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Tự động cuộn xuống khi gửi tin nhắn
        document.getElementById('chatForm').addEventListener('submit', function() {
            setTimeout(function() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 100);
        });
    </script>
@endsection
