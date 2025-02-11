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
                                                <div class="col-xl-3 col-lg-3">
                                                    <ul class="nav nav-pills flex-column" role="tablist">
                                                        <li id="general" class="nav-item" role="presentation">
                                                            <a href="#general-panel" class="nav-link"
                                                                data-bs-toggle="tab" role="tab"
                                                                aria-controls="#general-panel" aria-selected="true"
                                                                aria-disabled="false">
                                                                <i class="ri-settings-line"></i>{{ __('form.general') }}</a>
                                                        </li>
                                                        <li id="inventory" class="nav-item" role="presentation">
                                                            <a href="#inventory-panel" class="nav-link active" data-bs-toggle="tab"
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
                                                                <i
                                                                    class="ri-checkbox-circle-line"></i>{{ __('form.product.is_active') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-9 col-lg-9">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade" id="general-panel"
                                                            aria-labelledby="general">
                                                            <div tab="general" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="name">
                                                                        {{ __('form.product.name') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="name" type="text"
                                                                            class="form-control"
                                                                            placeholder="{{ __('form.enter_product_name') }}"
                                                                            name="product[name]">
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.short_description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <textarea id="sort_description" rows="3" class="form-control"
                                                                            placeholder="{{ __('form.enter_short_description') }}" name="product[short_description]"></textarea>
                                                                        <p class="help-text">
                                                                            {{ __('form.help_short_description') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div id="editor"></div>
                                                                        <textarea name="product[description]" class="d-none"></textarea>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade show active" id="inventory-panel"
                                                            aria-labelledby="inventory">
                                                            <div tab="inventory" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="type">
                                                                        {{ __('form.product.type') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select id="type" name="product[type]"
                                                                            class="form-select">
                                                                            <option value="">
                                                                                {{ __('form.product_type_single') }}
                                                                            </option>
                                                                            <option value="" selected>
                                                                                {{ __('form.product_type_variant') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="sku">
                                                                        {{ __('form.product.sku') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="sku" type="text"
                                                                            class="form-control"
                                                                            placeholder="{{ __('form.enter_sku') }}"
                                                                            name="product[sku]">
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="stock">
                                                                        {{ __('form.product_stock.stock') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="stock" type="number"
                                                                            class="form-control"
                                                                            placeholder="{{ __('form.enter_product_stock') }}"
                                                                            name="product[stock]">
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="price">
                                                                        {{ __('form.product.price') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input id="price" type="number"
                                                                                class="form-control"
                                                                                placeholder="{{ __('form.enter_price') }}"
                                                                                name="product[price]">
                                                                            <span class="input-group-text">VNĐ</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="sale_price">
                                                                        {{ __('form.product.sale_price') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input id="sale_price" type="number"
                                                                                placeholder="{{ __('form.enter_sale_price') }}"
                                                                                class="form-control"
                                                                                name="product[sale_price]">
                                                                            <span class="input-group-text">VNĐ</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_sale">
                                                                        {{ __('form.product.is_sale') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_sale"
                                                                                    name="product[is_sale]">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.sale_price_start_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD" name="product[sale_price_start_at]" id="start_date_input"
                                                                                class="form-control form-date">
                                                                            <button type="button" id="startDatePickerBtn"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.sale_price_end_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD" name="product[sale_price_end_at]" id="end_date_input"
                                                                                class="form-control form-date"
                                                                            >
                                                                            <button type="button" id="startDatePickerBtn"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="variant-box border-top">
                                                                    <div id="variants-card">

                                                                        <div id="variants-section">
                                                                            <div class="variant-container">
                                                                                <div class="variant-inputs">
                                                                                    <div class="row d-none mb-3">
                                                                                        <div class="col-sm-3 variant-row">
                                                                                            <label class="form-label-title mb-0">
                                                                                                {{ __('form.attributes') }}
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-sm-3 variant-row">
                                                                                            <label class="form-label-title mb-0">
                                                                                                {{ __('form.attribute_value.value') }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    

                                                                    <button class="btn btn-theme btn-sm d-inline" id="add-attribute-btn" type="button">
                                                                        <div>{{ __('message.add') . ' ' . __('form.attributes') }}</div>
                                                                    </button>
                                                                    <button class="btn btn-warning btn-sm ms-2 d-inline" id="genarate-variant-btn" type="button">
                                                                        <div>{{ __('message.create') . ' ' . __('form.product_variants') }}</div>
                                                                    </button>
                                                                    <button class="btn btn-danger btn-sm ms-2 d-inline d-none" id="remove-all-variant-btn" type="button">
                                                                        <div>{{ __('message.delete_all') }}</div>
                                                                    </button>

                                                                    <div class="table-responsive datatable-wrapper border-table mt-4">
                                                                        <table class="table all-package theme-table no-footer">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="sm-width">{{ __('form.product_variant.thumbnail') }}</th>
                                                                                    <th>{{ __('form.product_variants') }}</th>
                                                                                    <th>{{ __('form.product_variant.sku') }}</th>
                                                                                    <th>{{ __('form.product_variant.price') }}</th>
                                                                                    <th>{{ __('form.product_variant.sale_price') }}</th>
                                                                                    <th>{{ __('form.product_stock.stock') }}</th>
                                                                                    <th>{{ __('form.product_variant.is_active') }}</th>
                                                                                    <th>{{ __('form.action') }}</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="sm-width">
                                                                                        <label for="file-input" class="cursor-pointer">
                                                                                            <img alt="image" class="tbl-image icon-image" src="{{ asset('/theme/admin/assets/images/categories/mobile_phone.svg') }}">
                                                                                        </label>
                                                                                        <input id="file-input" type="file" style="display: none;" name="product_variant[thumbnail]"/>
                                                                                    </td>
    
                                                                                    <td>
                                                                                        <div>
                                                                                            Màu đen, 586GB Màu đen, 586GB Màu đen, 586GB
                                                                                        </div>
                                                                                    </td>
                                        
                                                                                    <td>
                                                                                        <input type="text" name="product_variant[sku]" class="form-control">
                                                                                    </td>
    
                                                                                    <td>
                                                                                        <input type="number" name="product_variant[price]" class="form-control">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="product_variant[sale_price]" class="form-control">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="product_variant[stock]" class="form-control">
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="form-check form-switch ps-0">
                                                                                            <label class="switch">
                                                                                                <input type="checkbox" id="is_active" name="product_variant[is_active]">
                                                                                                <span class="switch-state"></span>
                                                                                            </label>
                                                                                        </div>
                                                                                    </td>
                                        
                                        
                                                                                    <td>
                                                                                        <ul id="actions">
                                                                                            <li>
                                                                                                <a href="" class="btn-delete">
                                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="setup-panel"
                                                            aria-labelledby="setup">
                                                            <div tab="setup" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="tags">
                                                                        {{ __('form.tags') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="tags" class="form-select select2"
                                                                                multiple name="tags[]"
                                                                            >
                                                                                <option value="">Product</option>
                                                                                <option value="">Phone 2025</option>
                                                                                <option value="">TV & Appliances
                                                                                </option>
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
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="categories">
                                                                        {{ __('form.categories') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="categories" class="form-select select2"
                                                                                multiple name="categories[]"
                                                                            >
                                                                                <option data-type="parent"
                                                                                    value="1"disabled>Electronics
                                                                                </option>
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
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="product_accessories">
                                                                        {{ __('form.product_accessories') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="product_accessories" class="form-select select2"
                                                                                multiple name="product_accessories[]"
                                                                            >
                                                                                <option value="1">iPhone 16 Pro 128GB | Chính hãng VN/A</option>
                                                                                <option value="1">iPhone 17 Pro 128GB | Chính hãng VN/A</option>
                                                                                <option value="1">iPhone 18 Pro 128GB | Chính hãng VN/A</option>
                                                                            </select>
                                                                            <p class="help-text">
                                                                                {{ __('form.help_product_accessories') }}
                                                                            </p>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="images-panel"
                                                            aria-labelledby="images">
                                                            <div tab="images" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="thumbnail">
                                                                        {{ __('form.product.thumbnail') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="product[thumbnail]"
                                                                            id="thumbnail" class="form-control">
                                                                        <p class="help-text">
                                                                            {{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="product_galleries">
                                                                        {{ __('form.product_galleries') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="product_galleries[]"
                                                                            id="product_galleries" class="form-control"
                                                                            multiple>
                                                                        <p class="help-text">
                                                                            {{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="status-panel"
                                                            aria-labelledby="status">
                                                            <div tab="status" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_featured">
                                                                        {{ __('form.product.is_featured') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_featured"
                                                                                    name="product[is_featured]">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">
                                                                                {{ __('form.help_is_featured') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_trending">
                                                                        {{ __('form.product.is_trending') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_trending"
                                                                                    name="product[is_trending]">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">
                                                                                {{ __('form.help_is_trending') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_active">
                                                                        {{ __('form.product.is_active') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_active"
                                                                                    name="product[is_active]">
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
                                                <div>{{ __('message.add_new') }}</div>
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

            $('#start-date-div, #end-date-div').hide();
            $(".form-date").flatpickr({
                dateFormat: "Y-m-d"
            });
            
            $(".start_date_input").click(function() {
                $("#start_date_input").open();
            });
            $(".end_date_input").click(function() {
                $("#end_date_input").open();
            });

            // VARIANT
            const attributeData = {
                Liter: ['5 Liter', '10 Liter', '20 Liter'],
                Waist: ['30', '32', '34'],
                Size: ['S', 'M', 'L', 'XL'],
            };

            // Populate attributes dropdown
            function populateAttributes(selectElement) {
                selectElement.empty();
                for (const attribute in attributeData) {
                    selectElement.append(`<option value="${attribute}">${attribute}</option>`);
                }
            }

            // Populate values dropdown based on selected attribute
            function populateValues(selectElement, attribute) {
                selectElement.empty();
                if (attribute && attributeData[attribute]) {
                    attributeData[attribute].forEach(value => {
                        selectElement.append(`<option value="${value}">${value}</option>`);
                    });
                }
            }

             // On attribute change, update values
            $('.attribute-select').on('change', function() {
                const attribute = $(this).val();
                const valueSelect = $(this).closest('.variant-inputs').find('.value-select');
                populateValues(valueSelect, attribute);
            });
            
            $('#add-attribute-btn').on('click', function(e) {
                e.preventDefault();
                const variantContent = `
                    <div class="row attribute-content mb-3">
                        <div class="col-sm-3 variant-row">
                            <select name="attributes" class="form-select select2 attribute-select"></select>
                        </div>
                        <div class="col-sm-3 variant-row">
                            <select name="attributes" class="form-select select2 value-select" multiple></select>
                        </div>
                        <div class="col-sm-2 variant-row">
                            <a href="javascript:void(0)" class="invalid-feedback remove-variant">
                                {{ __('message.delete') }}
                            </a>
                        </div>
                    </div>
                `;

                
                $('.variant-inputs').append(variantContent);
                
                const newAttributeSelect = $('.variant-inputs .attribute-content:last-child .attribute-select');
                const newValueSelect = $('.variant-inputs .attribute-content:last-child .value-select');
                const removeVariant = $('.variant-inputs .attribute-content:last-child .remove-variant');
                const removeAllVariant = $('#remove-all-variant-btn');
                
                newAttributeSelect.select2();
                newValueSelect.select2();
                
                // Show something
                if ($('.variant-inputs').children().length > 1) {

                    // Show btn remove all variant
                    if (removeAllVariant.hasClass('d-none')) {
                        removeAllVariant.removeClass('d-none');
                    }

                }
                

                populateAttributes(newAttributeSelect);
                populateValues(newValueSelect, newAttributeSelect.val());

                newAttributeSelect.on('change', function() {
                    const attribute = $(this).val();
                    populateValues(newValueSelect, attribute);
                });
                
                
                if ($('#variant-inputs').children().first().hasClass('d-none')) {
                    titleAttributeValue.removeClass('d-none');
                }

                $(removeVariant).on('click', function() {
                    $(this).closest('.attribute-content').remove();

                    // Hide something
                    if ($('.variant-inputs').children().length <= 1) {

                        if (!removeAllVariant.hasClass('d-none')) {
                            removeAllVariant.addClass('d-none');
                        }

                        // Hide btn remove all variant
                        $('#variant-inputs').children().first().addClass('d-none');
                    }
                });
                

            });

            $('#remove-all-variant-btn').on('click', function() {
                $('.attribute-content').remove();
                $(this).addClass('d-none');
            });

            $('#genarate-variant-btn').on('click', function() {
                $('.attribute-select').each(function(index) {
                    console.log($(this).val(), $($('.value-select')[index]).val());
                })
            });


        });
    </script>
@endpush
