@extends('admin.layouts.master')

@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')

@endpush


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header">
                        <div class="d-flex align-items-center">
                            <h5>Tạo Mã Giảm Giá</h5>
                        </div>
                    </div>
                    <form novalidate="" class="theme-form theme-form-2 mega-form ">
                        <div class="vertical-tabs">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4">
                                    <ul class="nav nav-pills coupon-tab flex-column" role="tablist">
                                        <li id="general" class="nav-item" role="presentation"> <a href="#general-panel"
                                                class="nav-link active" id="ngb-nav-0" data-bs-toggle="tab" role="tab"
                                                aria-controls="general-panel" aria-selected="true" aria-disabled="false">
                                                <i class="ri-settings-line"></i> Tổng Quan
                                            </a>
                                        </li>
                                        <li id="restriction" class="nav-item" role="presentation"> <a
                                                href="#restriction-panel" class="nav-link" id="ngb-nav-1"
                                                data-bs-toggle="tab" role="tab" aria-controls="restriction-panel"
                                                aria-selected="false" aria-disabled="false">
                                                <i class="ri-close-circle-line"></i> Hạn Chế
                                            </a>
                                        </li>
                                        <li id="usage" class="nav-item" role="presentation"> <a href="#usage-panel"
                                                class="nav-link" id="ngb-nav-2" data-bs-toggle="tab" role="tab"
                                                aria-controls="usage-panel" aria-selected="false" aria-disabled="false">
                                                <i class="ri-pie-chart-line"></i> Sử Dụng
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xl-9 col-lg-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="general-panel" role="tabpanel"
                                            aria-labelledby="ngb-nav-0">
                                            <h3>Tổng Quan Cài Đặt</h3>
                                            <div class="align-items-center g-2 mb-4 row">

                                                <label class="col-sm-3 form-label-title mb-0" for="title">
                                                   Tiêu Đề
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input id="title" type="text" formcontrolname="title"
                                                        class="form-control "
                                                        placeholder="Enter coupon title">
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="description">
                                                    Mô Tả 
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea id="description" type="text" formcontrolname="description"
                                                        class="form-control " placeholder="Enter coupon description"></textarea>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="code">
                                                    Mã Giảm Giá
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input id="code" type="text" formcontrolname="code"
                                                        class="form-control "
                                                        placeholder="Enter coupon code">
                                                </div>
                                            </div>

                                            {{-- PHẦN SELECT TYPE --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="type">Loại Giảm Giá<span
                                                        class="theme-color ms-2 required-dot">*</span></label>
                                                <div class="col-sm-9">
                                                    <select id="type"
                                                        class="form-control form-select">
                                                        <option value="" disabled selected>Lựa Chọn Loại Giảm Giá</option>
                                                        <option value="percentage">Phần Trăm</option>
                                                        <option value="free_shipping">Miễn Phí Ship</option>
                                                        <option value="fixed">Thương Lượng</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- PHẦN SELECT TYPE --}}

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="amount">
                                                    Số Lượng
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-text"> $ </span>
                                                        <input type="number" name="amount" formcontrolname="amount"
                                                            class="form-control ng-untouched ng-pristine ng-valid"
                                                            placeholder="Nhập Số Lượng">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="is_expired">
                                                    Đã Hết Hạn
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_expired"
                                                                formcontrolname="is_expired"
                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center g-2 mb-4 row" id="start-date-div"
                                                style="display:none;">
                                                <label class="col-sm-3 form-label-title mb-0" for="start_date">
                                                   Ngày Bắt Đầu<span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="dp-hidden position-absolute custom-dp-dropdown">
                                                        <div class="input-group">
                                                            <input name="datepicker" id="start_date" tabindex="-1"
                                                                readonly="" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="input-group custom-dt-picker">
                                                        <input placeholder="yyyy-mm-dd" name="dpFromDate"
                                                            id="start_date_input" readonly="" class="form-control">
                                                        <button type="button" id="startDatePickerBtn"
                                                            class="btn btn-outline-secondary">
                                                            <i class="ri-calendar-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="end-date-div"
                                                style="display:none;">
                                                <label class="col-sm-3 form-label-title mb-0" for="end_date">
                                                    Ngày Kết Thúc<span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group custom-dt-picker">
                                                        <input placeholder="yyyy-mm-dd" name="dpToDate"
                                                            id="end_date_input" readonly="" class="form-control">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="endDatePickerBtn">
                                                            <i class="ri-calendar-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="is_first_order">
                                                   Đơn Hàng Đầu Tiên ?
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_first_order"
                                                                formcontrolname="is_first_order"
                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="status">
                                                   Trạng Thái
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="status"
                                                                formcontrolname="status"
                                                                class="ng-untouched ng-pristine ng-valid">
                                                            <span class="switch-state"></span>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- PHẦN cHỌN NHIỀU SẢN PHẨM --}}
                                        <div class="tab-pane fade" id="restriction-panel" role="tabpanel"
                                            aria-labelledby="ngb-nav-1">
                                            <h3>Cài đặt hạn chế</h3>
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="is_apply_all">
                                                    Chấp Nhận Cho Tất Cả Sản Phẩm
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_apply_all"
                                                                formcontrolname="is_apply_all"
                                                                class="ng-untouched ng-pristine ng-valid">
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="include_product">
                                                    Bao Gồm Sản Phẩm<span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select name="" id="" class="form-control form-select" multiple>
                                                        <option value="">Điện thoại</option>
                                                        <option value="">Điện thoại</option>
                                                        <option value="">Điện thoại</option>
                                                        <option value="">Điện thoại</option>
                                                        <option value="">Điện thoại</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- PHẦN cHỌN NHIỀU SẢN PHẨM --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="min_spend">
                                                   Giá Tối Thiểu
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-text"> $ </span>
                                                        <input type="number" id="min_spend" name="min_spend"
                                                            formcontrolname="min_spend"
                                                            class="form-control "
                                                            placeholder="Enter min spend">
                                                    </div>
                                                    <p class="help-text">*Xác định
                                                        giá trị đơn hàng tối thiểu cần thiết để sử dụng phiếu giảm giá.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="usage-panel" role="tabpanel"
                                            aria-labelledby="ngb-nav-2">
                                            <h3>Cài Đặt Sử Dụng</h3>
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="is_unlimited">
                                                    Không Giới Hạn<span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_unlimited"
                                                                formcontrolname="is_unlimited"
                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-coupon">
                                                <label class="col-sm-3 form-label-title mb-0" for="usage_per_coupon">
                                                   Sử Dụng Cho Mỗi Phiếu Giảm Giá
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" id="usage_per_coupon" name="usage_per_coupon"
                                                        formcontrolname="usage_per_coupon"
                                                        class="form-control ng-untouched ng-pristine ng-valid"
                                                        placeholder="Enter value">
                                                    <p class="help-text">*Chỉ định
                                                        số lần tối đa có thể sử dụng một phiếu giảm giá.</p>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-customer">
                                                <label class="col-sm-3 form-label-title mb-0" for="usage_per_customer">
                                                    Sử dụng cho mỗi khách hàng
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" id="usage_per_customer"
                                                        name="usage_per_customer" formcontrolname="usage_per_customer"
                                                        class="form-control ng-untouched ng-pristine ng-valid"
                                                        placeholder="Enter value">
                                                    <p class="help-text">*Chỉ định
                                                        số lần tối đa mà một khách hàng có thể
                                                        sử dụng phiếu giảm giá.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <button class="btn btn-theme ms-auto mt-4" id="coupon_btn" type="submit">
                    Lưu Mã Giảm Giá
                </button>
            </div>
        </div>
    </div>
@endsection

@push('js_library')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

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


        });
    </script>
@endpush
