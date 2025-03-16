@auth
    <div class="container" style="margin-left: 30px">
        <!-- Chat Widget Start -->
        <div id="chatWidget" class="chat-widget position-fixed bottom-0 start-0 shadow-lg bg-white rounded-3 d-none"
            style="width: 350px; z-index: 10000; margin-bottom: 40px; margin-left: 40px;">
            <div class="text-white d-flex justify-content-between align-items-center p-3 rounded-top"
                style="background: #0da487 !important;">
                <span>Live Chat</span>
                <button class="btn-close text-white" id="toggleChat"></button>
            </div>
            <div class="chat-body overflow-auto p-3" id="chatBody" style="height: 300px;">
                <!-- Tin nhắn sẽ hiển thị ở đây -->
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
        <!-- Chat Widget End -->
    </div>
@endauth

@push('css')
    <style>
        /* Tăng z-index để đẩy chat widget lên phía trên */
        #chatWidget {
            z-index: 10000;
            position: fixed;
            width: 350px;
            bottom: 40px;
            left: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Tạo khoảng cách từ các cạnh của màn hình */
        }

        /* Responsive cho màn hình nhỏ */
        @media (max-width: 768px) {
            #chatWidget {
                width: 95vw;
                height: 95vh;
                bottom: 20px;
                left: 2.5vw;
                border-radius: 10px;
                z-index: 10000;
            }

            #chatBody {
                height: calc(95vh - 150px);
                overflow-y: auto;
            }

            #openChat {
                bottom: 20px;
                left: 20px;
                z-index: 10000;
            }
        }

        /* Responsive cho các màn hình rất nhỏ (nếu cần) */
        @media (max-width: 576px) {
            #chatWidget {
                width: 100vw;
                height: 100vh;
                bottom: 0;
                left: 0;
                border-radius: 0;
            }

            #openChat {
                bottom: 20px;
                left: 20px;
                z-index: 10000;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Mở widget chat khi nhấn nút
            $('#openChat').click(function() {
                $('#chatWidget').removeClass('d-none').fadeIn();
                $('#openChat').fadeOut();
            });

            // Đóng widget chat khi nhấn nút đóng
            $('#toggleChat').click(function() {
                $('#chatWidget').fadeOut(function() {
                    $('#chatWidget').addClass('d-none');
                    $('#openChat').fadeIn();
                });
            });
        });
    </script>
@endpush
