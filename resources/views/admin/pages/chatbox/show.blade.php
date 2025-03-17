@extends('admin.layouts.master')

@push('css_library')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')
    <div class="container-fluid p-0 h-100">
        <div class="d-flex flex-column h-100 rounded-3 shadow bg-white">
            <!-- Header với thông tin khách hàng và nút thoát -->
            <div class="d-flex align-items-center justify-content-between p-2 bg-primary text-white rounded-top shadow"
                style="height: 60px;">
                <div class="d-flex align-items-center">
                    <img src="{{ Storage::url($chatSession->customer->avatar) }}" alt="User"
                        class="rounded-circle me-2 img-fluid" style="width: 40px; height: 40px;">
                    <span class="fs-6 fw-bold">{{ $chatSession->customer->fullname }}</span>
                </div>
                <a class="btn btn-outline-light btn-sm rounded-pill" href="{{ route('admin.chats.index') }}">Thoát</a>
            </div>

            <!-- Khu vực tin nhắn -->
            <div id="chatMessages" class="flex-grow-1 p-2 overflow-auto bg-light border-bottom" style="height: 450px; max-height: 450px;">
                @foreach ($chatSession->messages as $message)
                    @if ($message->sender_id == $chatSession->customer_id)
                        <!-- Tin nhắn của khách hàng -->
                        <div class="d-flex mb-2">
                            <!-- Avatar của khách hàng -->
                            <img src="{{ $chatSession->customer->avatar ? Storage::url($chatSession->customer->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($chatSession->customer->fullname))) . '?d=mp' }}"
                                alt="Customer" class="rounded-circle me-2 img-fluid" style="width: 40px; height: 40px;">
                            <div class="bg-white border rounded p-2 shadow-sm position-relative w-75">
                                <p class="mb-1 small">{{ $message->message }}</p>
                                <small class="text-muted position-absolute end-0 bottom-0 me-2 mb-1"
                                    style="font-size: 10px;">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <!-- Tin nhắn của admin -->
                        <div class="d-flex mb-2 justify-content-end">
                            <div class="bg-primary text-white border rounded p-2 shadow-sm position-relative w-75">
                                <p class="mb-1 small">{{ $message->message }}</p>
                                <small class="text-white-50 position-absolute end-0 bottom-0 me-2 mb-1"
                                    style="font-size: 10px;">
                                    {{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                                </small>
                            </div>
                            <!-- Avatar của admin -->
                            <img src="{{ $chatSession->employee && $chatSession->employee->avatar ? Storage::url($chatSession->employee->avatar) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($chatSession->employee->fullname ?? 'admin'))) . '?d=mp' }}"
                                alt="Admin" class="rounded-circle ms-2 border border-light"
                                style="width: 40px; height: 40px;">
                        </div>
                    @endif
                @endforeach
                <div id="endOfChat"></div>
            </div>

            <!-- Form gửi tin nhắn và file -->
            <form id="chatForm" action="{{ route('admin.chats.send-message', $chatSession->id) }}" method="POST"
                enctype="multipart/form-data" class="d-flex align-items-center p-2 border-top bg-light shadow">
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
    </script>
@endsection
