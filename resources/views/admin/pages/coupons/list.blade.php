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
                                href="{{ route('admin.coupons.create') }}"><i class="ri-add-line"></i> Thêm Mã Giảm Giá </a>
                        </div>
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
                                                <li>
                                                    <a href="#!" class="btn-detail">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.coupons.edit', ['coupon' => 1]) }}" class="btn-edit">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete" onclick="return confirm('{{ __('message.confirm_move_to_trash_item') }}')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
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
        </div>
    </div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script></script>
@endpush
