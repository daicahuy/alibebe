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
    <style>
        .ck-editor__editable {
            resize: vertical;
            overflow: auto;
        }
    </style>
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
                                    <form
                                        action="{{ route('admin.products.store') }}"
                                        novalidate
                                        class="theme-form theme-form-2 mega-form"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        id="form-create-product"
                                    >
                                        @csrf
                                        <div class="vertical-tabs">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-3">
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
                                                                    class="ri-file-list-line"></i>{{ __('message.detail') }}</a>
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
                                                        <div class="tab-pane fade show active" id="general-panel"
                                                            aria-labelledby="general">
                                                            <div tab="general" class="tab">
                                                                <div class="form-group align-items-center g-2 mb-4 row">
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

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.short_description') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <textarea id="short_description" rows="3" class="form-control"
                                                                            placeholder="{{ __('form.enter_short_description') }}" name="product[short_description]"></textarea>
                                                                        <p class="help-text">{{ __('form.help_short_description') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.description') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div id="editor"></div>
                                                                        <textarea name="product[description]" class="d-none"></textarea>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.attribute_specifications') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <div class="specifications-inputs">
                                                                                
                                                                            </div>
            
                                                                            <button class="btn btn-theme btn-sm d-inline"
                                                                                id="add-specifications-btn" type="button">
                                                                                <div>
                                                                                    {{ __('message.add') . ' ' . __('form.attribute_specifications') }}
                                                                                </div>
                                                                            </button>
                                                                            <button
                                                                                class="btn btn-danger btn-sm ms-2 d-inline d-none"
                                                                                id="remove-all-specifications-btn" type="button">
                                                                                <div>{{ __('message.delete_all') }}</div>
                                                                            </button>
                                                                            <input type="hidden" name="product_specifications" disabled>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="inventory-panel"
                                                            aria-labelledby="inventory">
                                                            <div tab="inventory" class="tab">
                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="type">
                                                                        {{ __('form.product.type') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select id="type" name="product[type]"
                                                                            class="form-select">
                                                                            <option
                                                                                value="{{ ProductType::SINGLE }}">
                                                                                {{ __('form.product_type_single') }}
                                                                            </option>
                                                                            <option
                                                                                value="{{ ProductType::VARIANT }}">
                                                                                {{ __('form.product_type_variant') }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
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
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="stock-box form-group align-items-center g-2 mb-4 row">
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
                                                                            name="product_stocks[stock]">
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="price-box form-group align-items-center g-2 mb-4 row">
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
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="sale_price-box form-group align-items-center g-2 mb-4 row">
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
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_sale">
                                                                        {{ __('form.product.is_sale') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_sale"
                                                                                    name="product[is_sale]" value="1">
                                                                                <span class="switch-state"></span>
                                                                                
                                                                            </label>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.sale_price_start_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD"
                                                                                name="product[sale_price_start_at]"
                                                                                id="start_date_input"
                                                                                class="form-control form-date">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0">
                                                                        {{ __('form.product.sale_price_end_at') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group custom-dt-picker">
                                                                            <input placeholder="YYY-MM-DD"
                                                                                name="product[sale_price_end_at]"
                                                                                id="end_date_input"
                                                                                class="form-control form-date">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group variant-box border-top d-none">
                                                                    <div id="variants-card">

                                                                        <div id="variants-section">
                                                                            <div class="variant-container">
                                                                                <div class="variant-inputs">
                                                                                    <div class="row d-none mb-3">
                                                                                        <div class="col-sm-3 variant-row">
                                                                                            <label
                                                                                                class="form-label-title mb-0">
                                                                                                {{ __('form.attributes') }}
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-sm-3 variant-row">
                                                                                            <label
                                                                                                class="form-label-title mb-0">
                                                                                                {{ __('form.attribute_value.value') }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <button class="btn btn-theme btn-sm d-inline"
                                                                        id="add-attribute-btn" type="button">
                                                                        <div>
                                                                            {{ __('message.add') . ' ' . __('form.attributes') }}
                                                                        </div>
                                                                    </button>
                                                                    <button class="btn btn-warning-gradien btn-sm ms-2 d-inline"
                                                                        id="genarate-variant-btn" type="button">
                                                                        <div>
                                                                            {{ __('message.create') . ' ' . __('form.product_variants') }}
                                                                        </div>
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-danger btn-sm ms-2 d-inline d-none"
                                                                        id="remove-all-variant-btn" type="button">
                                                                        <div>{{ __('message.delete_all') }}</div>
                                                                    </button>
                                                                    <input type="hidden" name="product_variants" disabled>
                                                                    <div class="invalid-feedback"></div>

                                                                    <div class="table-responsive datatable-wrapper border-table mt-4 d-none"
                                                                        id="table-variants">
                                                                        <table
                                                                            class="table all-package theme-table no-footer">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="sm-width">
                                                                                        {{ __('form.product_variant.thumbnail') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_variants') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_variant.sku') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_variant.price') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_variant.sale_price') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_stock.stock') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.product_variant.is_active') }}
                                                                                    </th>
                                                                                    <th>{{ __('form.action') }}</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="setup-panel"
                                                            aria-labelledby="setup">
                                                            <div tab="setup" class="tab">
                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="tags">
                                                                        {{ __('form.tags') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="tags" class="form-select select2" multiple name="tags[]">
                                                                                @foreach ($tags as $tag)
                                                                                    <option value="{{ $tag->id }}">
                                                                                        {{ $tag->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="tags">
                                                                        {{ __('form.brands') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="brand" class="form-select select2" name="product[brand_id]">
                                                                                @foreach ($brands as $brand)
                                                                                    <option value="{{ $brand->id }}">
                                                                                        {{ $brand->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="categories">
                                                                        {{ __('form.categories') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="categories" class="form-select select2" name="category_id">
                                                                                @foreach ($categories as $category)
                                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <div class="invalid-feedback"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="product_accessories">
                                                                        {{ __('form.product_accessories') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select id="product_accessories"
                                                                                class="form-select select2" multiple
                                                                                name="product_accessories[]">
                                                                                @foreach ($productAccessories as $productAccessory)
                                                                                    <option value="{{ $productAccessory->id }}">{{ $productAccessory->name }}</option>
                                                                                @endforeach
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
                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="thumbnail">
                                                                        {{ __('form.product.thumbnail') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="product[thumbnail]" id="thumbnail" class="form-control">
                                                                        <p class="help-text">{{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="product_galleries">
                                                                        {{ __('form.product_galleries') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input type="file" name="product_galleries[]" id="product_galleries" class="form-control" multiple>
                                                                        <input type="hidden" name="product_galleries" disabled>
                                                                        <p class="help-text">{{ __('form.help_thubnail') }}</p>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="status-panel"
                                                            aria-labelledby="status">
                                                            <div tab="status" class="tab">
                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_featured">
                                                                        {{ __('form.product.is_featured') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_featured"
                                                                                    name="product[is_featured]" value="1">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">
                                                                                {{ __('form.help_is_featured') }}</p>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_trending">
                                                                        {{ __('form.product.is_trending') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_trending"
                                                                                    name="product[is_trending]" value="1">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                            <p class="help-text">{{ __('form.help_is_trending') }}</p>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="is_active">
                                                                        {{ __('form.product.is_active') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch">
                                                                                <input type="checkbox" id="is_active"
                                                                                    name="product[is_active]" value="1">
                                                                                <span class="switch-state"></span>
                                                                            </label>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success ms-auto mt-4" type="submit">
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
            
            $(".form-date").flatpickr({
                dateFormat: "Y-m-d"
            });

            $(".start_date_input").click(function() {
                $("#start_date_input").open();
            });
            $(".end_date_input").click(function() {
                $("#end_date_input").open();
            });

            $('.ck-editor__editable').on('input', function() {
                $('textarea[name="product[description]"]').html($('.ck-editor__editable').html());
            })

            $('form').on('change', 'input, select, textarea', function () {
                console.log($(this));
                $(this).removeClass('is-invalid');
                $(this).closest('.form-group').find('.invalid-feedback').text('');
            });

            // SPECIFICATIONS
            // specificationsData = {
            //     Liter: ['5 Liter', '10 Liter', '20 Liter'],
            //     Waist: ['30', '32', '34'],
            //     Size: ['S', 'M', 'L', 'XL'],
            // }
            const specificationsData = JSON.parse({!! json_encode($attributeSpecifications, JSON_UNESCAPED_UNICODE) !!});
    
            // Populate attributes dropdown
            function populateSpecifications(selectElement) {
                selectElement.empty();
                for (const specifications in specificationsData) {
                    selectElement.append(`<option value="${specifications}">${specifications}</option>`);
                }
            }

            // Populate values dropdown based on selected specifications
            function populateSpecificationsValues(selectElement, specifications) {
                selectElement.empty();
                if (specifications && specificationsData[specifications]) {
                    Object.entries(specificationsData[specifications]).forEach(value => {
                        selectElement.append(`<option value="${value[0]}">${value[1]}</option>`);
                    });
                }
            }

            // On attribute change, update values
            $('.specifications-select').on('change', function() {
                const attributeSpecifications = $(this).val();
                const valueSpecifiactionSelect = $(this).closest('.specifications-inputs').find('.value-specifications-select');
                populateSpecificationsValues(valueSpecifiactionSelect, attributeSpecifications);
            });


            // VARIANT
            // attributeData = {
            //     Liter: ['5 Liter', '10 Liter', '20 Liter'],
            //     Waist: ['30', '32', '34'],
            //     Size: ['S', 'M', 'L', 'XL'],
            // }
            const attributeData = JSON.parse({!! json_encode($attributeVariants, JSON_UNESCAPED_UNICODE) !!});
            const attributeDataFlattened = {};
            for (const key in attributeData) {  
                Object.assign(attributeDataFlattened, attributeData[key]);  
            }

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
                    Object.entries(attributeData[attribute]).forEach(value => {
                        selectElement.append(`<option value="${value[0]}">${value[1]}</option>`);
                    });
                }
            }

            // On attribute change, update values
            $('.attribute-select').on('change', function() {
                const attribute = $(this).val();
                const valueSelect = $(this).closest('.variant-inputs').find('.value-select');
                populateValues(valueSelect, attribute);
            });

            // Combinations Product
            function cartesianProduct(arrays) {
                return arrays.reduce((acc, curr) => {
                    return acc.flatMap(a => curr.map(b => `${a},${b}`));
                });
            }

            $('#type').on('change', function() {
                switch ($(this).val()) {
                    case '0': {
                        $(".invalid-feedback").text("");
                        $(".is-invalid").removeClass("is-invalid");

                        if (!$('.variant-box').hasClass('d-none')) {
                            $('.variant-box').addClass('d-none');
                            $('.variant-box').find('*').prop('disabled', true);
                        }

                        if ($('.stock-box').hasClass('d-none')) {
                            $('.stock-box').removeClass('d-none');
                            $('.stock-box').find('*').removeAttr('disabled');
                        }

                        if ($('.price-box').hasClass('d-none')) {
                            $('.price-box').removeClass('d-none');
                            $('.price-box').find('*').removeAttr('disabled');
                        }

                        if ($('.sale_price-box').hasClass('d-none')) {
                            $('.sale_price-box').removeClass('d-none');
                            $('.sale_price-box').find('*').removeAttr('disabled');
                        }

                        break;
                    }
                    case '1': {
                        $(".invalid-feedback").text("");
                        $(".is-invalid").removeClass("is-invalid");

                        if ($('.variant-box').hasClass('d-none')) {
                            $('.variant-box').removeClass('d-none');
                            $('.variant-box').find('*').removeAttr('disabled');
                        }

                        if (!$('.stock-box').hasClass('d-none')) {
                            $('.stock-box').addClass('d-none');
                            $('.stock-box').find('*').prop('disabled', true);
                        }

                        if (!$('.price-box').hasClass('d-none')) {
                            $('.price-box').addClass('d-none');
                            $('.price-box').find('*').prop('disabled', true);
                        }

                        if (!$('.sale_price-box').hasClass('d-none')) {
                            $('.sale_price-box').addClass('d-none');
                            $('.sale_price-box').find('*').prop('disabled', true);
                        }

                        break;
                    }
                }
            })

            // Handle Add Specification
            $('#add-specifications-btn').on('click', function(e) {
                e.preventDefault();

                $(this).parent().find("[name=product_specifications]").next('.invalid-feedback').text('');

                const specificationsContent = `
                    <div class="row specifications-content mb-3">
                        <div class="col-sm-3 specifications-row">
                            <select class="form-select select2 specifications-select"></select>
                        </div>
                        <div class="col-sm-3 specifications-row">
                            <select class="form-select select2 value-specifications-select" name="product_specifications[]"></select>
                        </div>
                        <div class="col-sm-2 specifications-row">
                            <a href="javascript:void(0)" class="remove-specifications" style="display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.5rem;">
                                {{ __('message.delete') }}
                            </a>
                        </div>
                    </div>
                `;

                $('.specifications-inputs').append(specificationsContent);

                const newSpecificationsSelect = $('.specifications-inputs .specifications-content:last-child .specifications-select');
                const newValueSelect = $('.specifications-inputs .specifications-content:last-child .value-specifications-select');
                const removeSpecifications = $('.specifications-inputs .specifications-content:last-child .remove-specifications');
                const removeAllSpecifications = $('#remove-all-specifications-btn');

                newSpecificationsSelect.select2();
                newValueSelect.select2();

                // Show something
                if ($('.specifications-inputs').children().length > 1) {

                    // Show btn remove all specifications
                    if (removeAllSpecifications.hasClass('d-none')) {
                        removeAllSpecifications.removeClass('d-none');
                    }

                }


                populateSpecifications(newSpecificationsSelect);
                populateSpecificationsValues(newValueSelect, newSpecificationsSelect.val());

                newSpecificationsSelect.on('change', function() {
                    const specifications = $(this).val();
                    populateSpecificationsValues(newValueSelect, specifications);
                });

                $(removeSpecifications).on('click', function() {
                    $(this).closest('.specifications-content').remove();

                    // Hide something
                    if ($('.specifications-inputs').children().length <= 1) {

                        if (!removeAllSpecifications.hasClass('d-none')) {
                            removeAllSpecifications.addClass('d-none');
                        }

                    }
                });

            })

            // Remove All Specifications
            $('#remove-all-specifications-btn').on('click', function() {
                $('.specifications-content').remove();
                $(this).addClass('d-none');
            });


            // Handle Add Attribute
            $('#add-attribute-btn').on('click', function(e) {
                e.preventDefault();
                const variantContent = `
                    <div class="row attribute-content mb-3">
                        <div class="col-sm-3 variant-row">
                            <select class="form-select select2 attribute-select"></select>
                        </div>
                        <div class="col-sm-3 variant-row">
                            <select class="form-select select2 value-select" multiple></select>
                        </div>
                        <div class="col-sm-2 variant-row">
                            <a href="javascript:void(0)" class="remove-variant" style="display: block; color: #dc3545; font-size: 0.875em; margin-top: 0.5rem;">
                                {{ __('message.delete') }}
                            </a>
                        </div>
                    </div>
                `;


                $('.variant-inputs').append(variantContent);

                const newAttributeSelect = $(
                    '.variant-inputs .attribute-content:last-child .attribute-select');
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

                $(removeVariant).on('click', function() {
                    $(this).closest('.attribute-content').remove();

                    // Hide something
                    if ($('.variant-inputs').children().length <= 2) {

                        if (!removeAllVariant.hasClass('d-none')) {
                            removeAllVariant.addClass('d-none');
                        }

                        // Hide btn remove all variant
                        $('.variant-inputs').children().first().addClass('d-none');
                    }
                });


            });

            // Remove All Variant
            $('#remove-all-variant-btn').on('click', function() {
                $('.attribute-content').remove();
                $(this).addClass('d-none');
            });

            // Handle Genarate Variant
            $('#genarate-variant-btn').on('click', function() {
                let data = [];

                $('.attribute-select').each(function(index) {
                    data.push($($('.value-select')[index]).val());
                })

                if (data.length !== 0) {
                    console.log(data);
                    let combinations = cartesianProduct(data);
                    console.log(combinations);
                    const variantElements = combinations.map((combination, index) => {
                        let combinationName = '';
                        const variant = combination.split(',').map((attributeValueId) => {
                            combinationName += attributeDataFlattened[attributeValueId] + ' | ';
                            return `<input type="hidden" value="${attributeValueId}" name="product_variants[${index}][variant][]" />`
                        })

                        return `
                            <tr class="variant">
                                <td class="sm-width form-group">
                                    <label for="file-input${index}" class="cursor-pointer">
                                        <img alt="image" class="tbl-image icon-image" src="{{ asset('/theme/admin/assets/images/no-image.png') }}">
                                    </label>
                                    <input id="file-input${index}" type="file" style="display: none;" name="product_variants[${index}][info][thumbnail]"/>
                                    <div class="invalid-feedback"></div>
                                </td>

                                <td class="form-group">
                                    <div>
                                        ${combinationName.slice(0, -3)}
                                        ${variant.join('')}
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </td>

                                <td class="form-group">
                                    <input type="text" name="product_variants[${index}][info][sku]" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </td>

                                <td class="form-group">
                                    <input type="number" name="product_variants[${index}][info][price]" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </td>
                                <td class="form-group">
                                    <input type="number" name="product_variants[${index}][info][sale_price]" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </td>
                                <td class="form-group">
                                    <input type="number" name="product_variants[${index}][product_stocks][stock]" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </td>
                                <td class="form-group">
                                    <div class="form-check form-switch ps-0">
                                        <label class="switch">
                                            <input type="checkbox" id="is_active" name="product_variants[${index}][info][is_active]" value="1">
                                            <span class="switch-state"></span>
                                        </label>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </td>


                                <td>
                                    <ul id="actions">
                                        <li>
                                            <a href="#!" class="btn-delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `;
                    }).join('');

                    $('#table-variants').removeClass('d-none');

                    $('#table-variants tbody').html(variantElements);

                    $('.btn-delete').on('click', function() {
                        $(this).closest('.variant').remove();
                    });

                } else {
                    $('#table-variants tbody').html('');
                    $('#table-variants').addClass('d-none');
                }


            });
            
            // HANDLE CREATE PRODUCT
            $('#form-create-product').on('submit', function(e) {
                e.preventDefault();

                const data = new FormData($("#form-create-product")[0]);
                let url = "";

                if ($('#type').val() == 0) {
                    url = "{{ route('api.products.storeSingle') }}";
                } else if ($('#type').val() == 1) {
                    url = "{{ route('api.products.storeVariant') }}";
                }

                $.ajax({
                    url,
                    type: "POST",
                    data,
                    processData: false,
                    contentType: false,
                    success: function (response) {

                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            draggable: true
                        });

                        setTimeout(() => {
                            window.location.href = "{{ route('admin.products.index') }}"; 
                        }, 1500);

                    },
                    error: function (jqXHR) {
                        if (jqXHR.status !== 422) {
                            Swal.fire({
                                icon: "error",
                                title: jqXHR.responseJSON.message,
                            });
                            return
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Đã xảy ra một số lỗi",
                            text: "Vui lòng kiểm tra lại thông tin !",
                        });

                        const errors = jqXHR.responseJSON.errors;
                        console.log(errors);
                        
                        $(".invalid-feedback").text("");
                        $(".is-invalid").removeClass("is-invalid");

                        // Lặp qua danh sách lỗi
                        $.each(errors, function (key, message) {
                            const parts = key.split('.');

                            if (parts[0] === "product_variants") {
                                key = parts.reduce((accumulator, currentItem) => `${accumulator}[${currentItem}]`);
                            } else if (parts.length >= 2) {
                                key = parts.reduce((accumulator, currentItem) => !isNaN(currentItem) ? `${accumulator}[]` : `${accumulator}[${currentItem}]`)
                                // key = `${parts[0]}[${parts[1]}]`; 
                            }

                            console.log(key);
                            
                            let inputField = $(`[name="${key}"]`);

                            if (inputField.length > 0) {
                                inputField.addClass("is-invalid");
                                inputField.closest('.form-group').find(".invalid-feedback").html(message);
                            }
                        });
                        

                    }
                });
            })

        });
    </script>
@endpush
