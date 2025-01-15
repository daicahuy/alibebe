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
                                                        placeholder="Nhập Mô Tả Giảm Giá"></textarea>
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
                                                        class="form-control form-select @error('discount_type')
                                                            is-invalid
                                                        @enderror">
                                                        <option value="" disabled selected>
                                                            Lựa Chọn Loại Giảm Giá
                                                        </option>
                                                        <option value="0">Giá Cố Định</option>
                                                        <option value="1">Phần Trăm</option>
                                                    </select>
                                                    @error('discount_type')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- PHẦN SELECT TYPE --}}

                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="discount_value">
                                                    {{ __('form.coupon.discount_value') }}
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-text"> $ </span>
                                                        <input type="number" name="discount_value"
                                                            formcontrolname="discount_value"
                                                            value="{{ old('discount_value') }}"
                                                            class="form-control ng-untouched ng-pristine ng-valid @error('discount_value')
                                                                is-invalid
                                                            @enderror"
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
                                                                class="ng-untouched ng-pristine ng-valid @error('is_expired')
                                                                    is-invalid
                                                                @enderror">
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
                                                            id="start_date_input" readonly=""
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
                                                            id="end_date_input" readonly=""
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
                                                            <input type="checkbox" id="status" name="is_active"
                                                                formcontrolname="status" value="1"
                                                                class="ng-untouched ng-pristine ng-valid @error('is_active')
                                                                    is-invalid
                                                                @enderror">
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

                                            {{-- PHẦN CHỌN NHIỀU DANH MỤC --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="include_category">
                                                    Bao Gồm Danh Mục
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select name="coupon_restrictions[valid_categories][]"
                                                        id="include_category"
                                                        class="form-control form-select @error('coupon_restrictions.valid_categories') is-invalid @enderror"
                                                        multiple>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                {{ in_array($category->id, old('coupon_restrictions.valid_categories', [])) ? 'selected' : '' }}>
                                                                {{ $category->name }}
                                                            </option>
                                                            @foreach ($category->categories as $child)
                                                                <option value="{{ $child->id }}"
                                                                    {{ in_array($child->id, old('coupon_restrictions.valid_categories', [])) ? 'selected' : '' }}>
                                                                    --{{ $child->name }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    @error('coupon_restrictions.valid_categories')
                                                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- PHẦN CHỌN NHIỀU DANH MỤC --}}

                                            {{-- PHẦN CHỌN NHIỀU SẢN PHẨM --}}
                                            <div class="align-items-center g-2 mb-4 row">
                                                <label class="col-sm-3 form-label-title mb-0" for="include_product">
                                                    Bao Gồm Sản Phẩm
                                                    <span class="theme-color ms-2 required-dot">*</span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select name="coupon_restrictions[valid_products][]"
                                                        id="include_product"
                                                        class="form-control form-select @error('coupon_restrictions.valid_products') is-invalid @enderror"
                                                        multiple>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ in_array($product->id, old('coupon_restrictions.valid_products', [])) ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('coupon_restrictions.valid_products')
                                                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- PHẦN CHỌN NHIỀU SẢN PHẨM --}}

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
                                                            formcontrolname="min_order_value"
                                                            class="form-control @error('min_order_value')
                                                                invalid
                                                            @enderror"
                                                            placeholder="Enter min order value">
                                                    </div>
                                                    <p class="help-text">*Xác định
                                                        giá trị đơn hàng tối thiểu cần thiết để sử dụng phiếu giảm giá.
                                                    </p>
                                                    @error('min_order_value')
                                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="align-items-center g-2 mb-4 row" id="usage-per-coupon">
                                                <label class="col-sm-3 form-label-title mb-0"
                                                    for="coupon_restrictions[max_discount_value]">
                                                    Hạn Mức Tối Đa
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" id="coupon_restrictions[max_discount_value]"
                                                        name="coupon_restrictions[max_discount_value]"
                                                        formcontrolname="coupon_restrictions[max_discount_value]"
                                                        class="form-control ng-untouched ng-pristine ng-valid @error('coupon_restrictions[max_discount_value]')
                                                            in-valid
                                                        @enderror"
                                                        placeholder="Enter value">
                                                    <p class="help-text">*Chỉ định
                                                        số tiền tối đa có thể sử dụng trong một phiếu giảm giá.</p>
                                                    @error('coupon_restrictions[max_discount_value]')
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
                                                        formcontrolname="usage_limit"
                                                        class="form-control ng-untouched ng-pristine ng-valid @error('usage_limit')
                                                            in-valid
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
                                                            <option value="{{ $key }}">
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
        });
    </script>
@endpush
