<?php

return [

    'attributes' => 'Thuộc tính',
    'attribute_all' => 'Tất cả thuộc tính',
    'attribute_variants' => 'Thuộc tính biến thể',
    'attribute_specifications' => 'Thuộc tính sản phẩm',

    'attribute' => [
        'id' => 'ID',
        'name' => 'Tên thuộc tính',
        'slug' => 'Slug',
        'is_variant' => 'Thuộc biến thể sản phẩm',
        'is_active' => 'Đang hoạt động',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'attribute_values' => 'Giá trị thuộc tính',
    'attribute_value' => [
        'id' => 'ID',
        'attribute_id' => 'ID thuộc tính',
        'value' => 'Giá trị',
        'is_active' => 'Đang hoạt động',
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
        'is_active' => 'Đang hoạt động',
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
    'category' => [
        'id' => 'ID',
        'parent_id' => 'ID cha',
        'name' => 'Tên',
        'slug' => 'Slug',
        'ordinal' => 'Thứ tự hiển thị',
        'is_active' => 'Đang hoạt động',
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
        'is_active' => 'Đang hoạt động',
        'start_date' => 'Ngày bắt đầu',
        'end_date' => 'Ngày kết thúc',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
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
        'payment_id' => 'ID thanh toán',
        'phone_number' => 'Số điện thoại',
        'email' => 'Email',
        'fullname' => 'Họ và tên',
        'address' => 'Địa chỉ',
        'total_amount' => 'Tổng số tiền',
        'is_paid' => 'Đã thanh toán',
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
        'quantity' => 'Số lượng',
        'name_variant' => 'Tên biến thể',
        'attributes_variant' => 'Thuộc tính biến thể',
        'price_variant' => 'Giá biến thể',
        'quantity_variant' => 'Số lượng biến thể',
    ],

    'order_statuses' => 'Trạng thái đơn hàng',
    'order_status' => [
        'id' => 'ID',
        'name' => 'Tên trạng thái',
        'ordinal' => 'Thứ tự hiển thị',
    ],

    'payments' => 'Thanh toán',
    'payment' => [
        'id' => 'ID',
        'parent_id' => 'ID cha',
        'name' => 'Tên',
        'logo' => 'Logo',
        'is_active' => 'Đang hoạt động',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'products' => 'Sản phẩm',
    'product_manager' => 'Quản lý sản phẩm',
    'product' => [
        'id' => 'ID',
        'brand_id' => 'ID thương hiệu',
        'name' => 'Tên sản phẩm',
        'name_link' => 'Liên kết tên sản phẩm',
        'slug' => 'Slug',
        'video' => 'Video',
        'views' => 'Lượt xem',
        'content' => 'Nội dung',
        'thumbnail' => 'Hình thu nhỏ',
        'sku' => 'Mã sản phẩm (SKU)',
        'price' => 'Giá',
        'sale_price' => 'Giá khuyến mãi',
        'sale_price_start_at' => 'Bắt đầu khuyến mãi',
        'sale_price_end_at' => 'Kết thúc khuyến mãi',
        'type' => 'Loại sản phẩm',
        'is_active' => 'Đang hoạt động',
        'start_at' => 'Thời gian ra mắt',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'deleted_at' => 'Ngày xóa',
    ],

    'product_features' => 'Tính năng',
    'product_feature' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'feature' => 'Tính năng',
    ],

    'product_galleries' => 'Bộ sưu tập',
    'product_gallery' => [
        'id' => 'ID',
        'product_id' => 'ID sản phẩm',
        'image' => 'Hình ảnh',
    ],

    'product_stocks' => 'Tồn kho',
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
        'sku' => 'Mã sản phẩm (SKU)',
        'price' => 'Giá',
        'sale_price' => 'Giá khuyến mãi',
        'sale_price_start_at' => 'Bắt đầu khuyến mãi',
        'sale_price_end_at' => 'Kết thúc khuyến mãi',
        'thumbnail' => 'Hình thu nhỏ',
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

    'enter_name' => 'Nhập tên',
    'enter_ordinal' => 'Nhập thứ tự hiển thị',
    'enter_attribute_name' => 'Nhập tên thuộc tính',
    'enter_brand_name' => 'Nhập tên thương hiệu',
    'enter_tag_name' => 'Nhập tên thẻ',
    'enter_attribute_value_value' => 'Nhập giá trị',
    'enter_phone_number' => 'Nhập số điện thoại',
    'enter_email' => 'Nhập email',
    'enter_password' => 'Nhập mật khẩu',
    'enter_confirm_password' => 'Xác nhận lại mật khẩu',
    'select_icon' => 'Chọn biểu tượng',
    'select_logo' => 'Chọn logo',

];
