@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/select2.min.css') }}">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="container-fuild">
        <div class="row m-0">

            <div class="col-xl-12 p-0">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header">
                                        <div class="d-flex align-items-center">
                                            <h5>
                                                <a href="{{ route('admin.products.index') }}"
                                                    class="link">{{ __('form.products') }}</a>
                                                <span class="fs-6 fw-light">></span> {{ __('message.add_new') }}
                                            </h5>
                                        </div>
                                    </div>
                                    <form novalidate class="theme-form theme-form-2 mega-form   ">
                                        <div class="vertical-tabs">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-4">
                                                    <ul class="nav nav-pills flex-column" role="tablist">
                                                        <li id="general" class="nav-item" role="presentation">
                                                            <a href="#general-panel" class="nav-link active"
                                                                data-bs-toggle="tab" role="tab"
                                                                aria-controls="#general-panel" aria-selected="true"
                                                                aria-disabled="false">
                                                                <i class="ri-settings-line"></i>{{ __('form.general') }}</a>
                                                        </li>
                                                        <li id="inventory" class="nav-item" role="presentation">
                                                            <a href="#inventory-panel" class="nav-link" data-bs-toggle="tab"
                                                                role="tab" aria-controls="#inventory-panel"
                                                                aria-selected="true" aria-disabled="false">
                                                                <i
                                                                    class="ri-file-list-line"></i>{{ __('form.inventory') }}</a>
                                                        </li>
                                                        <li id="setup" class="nav-item" role="presentation">
                                                            <a href="#setup-panel" class="nav-link" data-bs-toggle="tab"
                                                                role="tab" aria-controls="#setup-panel"
                                                                aria-selected="true" aria-disabled="false">
                                                                <i class="ri-tools-line"></i>{{ __('form.setup') }}</a>
                                                        </li>
                                                        <li id="images" class="nav-item" role="presentation">
                                                            <a href="#images-panel" class="nav-link" data-bs-toggle="tab"
                                                                role="tab" aria-controls="#images-panel"
                                                                aria-selected="true" aria-disabled="false">
                                                                <i class="ri-image-line"></i>{{ __('form.images') }}</a>
                                                        </li>
                                                        <li id="status" class="nav-item" role="presentation">
                                                            <a href="#status-panel" class="nav-link" data-bs-toggle="tab"
                                                                role="tab" aria-controls="#status-panel"
                                                                aria-selected="true" aria-disabled="false">
                                                                <i class="ri-checkbox-circle-line"></i>{{ __('form.product.is_active') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-7 col-lg-8">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="general-panel" aria-labelledby="general">
                                                            <div tab="general" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="name">
                                                                        {{ __('form.product.name') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="name" type="text" class="form-control" placeholder="{{ __('form.enter_product_name') }}" name="name">
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="short_description">
                                                                        {{ __('form.product.short_description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <textarea id="sort_description" rows="3" class="form-control" placeholder="{{ __('form.enter_short_description') }}" name="short_description"></textarea>
                                                                        <p class="help-text">{{ __('form.help_short_description') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="description">
                                                                        {{ __('form.product.description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div id="editor"></div>
                                                                        <textarea name="description" class="d-none"></textarea>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="inventory-panel" aria-labelledby="inventory">
                                                            <div tab="inventory" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="type">
                                                                        {{ __('form.product.type') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select id="type" name="type" class="form-select">
                                                                            <option value="">{{ __('form.product_type_single') }}</option>
                                                                            <option value="">{{ __('form.product_type_variant') }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sku">
                                                                        {{ __('form.product.sku') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="sku" type="text" class="form-control" placeholder="{{ __('form.enter_sku') }}" name="sku">
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="product_stock">
                                                                        {{ __('form.product_stock.stock') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input
                                                                            id="product_stock"
                                                                            type="number"
                                                                            class="form-control"
                                                                            placeholder="{{ __('form.enter_product_stock') }}"
                                                                            name="product_stock"
                                                                        >
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="price">
                                                                        {{ __('form.product.price') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input
                                                                                id="price"
                                                                                type="number"
                                                                                class="form-control"
                                                                                placeholder="{{ __('form.enter_price') }}"
                                                                                name="price"
                                                                            >
                                                                            <span class="input-group-text">VNĐ</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sale_price"> 
                                                                        {{ __('form.product.sale_price') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input
                                                                                id="sale_price"
                                                                                type="number"
                                                                                placeholder="{{ __('form.enter_sale_price') }}"
                                                                                class="form-control"
                                                                                name="sale_price"
                                                                            >
                                                                            <span class="input-group-text">VNĐ</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row d-none">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_sale">
                                                                        {{ __('form.product.is_sale') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_sale">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sale_price_start_at">
                                                                        {{ __('form.product.sale_price_start_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD" name="sale_price_start_at" id="start_date_input" class="form-control form-date">
                                                                            <button type="button" id="startDatePickerBtn"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sale_price_end_at">
                                                                        {{ __('form.product.sale_price_end_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD" name="sale_price_end_at" id="start_date_input" class="form-control form-date">
                                                                            <button type="button" id="startDatePickerBtn"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="setup-panel" aria-labelledby="setup">
                                                            <div tab="setup" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="tags">
                                                                        {{ __('form.tags') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="tags" class="select2 form-select" multiple name="tags[]">
                                                                                <option value="">Product</option>
                                                                                <option value="">Phone 2025</option>
                                                                                <option value="">TV & Appliances</option>
                                                                                <option value="">Home & Furniture</option>
                                                                                <option value="">Another</option>
                                                                                <option value="">Baby & Kids</option>
                                                                                <option value="">Health, Beauty & Perfumes</option>
                                                                                <option value="">Uncategorized</option>
                                                                            </select>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="categories">
                                                                        {{ __('form.categories') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="categories" class="select2 form-select" multiple name="categories[]">
                                                                                <option data-type="parent" value="1"disabled>Electronics</option>
                                                                                <option data-type="child" value="1">TV & Appliances</option>
                                                                                <option data-type="child" value="1">Home & Furniture</option>
                                                                                <option data-type="child" value="1">Another</option>
                                                                                <option data-type="parent" value="1">Baby & Kids</option>
                                                                                <option data-type="parent" value="1">Health, Beauty & Perfumes</option>
                                                                                <option data-type="parent" value="1">Uncategorized</option>
                                                                            </select>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="product_accessories[]">
                                                                        {{ __('form.product_accessories') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="product_accessories" class="select2 form-select" multiple name="product_accessories[]">
                                                                                <option value="1">iPhone 16 Pro 128GB | Chính hãng VN/A</option>
                                                                                <option value="1">iPhone 17 Pro 128GB | Chính hãng VN/A</option>
                                                                                <option value="1">iPhone 18 Pro 128GB | Chính hãng VN/A</option>
                                                                            </select>
                                                                            <p class="help-text">{{ __('form.help_product_accessories') }}</p>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="images-panel" aria-labelledby="images">
                                                            <div tab="images" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="thumbnail">
                                                                        {{ __('form.product.thumbnail') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                                                                        <p class="help-text">{{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="product_galleries">
                                                                        {{ __('form.product_galleries') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="product_galleries" id="product_galleries" class="form-control">
                                                                        <p class="help-text">{{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="status-panel" aria-labelledby="status">
                                                            <div tab="status" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_featured">
                                                                        {{ __('form.product.is_featured') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_featured" name="is_featured">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">{{ __('form.help_is_featured') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_trending">
                                                                        {{ __('form.product.is_trending') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_trending" name="is_trending">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">{{ __('form.help_is_trending') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_active">
                                                                        {{ __('form.product.is_active') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_active" name="is_active">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-theme ms-auto mt-4" id="product_btn" type="submit">
                                                <div> Save Product </div>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
    <!-- ck editor js -->
    <script src="{{ asset('theme/admin/assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/ckeditor-custom.js') }}"></script>

    <!-- select2 js -->
    <script src="{{ asset('theme/admin/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/select2-custom.js') }}"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            // Mặc định ẩn Start Date và End Date khi checkbox chưa được tick
            $('#start-date-div, #end-date-div').hide(); // Ẩn các trường ngày khi trang tải

            // Khởi tạo Flatpickr cho các trường input
            $(".form-date").flatpickr({
                dateFormat: "Y-m-d"
            });

            // Khi nhấn vào nút calendar bên cạnh input #start_date
            $(".form-date").click(function() {
                $("#start_date_input").open(); // Mở bảng lịch cho start_date
            });
        });
    </script>
@endpush
