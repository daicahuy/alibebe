@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        #loading-icon-load {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loading-icon {
            animation: rotate 2s linear infinite;
            width: 100px;
            height: 100px;

        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .order-status-tabs>div>div {
            flex: 0 0 10%;
            /* Mỗi item chiếm 25% chiều rộng */
            box-sizing: border-box;
            /* Bao gồm padding và border trong chiều rộng */
            min-width: 200px;
            /* Đảm bảo mỗi item có chiều rộng tối thiểu */
            margin-right: 10px;
            /* Khoảng cách giữa các item */
        }

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
        use App\Enums\OrderStatusType;
    @endphp
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
    <div class="tabs">
        <div class="card layout_filter shadow-sm">
            <div class="card-body">
                <div>
                    <form>
                        <div class="row g-3 py-2"> <!-- Giảm khoảng cách giữa các phần tử -->
                            <!-- Tìm kiếm theo tên khách hàng -->
                            <div class="col-md-4">
                                <input class="form-control form-control-sm" type="search" name="search" id="search"
                                    placeholder="Search by Customer Name">
                            </div>



                            <!-- Lọc theo phương thức thanh toán -->



                        </div>

                        <!-- Lọc theo ngày -->
                        <div class="row g-3 py-2">
                            <!-- Ngày bắt đầu -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày bắt đầu</label>
                                <div class="col-sm-9" style="width: 100%">
                                    <div class="input-group custom-dt-picker">
                                        <input placeholder="yyyy-mm-dd" name="dpToDate" id="start_date_input" readonly=""
                                            class="form-control">
                                        <button type="button" class="btn btn-outline-secondary" id="startDatePickerBtn">
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
                                    <button id="filterButton" class="btn btn-solid filter">Lọc</button>
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
                <div class="order-status-tabs" style="overflow-x: auto; white-space: nowrap;">
                    <div class="d-flex flex-row" style="">
                        <div class="col">
                            <button class="tab active btn-order" data-status = "{{ OrderStatusType::PENDING }}"
                                type="submit">
                                Chờ xử lý (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::PROCESSING }}" type="submit">
                                Đang xử lý (<span class="count">0</span>)
                            </button>
                        </div>

                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::SHIPPING }}" type="submit">
                                Đang giao (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::DELIVERED }}" type="submit">
                                Đã giao (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::CANCEL }}" type="submit">
                                Hủy hàng (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::COMPLETED }}" type="submit">
                                Hoàn thành (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::FAILED_DELIVERY }}"
                                type="submit">
                                Giao hàng thất bại (<span class="count">0</span>)
                            </button>
                        </div>
                        <div class="col">
                            <button class=" btn-order text-danger notReceived" type="submit">
                                Giải quyết xung đột (2)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End trạng thái --}}
            <div>
                <div class="table-responsive">
                    <table class="table all-package order-table theme-table" id="orderTable">
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



                        </tbody>
                    </table>
                    <div id="loading-icon-load">
                        <div id="loading-icon" style="display: none;">
                            <img src="data:image/png;base64,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"
                                alt="spinner-frame-5">
                        </div>
                    </div>


                    <nav aria-label="Page navigation example" class="mt-3">
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
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


            let activeTab = 1;
            let currentPage = 1;
            const itemsPerPage = 5;

            // Hàm gọi API để lấy dữ liệu
            function fetchOrders(updateCounts = false) {
                const search = $("#search").val();
                const startDate = $("#start_date_input").val();
                const endDate = $("#end_date_input").val();
                $("#loading-icon").show();
                // Gọi API
                $.ajax({
                    url: "http://127.0.0.1:8000/api/orders/list",
                    method: "GET",
                    data: {
                        order_status_id: activeTab,
                        search,
                        startDate,
                        endDate,
                        page: currentPage,
                        limit: itemsPerPage,
                    },
                    success: function(response) {
                        renderTable(response.orders, response.totalPages);
                        console.log("response: " + response.totalPages)
                        if (response
                            .totalPages
                        ) { // giả sử response có thuộc tính totalRecords chứa tổng số bản ghi
                            $('#pagination').twbsPagination({
                                totalPages: response.totalPages,
                                visiblePages: 3,
                                startPage: currentPage, // Duy trì trang hiện tại
                                onPageClick: function(event, page) {
                                    currentPage = page;
                                    fetchOrders();
                                }
                            });
                        }
                        if (updateCounts) updateTabCounts(search, startDate, endDate);
                    },
                    error: function() {
                        alert("Error fetching data from API");
                    },
                    complete: function() {
                        $("#loading-icon")
                            .hide(); // Ẩn icon loading khi API hoàn tất (thành công hoặc thất bại)
                    }
                });
            }

            // Hàm render dữ liệu vào bảng
            function renderTable(orders, totalPages) {
                $("#orderTable tbody").empty();

                if (orders.length === 0) {
                    $("#orderTable tbody").append(`
            <tr>
              <td colspan="4" style="text-align: center;">Không có dữ liệu</td>
              <td colspan="4" style="text-align: center;"></td>
              <td colspan="4" style="text-align: center;"></td>
              <td colspan="4" style="text-align: center;"></td>
              <td colspan="4" style="text-align: center;"></td>
            </tr>
          `);
                } else {
                    orders.forEach(order => {
                        $("#orderTable tbody").append(`
                        <tr>
                                <td class="px-4 py-2"><span
                                        class="font-semibold uppercase text-xs">${ order.code }</span></td>
                                <td class="px-4 py-2"><span class="text-sm">${ convertDate(order.created_at) }</span></td>
                                <td class="px-4 py-2 text-xs"><span class="text-sm">${ order.fullname }</span>
                                </td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">${ order.payment.name }</span></td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">${ formatCurrency(order.total_amount) }</span></td>
                                <td class="px-4 py-2 text-xs">
                                    <select class="font-serif form-select form-select-sm orderStatus">
                                        <option value="1">Chờ xử lý</option>
                                        <option value="2">Đang xử lý</option>
                                        <option value="3">Đang giao hàng</option>
                                        <option value="4">Đã giao hàng</option>
                                        <option value="5">Giao hàng thất bại</option>
                                        <option value="6">Hoàn thành</option>
                                        <option value="7">Đã hủy</option>
                                    </select>
                                </td>

                                <td>
                                    <ul id="actions">
                                        <li>
                                            <a href="orders/${order.id}"
                                                class="btn-detail">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                               
                                </a>
                            </tr>
            `);
                    });
                }


            }

            // Hàm cập nhật số lượng order trên các tab
            function updateTabCounts(search, startDate, endDate) {
                $(".tab").each(function() {
                    const status = $(this).data("status");

                    $.ajax({
                        url: "http://127.0.0.1:8000/api/orders/list/count",
                        method: "GET",
                        data: {
                            order_status_id: status,
                            search,
                            startDate,
                            endDate,
                        },
                        success: function(response) {
                            if (response[0]) {
                                $(this).find(".count").text(response[0].count);

                            } else {
                                $(this).find(".count").text(0);

                            }
                        }.bind(this),
                        error: function() {
                            console.error("Error fetching count for status:", status);
                        },
                    });
                });
            }

            // Xử lý sự kiện lọc
            $("#filterButton").click(function(e) {
                event.preventDefault();
                currentPage = 1; // Reset về trang đầu tiên
                $('#pagination').twbsPagination('destroy');
                fetchOrders(true);
            });

            // Xử lý sự kiện chuyển tab
            $(".tab").click(function() {
                $(".tab").removeClass("active");
                $(this).addClass("active");
                activeTab = $(this).data("status");
                currentPage = 1; // Reset về trang đầu tiên
                $('#pagination').twbsPagination('destroy');
                fetchOrders();
            });



            // Khởi tạo lần đầu
            fetchOrders(true);





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
    <script src="{{ asset('js/utility.js') }}"></script>
@endpush
