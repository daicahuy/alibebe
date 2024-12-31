@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <link rel="stylesheet" href="/theme/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/mermaid.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/nouislider.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/icons.min.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" crossorigin>

    <link rel="stylesheet" href="/theme/admin/assets/css/app.min.css">
    {{-- <link rel="stylesheet" type="text/css" href="/theme/admin/assets/css/select2.min.css"> --}}


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/theme/admin/assets/css/styles-angular.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/styles_add_product.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/styles_add_product2.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
@endpush

@push('css')
    <style>
        .page-wrapper.compact-wrapper .page-body-wrapper .page-body {
            margin-top: unset !important;
            padding-top: unset !important;
        }

        .accordion-button {
            overflow: hidden;
            text-transform: capitalize;
            box-shadow: none;
            border: none;
            background-color: #f9f9f6 !important;
            font-weight: 400;
            font-size: 16px;
            padding: 10px 18px;
            color: #4a5568;
            border-radius: 11px !important;
        }

        .accordion-header {
            border: 1px solid #ddd !important;
            border-radius: 11px !important;
        }

        .accordion-body {
            padding-left: 12px;
            padding-right: 12px;
        }

        .theme-form .select2-selection__rendered {
            width: unset !important;
        }

        .select2-selection.select2-selection--multiple {
            background-color: #f9f9f6;
        }

        .select2.select2-container.select2-container--default.select2-container--focus {
            width: 100% !important;
        }

        .select2-search.select2-search--inline {
            height: 100% !important;
        }

        .select2-search__field {
            height: 100% !important;
            margin: unset !important;
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%);
        }

        .select2-selection__rendered {
            border-radius: 5px !important;
        }

        .variant-container {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .variant-container:last-child {
            border-bottom: none;
        }

        .variant-inputs {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .variant-inputs .select2-container {
            flex: 1;
        }

        .remove-variant {
            color: red;
            cursor: pointer;
            align-self: center;
        }

        .generated-variants {
            margin-top: 20px;
        }


        .custom-select .select2-container .select2-selection {
            border: unset !important;
        }

        .selection {
            border: unset !important;
        }

        .custom-select .select2-container .select2-selection .select2-selection__arrow:before {
            content: "" !important;
        }

        .variant-container {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .variant-container:last-child {
            border-bottom: none;
        }

        .variant-inputs {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .variant-inputs .select2-container {
            flex: 1;
        }

        .remove-variant {
            color: red;
            cursor: pointer;
            align-self: center;
        }

        .generated-variants {
            margin-top: 20px;
        }



        .select2.select2-container .selection {
            width: 100%;
        }

        .select2-selection.select2-selection--multiple {
            align-items: center;
            display: flex;
            padding-bottom: unset;
        }

        .select2-selection__choice {
            display: flex !important;
            align-items: center !important;
            padding: 0 !important;
        }

        .select2-selection__choice__remove {
            margin-left: 0 !important;
        }

        .select2-selection__choice__display {
            padding-left: 23px !important;
        }

        .select2-selection__choice__remove .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            height: 40px !important;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        @media print {
            body {
                margin: 0 !important;
            }
        }

        .main-container {
            font-family: "Montserrat", serif;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .ck-content {
            font-family: "Montserrat", serif;
            line-height: 1.6;
            word-break: break-word;
        }

        .editor-container_classic-editor .editor-container__editor {
            min-width: 100%;

        }



        .editor_container__word-count .ck-word-count {
            color: var(--ck-color-text);
            display: flex;
            height: 20px;
            gap: var(--ck-spacing-small);
            justify-content: flex-end;
            font-size: var(--ck-font-size-base);
            line-height: var(--ck-line-height-base);
            font-family: var(--ck-font-face);
            padding: var(--ck-spacing-small) var(--ck-spacing-standard);
        }

        .editor-container_include-word-count.editor-container_classic-editor .editor_container__word-count {
            border: 1px solid var(--ck-color-base-border);
            border-radius: var(--ck-border-radius);
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-top: none;
        }

        .editor-container_include-word-count.editor-container_classic-editor .editor-container__editor .ck-editor .ck-editor__editable {
            border-radius: 0;
        }

        .dropzone-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .input-group-text {
            padding-left: 8px;
            padding-right: 8px;
            padding-top: unset;
            padding-bottom: unset;
        }




        .autocomplete-container {
            position: relative;
            width: 100%;
        }

        .input-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;

            gap: 5px;
            box-sizing: border-box;
            cursor: text;
        }

        .input-wrapper input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 100px;
            font-size: 16px;
            padding: 5px;
        }

        .input-wrapper-tag {
            display: flex;
            flex-wrap: wrap;
            align-items: center;

            gap: 5px;
            box-sizing: border-box;
            cursor: text;
        }

        .input-wrapper-tag input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 100px;
            font-size: 16px;
            padding: 5px;
        }

        .tag {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 14px;
        }

        .tag .remove-tag {
            margin-left: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .tag .remove-tag:hover {
            color: #ff4d4d;
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            border-radius: 0 0 4px 4px;
        }

        .dropdown div {
            padding: 10px;
            cursor: pointer;
        }

        .dropdown div:hover {
            background-color: #f0f0f0;
        }

        .dropdown div.active {
            background-color: #007bff;
            color: white;
        }

        .dropdown div:not(:last-child) {
            border-bottom: 1px solid #eee;
        }

        .btn-info:hover {
            color: #ccc;
        }


        .select2-selection__rendered {
            display: flex !important;
            height: 100%;
            width: 100%;
        }

        .custom-select-brand .select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div _ngcontent-ng-c1743930539="" class="container-fluid">
        <div _ngcontent-ng-c1743930539="" class="row">
            <div _ngcontent-ng-c1743930539="" class="col-sm-12">
                <div _ngcontent-ng-c1743930539="" class="card">
                    <div _ngcontent-ng-c1743930539="" class="card-body">
                        <div _ngcontent-ng-c1743930539="" class="title-header">
                            <div _ngcontent-ng-c1743930539="" class="d-flex align-items-center">
                                <h5 _ngcontent-ng-c1743930539="">Add Product</h5>
                            </div>
                        </div><!----><app-form-product _ngcontent-ng-c3760920984="" _nghost-ng-c4139701631="">
                            <form _ngcontent-ng-c4139701631="" novalidate=""
                                class="theme-form theme-form-2 mega-form ng-untouched ng-pristine ng-invalid">
                                <div _ngcontent-ng-c4139701631="" class="vertical-tabs">
                                    <div _ngcontent-ng-c4139701631="" class="row">
                                        <div _ngcontent-ng-c4139701631="" class="col-xl-3 col-lg-4">
                                            <ul _ngcontent-ng-c4139701631="" ngbnav="" orientation="vertical"
                                                class="nav nav-pills flex-column">
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="general" id="general"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link active " style="cursor: pointer"
                                                        data-tab="ngb-nav-0" aria-controls="ngb-nav-0-panel"
                                                        aria-selected="true" aria-disabled="false"><i
                                                            _ngcontent-ng-c4139701631=""
                                                            class="ri-settings-line"></i>General</div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="inventory" id="inventory"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-1"
                                                        aria-controls="ngb-nav-1-panel" aria-selected="false"
                                                        aria-disabled="false" tabindex="-1"><i _ngcontent-ng-c4139701631=""
                                                            class="ri-file-list-line"></i>Inventory</div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="setup" id="setup"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-2"
                                                        aria-controls="ngb-nav-2-panel" aria-selected="false"
                                                        aria-disabled="false" tabindex="-1"><i _ngcontent-ng-c4139701631=""
                                                            class="ri-tools-line"></i>setup
                                                    </div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="images" id="images"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-3"
                                                        tabindex="-1" aria-controls="ngb-nav-3-panel"
                                                        aria-selected="false" aria-disabled="false"><i
                                                            _ngcontent-ng-c4139701631="" class="ri-image-line"></i>Images
                                                    </div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="seo" id="seo"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-4"
                                                        tabindex="-1" aria-controls="ngb-nav-4-panel"
                                                        aria-selected="false" aria-disabled="false"><i
                                                            _ngcontent-ng-c4139701631="" class="ri-earth-line"></i>SEO
                                                    </div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="shipping" id="shipping"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-5"
                                                        tabindex="-1" aria-controls="ngb-nav-5-panel"
                                                        aria-selected="false" aria-disabled="false"><i
                                                            _ngcontent-ng-c4139701631=""
                                                            class="ri-truck-line"></i>Shipping &amp; Tax</div><!---->
                                                </li>
                                                <li _ngcontent-ng-c4139701631="" ngbnavitem="status" id="status"
                                                    class="nav-item">
                                                    <div _ngcontent-ng-c4139701631="" href="" ngbnavlink=""
                                                        class="nav-link " style="cursor: pointer" data-tab="ngb-nav-6"
                                                        tabindex="-1" aria-controls="ngb-nav-6-panel"
                                                        aria-selected="false" aria-disabled="false"><i
                                                            _ngcontent-ng-c4139701631=""
                                                            class="ri-checkbox-circle-line"></i>Status</div><!---->
                                                </li>
                                            </ul>
                                        </div>
                                        <div _ngcontent-ng-c4139701631="" class="col-xl-9 col-lg-8">
                                            <div _ngcontent-ng-c4139701631="" class="tab-content">
                                                <div ngbnavpane="" class="tab-pane fade active show" id="ngb-nav-0"
                                                    aria-labelledby="ngb-nav-0">
                                                    <div _ngcontent-ng-c4139701631="" tab="general" class="tab">

                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="name">
                                                                    Tên sản phẩm<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9"><input
                                                                        _ngcontent-ng-c4139701631="" id="name"
                                                                        type="text" formcontrolname="name"
                                                                        class="form-control ng-untouched ng-pristine ng-invalid"
                                                                        placeholder="Nhập tên sản phẩm"
                                                                        fdprocessedid="nobit"><!----></div>
                                                            </div>
                                                        </app-form-fields>
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="name">
                                                                    Slug<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9"><input
                                                                        _ngcontent-ng-c4139701631="" id="name"
                                                                        type="text" formcontrolname="name"
                                                                        class="form-control ng-untouched ng-pristine ng-invalid"
                                                                        placeholder="Slug" fdprocessedid="nobit"><!---->
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="name">
                                                                    Link sản phẩm<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9"><input
                                                                        _ngcontent-ng-c4139701631="" id="name"
                                                                        type="text" formcontrolname="name"
                                                                        class="form-control ng-untouched ng-pristine ng-invalid"
                                                                        placeholder="Link sản phẩm"
                                                                        fdprocessedid="nobit"><!----></div>
                                                            </div>
                                                        </app-form-fields>
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="short_description">Mô tả ngắn sản phẩm<span
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <textarea _ngcontent-ng-c4139701631="" id="sort_description" rows="3" formcontrolname="short_description"
                                                                        class="form-control ng-untouched ng-pristine ng-invalid" placeholder="Nhập mô tả ngắn sản phẩm"></textarea>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="description">Mô tả sản phẩm<span
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div class="">
                                                                    <div class="editor-container editor-container_classic-editor editor-container_include-word-count"
                                                                        id="editor-container">
                                                                        <div class="editor-container__editor">
                                                                            <div id="editor"></div>
                                                                        </div>
                                                                        <div class="editor_container__word-count"
                                                                            id="editor-word-count"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="store">
                                                                    Hãng<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <select2 _ngcontent-ng-c4139701631=""
                                                                        formcontrolname="store_id" id="store_id"
                                                                        resettable=""
                                                                        class="custom-select custom-select-brand ng-untouched ng-pristine ng-invalid"
                                                                        _nghost-ng-c3374597708="" aria-invalid="false">
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2-label"><!----></div>
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                cdkoverlayorigin="" class="selection"
                                                                                tabindex="0">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    role="combobox"
                                                                                    class="select2-selection select2-selection--single">

                                                                                    <select class="brand-select"
                                                                                        placeholder="Select Attribute">
                                                                                    </select>

                                                                                </div>
                                                                            </div>

                                                                        </div><!----><!---->
                                                                    </select2><!---->
                                                                </div>
                                                            </div>
                                                        </app-form-fields><!---->


                                                        <div class="text-center mt-5">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#specModalTechnicalData">
                                                                Thêm Thông số kỹ thuật
                                                            </button>
                                                        </div>

                                                        <div class="modal fade" id="specModalTechnicalData"
                                                            tabindex="-1" aria-labelledby="specModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="specModalLabel">Thông
                                                                            số kỹ thuật</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Bảng thông số kỹ thuật -->
                                                                        <div class="specifi-box border-top">
                                                                            <div id="specifis-card" style="display: none">

                                                                                <div id="specifis-section">
                                                                                    <!-- specifi container -->
                                                                                    <div class="specifi-container">
                                                                                        <div class="specifi-inputs">
                                                                                            <select
                                                                                                class="attribute-specifis-select"
                                                                                                placeholder="Select Attribute">
                                                                                            </select>
                                                                                            <select
                                                                                                class="value-specifis-select"
                                                                                                multiple="multiple"
                                                                                                placeholder="Select Values">
                                                                                            </select>
                                                                                            <span
                                                                                                class="remove-specifi">Remove</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div
                                                                                    class="d-flex flex-row gap-3 align-items-center mb-2">
                                                                                    <button id="add-specifi-btn"
                                                                                        class="btn btn-primary">Add
                                                                                        specifi</button>

                                                                                </div>

                                                                                <div id="generated-specifis"></div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Đóng</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!---->
                                                </div><!---->
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-1"
                                                    aria-labelledby="ngb-nav-1">
                                                    <div _ngcontent-ng-c4139701631="" tab="inventory" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="type">
                                                                    Loại sản phẩm<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <select2 _ngcontent-ng-c4139701631=""
                                                                        formcontrolname="type"
                                                                        class="custom-select ng-untouched ng-pristine ng-valid"
                                                                        _nghost-ng-c3374597708="" id="select2-1"
                                                                        aria-invalid="false">
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2-label"><!----></div>
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                cdkoverlayorigin="" class="selection"
                                                                                tabindex="0">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    role="combobox"
                                                                                    class="select2-selection select2-selection--single">
                                                                                    <select name="product_type"
                                                                                        id="product_type"
                                                                                        style="width: 100%; padding-left: unset !important; border: unset">
                                                                                        <option value="single">Sản phẩm đơn
                                                                                        </option>
                                                                                        <option value="variant">Sản phẩm
                                                                                            biến thế
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div><!----><!---->
                                                                    </select2><!---->
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="sku">
                                                                    SKU<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9"><input
                                                                        _ngcontent-ng-c4139701631="" id="sku"
                                                                        type="text" formcontrolname="sku"
                                                                        class="form-control ng-untouched ng-pristine ng-invalid"
                                                                        placeholder="Enter SKU"><!----></div>
                                                            </div>
                                                            <app-form-fields _ngcontent-ng-c4139701631=""
                                                                _nghost-ng-c1578356246="">
                                                                <div _ngcontent-ng-c1578356246=""
                                                                    class="align-items-center g-2 mb-4 row"><label
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="col-sm-3 form-label-title mb-0"
                                                                        for="price">
                                                                        Giá<span _ngcontent-ng-c1578356246=""
                                                                            class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                    <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                        <div _ngcontent-ng-c4139701631=""
                                                                            class="input-group">
                                                                            <span _ngcontent-ng-c4139701631=""
                                                                                class="input-group-text"> $ </span><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                id="price" type="number"
                                                                                formcontrolname="price"
                                                                                class="form-control ng-untouched ng-pristine ng-invalid"
                                                                                placeholder="Nhập giá">
                                                                        </div><!----><!---->
                                                                    </div>
                                                                </div>
                                                            </app-form-fields><!----><app-form-fields
                                                                _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                                                <div _ngcontent-ng-c1578356246=""
                                                                    class="align-items-center g-2 mb-4 row"><label
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="col-sm-3 form-label-title mb-0"
                                                                        for="discount_value"> Giảm giá<!----></label>
                                                                    <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                        <div _ngcontent-ng-c4139701631=""
                                                                            class="input-group">
                                                                            <input _ngcontent-ng-c4139701631=""
                                                                                id="discount_value" type="number"
                                                                                min="0" max="100"
                                                                                oninput="if (value > 100) value = 100; if (value < 0) value = 0;"
                                                                                formcontrolname="discount"
                                                                                class="form-control ng-untouched ng-pristine ng-valid"
                                                                                placeholder="Enter discount"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </app-form-fields><!----><app-form-fields
                                                                _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                                                <div _ngcontent-ng-c1578356246=""
                                                                    class="align-items-center g-2 mb-4 row"><label
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="col-sm-3 form-label-title mb-0"
                                                                        for="sale_price">Giá sau giảm giá</label>
                                                                    <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                        <div _ngcontent-ng-c4139701631=""
                                                                            class="input-group">
                                                                            <span _ngcontent-ng-c4139701631=""
                                                                                class="input-group-text"> $ </span><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                id="sale_price" type="number"
                                                                                placeholder="Giá sau giảm giá"
                                                                                readonly=""
                                                                                class="form-control disabled">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </app-form-fields><!----><app-form-fields
                                                                _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                                                <div _ngcontent-ng-c1578356246=""
                                                                    class="align-items-center g-2 mb-4 row"><label
                                                                        _ngcontent-ng-c1578356246=""
                                                                        class="col-sm-3 form-label-title mb-0"
                                                                        for="is_sale_enable">Kích hoặt giảm giá</label>
                                                                    <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                        <div _ngcontent-ng-c4139701631=""
                                                                            class="form-check form-switch ps-0"><label
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch"><input
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    type="checkbox" id="is_sale_enable"
                                                                                    formcontrolname="is_sale_enable"
                                                                                    class="ng-untouched ng-pristine ng-valid"><span
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    class="switch-state"></span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </app-form-fields>
                                                            <div _ngcontent-ng-c4139701631="">
                                                                <app-form-fields _ngcontent-ng-c4139701631=""
                                                                    _nghost-ng-c1578356246="">
                                                                    <div _ngcontent-ng-c1578356246=""
                                                                        class="align-items-center g-2 mb-4 row"><label
                                                                            _ngcontent-ng-c1578356246=""
                                                                            class="col-sm-3 form-label-title mb-0"
                                                                            for="sale_starts_at">Bắt đầu giảm giá</label>
                                                                        <div _ngcontent-ng-c1578356246=""
                                                                            class="col-sm-9">
                                                                            <div _ngcontent-ng-c4139701631=""
                                                                                class="dp-hidden position-absolute custom-dp-dropdown">
                                                                                <div _ngcontent-ng-c4139701631=""
                                                                                    class="input-group"><input
                                                                                        _ngcontent-ng-c4139701631=""
                                                                                        name="datepicker" ngbdatepicker=""
                                                                                        outsidedays="hidden"
                                                                                        tabindex="-1" readonly=""
                                                                                        class="form-control"><!----><!---->
                                                                                </div>
                                                                            </div>
                                                                            <div _ngcontent-ng-c4139701631=""
                                                                                class="input-group custom-dt-picker"><input
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    placeholder="yyyy-mm-dd"
                                                                                    name="dpFromDate" readonly=""
                                                                                    class="form-control"><button
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    type="button"
                                                                                    class="btn btn-outline-secondary"><i
                                                                                        _ngcontent-ng-c4139701631=""
                                                                                        class="ri-calendar-line"></i></button>
                                                                            </div><!---->
                                                                        </div>
                                                                    </div>
                                                                </app-form-fields><app-form-fields
                                                                    _ngcontent-ng-c4139701631=""
                                                                    _nghost-ng-c1578356246="">
                                                                    <div _ngcontent-ng-c1578356246=""
                                                                        class="align-items-center g-2 mb-4 row"><label
                                                                            _ngcontent-ng-c1578356246=""
                                                                            class="col-sm-3 form-label-title mb-0"
                                                                            for="sale_expired_at">Kết thúc giảm giá</label>
                                                                        <div _ngcontent-ng-c1578356246=""
                                                                            class="col-sm-9">
                                                                            <div _ngcontent-ng-c4139701631=""
                                                                                class="input-group custom-dt-picker"><input
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    placeholder="yyyy-mm-dd"
                                                                                    name="dpToDate" readonly=""
                                                                                    class="form-control"><button
                                                                                    _ngcontent-ng-c4139701631=""
                                                                                    type="button"
                                                                                    class="btn btn-outline-secondary"><i
                                                                                        _ngcontent-ng-c4139701631=""
                                                                                        class="ri-calendar-line"></i></button>
                                                                            </div><!---->
                                                                        </div>
                                                                    </div>
                                                                </app-form-fields>
                                                            </div><!---->




                                                    </div><!---->

                                                    <div class="variant-box border-top">
                                                        <div id="variants-card" style="display: none">

                                                            <div id="variants-section">
                                                                <!-- Variant container -->
                                                                <div class="variant-container">
                                                                    <div class="variant-inputs">
                                                                        <select class="attribute-select"
                                                                            placeholder="Select Attribute">
                                                                        </select>
                                                                        <select class="value-select" multiple="multiple"
                                                                            placeholder="Select Values">
                                                                        </select>
                                                                        <span class="remove-variant">Remove</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex flex-row gap-3 align-items-center mb-2">
                                                                <button id="add-variant-btn" class="btn btn-primary">Add
                                                                    Variant</button>

                                                                <button id="generate-variants-btn"
                                                                    class="btn btn-info ml-3">Generate Variants</button>
                                                            </div>

                                                            <div id="generated-variants"></div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-2"
                                                    aria-labelledby="ngb-nav-2">
                                                    <div _ngcontent-ng-c4139701631="" tab="setup" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="tags">
                                                                    Tags<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">

                                                                </div>
                                                            </div>
                                                        </app-form-fields>

                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="categories">
                                                                    Categories<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <app-advanced-dropdown _ngcontent-ng-c4139701631=""
                                                                        _nghost-ng-c3485755482="" id="categories">
                                                                        <div _ngcontent-ng-c3485755482="">
                                                                            <div _ngcontent-ng-c3485755482=""
                                                                                class="position-relative">
                                                                                <nav _ngcontent-ng-c3485755482=""
                                                                                    class="category-breadcrumb-select">
                                                                                    <ol _ngcontent-ng-c3485755482=""
                                                                                        class="breadcrumb"><!---->
                                                                                        <li _ngcontent-ng-c3485755482=""
                                                                                            class="breadcrumb-item toggle-dropdown">
                                                                                            <a _ngcontent-ng-c3485755482=""
                                                                                                href="javascript:void(0)">Select
                                                                                                Option</a>
                                                                                        </li>
                                                                                        <!----><!---->
                                                                                    </ol>
                                                                                </nav><a _ngcontent-ng-c3485755482=""
                                                                                    class="cateogry-close-btn d-inline-block"><i
                                                                                        _ngcontent-ng-c3485755482=""
                                                                                        class="ri-arrow-down-s-line down-arrow"></i><i
                                                                                        _ngcontent-ng-c3485755482=""
                                                                                        class="ri-close-line close-arrow"></i></a>
                                                                                <div _ngcontent-ng-c3485755482=""
                                                                                    class="select-category-box mt-2 dropdown-open">
                                                                                    <input _ngcontent-ng-c3485755482=""
                                                                                        placeholder="Search here.."
                                                                                        class="form-control search-input ng-untouched ng-pristine ng-valid">
                                                                                    <div _ngcontent-ng-c3485755482=""
                                                                                        class="category-content">
                                                                                        <nav _ngcontent-ng-c3485755482=""
                                                                                            aria-label="breadcrumb"
                                                                                            class="category-breadcrumb">
                                                                                            <ol _ngcontent-ng-c3485755482=""
                                                                                                class="breadcrumb"><!---->
                                                                                                <li _ngcontent-ng-c3485755482=""
                                                                                                    class="breadcrumb-item">
                                                                                                    <a _ngcontent-ng-c3485755482=""
                                                                                                        href="javascript:void(0)">All</a>
                                                                                                </li><!----><!---->
                                                                                            </ol>
                                                                                        </nav>
                                                                                        <div _ngcontent-ng-c3485755482=""
                                                                                            class="category-listing">
                                                                                            <ul
                                                                                                _ngcontent-ng-c3485755482="">
                                                                                                <app-dropdown-list
                                                                                                    _ngcontent-ng-c3485755482=""
                                                                                                    _nghost-ng-c85607640="">
                                                                                                    <li
                                                                                                        _ngcontent-ng-c85607640="">
                                                                                                        Furnishing <a
                                                                                                            _ngcontent-ng-c85607640=""
                                                                                                            href="javascript:void(0)"
                                                                                                            class="select-btn">
                                                                                                            Select
                                                                                                        </a><!----></li>
                                                                                            </ul>
                                                                                        </div><!---->
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </app-advanced-dropdown><!---->
                                                                </div>

                                                                <script>
                                                                    // select option
                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        const toggleLink = document.querySelector('.toggle-dropdown');
                                                                        const closeBtn = document.querySelector('.cateogry-close-btn');
                                                                        const dropdownBox = document.querySelector('.select-category-box');
                                                                        const downArrow = closeBtn.querySelector('.down-arrow');
                                                                        const closeArrow = closeBtn.querySelector('.close-arrow');
                                                                        const breadcrumbPills = document.querySelector('.breadcrumb');
                                                                        const selectOptionItem = document.querySelector('.breadcrumb-item');
                                                                        let selectedItem = null;

                                                                        hideDropdown(); //ẩn load lần đầu

                                                                        function showDropdown() {
                                                                            dropdownBox.style.display = 'block';
                                                                            downArrow.style.display = 'none';
                                                                            closeArrow.style.display = 'inline-block';
                                                                        }

                                                                        function hideDropdown() {
                                                                            dropdownBox.style.display = 'none';
                                                                            downArrow.style.display = 'inline-block';
                                                                            closeArrow.style.display = 'none';
                                                                        }

                                                                        // Click mũi tên 
                                                                        const rightArrows = document.querySelectorAll('.right-arrow');
                                                                        rightArrows.forEach(arrow => {
                                                                            arrow.addEventListener('click', function(e) {
                                                                                e.preventDefault();
                                                                                const categoryName = this.closest('li').firstChild.textContent.trim();

                                                                                // Add > tendanhmuc
                                                                                const breadcrumbNav = document.querySelector(
                                                                                    '.category-breadcrumb .breadcrumb');
                                                                                const newCategoryItem = document.createElement('li');
                                                                                newCategoryItem.classList.add('breadcrumb-item', 'inserted');
                                                                                newCategoryItem.innerHTML = `<a href="javascript:void(0)">${categoryName}</a>`;
                                                                                breadcrumbNav.appendChild(newCategoryItem);

                                                                                // các danh mục con cho danh mục đã chọn
                                                                                // loadSubcategories(categoryName);
                                                                            });
                                                                        });

                                                                        // Click all
                                                                        document.querySelector('.category-breadcrumb').addEventListener('click', function(e) {
                                                                            if (e.target.textContent.trim() === 'All') {
                                                                                // Xóa sau all
                                                                                const breadcrumbItems = document.querySelectorAll(
                                                                                    '.category-breadcrumb .breadcrumb-item');
                                                                                breadcrumbItems.forEach((item, index) => {
                                                                                    if (index > breadcrumbItems.length - 2) { // Giữu all xóa còn lại
                                                                                        item.remove();
                                                                                    }
                                                                                });

                                                                                // Danh muc chính
                                                                                // loadMainCategories();
                                                                            }
                                                                        });

                                                                        // Hiện dropdown
                                                                        toggleLink.addEventListener('click', (e) => {
                                                                            e.preventDefault();
                                                                            console.log("!@3");
                                                                            if (dropdownBox.style.display === 'block') {
                                                                                hideDropdown();
                                                                            } else {
                                                                                showDropdown();
                                                                            }
                                                                        });

                                                                        closeBtn.addEventListener('click', (e) => {
                                                                            e.stopPropagation();
                                                                            if (dropdownBox.style.display === 'block') {
                                                                                hideDropdown();
                                                                            } else {
                                                                                showDropdown();
                                                                            }
                                                                        });

                                                                        document.addEventListener('click', (e) => {
                                                                            if (!dropdownBox.contains(e.target) && !toggleLink.contains(e.target) && !closeBtn.contains(
                                                                                    e.target)) {
                                                                                hideDropdown();
                                                                            }
                                                                        });

                                                                        // Nút chọn
                                                                        const selectButtons = document.querySelectorAll('.select-btn');
                                                                        selectButtons.forEach(button => {
                                                                            button.addEventListener('click', function() {
                                                                                if (selectedItem) {
                                                                                    selectedItem.classList.remove('selected');
                                                                                    breadcrumbPills.querySelector('.breadcrumb-pills')?.remove();
                                                                                }

                                                                                button.classList.add('selected');
                                                                                selectedItem = button;

                                                                                const selectedText = button.closest('li').firstChild.textContent.trim();

                                                                                const breadcrumbItem = document.createElement('li');
                                                                                breadcrumbItem.classList.add('breadcrumb-pills', 'inserted');
                                                                                breadcrumbItem.innerHTML = `<span class="badge badge-pill badge-primary">${selectedText}
                        <i class="ri-close-line remove-pill"></i></span>`;
                                                                                breadcrumbPills.prepend(breadcrumbItem);

                                                                                selectOptionItem.style.display = 'none';
                                                                                hideDropdown();

                                                                                breadcrumbItem.querySelector('.remove-pill').addEventListener('click',
                                                                                    function() {
                                                                                        breadcrumbItem.remove();
                                                                                        selectedItem.classList.remove('selected');
                                                                                        selectedItem = null;
                                                                                        selectOptionItem.style.display = 'block';
                                                                                    });
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>
                                                        </app-form-fields>








                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="is_random_related_products"> Random Related
                                                                    Product<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox"
                                                                                id="is_random_related_products"
                                                                                formcontrolname="is_random_related_products"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631="" class="help-text">
                                                                            *Enabling this option allows
                                                                            the backend to randomly select 6 products for
                                                                            display.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="related_product_id"> Related
                                                                    Products<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <select2 _ngcontent-ng-c4139701631=""
                                                                        formcontrolname="related_products"
                                                                        class="custom-select ng-untouched ng-pristine ng-valid"
                                                                        _nghost-ng-c3374597708="" id="select2-4"
                                                                        aria-invalid="false">
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2-label"><!----></div>
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                cdkoverlayorigin="" class="selection"
                                                                                tabindex="0">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    role="combobox"
                                                                                    class="select2-selection select2-selection--multiple">
                                                                                    <!----><!----><!---->
                                                                                    <ul _ngcontent-ng-c3374597708=""
                                                                                        class="select2-selection__rendered">
                                                                                        <span _ngcontent-ng-c3374597708=""
                                                                                            class="select2-selection__placeholder">Select
                                                                                            Product</span><!---->
                                                                                    </ul>
                                                                                    <!---->
                                                                                </div>
                                                                            </div>
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-container select2-container--default select2-container-dropdown">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    class="select2-dropdown select2-dropdown--below">
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-search select2-search--dropdown">
                                                                                        <input _ngcontent-ng-c3374597708=""
                                                                                            type="search" role="textbox"
                                                                                            autocomplete="off"
                                                                                            autocorrect="off"
                                                                                            autocapitalize="off"
                                                                                            spellcheck="false"
                                                                                            class="select2-search__field"
                                                                                            id="select2-4-search-field"
                                                                                            tabindex="-1">
                                                                                    </div>
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-results">
                                                                                        <ul _ngcontent-ng-c3374597708=""
                                                                                            role="tree" tabindex="-1"
                                                                                            infinitescroll=""
                                                                                            class="select2-results__options"
                                                                                            style="max-height: 200px;">
                                                                                            <!---->
                                                                                            <li _ngcontent-ng-c3374597708=""
                                                                                                class="select2-no-result select2-results__option">
                                                                                                No Data Found.</li>
                                                                                            <!----><!---->
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!----><!----><!---->
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-subscript-wrapper"></div>
                                                                        </div><!----><!---->
                                                                    </select2>
                                                                    <p _ngcontent-ng-c4139701631="" class="help-text">
                                                                        *Choose a maximum of 6 products for effective
                                                                        related products display.</p>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><!----><app-form-fields
                                                            _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="cross_sell_products"> Cross Sell
                                                                    Products<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <select2 _ngcontent-ng-c4139701631=""
                                                                        formcontrolname="cross_sell_products"
                                                                        class="custom-select ng-untouched ng-pristine ng-valid"
                                                                        _nghost-ng-c3374597708="" id="select2-3"
                                                                        aria-invalid="false">
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2-label"><!----></div>
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                cdkoverlayorigin="" class="selection"
                                                                                tabindex="0">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    role="combobox"
                                                                                    class="select2-selection select2-selection--multiple">
                                                                                    <!----><!----><!---->
                                                                                    <ul _ngcontent-ng-c3374597708=""
                                                                                        class="select2-selection__rendered">
                                                                                        <span _ngcontent-ng-c3374597708=""
                                                                                            class="select2-selection__placeholder">Select
                                                                                            Product</span><!---->
                                                                                    </ul>
                                                                                    <!---->
                                                                                </div>
                                                                            </div>
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-container select2-container--default select2-container-dropdown">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    class="select2-dropdown select2-dropdown--below">
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-search select2-search--dropdown">
                                                                                        <input _ngcontent-ng-c3374597708=""
                                                                                            type="search" role="textbox"
                                                                                            autocomplete="off"
                                                                                            autocorrect="off"
                                                                                            autocapitalize="off"
                                                                                            spellcheck="false"
                                                                                            class="select2-search__field"
                                                                                            id="select2-3-search-field"
                                                                                            tabindex="-1">
                                                                                    </div>
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-results">
                                                                                        <ul _ngcontent-ng-c3374597708=""
                                                                                            role="tree" tabindex="-1"
                                                                                            infinitescroll=""
                                                                                            class="select2-results__options"
                                                                                            style="max-height: 200px;">
                                                                                            <!---->
                                                                                            <li _ngcontent-ng-c3374597708=""
                                                                                                class="select2-no-result select2-results__option">
                                                                                                No Data Found.</li>
                                                                                            <!----><!---->
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!----><!----><!---->
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-subscript-wrapper"></div>
                                                                        </div><!----><!---->
                                                                    </select2>
                                                                    <p _ngcontent-ng-c4139701631="" class="help-text">
                                                                        *Choose a maximum of 3 products for effective
                                                                        cross-selling display.</p>
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><!---->
                                                </div>
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-3"
                                                    aria-labelledby="ngb-nav-3">
                                                    <div _ngcontent-ng-c4139701631="" tab="images" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="product_thumbnail_id">
                                                                    Thumbnail<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <app-image-upload _ngcontent-ng-c4139701631=""
                                                                        _nghost-ng-c3000554265="">
                                                                        <ul _ngcontent-ng-c3000554265=""
                                                                            class="image-select-list cursor-pointer">
                                                                            <li _ngcontent-ng-c3000554265=""
                                                                                class="choosefile-input"><i
                                                                                    _ngcontent-ng-c3000554265=""
                                                                                    class="ri-add-line"></i></li>
                                                                            <!----><!----><!---->
                                                                        </ul>
                                                                        <p _ngcontent-ng-c3000554265="" class="help-text">
                                                                            *Upload image size 600x600px
                                                                            recommended</p><!----><app-media-modal
                                                                            _ngcontent-ng-c3000554265=""
                                                                            _nghost-ng-c729472833=""><!----></app-media-modal>
                                                                    </app-image-upload>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="product_galleries_id"> Images<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <app-image-upload _ngcontent-ng-c4139701631=""
                                                                        _nghost-ng-c3000554265="">
                                                                        <ul _ngcontent-ng-c3000554265=""
                                                                            class="image-select-list cursor-pointer">
                                                                            <li _ngcontent-ng-c3000554265=""
                                                                                class="choosefile-input"><i
                                                                                    _ngcontent-ng-c3000554265=""
                                                                                    class="ri-add-line"></i></li>
                                                                            <!----><!----><!---->
                                                                        </ul>
                                                                        <p _ngcontent-ng-c3000554265="" class="help-text">
                                                                            *Upload image size 600x600px
                                                                            recommended</p><!----><app-media-modal
                                                                            _ngcontent-ng-c3000554265=""
                                                                            _nghost-ng-c729472833=""><!----></app-media-modal>
                                                                    </app-image-upload>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="size_chart_image_id"> Size
                                                                    Chart<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <app-image-upload _ngcontent-ng-c4139701631=""
                                                                        _nghost-ng-c3000554265="">
                                                                        <ul _ngcontent-ng-c3000554265=""
                                                                            class="image-select-list cursor-pointer">
                                                                            <li _ngcontent-ng-c3000554265=""
                                                                                class="choosefile-input"><i
                                                                                    _ngcontent-ng-c3000554265=""
                                                                                    class="ri-add-line"></i></li>
                                                                            <!----><!----><!---->
                                                                        </ul>
                                                                        <p _ngcontent-ng-c3000554265="" class="help-text">
                                                                            *Upload an image showcasing
                                                                            the size chart tailored for fashion
                                                                            products. A
                                                                            table format image is suggested for easy
                                                                            reference.</p><!----><app-media-modal
                                                                            _ngcontent-ng-c3000554265=""
                                                                            _nghost-ng-c729472833=""><!----></app-media-modal>
                                                                    </app-image-upload>
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><!---->
                                                </div><!---->
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-4"
                                                    aria-labelledby="ngb-nav-4">
                                                    <div _ngcontent-ng-c4139701631="" tab="seo" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="meta_title">
                                                                    Meta Title<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <input _ngcontent-ng-c4139701631="" id="meta_title"
                                                                        type="text" formcontrolname="meta_title"
                                                                        class="form-control ng-untouched ng-pristine ng-valid"
                                                                        placeholder="Enter meta title">
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="meta_desc">
                                                                    Meta Description<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <textarea _ngcontent-ng-c4139701631="" id="meta_desc" rows="3" formcontrolname="meta_description"
                                                                        class="form-control ng-untouched ng-pristine ng-valid" placeholder="Enter meta description"></textarea>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="meta_image">
                                                                    Meta Image<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <app-image-upload _ngcontent-ng-c4139701631=""
                                                                        _nghost-ng-c3000554265="">
                                                                        <ul _ngcontent-ng-c3000554265=""
                                                                            class="image-select-list cursor-pointer">
                                                                            <li _ngcontent-ng-c3000554265=""
                                                                                class="choosefile-input"><i
                                                                                    _ngcontent-ng-c3000554265=""
                                                                                    class="ri-add-line"></i></li>
                                                                            <!----><!----><!---->
                                                                        </ul><!----><app-media-modal
                                                                            _ngcontent-ng-c3000554265=""
                                                                            _nghost-ng-c729472833=""><!----></app-media-modal>
                                                                    </app-image-upload>
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><!---->
                                                </div><!---->
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-5"
                                                    aria-labelledby="ngb-nav-5">
                                                    <div _ngcontent-ng-c4139701631="" tab="shipping" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="free_shipping"> Free Shipping<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="free_shipping"
                                                                                formcontrolname="is_free_shipping"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0" for="tax">
                                                                    Tax<span _ngcontent-ng-c1578356246=""
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <select2 _ngcontent-ng-c4139701631=""
                                                                        formcontrolname="tax_id" resettable=""
                                                                        class="custom-select ng-untouched ng-pristine ng-invalid"
                                                                        _nghost-ng-c3374597708="" id="tax_id"
                                                                        aria-invalid="false">
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2-label"><!----></div>
                                                                        <div _ngcontent-ng-c3374597708=""
                                                                            class="select2 select2-container select2-container--default select2-container--focus select2-container--below">
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                cdkoverlayorigin="" class="selection"
                                                                                tabindex="0">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    role="combobox"
                                                                                    class="select2-selection select2-selection--single">
                                                                                    <span _ngcontent-ng-c3374597708=""
                                                                                        class="select2-selection__rendered"
                                                                                        title=""><span
                                                                                            _ngcontent-ng-c3374597708="">&nbsp;</span><!----><!----><span
                                                                                            _ngcontent-ng-c3374597708=""
                                                                                            class="select2-selection__placeholder">Select
                                                                                            Tax</span></span><!----><!----><span
                                                                                        _ngcontent-ng-c3374597708=""
                                                                                        role="presentation"
                                                                                        class="select2-selection__arrow"></span><!----><!---->
                                                                                </div>
                                                                            </div>
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-container select2-container--default select2-container-dropdown">
                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                    class="select2-dropdown select2-dropdown--below">
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-search select2-search--dropdown select2-search--hide">
                                                                                        <input _ngcontent-ng-c3374597708=""
                                                                                            type="search" role="textbox"
                                                                                            autocomplete="off"
                                                                                            autocorrect="off"
                                                                                            autocapitalize="off"
                                                                                            spellcheck="false"
                                                                                            class="select2-search__field"
                                                                                            id="tax_id-search-field"
                                                                                            tabindex="-1">
                                                                                    </div>
                                                                                    <div _ngcontent-ng-c3374597708=""
                                                                                        class="select2-results">
                                                                                        <ul _ngcontent-ng-c3374597708=""
                                                                                            role="tree" tabindex="-1"
                                                                                            infinitescroll=""
                                                                                            class="select2-results__options"
                                                                                            style="max-height: 200px;">
                                                                                            <!---->
                                                                                            <li _ngcontent-ng-c3374597708=""
                                                                                                role="treeitem"
                                                                                                class="select2-results__option select2-results__option--highlighted"
                                                                                                id="tax_id-option-0"
                                                                                                aria-selected="false"
                                                                                                aria-disabled="false">
                                                                                                <div _ngcontent-ng-c3374597708=""
                                                                                                    class="select2-label-content">
                                                                                                    Sales Tax</div>
                                                                                                <!----><!---->
                                                                                            </li>
                                                                                            <!----><!----><!----><!----><!---->
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!----><!----><!---->
                                                                            <div _ngcontent-ng-c3374597708=""
                                                                                class="select2-subscript-wrapper">
                                                                            </div>
                                                                        </div><!----><!---->
                                                                    </select2><!---->
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="estimated_delivery_text"> Estimated Delivery
                                                                    Text<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <input _ngcontent-ng-c4139701631=""
                                                                        id="estimated_delivery_text" type="text"
                                                                        formcontrolname="estimated_delivery_text"
                                                                        class="form-control ng-untouched ng-pristine ng-valid"
                                                                        placeholder="Enter Estimated Delivery Text">
                                                                    <p _ngcontent-ng-c4139701631="" class="help-text">
                                                                        *Specify delivery text e.g Your order is likely
                                                                        to
                                                                        reach you within 5 to 10 days.</p>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="return_policy_text"> Return Policy
                                                                    Text<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <input _ngcontent-ng-c4139701631=""
                                                                        id="return_policy_text" type="text"
                                                                        formcontrolname="return_policy_text"
                                                                        class="form-control ng-untouched ng-pristine ng-valid"
                                                                        placeholder="Enter Return Policy Text">
                                                                    <p _ngcontent-ng-c4139701631="" class="help-text">
                                                                        *Specify return text e.g Hassle free 7, 15 and
                                                                        30
                                                                        days return might be available.</p>
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><!---->
                                                </div><!---->
                                                <div ngbnavpane="" class="tab-pane fade" id="ngb-nav-6"
                                                    aria-labelledby="ngb-nav-6">
                                                    <div _ngcontent-ng-c4139701631="" tab="status" class="tab">
                                                        <app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="product_featured"> Featured<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="product_featured"
                                                                                formcontrolname="is_featured"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *Enabling this option will
                                                                            display a Featured tag on the product.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="safe_checkout"> Safe checkout<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="safe_checkout"
                                                                                formcontrolname="safe_checkout"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">*A
                                                                            safe checkout image will
                                                                            appear on the product page. Modify the image
                                                                            in
                                                                            the theme options.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="secure_checkout"> Secure
                                                                    checkout<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="secure_checkout"
                                                                                formcontrolname="secure_checkout"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">*A
                                                                            secure checkout image
                                                                            will appear on the product page. Modify the
                                                                            image in the theme options.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="social_share"> Social share<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="social_share"
                                                                                formcontrolname="social_share"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *Enable this option to allow
                                                                            users to share the product on social media
                                                                            platforms.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="encourage_order"> Encourage
                                                                    order<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="encourage_order"
                                                                                formcontrolname="encourage_order"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">*A
                                                                            random order count
                                                                            between 1 and 100 will be displayed to
                                                                            motivate
                                                                            user purchases.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="encourage_view"> Encourage
                                                                    view<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="encourage_view"
                                                                                formcontrolname="encourage_view"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *this feature encourages
                                                                            users to view products by presenting
                                                                            engaging
                                                                            content or prompts.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="is_trending"> trending<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="is_trending"
                                                                                formcontrolname="is_trending"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *Enabling this will showcase
                                                                            the product in the sidebar of the product
                                                                            page
                                                                            as a trending item.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="return">
                                                                    return<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="return"
                                                                                formcontrolname="is_return"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *Enable to make the product
                                                                            eligible for returns.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields _ngcontent-ng-c4139701631=""
                                                            _nghost-ng-c1578356246="">
                                                            <div _ngcontent-ng-c1578356246=""
                                                                class="align-items-center g-2 mb-4 row"><label
                                                                    _ngcontent-ng-c1578356246=""
                                                                    class="col-sm-3 form-label-title mb-0"
                                                                    for="status">
                                                                    Status<!----></label>
                                                                <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                                    <div _ngcontent-ng-c4139701631=""
                                                                        class="form-check form-switch ps-0"><label
                                                                            _ngcontent-ng-c4139701631=""
                                                                            class="switch"><input
                                                                                _ngcontent-ng-c4139701631=""
                                                                                type="checkbox" id="status"
                                                                                formcontrolname="status"
                                                                                class="ng-untouched ng-pristine ng-valid"><span
                                                                                _ngcontent-ng-c4139701631=""
                                                                                class="switch-state"></span></label>
                                                                        <p _ngcontent-ng-c4139701631=""
                                                                            class="help-text">
                                                                            *Toggle between Enabled and
                                                                            Disabled to control the availability of the
                                                                            product for purchase.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><!---->
                                                </div><!----><!---->
                                            </div>
                                        </div>
                                    </div><app-button _ngcontent-ng-c4139701631="" _nghost-ng-c3686270073=""><button
                                            _ngcontent-ng-c3686270073="" class="btn btn-theme ms-auto mt-4"
                                            id="product_btn" type="submit" fdprocessedid="hlbg1j">
                                            <div _ngcontent-ng-c3686270073=""> Save Product </div>
                                        </button></app-button>
                                </div>
                            </form>
                        </app-form-product>
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
    <script src="/theme/admin/assets/js/ckeditor.js"></script>
    <script src="/theme/admin/assets/js/ckeditor-custom.js"></script>

    <!-- select2 js -->
    <script src="/theme/admin/assets/js/select2.min.js"></script>
    <script src="/theme/admin/assets/js/select2-custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Thêm thư viện Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            const attributeData = ["Liter", "Waist", "Size"];

            // Populate attributes dropdown
            function populateBrand(selectElement) {
                selectElement.empty();
                selectElement.append('<option></option>'); // Placeholder
                for (const attribute in attributeData) {
                    selectElement.append(
                        `<option value="${attributeData[attribute]}">${attributeData[attribute]}</option>`);
                }
            }






            // Initialize the first attribute select
            populateBrand($('.brand-select'));
            $('.brand-select').select2({
                placeholder: "Chọn Hãng"
            });


            // Xử lý khi click vào tab
            $('.nav-link').click(function() {
                // Bỏ class 'active' khỏi tất cả các nav-link
                $('.nav-link').removeClass('active');
                // Thêm class 'active' vào nav-link hiện tại
                $(this).addClass('active');

                // Lấy ID của nội dung cần hiển thị
                const nav_linkId = $(this).data('tab');;

                // Ẩn tất cả nội dung của các nav-link
                $('.tab-pane').removeClass('active show');
                // Hiển thị nội dung của tab được chọn
                $(`#${nav_linkId}`).addClass('active show');
            });

            $('#product_type').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue === 'single') {
                    $('#variants-card').hide();

                } else if (selectedValue === 'variant') {
                    $('#variants-card').show();
                }
            });

        });

        const attributeData = {
            Liter: ['5 Liter', '10 Liter', '20 Liter'],
            Waist: ['30', '32', '34'],
            Size: ['S', 'M', 'L', 'XL'],
        };

        // Populate attributes dropdown
        function populateAttributes(selectElement) {
            selectElement.empty();
            selectElement.append('<option></option>'); // Placeholder
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

        // Initialize the first attribute select
        populateAttributes($('.attribute-select'));
        $('.attribute-select').select2({
            placeholder: "Select Attribute"
        });
        $('.value-select').select2({
            placeholder: "Select Values"
        });

        // On attribute change, update values
        $('.attribute-select').on('change', function() {
            const attribute = $(this).val();
            const valueSelect = $(this).closest('.variant-inputs').find('.value-select');
            populateValues(valueSelect, attribute);
        });

        // Add Variant
        $('#add-variant-btn').on('click', function(e) {
            e.preventDefault();
            const variantContainer = `
                                      <div class="variant-container">
                                        <div class="variant-inputs">
                                          <select class="attribute-select" placeholder="Select Attribute"></select>
                                          <select class="value-select" multiple="multiple" placeholder="Select Values"></select>
                                          <span class="remove-variant">Remove</span>
                                        </div>
                                      </div>
                                    `;
            $('#variants-section').append(variantContainer);

            const newAttributeSelect = $(
                '#variants-section .variant-container:last-child .attribute-select');
            const newValueSelect = $('#variants-section .variant-container:last-child .value-select');

            populateAttributes(newAttributeSelect);
            newAttributeSelect.select2({
                placeholder: "Select Attribute"
            });
            newValueSelect.select2({
                placeholder: "Select Values"
            });

            // On attribute change, update values
            newAttributeSelect.on('change', function() {
                const attribute = $(this).val();
                populateValues(newValueSelect, attribute);
            });
        });

        // Remove a Variant
        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.variant-container').remove();
        });

        // Generate Variants
        // Generate Variants
        $('#generate-variants-btn').on('click', function(e) {
            e.preventDefault();

            console.log('Generating Variants...');

            const attributes = [];

            // Collect all attributes and their values
            $('#variants-section .variant-container').each(function() {
                const attribute = $(this).find('.attribute-select option:selected').text();
                const values = $(this).find('.value-select').val();
                if (attribute && values && values.length > 0) {
                    attributes.push({
                        attribute: attribute,
                        values: values,
                    });
                }
            });

            // Generate combinations
            const combinations = generateCombinations(attributes);
            $('#generated-variants').empty();
            combinations.forEach(combination => {

                console.log("combinations: ", combinations)

                $('#generated-variants').append(`

                        <div _ngcontent-ng-c4139701631="" role="heading" ngbaccordionheader="" class="accordion-header">
                            <button _ngcontent-ng-c4139701631="" type="button" ngbaccordionbutton="" class="toggle-details  accordion-button" id="ngb-accordion-item-0-toggle" aria-controls="ngb-accordion-item-0-collapse" aria-expanded="true" fdprocessedid="2sdvry">
                                ${combination}
                            </button>

                            <div _ngcontent-ng-c4139701631="" role="region" ngbaccordioncollapse="" class="variant-details pt-2 accordion-collapse collapse show" id="ngb-accordion-item-0-collapse" aria-labelledby="ngb-accordion-item-0-toggle">
                                <div _ngcontent-ng-c4139701631="" ngbaccordionbody="" class="accordion-body"><!---->
                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                        <div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row">
                                            <label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="variation_name0"> Name<span _ngcontent-ng-c1578356246="" class="theme-color ms-2 required-dot">*</span><!----></label>
                                            <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                <input _ngcontent-ng-c4139701631="" type="text" placeholder="Enter Name" formcontrolname="name" class="form-control ng-untouched ng-pristine ng-invalid" id="variation_name0" fdprocessedid="n4gn7"><!----></div>
                                                </div>
                                    </app-form-fields>
                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246="">
                                        <div _ngcontent-ng-c1578356246="" class="align-items-center content-variant g-2 mb-4 row">
                                            <label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="price0"> Price<span _ngcontent-ng-c1578356246="" class="theme-color ms-2 required-dot">*</span><!----></label>
                                            <div _ngcontent-ng-c1578356246="" class="col-sm-9">
                                                <div _ngcontent-ng-c4139701631="" class="input-group">
                                                    <span _ngcontent-ng-c4139701631="" class="input-group-text"> $ </span>
                                                    <input _ngcontent-ng-c4139701631="" type="number" placeholder="Enter Price" formcontrolname="price" class="form-control ng-untouched ng-pristine ng-invalid" id="price0" fdprocessedid="nrf6x"></div><!----><!----></div></div>
                                                    </app-form-fields>
                                                    
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="discount_value0"> Discount<!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><div _ngcontent-ng-c4139701631="" class="input-group"><input _ngcontent-ng-c4139701631="" type="number" min="0" max="100" oninput="if (value > 100) value = 100; if (value < 0) value = 0;" formcontrolname="discount" class="form-control ng-untouched ng-pristine ng-valid" placeholder="Enter discount" id="discount_value0" fdprocessedid="q97pxu"><span _ngcontent-ng-c4139701631="" class="input-group-text">%</span></div></div></div></app-form-fields>
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="sale_price0"> Sale Price<!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><div _ngcontent-ng-c4139701631="" class="input-group"><span _ngcontent-ng-c4139701631="" class="input-group-text"> $ </span><input _ngcontent-ng-c4139701631="" type="number" placeholder="Enter sale price" readonly="" class="form-control" id="sale_price0" fdprocessedid="d6vkii"></div></div></div></app-form-fields>
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="quantity0"> Stock Quantity<span _ngcontent-ng-c1578356246="" class="theme-color ms-2 required-dot">*</span><!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><input _ngcontent-ng-c4139701631="" type="number" placeholder="Enter Quantity" formcontrolname="quantity" class="form-control ng-untouched ng-pristine ng-invalid" id="quantity0" fdprocessedid="poussb"><!----></div></div></app-form-fields>
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="sku0"> SKU<span _ngcontent-ng-c1578356246="" class="theme-color ms-2 required-dot">*</span><!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><input _ngcontent-ng-c4139701631="" type="text" placeholder="Enter SKU" formcontrolname="sku" class="form-control ng-untouched ng-pristine ng-invalid" id="sku0" fdprocessedid="4een3y"><!----></div></div></app-form-fields>
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="stock_status0"> Stock Status<span _ngcontent-ng-c1578356246="" class="theme-color ms-2 required-dot">*</span><!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><select2 _ngcontent-ng-c4139701631="" formcontrolname="stock_status" class="custom-select ng-untouched ng-pristine ng-valid" _nghost-ng-c3374597708="" id="select2-11" aria-invalid="false"><div _ngcontent-ng-c3374597708="" class="select2-label"><!----></div><div _ngcontent-ng-c3374597708="" class="select2 select2-container select2-container--default select2-container--focus select2-container--below"><div _ngcontent-ng-c3374597708="" cdkoverlayorigin="" class="selection" tabindex="0">
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="variation_image_id0"> Image<!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><app-image-upload _ngcontent-ng-c4139701631="" _nghost-ng-c3000554265=""><ul _ngcontent-ng-c3000554265="" class="image-select-list cursor-pointer"><li _ngcontent-ng-c3000554265="" class="choosefile-input"><i _ngcontent-ng-c3000554265="" class="ri-add-line"></i></li><!----><!----><!----></ul><!----><app-media-modal _ngcontent-ng-c3000554265="" _nghost-ng-c729472833=""><!----></app-media-modal></app-image-upload></div></div></app-form-fields>
                                                    <app-form-fields _ngcontent-ng-c4139701631="" _nghost-ng-c1578356246=""><div _ngcontent-ng-c1578356246="" class="align-items-center g-2 mb-4 row"><label _ngcontent-ng-c1578356246="" class="col-sm-3 form-label-title mb-0" for="active_variation_status0"> Status<!----></label><div _ngcontent-ng-c1578356246="" class="col-sm-9"><div _ngcontent-ng-c4139701631="" class="form-check form-switch ps-0"><label _ngcontent-ng-c4139701631="" class="switch"><input _ngcontent-ng-c4139701631="" type="checkbox" formcontrolname="status" id="active_variation_status0" class="ng-untouched ng-pristine ng-valid"><span _ngcontent-ng-c4139701631="" class="switch-state"></span></label></div></div></div>
                                    </app-form-fields>
                                </div><!---->
                            </div>
                        </div>
                    `);
            });

            // Toggle details visibility
            $('.toggle-details').on('click', function() {
                $(this).siblings('.variant-details').toggle();
            });
        });


        // Generate combinations from attributes
        function generateCombinations(attributes) {
            if (attributes.length === 0) return [];

            const combine = (index, current) => {
                if (index === attributes.length) {
                    return [current.join(' / ')];
                }

                const results = [];
                const {
                    attribute,
                    values
                } = attributes[index];
                values.forEach(value => {
                    results.push(...combine(index + 1, [...current, `${value} ${attribute}`]));
                });

                return results;
            };

            return combine(0, []);
        }



        //select specifi 


        const specifiData = {
            Liter: ['5 Liter', '10 Liter', '20 Liter'],
            Waist: ['30', '32', '34'],
            Size: ['S', 'M', 'L', 'XL'],
        };

        // Populate attributes dropdown
        function populateAttributesSpecifi(selectElement) {
            selectElement.empty();
            selectElement.append('<option></option>'); // Placeholder
            for (const attribute in specifiData) {
                selectElement.append(`<option value="${attribute}">${attribute}</option>`);
            }
        }

        // Populate values dropdown based on selected attribute
        function populateValues(selectElement, attribute) {
            selectElement.empty();
            if (attribute && specifiData[attribute]) {
                specifiData[attribute].forEach(value => {
                    selectElement.append(`<option value="${value}">${value}</option>`);
                });
            }
        }

        // Initialize the first attribute select
        populateAttributesSpecifi($('.attribute-specifis-select'));
        $('.attribute-specifis-select').select2({
            placeholder: "Select Attribute"
        });
        $('.value-specifis-select').select2({
            placeholder: "Select Values"
        });

        // On attribute change, update values
        $('.attribute-specifis-select').on('change', function() {
            const attribute = $(this).val();
            const valueSelect = $(this).closest('.specifis-inputs').find('.value-select');
            populateValues(valueSelect, attribute);
        });

        // Add specifis
        $('#add-specifis-btn').on('click', function(e) {
            e.preventDefault();
            const specifisContainer = `
                                      <div class="specifis-container">
                                        <div class="specifis-inputs">
                                          <select class="attribute-select" placeholder="Select Attribute"></select>
                                          <select class="value-select" multiple="multiple" placeholder="Select Values"></select>
                                          <span class="remove-specifis">Remove</span>
                                        </div>
                                      </div>
                                    `;
            $('#specifiss-section').append(specifisContainer);

            const newAttributeSelect = $(
                '#specifiss-section .specifis-container:last-child .attribute-select');
            const newValueSelect = $('#specifiss-section .specifis-container:last-child .value-select');

            populateAttributesSpecifi(newAttributeSelect);
            newAttributeSelect.select2({
                placeholder: "Select Attribute"
            });
            newValueSelect.select2({
                placeholder: "Select Values"
            });

            // On attribute change, update values
            newAttributeSelect.on('change', function() {
                const attribute = $(this).val();
                populateValues(newValueSelect, attribute);
            });
        });

        // Remove a specifis
        $(document).on('click', '.remove-specifis', function() {
            $(this).closest('.specifis-container').remove();
        });



        // select option
    </script>
@endpush
