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
                                                <span class="fs-6 fw-light">></span> {{ __('message.detail') }}
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
                                                                            class="form-control disabled"
                                                                            placeholder="{{ __('form.enter_product_name') }}"
                                                                            name="product[name]"
                                                                            value="{{ $product->name }}"
                                                                            disabled
                                                                        >
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
                                                                        <textarea id="short_description" rows="3" class="form-control disabled"
                                                                            placeholder="{{ __('form.enter_short_description') }}" name="product[short_description]" disabled>{{ $product->short_description }}</textarea>
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
                                                                        <textarea name="product[description]" class="d-none">{{ $product->description }}</textarea>
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
                                                                            {{-- @dd($product); --}}
                                                                            <div class="specifications-inputs">
                                                                                @foreach ($product->attributeValues as $attributeValue)
                                                                                    <div class="row specifications-content mb-3">
                                                                                        <div class="col-sm-3 specifications-row">
                                                                                            <select class="form-select select2 specifications-select disabled" disabled>
                                                                                                @foreach (json_decode($attributeSpecifications, true) as $specificationName => $specification)
                                                                                                    <option value="{{ $specificationName }}" {{ $specificationName === $attributeValue->attribute->name ? 'selected' : '' }}>{{ $specificationName }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-sm-3 specifications-row">
                                                                                            <select class="form-select select2 value-specifications-select disabled" name="product_specifications[]" disabled>
                                                                                                @foreach (json_decode($attributeSpecifications, true)[$attributeValue->attribute->name] as $specificationId => $specificationValue)
                                                                                                    <option value="{{ $specificationId }}" {{ $specificationId == $attributeValue->id ? 'selected' : '' }}>{{ $specificationValue }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
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
                                                                            class="form-select disabled" disabled>
                                                                            <option
                                                                                value="{{ ProductType::SINGLE }}" {{ $product->isSingle() ? 'selected' : ''}}>
                                                                                {{ __('form.product_type_single') }}
                                                                            </option>
                                                                            <option
                                                                                value="{{ ProductType::VARIANT }}" {{ $product->isVariant() ? 'selected' : ''}}>
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
                                                                            class="form-control disabled"
                                                                            placeholder="{{ __('form.enter_sku') }}"
                                                                            name="product[sku]"
                                                                            value="{{ $product->sku }}"
                                                                            disabled
                                                                        >
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="stock-box form-group align-items-center g-2 mb-4 row {{ $product->isVariant() ? 'd-none' : '' }}">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="stock">
                                                                        {{ __('form.product_stock.stock') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <input id="stock" type="number"
                                                                            class="form-control disabled"
                                                                            placeholder="{{ __('form.enter_product_stock') }}"
                                                                            name="product_stocks[stock]"
                                                                            value="{{ $product->productStock?->stock }}"
                                                                            disabled
                                                                        >
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="price-box form-group align-items-center g-2 mb-4 row {{ $product->isVariant() ? 'd-none' : '' }}">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="price">
                                                                        {{ __('form.product.price') }}
                                                                        <span
                                                                            class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input id="price" type="number"
                                                                                class="form-control disabled"
                                                                                placeholder="{{ __('form.enter_price') }}"
                                                                                name="product[price]"
                                                                                value="{{ $product->price }}"
                                                                                {{ $product->isVariant() ? 'disabled' : '' }}
                                                                                disabled
                                                                            >
                                                                            <span class="input-group-text">VNĐ</span>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="sale_price-box form-group align-items-center g-2 mb-4 row {{ $product->isVariant() ? 'd-none' : '' }}">
                                                                    <label class="col-sm-3 form-label-title mb-0"
                                                                        for="sale_price">
                                                                        {{ __('form.product.sale_price') }}
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group">
                                                                            <input id="sale_price" type="number"
                                                                                placeholder="{{ __('form.enter_sale_price') }}"
                                                                                class="form-control disabled"
                                                                                name="product[sale_price]"
                                                                                value="{{ $product->sale_price }}"
                                                                                {{ $product->isVariant() ? 'd-none' : '' }}
                                                                                disabled
                                                                            >
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
                                                                            <label class="switch disabled">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    id="is_sale"
                                                                                    name="product[is_sale]"
                                                                                    value="1"
                                                                                    {{ $product->is_sale === 1 ? 'checked' : '' }}
                                                                                    disabled
                                                                                >
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
                                                                            <input
                                                                                placeholder="YYY-MM-DD"
                                                                                name="product[sale_price_start_at]"
                                                                                id="start_date_input"
                                                                                class="form-control form-date disabled"
                                                                                value="{{ $product->sale_price_start_at }}"
                                                                                disabled
                                                                            >
                                                                            <button type="button" id="startDatePickerBtn"
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
                                                                            <input
                                                                                placeholder="YYY-MM-DD"
                                                                                name="product[sale_price_end_at]"
                                                                                id="end_date_input"
                                                                                class="form-control form-date disabled"
                                                                                value="{{ $product->sale_price_end_at }}"
                                                                                disabled
                                                                            >
                                                                            <button type="button" id="startDatePickerBtn"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="ri-calendar-line"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="invalid-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group variant-box border-top {{ $product->isSingle() ? 'd-none' : '' }}">

                                                                    <div class="table-responsive datatable-wrapper border-table mt-4"
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
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                {{-- @dd($product); --}}
                                                                                @foreach ($product->productVariants as $variant)
                                                                                    <tr class="variant">
                                                                                        <td class="sm-width form-group">
                                                                                            <img alt="image" class="tbl-image icon-image" src="{{ Storage::url($variant->thumbnail) }}">
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                        
                                                                                        <td class="form-group">
                                                                                            <div>
                                                                                                @foreach ($variant->attributeValues->pluck('value') as $combine)
                                                                                                    {{ $combine . ($loop->last ? '' : ' | ') }}
                                                                                                @endforeach
                                                                                            </div>
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                        
                                                                                        <td class="form-group">
                                                                                            <input
                                                                                                type="text"
                                                                                                name="product_variants[{{ $variant->id }}][info][sku]"
                                                                                                class="form-control disabled"
                                                                                                value="{{ $variant->sku }}"
                                                                                                disabled
                                                                                            >
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                        
                                                                                        <td class="form-group">
                                                                                            <input
                                                                                                type="number"
                                                                                                name="product_variants[{{ $variant->id }}][info][price]"
                                                                                                class="form-control disabled"
                                                                                                value="{{ $variant->price }}"
                                                                                                disabled
                                                                                            >
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                                                        <td class="form-group">
                                                                                            <input
                                                                                                type="number"
                                                                                                name="product_variants[{{ $variant->id }}][info][sale_price]"
                                                                                                class="form-control disabled"
                                                                                                value="{{ $variant->sale_price }}"
                                                                                                disabled
                                                                                            >
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                                                        <td class="form-group">
                                                                                            <input
                                                                                                type="number"
                                                                                                name="product_variants[{{ $variant->id }}][product_stocks][stock]"
                                                                                                class="form-control disabled"
                                                                                                value="{{ $variant->productStock->stock }}"
                                                                                                disabled
                                                                                            >
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                                                        <td class="form-group">
                                                                                            <div class="form-check form-switch ps-0">
                                                                                                <label class="switch disabled">
                                                                                                    <input
                                                                                                        type="checkbox"
                                                                                                        id="is_active"
                                                                                                        name="product_variants[{{ $variant->id }}][info][is_active]"
                                                                                                        value="1"
                                                                                                        {{ $variant->is_active === 1 ? 'checked' : '' }}
                                                                                                        disabled
                                                                                                    >
                                                                                                    <span class="switch-state"></span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="invalid-feedback"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
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
                                                                            <select id="tags" class="form-select select2 disabled" multiple name="tags[]" disabled>
                                                                                @foreach ($tags as $tag)
                                                                                    <option
                                                                                        value="{{ $tag->id }}"
                                                                                        {{ in_array($tag->id, $product->tags->pluck('id')->toArray()) ? 'selected' : '' }}
                                                                                    >
                                                                                        {{ $tag->name }}
                                                                                    </option>
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
                                                                            <select id="brand" class="form-select select2 disabled" name="product[brand_id]" disabled>
                                                                                @foreach ($brands as $brand)
                                                                                    <option
                                                                                        value="{{ $brand->id }}"
                                                                                        {{ $product->brand_id === $brand->id ? 'selected' : '' }}
                                                                                    >
                                                                                        {{ $brand->name }}
                                                                                    </option>
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
                                                                            <select id="categories" class="form-select select2 disabled" name="category_id" disabled>
                                                                                @foreach ($categories as $category)
                                                                                    <option
                                                                                        value="{{ $category->id }}"
                                                                                        {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}
                                                                                    >
                                                                                        {{ $category->name }}
                                                                                    </option>
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
                                                                                class="form-select select2 disabled" multiple
                                                                                name="product_accessories[]" disabled>
                                                                                @foreach ($productAccessories as $productAccessory)
                                                                                    <option
                                                                                        value="{{ $productAccessory->id }}"
                                                                                        {{ in_array($productAccessory->id, $product->productAccessories->pluck('id')->toArray()) ? 'selected' : '' }}
                                                                                    >
                                                                                        {{ $productAccessory->name }}
                                                                                    </option>
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
                                                                        <div class="mb-2">
                                                                            <img alt="image" class="tbl-image icon-image" src="{{ Storage::url($product->thumbnail) }}">
                                                                        </div>
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
                                                                        <div class="mb-2">
                                                                            @foreach ($product->productGallery as $gallery)
                                                                                <img alt="image" class="tbl-image icon-image" src="{{ Storage::url($gallery->image) }}">
                                                                            @endforeach
                                                                        </div>
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
                                                                            <label class="switch disabled">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    id="is_featured"
                                                                                    name="product[is_featured]"
                                                                                    value="1"
                                                                                    {{ $product->is_featured ? 'checked' : '' }}
                                                                                    disabled
                                                                                >
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
                                                                            <label class="switch disabled">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    id="is_trending"
                                                                                    name="product[is_trending]"
                                                                                    value="1"
                                                                                    {{ $product->is_trending ? 'checked' : '' }}
                                                                                    disabled
                                                                                >
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
                                                                            <label class="switch disabled">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    id="is_active"
                                                                                    name="product[is_active]"
                                                                                    value="1"
                                                                                    {{ $product->is_active ? 'checked' : '' }}
                                                                                    disabled
                                                                                >
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
                                            <div class="d-flex justify-content-end">
                                                <a class="btn btn-warning ms-auto mt-4" href="{{ route('admin.products.edit', $product->id) }}">
                                                    <div>{{ __('message.edit') }}</div>
                                                </a>
                                            </div>
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
    <script>
        ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.isReadOnly = true;
            editor.setData('{!! $product->description !!}');
        })
        .catch(error => {
            console.error(error);
        });
    </script>

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

        });
    </script>
@endpush
