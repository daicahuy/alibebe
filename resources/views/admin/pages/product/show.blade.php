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
        th,
        td {
            border: 1px solid black;

            /* Chiều cao của ô */
            text-align: center;
            /* Căn giữa theo chiều ngang */
            vertical-align: middle;
            /* Căn giữa theo chiều dọc */
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


        .page-wrapper {
            padding: unset;
        }

        .page-content {
            padding: unset;
        }

        .btn-secondary:hover {
            background-color: #fff;
            border: 1px solid #6c757d;
            color: #fff;
        }

        @media (min-width: 992px) {

            .modal-lg,
            .modal-xl {
                --bs-modal-width: 1200px;
            }
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
                        <h4 class="mb-sm-0">Xem chi tiết sản phẩm A</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Sản phẩm</a></li>
                                <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
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
                                    <input type="text" class="form-control" id="product-title-input" value="Tên sản phẩm"
                                        disabled placeholder="Nhập tên sản phầm" required="" fdprocessedid="8vxy8n">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Sku</label>
                                    <input type="text" class="form-control" id="product-title-input" value="Sku"
                                        disabled placeholder="Nhập Sku" required="" fdprocessedid="8vxy8n">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Tính năng nổi bật</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="4" disabled>Tính năng nổi bật</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết sản phẩm</label>

                                    <div class="main-container">
                                        <div class="editor-container editor-container_classic-editor editor-container_include-word-count"
                                            id="editor-container">
                                            <div class="editor-container__editor">
                                                <div id="editor"
                                                    data-content="<p>Nội dung từ file HTML qua data-content.</p>">

                                                </div>
                                            </div>
                                            <div class="editor_container__word-count" id="editor-word-count"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Slug</label>
                                    <input type="text" class="form-control" id="product-title-input" value=""
                                        placeholder="Slug" disabled required="" fdprocessedid="8vxy8n">
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="d-flex flex-row align-items-start">
                                            <label class="form-label " style="min-width: 180px">Danh mục sản phẩm:
                                            </label>
                                            <div class="ml-1">
                                                <div class="mb-2">Danh mục aDanh mục aDanh mục aDanh mục aDanh mục aDanh
                                                    mục aDanh mục
                                                    aDanh mục aDanh mục aDanh mục aDanh mục aDanh mục aDanh mục aDanh mục
                                                    aDanh mục aDanh mục aDanh mục a</div>
                                                <div class="mb-2">Danh mục b</div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-6">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex flex-row align-items-start">
                                                <label class="form-label" style="min-width: 180px">Sản phẩm liên kết:
                                                </label>
                                                <div class="ml-1">
                                                    <div class="mb-2">Sản phẩm 1</div>
                                                    <div class="mb-2">Sản phẩm 2</div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-6">
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex flex-row align-items-start">
                                                <label class="form-label" style="min-width: 180px">Phụ kiện đi kèm:
                                                </label>
                                                <div class="ml-1">
                                                    <div class="mb-2">Phụ kiện 1</div>
                                                    <div class="mb-2">Phụ kiện 2</div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div>
                                    <div class="text-center mt-5">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#specModal">
                                            Xem thông số kỹ thuật
                                        </button>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="specModal" tabindex="-1"
                                        aria-labelledby="specModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="specModalLabel">Thông số kỹ thuật</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Bảng thông số kỹ thuật -->
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <th>Kích thước màn hình</th>
                                                                <td>6.78 inches</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Công nghệ màn hình</th>
                                                                <td>AMOLED</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Camera sau</th>
                                                                <td>Camera chính: 108MP, f/1.75<br>Camera Macro: 2MP, AI
                                                                    Camera, Đèn flash dọc bốn chiều</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Camera trước</th>
                                                                <td>32MP, f/2.2</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Chipset</th>
                                                                <td>Mediatek Helio G99</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Công nghệ NFC</th>
                                                                <td>Có</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Dung lượng RAM</th>
                                                                <td>8GB + Mở rộng 8GB</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Bộ nhớ trong</th>
                                                                <td>256 GB</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pin</th>
                                                                <td>5000mAh</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Thẻ SIM</th>
                                                                <td>2 SIM (Nano-SIM)</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Hệ điều hành</th>
                                                                <td>Android 14</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Độ phân giải màn hình</th>
                                                                <td>1080 x 2436 pixels</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tính năng màn hình</th>
                                                                <td>Tần số quét 120Hz, 1000 nit, 1.07 tỷ màu, Kính Cường Lực
                                                                    Corning Gorilla Glass 5</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Loại CPU</th>
                                                                <td>Tiến trình 6nm</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
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
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">List Image</label>
                                <div class="form-group col-sm-9">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                    <img src="/theme/admin/assets/images/product/10.png" alt=""
                                        style="width: 100px; height: 100px; object-fit: contain">
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Video</label>
                                    <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/CPkGTSW34_I?si=86-cVeQn_eSoEdc3"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
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
                                            <label class="form-label" for="manufacturer-brand-input">Hãng</label>
                                            <div class="input-wrapper" id="inputWrapperBrand">
                                                <input type="text" class="form-control" id="manufacturer-brand-input"
                                                    placeholder="Nhập tên hãng" disabled fdprocessedid="9t80sn">

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
                                                placeholder="Số lượng" disabled required="" fdprocessedid="qpl60w">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product-price-input">Giá</label>
                                            <div class="input-group has-validation mb-3">
                                                <span class="input-group-text" id="product-price-addon">$</span>
                                                <input type="text" class="form-control" id="product-price-input"
                                                    placeholder="Giá" aria-label="Price" disabled
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
                                                    placeholder="Giảm giá" aria-label="discount" disabled
                                                    aria-describedby="product-discount-addon" required=""
                                                    fdprocessedid="tpqrz">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="orders-input">Khuyến mãi</label>
                                            <div class="input-group has-validation mb-3">
                                                <input type="text" class="form-control" id="product-title-input"
                                                    value="" placeholder="Khuyến mãi" disabled required=""
                                                    fdprocessedid="8vxy8n">
                                            </div>
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
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary mb-3 mt-3" data-bs-toggle="modal"
                                    data-bs-target="#variantModal">
                                    Xem biến thể sản phẩm
                                </button>
                                <div class="modal fade" id="variantModal" tabindex="-1"
                                    aria-labelledby="variantModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="variantModalLabel">Biến thể sản phẩm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Bảng biến thể sản phẩm -->
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Combination</th>
                                                            <th>SKU</th>
                                                            <th>Barcode</th>
                                                            <th>Price</th>
                                                            <th>Sale Price</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><img src="https://via.placeholder.com/50" alt="Image">
                                                            </td>
                                                            <td>Small<br>(676ee5f7757474000c549947-0)</td>
                                                            <td class="">
                                                                <span>123123</span>
                                                            </td>
                                                            <td class="">
                                                                <span>123123</span>
                                                            </td>
                                                            <td class="">
                                                                <span>123123</span>
                                                            </td>
                                                            <td class="">
                                                                <span>123123</span>
                                                            </td>
                                                            <td class="">
                                                                <span>123123</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <!-- end card -->

                        </div>
                        <!-- end col -->

                        <!-- end col -->
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="card">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <!-- Icon mắt -->
                                    <i class="fas fa-eye me-2"></i>
                                    <!-- Số lượng người xem -->
                                    <span style="font-size: 24px">1,234 lượt xem</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3 d-flex flex-column">
                                    <h5 class="card-title mb-2">Status</h5>
                                    <input type="text" class="form-control" id="promotions-input" required=""
                                        fdprocessedid="4xdyf5" value="Xuất bản" disabled>
                                </div>


                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <h5 class="card-title mb-2">Thời gian xuất bản</h5>
                                    <input type="text" id="publish-date" name="publish_date"
                                        class="form-control flatpickr-input" placeholder="Nhập thời gian"
                                        data-provider="flatpickr" data-date-format="d.m.y" disabled data-enable-time=""
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
                                    <input type="text" class="form-control" id="tags-input" disabled
                                        placeholder="Tags" required="" fdprocessedid="4xdyf5">
                                </div>
                                <div class="dropdown" id="dropdownTags" style="display: none;"></div>
                            </div>

                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-2">Mô tả ngắn sản phẩm</h5>
                                <textarea class="form-control" disabled placeholder="Must enter minimum of a 100 characters" rows="5"></textarea>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

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
    {{-- <script src="/theme/admin/assets/js/ckeditor-custom2.js"></script> --}}

    <!-- select2 js -->
    <script src="/theme/admin/assets/js/select2.min.js"></script>
    <script src="/theme/admin/assets/js/select2-custom.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Thêm thư viện Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('js')
    <script>
        ClassicEditor.create(document.querySelector("#editor"))
            .then((editor) => {
                // Lấy nội dung từ thuộc tính data-content của #editor
                const editorContent = document.querySelector("#editor").getAttribute("data-content");

                // Nhập dữ liệu vào CKEditor
                editor.setData(editorContent);

                // Vô hiệu hóa chỉnh sửa
                editor.isReadOnly = true;
            })
            .catch((error) => {
                console.error(error);
            });
    </script>
@endpush
