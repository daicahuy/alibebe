@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        .confirm {
            background-color: #0da487 !important;
        }

        .btn-outline-primary {
            color: #4a5568;
        }

        .layout_filter {
            margin: 0px !important;
        }

        .filter {
            width: 231.31px;
            height: 35px;
        }

        .order-offcanvas {
            z-index: 1055 !important;
            /* Giá trị cao hơn backdrop (thường là 1050) */
        }

        /* Ẩn dropdown mặc định */
        .dropdown-menu {
            display: none;
        }

        /* Hiển thị dropdown khi được kích hoạt */
        .dropdown.show .dropdown-menu {
            display: block;
        }

        /* Bỏ dấu đầu dòng của danh sách */
        li {
            list-style: none;
        }

        /* Tạo block riêng cho mỗi mục submenu */
        .sidebar-submenu li {
            display: block;
            /* Đảm bảo mỗi li là một khối riêng biệt */
            margin-bottom: 8px;
            /* Khoảng cách giữa các mục */
        }

        /* Đảm bảo mỗi mục con trong submenu không nằm cạnh nhau */
        .sidebar-submenu a {
            display: block;
            /* Đảm bảo link trong mỗi li là một khối */
            padding: 8px 12px;
            /* Tạo padding cho các mục */
            text-decoration: none;
            /* Loại bỏ gạch chân */
            color: #333;
            /* Màu chữ */
        }

        .sidebar-submenu a:hover {
            background-color: #f0f0f0;
            /* Hiệu ứng hover */
        }

        .btn-red {
            background-color: red
        }

        /* Modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            /* Đảm bảo modal nằm trên các phần tử khác */
            display: none;
            /* Mặc định ẩn backdrop */
        }

        /* Modal */
        #mediaModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            /* Trên backdrop */
            display: none;
            /* Mặc định ẩn modal */
            padding: 20px;
            width: 90%;
            /* Chiều rộng modal lớn hơn */
            max-width: 1300px;
            /* Đặt giới hạn chiều rộng tối đa */
            max-height: 100vh;
            /* Chiều cao tối đa chiếm 90% chiều cao màn hình */
            overflow-y: auto;
            /* Bật cuộn dọc nếu nội dung quá dài */
        }

        .notReceived:hover {
            color: #4a5568 !important;
        }

        .btn-order {
            padding: 5px;
            border: none;
            background-color: #fff;
            border-bottom: 2px solid transparent;
            transition: border-bottom 0.3s ease, color 0.3s ease;
        }

        .btn-order:hover {
            border-bottom: 2px solid #656d7b;
            background-color: #fff;
            /* Màu viền khi hover */
            color: #000;
        }

        .btn-order.active {
            border-bottom: 2px solid #656d7b;
            background-color: #fff;
            /* Màu viền khi active */
            font-weight: bold;
            color: #656d7b;
        }

        /* Image preview */
        #imagePreview img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .small-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }

        .custom-pagination .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-pagination .page-item {
            margin: 0 5px;
        }

        .custom-pagination .page-link {
            padding: 10px 15px;
            color: #0c9c8a;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #0c9c8a;
            color: white;
            border-color: #0c9c8a;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #ddd;
            pointer-events: none;
        }

        .custom-pagination .page-item:hover .page-link {
            background-color: #e9ecef;
            border-color: #ddd;
        }

        .custom-pagination .page-link i {
            font-size: 16px;
        }


        /* Add Button */
        /* Plus symbol */
        .add-button::after {
            content: '+';
            /* Plus icon */
            font-size: 24px;
            /* Font size for the plus icon */
            color: #888;
            /* Grey color for the icon */
        }

        /* Hover effect */
        .add-button:hover {
            background-color: #f0f0f0;
            /* Slightly darker background on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            /* Stronger shadow on hover */
        }

        /* Active effect */
        .add-button:active {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            /* Reduced shadow for pressed effect */
            transform: scale(0.95);
            /* Slight shrink on click */
        }

        /* Add Button */

        .custom-upload {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 400px;
            border: 2px dashed #ccc;
            border-radius: 12px;
            cursor: pointer;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            position: relative;
        }

        .custom-upload:hover {
            background-color: #f0f0f0;
            border-color: #0da487;
        }

        .custom-upload h2 {
            font-size: 24px;
            color: #717386;
            margin: 0;
            margin-bottom: 10px;
        }

        .custom-upload i {
            font-size: 24px;
            color: #717386;
            margin-bottom: 8px;
        }

        .custom-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image preview container */
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Image container styling */
        .image-container {
            position: relative;
            width: 100px;
            /* Chiều rộng của mỗi ảnh */
            height: 100px;
            /* Chiều cao của mỗi ảnh */
            overflow: hidden;
            border: 2px solid #ccc;
            /* Viền cho ảnh */
            border-radius: 8px;
            /* Góc bo tròn */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Tạo hiệu ứng đổ bóng */
            transition: transform 0.3s ease;
        }

        .image-container:hover {
            transform: scale(1.05);
            /* Phóng to ảnh khi hover */
        }

        /* Image inside container */
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh luôn được căn chỉnh đẹp trong khung */
            border-radius: 8px;
            /* Bo tròn góc ảnh */
        }

        /* Delete button styling */
        .delete-btn {
            position: absolute;
            top: 5px;
            /* Điều chỉnh nút delete lên phía trên */
            right: 5px;
            /* Điều chỉnh nút delete về phía phải */
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            /* Tăng kích thước nút delete */
            height: 24px;
            font-size: 16px;
            line-height: 24px;
            /* Đảm bảo icon nằm giữa */
            text-align: center;
            /* Căn giữa nội dung nút delete */
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Đổ bóng cho nút xóa */
            z-index: 10;
            /* Đảm bảo nút delete luôn nằm trên cùng */
        }

        .delete-btn:hover {
            background-color: #ff1a1a;
            /* Đổi màu khi hover */
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    {{-- Start Lọc --}}
    <div class="tab">
        <div class="card layout_filter shadow-sm">
            <div class="card-body bg-white">
                <div>
                    <form>
                        <div class="row g-3 py-2"> <!-- Giảm khoảng cách giữa các phần tử -->
                            <!-- Tìm kiếm theo tên khách hàng -->
                            <div class="col-md-4">
                                <input class="form-control form-control-sm" type="search" name="search"
                                    placeholder="Search by Customer Name">
                            </div>

                            <!-- Lọc theo thời gian -->
                            <div class="col-md-4">
                                <select class="form-control form-select form-select-sm">
                                    <option value="Order limits" hidden>
                                        <p>Thời gian</p>
                                    </option>
                                    <option value="5">5 ngày trước</option>
                                    <option value="7">7 ngày trước</option>
                                    <option value="15">15 ngày trước</option>
                                    <option value="30">30 ngày trước</option>
                                </select>
                            </div>

                            <!-- Lọc theo phương thức thanh toán -->
                            <div class="col-md-4">
                                <select class="form-control form-select form-select-sm">
                                    <option value="Method" hidden>Phương thức</option>
                                    <option value="Cash">Tiền mặt</option>
                                    <option value="Card">Thẻ</option>
                                    <option value="Credit">Tín dụng</option>
                                </select>
                            </div>


                        </div>

                        <!-- Lọc theo ngày -->
                        <div class="row g-3 py-2">
                            <!-- Ngày bắt đầu -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input class="form-control form-control-sm" type="date" name="startDate">
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày kết thúc</label>
                                <input class="form-control form-control-sm" type="date" name="endDate">
                            </div>

                            <!-- Nút lọc -->
                            <div class="col-md-4 d-flex mt-5 justify-content-center">
                                <div class="">
                                    <a href="#" class="btn btn-solid filter">Lọc</a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End lọc --}}




    {{-- Start Body Order --}}
    <div class="card card-table mt-2">
        <div class="card-body">
            <div class="title-header option-title">
                <h5>Order List</h5>

                <a href="#" class="btn btn-solid" style="height: 35px;line-height:17px">Download all orders</a>
            </div>
            {{-- Start trạng thái --}}
            <div class="p-4">
                <div class="row g-3 py-2">
                    <div class="col">
                        <button class=" active btn-order" type="submit">
                            Chờ xử lý (5)
                        </button>
                    </div>
                    <div class="col">
                        <button class=" btn-order" type="submit">
                            Đã lấy hàng (12)
                        </button>
                    </div>
                    <div class="col">
                        <button class=" btn-order" type="submit">
                            Đang giao (2)
                        </button>
                    </div>
                    <div class="col">
                        <button class=" btn-order" type="submit">
                            Đã giao (9)
                        </button>
                    </div>
                    <div class="col">
                        <button class=" btn-order" type="submit">
                            Hủy hàng (2)
                        </button>
                    </div>
                    <div class="col">
                        <button class=" btn-order text-danger notReceived" type="submit">
                            Giải quyết xung đột (2)
                        </button>
                    </div>
                </div>
            </div>
            {{-- End trạng thái --}}
            <div>
                <div class="table-responsive">
                    <table class="table all-package order-table theme-table" id="table_id">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Mã Đơn Hàng </th>
                                <th class="px-4 py-2">Thời Gian</th>
                                <th class="px-4 py-2">Họ Tên</th>
                                <th class="px-4 py-2">Phương Thức Thanh Toán</th>
                                <th class="px-4 py-2">Tổng</th>
                                <th class="px-4 py-2">Trạng Thái</th>
                                <th class="px-4 py-2 text-right">Khác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>

                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>
                            <tr href="#order-details">
                                <td class="px-4 py-2"><span class="font-semibold uppercase text-xs">11497</span></td>
                                <td class="px-4 py-2"><span class="text-sm">23 Dec, 2024 6:40 PM</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">un n </span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">Tiền mặt</span></td>
                                <td class="px-4 py-2"><span class="text-sm font-semibold">$558.12</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option>Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </a>
                                </td>
                                </a>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- End Body Order --}}


    {{--    Modal insert image --}}
    <!-- Backdrop -->
    <div class="modal-backdrop" id="modalBackdrop"></div>

    <div class="modal-content" id="mediaModal" style="display: none;">
        <div class="modal-header">
            <h2>Insert Media</h2>
            <button class="btn btn-close" id="media_close_btn" type="button">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="modal-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#" class="nav-link active" id="selectFileTab">Select File</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="uploadNewTab">Upload New</a>
                </li>
            </ul>
            <div class="tab-content mt-2">
                <!-- Select File Tab -->
                <div class="tab-pane fade active show" id="selectFilePanel">
                    <div class="select-top-panel d-flex">
                        <input type="text" class="form-control me-3" placeholder="Search your files">
                        <select class="form-select">
                            <option value="">Sort By desc</option>
                            <option value="newest">Sort By newest</option>
                            <option value="oldest">Sort By oldest</option>
                            <option value="smallest">Sort By smallest</option>
                            <option value="largest">Sort By largest</option>
                        </select>
                    </div>
                    <div class="content-section py-0">
                        <div class="row row-cols-2 g-2 media-library-sec">
                            <div class="media-item col-2">
                                <input name="attachment" class="media-checkbox" type="radio" id="attachment-1470"
                                    value="1470">
                                <label for="attachment-1470">
                                    <div class="ratio ratio-1x1">
                                        <img alt="attachment" class="img-fluid" src="https://example.com/image.jpg">
                                    </div>
                                </label>
                            </div>
                            <div class="media-item col-2">
                                <input name="attachment" class="media-checkbox" type="radio" id="attachment-1471"
                                    value="1471">
                                <label for="attachment-1471">
                                    <div class="ratio ratio-1x1">
                                        <img alt="attachment" class="img-fluid" src="https://example.com/image.jpg">
                                    </div>
                                </label>
                            </div>
                        </div>
                        <nav class="custom-pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled"><a href="#" class="page-link"><i
                                            class="ri-arrow-left-s-line"></i></a></li>
                                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                <li class="page-item"><a href="#" class="page-link">2</a></li>
                                <li class="page-item"><a href="#" class="page-link">3</a></li>
                                <li class="page-item"><a href="#" class="page-link"><i
                                            class="ri-arrow-right-s-line"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Upload New Tab -->
                <div class="tab-pane fade" id="uploadNewPanel">
                    <div class="content-section drop-files-sec">
                        <div class="custom-upload">
                            <input type="file" id="fileUploadInput" multiple accept="image/*">
                            <div class="dropzone-label d-flex">
                                <i class="ri-upload-line justify-content-center"></i>
                                <h2>Drop Files Here or Click to Upload</h2>
                            </div>
                        </div>
                        <div id="imagePreview" class="image-preview">
                            <!-- Ảnh sẽ hiển thị ở đây sau khi tải lên -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-theme" id="media_btn" type="button">Đẩy File</button>
        </div>
    </div>
    <!-- Modal Upload image-->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Hình ảnh minh chứng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="brand-form">
                        <!-- Add Image Section -->
                        <div class="align-items-center g-2 mb-4 row">
                            <label class="col-sm-2 form-label-title mb-0" for="image">Thêm ảnh</label>
                            <div class="col-sm-10 d-flex justify-content-center">
                                <ul class="image-select-list cursor-pointer">
                                    <li class="choosefile-input" id="openModal1">
                                        <div class="add-button"></div>
                                    </li>
                                </ul>
                                <div>
                                    <div class="ml-4 d-flex" id="image-area">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" id="save-btn" class="btn btn-primary">
                                <i class="ri-save-line"></i> Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    {{-- image --}}
    <script>
        $(document).ready(function() {
            const $openModalButton = $('#openModal1');
            const $modal = $('#mediaModal');
            const $backdrop = $('#modalBackdrop');
            const $closeModalButton = $('#media_close_btn');
            const $fileUploadInput = $('#fileUploadInput');
            const $imagePreview = $('#imagePreview');
            const $imageArea = $('#image-area');
            const $mediaBtn = $('#media_btn');
            const $uploadNewTab = $('#uploadNewTab');
            const $selectFileTab = $('#selectFileTab');

            // Tabs Panels
            const $uploadNewPanel = $('#uploadNewPanel');
            const $selectFilePanel = $('#selectFilePanel');

            // Show modal and set default tab to "Select File"
            function showModal() {
                $modal.show();
                $backdrop.show();
                activateSelectFileTab(); // Set default tab to Select File
            }

            // Hide modal and backdrop
            function hideModal() {
                $modal.hide();
                $backdrop.hide();
            }

            // Event listeners for modal open/close
            $openModalButton.on('click', showModal);
            $closeModalButton.on('click', hideModal);
            $backdrop.on('click', hideModal);

            // Tab switching
            $uploadNewTab.on('click', function(e) {
                e.preventDefault();
                activateUploadTab();
            });

            $selectFileTab.on('click', function(e) {
                e.preventDefault();
                activateSelectFileTab();
            });

            // Activate "Upload New" tab
            function activateUploadTab() {
                $uploadNewTab.addClass('active');
                $selectFileTab.removeClass('active');
                $uploadNewPanel.addClass('show active');
                $selectFilePanel.removeClass('show active');
            }

            // Activate "Select File" tab
            function activateSelectFileTab() {
                $selectFileTab.addClass('active');
                $uploadNewTab.removeClass('active');
                $selectFilePanel.addClass('show active');
                $uploadNewPanel.removeClass('show active');
                resetFileInput(); // Reset file input when switching to "Select File" tab
            }

            // Reset file input when switching tabs
            function resetFileInput() {
                $fileUploadInput.val(''); // Clear file input
                $imagePreview.html(''); // Clear image preview
            }

            // File upload preview
            let selectedFiles = [];

            $fileUploadInput.on('change', function(e) {
                const files = e.target.files;

                // Đẩy các file mới vào mảng
                $.each(files, function(_, file) {
                    selectedFiles.push(file);
                });

                // Xóa preview cũ
                $imagePreview.html('');

                // Hiển thị preview các ảnh trong mảng
                $.each(selectedFiles, function(_, file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const $imgContainer = $('<div>').addClass('image-container');
                        const $img = $('<img>').attr('src', event.target.result);
                        const $deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        $deleteBtn.on('click', function() {
                            $imgContainer.remove();
                            // Cập nhật lại mảng selectedFiles khi xóa ảnh
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            displayImagesOutside(); // Cập nhật ảnh bên ngoài modal
                        });

                        $imgContainer.append($img).append($deleteBtn);
                        $imagePreview.append($imgContainer);
                    };
                    reader.readAsDataURL(file);
                });

                if ($mediaBtn) {
                    displayImagesOutside();
                } // Hiển thị ảnh bên ngoài modal
            });

            // Hiển thị ảnh ngoài modal
            function displayImagesOutside() {
                $imageArea.html(''); // Xóa ảnh cũ ngoài modal

                $.each(selectedFiles, function(_, file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const $imgContainer = $('<div>').addClass('image-container');
                        const $img = $('<img>').attr('src', event.target.result).attr('name',
                            'image[]');
                        const $deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        $deleteBtn.on('click', function() {
                            $imgContainer.remove();
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            displayImagesOutside(); // Cập nhật ảnh bên ngoài modal khi xóa
                        });

                        $imgContainer.append($img).append($deleteBtn);
                        $imageArea.append($imgContainer); // Thêm ảnh ngoài modal
                    };
                    reader.readAsDataURL(file);
                });
            }

            $('#save-btn').on('click', function() {
                if (selectedFiles.length === 0) {
                    // Thông báo lỗi nếu chưa có ảnh nào
                    $.notify(
                        '<i class="fas fa-bell"></i><strong>Vui lòng tải ảnh!</strong>', {
                            type: 'theme',
                            allow_dismiss: true,
                            delay: 2000,
                            showProgressbar: true,
                            timer: 300,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            }
                        });
                } else {
                    $.notify('<i class="fas fa-bell"></i><strong>Thao tác thành công!</strong>', {
                        type: 'theme',
                        allow_dismiss: true,
                        delay: 1000,
                        showProgressbar: true,
                        timer: 300,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });
                    // Xóa tất cả ảnh đã tải lên và reset lại giao diện
                    selectedFiles = []; // Xóa mảng ảnh đã chọn
                    resetFileInput(); // Reset lại input và preview ảnh
                    displayImagesOutside(); // Cập nhật lại khu vực hiển thị ảnh ngoài modal

                }

            });

            $mediaBtn.on('click', function() {
                // Show success notification
                $.notify(
                    '<i class="fas fa-bell"></i><strong>Ảnh đã được đẩy lên</strong>', {
                        type: 'theme',
                        allow_dismiss: true,
                        delay: 1000,
                        showProgressbar: true,
                        timer: 300,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });

                // Close the modal after showing notification
                hideModal(); // Hide modal
            });
        });
    </script>
    {{-- Chuyển trạng thái --}}
    <script>
        $('.orderStatus').on('change', function() {
            if ($(this).val() === 'Đã giao') {
                // Hiển thị modal đầu tiên
                const firstModal = new bootstrap.Modal($('#statusModal')[0]);
                firstModal.show();

                // Xử lý sự kiện khi click nút openModal1
                $('#openModal1').one('click', function() {
                    firstModal.hide(); // Đóng modal đầu tiên
                    const secondModal = new bootstrap.Modal($('#secondModal')[0]);
                    secondModal.show(); // Hiển thị modal thứ hai
                });
            }
        });
    </script>
    <!-- Thêm SweetAlert2 CDN -->
    <script>
        $(document).ready(function() {
            $('.btn-order').on('click', function() {
                // Xóa lớp active khỏi tất cả các nút
                $('.btn-order').removeClass('active');

                // Thêm lớp active vào nút được click
                $(this).addClass('active');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
