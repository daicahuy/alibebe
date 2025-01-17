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

    @if ($errors->has('message'))
        <div class="alert alert-danger" role="alert">
            <strong>{{ $errors->first('message') }}</strong>
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
                        <div class="selection-box">
                            <label>Hiển Thị:</label>
                            <select class="form-control" id="per_page">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            <label>Số Lượng Mỗi Trang</label>
                        </div>
                        <div class="table-search">
                            <label for="role-search" class="form-label">Tìm Kiếm:</label>
                            <input type="search" id="role-search" name="searchKey" class="form-control">
                        </div>
                        <a href="{{ route('admin.coupons.trash') }}"
                            class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                            <i class="ri-delete-bin-line"></i>
                            {{ __('message.trash') }}
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $couponsIntrash }}</span>
                        </a>
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
                                        <th class="cursor-pointer"> Mã Giảm Giá
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Loại Giảm Giá
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Giá Trị Giảm Giá
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Số Lần Sử Dụng Tối Đa
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Số Mã Đã Được Sử Dụng
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th>Đang Hoạt Động</th>
                                        <th>Có Hạn</th>
                                        <th class="cursor-pointer"> Ngày Bắt Đầu
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th class="cursor-pointer"> Ngày Kết Thúc
                                            <div class="filter-arrow"></div>
                                        </th>
                                        <th>Trạng Thái</th>
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
                                                <div>
                                                    {{ $coupon->discount_type === 0 ? 'Giảm Theo Giá Cố Định' : 'Giảm Theo Phần Trăm' }}
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">
                                                <div>{{ $coupon->discount_value }}</div>
                                            </td>
                                            <td class="cursor-pointer">
                                                <div>{{ $coupon->usage_limit }}</div>
                                            </td>
                                            <td class="cursor-pointer">
                                                <div>{{ $coupon->usage_count }}</div>
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
                                            <td class="cursor-pointer">
                                               {{ $coupon->is_expired === 1 ? 'Có Thời Hạn' : 'Không Có Thời Hạn'}}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ \Carbon\Carbon::parse($coupon->start_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ \Carbon\Carbon::parse($coupon->end_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ $coupon->end_date <= now() ? 'Hết Hạn' : 'Chưa Hết Hạn' }}
                                            </td>                                            
                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="{{ route('admin.coupons.show', ['coupon' => $coupon->id]) }}"
                                                            class="btn-detail">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.coupons.edit', ['coupon' => $coupon->id]) }}"
                                                            class="btn-edit">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}"
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
            // Phân Dòng 10 , 30 , 50 , 100
            $('#per_page').change(function() {
                var perPage = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });
        });
    </script>
@endpush
