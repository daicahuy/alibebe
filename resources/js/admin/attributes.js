$(document).ready(function () {
    // Khi thay đổi trạng thái của checkbox
    $('.switch-input').on('change', function () {
        // Lấy ID của checkbox từ thuộc tính 'id'
        var attributeId = $(this).attr('id').split('-')[1]; // Lấy ID từ phần tử có id="status-{{$atb->id}}"
        var form = $('#updateForm-' + attributeId);  // Lấy form liên quan đến checkbox này

        // Cập nhật giá trị của checkbox (1 hoặc 0)
        var is_active = $(this).is(':checked') ? 1 : 0;
        
        // Gửi dữ liệu bằng AJAX
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: {
                _token: form.find('input[name="_token"]').val(),
                id: attributeId,
                status: is_active
            },
            success: function (response) {
                // Xử lý thành công (có thể hiển thị thông báo hoặc cập nhật UI nếu cần)
                if (response.success) {
                    alert('Cập nhật trạng thái thành công!');
                }
            },
            error: function (xhr, status, error) {
                // Xử lý lỗi nếu có
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    });
});
