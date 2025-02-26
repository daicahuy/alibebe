@extends('admin.layouts.master')

@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
@endpush


@section('content')
    @if ($errors->has('message'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ $errors->first('message') }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>
                            <a class="link" href="{{ route('admin.coupons.index') }}">{{ __('form.coupons') }}</a>
                            <span class="fs-6 fw-light">></span> {{ __('message.add_new') }}
                        </h5>
                    </div>
                    <form novalidate="" class="theme-form theme-form-2 mega-form " method="POST"
                        action="{{ route('admin.coupons.store') }}">
                        @csrf
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
                                                <i class="ri-close-circle-line"></i> Hợp Lệ
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
                                                    {{ __('form.coupon.title') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input id="title" type="text" formcontrolname="title"
                                                        name="title" value="{{ old('title') }}"
                                                        class="form-control @error('title')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="Nhập Tiêu Đề">
                                                    @error('title')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="description">
                                                    {{ __('form.coupon.description') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                                        placeholder="Nhập Mô Tả Giảm Giá">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="code">
                                                    {{ __('form.coupon.code') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input id="code" type="text" formcontrolname="code"
                                                        name="code" value="{{ old('code') }}"
                                                        class="form-control @error('code')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="Nhập Mã Giảm Giá">
                                                    @error('code')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- PHẦN SELECT TYPE --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="type">
                                                    {{ __('form.coupon.discount_type') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select id="type" name="discount_type"
                                                        class="form-control form-select @error('discount_type') is-invalid @enderror">
                                                        <option value="0"
                                                            {{ old('discount_type') == 0 ? 'selected' : '' }}>Giá Cố Định
                                                        </option>
                                                        <option value="1"
                                                            {{ old('discount_type') == 1 ? 'selected' : '' }}>Phần Trăm
                                                        </option>
                                                    </select>
                                                    @error('discount_type')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- PHẦN SELECT TYPE --}}

                                            {{-- PHẦN NHẬP GIÁ TRỊ GIẢM GIÁ --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="discount_value">
                                                    {{ __('form.coupon.discount_value') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" id="discount_value" name="discount_value"
                                                            value="{{ old('discount_value') }}"
                                                            class="form-control @error('discount_value') is-invalid @enderror"
                                                            placeholder="Nhập Mức Giảm Giá">
                                                    </div>
                                                    @error('discount_value')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="is_expired">
                                                    {{ __('form.coupon.is_expired') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_expired" name="is_expired"
                                                                formcontrolname="is_expired" value="1"
                                                                class="ng-untouched ng-pristine ng-valid @error('is_expired') is-invalid @enderror"
                                                                {{ old('is_expired') == '1' ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                    @error('is_expired')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="start-date-div"
                                                style="display:none;">
                                                <label class="col-sm-3 form-label-title mb-0" for="start_date">
                                                    {{ __('form.coupon.start_date') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group custom-dt-picker">
                                                        <input placeholder="yyyy-mm-dd" name="start_date"
                                                            value="{{ old('start_date') }}" id="start_date_input"
                                                            readonly=""
                                                            class="form-control @error('start_date')
                                                                is-invalid
                                                            @enderror">
                                                        <button type="button" id="startDatePickerBtn"
                                                            class="btn btn-outline-secondary">
                                                            <i class="ri-calendar-line"></i>
                                                        </button>
                                                    </div>
                                                    @error('start_date')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="end-date-div"
                                                style="display:none;">
                                                <label class="col-sm-3 form-label-title mb-0" for="end_date">
                                                    {{ __('form.coupon.end_date') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group custom-dt-picker">
                                                        <input placeholder="yyyy-mm-dd" name="end_date"
                                                            value="{{ old('end_date') }}" id="end_date_input"
                                                            readonly=""
                                                            class="form-control @error('end_date')
                                                                is-invalid
                                                            @enderror">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="endDatePickerBtn">
                                                            <i class="ri-calendar-line"></i>
                                                        </button>
                                                    </div>
                                                    @error('end_date')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="status">
                                                    {{ __('form.coupon.is_active') }}
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch">
                                                            <input type="checkbox" id="is_active" name="is_active"
                                                                formcontrolname="is_active" value="1"
                                                                class="ng-untouched ng-pristine ng-valid @error('is_active') is-invalid @enderror"
                                                                {{ old('is_active') == '1' ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                        @error('is_active')
                                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="restriction-panel" role="tabpanel"
                                            aria-labelledby="ngb-nav-1">
                                            <h3>Cài đặt Hợp Lệ</h3>
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="min_order_value">
                                                    Giá Tối Thiểu
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-text"> $ </span>
                                                        <input type="number" id="min_order_value"
                                                            name="coupon_restrictions[min_order_value]"
                                                            value="{{ old('coupon_restrictions.min_order_value') }}"
                                                            formcontrolname="min_order_value"
                                                            class="form-control @error('coupon_restrictions.min_order_value')
                                                                is-invalid
                                                            @enderror"
                                                            placeholder="Enter min order value">
                                                    </div>
                                                    <p class="help-text">*Xác định
                                                        giá trị đơn hàng tối thiểu cần thiết để sử dụng phiếu giảm giá.
                                                    </p>
                                                    @error('coupon_restrictions.min_order_value')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- PHẦN NHẬP HẠN MỨC TỐI ĐA --}}
                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-coupon">
                                                <label class="col-sm-3 form-label-title mb-0" for="max_discount_value">
                                                    Hạn Mức Tối Đa
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" id="max_discount_value"
                                                        name="coupon_restrictions[max_discount_value]"
                                                        value="{{ old('coupon_restrictions.max_discount_value') }}"
                                                        class="form-control @error('coupon_restrictions.max_discount_value') is-invalid @enderror"
                                                        placeholder="Enter value">
                                                    <p class="help-text">*Chỉ định số tiền tối đa có thể sử dụng trong một
                                                        phiếu giảm giá.</p>
                                                    @error('coupon_restrictions.max_discount_value')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
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
                                                                class="ng-untouched ng-pristine ng-valid">
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-coupon">
                                                <label class="col-sm-3 form-label-title mb-0" for="usage_limit">
                                                    Sử Dụng Cho Mỗi Phiếu Giảm Giá
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" id="usage_limit" name="usage_limit"
                                                        value="{{ old('usage_limit') }}" formcontrolname="usage_limit"
                                                        class="form-control ng-untouched ng-pristine ng-valid @error('usage_limit')
                                                            is-invalid
                                                        @enderror"
                                                        placeholder="Enter value">
                                                    <p class="help-text">*Chỉ định
                                                        số lần tối đa có thể sử dụng một phiếu giảm giá.</p>
                                                    @error('usage_limit')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-customer">
                                                <label class="col-sm-3 form-label-title mb-0" for="usage_per_customer">
                                                    Sử dụng cho Nhóm Khách Hàng
                                                </label>
                                                <div class="col-sm-9">
                                                    <select name="user_group" id=""
                                                        class="form-control form-select">
                                                        @foreach ($userGroupTypes as $key => $value)
                                                            <option value="{{ $key }}"
                                                                {{ old('user_group') == $key ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-theme ms-auto mt-4" id="coupon_btn" type="submit">
                            Lưu Mã Giảm Giá
                        </button>
                    </form>
                </div>
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

            if ($('#is_expired').prop('checked')) {
                $('#start-date-div, #end-date-div').show();
            }
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

            $('input, select, textarea').on('focus', function() {
                const $input = $(this);
                // Tìm error message trong parent gần nhất có class col-sm-9
                const $errorDiv = $input.closest('.col-sm-9').find('.alert-danger');

                if ($input.hasClass('is-invalid')) {
                    $input.removeClass('is-invalid');
                    $errorDiv.fadeOut(200);
                }
            });

            // Lấy các phần tử cần thiết
            var $discountType = $('#type');
            var $discountValue = $('#discount_value');
            var $maxDiscountValue = $('#max_discount_value');

            // Hàm để cập nhật max_discount_value
            function updateMaxDiscountValue() {
                var discountType = $discountType.val();
                var discountValue = $discountValue.val();

                if (discountType == '0') { // Giá Cố Định
                    $maxDiscountValue.val(discountValue); // Cập nhật giá trị max_discount_value
                    $maxDiscountValue.prop('readonly', true); // Không cho phép chỉnh sửa
                } else {
                    $maxDiscountValue.val('');
                    $maxDiscountValue.prop('readonly', false); // Cho phép chỉnh sửa nếu là Phần Trăm
                }
            }

            // Sự kiện khi thay đổi loại giảm giá
            $discountType.change(function() {
                updateMaxDiscountValue();
            });

            // Sự kiện khi thay đổi giá trị giảm giá
            $discountValue.on('input', function() {
                if ($discountType.val() == '0') { // Khi loại giảm giá là Giá Cố Định
                    $maxDiscountValue.val($discountValue.val());
                }
            });

            // Gọi hàm cập nhật ngay khi trang được tải
            updateMaxDiscountValue();
        });

        $(document).ready(function() {
            function checkPanelErrors() {
                // Xóa hết indicator cũ
                $('.nav-link .text-danger').remove();

                // Kiểm tra và thêm indicator cho từng panel
                ['general', 'restriction', 'usage'].forEach(id => {
                    if ($(`#${id}-panel .alert-danger`).length > 0) {
                        $(`#${id} .nav-link`).append(
                            '<i class="ri-error-warning-line text-danger ms-2"></i>');
                        // Active tab đầu tiên có lỗi
                        if (!$('.nav-link.active').parent().find('.text-danger').length) {
                            $(`#${id} .nav-link`).tab('show');
                        }
                    }
                });
            }

            checkPanelErrors();

            // Xóa indicator khi input thay đổi
            $('input, select, textarea').on('input focus', function() {
                const panelId = $(this).closest('.tab-pane').attr('id').replace('-panel', '');
                $(`#${panelId} .nav-link .text-danger`).remove();
            });
        });
    </script>
@endpush
