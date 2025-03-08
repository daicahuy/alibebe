<!-- Chat Widget Start -->
<div id="chatWidget" class="chat-widget position-fixed bottom-0 end-0 m-3 shadow-lg bg-white rounded-3 d-none" style="width: 350px;">
    <div class="text-white d-flex justify-content-between align-items-center p-3 rounded-top" style="background: #0da487 !important;">
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
        <input type="text" id="messageInput" class="form-control me-2 rounded-pill shadow-sm" placeholder="Nhập tin nhắn...">
        <button type="submit" class="btn btn-theme rounded-pill shadow-sm">Gửi</button>
    </form>
</div>

<!-- Button mở chat -->
<button id="openChat" class="btn position-fixed" style="bottom: 90px; right: 20px; width: 50px; height: 50px; border-radius: 50%; background-color: #0da487; color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <i class="fas fa-comments"></i>
</button>
<!-- Chat Widget End -->

@push('css')
<style>
    /* Nút mở chat */
    #openChat {
        bottom: 90px !important; /* Điều chỉnh nút lên cao hơn */
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
