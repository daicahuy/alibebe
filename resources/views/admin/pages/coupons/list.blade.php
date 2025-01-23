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

                            <form action="{{ route('admin.coupons.destroy-selected') }}" method="POST"
                                id="delete-selected-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_coupons" id="selected_coupons">
                                <button type="submit" class="btn btn-outline btn-sm" id="btn-move-to-trash-all">
                                    {{ __('message.move_to_trash') }}
                                </button>
                            </form>

                            <a href="{{ route('admin.coupons.trash') }}"
                                class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                <i class="ri-delete-bin-line"></i>
                                {{ __('message.trash') }}
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $couponsIntrash }}</span>
                            </a>
                        </div>

                        <div class="datepicker-wrap">

                        </div>

                        <form action="" method="GET">
                            <div class="row">
                                <div class="table-search col-sm-6">
                                    <label for="role-search" class="form-label">Tìm Kiếm:</label>
                                    <input type="search" id="role-search" name="searchKey" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn-theme">Search</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div>
                        <div class="table-responsive datatable-wrapper border-table mt-3">
                            <table class="table all-package theme-table no-footer">
                                <thead>
                                    <tr>
                                        <th class="sm-width">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="checkbox-table"
                                                    class="custom-control-input checkbox_animated">
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
                                        <th>Nhóm Người Dùng</th>
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
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="checkbox-table" value="{{ $coupon->id }}"
                                                        class="custom-control-input checkbox_animated checkbox-input">
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
                                                <div>{{ $coupon->user_group }}</div>
                                            </td>
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" class="coupon-status-toggle"
                                                            id="status-{{ $coupon->id }}" name="is_active"
                                                            value="{{ $coupon->is_active }}"
                                                            @if ($coupon->is_active === 1) checked @endif>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ $coupon->is_expired === 1 ? 'Có Thời Hạn' : 'Vĩnh Viễn' }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ $coupon->start_date? \Carbon\Carbon::parse($coupon->start_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A'): 'N/A' }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ $coupon->end_date? \Carbon\Carbon::parse($coupon->end_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A'): 'N/A' }}
                                            </td>
                                            <td class="cursor-pointer">
                                                {{ !isset($coupon->end_date) && $coupon->end_date <= now() && $coupon->is_expired === 1 ? 'Hết Hạn' : 'Chưa Hết Hạn' }}
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
            // --- Logic Checkbox ---
            $('#btn-move-to-trash-all').addClass('visually-hidden');

            $('#checkbox-table').on('click', function() {
                $('#btn-move-to-trash-all').toggleClass('visually-hidden', !$(this).prop('checked'));
                $('.checkbox-input').prop('checked', $(this).prop('checked'));
                updateSelectedCoupons();
            });

            $('.checkbox-input').on('click', function() {
                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;
                $('#checkbox-table').prop('checked', total === checked);
                updateSelectedCoupons();
            });

            function updateSelectedCoupons() {
                let selectedCoupons = [];
                $('.checkbox-input:checked').each(function() {
                    selectedCoupons.push($(this).val());
                });
                $('#selected_coupons').val(selectedCoupons.join(
                    ',')); // Cập nhật input hidden với danh sách selected
                $('#btn-move-to-trash-all').toggleClass('visually-hidden', selectedCoupons.length === 0);
            }
            // --- End Logic Checkbox ---

            // Phân Dòng 10 , 30 , 50 , 100
            $('#per_page').change(function() {
                var perPage = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });
            // Cập Nhật Trạng Thái
            $('.coupon-status-toggle').change(function() {
                var couponId = $(this).attr('id').split('-')[1];
                var newStatus = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '/admin/coupons/update-coupon-status/' + couponId,
                    method: 'POST',
                    data: {
                        is_active: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                       
                    },
                    error: function(xhr, status, error) {
                        
                    }
                });
            });

        });
    </script>
@endpush
