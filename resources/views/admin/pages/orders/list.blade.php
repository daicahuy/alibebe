@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        .layout_filter {
            margin: 0px !important;
        }

        .filter {
            width: 231.31px;
            height: 35px;
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

        body.dark-only .btn-order {
            color: #fff9 !important;
            border-radius: 7% !important;
            background: unset !important;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    @php

        $dataOrder = [
            'id' => 1,
            'code' => 'ORD123456',
            'user_id' => 1, // Giả sử đã có người dùng với ID là 1
            'payment_id' => 1, // Giả sử đã có phương thức thanh toán với ID là 1
            'phone_number' => '0123456789',
            'email' => 'example@example.com',
            'fullname' => 'Nguyễn Văn A',
            'address' => '123 Đường ABC, Phường XYZ, Thành phố HCM',
            'total_amount' => 150.75,
            'is_paid' => true,
            'coupon_id' => null, // Hoặc 1 nếu có coupon
            'coupon_code' => null, // Hoặc 'DISCOUNT10' nếu có coupon
            'coupon_description' => null, // Hoặc 'Giảm giá 10%' nếu có coupon
            'coupon_discount_type' => null, // Hoặc 'percentage' nếu có coupon
            'coupon_discount_value' => null, // Hoặc 10 nếu có coupon
            'created_at' => now(),
            'updated_at' => now(),
            'name_payment' => 'payment',
        ];
    @endphp
    {{-- Start Lọc --}}
    <div class="tab">
        <div class="card layout_filter shadow-sm">
            <div class="card-body">
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
                                <div class="col-sm-9" style="width: 100%">
                                    <div class="input-group custom-dt-picker">
                                        <input placeholder="yyyy-mm-dd" name="dpToDate" id="end_date_input" readonly=""
                                            class="form-control">
                                        <button type="button" class="btn btn-outline-secondary" id="endDatePickerBtn">
                                            <i class="ri-calendar-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày kết thúc</label>
                                <div class="col-sm-9" style="width: 100%">
                                    <div class="input-group custom-dt-picker">
                                        <input placeholder="yyyy-mm-dd" name="dpToDate" id="end_date_input" readonly=""
                                            class="form-control">
                                        <button type="button" class="btn btn-outline-secondary" id="endDatePickerBtn">
                                            <i class="ri-calendar-line"></i>
                                        </button>
                                    </div>
                                </div>
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
                <h5>Danh Sách Đơn Hàng</h5>

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
                            <tr>
                                <td class="px-4 py-2"><span
                                        class="font-semibold uppercase text-xs">{{ $dataOrder['code'] }}</span></td>
                                <td class="px-4 py-2"><span class="text-sm">{{ $dataOrder['created_at'] }}</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">{{ $dataOrder['fullname'] }}</span></td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">{{ $dataOrder['name_payment'] }}</span></td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">{{ $dataOrder['total_amount'] }}</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option value="{{ OrderStatusType::PENDING }}">Chờ xử lý</option>
                                        <option>Đã lấy hàng</option>
                                        <option>Đang giao</option>
                                        <option>Đã giao</option>
                                        <option>Hủy đơn</option>
                                    </select>
                                </td>
                                <td>
                                    <ul id="actions">
                                        <li>
                                            <a href="{{ route('admin.orders.show', ['order' => 1]) }}" class="btn-detail">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </li>
                                    </ul>
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


    {{-- MODALS --}}
    @component('components.modal.confirm', [
        'id' => 'modalConfirm',
        'title' => 'Minh chứng của bạn',
    ])
        <form action="">
            @csrf
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="icon">
                    Minh chứng
                </label>
                <div class="col-sm-9">
                    <input type="file" name="icon" id="icon" class="form-control">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="name">
                    Ghi chú
                    <span class="theme-color ms-2 required-dot ">*</span>
                </label>
                <div class="col-sm-9">
                    <textarea name="" id="" cols="15" class="form-control"></textarea>
                </div>
            </div>

            <div class="button-box justify-content-end">
                <button class="btn btn-md btn-secondary fw-bold btn-cancel" type="button">
                    {{ __('message.cancel') }}
                </button>
                <button class="btn btn-md btn-theme fw-bold btn-action" type="submit">
                    Xác nhận
                </button>
            </div>
        </form>
    @endcomponent
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <!-- Thêm SweetAlert2 CDN -->
    <script>
        $(document).ready(function() {

            $('.btn-order').on('click', function() {
                // Xóa lớp active khỏi tất cả các nút
                $('.btn-order').removeClass('active');

                // Thêm lớp active vào nút được click
                $(this).addClass('active');
            });

            $('.orderStatus').on('change', function() {
                // Xóa lớp active khỏi tất cả các nút
                $('#modalConfirm').modal('show');

            });
        });


        $('#is_unlimited').change(function() {
            // Toggle để ẩn/hiện hai trường phía dưới
            $('#usage-per-coupon, #usage-per-customer').toggle(!$(this).is(':checked'));
        });

        // Mặc định ẩn Start Date và End Date khi checkbox chưa được tick
        $('#start-date-div, #end-date-div').hide(); // Ẩn các trường ngày khi trang tải

        // Khi checkbox thay đổi trạng thái
        $('#is_expired').change(function() {
            // Kiểm tra nếu checkbox được tick
            if ($(this).is(':checked')) {
                // Hiện các trường Start Date và End Date khi checkbox được tick
                $('#start-date-div, #end-date-div').show();
            } else {
                // Ẩn các trường khi checkbox không được tick
                $('#start-date-div, #end-date-div').hide();
            }
        });

        // Khởi tạo Flatpickr cho các trường input
        $("#start_date_input").flatpickr({
            dateFormat: "Y-m-d"
        });

        $("#end_date_input").flatpickr({
            dateFormat: "Y-m-d"
        });

        // Khi nhấn vào nút calendar bên cạnh input #start_date
        $("#startDatePickerBtn").click(function() {
            $("#start_date_input").open(); // Mở bảng lịch cho start_date
        });

        // Khi nhấn vào nút calendar bên cạnh input #end_date
        $("#endDatePickerBtn").click(function() {
            $("#end_date_input").open(); // Mở bảng lịch cho end_date
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
