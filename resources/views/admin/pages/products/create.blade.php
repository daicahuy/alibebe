@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
<!-- Select2 css -->
<link rel="stylesheet" href="{{ asset('theme/admin/assets/css/select2.min.css') }}">

@endpush

@push('css')
<style>
    
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
                                                                <i
                                                                    class="ri-checkbox-circle-line"></i>{{ __('form.status') }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-xl-7 col-lg-8">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade show active" id="general-panel"
                                                            aria-labelledby="general">
                                                            <div tab="general" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="name">
                                                                        {{ __('form.product.name') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9"><input id="name"
                                                                            type="text" formcontrolname="name"
                                                                            class="form-control   "
                                                                            placeholder="Enter product name">
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="short_description">
                                                                        {{ __('form.product.short_description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <textarea id="sort_description" rows="3" formcontrolname="short_description" class="form-control   "
                                                                            placeholder="Enter Short Description"></textarea>
                                                                        <p class="help-text">*Maximum length
                                                                            should be 300 characters.</p>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="description">
                                                                        {{ __('form.product.description') }}
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div id="editor"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="store">
                                                                        Store
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div>
                                                                            <select class="select2 form-select" name="state" multiple="multiple">
                                                                                <option disabled>Category Menu</option>
                                                                                <option>Electronics</option>
                                                                                <option>TV & Appliances</option>
                                                                                <option>Home & Furniture</option>
                                                                                <option>Another</option>
                                                                                <option>Baby & Kids</option>
                                                                                <option>Health, Beauty & Perfumes</option>
                                                                                <option>Uncategorized</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="inventory-panel"
                                                            aria-labelledby="inventory">
                                                            <div tab="inventory" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="type">
                                                                        Type
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select2 formcontrolname="type"
                                                                            class="custom-select   " id="select2-13"
                                                                            aria-invalid="false">
                                                                            <div class="select2-label"></div>
                                                                            <div
                                                                                class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                                <div cdkoverlayorigin="" class="selection"
                                                                                    tabindex="0">
                                                                                    <div role="combobox"
                                                                                        class="select2-selection select2-selection--single">
                                                                                        <span
                                                                                            class="select2-selection__rendered"
                                                                                            title="Simple"><span>Simple</span><span
                                                                                                class="select2-selection__placeholder select2-selection__placeholder__option">Select
                                                                                                Type</span></span><span
                                                                                            role="presentation"
                                                                                            class="select2-selection__arrow"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="select2-container select2-container--default select2-container-dropdown">
                                                                                    <div
                                                                                        class="select2-dropdown select2-dropdown--below">
                                                                                        <div
                                                                                            class="select2-search select2-search--dropdown select2-search--hide">
                                                                                            <input type="search"
                                                                                                role="textbox"
                                                                                                autocomplete="off"
                                                                                                autocorrect="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                class="select2-search__field"
                                                                                                id="select2-13-search-field"
                                                                                                tabindex="-1">
                                                                                        </div>
                                                                                        <div class="select2-results">
                                                                                            <ul role="tree"
                                                                                                tabindex="-1"
                                                                                                infinitescroll=""
                                                                                                class="select2-results__options"
                                                                                                style="max-height: 200px;">

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option select2-results__option--highlighted"
                                                                                                    id="select2-13-option-0"
                                                                                                    aria-selected="true"
                                                                                                    aria-disabled="false">
                                                                                                    <div
                                                                                                        class="select2-label-content">
                                                                                                        Simple</div>

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-13-option-1"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div
                                                                                                        class="select2-label-content">
                                                                                                        Classified
                                                                                                    </div>

                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="select2-subscript-wrapper">
                                                                                </div>
                                                                            </div>
                                                                        </select2>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="unit">
                                                                        Unit</label>
                                                                    <div class="col-sm-9"><input id="unit"
                                                                            type="text" formcontrolname="unit"
                                                                            class="form-control   "
                                                                            placeholder="Enter Unit">
                                                                        <p class="help-text">*Specify the
                                                                            measurement unit, such as 10 Pieces, 1
                                                                            KG, 1 Ltr, etc.</p>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="weight">
                                                                        Weight</label>
                                                                    <div class="col-sm-9"><input id="weight"
                                                                            type="number"
                                                                            placeholder="Enter weight Gms (e.g 100)"
                                                                            formcontrolname="weight"
                                                                            class="form-control   ">
                                                                        <p class="help-text">*Specify the weight
                                                                            of this product in Gms.</p>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="stock_status">
                                                                        Stock Status
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <select2 formcontrolname="stock_status"
                                                                            class="custom-select   " id="select2-14"
                                                                            aria-invalid="false">
                                                                            <div class="select2-label"></div>
                                                                            <div
                                                                                class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                                <div cdkoverlayorigin="" class="selection"
                                                                                    tabindex="0">
                                                                                    <div role="combobox"
                                                                                        class="select2-selection select2-selection--single">
                                                                                        <span
                                                                                            class="select2-selection__rendered"
                                                                                            title="In Stock"><span>In
                                                                                                Stock</span><span
                                                                                                class="select2-selection__placeholder select2-selection__placeholder__option">Select
                                                                                                Stock
                                                                                                Status</span></span><span
                                                                                            role="presentation"
                                                                                            class="select2-selection__arrow"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="select2-container select2-container--default select2-container-dropdown">
                                                                                    <div
                                                                                        class="select2-dropdown select2-dropdown--below">
                                                                                        <div
                                                                                            class="select2-search select2-search--dropdown select2-search--hide">
                                                                                            <input type="search"
                                                                                                role="textbox"
                                                                                                autocomplete="off"
                                                                                                autocorrect="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                class="select2-search__field"
                                                                                                id="select2-14-search-field"
                                                                                                tabindex="-1">
                                                                                        </div>
                                                                                        <div class="select2-results">
                                                                                            <ul role="tree"
                                                                                                tabindex="-1"
                                                                                                infinitescroll=""
                                                                                                class="select2-results__options"
                                                                                                style="max-height: 200px;">

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option select2-results__option--highlighted"
                                                                                                    id="select2-14-option-0"
                                                                                                    aria-selected="true"
                                                                                                    aria-disabled="false">
                                                                                                    <div
                                                                                                        class="select2-label-content">
                                                                                                        In Stock
                                                                                                    </div>

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-14-option-1"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div
                                                                                                        class="select2-label-content">
                                                                                                        Out of Stock
                                                                                                    </div>

                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="select2-subscript-wrapper">
                                                                                </div>
                                                                            </div>
                                                                        </select2>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sku">
                                                                        SKU
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9"><input id="sku"
                                                                            type="text" formcontrolname="sku"
                                                                            class="form-control   "
                                                                            placeholder="Enter SKU"></div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="quantity">
                                                                        Stock Quantity
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9"><input id="quantity"
                                                                            type="number" formcontrolname="quantity"
                                                                            class="form-control   "
                                                                            placeholder="Enter Quantity">
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="price">
                                                                        Price
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group"><span
                                                                                class="input-group-text"> $
                                                                            </span><input id="price" type="number"
                                                                                formcontrolname="price"
                                                                                class="form-control   "
                                                                                placeholder="Enter Price"></div>

                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="discount_value">
                                                                        Discount</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group"><input
                                                                                id="discount_value" type="number"
                                                                                min="0" max="100"
                                                                                oninput="if (value > 100) value = 100; if (value < 0) value = 0;"
                                                                                formcontrolname="discount"
                                                                                class="form-control   "
                                                                                placeholder="Enter discount"><span
                                                                                class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="sale_price">
                                                                        Sale Price</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="input-group"><span
                                                                                class="input-group-text"> $
                                                                            </span><input id="sale_price" type="number"
                                                                                placeholder="sale price" readonly=""
                                                                                class="form-control disabled">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_sale_enable">
                                                                        Sale
                                                                        Status</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="is_sale_enable"
                                                                                    formcontrolname="is_sale_enable"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div><app-form-fields>
                                                                        <div class="align-items-center g-2 mb-4 row">
                                                                            <label class="col-sm-3 form-label-title mb-0" for="sale_starts_at">
                                                                                Sale Start
                                                                                Date</label>
                                                                            <div class="col-sm-9">
                                                                                <div
                                                                                    class="dp-hidden position-absolute custom-dp-dropdown">
                                                                                    <div class="input-group"><input
                                                                                            name="datepicker"
                                                                                            ngbdatepicker=""
                                                                                            outsidedays="hidden"
                                                                                            tabindex="-1" readonly=""
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="input-group custom-dt-picker">
                                                                                    <input placeholder="yyyy-mm-dd"
                                                                                        name="dpFromDate" readonly=""
                                                                                        class="form-control"><button
                                                                                        type="button"
                                                                                        class="btn btn-outline-secondary"><i
                                                                                            class="ri-calendar-line"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <app-form-fields>
                                                                            <div class="align-items-center g-2 mb-4 row">
                                                                                <label
                                                                                    class="col-sm-3 form-label-title mb-0" for="sale_expired_at">
                                                                                    Sale End
                                                                                    Date</label>
                                                                                <div class="col-sm-9">
                                                                                    <div
                                                                                        class="input-group custom-dt-picker">
                                                                                        <input placeholder="yyyy-mm-dd"
                                                                                            name="dpToDate" readonly=""
                                                                                            class="form-control"><button
                                                                                            type="button"
                                                                                            class="btn btn-outline-secondary"><i
                                                                                                class="ri-calendar-line"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="setup-panel"
                                                            aria-labelledby="setup">
                                                            <div tab="setup" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="tags">
                                                                        Tags</label>
                                                                    <div class="col-sm-9"><app-advanced-dropdown>
                                                                            <div>
                                                                                <div class="position-relative">
                                                                                    <nav
                                                                                        class="category-breadcrumb-select">
                                                                                        <ol class="breadcrumb">

                                                                                            <li class="breadcrumb-item">
                                                                                                <a
                                                                                                    href="javascript:void(0)">Select
                                                                                                    Option</a>
                                                                                            </li>

                                                                                        </ol>
                                                                                    </nav><a
                                                                                        class="cateogry-close-btn d-inline-block"><i
                                                                                            class="ri-arrow-down-s-line down-arrow"></i><i
                                                                                            class="ri-close-line close-arrow"></i></a>
                                                                                    <div
                                                                                        class="select-category-box mt-2 dropdown-open">
                                                                                        <input placeholder="Search here.."
                                                                                            class="form-control search-input   ">
                                                                                        <div class="category-content">
                                                                                            <nav aria-label="breadcrumb"
                                                                                                class="category-breadcrumb">
                                                                                                <ol class="breadcrumb">

                                                                                                    <li
                                                                                                        class="breadcrumb-item">
                                                                                                        <a
                                                                                                            href="javascript:void(0)">All</a>
                                                                                                    </li>

                                                                                                </ol>
                                                                                            </nav>
                                                                                            <div class="category-listing">
                                                                                                <ul>
                                                                                                    <app-dropdown-list>
                                                                                                        <li>
                                                                                                            Farm
                                                                                                            Fresh
                                                                                                            Produce
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Groceries
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Fashions
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Furnishing
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Accessories
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Sports
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Electronics
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Meats
                                                                                                            &amp;
                                                                                                            Seafood
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Fashion
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Beauty
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Furniture
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Pet Shop
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Wines
                                                                                                            &amp;
                                                                                                            Soft
                                                                                                            Drinks
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Grocery
                                                                                                            &amp;
                                                                                                            Staples
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Biscuits
                                                                                                            &amp;
                                                                                                            Snacks
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Frozen
                                                                                                            Foods <a
                                                                                                                href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Breakfast
                                                                                                            &amp;
                                                                                                            Dairy <a
                                                                                                                href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Beverages
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Vegetables
                                                                                                            &amp;
                                                                                                            Fruits
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </app-advanced-dropdown></div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="categories">
                                                                        Categories
                                                                        <span class="theme-color ms-2 required-dot">*</span>
                                                                    </label>
                                                                    <div class="col-sm-9"><app-advanced-dropdown
                                                                            id="categories">
                                                                            <div>
                                                                                <div class="position-relative">
                                                                                    <nav
                                                                                        class="category-breadcrumb-select">
                                                                                        <ol class="breadcrumb">

                                                                                            <li class="breadcrumb-item">
                                                                                                <a
                                                                                                    href="javascript:void(0)">Select
                                                                                                    Option</a>
                                                                                            </li>

                                                                                        </ol>
                                                                                    </nav><a
                                                                                        class="cateogry-close-btn d-inline-block"><i
                                                                                            class="ri-arrow-down-s-line down-arrow"></i><i
                                                                                            class="ri-close-line close-arrow"></i></a>
                                                                                    <div
                                                                                        class="select-category-box mt-2 dropdown-open">
                                                                                        <input placeholder="Search here.."
                                                                                            class="form-control search-input   ">
                                                                                        <div class="category-content">
                                                                                            <nav aria-label="breadcrumb"
                                                                                                class="category-breadcrumb">
                                                                                                <ol class="breadcrumb">

                                                                                                    <li
                                                                                                        class="breadcrumb-item">
                                                                                                        <a
                                                                                                            href="javascript:void(0)">All</a>
                                                                                                    </li>

                                                                                                </ol>
                                                                                            </nav>
                                                                                            <div class="category-listing">
                                                                                                <ul>
                                                                                                    <app-dropdown-list>
                                                                                                        <li>
                                                                                                            Furnishing
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Fashions
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Groceries
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Farm
                                                                                                            Fresh
                                                                                                            Produce
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Electronics
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Sports
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Accessories
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Fashion
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a><a
                                                                                                                href="javascript:void(0)"
                                                                                                                class="right-arrow"><i
                                                                                                                    class="ri-arrow-right-s-line"></i></a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Beauty
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Furniture
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a><a
                                                                                                                href="javascript:void(0)"
                                                                                                                class="right-arrow"><i
                                                                                                                    class="ri-arrow-right-s-line"></i></a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Meats
                                                                                                            &amp;
                                                                                                            Seafood
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Pet Shop
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Milk
                                                                                                            &amp;
                                                                                                            Dairy
                                                                                                            Products
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Wines
                                                                                                            &amp;
                                                                                                            Soft
                                                                                                            Drinks
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Grocery
                                                                                                            &amp;
                                                                                                            Staples
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Biscuits
                                                                                                            &amp;
                                                                                                            Snacks
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Frozen
                                                                                                            Foods <a
                                                                                                                href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Daily
                                                                                                            Breakfast
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Beverages
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list><app-dropdown-list>
                                                                                                        <li>
                                                                                                            Vegetables
                                                                                                            &amp;
                                                                                                            Fruits
                                                                                                            <a href="javascript:void(0)"
                                                                                                                class="select-btn">
                                                                                                                Select
                                                                                                            </a>
                                                                                                        </li>
                                                                                                    </app-dropdown-list>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </app-advanced-dropdown></div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_random_related_products">
                                                                        Random
                                                                        Related Product</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="is_random_related_products"
                                                                                    formcontrolname="is_random_related_products"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Enabling this
                                                                                option allows the backend to
                                                                                randomly select 6 products for
                                                                                display.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="related_product_id">
                                                                        Related
                                                                        Products</label>
                                                                    <div class="col-sm-9">
                                                                        <select2 formcontrolname="related_products"
                                                                            class="custom-select   " id="select2-16"
                                                                            aria-invalid="false">
                                                                            <div class="select2-label">
                                                                            </div>
                                                                            <div
                                                                                class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                                <div cdkoverlayorigin="" class="selection"
                                                                                    tabindex="0">
                                                                                    <div role="combobox"
                                                                                        class="select2-selection select2-selection--multiple">

                                                                                        <ul
                                                                                            class="select2-selection__rendered">
                                                                                            <span
                                                                                                class="select2-selection__placeholder">Select
                                                                                                Product</span>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="select2-container select2-container--default select2-container-dropdown">
                                                                                    <div
                                                                                        class="select2-dropdown select2-dropdown--below">
                                                                                        <div
                                                                                            class="select2-search select2-search--dropdown">
                                                                                            <input type="search"
                                                                                                role="textbox"
                                                                                                autocomplete="off"
                                                                                                autocorrect="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                class="select2-search__field"
                                                                                                id="select2-16-search-field"
                                                                                                tabindex="-1">
                                                                                        </div>
                                                                                        <div class="select2-results">
                                                                                            <ul role="tree"
                                                                                                tabindex="-1"
                                                                                                infinitescroll=""
                                                                                                class="select2-results__options"
                                                                                                style="max-height: 200px;">

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option select2-results__option--highlighted"
                                                                                                    id="select2-16-option-0"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/93/Strawberry_1.png">
                                                                                                    </div>
                                                                                                    Deliciously
                                                                                                    Sweet Strawberry

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-1"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/100/Watermelon_4.png">
                                                                                                    </div>
                                                                                                    Deliciously
                                                                                                    Sweet Watermelon

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-2"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/87/Plum_2.png">
                                                                                                    </div> Palm
                                                                                                    Bliss Unleashed

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-3"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/83/Pear_4.png">
                                                                                                    </div> Fresh
                                                                                                    Pear

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-4"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/77/Pumpkin_3.png">
                                                                                                    </div> Premium
                                                                                                    Organic Pumpkin

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-5"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/25/Durian_4.png">
                                                                                                    </div> Freshly
                                                                                                    Picked Durian

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-6"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/70/Pea_1.png">
                                                                                                    </div>
                                                                                                    Nourishing Peas

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-7"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/65/Orange_1.png">
                                                                                                    </div> Organic
                                                                                                    Oranges

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-8"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/33/Garlic_4.png">
                                                                                                    </div> Fresh
                                                                                                    Organic Garlic

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-9"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/63/Kiwi_4.png">
                                                                                                    </div> Juicy
                                                                                                    Green Kiwi

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-10"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/26/Eggplant_1.png">
                                                                                                    </div>
                                                                                                    Nutrient-Rich
                                                                                                    Eggplant

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-11"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/55/Banana_1.png">
                                                                                                    </div> Nature's
                                                                                                    Sweet Banana

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-12"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/12/Beetroot_4.png">
                                                                                                    </div> Naturally
                                                                                                    Grown Beetroot

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-13"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/14/Cabbage_1.png">
                                                                                                    </div> Gourmet
                                                                                                    Organic Cabbage

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-14"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/52/Aamla_3.png">
                                                                                                    </div> Superior
                                                                                                    Quality Amla

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-15"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/48/Onion_4.png">
                                                                                                    </div> Premium
                                                                                                    Organic Onion

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-16"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/35/Peach_1.png">
                                                                                                    </div>
                                                                                                    Deliciously Ripe
                                                                                                    Peach

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-17"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/42/Tomato_3.png">
                                                                                                    </div>
                                                                                                    Handpicked
                                                                                                    Tomatoes

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-16-option-18"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/18/Capsicum_1.png">
                                                                                                    </div> Fresh
                                                                                                    Capsicum

                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="select2-subscript-wrapper">
                                                                                </div>
                                                                            </div>
                                                                        </select2>
                                                                        <p class="help-text">*Choose a maximum of
                                                                            6 products for effective related
                                                                            products display.</p>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="cross_sell_products">
                                                                        Cross Sell
                                                                        Products</label>
                                                                    <div class="col-sm-9">
                                                                        <select2 formcontrolname="cross_sell_products"
                                                                            class="custom-select   " id="select2-15"
                                                                            aria-invalid="false">
                                                                            <div class="select2-label">
                                                                            </div>
                                                                            <div
                                                                                class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                                <div cdkoverlayorigin="" class="selection"
                                                                                    tabindex="0">
                                                                                    <div role="combobox"
                                                                                        class="select2-selection select2-selection--multiple">

                                                                                        <ul
                                                                                            class="select2-selection__rendered">
                                                                                            <span
                                                                                                class="select2-selection__placeholder">Select
                                                                                                Product</span>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="select2-container select2-container--default select2-container-dropdown">
                                                                                    <div
                                                                                        class="select2-dropdown select2-dropdown--below">
                                                                                        <div
                                                                                            class="select2-search select2-search--dropdown">
                                                                                            <input type="search"
                                                                                                role="textbox"
                                                                                                autocomplete="off"
                                                                                                autocorrect="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                class="select2-search__field"
                                                                                                id="select2-15-search-field"
                                                                                                tabindex="-1">
                                                                                        </div>
                                                                                        <div class="select2-results">
                                                                                            <ul role="tree"
                                                                                                tabindex="-1"
                                                                                                infinitescroll=""
                                                                                                class="select2-results__options"
                                                                                                style="max-height: 200px;">

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option select2-results__option--highlighted"
                                                                                                    id="select2-15-option-0"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/93/Strawberry_1.png">
                                                                                                    </div>
                                                                                                    Deliciously
                                                                                                    Sweet Strawberry

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-1"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/87/Plum_2.png">
                                                                                                    </div> Palm
                                                                                                    Bliss Unleashed

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-2"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/83/Pear_4.png">
                                                                                                    </div> Fresh
                                                                                                    Pear

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-3"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/77/Pumpkin_3.png">
                                                                                                    </div> Premium
                                                                                                    Organic Pumpkin

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-4"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/25/Durian_4.png">
                                                                                                    </div> Freshly
                                                                                                    Picked Durian

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-5"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/70/Pea_1.png">
                                                                                                    </div>
                                                                                                    Nourishing Peas

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-6"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/33/Garlic_4.png">
                                                                                                    </div> Fresh
                                                                                                    Organic Garlic

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-7"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/63/Kiwi_4.png">
                                                                                                    </div> Juicy
                                                                                                    Green Kiwi

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-8"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/26/Eggplant_1.png">
                                                                                                    </div>
                                                                                                    Nutrient-Rich
                                                                                                    Eggplant

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-9"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/55/Banana_1.png">
                                                                                                    </div> Nature's
                                                                                                    Sweet Banana

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-10"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/12/Beetroot_4.png">
                                                                                                    </div> Naturally
                                                                                                    Grown Beetroot

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-11"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/14/Cabbage_1.png">
                                                                                                    </div> Gourmet
                                                                                                    Organic Cabbage

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-12"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/52/Aamla_3.png">
                                                                                                    </div> Superior
                                                                                                    Quality Amla

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-13"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/48/Onion_4.png">
                                                                                                    </div> Premium
                                                                                                    Organic Onion

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-14"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/35/Peach_1.png">
                                                                                                    </div>
                                                                                                    Deliciously Ripe
                                                                                                    Peach

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-15"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/42/Tomato_3.png">
                                                                                                    </div>
                                                                                                    Handpicked
                                                                                                    Tomatoes

                                                                                                </li>

                                                                                                <li role="treeitem"
                                                                                                    class="select2-results__option"
                                                                                                    id="select2-15-option-16"
                                                                                                    aria-selected="false"
                                                                                                    aria-disabled="false">
                                                                                                    <div class="image">
                                                                                                        <img class="img-fluid selection-image"
                                                                                                            src="https://laravel.pixelstrap.net/fastkart/storage/18/Capsicum_1.png">
                                                                                                    </div> Fresh
                                                                                                    Capsicum

                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="select2-subscript-wrapper">
                                                                                </div>
                                                                            </div>
                                                                        </select2>
                                                                        <p class="help-text">*Choose a maximum of
                                                                            3 products for effective cross-selling
                                                                            display.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="images-panel"
                                                            aria-labelledby="images">
                                                            <div tab="images" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="product_thumbnail_id">
                                                                        Thumbnail</label>
                                                                    <div class="col-sm-9"><app-image-upload>
                                                                            <ul class="image-select-list cursor-pointer">
                                                                                <li class="choosefile-input"><i
                                                                                        class="ri-add-line"></i>
                                                                                </li>
                                                                                <li>
                                                                                    <img alt="image"
                                                                                        class="img-fluid"
                                                                                        src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="remove-icon"><i
                                                                                            class="ri-close-line text-white"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                            <p class="help-text">*Upload image
                                                                                size 600x600px recommended</p>
                                                                            <app-media-modal></app-media-modal>
                                                                        </app-image-upload></div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="product_galleries_id">
                                                                        Images</label>
                                                                    <div class="col-sm-9"><app-image-upload>
                                                                            <ul class="image-select-list cursor-pointer">
                                                                                <li class="choosefile-input"><i
                                                                                        class="ri-add-line"></i>
                                                                                </li>
                                                                                <li>
                                                                                    <img alt="image"
                                                                                        class="img-fluid"
                                                                                        src="https://laravel.pixelstrap.net/fastkart/storage/89/Pomegranate_1.png"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="remove-icon"
                                                                                        id="remove-icon0"><i
                                                                                            class="ri-close-line text-white"></i></a>
                                                                                </li>
                                                                                <li>
                                                                                    <img alt="image"
                                                                                        class="img-fluid"
                                                                                        src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="remove-icon"
                                                                                        id="remove-icon1"><i
                                                                                            class="ri-close-line text-white"></i></a>
                                                                                </li>
                                                                                <li>
                                                                                    <img alt="image"
                                                                                        class="img-fluid"
                                                                                        src="https://laravel.pixelstrap.net/fastkart/storage/91/Pomegranate_3.png"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="remove-icon"
                                                                                        id="remove-icon2"><i
                                                                                            class="ri-close-line text-white"></i></a>
                                                                                </li>
                                                                                <li>
                                                                                    <img alt="image"
                                                                                        class="img-fluid"
                                                                                        src="https://laravel.pixelstrap.net/fastkart/storage/92/Pomegranate_4.png"><a
                                                                                        href="javascript:void(0)"
                                                                                        class="remove-icon"
                                                                                        id="remove-icon3"><i
                                                                                            class="ri-close-line text-white"></i></a>
                                                                                </li>
                                                                            </ul>
                                                                            <p class="help-text">*Upload image
                                                                                size 600x600px recommended</p>
                                                                            <app-media-modal></app-media-modal>
                                                                        </app-image-upload></div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="size_chart_image_id">
                                                                        Size
                                                                        Chart</label>
                                                                    <div class="col-sm-9"><app-image-upload>
                                                                            <ul class="image-select-list cursor-pointer">
                                                                                <li class="choosefile-input"><i
                                                                                        class="ri-add-line"></i>
                                                                                </li>
                                                                            </ul>
                                                                            <p class="help-text">*Upload an image
                                                                                showcasing the size chart tailored
                                                                                for fashion products. A table format
                                                                                image is suggested for easy
                                                                                reference.</p>
                                                                            <app-media-modal></app-media-modal>
                                                                        </app-image-upload></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane fade" id="status-panel"
                                                            aria-labelledby="status">
                                                            <div tab="status" class="tab">
                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="product_featured">
                                                                        Featured</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="product_featured"
                                                                                    formcontrolname="is_featured"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Enabling this
                                                                                option will display a Featured tag
                                                                                on the product.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="safe_checkout">
                                                                        Safe
                                                                        checkout</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="safe_checkout"
                                                                                    formcontrolname="safe_checkout"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*A safe checkout
                                                                                image will appear on the product
                                                                                page. Modify the image in the theme
                                                                                options.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="secure_checkout">
                                                                        Secure
                                                                        checkout</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="secure_checkout"
                                                                                    formcontrolname="secure_checkout"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*A secure
                                                                                checkout image will appear on the
                                                                                product page. Modify the image in
                                                                                the theme options.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="social_share">
                                                                        Social
                                                                        share</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="social_share"
                                                                                    formcontrolname="social_share"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Enable this
                                                                                option to allow users to share the
                                                                                product on social media platforms.
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="encourage_order">
                                                                        Encourage
                                                                        order</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="encourage_order"
                                                                                    formcontrolname="encourage_order"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*A random order
                                                                                count between 1 and 100 will be
                                                                                displayed to motivate user
                                                                                purchases.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="encourage_view">
                                                                        Encourage
                                                                        view</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="encourage_view"
                                                                                    formcontrolname="encourage_view"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*this feature
                                                                                encourages users to view products by
                                                                                presenting engaging content or
                                                                                prompts.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="is_trending">
                                                                        trending</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="is_trending"
                                                                                    formcontrolname="is_trending"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Enabling this
                                                                                will showcase the product in the
                                                                                sidebar of the product page as a
                                                                                trending item.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="return">
                                                                        return</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="return"
                                                                                    formcontrolname="is_return"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Enable to make
                                                                                the product eligible for returns.
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="align-items-center g-2 mb-4 row">
                                                                    <label class="col-sm-3 form-label-title mb-0" for="status">
                                                                        Status</label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-check form-switch ps-0">
                                                                            <label class="switch"><input type="checkbox"
                                                                                    id="status"
                                                                                    formcontrolname="status"
                                                                                    class="  "><span
                                                                                    class="switch-state"></span></label>
                                                                            <p class="help-text">*Toggle between
                                                                                Enabled and Disabled to control the
                                                                                availability of the product for
                                                                                purchase.</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-theme ms-auto mt-4" id="product_btn"
                                                type="submit">
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
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endpush
