@extends('admin.layouts.master')

{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        /* Modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
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
            display: none;
            padding: 20px;
            width: 90%;
            max-width: 1300px;
            max-height: 100vh;
            overflow-y: auto;
        }

        /* Modal header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Modal close button */
        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Tab navigation styles */
        .nav-tabs {
            margin-bottom: 15px;
        }

        .nav-link {
            cursor: pointer;
        }

        /* Content section */
        .content-section {
            margin-top: 10px;
        }

        /* Dropzone */
        .dropzone-label {
            display: flex;
            /* Kích hoạt Flexbox */
            flex-direction: column;
            /* Xếp chồng các phần tử theo chiều dọc */
            justify-content: center;
            /* Căn giữa nội dung theo chiều dọc */
            align-items: center;
            /* Căn giữa nội dung theo chiều ngang */
            margin-top: 10px;
            padding: 20px;
            border-radius: 8px;
            /* Góc bo tròn */
            cursor: pointer;
            background-color: #f9f9f9;
            height: 400px;
            /* Chiều cao cố định */
            width: 90%;
            /* Chiều rộng chiếm 90% khối cha */
            text-align: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            /* Hiệu ứng hover */
        }

        .dropzone-label h2 {
            color: #007bff;
            font-size: 1.2rem;
        }

        /* Image preview */
        #imagePreview img {
            width: 100px;
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
@endpush
{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>Tất Cả Thương Hiệu</h5>
                        <form class="d-inline-flex">
                            <a href="" id="openAddBrandModal" class="align-items-center btn btn-theme d-flex">
                                <i data-feather="plus-square"></i> Thêm Mới
                            </a>
                        </form>
                    </div>

                    <div class="show-box">
                        <div class="selection-box"><label>Hiển Thị
                                :</label><select class="form-control">
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select><label>Số Lượng Mỗi Trang</label></div>
                        <div class="datepicker-wrap"></div>
                        <div class="table-search"><label for="role-search" class="form-label">Tìm Kiếm:</label><input
                                type="search" id="role-search" class="form-control ng-untouched ng-pristine ng-valid">
                        </div>
                    </div>

                    <div class="table-responsive category-table">
                        <div>
                            <table class="table all-package theme-table" id="table_id">
                                <thead>
                                    <tr>
                                        <th class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="table-checkbox"
                                                    class="custom-control-input checkbox_animated"><label
                                                    for="table-checkbox" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Tên Thương Hiệu</th>
                                        <th>Logo Thương Hiệu</th>
                                        <th>Slug</th>
                                        <th>Ngày Tạo</th>
                                        <th>Ngày Chỉnh Sửa</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody id="brand-table-body">
                                    <!-- Thêm dữ liệu vào đây -->
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-7" value="7"><label
                                                    class="custom-control-label" for="table-checkbox-item-7">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Aata Biscuit</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>buscuit</td>
                                        <td>26-12-2021</td>
                                        <td>26-12-2021</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-6" value="6"><label
                                                    class="custom-control-label" for="table-checkbox-item-6">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Dog Food</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>dog-food</td>
                                        <td>30-08-2022</td>
                                        <td>30-08-2022</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-5" value="5"><label
                                                    class="custom-control-label" for="table-checkbox-item-5">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Fresh Meat</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>meat</td>
                                        <td>30-03-2022</td>
                                        <td>30-03-2022</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-4" value="4"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-4">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Vegetables</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>vegetables</td>
                                        <td>01-01-2023</td>
                                        <td>01-01-2023</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-3" value="3"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-3">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Clothing</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>clothing</td>
                                        <td>05-07-2021</td>
                                        <td>05-07-2021</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-2" value="2"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Accessories</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>accessories</td>
                                        <td>15-11-2020</td>
                                        <td>15-11-2020</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="brand-row">
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-1" value="1"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-1">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>Electronics</td>
                                        <td>
                                            <div class="table-image">
                                                <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/08/hinh-nen-luffy-gear-5-58.jpg"
                                                    class="img-fluid" alt="Brand Logo">
                                            </div>
                                        </td>
                                        <td>electronics</td>
                                        <td>10-10-2022</td>
                                        <td>10-10-2022</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="order-detail.html">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalToggle">
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
            <nav class="custom-pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a href="javascript:void(0)" tabindex="-1" aria-disabled="true"
                            class="page-link"><i class="ri-arrow-left-s-line"></i></a></li>
                    <li class="page-item active"><a href="javascript:void(0)" class="page-link">1</a></li>
                    <li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><i
                                class="ri-arrow-right-s-line"></i></a></li>
                </ul>
            </nav>
            <!-- Modal Thêm Mới BOx Start -->
            <!-- Modal HTML Structure -->
            <div class="modal fade" id="addBrandModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm Thương Hiệu Mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="brand-form">
                                <div class="mb-3 row">
                                    <label for="brand-name" class="col-md-3 col-form-label">Tên Thương Hiệu</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="brand-name"
                                            placeholder="Nhập tên thương hiệu">
                                    </div>
                                </div>
                                <div class="align-items-center g-2 mb-4 row">
                                    <label class="col-sm-2 form-label-title mb-0" for="image">Hình Ảnh</label>
                                    <div class="col-sm-10 d-flex justify-content-center">
                                        <ul class="image-select-list cursor-pointer">
                                            <li class="choosefile-input" id="openModal1">
                                                <div class="add-button"></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="ml-4 d-flex" id="image-area"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">Hủy
                                Bỏ</button>
                            <button type="button" class="btn btn-animation btn-md fw-bold" id="save-btn">Lưu Thương
                                Hiệu</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Media -->
            <div class="modal-backdrop" id="modalBackdrop"></div>

            <div class="modal-content" id="mediaModal" style="display: none;">
                <div class="modal-header">
                    <h2>Insert Media</h2>
                    <button class="btn btn-close" id="media_close_btn" type="button">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#" class="nav-link active" id="selectFileTab">Select File</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="uploadNewTab">Upload New</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2">
                        <!-- Select File Tab -->
                        <div class="tab-pane fade active show" id="selectFilePanel">
                            <div class="select-top-panel d-flex">
                                <input type="text" class="form-control me-3" placeholder="Search your files">
                                <select class="form-select">
                                    <option value="">Sort By desc</option>
                                    <option value="newest">Sort By newest</option>
                                    <option value="oldest">Sort By oldest</option>
                                    <option value="smallest">Sort By smallest</option>
                                    <option value="largest">Sort By largest</option>
                                </select>
                            </div>
                            <div class="content-section py-0">
                                <div class="row row-cols-2 g-2 media-library-sec">
                                    <div class="media-item col-2">
                                        <input name="attachment" class="media-checkbox" type="radio"
                                            id="attachment-1470" value="1470">
                                        <label for="attachment-1470">
                                            <div class="ratio ratio-1x1">
                                                <img alt="attachment" class="img-fluid"
                                                    src="https://example.com/image.jpg">
                                            </div>
                                        </label>
                                    </div>
                                    <div class="media-item col-2">
                                        <input name="attachment" class="media-checkbox" type="radio"
                                            id="attachment-1471" value="1471">
                                        <label for="attachment-1471">
                                            <div class="ratio ratio-1x1">
                                                <img alt="attachment" class="img-fluid"
                                                    src="https://example.com/image.jpg">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <nav class="custom-pagination">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled"><a href="#" class="page-link"><i
                                                    class="ri-arrow-left-s-line"></i></a></li>
                                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                                        <li class="page-item"><a href="#" class="page-link"><i
                                                    class="ri-arrow-right-s-line"></i></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Upload New Tab -->
                        <div class="tab-pane fade" id="uploadNewPanel">
                            <div class="content-section drop-files-sec">
                                <div class="custom-upload">
                                    <input type="file" id="fileUploadInput" multiple accept="image/*">
                                    <div class="dropzone-label">
                                        <i class="ri-upload-line justify-content-center"></i>
                                        <h2>Drop Files Here or Click to Upload</h2>
                                    </div>
                                </div>
                                <div id="imagePreview" class="image-preview">
                                    <!-- Ảnh sẽ hiển thị ở đây sau khi tải lên -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-theme" id="media_btn" type="button">Insert Media</button>
                </div>
            </div>
            <!-- Delete Modal Box Start -->
            <div class="modal fade theme-modal remove-coupon" id="exampleModalToggle" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-block text-center">
                            <h5 class="modal-title w-100" id="exampleModalLabel22">Bạn Có Chắc Không ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="remove-box">
                                <p>Quyền sử dụng/nhóm, xem trước được kế thừa từ đối tượng, đối tượng sẽ
                                    tạo ra một quyền mới cho đối tượng này</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-animation btn-md fw-bold"
                                data-bs-dismiss="modal">Không</button>
                            <button type="button" class="btn btn-animation btn-md fw-bold"
                                data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                                data-bs-dismiss="modal">Có</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade theme-modal remove-coupon" id="exampleModalToggle2" aria-hidden="true"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLabel12">Thành Công!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="remove-box text-center">
                                <div class="wrapper">
                                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                        <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                            fill="none" />
                                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                    </svg>
                                </div>
                                <h4 class="text-content">Đã Xóa !</h4>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Đóng</button>
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
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Handle checkbox select all
            $('#table-checkbox').on('click', function() {
                $('.custom-control-input').prop('checked', $(this).prop('checked'));
            });

            $('.custom-control-input').not('#table-checkbox').on('click', function() {
                var total = $('.custom-control-input').not('#table-checkbox').length;
                var checked = $('.custom-control-input:checked').not('#table-checkbox').length;
                $('#table-checkbox').prop('checked', total === checked);
            });
            // Handle delete action
            $('#actions li:last-child a').on('click', function(e) {
                e.preventDefault();
                // Show delete confirmation modal
                $('#exampleModalToggle').modal('show');
            });

            // Handle delete confirmation
            $('#exampleModalToggle .modal-footer button:last-child').on('click', function() {
                // Close first modal
                $('#exampleModalToggle').modal('hide');
                // Show success modal
                $('#exampleModalToggle2').modal('show');
            });

            // Close success modal
            $('#exampleModalToggle2 .btn-primary').on('click', function() {
                $('#exampleModalToggle2').modal('hide');
            });
            // ========================== Brands Modal ======================
            // Bật modal thêm thương hiệu
            $("#openAddBrandModal").click(function(e) {
                e.preventDefault();
                $('#addBrandModal').modal('show');
            });

            // Bật modal media và tắt modal thêm thương hiệu
            var selectedFiles = [];

            // Show modal function
            function showModal() {
                $('#mediaModal').show();
                $('#modalBackdrop').show();
                $('#addBrandModal').modal('hide');
                activateSelectFileTab();
            }

            // Hide modal function
            function hideModal() {
                $('#mediaModal').hide();
                $('#modalBackdrop').hide();
            }

            // Reset file input
            function resetFileInput() {
                $('#fileUploadInput').val('');
                $('#imagePreview').html('');
            }

            // Activate upload tab
            function activateUploadTab() {
                $('#uploadNewTab').addClass('active');
                $('#selectFileTab').removeClass('active');
                $('#uploadNewPanel').addClass('show active');
                $('#selectFilePanel').removeClass('show active');
            }

            // Activate select file tab
            function activateSelectFileTab() {
                $('#selectFileTab').addClass('active');
                $('#uploadNewTab').removeClass('active');
                $('#selectFilePanel').addClass('show active');
                $('#uploadNewPanel').removeClass('show active');
                resetFileInput();
            }

            // Display images outside modal
            function displayImagesOutside() {
                $('#image-area').html('');

                $.each(selectedFiles, function(_, file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgContainer = $('<div>').addClass('image-container');
                        var img = $('<img>').attr('src', event.target.result).attr('name', 'image[]');
                        var deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        deleteBtn.on('click', function() {
                            imgContainer.remove();
                            selectedFiles = selectedFiles.filter(function(f) {
                                return f !== file;
                            });
                            displayImagesOutside();
                        });

                        imgContainer.append(img).append(deleteBtn);
                        $('#image-area').append(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Event bindings
            $('#openModal1').on('click', showModal);
            $('#media_close_btn').on('click', hideModal);
            $('#modalBackdrop').on('click', hideModal);

            $('#uploadNewTab').on('click', function(e) {
                e.preventDefault();
                activateUploadTab();
            });

            $('#selectFileTab').on('click', function(e) {
                e.preventDefault();
                activateSelectFileTab();
            });

            // File upload handling
            $('#fileUploadInput').on('change', function(e) {
                var files = e.target.files;

                $.each(files, function(_, file) {
                    selectedFiles.push(file);
                });

                $('#imagePreview').html('');

                $.each(selectedFiles, function(_, file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgContainer = $('<div>').addClass('image-container');
                        var img = $('<img>').attr('src', event.target.result);
                        var deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        deleteBtn.on('click', function() {
                            imgContainer.remove();
                            selectedFiles = selectedFiles.filter(function(f) {
                                return f !== file;
                            });
                            displayImagesOutside();
                        });

                        imgContainer.append(img).append(deleteBtn);
                        $('#imagePreview').append(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });

                if ($('#media_btn').length) {
                    displayImagesOutside();
                }
            });

            // Save button handler
            $('#save-btn').on('click', function() {
                $.notify('<i class="fas fa-bell"></i><strong>Save</strong> Completed', {
                    type: 'theme',
                    allow_dismiss: true,
                    delay: 1000,
                    showProgressbar: true,
                    timer: 300,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });
            });

            // Media button handler
            $('#media_btn').on('click', function() {
                $.notify(
                    '<i class="fas fa-bell"></i><strong>Media</strong> Action completed successfully', {
                        type: 'theme',
                        allow_dismiss: true,
                        delay: 1000,
                        showProgressbar: true,
                        timer: 300,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });
                hideModal();
                $('#addBrandModal').modal('show');
            });
        });
    </script>
@endpush
