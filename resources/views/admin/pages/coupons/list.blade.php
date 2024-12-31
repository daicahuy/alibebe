@extends('admin.layouts.master')

{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')

@endpush
{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header">
                        <div class="d-flex align-items-center">
                            <h5>Mã Giảm Giá</h5>
                        </div>
                        <div button=""><a class="align-items-center btn btn-theme d-flex"
                                href="/fastkart-admin/coupon/create"><i class="ri-add-line"></i> Thêm Mã Giảm Giá </a></div>
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
                                        <th class="sm-width"> STT </th>
                                        <th class="cursor-pointer"> Mã Giảm<div class="filter-arrow">
                                            </div>
                                        </th>
                                        <th class="cursor-pointer"> Ngày Tạo <div class="filter-arrow">
                                        </th>
                                        <th> Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-7" value="7"><label
                                                    class="custom-control-label" for="table-checkbox-item-7">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 1

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>SPECIAL10</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:15:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-0"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a></li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-6" value="6"><label
                                                    class="custom-control-label" for="table-checkbox-item-6">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 2

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>SPRING10</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:13:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-1"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a></li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-5" value="5"><label
                                                    class="custom-control-label" for="table-checkbox-item-5">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 3

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>EXCLUSIVEVIP</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:11:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-2"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-4" value="4"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-4">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 4

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>MOST25</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:09:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-3"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-3" value="3"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-3">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 5

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>FABULOUS15</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:05:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-4"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-2" value="2"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 6

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>SAVE20</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 06:03:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-5"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkbox_animated"
                                                    id="table-checkbox-item-1" value="1"><label
                                                    class="custom-control-label"
                                                    for="table-checkbox-item-1">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="cursor-pointer sm-width"> 7

                                        </td>
                                        <td class="cursor-pointer">

                                            <div>FAST5</div>

                                        </td>
                                        <td class="cursor-pointer">
                                            29 Sep 2023 05:56:PM

                                        </td>
                                        <td class="cursor-pointer">
                                            <div class="form-check form-switch ps-0">
                                                <label class="switch switch-sm"><input type="checkbox" id="status-6"
                                                        value="0"><span class="switch-state"></span></label>
                                            </div>

                                        </td>
                                        <td>
                                            <ul id="actions">
                                                <li><a href="javascript:void(0)"><i class="ri-pencil-line"></i></a></li>
                                                <li><a href="javascript:void(0)"><i class="ri-delete-bin-line"></i></a>
                                                </li>

                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <nav class="custom-pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a href="javascript:void(0)" tabindex="-1"
                                    aria-disabled="true" class="page-link"><i class="ri-arrow-left-s-line"></i></a></li>
                            <li class="page-item active"><a href="javascript:void(0)" class="page-link">1</a></li>
                            <li class="page-item disabled"><a href="javascript:void(0)" class="page-link"><i
                                        class="ri-arrow-right-s-line"></i></a></li>
                        </ul>
                    </nav>
                    <!-- Delete Modal Box Start -->
                    <div class="modal fade theme-modal remove-coupon" id="exampleModalToggle" aria-hidden="true"
                        tabindex="-1">
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
                                            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 52 52">
                                                <circle class="checkmark__circle" cx="26" cy="26" r="25"
                                                    fill="none" />
                                                <path class="checkmark__check" fill="none"
                                                    d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                                            </svg>
                                        </div>
                                        <h4 class="text-content">Đã Xóa !</h4>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-dismiss="modal">Đóng</button>
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
        });
    </script>
@endpush