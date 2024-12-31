@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    {{-- <style>
        /* Tổng thể bảng */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        .table {
            width: 100%;
            table-layout: fixed;
            /* Đặt bảng cố định độ rộng */
            border-collapse: collapse;
        }

        /* Cấu hình các cột */
        .table th,
        .table td {
            text-align: left;
            vertical-align: middle;
            padding: 12px 10px;
            white-space: nowrap;
            /* Tránh tràn xuống dòng */
            border: 1px solid #ddd;
            /* Đường viền giữa các ô */
        }

        /* Định dạng nội dung trong cột (xuống dòng khi tràn) */
        .table td {
            white-space: normal;
            /* Cho phép ngắt dòng */
            word-wrap: break-word;
            /* Tự động xuống dòng */
            overflow: hidden;
            text-overflow: ellipsis;
            /* Hiển thị ... nếu quá dài */
            max-width: 200px;
            /* Giới hạn độ rộng của ô */
        }

        /* Định dạng header */
        .table thead th {
            background-color: #f9f9f6;
            font-size: 16px;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Định dạng cột cụ thể */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 5%;
            /* ID cột */
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 20%;
            /* Category Name */
        }

        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 10%;
            /* Icon */
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 15%;
            /* Slug */
        }

        .table th:nth-child(5),
        .table td:nth-child(5) {
            width: 10%;
            /* PUBLISHED */
        }

        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 10%;
            /* Created at */
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 10%;
            /* Updated at */
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 10%;
            /* Option */
        }

        /* Điều chỉnh nội dung icon */
        .category-icon img {
            max-width: 30px;
            height: auto;
        }

        /* Định dạng nút chuyển đổi trạng thái */
        .form-check.form-switch {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Định dạng phần Option (danh sách icon) */
        ul {
            list-style: none;
            /* display: flex; */
            justify-content: center;
            gap: 10px;
            padding: 0;
            margin: 0;
        }

        ul li a {
            text-decoration: none;
            font-size: 18px;
            color: #333;
        }

        ul li a:hover {
            color: #007bff;
        }

        .category-title {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .subcategory-wrapper {
            margin-left: 60px;
            /* Tăng mức lùi cho mục con */
        }

        .subcategory-item {
            margin: 5px 0;
            display: flex;
            align-items: center;
        }

        .subcategory-item::before {
            content: "•";
            /* Dấu chấm hoặc gạch đầu dòng cho mục con */
            margin-right: 8px;
            font-size: 14px;
            color: #666;
        }

        .subcategory-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            max-width: 80%;
            /* Giới hạn chiều rộng */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Thêm dấu ... khi tràn */
            vertical-align: middle;
        }


        .subcategory-link:hover {
            text-decoration: underline;
        }

        /* css search */
    </style> --}}
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <!-- All User Table Start-->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header">
                        <div class="d-flex align-items-center">
                            <h5>Category</h5>
                        </div>
                        <div button=""><a class="align-items-center btn btn-theme d-flex"
                                href="/fastkart-admin/product/create"><i class="ri-add-line"></i> Add
                                Category </a></div>
                    </div>
                    <app-table>
                        <div class="show-box">
                            <div class="selection-box"><label>Show :</label>
                                <select class="form-control">
                                    <option value="30">30
                                    </option>
                                    <option value="50">50
                                    </option>
                                    <option value="100">100
                                    </option>
                                </select><label>Items per
                                    page</label>
                            </div>
                            <div class="datepicker-wrap">

                            </div>
                            <div class="table-search"><label for="role-search" class="form-label">Search :</label><input
                                    type="search" id="role-search" class="form-control ng-untouched ng-pristine ng-valid">
                            </div>
                            <!-- Parents only -->
                            <div class="react-switch-cate "
                                style="position: relative; display: inline-block; text-align: left; opacity: 1; direction: ltr; border-radius: 14px; transition: opacity 0.25s; touch-action: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none;">
                                <div class="react-switch-bg"
                                    style="height: 28px; width: 115px; margin: 0px; position: relative; background: rgb(47, 133, 90); border-radius: 14px; cursor: pointer; transition: background 0.25s;">
                                    <div
                                        style="height: 28px; width: 42px; position: relative; opacity: 1; pointer-events: none;
                               transition: opacity 0.25s;">
                                        <div
                                            style="display: flex; justify-content: center; align-items: center; height: 100%; font-size: 12px; color: white; padding-left: 8px; padding-top: 1px;">
                                            All</div>
                                    </div>
                                    <div
                                        style="height: 28px; width: 42px; position: absolute; opacity: 0; right: 0px; top: 0px; pointer-events: none;
                               transition: opacity 0.25s;">
                                        <div
                                            style="display: flex; justify-content: left; align-items: center; height: 100%; font-size: 12px; color: white; padding-right: 50px; padding-top: 1px; margin-left: -40px; white-space: nowrap;">
                                            Parents Only</div>
                                    </div>
                                </div>
                                <!-- di chuyển -->
                                <div class="react-switch-handle"
                                    style="height: 26px; width: 26px; background: rgb(255, 255, 255); display: inline-block; cursor: pointer; border-radius: 50%; position: absolute; 
                          transform: translateX(88px); top: 1px; outline: 0px; border: 0px; transition: background-color 0.25s, transform 0.25s, box-shadow 0.15s;">
                                </div>
                                <input type="checkbox" role="switch" aria-checked="true"
                                    style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px;">
                            </div>
                        </div>

                        <div>
                            <div class="table-responsive datatable-wrapper border-table">

                                <table class="table all-package theme-table no-footer">
                                    <thead>
                                        <tr>
                                            <th class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="table-checkbox"
                                                        class="custom-control-input checkbox_animated"><label
                                                        for="table-checkbox" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th class="sm-width"> ID. </th>
                                            <th class="sm-width"> Icon </th>
                                            <th class="cursor-pointer"> Name <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i>
                                                    </div>
                                                </div>
                                            </th>
                                           
                                            <!-- <th class="cursor-pointer"> Price <div
                                                        class="filter-arrow">
                                                        <div><i class="ri-arrow-up-s-fill"></i>
                                                        </div>
                                                    </div>
                                                </th> -->
                                            <th> published
                                            </th>

                                            <th> Created at

                                            </th>
                                            <th> Updated at
                                            </th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox_animated"
                                                        id="table-checkbox-item-20" value="20"><label
                                                        class="custom-control-label"
                                                        for="table-checkbox-item-20">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width"> 1

                                            </td>
                                            <td class="cursor-pointer sm-width"><img alt="image" class="tbl-image"
                                                    src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png">
                                            </td>
                                            <td class="cursor-pointer">

                                                <div>
                                                    <a href="">Âm thanh </a>

                                                    <div class="subcategory-wrapper">
                                                        <div class="pl-2 subcategory-item">
                                                            <a class="subcategory-link" href="">
                                                                <span>Tai nghe </span>
                                                            </a>
                                                        </div>
                                                        <div class="pl-2 subcategory-item">
                                                            <a class="subcategory-link" href="">
                                                                <span>Loa</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                           
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm"><input type="checkbox" id="status-0"
                                                            value="1"><span class="switch-state"></span></label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">

                                                22/12/2024

                                            </td>
                                            <td class="cursor-pointer">

                                                22/12/2024

                                            </td>


                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" id="1"><i
                                                                class="ri-delete-bin-line"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox_animated"
                                                        id="table-checkbox-item-20" value="20"><label
                                                        class="custom-control-label"
                                                        for="table-checkbox-item-20">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width"> 1

                                            </td>
                                            <td class="cursor-pointer sm-width"><img alt="image" class="tbl-image"
                                                    src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png">
                                            </td>
                                            <td class="cursor-pointer">

                                                <div>
                                                    <a href="">Âm thanh </a>

                                                    <div class="subcategory-wrapper">
                                                        <div class="pl-2 subcategory-item">
                                                            <a class="subcategory-link" href="">
                                                                <span>Tai nghe </span>
                                                            </a>
                                                        </div>
                                                        <div class="pl-2 subcategory-item">
                                                            <a class="subcategory-link" href="">
                                                                <span>Loa</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                           
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm"><input type="checkbox" id="status-0"
                                                            value="1"><span class="switch-state"></span></label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">

                                                22/12/2024

                                            </td>
                                            <td class="cursor-pointer">

                                                22/12/2024

                                            </td>


                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" id="1"><i
                                                                class="ri-delete-bin-line"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>

                                        

                                        <!-- <tr>
                                                <td class="sm-width">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            class="custom-control-input checkbox_animated"
                                                            id="table-checkbox-item-19"
                                                            value="19"><label
                                                            class="custom-control-label"
                                                            for="table-checkbox-item-19">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width"> 2

                                                </td>
                                                <td class="cursor-pointer sm-width"><img
                                                        alt="image" class="tbl-image"
                                                        src="https://laravel.pixelstrap.net/fastkart/storage/93/Strawberry_1.png">
                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>
                                                        Deliciously Sweet Strawberry</div>

                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>FRUIT09
                                                    </div>

                                                </td>
                                                <td class="cursor-pointer">
                                                    $6.37
                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>
                                                        <div class="status-in_stock"><span>in
                                                                stock</span></div>
                                                    </div>

                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>Fruits
                                                        Market</div>

                                                </td>
                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm"><input
                                                                type="checkbox" id="status-1"
                                                                value="1"><span
                                                                class="switch-state"></span></label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm"><input
                                                                type="checkbox" id="status-1"
                                                                value="0"><span
                                                                class="switch-state"></span></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul id="actions">
                                                        <li><a href="javascript:void(0)"><i
                                                                    class="ri-pencil-line"></i></a>
                                                        </li>
                                                        <li><a href="javascript:void(0)"><i
                                                                    class="ri-delete-bin-line"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr> -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav class="custom-pagination">
                            <app-pagination>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled"><a href="javascript:void(0)" tabindex="-1"
                                            aria-disabled="true" class="page-link"><i
                                                class="ri-arrow-left-s-line"></i></a></li>
                                    <li class="page-item active"><a href="javascript:void(0)" class="page-link">1</a>
                                    </li>
                                    <li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><i
                                                class="ri-arrow-right-s-line"></i></a></li>
                                </ul>
                            </app-pagination>
                        </nav>
                        <app-delete-modal>

                        </app-delete-modal>
                        <app-confirmation-modal>

                        </app-confirmation-modal>
                    </app-table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal xóa -->
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

    <!-- All User Table Ends-->
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script>
        // parents only
        // Ẩn hiện SubCategory
        $(document).ready(function() {
            // --- Xử lý chức năng "Parents Only" ---

            // Lấy các phần tử trong thành phần switch
            const $switch = $('.react-switch-cate');
            const $bg = $switch.find('.react-switch-bg');
            const $handle = $switch.find('.react-switch-handle');
            const $input = $switch.find('input[type="checkbox"]');
            const $divAll = $bg.children().first(); // Div đại diện cho trạng thái "All"
            const $divParents = $bg.children().eq(1); // Div đại diện cho trạng thái "Parents Only"

            // Thiết lập trạng thái mặc định là "Parents Only" khi trang được load
            $handle.css('transform', 'translateX(1px)'); // Vị trí tay cầm của switch
            $bg.css('background', 'rgb(14, 159, 110)'); // Màu nền khi ở trạng thái "Parents Only"
            $divAll.css({
                'position': 'relative',
                'opacity': '0', // Ẩn nội dung "All"
                'pointer-events': 'none' // Không cho phép tương tác
            });
            $divParents.css({
                'position': 'absolute',
                'opacity': '1', // Hiển thị nội dung "Parents Only"
                'right': '0',
                'top': '0',
                'pointer-events': 'none' // Không cho phép tương tác
            });
            $input.prop('checked', false); // Đặt trạng thái checkbox ban đầu là unchecked
            $input.prop('aria-checked', 'false'); // Cập nhật thuộc tính aria cho accessibility

            // Mặc định ẩn các danh mục con
            $('.pl-2').hide(); // Ẩn các danh mục con bằng class "pl-2"

            // Bắt sự kiện click vào switch
            $switch.click(function() {
                const isChecked = $input.prop('checked'); // Kiểm tra trạng thái checkbox

                if (isChecked) {
                    // Chuyển trạng thái từ "All" sang "Parents Only"
                    $handle.css('transform', 'translateX(1px)'); // Di chuyển tay cầm sang trái
                    $bg.css('background', 'rgb(14, 159, 110)'); // Đổi màu nền

                    // Hiển thị "Parents Only", ẩn "All"
                    $divAll.css({
                        'position': 'relative',
                        'opacity': '0',
                        'pointer-events': 'none'
                    });
                    $divParents.css({
                        'position': 'absolute',
                        'opacity': '1',
                        'right': '0',
                        'top': '0',
                        'pointer-events': 'none'
                    });

                    // Ẩn các danh mục con
                    $('.pl-2').slideUp(300); // Hiệu ứng ẩn danh mục con

                    $input.prop('aria-checked', 'false'); // Cập nhật trạng thái aria
                } else {
                    // Chuyển trạng thái từ "Parents Only" sang "All"
                    $handle.css('transform', 'translateX(88px)'); // Di chuyển tay cầm sang phải
                    $bg.css('background', 'rgb(47, 133, 90)'); // Đổi màu nền

                    // Hiển thị "All", ẩn "Parents Only"
                    $divAll.css({
                        'position': 'relative',
                        'opacity': '1',
                        'pointer-events': 'none'
                    });
                    $divParents.css({
                        'position': 'absolute',
                        'opacity': '0',
                        'right': '0',
                        'top': '0',
                        'pointer-events': 'none'
                    });

                    // Hiển thị các danh mục con
                    $('.pl-2').slideDown(300); // Hiệu ứng hiện danh mục con

                    $input.prop('aria-checked', 'true'); // Cập nhật trạng thái aria
                }

                $input.prop('checked', !isChecked); // Đảo ngược trạng thái của checkbox
            });


            // --- Xử lý sự kiện của nút xóa ---

            // Bắt sự kiện click cho tất cả icon xóa
            $(document).on('click', '.ri-delete-bin-line', function(e) {
                e.preventDefault();
                // Lấy id từ thẻ a cha
                const itemId = $(this).closest('a').attr('id');

                // Lưu id vào data của modal để sử dụng sau này
                $('#exampleModalToggle').data('item-id', itemId);

                // Hiển thị modal
                $('#exampleModalToggle').modal('show');
            });

            // Xử lý nút Yes
            $('#delete_yes_btn').on('click', function() {
                // Lấy id của item cần xóa
                const itemId = $('#exampleModalToggle').data('item-id');
                console.log('Deleting item:', itemId);

                // Thêm logic xóa item ở đây

                // Đóng modal
                $('#exampleModalToggle').modal('hide');
            });

            // Xử lý nút No
            $('#delete_no_btn').on('click', function() {
                $('#exampleModalToggle').modal('hide');
            });





            // Khi nhấn nút "Yes" trong modal xóa
            // $('#delete_yes_btn').on('click', function () {
            // 	alert('Item has been deleted.'); // Hiển thị thông báo (xử lý logic xóa tại đây nếu cần)
            // 	$('#exampleModalToggle').modal('hide'); // Ẩn modal xóa
            // });

            // // Khi nhấn nút "No" trong modal xóa
            // $('#delete_no_btn').on('click', function () {
            // 	$('#exampleModalToggle').modal('hide'); // Đóng modal xóa
            // });
        });
    </script>
@endpush
