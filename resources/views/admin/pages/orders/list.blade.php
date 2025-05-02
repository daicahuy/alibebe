@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        .all-package .sm-width {
            width: 43px;
        }

        .page-link {
            background-color: #0da487;
            color: #fff;
        }

        .page-link.active,
        .active>.page-link {
            color: #fff;

            background-color: #85f6df;
            border-color: #85f6df;
        }

        .page-link:hover {
            z-index: 2;
            color: #fff;
            background-color: #85f6df;
            border-color: #85f6df;
        }

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

        .btn-download-all {
            display: none;
        }

        .btn-download-all.active {
            display: block;
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

        .table-responsive {
            overflow: hidden;
            /* Ẩn cuộn ngoài */
        }

        .order-table {
            width: 100%;
            /* Chiều rộng của bảng vào 100% */
            border-collapse: collapse;
            /* Kết hợp các đường viền */
        }

        .order-table thead {
            position: sticky;
            /* Định vị cố định */
            top: 0;
            /* Đặt ở đỉnh trang */
            background: white;
            /* Màu nền cho bảng */
            /* z-index: 10; */
            /* Đảm bảo header nằm trên nội dung khác */
        }

        .table-responsive tbody {
            display: block;
            /* Chuyển tbody thành block để cuộn được */
            overflow-y: auto;
            /* Cho phép cuộn theo chiều dọc */
            height: 300px;
            /* Chiều cao tối đa của tbody (thay đổi theo nhu cầu) */
        }

        .table-responsive tr {
            display: table;
            /* Giữ css của hàng */
            table-layout: fixed;
            /* Giữ cấu trúc hàng */
            width: 100%;
            /* Chiều rộng 100% cho hàng */
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
            <input type="hidden" id="selected-category-ids" name="selected_category_ids" value="">
            <div class="card-body">
                <div>
                    <form>
                        <div class="row g-3 py-2"> <!-- Giảm khoảng cách giữa các phần tử -->
                            <!-- Tìm kiếm theo tên khách hàng -->
                            <div class="col-md-4">
                                <input class="form-control form-control-sm" type="search" name="search" id="search"
                                    placeholder="{{ __('message.orders_search') }}">
                            </div>



                            <!-- Lọc theo phương thức thanh toán -->



                        </div>

                        <!-- Lọc theo ngày -->
                        <div class="row g-3 py-2">
                            <!-- Ngày bắt đầu -->
                            <div class="col-md-4">
                                <label class="form-label">{{ __('message.time_start') }}</label>
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
                                <label class="form-label">{{ __('message.time_end') }}</label>
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
                                    <button id="filterButton"
                                        class="btn btn-solid filter">{{ __('message.filter') }}</button>
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
            <div class="title-header option-title"
                style="display: flex; padding-bottom: unset; justify-content: space-between; align-items: center;">
                <h5>{{ __('message.list_orders') }}<span id="count_selected_item"></span></h5>
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 8px;">
                    <div id="select-change-status-items"></div>
                    <button class="btn btn-solid visually-hidden " id="btn-move-to-trash-all"
                        style="height: 35px;line-height:17px">{{ __('message.print_selected_orders') }}</button>
                    <button class="btn btn-solid btn-download-all" id="btn-print-all"
                        style="height: 35px;line-height:17px">{{ __('message.print_all_orders') }}</button>
                </div>
            </div>
            {{-- Start trạng thái --}}
            <div class="p-4">
                <div class="order-status-tabs" style="overflow-x: auto; white-space: nowrap;">
                    <div class="d-flex flex-row" style="">
                        <div class="col">
                            <button class="tab active btn-order" data-status = "{{ OrderStatusType::PENDING }}"
                                type="submit">
                                {{ __('form.order_status.pending') }} <span class="count"></span>
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::PROCESSING }}" type="submit">
                                {{ __('form.order_status.processing') }} <span class="count"></span>
                            </button>
                        </div>

                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::SHIPPING }}" type="submit">
                                {{ __('form.order_status.shipping') }} <span class="count"></span>
                            </button>
                        </div>
                        {{-- <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::DELIVERED }}" type="submit">
                                {{ __('form.order_status.delivered') }} <span class="count"></span>
                            </button>
                        </div> --}}
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::FAILED_DELIVERY }}"
                                type="submit">
                                {{ __('form.order_status.failed_delivery') }} <span class="count"></span>
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::CANCEL }}" type="submit">
                                {{ __('form.order_status.cancel') }} <span class="count"></span>
                            </button>
                        </div>
                        <div class="col">
                            <button class="tab btn-order" data-status = "{{ OrderStatusType::COMPLETED }}" type="submit">
                                {{ __('form.order_status.completed') }} <span class="count"></span>
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
                                <th class="sm-width">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="checkbox-table"
                                            class="custom-control-input checkbox_animated">
                                    </div>
                                </th>
                                <th class="px-4 py-2">{{ __('form.order.code') }}</th>
                                <th class="px-4 py-2">{{ __('form.order.created_at') }}</th>
                                <th class="px-4 py-2" style="width: 280px; text-align: left;">
                                    {{ __('form.order.information_customer') }}</th>
                                <th class="px-4 py-2">{{ __('form.order.type_payment') }}</th>
                                <th class="px-4 py-2">{{ __('form.order.total_amount') }}(VND)</th>
                                <th class="px-4 py-2">{{ __('form.order.is_paid') }}</th>

                                <th class="px-4 py-2">{{ __('form.order_statuses') }}</th>
                                <th class="px-4 py-2 text-right">{{ __('message.other') }}</th>
                            </tr>
                        </thead>
                        <tbody>



                        </tbody>
                    </table>
                    <div id="loading-icon-load">
                        <div id="loading-icon" style="display: none;">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAF9ElEQVR4nO2dTYwURRTH/5AMkLi7YlwTdlYTPxNFceUgLnjQXS6CCQsJZ4UbBm6IgjEROOBFQPSgcHUTlwMgygWRcFJBXT3AfsANLoIKy86asMmqa17yOum8VHdX9XTPVHe/X1JJp6e6p6re1Pua6mpAURRFURRFURRFUQrKQwD2A/gVwN9c6HgfgO52N65qbAIwDWA+otwFsLHdjaySMP6NEUZQqI4KpQVqatpCGEGZUvWVL/vFgM8C2Amgh8tOPheuszfnNlWa38RgkwAku0QdMvRKTsyIwV5mqLNM1GmoNPKjIQab1JSkV9Qhm6O0SGW9baGyRlUa+bHPYNRJKHUuuzI06s8COAzgSijwpONDAJZn3K/C0s1Bn4vb+6DjdywC8CmAf2LuS58dAVBDgaCO7QBwMfQL+xHAdv4sLRsdAsOhFG0+5yDwb4silDq7m1EdGY0wyC5CmUqYGa7CAM+MecfyMTxnUYIwgvJLk7+ubrYpo+wON/iee1OoqcBmSDU1BmADgE4uJORxUWcOwDPwmB0Ov6634A+HDcLoMtS7H8CEqHsQHnNRNPYbjg16+Tj82Q/whzHRtqGEBGe47mUUKJomQQQ87HEU3RBtIxUVRZfH/UjsGAkhQAXikcoiYZzxWGVdKavK2u5g1LfBHw6Jto2zAZfQuUlR9yN47vaOWgjjJ8+CquUGt3eCZ0MXl00GYZDb+zQ8p4djgihh/NxkYJgXR1IEhjSzCkGN44zv2fOa4eNtns2MMDVOh9gK46zHfSkNNU6HzMUIYo5nhgqjxTblIHtQwQy/zAbc61SJoiiKoiiKoiilZy2AY5z3ChZz0PFRAIPtblyVeBLABYv0ynkAT7S7sWXnZQB/OeS8qO6adje6rDwG4I8UWeHbPKty4XWeikGOh47XoxpcMAz2SQCvALiPy6sAThnqfdeKh2aq9HDMWkOfaT1xFO8Y6g9kPTOSpuY6lJdjhpmRxGlxzedZNui8hUBobWxZmRR9JTWVxIDhb+Hclvj0A1hdoQdkGqKvHRbXdOa5hks2aDW7cyqQNglEVRaaVlm0vCgz1lvYkNdQXo6KvpJrm8TX4prP8n6sLFw+QLkZNPSZXNso3jXUpxglc9axN9Xgcq7kMyNJbZ9m1dTBZdAwM8rugbaNR1OmTiifpUnGnFjjmFz8kz1SJUce59yUTaBMCUmlRQxwOmQ8lGwd43O5GHBFURRFUZTCUgOwGcBwaHnPDB8P82f6bEiLoKdvr1nEF9dS7qeiWLIQwIeO6ZD/ABzga5WMcRVGuJBQlAwZ4l97eJDv8YY0q0LLe1bx84f3DDOFdg1SMqBmsBnXATwXc80KADcMNsV7Q/8UgBOh/02Oi81ofGCzYWbECSMsFLm/I93La2HcjkhF+ySUYdE+UlNpNxr4Ah5zIsYIjsDftVYvOlz7kriW7uUtcslQuNDOos3wAICtAL7iQQiey5jkhQdbACzNca1VS5b4ZE3S+z3SsATAHsutYmkjzN18TRyVEcjxjFVWnXcQco0RLvG1tiqLXFtb+ouksnrZgJuMetwAmagb3EyXciPmO4eb2Pb1kyIZdfAgjLD6muZjV2Es4e2c5CD/DuA9AH2hwK2Pz9001Ked7hZbur3k0ibRVzS3Nyv2GAb3ywRd38HCt1nUFhUYxgnl+aIGhsjAm7prEMYCi2sXGIQyFeF9mVInsxxn9IcWwPWzmpqtaupkq0FNuXpBUn29GVH3QBM2qjLJxVOi42QfXHlf3IMCVhMLeWDlTIkrlUu/XxUDQLrblRccXdMNDn9QVUJNZRW0NRO8yb9wgwVw4+zaVvYv3JkMBNJVoUfuSqmyFE+MumLBFjGYN1O4vbfEPd7QkW8uMJwSAzriEBjKBOcdh7S8EsFug8s5kvB+j86IbHPcNhiKQ3LxkmFwb7F9WBlKbazkc1JNzfMb4kzJRSUF9SbT79c93fy/0PQYXhZjU+jVGY+0u/FlZTGn0OPeYRg24GQzVE21gKWctT0pUhsTHGeQa6velKIoiqIoaBv/A1UYRA8mSNHeAAAAAElFTkSuQmCC"
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
        'title' => 'Xem minh chứng',
    ])
        <form id="formConfirmCheckOrder" method="POST">
            @csrf
            <input type="text" hidden value="" name="order_id" class="hiddenIDIgnore">
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="icon">
                    Ảnh đơn hàng
                </label>
                <div class="col-sm-9">
                    <img src="" alt="" width="150px" height="200px" id="img-checkout-order"
                        class="" style="object-fit: cover">
                </div>
            </div>

            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="name">
                    Tình trạng:
                </label>
                <div class="" style="width: unset;" id="checkout-order-status">

                </div>
            </div>

            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="name">
                    Ghi chú
                    <span class="theme-color ms-2 required-dot ">*</span>
                </label>
                <div class="col-sm-9">
                    <textarea name="note" id="text-note-checkout-order" cols="15" class="form-control"></textarea>
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


    @component('components.modal.confirm', [
        'id' => 'modalUpload',
        'title' => 'Tải ảnh minh chứng',
    ])
        <form id="formUploadImageOrder" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" hidden value="" name="order_id" class="hiddenIDOrderUpload">
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="icon">
                    Ảnh đơn hàng
                </label>
                <div class="col-sm-9">
                    <input type="file" name="employee_evidence" id="employee_evidence" class="form-control">
                </div>

                <div class="invalid-feedback error-confirm"></div>

            </div>
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="name">
                    Ghi chú
                    <span class="theme-color ms-2 required-dot ">*</span>
                </label>
                <div class="col-sm-9">
                    <textarea name="note" id="text-note-checkout-order-upload" cols="15" class="form-control note"></textarea>
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

    @component('components.modal.confirm', [
        'id' => 'modalShowRefundBank',
        'title' => 'Xem thông tin hoàn tiền',
    ])
        <form id="modalFormShowRefundBank" style="max-height: 77vh; overflow-y: auto;" method="POST"
            enctype="multipart/form-data">
            <table class="table all-package theme-table no-footer">
                <tbody><!---->
                    <tr>
                        <td class="text-start fw-semibold">Giá trị hoàn</td>
                        <td class="text-start" id="total_amount"></td>
                    </tr>
                    <tr>
                        <td class="text-start fw-semibold">Tên người thụ hưởng </td>
                        <td class="text-start" id="user_bank_name"></td>
                    </tr>
                    <tr>
                        <td class="text-start fw-semibold">Tên ngân hàng </td>
                        <td class="text-start"id="bank_name"></td>
                    </tr>
                    <tr>
                        <td class="text-start fw-semibold">Số tài khoản </td>
                        <td class="text-start" id="bank_account"></td>
                    </tr>


                    <input type="hidden" hidden id="idorder" name="idorder" value="">
                </tbody>
            </table>
            <div class="mb-3" id="div_send_money">

            </div>
            <div class="button-box justify-content-end">
                <button class="btn btn-md btn-secondary fw-bold btn-cancel" type="button">
                    {{ __('message.cancel') }}
                </button>
                <button class="btn btn-md btn-theme fw-bold btn-action" disabled id="btn_send_money">
                    Đã chuyển tiền
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endpush

