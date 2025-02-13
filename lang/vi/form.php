<?php

return [

    'attributes' => 'Thuộc tính',
    'attribute_all' => 'Tất cả thuộc tính',
    'attribute_variants' => 'Thuộc tính biến thể',
    'attribute_specifications' => 'Thuộc tính sản phẩm',

    'auth' => [
        'login' => 'Đăng nhập',
        'welcome' => 'Welcome To Fastkart',
        'login_account' => 'Đăng nhập vào tài khoản của bạn',
        'email_or_phone_number' => 'Nhập số điện thoại hoặc email',
        'password' => 'Mật khẩu',
        'remember_me' => 'Ghi nhớ tài khoản',
        'forgot_password' => 'Quên mật khẩu',
        'login_with_google' => 'Đăng nhập với Google',
        'signup_with_google' => 'Đăng ký với Google',
        'login_with_facebook' => 'Đăng nhập với Facebook',
        'signup_with_facebook' => 'Đăng ký với Facebook',
        'not_have_account' => 'Chưa có tài khoản?',
        'have_account' => 'Đã có tài khoản',
        'register' => 'Đăng ký',
        'created_account' => 'Tạo tài khoản mới',
        'logout' => 'Đăng xuất'
    ],

    'attribute' => [
        'id' => 'ID',
        'name' => 'Tên thuộc tính',
        'slug' => 'Slug',
        'is_variant' => 'Thuộc biến thể sản phẩm',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'attribute_values' => 'Giá trị thuộc tính',
    'attribute_value' => [
        'id' => 'ID',
        'attribute_id' => 'ID thuộc tính',
        'value' => 'Giá trị',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'brands' => 'Thương hiệu',
    'brand' => [
        'id' => 'ID',
        'name' => 'Tên thương hiệu',
        'slug' => 'Slug',
        'logo' => 'Logo',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'cart_items' => 'Giỏ hàng',
    'cart_item' => [
        'id' => 'ID',
        'user_id' => 'ID người dùng',
        'product_id' => 'ID sản phẩm',
        'product_variant_id' => 'ID biến thể sản phẩm',
        'quantity' => 'Số lượng',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'categories' => 'Danh mục',
    'categories_parent' => 'Danh mục cha',
    'category_name_child' => 'Tên danh mục con',
    'category_all' => 'Tất cả danh mục',
    'category' => [
        'id' => 'ID',
        'parent_id' => 'ID cha',
        'name' => 'Tên danh mục',
        'slug' => 'Slug',
        'ordinal' => 'Thứ tự hiển thị',
        'is_active' => 'Trạng thái',
        'icon' => 'Biểu tượng',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'chat_sessions' => 'Phiên trò chuyện',
    'chat_session' => [
        'id' => 'ID',
        'customer_id' => 'ID khách hàng',
        'employee_id' => 'ID nhân viên',
        'status' => 'Trạng thái',
        'created_date' => 'Ngày tạo',
        'closed_date' => 'Ngày đóng',
    ],

    'comments' => 'Bình luận',
    'comment' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'user_id' => 'ID người dùng',
        'content' => 'Nội dung',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'comment_replies' => 'Phản hồi bình luận',
    'comment_reply' => [
        'id' => 'ID',
        'comment_id' => 'ID bình luận',
        'reply_user_id' => 'ID người được trả lơi',
        'user_id' => 'ID người trả lời',
        'content' => 'Nội dung',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'coupons' => 'Mã giảm giá',
    'coupons_hide' => 'Mã Giảm Giá Ẩn',
    'coupon' => [
        'id' => 'ID',
        'code' => 'Mã giảm giá',
        'title' => 'Tiêu đề',
        'description' => 'Mô tả',
        'discount_type' => 'Loại giảm giá',
        'discount_value' => 'Giá trị giảm giá',
        'usage_limit' => 'Giới hạn sử dụng',
        'usage_count' => 'Số lần sử dụng',
        'user_group' => 'Nhóm người dùng',
        'is_expired' => 'Có hạn',
        'is_active' => 'Trạng thái',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',

        'select_discount_type' => 'Lựa Chọn Loại Giảm Giá',
        'fix_amount' => 'Giá Cố Định',
        'percent' => 'Phần Trăm',
    ],


    'histories' => 'Lịch sử',
    'history' => [
        'id' => 'ID',
        'subject_type' => 'Loại đối tượng',
        'subject_id' => 'ID đối tượng',
        'action_type' => 'Loại hành động',
        'old_value' => 'Giá trị cũ',
        'new_value' => 'Giá trị mới',
        'user_id' => 'ID người dùng',
        'description' => 'Mô tả',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'messages' => 'Tin nhắn',
    'message' => [
        'id' => 'ID',
        'chat_session_id' => 'ID phiên trò chuyện',
        'sender_id' => 'ID người gửi',
        'message' => 'Tin nhắn',
        'type' => 'Loại',
        'read_at' => 'Thời gian đã đọc',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'orders' => 'Đơn hàng',
    'order' => [
        'id' => 'ID',
        'code' => 'Mã đơn hàng',
        'user_id' => 'ID người dùng',
        'information_customer' => 'Thông tin khách hàng',
        'payment_id' => 'ID thanh toán',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'fullname' => 'Tên',
        'address' => 'Địa chỉ',
        'note' => 'Ghi chú',
        'total_amount' => 'Tổng số tiền',
        'is_paid' => 'Trạng thái thanh toán',
        'type_payment' => 'Phương thức thanh toán',
        'coupon_id' => 'ID mã giảm giá',
        'coupon_code' => 'Mã giảm giá',
        'coupon_description' => 'Mô tả mã giảm giá',
        'coupon_discount_type' => 'Loại giảm giá',
        'coupon_discount_value' => 'Giá trị giảm giá',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'order_items' => 'Sản phẩm trong đơn hàng',


    'order_item' => [
        'id' => 'ID',
        'order_id' => 'ID đơn hàng',
        'product_id' => 'ID sản phẩm',
        'product_variant_id' => 'ID biến thể sản phẩm',
        'name' => 'Tên sản phẩm',
        'price' => 'Giá',
        'image' => 'Ảnh',
        'quantity' => 'Số lượng',
        'name_variant' => 'Tên biến thể',
        'attributes_variant' => 'Thuộc tính biến thể',
        'price_variant' => 'Giá biến thể',
        'quantity_variant' => 'Số lượng biến thể',
        'total_amount' => 'Tổng tiền',
    ],

    'order_statuses' => 'Trạng thái đơn hàng',
    'order_status' => [
        'id' => 'ID',
        'name' => 'Tên trạng thái',
        'ordinal' => 'Thứ tự hiển thị',

        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'shipping' => 'Đang giao hàng',
        'delivered' => 'Đã giao hàng',
        'failed_delivery' => 'Giao hàng thất bại',
        'completed' => 'Hoàn thành',
        'cancel' => 'Đã hủy',
    ],

    'payments' => 'Thanh toán',
    'payment' => [
        'id' => 'ID',
        'parent_id' => 'ID cha',
        'name' => 'Tên',
        'logo' => 'Logo',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'products' => 'Sản phẩm',
    'product_manager' => 'Quản lý sản phẩm',
    'product_type_single' => 'Sản phẩm đơn',
    'product_type_variant' => 'Sản phẩm biến thể',
    'product' => [
        'id' => 'ID',
        'brand_id' => 'ID thương hiệu',
        'name' => 'Tên sản phẩm',
        'slug' => 'Slug',
        'views' => 'Lượt xem',
        'short_description' => 'Mô tả ngắn',
        'description' => 'Mô tả chi tiết',
        'thumbnail' => 'Ảnh chính',
        'type' => 'Loại sản phẩm',
        'sku' => 'Mã SKU',
        'price' => 'Giá',
        'sale_price' => 'Giá khuyến mãi',
        'sale_price_start_at' => 'Bắt đầu khuyến mãi',
        'sale_price_end_at' => 'Kết thúc khuyến mãi',
        'is_sale' => 'Trạng thái khuyến mãi',
        'is_featured' => 'Sản phẩm nổi bật',
        'is_trending' => 'Sản phẩm xu hướng',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'product_accessories' => 'Phụ kiện đi kèm',

    'product_galleries' => 'Bộ sưu tập',
    'product_gallery' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'image' => 'Hình ảnh',
    ],

    'product_stocks' => 'Tồn kho',
    'product_stock_status' => 'Trạng thái kho',
    'product_stock_status_all' => 'Tất cả trạng thái kho',
    'product_stock_in_stock' => 'Còn hàng',
    'product_stock_out_of_stock' => 'Hết hàng',
    'product_stock_low_stock' => 'Sắp hết hàng',
    'product_stock' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'product_variant_id' => 'ID biến thể sản phẩm',
        'stock' => 'Tồn kho',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'product_variants' => 'Biến thể',
    'product_variant' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'sku' => 'Mã SKU',
        'price' => 'Giá',
        'sale_price' => 'Giá khuyến mãi',
        'sale_price_start_at' => 'Bắt đầu khuyến mãi',
        'sale_price_end_at' => 'Kết thúc khuyến mãi',
        'thumbnail' => 'Ảnh',
        'is_active' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'reviews' => 'Đánh giá',
    'review' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'order_id' => 'ID đơn hàng',
        'user_id' => 'ID người dùng',
        'rating' => 'Đánh giá',
        'review_text' => 'Nội dung đánh giá',
        'reason' => 'Lý do',
        'is_active' => 'Trạng thái kích hoạt',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'review_multimedias' => 'Đánh giá đa phương tiện',
    'review_multimedia' => [
        'id' => 'ID',
        'review_id' => 'ID đánh giá',
        'file' => 'Tệp tin',
        'file_type' => 'Loại tệp',
    ],

    'stock_movements' => 'Biến động kho',
    'stock_movement' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'product_variant_id' => 'ID biến thể sản phẩm',
        'quantity' => 'Số lượng',
        'type' => 'Loại hành động',
        'reason' => 'Lý do',
        'user_id' => 'ID người dùng',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'tags' => 'Thẻ',
    'tag' => [
        'id' => 'ID',
        'name' => 'Tên',
        'slug' => 'Đường dẫn thân thiện',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'users' => 'Người dùng',
    'user_manager' => 'Quản lý người dùng',
    'user_staff' => 'Quản lý nhân viên',
    'user_all' => 'Tất cả người dùng',
    'user_customer' => 'Khách hàng',
    'user_employee' => 'Nhân viên',
    'user_admin' => 'Chủ cửa hàng',
    'user' => [
        'id' => 'ID',
        'google_id' => 'ID Google',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'password' => 'Mật khẩu',
        'confirm_password' => 'Xác nhận mật khẩu',
        'fullname' => 'Họ và tên',
        'avatar' => 'Ảnh đại diện',
        'gender' => 'Giới tính',
        'birthday' => 'Ngày sinh',
        'loyalty_points' => 'Điểm trung thành',
        'role' => 'Vai trò',
        'status' => 'Trạng thái',
        'verified_at' => 'Thời gian xác minh',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'user_addresses' => 'Địa chỉ',
    'user_address' => [
        'id' => 'ID',
        'user_id' => 'ID người dùng',
        'address' => 'Địa chỉ',
        'id_default' => 'Mặc định',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
    ],

    'wishlists' => 'Danh sách yêu thích',
    'wishlist' => [
        'id' => 'ID',
        'user_id' => 'ID người dùng',
        'product_id' => 'ID sản phẩm',
        'created_at' => 'Ngày tạo',
    ],

    'action' => 'Hành động',
    'general' => 'Tổng quan',
    'inventory' => 'Kho',
    'setup' => 'Cài đặt',
    'images' => 'Ảnh',

    'enter_name' => 'Nhập tên',
    'enter_product_name' => 'Nhập tên sản phẩm',
    'enter_sku' => 'Nhập mã SKU',
    'enter_product_stock' => 'Nhập số lượng tồn kho',
    'enter_price' => 'Nhập giá',
    'enter_sale_price' => 'Nhập giá khuyến mãi',
    'enter_ordinal' => 'Nhập thứ tự hiển thị',
    'enter_attribute_name' => 'Nhập tên thuộc tính',
    'enter_brand_name' => 'Nhập tên thương hiệu',
    'enter_tag_name' => 'Nhập tên thẻ',
    'enter_attribute_value_value' => 'Nhập giá trị',
    'enter_phone_number' => 'Nhập số điện thoại',
    'enter_email' => 'Nhập email',
    'enter_password' => 'Nhập mật khẩu',
    'enter_confirm_password' => 'Xác nhận lại mật khẩu',
    'enter_short_description' => 'Nhập mô tả ngắn',

    'select_icon' => 'Chọn biểu tượng',
    'select_logo' => 'Chọn logo',

    'help_thubnail' => '*Khuyến nghị tải lên kích thước hình ảnh 600x600px',
    'help_short_description' => '*Độ dài tối đa là 255 ký tự.',
    'help_product_accessories' => '*Chọn tối đa 6 phụ kiện để hiển thị phụ kiện đi kèm hiệu quả.',
    'help_is_featured' => '*Bật tùy chọn này sẽ hiển thị cờ <Nổi bật> trên sản phẩm.',
    'help_is_trending' => '*Bật tùy chọn này sẽ hiển thị sản phẩm trong thanh bên của trang sản phẩm dưới dạng mặt hàng thịnh hành.',
];
