@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <link rel="stylesheet" href="/theme/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/mermaid.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/nouislider.min.css">
    <link rel="stylesheet" href="/theme/admin/assets/css/icons.min.css">

    <link rel="stylesheet" href="/theme/admin/assets/css/app.min.css">
    <link rel="stylesheet" type="text/css" href="/theme/admin/assets/css/style.css">
    <style>
        .page-wrapper {
            padding: unset;
        }

        .custom-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .custom-table tbody tr:hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        .custom-table th,
        .custom-table td {
            vertical-align: middle;
            text-align: center;
        }

        <style>.confirm {
            background-color: #0da487 !important;
        }

        .btn-outline-primary {
            color: #4a5568;
        }

        .layout_filter {
            margin: 0px !important;
        }

        .filter {
            width: 231.31px;
            height: 35px;
        }

        .order-offcanvas {
            z-index: 1055 !important;
            /* Giá trị cao hơn backdrop (thường là 1050) */
        }

        /* Ẩn dropdown mặc định */
        .dropdown-menu {
            display: none;
        }

        /* Hiển thị dropdown khi được kích hoạt */
        .dropdown.show .dropdown-menu {
            display: block;
        }

        /* Bỏ dấu đầu dòng của danh sách */
        li {
            list-style: none;
        }

        /* Tạo block riêng cho mỗi mục submenu */
        .sidebar-submenu li {
            display: block;
            /* Đảm bảo mỗi li là một khối riêng biệt */
            margin-bottom: 8px;
            /* Khoảng cách giữa các mục */
        }

        /* Đảm bảo mỗi mục con trong submenu không nằm cạnh nhau */
        .sidebar-submenu a {
            display: block;
            /* Đảm bảo link trong mỗi li là một khối */
            padding: 8px 12px;
            /* Tạo padding cho các mục */
            text-decoration: none;
            /* Loại bỏ gạch chân */
            color: #333;
            /* Màu chữ */
        }

        .sidebar-submenu a:hover {
            background-color: #f0f0f0;
            /* Hiệu ứng hover */
        }

        .btn-red {
            background-color: red
        }

        /* Modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            /* Đảm bảo modal nằm trên các phần tử khác */
            display: none;
            /* Mặc định ẩn backdrop */
        }

        /* Modal */
        #mediaModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            /* Trên backdrop */
            display: none;
            /* Mặc định ẩn modal */
            padding: 20px;
            width: 90%;
            /* Chiều rộng modal lớn hơn */
            max-width: 1300px;
            /* Đặt giới hạn chiều rộng tối đa */
            max-height: 100vh;
            /* Chiều cao tối đa chiếm 90% chiều cao màn hình */
            overflow-y: auto;
            /* Bật cuộn dọc nếu nội dung quá dài */
        }

        .notReceived:hover {
            color: #4a5568 !important;
        }

        .btn-order {
            padding: 5px;
            border: none;
            background-color: #fff;
            border-bottom: 2px solid transparent;
            transition: border-bottom 0.3s ease, color 0.3s ease;
        }

        .btn-order:hover {
            border-bottom: 2px solid #656d7b;
            background-color: #fff;
            /* Màu viền khi hover */
            color: #000;
        }

        .btn-order.active {
            border-bottom: 2px solid #656d7b;
            background-color: #fff;
            /* Màu viền khi active */
            font-weight: bold;
            color: #656d7b;
        }

        /* Image preview */
        #imagePreview img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .small-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }

        .custom-pagination .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-pagination .page-item {
            margin: 0 5px;
        }

        .custom-pagination .page-link {
            padding: 10px 15px;
            color: #0c9c8a;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #0c9c8a;
            color: white;
            border-color: #0c9c8a;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #ddd;
            pointer-events: none;
        }

        .custom-pagination .page-item:hover .page-link {
            background-color: #e9ecef;
            border-color: #ddd;
        }

        .custom-pagination .page-link i {
            font-size: 16px;
        }


        /* Add Button */
        /* Plus symbol */
        .add-button::after {
            content: '+';
            /* Plus icon */
            font-size: 24px;
            /* Font size for the plus icon */
            color: #888;
            /* Grey color for the icon */
        }

        /* Hover effect */
        .add-button:hover {
            background-color: #f0f0f0;
            /* Slightly darker background on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            /* Stronger shadow on hover */
        }

        /* Active effect */
        .add-button:active {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            /* Reduced shadow for pressed effect */
            transform: scale(0.95);
            /* Slight shrink on click */
        }

        /* Add Button */

        .custom-upload {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 400px;
            border: 2px dashed #ccc;
            border-radius: 12px;
            cursor: pointer;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            position: relative;
        }

        .custom-upload:hover {
            background-color: #f0f0f0;
            border-color: #0da487;
        }

        .custom-upload h2 {
            font-size: 24px;
            color: #717386;
            margin: 0;
            margin-bottom: 10px;
        }

        .custom-upload i {
            font-size: 24px;
            color: #717386;
            margin-bottom: 8px;
        }

        .custom-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image preview container */
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Image container styling */
        .image-container {
            position: relative;
            width: 100px;
            /* Chiều rộng của mỗi ảnh */
            height: 100px;
            /* Chiều cao của mỗi ảnh */
            overflow: hidden;
            border: 2px solid #ccc;
            /* Viền cho ảnh */
            border-radius: 8px;
            /* Góc bo tròn */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Tạo hiệu ứng đổ bóng */
            transition: transform 0.3s ease;
        }

        .image-container:hover {
            transform: scale(1.05);
            /* Phóng to ảnh khi hover */
        }

        /* Image inside container */
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh luôn được căn chỉnh đẹp trong khung */
            border-radius: 8px;
            /* Bo tròn góc ảnh */
        }

        /* Delete button styling */
        .delete-btn {
            position: absolute;
            top: 5px;
            /* Điều chỉnh nút delete lên phía trên */
            right: 5px;
            /* Điều chỉnh nút delete về phía phải */
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            /* Tăng kích thước nút delete */
            height: 24px;
            font-size: 16px;
            line-height: 24px;
            /* Đảm bảo icon nằm giữa */
            text-align: center;
            /* Căn giữa nội dung nút delete */
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Đổ bóng cho nút xóa */
            z-index: 10;
            /* Đảm bảo nút delete luôn nằm trên cùng */
        }

        .delete-btn:hover {
            background-color: #ff1a1a;
            /* Đổi màu khi hover */
        }
    </style>
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    {{-- Start Lọc --}}
    <div class="tab">
        <div class="card layout_filter shadow-sm">
            <div class="card-body bg-white">
                <div>
                    <form>

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="productStatus">Trạng thái sản phẩm:</label>
                                <select id="productStatus" class="form-control">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="available">Đang bán</option>
                                    <option value="not_available">Ngừng bán</option>
                                </select>
                            </div>
                            <div class="col-6"></div>

                            <!-- Bộ lọc theo mức giá -->
                            <div class="form-group col-6">
                                <label for="priceFrom">Giá từ:</label>
                                <input type="number" id="priceFrom" class="form-control" placeholder="Nhập giá từ">
                            </div>
                            <div class="form-group col-6">
                                <label for="priceTo">Giá đến:</label>
                                <input type="number" id="priceTo" class="form-control" placeholder="Nhập giá đến">
                            </div>

                            <!-- Lọc theo ngày -->
                            <!-- Ngày bắt đầu -->
                            <h3 class="mt-3">Lọc theo ngày tạo sản phẩm</h3>

                            <div class="col-6">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input class="form-control form-control-sm" type="date" name="startDate">
                            </div>

                            <!-- Ngày kết thúc -->
                            <div class="col-6">
                                <label class="form-label">Ngày kết thúc</label>
                                <input class="form-control form-control-sm" type="date" name="endDate">
                            </div>
                        </div>

                        <!-- Nút lọc -->
                        <div class="col-6 mt-3">
                            <div class="">
                                <a href="#" class="btn btn-solid filter">Lọc</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End lọc --}}




    {{-- Start Body Order --}}
    <div class="card card-table mt-2">
        <div class="card-body">
            <div _ngcontent-ng-c1743930539="" class="title-header">
                <div _ngcontent-ng-c1743930539="" class="d-flex align-items-center">
                    <h5 _ngcontent-ng-c1743930539="">Danh sách sản phẩm</h5>
                </div>
                <div _ngcontent-ng-c831449713="" button=""><a _ngcontent-ng-c831449713=""
                        class="align-items-center btn btn-theme d-flex" href="/fastkart-admin/product/create"><i
                            _ngcontent-ng-c831449713="" class="ri-add-line"></i> Add Product </a></div><!---->
            </div>
            <app-table _ngcontent-ng-c831449713="" _nghost-ng-c1063460097="">
                <div _ngcontent-ng-c1063460097="" class="show-box">
                    <div _ngcontent-ng-c1063460097="" class="selection-box"><label _ngcontent-ng-c1063460097="">Show
                            :</label><select _ngcontent-ng-c1063460097="" class="form-control" fdprocessedid="qjgiun">
                            <option _ngcontent-ng-c1063460097="" value="30">30</option>
                            <option _ngcontent-ng-c1063460097="" value="50">50</option>
                            <option _ngcontent-ng-c1063460097="" value="100">100</option><!---->
                        </select><label _ngcontent-ng-c1063460097="">Items per page</label><!----><!----></div>
                    <div _ngcontent-ng-c1063460097="" class="datepicker-wrap"><!----></div>
                    <div _ngcontent-ng-c1063460097="" class="table-search"><label _ngcontent-ng-c1063460097=""
                            for="role-search" class="form-label">Search :</label><input _ngcontent-ng-c1063460097=""
                            type="search" id="role-search" class="form-control ng-untouched ng-pristine ng-valid"></div>
                </div><!---->
                <div _ngcontent-ng-c1063460097="">
                    <div _ngcontent-ng-c1063460097="" class="table-responsive datatable-wrapper border-table"><!---->
                        <table _ngcontent-ng-c1063460097="" class="table all-package theme-table no-footer">
                            <thead _ngcontent-ng-c1063460097="">
                                <tr _ngcontent-ng-c1063460097="">
                                    <th _ngcontent-ng-c1063460097="" class="sm-width">
                                        <div _ngcontent-ng-c1063460097="" class="custom-control custom-checkbox"><input
                                                _ngcontent-ng-c1063460097="" type="checkbox" id="table-checkbox"
                                                class="custom-control-input checkbox_animated"><label
                                                _ngcontent-ng-c1063460097="" for="table-checkbox"
                                                class="custom-control-label">&nbsp;</label></div>
                                    </th><!---->
                                    <th _ngcontent-ng-c1063460097="" class="sm-width"> No. <!----></th>
                                    <th _ngcontent-ng-c1063460097="" class="sm-width"> Ảnh <!----></th>
                                    <th _ngcontent-ng-c1063460097="" class="cursor-pointer"> Tên sản phẩm <div
                                            _ngcontent-ng-c1063460097="" class="filter-arrow">
                                            <div _ngcontent-ng-c1063460097=""><i _ngcontent-ng-c1063460097=""
                                                    class="ri-arrow-up-s-fill"></i><!----><!----></div>
                                        </div><!----></th>
                                    <th _ngcontent-ng-c1063460097="" class="cursor-pointer"> SKU <div
                                            _ngcontent-ng-c1063460097="" class="filter-arrow">
                                            <div _ngcontent-ng-c1063460097=""><i _ngcontent-ng-c1063460097=""
                                                    class="ri-arrow-up-s-fill"></i><!----><!----></div>
                                        </div><!----></th>
                                    <th _ngcontent-ng-c1063460097="" class="cursor-pointer"> Giá <div
                                            _ngcontent-ng-c1063460097="" class="filter-arrow">
                                            <div _ngcontent-ng-c1063460097=""><i _ngcontent-ng-c1063460097=""
                                                    class="ri-arrow-up-s-fill"></i><!----><!----></div>
                                        </div><!----></th>
                                    <th _ngcontent-ng-c1063460097=""> Số lượng <!----></th>
                                    <th _ngcontent-ng-c1063460097=""> Hãng <!----></th>
                                    <th _ngcontent-ng-c1063460097=""> Status <!----></th><!---->
                                    <th _ngcontent-ng-c1063460097="">Actions</th><!---->
                                </tr>
                            </thead>
                            <tbody _ngcontent-ng-c1063460097="">
                                <tr _ngcontent-ng-c1063460097="">
                                    <td _ngcontent-ng-c1063460097="" class="sm-width">
                                        <div _ngcontent-ng-c1063460097="" class="custom-control custom-checkbox"><input
                                                _ngcontent-ng-c1063460097="" type="checkbox"
                                                class="custom-control-input checkbox_animated" id="table-checkbox-item-20"
                                                value="20"><label _ngcontent-ng-c1063460097=""
                                                class="custom-control-label" for="table-checkbox-item-20">&nbsp;</label>
                                        </div>
                                    </td><!---->
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer sm-width"> 1 <!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer sm-width"><!----><img
                                            _ngcontent-ng-c1063460097="" alt="image" class="tbl-image"
                                            src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png"><!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer">
                                        <!----><!----><!----><!----><!----><!---->
                                        <div _ngcontent-ng-c1063460097="">Gourmet Fresh</div>
                                        <!----><!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer">
                                        <!----><!----><!----><!----><!----><!---->
                                        <div _ngcontent-ng-c1063460097="">FRUIT10</div>
                                        <!----><!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer"><!----><!----><!----> $4.65
                                        <!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer">
                                        <!----><!----><!----><!----><!----><!---->
                                        <div _ngcontent-ng-c1063460097="">
                                            <div class="status-in_stock"><span>in stock</span></div>
                                        </div><!----><!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer">
                                        <!----><!----><!----><!----><!----><!---->
                                        <div _ngcontent-ng-c1063460097="">Fruits Market</div>
                                        <!----><!----><!----><!----><!----><!---->
                                    </td>
                                    <td _ngcontent-ng-c1063460097="" class="cursor-pointer"><!----><!---->
                                        <button type="button" class="btn btn-success">Xuất bản</button>
                                    </td><!---->
                                    <td _ngcontent-ng-c1063460097="">
                                        <ul _ngcontent-ng-c1063460097="" id="actions"><!---->
                                            <li>
                                                <a href="">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li _ngcontent-ng-c1063460097=""><a _ngcontent-ng-c1063460097=""
                                                    href="javascript:void(0)"><i _ngcontent-ng-c1063460097=""
                                                        class="ri-pencil-line"></i></a></li><!----><!---->
                                            <li _ngcontent-ng-c1063460097="" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalToggle"><a _ngcontent-ng-c1063460097=""
                                                    href="javascript:void(0)"><i _ngcontent-ng-c1063460097=""
                                                        class="ri-delete-bin-line"></i></a></li>
                                            <!----><!----><!----><!---->
                                        </ul>



                                    </td><!---->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <nav _ngcontent-ng-c1063460097="" class="custom-pagination"><app-pagination _ngcontent-ng-c1063460097=""
                        _nghost-ng-c2013971967="">
                        <ul _ngcontent-ng-c2013971967="" class="pagination justify-content-center">
                            <li _ngcontent-ng-c2013971967="" class="page-item disabled"><a _ngcontent-ng-c2013971967=""
                                    href="javascript:void(0)" tabindex="-1" aria-disabled="true" class="page-link"><i
                                        _ngcontent-ng-c2013971967="" class="ri-arrow-left-s-line"></i></a></li>
                            <li _ngcontent-ng-c2013971967="" class="page-item active"><a _ngcontent-ng-c2013971967=""
                                    href="javascript:void(0)" class="page-link">1</a></li><!---->
                            <li _ngcontent-ng-c2013971967="" class="page-item disabled"><a _ngcontent-ng-c2013971967=""
                                    href="javascript:void(0)" class="page-link"><i _ngcontent-ng-c2013971967=""
                                        class="ri-arrow-right-s-line"></i></a></li>
                        </ul><!---->
                    </app-pagination></nav><!----><app-delete-modal _ngcontent-ng-c1063460097=""
                    _nghost-ng-c3717208901=""><!----></app-delete-modal><app-confirmation-modal
                    _ngcontent-ng-c1063460097="" _nghost-ng-c3454384515=""><!----></app-confirmation-modal>
            </app-table>
        </div>
    </div>
    {{-- End Body Order --}}


    {{--    Modal insert image --}}
    <!-- Backdrop -->


    <div class="modal fade" id="exampleModalToggle" tabindex="-1" aria-labelledby="exampleModalToggleLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="ri-delete-bin-line icon-box"></i>
                    <h5 class="modal-title">Delete Item?</h5>
                    <p>This Item will be deleted permanently. You can't undo this action.</p>
                    <div class="button-box">
                        <button class="btn btn-md btn-secondary fw-bold" id="delete_no_btn" type="button">
                            No
                        </button>
                        <button class="btn btn-md btn-theme fw-bold" id="delete_yes_btn" type="button">
                            Yes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
@endpush