@push('js')
    <!-- Thêm SweetAlert2 CDN -->
    <script>
        $(document).ready(function() {
            const dataUser = <?php echo json_encode($user); ?>;

            $('#modalUpload').on('shown.bs.modal', function() {
                //Xử lý khi modal được hiển thị
                $('.btn-cancel').click(function() {
                    $('#formUploadImageOrder')[0].reset(); //Reset form
                    $('.error-confirm').html(''); //Xóa thông báo lỗi
                    $('.note').val(''); // Xóa nội dung textarea nếu có
                });
            });
            $('#formConfirmCheckOrder').on("submit", function(event) {
                event.preventDefault();

                const note = $("#formConfirmCheckOrder #text-note-checkout-order").val();

                const order_id = $("#formConfirmCheckOrder .hiddenIDIgnore").val();

                $.ajax({
                    url: '{{ route('api.orders.changeStatusOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: order_id,
                        note: note
                    },
                    success: function(response) {

                        if (response.status == 200) {

                            alert("Cập nhật thành công.");
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });

            });

            $('#formUploadImageOrder').on("submit", function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const order_id = $("#formUploadImageOrder .hiddenIDOrderUpload").val();

                $.ajax({
                    url: `http://127.0.0.1:8000/api/orders/uploadImgConfirm/${order_id}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#formUploadImageOrder .error-confirm').text("Trường bắt buộc")
                        }
                        if (response.status == 200) {
                            $('.error-confirm').html('');
                            $('#formUploadImageOrder .note').val("")
                            $('#formUploadImageOrder')[0].reset();
                            $('#modalUpload').modal('hide');
                            fetchOrders();
                            alert("Cập nhật thành công.");
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });

            });


            $('.btn-order').on('click', function() {
                // Xóa lớp active khỏi tất cả các nút
                $('.btn-order').removeClass('active');

                // Thêm lớp active vào nút được click
                $(this).addClass('active');
            });

            // $('.orderStatus').on('change', function() {
            //     // Xóa lớp active khỏi tất cả các nút
            //     $('#modalConfirm').modal('show');

            // });


            const orderStatuses = [{
                    id: 1,
                    name: "Chờ xử lý",
                    next: [1, 2, 7]
                },
                {
                    id: 2,
                    name: "Đang xử lý",
                    next: [2, 3, 7]
                },
                {
                    id: 3,
                    name: "Đang giao hàng",
                    next: [3, 4, 5],
                    unnextList: [4, 5]
                },
                // {
                //     id: 4,
                //     name: "Đã giao hàng",
                //     next: [4, 6, 7]
                // },
                {
                    id: 4,
                    name: "Giao hàng thất bại",
                    next: [4]
                },
                {
                    id: 5,
                    name: "Hoàn thành",
                    next: [5]
                },
                {
                    id: 6,
                    name: "Đã hủy",
                    next: []
                }
            ];



            // Hàm gọi API để lấy dữ liệu
            function fetchOrders(updateCounts = false) {
                const search = $("#search").val();
                const startDate = $("#start_date_input").val();
                const endDate = $("#end_date_input").val();
                $("#loading-icon").show();
                // Gọi API
                $.ajax({
                    url: '{{ route('api.orders.index') }}',
                    method: "GET",
                    data: {
                        order_status_id: activeTab,
                        user_id: dataUser.id,
                        search,
                        startDate,
                        endDate,
                        page: currentPage,
                        limit: itemsPerPage,
                        role_user: dataUser.role

                    },
                    success: function(response) {

                        renderTable(response.orders, response.totalPages);
                        if (response
                            .totalPages
                        ) { // giả sử response có thuộc tính totalRecords chứa tổng số bản ghi
                            $('#pagination').twbsPagination({
                                totalPages: response.totalPages,
                                visiblePages: 3,
                                first: 'Đầu',
                                last: 'Cuối',
                                prev: 'Trước',
                                next: 'Sau',
                                startPage: currentPage, // Duy trì trang hiện tại
                                onPageClick: function(event, page) {
                                    currentPage = page;
                                    fetchOrders();
                                }
                            });
                        }
                        if (updateCounts) {

                            updateTabCounts(search, startDate, endDate);

                        }

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

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            let changedOrderIds = [];
            let debounceTimer;

            function handleStatusChange(orderId) {

                if (!changedOrderIds.includes(orderId)) {
                    changedOrderIds.push(orderId);
                }


                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {

                    fetchOrders(true);
                    changedOrderIds = [];
                }, 2000);
            }


            function renderTable(orders, totalPages) {
                $("#orderTable tbody").empty();

                if (orders.length === 0) {
                    $("#orderTable tbody").append(`
            <tr>
              <p>Không có dữ liệu</p>
            </tr>
          `);
                } else {
                    orders.forEach(order => {
                        const currentStatusId = order.order_statuses[0].pivot.order_status_id;
                        const selectId = `select_status_${order.id}`;
                        Pusher.logToConsole = true;

                        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                        });

                        var channel = pusher.subscribe('order-status.' + order.id);
                        channel.bind('event-change-status', function(data) {
                            if (data.userID != dataUser.id) {
                                handleStatusChange(data.orderId)
                            }
                        });
                        var channel = pusher.subscribe('order-status-lock.' + order.id);
                        channel.bind('event-change-status-lock', function(data) {
                            if (data.userID != dataUser.id) {
                                if (data.status == 0) {
                                    $(`#select_status_${order.id}`).prop('disabled', false);
                                } else {
                                    $(`#select_status_${order.id}`).prop('disabled', true);
                                }

                            }
                        });
                        let selectHtml =
                            `<select class="font-serif form-select form-select-sm orderStatus"  ${order.locked_status == 1 ? "disabled":""} data-order-id="${order.id}" id="${selectId}">`;
                        orderStatuses.forEach(status => {
                            const currentStatus = orderStatuses.find(s => s.id === currentStatusId);
                            const disabled = !currentStatus.next.includes(status.id) && status
                                .id !== currentStatusId ? "disabled" : "";
                            selectHtml +=
                                `<option value="${status.id}" ${disabled}>${status.name}</option>`;
                        });
                        selectHtml += `</select>`;

                        $("#orderTable tbody").append(`
                        <tr data-id="${order.id}">
                                <td class="sm-width">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" value=${order.id} id="checkbox-${order.id}"
                                        class="custom-control-input checkbox_animated checkbox-input">
                                    </div>
                                </td>
                                <td class="px-4 py-2"><p
                                        class="font-semibold uppercase text-xs">${ order.code }</p></td>
                                <td class="px-4 py-2"><span class="text-sm">${ convertDate(order.created_at) }</span></td>
                                <td class="px-4 py-2 text-xs" style="width: 280px; text-align: left;">
                                    <span class="block">
													<b>{{ __('form.order.fullname') }}: </b>
													${order.fullname}
												</span>
                                                <span class="block">
													<b>{{ __('form.order.phone_number') }}: </b>
													${order.phone_number}
												</span>
                                                <span class="block">
													<b>{{ __('form.order.address') }}: </b>
													${order.address}
												</span>
                                </td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">${ order.payment.name }</span></td>
                                <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">${ formatCurrency(order.total_amount) }</span></td>
                                        <td class="px-4 py-2"><span
                                        class="text-sm font-semibold">${ order.is_paid == 1 ? "Đã thanh toán" : "Chưa thanh toán" }</br></span>${ order.is_refund_cancel == 0 ? "<p style='color:red'>Chờ hoàn tiền</p>" : "" }${ order.is_refund_cancel == 1 ? `<p style='color:red'>Đã hoàn tiền</br>${order.check_refund_cancel == 0 ? "(Khách chưa nhận được tiền)":""}</p>` : "" }</td>
                                <td class="px-4 py-2 text-xs">

                                    
                                    ${currentStatusId === 5 ?
                    `<div class="span-completed"><div class="status-completed"><span>Hoàn thành</span></div></div>` :
                    (currentStatusId === 6 ?
                        `<div class="span-failed"><div class="status-failed"><span>Đã hủy</span></div></div>` :
                        selectHtml
                    )
                }
                                </td>

                                <td>
                                    <ul id="actions">
                                        ${order.order_statuses[0].pivot.employee_evidence != null 
                                            && order.order_statuses[0].pivot.customer_confirmation==0 ? `
                                                                <div _ngcontent-ng-c1063460097="" class="ng-star-inserted">
                                                                <div class="status-pending">
                                                                <span style="font-size: 11px; cursor: pointer;" data-configOrder="${order.id}">Xung đột</span>
                                                                </div>
                                                                </div>


                                                                ` : `

                                                                `}
                                        <li>
                                            ${order.is_refund_cancel != null ? `
                                                    <div style="width: 30px;height: 30px;cursor: pointer;" class="show_modal_refund_bank" data-idorder="${order.id}">
                                                        <i style="color:#0da487" class="ri-exchange-dollar-line"></i></div>
                                                    `:""}
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

                    $('.status-pending span').on("click", function(event) {
                        event.preventDefault();
                        const orderId = $(this).data(
                            'configorder');
                        callApiGetOrderOrderStatus(orderId);

                        $('#modalConfirm').modal('show');
                    });

                    async function callApiGetOrder(orderId) {
                        await $.ajax({
                            url: `http://127.0.0.1:8000/api/orders/getOrder/${orderId}`,
                            type: 'get',

                            success: function(response) {
                                const order = response.order
                                const imageUrl =
                                    `{{ Storage::url('${order.img_send_refund_money}') }}`;
                                $("#modalShowRefundBank #total_amount").text(`${formatCurrency(order
                                    .total_amount)}đ`)
                                $("#modalShowRefundBank #user_bank_name").text(order.user
                                    .user_bank_name)
                                $("#modalShowRefundBank #bank_name").text(order.user
                                    .bank_name)
                                $("#modalShowRefundBank #bank_account").text(order.user
                                    .bank_account)
                                $("#modalShowRefundBank #idorder").val(order.id)

                                if (order.is_refund_cancel == 1) {
                                    $("#modalShowRefundBank #btn_send_money").attr(
                                        "disabled", true);
                                }

                                if (order.is_refund_cancel == 0) {
                                    $("#modalShowRefundBank #div_send_money").append(`
                                    <label for="img_send_money" class="form-label">Tải lên ảnh</label>
                <input class="form-control" type="file" id="img_send_money" name="img_send_money">
                <img id="image_preview" class="mt-3" style="width: 100%">
                    <!-- Preview ảnh sẽ được hiển thị ở đây -->
                </img>
                                    `)
                                }

                                if (order.is_refund_cancel == 1) {
                                    $("#modalShowRefundBank #div_send_money").append(`
                                    <label for="img_send_money" class="form-label">Ảnh chuyển khoản</label>
                <img id="image_preview" class="mt-3" style="width: 100%" src="${imageUrl}">
             
                                    `)
                                }

                                $('#modalShowRefundBank #img_send_money').on('change', function(
                                    event) {
                                    const file = event.target.files[0];
                                    console.log("showw file");
                                    //
                                    if (file) {
                                        const reader = new FileReader();
                                        const fileType = file.type.split('/')[0];

                                        reader.onload = function(e) {
                                            if (fileType === 'image') {
                                                $('#modalShowRefundBank #image_preview')
                                                    .attr('src', e.target.result)
                                                    .show();
                                                $("#btn_send_money").attr('disabled',
                                                    false);
                                            }
                                        }

                                        reader.readAsDataURL(file); // Đọc file ảnh
                                    }
                                });



                            },
                            error: function(error) {
                                console.error(
                                    "Lỗi lấy order",
                                    error);
                            }
                        });
                    }



                    $(".show_modal_refund_bank").on("click", async function() {
                        const orderId = $(this).data(
                            'idorder');
                        $("#modalShowRefundBank #div_send_money").empty();
                        await callApiGetOrder(orderId)

                        $("#modalShowRefundBank").modal("show")
                    })

                    $("#modalFormShowRefundBank").off("submit").on("submit", async function(e) {
                        e.preventDefault();
                        const idOrder = $("#modalShowRefundBank #idorder").val();
                        if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                            return;
                        }
                        const formData = new FormData(this);

                        await $.ajax({
                            url: '{{ route('api.orders.changeStatusRefundMoney') }}',
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {

                                if (response.status == 200) {
                                    Toastify({
                                        text: "Thao tác thành công",
                                        duration: 2000,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        stopOnFocus: true,
                                        style: {
                                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                                        },
                                    }).showToast();
                                    $("#modalShowRefundBank #div_send_money").empty()
                                    callApiGetOrder(idOrder)
                                    fetchOrders();

                                }
                            },
                            error: function(error) {
                                console.error(
                                    "Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });

                    })
                }
            }


            function callApiGetOrderOrderStatus(idOrder) {
                $.ajax({
                    url: '{{ route('api.orders.getOrderOrderByStatus') }}',
                    type: 'POST',
                    data: {
                        order_id: idOrder,
                    },
                    success: function(response) {
                        console.log(response.data[0])
                        const imageUrl =
                            `{{ Storage::url('${response.data[0].employee_evidence}') }}`;
                        //Chuyển đổi thành Javascript string
                        const jsImageUrl = imageUrl.replace(/\{\{\s*|\s*\}\}/g, '');
                        $("#modalConfirm #img-checkout-order").attr("src",
                            jsImageUrl);
                        if (response.data[0].customer_confirmation == 1) {
                            $("#modalConfirm #checkout-order-status").text(
                                "Khách hàng đã nhận được hàng");
                        } else if (response.data[0].customer_confirmation == 0) {
                            $("#modalConfirm #checkout-order-status").text(
                                "Khách hàng chưa nhận được hàng");
                        }
                        $("#modalConfirm #text-note-checkout-order").val(
                            `${response.data[0].note?response.data[0].note:""}`);

                        $("#modalConfirm .hiddenIDIgnore").val(`${response.data[0].order_id}`)

                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });
            }

            function callApiChangeStatusListOrder(idOrders, idStatus) {
                $.ajax({
                    url: '{{ route('api.orders.changeStatusOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: idOrders,
                        status_id: idStatus,
                        user_id: dataUser.id

                    },
                    success: function(response) {

                        console.log("response", response)
                        if (response.status == 200) {
                            $('#checkbox-table').prop('checked', false);
                            $('#select-change-status-items').empty();
                            $("#count_selected_item").text(``)
                            // $('.btn-download-all').addClass('active');
                            $('#selected-category-ids').val('');
                            fetchOrders(true);
                            toggleBulkActionButton();
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });
            }



            function updateSelectedIds() { // 3. Hàm cập nhật input ẩn
                const selectedIds = $('.checkbox-input:checked').map(
                    function() { // 3.1 Lấy mảng các ID của checkbox được chọn
                        return $(this).val(); // 3.2 Lấy giá trị (value) của checkbox (chính là ID category)
                    }).toArray(); // 3.3 Chuyển đổi kết quả sang mảng JavaScript

                const checkedCount = selectedIds.length
                $('#select-change-status-items').empty();

                if (checkedCount) {
                    $("#count_selected_item").text(`(Đã chọn ${checkedCount})`)
                    $('.btn-download-all').removeClass('active');

                    let selectHtmlStatus = `
                    <select class="font-serif form-select form-select-sm orderStatus"  style="width: unset" id="select_status_list">
                `;

                    orderStatuses.forEach(status => {
                        selectHtmlStatus += `
                    <option value="${status.id}">${status.name}</option>
                `;
                    });

                    selectHtmlStatus += `</select>`;


                    $('#select-change-status-items').append(selectHtmlStatus);
                    $("#select_status_list").val(activeTab)

                    function updateSelectStatus() {
                        const currentStatus = parseInt($('#select_status_list').val(), 10);
                        const currentStatusObj = orderStatuses.find(s => s.id === currentStatus);
                        $('#select_status_list option').each(function() {
                            const status = parseInt($(this).val(), 10);

                            // if (currentStatus == 3) {
                            //     $(this).prop('disabled', !currentStatusObj.unnextList.includes(status));

                            // } else {

                            // }
                            $(this).prop('disabled', !currentStatusObj.next.includes(status));
                        });
                    }

                    updateSelectStatus();

                    let lockTimersList = {};
                    let blurTimersList = {};



                    function lockOrderList(selectedIds, selectElement) {
                        $.ajax({
                            url: '{{ route('api.orders.lockOrder') }}',
                            type: 'POST',
                            data: {
                                order_id: selectedIds,
                                user_id: dataUser.id
                            },
                            success: function(response) {
                                console.log("responselockkkkkkk:", response);
                                if (response.status == 200) {
                                    // selectElement.prop('disabled', true);

                                    if (lockTimersList["list"]) {
                                        clearTimeout(lockTimersList["list"]);
                                    }
                                    lockTimersList["list"] = setTimeout(() => unlockOrderList(
                                            selectedIds,
                                            selectElement),
                                        60000);

                                    if (blurTimersList["list"]) {
                                        clearTimeout(blurTimersList["list"]);
                                    }
                                    blurTimersList["list"] = setTimeout(() => {
                                        if (selectElement) {
                                            selectElement.blur();
                                            console.log('Automatically blurred select.');
                                        }
                                        selectElement.prop('disabled', false);

                                    }, 60000);
                                }
                            },
                            error: function(error) {
                                console.error("lỗi khóa",
                                    error);
                            }
                        });
                    }

                    function unlockOrderList(selectedIds, selectElement) {
                        $.ajax({
                            url: '{{ route('api.orders.unlockOrder') }}',
                            type: 'POST',
                            data: {
                                order_id: selectedIds,
                                user_id: dataUser.id

                            },
                            success: function(response) {
                                console.log("response0000000000000000lockkkkkkk:", response);

                                if (response.status == 200) {
                                    console.log(" un loked order lock order")
                                    selectElement.prop('disabled', false);

                                    clearTimeout(lockTimersList["list"]);
                                    clearTimeout(blurTimersList["list"]);
                                }
                            },
                            error: function(error) {
                                console.error("Lỗi mở khóa",
                                    error);
                            }
                        });
                    }


                    function checkOrderLockList(selectedIds, selectElement) {

                        console.log("Checking order lock list,", selectedIds)
                        $.ajax({
                            url: '{{ route('api.orders.checkLockOrder') }}',
                            type: 'POST',
                            data: {
                                order_id: selectedIds,
                            },
                            success: function(response) {

                                if (response.status == 200) {

                                    if (response.data.length > 0) {
                                        selectElement.prop('disabled', true);
                                        const codes = response.data.map(item => item.code).filter(
                                            Boolean); // Ensures `code` exists

                                        // Display the codes in the alert message
                                        if (codes.length > 0) {
                                            alert('Đơn hàng này đã bị khóa. Các mã code: ' + codes.join(
                                                ', '));
                                        } else {
                                            alert('Đơn hàng này đã bị khóa.');
                                        }

                                    } else {
                                        lockOrderList(selectedIds, selectElement)
                                    }
                                }
                            },
                            error: function(error) {
                                console.error("Lỗi check",
                                    error);
                            }
                        });
                    }

                    $('#select-change-status-items').on('focus', '.orderStatus', function() {
                        checkOrderLockList(selectedIds, $(this));
                        console.log("orderId11111:", selectedIds);

                    }).on('blur', '.orderStatus', function() {
                        console.log("orderId22222222222222:", selectedIds);

                        unlockOrderList(selectedIds, $(this));
                    });






                    let previousValuesOrderList;

                    // Sự kiện focus để lưu giá trị trước đó
                    $('#select_status_list').on('focus', function() {
                        previousValuesOrderList = $(this).val(); // Lưu giá trị hiện tại vào object
                    });
                    $('#select_status_list').on("change", function() {
                        if (!confirm('Bạn có chắc chắn muốn thay đổi trạng thái không?')) {
                            $('#select_status_list').val(previousValuesOrderList);
                            return;
                        }
                        const selectedStatusChangeList = $(this).val();
                        console.log("selectedIds", selectedIds)
                        callApiChangeStatusListOrder(selectedIds, selectedStatusChangeList);
                    });
                } else {
                    $('#select-change-status-items').empty();
                    $("#count_selected_item").text(``)
                    if (activeTab == 2) {
                        $('.btn-download-all').addClass('active');
                    }

                }
                $('#selected-category-ids').val(selectedIds.join(',')); // 3.4 Gán chuỗi ID vào input ẩn
            }

            function toggleBulkActionButton() { // 4. Hàm ẩn/hiện nút "Xóa tất cả"
                $('#btn-move-to-trash-all').toggleClass('visually-hidden', !(activeTab === 2 && $(
                    '#selected-category-ids').val() !== ''));
            }

            function updateTabCounts(search, startDate, endDate) {
                $(".tab").each(function() {
                    const status = $(this).data("status");
                    $.ajax({
                        url: '{{ route('api.orders.countByStatus') }}',
                        method: "GET",
                        data: {
                            order_status_id: status,
                            search,
                            startDate,
                            endDate,
                        },
                        success: function(response) {
                            if (search == "" && startDate == "" && endDate == "") {
                                $(this).find(".count").text("");
                            }
                            if (response[0]) {
                                if (search == "" && startDate == "" && endDate == "") {
                                    $(this).find(".count").text("");
                                } else {

                                    $(this).find(".count").text(`(${response[0].count})`);
                                }

                            } else {
                                $(this).find(".count").text("");

                            }
                        }.bind(this),
                        error: function() {
                            console.error("Error fetching count for status:", status);
                        },
                    });
                });
            }

            let activeTab = 1;
            let currentPage = 1;
            const itemsPerPage = 5;
            if (activeTab === 2) {
                $('.btn-download-all').addClass('active');
            }
            $('#checkbox-table').on('click', function() { // 1. Click vào checkbox "Chọn tất cả"
                const isChecked = $(this).prop(
                    'checked'); // 1.1 Lấy trạng thái checked của checkbox "Chọn tất cả"
                $('.checkbox-input').prop('checked',
                    isChecked); // 1.2 Đặt trạng thái checked cho tất cả checkbox con

                updateSelectedIds(); // 1.3 Cập nhật input ẩn chứa ID được chọn
                toggleBulkActionButton(); // 1.4 Ẩn/hiện nút "Xóa tất cả"
            });

            $('#orderTable tbody').on('click', '.checkbox-input', function() {
                $('#checkbox-table').prop('checked', $('.checkbox-input:checked').length === $(
                    '.checkbox-input').length);
                updateSelectedIds();
                toggleBulkActionButton();
            });

            $('#btn-move-to-trash-all').on('click', function() {
                const selectedIds = $('#selected-category-ids').val(); // 6.1 Lấy chuỗi ID từ input ẩn
                const selectedIdsArray = selectedIds ? selectedIds.split(',') : [];
                fetch(`http://127.0.0.1:8000/api/orders/invoice`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Nếu dùng Laravel
                        },
                        body: JSON.stringify({
                            idOrders: selectedIdsArray
                        }) // orderData là dữ liệu đơn hàng của bạn
                    })
                    .then((response) => {

                        return response.blob();
                    }) // response.blob() nếu muốn trả về file pdf trực tiếp. response.json() nếu trả về đường dẫn
                    .then(blob => {
                        //Tạo link download
                        const url = window.URL.createObjectURL(blob);
                        window.open(url); // Mở PDF trong tab mới

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            })



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
                $('.checkbox-input:checked').prop('checked', false);
                $('#checkbox-table').prop('checked', false);
                $("#count_selected_item").text("")
                // Đặt giá trị của #selected-category-ids thành rỗng
                $('#selected-category-ids').val('');
                $('#select-change-status-items').empty()

                $('#btn-move-to-trash-all').toggleClass('visually-hidden', !(activeTab === 2 && $(
                    '#selected-category-ids').val() != ''))
                if (activeTab == 2) {
                    $('.btn-download-all').addClass('active');

                } else {
                    $('.btn-download-all').removeClass('active');

                }
                currentPage = 1; // Reset về trang đầu tiên
                $('#pagination').twbsPagination('destroy');
                fetchOrders();
            });

            let lockTimers = {};
            let blurTimers = {};



            function lockOrder(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.lockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        user_id: dataUser.id
                    },
                    success: function(response) {
                        console.log("responselockkkkkkk:", response);
                        if (response.status == 200) {
                            // selectElement.prop('disabled', true);

                            console.log("loked order lock order")
                            if (lockTimers[orderId]) {
                                clearTimeout(lockTimers[orderId]);
                            }
                            lockTimers[orderId] = setTimeout(() => unlockOrder(orderId, selectElement),
                                60000);

                            if (blurTimers[orderId]) {
                                clearTimeout(blurTimers[orderId]);
                            }
                            blurTimers[orderId] = setTimeout(() => {
                                if (selectElement) {
                                    selectElement.blur();
                                    console.log('Automatically blurred select.');
                                }
                                selectElement.prop('disabled', false);

                            }, 60000);
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }

            function unlockOrder(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.unlockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        user_id: dataUser.id

                    },
                    success: function(response) {
                        console.log("response0000000000000000lockkkkkkk:", response);

                        if (response.status == 200) {
                            console.log(" un loked order lock order")
                            selectElement.prop('disabled', false);

                            clearTimeout(lockTimers[orderId]);
                            clearTimeout(blurTimers[orderId]);
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }


            function checkOrderLock(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.checkLockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            if (response.locked == 1) {
                                selectElement.prop('disabled', true);
                                alert('Đơn hàng này đã bị khóa.');

                            } else {
                                lockOrder(orderId, selectElement)
                            }
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }

            $('#orderTable').on('focus', '.orderStatus', function() {
                const orderId = $(this).data('order-id');
                checkOrderLock(orderId, $(this));
                console.log("orderId11111:", orderId);

            }).on('blur', '.orderStatus', function() {
                let orderId = $(this).data('order-id');
                console.log("orderId22222222222222:", orderId);

                unlockOrder(orderId, $(this));
            });

            let previousValuesOrder = {};

            $('#orderTable').on('focus', '.orderStatus', function() {
                const orderId = $(this).data('order-id');
                previousValuesOrder[orderId] = $(this).val();
            });

            $('#orderTable').on('change', '.orderStatus', function() {
                const orderId = $(this).data('order-id');

                if (!confirm('Bạn có chắc chắn muốn thay đổi trạng thái không?')) {
                    $(this).val(previousValuesOrder[orderId]); // Khôi phục giá trị trước đó
                    return;
                }

                const selectedValue = parseInt($(this).val());
                const idOrder = $(this).closest('tr').data('id');

                // if (selectedValue === 4) {

                //     $("#modalUpload .hiddenIDOrderUpload").val(idOrder);

                //     $('#modalUpload').modal(
                //         'show');
                //     $(this).val($(this).data(
                //         'previous-value'));
                //     return;
                // }


                $.ajax({
                    url: '{{ route('api.orders.changeStatusOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: idOrder,
                        status_id: selectedValue,
                        user_id: dataUser.id,

                    },
                    success: function(response) {
                        console.log("response", response);
                        if (response.status == 200) {
                            fetchOrders(true);
                            $('#checkbox-table').prop('checked', false);
                            $('#select-change-status-items').empty();
                            $("#count_selected_item").text(``)
                            // $('.btn-download-all').addClass('active');
                            $('#selected-category-ids').val('');
                            toggleBulkActionButton();
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });
            });

            $('#orderTable').on('focus', '.orderStatus', function() {
                $(this).data('previous-value', $(this).val());
            });


            $("#btn-print-all").click(() => {
                fetch(`http://127.0.0.1:8000/api/orders/invoice`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Nếu dùng Laravel
                        },
                        body: JSON.stringify({
                            activeTab: activeTab
                        }) // orderData là dữ liệu đơn hàng của bạn
                    })
                    .then((response) => {

                        return response.blob();
                    }) // response.blob() nếu muốn trả về file pdf trực tiếp. response.json() nếu trả về đường dẫn
                    .then(blob => {
                        //Tạo link download
                        const url = window.URL.createObjectURL(blob);
                        window.open(url); // Mở PDF trong tab mới

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });



            })

            // Khởi tạo lần đầu
            fetchOrders();
            toggleBulkActionButton();
            Pusher.logToConsole = true;

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channel = pusher.subscribe('order-create-update');
            channel.bind('event-update-order', function(data) {
                fetchOrders()
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
    <script src="{{ asset('js/utility.js') }}"></script>
@endpush
