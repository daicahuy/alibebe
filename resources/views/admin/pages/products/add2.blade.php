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
    <link rel="stylesheet" href="/theme/admin/assets/css/addproduct.css">
    <link rel="stylesheet" type="text/css" href="/theme/admin/assets/css/style.css">
    {{-- <link rel="stylesheet" type="text/css" href="/theme/admin/assets/css/select2.min.css"> --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
@endpush

@push('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,500&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
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

        .variant-item {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            position: relative;
        }

        .toggle-details {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 16px;
            user-select: none;
        }

        .variant-details {
            margin-top: 10px;
            display: none;
            background: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .variant-details input {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
            min-width: 795px;
            max-width: 795px;
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
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create product</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                                <li class="breadcrumb-item active">Create product</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate="">
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary fs-20">
                                                <i class="bi bi-box-seam"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">Thông tin sản phẩm</h5>
                                        <p class="text-muted mb-0">Xem tất cả thông tin sản phẩm bên dưới</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="product-title-input" value=""
                                        placeholder="Nhập tên sản phầm" required="" fdprocessedid="8vxy8n">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Sku</label>
                                    <input type="text" class="form-control" id="product-title-input" value=""
                                        placeholder="Nhập Sku" required="" fdprocessedid="8vxy8n">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết sản phẩm</label>

                                    <div class="main-container">
                                        <div class="editor-container editor-container_classic-editor editor-container_include-word-count"
                                            id="editor-container">
                                            <div class="editor-container__editor">
                                                <div id="editor"></div>
                                            </div>
                                            <div class="editor_container__word-count" id="editor-word-count"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Slug</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction"
                                        value="add">
                                    <input type="text" class="form-control d-none" id="product-id-input">
                                    <input type="text" class="form-control" id="product-title-input" value=""
                                        placeholder="Enter product title" required="" fdprocessedid="8vxy8n">
                                    <div class="invalid-feedback">Nhập slug</div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Danh mục sản phẩm</label>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary fs-20">
                                                <i class="bi bi-images"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">Product Gallery</h5>
                                        <p class="text-muted mb-0">Add product gallery images.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Ảnh bìa</label>
                                <div class="form-group col-sm-9">
                                    <div class="">


                                        <input class="form-control form-control-sm" style="height: unset" id="formFileSm"
                                            type="file">

                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">List Image</label>
                                <div class="form-group col-sm-9">
                                    <form class="dropzone custom-dropzone" id="multiFileUpload"
                                        action="https://themes.pixelstrap.com/upload.php">
                                        <div class="dropzone-wrapper">
                                            <div class="dz-message needsclick">
                                                <div class="d-flex flex-column justify-content-center  align-items-center">
                                                    <i class="icon-cloud-up"></i>
                                                    <h6>Thêm file ảnh tại đây</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Video</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction"
                                        value="add">
                                    <input type="text" class="form-control d-none" id="product-id-input">
                                    <input type="text" class="form-control" id="product-title-input" value=""
                                        placeholder="Enter product title" required="" fdprocessedid="8vxy8n">
                                    <div class="invalid-feedback">Nhập url video</div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary fs-20">
                                                <i class="bi bi-list-ul"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">Thông tin chung</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row ">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-name-input">Manufacturer
                                                Name</label>
                                            <input type="text" class="form-control" id="manufacturer-name-input"
                                                placeholder="Enter manufacturer name" fdprocessedid="hlqagp">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="manufacturer-brand-input">Hãng</label>
                                            <div class="input-wrapper" id="inputWrapperBrand">
                                                <input type="text" class="form-control" id="manufacturer-brand-input"
                                                    placeholder="Nhập tên hãng" fdprocessedid="9t80sn">

                                            </div>
                                            <div class="dropdown" id="dropdownBrand" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="stocks-input">Số lượng</label>
                                            <input type="text" class="form-control" id="stocks-input"
                                                placeholder="Số lượng" required="" fdprocessedid="qpl60w">
                                            <div class="invalid-feedback">Please enter a product stocks.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product-price-input">Giá</label>
                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="product-price-addon">$</span>
                                                <input type="text" class="form-control" id="product-price-input"
                                                    placeholder="Giá" aria-label="Price"
                                                    aria-describedby="product-price-addon" required=""
                                                    fdprocessedid="pcf36w">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product-discount-input">Giảm giá</label>
                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="product-discount-addon">%</span>
                                                <input type="text" class="form-control" id="product-discount-input"
                                                    placeholder="Giảm giá" aria-label="discount"
                                                    aria-describedby="product-discount-addon" required=""
                                                    fdprocessedid="tpqrz">
                                                <div class="invalid-feedback">Please enter a product discount.</div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3 autocomplete-container">
                                            <label class="form-label" for="orders-input">Khuyến mãi</label>
                                            <div class="input-wrapper" id="inputWrapperPromotion">
                                                <input type="text" class="form-control" id="promotions-input"
                                                    placeholder="Khuyến mãi" required="" fdprocessedid="4xdyf5">
                                            </div>
                                            <div class="dropdown" id="dropdownPromotion" style="display: none;"></div>
                                        </div>
                                    </div>


                                    <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div>
                                            <label class="form-label">Colors</label>
                                            <ul class="clothe-colors list-unstyled hstack gap-2 mb-0 flex-wrap">
                                                <li>
                                                    <input type="checkbox" value="success" id="color-1">
                                                    <label
                                                        class="avatar-xs btn btn-success p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-1"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="info" id="color-2">
                                                    <label
                                                        class="avatar-xs btn btn-info p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-2"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="warning" id="color-3">
                                                    <label
                                                        class="avatar-xs btn btn-warning p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-3"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="danger" id="color-4">
                                                    <label
                                                        class="avatar-xs btn btn-danger p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-4"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="primary" id="color-5">
                                                    <label
                                                        class="avatar-xs btn btn-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-5"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="secondary" id="color-6">
                                                    <label
                                                        class="avatar-xs btn btn-secondary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-6"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="dark" id="color-7">
                                                    <label
                                                        class="avatar-xs btn btn-dark p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-7"></label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="light" id="color-8">
                                                    <label
                                                        class="avatar-xs btn btn-light p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="color-8"></label>
                                                </li>
                                            </ul>
                                            <div class="error-msg mt-1">Please select a product colors.</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mt-3 mt-lg-0">
                                            <label class="form-label">Sizes</label>
                                            <ul class="clothe-size list-unstyled hstack gap-2 mb-0 flex-wrap"
                                                id="size-filter">
                                                <li>
                                                    <input type="checkbox" value="xs" id="sizeXs">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="sizeXs">XS</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="s" id="sizeS">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="sizeS">S</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="m" id="sizeM">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="sizeM">M</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="l" id="sizeL">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="sizeL">L</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="xl" id="sizeXl">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="sizeXl">XL</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="2xl" id="size2xl">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size2xl">2XL</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="3xl" id="size3xl">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size3xl">3XL</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="40" id="size40">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size40">40</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="41" id="size41">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size41">41</label>
                                                </li>
                                                <li>
                                                    <input type="checkbox" value="42" id="size42">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size42">42</label>
                                                </li>
                                            </ul>
                                            <div class="error-msg mt-1">Please select a product sizes.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-3">
                            <div class="text-base font-normal text-orange-500 dark:text-orange-400 mx-4">
                                Does this product have variants?
                            </div>
                            <div class="react-switch md:ml-0 ml-3"
                                style="position: relative; display: inline-block; text-align: left; opacity: 1; direction: ltr; border-radius: 15px; transition: opacity 0.25s; touch-action: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;">
                                <div id="switch-bg" class="react-switch-bg"
                                    style="height: 30px; width: 80px; margin: 0px; position: relative; background:  rgb(229, 62, 62); border-radius: 15px; cursor: pointer; transition: background 0.25s;">
                                    <!-- Yes -->
                                    <div id="buttonYes"
                                        style="height: 30px; width: 45px; position: relative; opacity: 0; pointer-events: none; transition: opacity 0.25s;">
                                        <div
                                            style="display: flex; justify-content: center; align-items: center; height: 100%; font-size: 14px; color: white; padding-left: 8px; padding-top: 1px;">
                                            Yes
                                        </div>
                                    </div>
                                    <!-- No -->
                                    <div id="buttonNo"
                                        style="height: 30px; width: 45px; position: absolute; opacity: 1; right: 0px; top: 0px; pointer-events: none; transition: opacity 0.25s;">
                                        <div
                                            style="display: flex; justify-content: center; align-items: center; height: 100%; font-size: 14px; color: white; padding-right: 5px; padding-top: 1px;">
                                            No
                                        </div>
                                    </div>
                                </div>
                                <!-- Handle -->
                                <div class="react-switch-handle" id="switch-handle"
                                    style="height: 28px; width: 28px; background: rgb(255, 255, 255); display: inline-block; cursor: pointer; border-radius: 50%; position: absolute; transform: translateX(1px); top: 1px; outline: 0px; border: 0px; transition: transform 0.25s, box-shadow 0.15s;">
                                </div>
                                <input type="checkbox" id="toggle-switch" name="toggle-switch" role="switch"
                                    aria-checked="true"
                                    style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px;">
                            </div>
                        </div>


                        <div id="variants-card" style="display: none">

                            <div id="variants-section">
                                <!-- Variant container -->
                                <div class="variant-container">
                                    <div class="variant-inputs">
                                        <select class="attribute-select" placeholder="Select Attribute">
                                        </select>
                                        <select class="value-select" multiple="multiple" placeholder="Select Values">
                                        </select>
                                        <span class="remove-variant">Remove</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center">
                                <button id="add-variant-btn" class="btn btn-primary">Add Variant</button>
                                <button id="generate-variants-btn" class="btn btn-info ml-2">Generate Variants</button>
                            </div>

                            <div id="generated-variants"></div>
                        </div>


                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
                        <script>
                            const toggleSwitch = document.getElementById('toggle-switch');
                            const buttonYes = document.getElementById('buttonYes');
                            const buttonNo = document.getElementById('buttonNo');
                            const switchHandle = document.getElementById('switch-handle');
                            const switchBg = document.getElementById('switch-bg');
                            const variantsCard = document.getElementById('variants-card');



                            // Add event listener to toggle functionality
                            toggleSwitch.addEventListener('change', () => {
                                if (toggleSwitch.checked) {
                                    buttonNo.style.opacity = 0;
                                    buttonYes.style.opacity = 1;
                                    variantsCard.style.display = 'block';
                                    switchBg.style.background = 'rgb(47, 133, 90)'; // Green
                                    switchHandle.style.transform = 'translateX(51px)'; // Move to the right
                                } else {
                                    buttonNo.style.opacity = 1;
                                    buttonYes.style.opacity = 0;
                                    variantsCard.style.display = 'none';

                                    switchBg.style.background = 'rgb(229, 62, 62)'; // Red
                                    switchHandle.style.transform = 'translateX(1px)'; // Move to the left

                                }
                            });

                            // Simulate switch toggle on click
                            switchBg.addEventListener('click', () => {
                                toggleSwitch.checked = !toggleSwitch.checked;
                                toggleSwitch.dispatchEvent(new Event('change'));
                            });



                            $(document).ready(function() {
                                // Demo data: Map of attributes and their corresponding values
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
                                $('#generate-variants-btn').on('click', function(e) {
                                    e.preventDefault();

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
                                    console.log('Generated Variants:', attributes);
                                    // Generate combinations
                                    const combinations = generateCombinations(attributes);
                                    $('#generated-variants').empty();
                                    combinations.forEach(combination => {
                                        $('#generated-variants').append(`
                                        <div class="variant-item toggle-details"">
                                          ${combination}
                                          <span class=">▼</span>
                                          <div class="variant-details">
                                            <label>Details for ${combination}</label>
                                            <input type="text" placeholder="Enter specific details for this variant" />
                                          </div>
                                        </div>
                                      `);
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

                                // Toggle variant details
                                $(document).on('click', '.toggle-details', function() {
                                    const details = $(this).siblings('.variant-details');
                                    details.slideToggle();

                                    // Toggle arrow icon
                                    const currentText = $(this).text();
                                    $(this).text(currentText === '▼' ? '▲' : '▼');
                                });
                            });
                        </script>

                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm" fdprocessedid="2mvop2">Submit</button>
                        </div>

                    </div>
                    <!-- end col -->

                    <div class="col-xl-3 col-lg-4">
                        <div class="card">

                            <div class="card-body">
                                <div class="mb-3 d-flex flex-column">
                                    <label for="choices-publish-status-input" class="form-label">Status</label>

                                    <select class="form-select" aria-label="Default select example">
                                        <option value="1">Nháp</option>
                                        <option value="2">Kích hoat</option>
                                    </select>
                                </div>


                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <label for="datepicker-publish-input" class="form-label">Hẹn giờ xuất bản</label>
                                    <input type="text" id="publish-date" name="publish_date"
                                        class="form-control flatpickr-input" placeholder="Nhập thời gian"
                                        data-provider="flatpickr" data-date-format="d.m.y" data-enable-time=""
                                        readonly="readonly" fdprocessedid="126wv">

                                    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                    <script>
                                        // Initialize Flatpickr on the input field
                                        flatpickr("#publish-date", {
                                            enableTime: true, // Enables time selection
                                            dateFormat: "Y-m-d H:i", // Date format: e.g., 2023-12-26 14:30
                                            minDate: "today", // Disable past dates
                                            time_24hr: true // Use 24-hour time format
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->


                        <div class="card">
                            <div class="card-header">

                            </div>
                            <div class="mb-3 autocomplete-container">
                                <h5 class="card-title mb-2">Thẻ sản phẩm</h5>
                                <div class="input-wrapper" id="inputWrapperTags">
                                    <input type="text" class="form-control" id="tags-input" placeholder="Tags"
                                        required="" fdprocessedid="4xdyf5">
                                </div>
                                <div class="dropdown" id="dropdownTags" style="display: none;"></div>
                            </div>

                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Mô tả ngắn sản phẩm</h5>
                                <textarea class="form-control" placeholder="Must enter minimum of a 100 characters" rows="5"></textarea>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </form>
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script>2024 © Toner.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design &amp; Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            // Danh sách giả lập (database) cho từng input
            let nameDatabase = [
                "Nguyễn Văn A",
                "Trần Thị B",
                "Lê Văn C",
                "Phạm Thị D"
            ];

            let brandDatabase = [
                "Apple",
                "Samsung",
                "Sony",
                "LG",
                "Xiaomi"
            ];

            let TagsDatabase = [
                "Apple",
                "Samsung",
                "Sony",
                "LG",
                "Xiaomi"
            ];

            // Lưu trữ các giá trị đã chọn
            let selectedNames = [];
            let selectedBrands = [];
            let selectedTags = [];

            // Hàm xử lý autocomplete chung cho cả hai input
            function setupAutocomplete(inputId, dropdownId, wrapperId, database, selectedItems) {
                const input = document.getElementById(inputId);
                const dropdown = document.getElementById(dropdownId);
                const wrapper = document.getElementById(wrapperId);

                let activeIndex = -1; // Chỉ mục mục đang được chọn trong dropdown

                // Hàm cập nhật dropdown
                function updateDropdown() {
                    const query = input.value.trim().toLowerCase();
                    if (!query) {
                        dropdown.style.display = "none";
                        activeIndex = -1;
                        return;
                    }

                    // Lọc danh sách gợi ý
                    const filteredItems = database.filter(
                        item => item.toLowerCase().includes(query) && !selectedItems.includes(item)
                    );

                    if (filteredItems.length === 0) {
                        dropdown.style.display = "none";
                        activeIndex = -1;
                        return;
                    }

                    // Hiển thị danh sách gợi ý
                    dropdown.innerHTML = filteredItems
                        .map((item, index) =>
                            `<div class="${index === activeIndex ? 'active' : ''}" data-item="${item}">${item}</div>`)
                        .join("");

                    dropdown.style.display = "block";
                }

                // Hàm chọn item
                function selectItem(item) {
                    if (!database.includes(item)) {
                        database.push(item); // Thêm vào database nếu giá trị chưa tồn tại
                    }

                    selectedItems.push(item); // Thêm vào danh sách đã chọn
                    renderTags(); // Cập nhật giao diện

                    input.value = ""; // Xóa giá trị trong input
                    dropdown.style.display = "none";
                    activeIndex = -1;
                }

                // Hàm hiển thị các thẻ đã chọn
                function renderTags() {
                    // Xóa tất cả các thẻ cũ (trừ ô input)
                    const tags = wrapper.querySelectorAll(".tag");
                    tags.forEach(tag => tag.remove());

                    // Tạo thẻ mới cho mỗi giá trị đã chọn
                    selectedItems.forEach(item => {
                        const tag = document.createElement("div");
                        tag.className = "tag";
                        tag.innerHTML = `${item} <span class="remove-tag" data-item="${item}">&times;</span>`;
                        wrapper.insertBefore(tag, input);
                    });

                    // Gán sự kiện xóa cho các nút "x"
                    const removeButtons = wrapper.querySelectorAll(".remove-tag");
                    removeButtons.forEach(button => {
                        button.addEventListener("click", () => {
                            const item = button.getAttribute("data-item");
                            removeTag(item);
                        });
                    });
                }

                // Hàm xóa một thẻ
                function removeTag(item) {
                    const index = selectedItems.indexOf(item);
                    if (index > -1) {
                        selectedItems.splice(index, 1); // Loại bỏ giá trị khỏi danh sách đã chọn
                        renderTags(); // Cập nhật giao diện
                    }
                }

                // Hàm xử lý điều hướng bằng bàn phím
                function handleKeyDown(event) {
                    const dropdownItems = dropdown.querySelectorAll("div");
                    if (dropdown.style.display === "block" && dropdownItems.length > 0) {
                        if (event.key === "ArrowDown") {
                            activeIndex = (activeIndex + 1) % dropdownItems.length;
                            updateActiveItem();
                            event.preventDefault();
                        } else if (event.key === "ArrowUp") {
                            activeIndex = (activeIndex - 1 + dropdownItems.length) % dropdownItems.length;
                            updateActiveItem();
                            event.preventDefault();
                        } else if (event.key === "Enter") {
                            if (activeIndex >= 0 && activeIndex < dropdownItems.length) {
                                selectItem(dropdownItems[activeIndex].dataset.item);
                            } else if (input.value.trim() !== "") {
                                selectItem(input.value.trim());
                            }
                            event.preventDefault();
                        }
                    }
                }

                // Hàm cập nhật mục đang được chọn
                function updateActiveItem() {
                    const dropdownItems = dropdown.querySelectorAll("div");
                    dropdownItems.forEach((item, index) => {
                        item.classList.toggle("active", index === activeIndex);
                    });
                }

                // Sử dụng chuột để chọn item
                dropdown.addEventListener("click", (event) => {
                    const item = event.target.dataset.item;
                    if (item) {
                        selectItem(item);
                    }
                });

                // Lắng nghe sự kiện
                input.addEventListener("input", updateDropdown);
                input.addEventListener("keydown", handleKeyDown);
                input.addEventListener("focus", updateDropdown);

                input.addEventListener("keydown", (event) => {
                    if (event.key === "Enter" && input.value.trim()) {
                        const newName = input.value.trim();
                        if (!selectedItems.includes(newName)) {
                            selectItem(newName); // Thêm giá trị mới
                        }
                        event.preventDefault(); // Ngăn hành động mặc định của Enter
                    }
                });
                document.addEventListener("click", (event) => {
                    if (!event.target.closest(`#${wrapperId}`)) {
                        dropdown.style.display = "none";
                        activeIndex = -1;
                    }
                });
            }

            // Khởi tạo autocomplete cho cả hai input
            setupAutocomplete("promotions-input", "dropdownPromotion", "inputWrapperPromotion", nameDatabase, selectedNames);
            setupAutocomplete("tags-input", "dropdownTags", "inputWrapperTags", TagsDatabase, selectedTags);
            setupAutocomplete("manufacturer-brand-input", "dropdownBrand", "inputWrapperBrand", brandDatabase, selectedBrands);
        </script>
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
@endpush
