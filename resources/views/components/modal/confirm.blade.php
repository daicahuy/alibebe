<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Màu đen mờ */
        z-index: 1000;
        /* Đảm bảo overlay ở trên cùng */
        display: none;
        /* Ẩn overlay ban đầu */
    }

    .modal-open .overlay {
        display: block;
        /* Hiện overlay khi modal mở */
    }
</style>

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="overlay">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title mb-5">{{ $title }} </h5>
                    <div class="row">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#{{ $id }} .btn-cancel').on('click', function() {
        $('#{{ $id }}').modal('hide')
    })
</script>
