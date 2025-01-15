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
    @if (session()->has('success'))
        <div class="alert alert-primary" role="alert">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header">
                        <div class="d-flex align-items-center">
                            <h5>Mã Giảm Giá</h5>
                        </div>
                        <div button="button">
                            <a class="align-items-center btn btn-theme d-flex" href="{{ route('admin.coupons.create') }}">
                                <i class="ri-add-line"></i> Thêm Mã Giảm Giá
                            </a>
                        </div>
                    </div>
                    <div class="show-box">
                        <div class="selection-box"><label>Hiển Thị:</label>
                            <select class="form-control">
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <label>Số Lượng Mỗi Trang</label>
                        </div>
                        <div class="datepicker-wrap"></div>
                        <div class="table-search">
                            <label for="role-search" class="form-label">Tìm Kiếm:</label>
                            <input type="search" id="role-search" class="form-control">
                        </div>
                    </div>
                    <div>
                        <div class="table-responsive datatable-wrapper border-table">
                            <table class="table all-package theme-table no-footer">
                                <thead>
                                    <tr>
                                        <th class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="check-all"
                                                    class="custom-control-input checkbox_animated">
                                                <label for="table-checkbox" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th class="sm-width"> STT </th>
                                        <th class="cursor-pointer"> Mã Giảm
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Ngày Bắt Đầu
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Ngày Kết Thúc
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th> Trạng Thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input checkbox_animated"
                                                        id="table-checkbox-item-{{ $coupon->id }}"
                                                        value="{{ $coupon->id }}">
                                                    <label class="custom-control-label"
                                                        for="table-checkbox-item-{{ $coupon->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width">{{ $coupon->id }}</td>
                                            <td class="cursor-pointer">
                                                <div>{{ $coupon->code }}</div>
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ \Carbon\Carbon::parse($coupon->start_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ \Carbon\Carbon::parse($coupon->end_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') }}
                                            </td>
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" id="status-{{ $coupon->id }}"
                                                            value="{{ $coupon->is_active }}"
                                                            @if ($coupon->is_active === 1) checked @endif>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <form action="{{ route('admin.coupons.restore', $coupon->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="btn-restore">
                                                                <i class="ri-refresh-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.coupons.force-destroy', $coupon->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-delete"
                                                                onclick="return confirm('{{ __('message.confirm_move_to_trash_item') }}')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- END TABLE -->

                <!-- START PAGINATION -->
                <div class="custom-pagination">
                    {{ $coupons->links() }}
                </div>
                <!-- END PAGINATIOn -->
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
            // Khi checkbox "Check All" thay đổi
            $('#check-all').change(function() {
                // Lấy tất cả các checkbox trong bảng và thay đổi trạng thái của chúng
                $('.custom-control-input.checkbox_animated').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endpush
