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
    <!-- Kiểm tra thông báo flash -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="title-header">
                        <div class="d-flex align-items-center">
                            <h5>{{ __('form.coupons_hide') }}</h5>
                        </div>
                        <div>
                            <a class="align-items-center btn btn-theme d-flex" href="{{ route('admin.coupons.create') }}">
                                <i class="ri-add-line"></i>
                                {{ __('message.add') . ' ' . __('form.coupons') }}
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

                            <form action="{{ route('admin.coupons.destroy-selected') }}" method="POST"
                                id="delete-selected-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_coupons" id="selected_coupons">
                                <button type="submit" class="btn btn-outline btn-sm" style="display:none;"
                                    id="btn-move-to-trash-all">
                                    {{ __('message.move_to_trash') }}
                                </button>
                            </form>

                            <a href="{{ route('admin.coupons.index') }}"
                                class="align-items-center btn btn-theme btn-sm d-flex position-relative ms-2">
                                {{__('form.coupons')}}
                            </a>
                    
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

                        <form action="{{ route('admin.coupons.search') }}" method="GET">
                            <div class="row">
                                <div class="table-search col-sm-8">
                                    <label for="role-search" class="form-label">Tìm Kiếm:</label>
                                    <input type="search" id="role-search" name="searchKey" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-theme">Search</button>
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
                                        <th class="sm-width">STT</th>
                                        <th class="sm-width cursor-pointer">
                                            <a
                                                href="{{ route('admin.coupons.hide', ['sortField' => 'id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                                ID
                                                @if (request('sortField') === 'id')
                                                    <div class="filter-arrow">
                                                        <div>
                                                            <i
                                                                class="ri-arrow-{{ request('sortDirection') === 'asc' ? 'up' : 'down' }}-s-fill"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="cursor-pointer">
                                            <a
                                                href="{{ route('admin.coupons.hide', ['sortField' => 'code', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                                {{__('form.coupon.code')}}
                                                @if (request('sortField') === 'code')
                                                    <div class="filter-arrow">
                                                        <div>
                                                            <i
                                                                class="ri-arrow-{{ request('sortDirection') === 'asc' ? 'up' : 'down' }}-s-fill"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="cursor-pointer">
                                            <a
                                                href="{{ route('admin.coupons.hide', ['sortField' => 'title', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                                {{__('form.coupon.title')}}
                                                @if (request('sortField') === 'title')
                                                    <div class="filter-arrow">
                                                        <div>
                                                            <i
                                                                class="ri-arrow-{{ request('sortDirection') === 'asc' ? 'up' : 'down' }}-s-fill"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </a>
                                        </th>
                                        <th>{{__('form.coupon.is_active')}}</th>
                                        <th class="cursor-pointer">
                                            <a
                                                href="{{ route('admin.coupons.hide', ['sortField' => 'start_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                                {{__('form.coupon.start_date')}}
                                                @if (request('sortField') === 'start_date')
                                                    <div class="filter-arrow">
                                                        <div>
                                                            <i
                                                                class="ri-arrow-{{ request('sortDirection') === 'asc' ? 'up' : 'down' }}-s-fill"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="cursor-pointer">
                                            <a
                                            href="{{ route('admin.coupons.hide', ['sortField' => 'end_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                            {{__('form.coupon.end_date')}}
                                            @if (request('sortField') === 'end_date')
                                                <div class="filter-arrow">
                                                    <div>
                                                        <i
                                                            class="ri-arrow-{{ request('sortDirection') === 'asc' ? 'up' : 'down' }}-s-fill"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </a>
                                        </th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($coupons->isEmpty())
                                        <tr>
                                            <td colspan="8">Không có mã giảm giá nào trong danh sách.</td>
                                        </tr>
                                    @else
                                        @foreach ($coupons as $key => $coupon)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="checkbox-table"
                                                            value="{{ $coupon->id }}"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">{{$key + 1}}</td>
                                                <td class="cursor-pointer sm-width">{{ $coupon->id }}</td>
                                                <td class="cursor-pointer">
                                                    <div>{{ $coupon->code }}</div>
                                                </td>
                                                <td class="cursor-pointer">
                                                    <div>{{ $coupon->title }}</div>
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
                                                    {{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') : 'N/A' }}
                                                </td>
                                                <td class="cursor-pointer">
                                                    {{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') : 'N/A' }}
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
                                                            <form
                                                                action="{{ route('admin.coupons.destroy', $coupon->id) }}"
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
                                    @endif
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
            $('#checkbox-table').on('click', function() {
                $('#btn-move-to-trash-all').css('display', !$(this).prop('checked') ? 'none' : 'block');
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
                $('#selected_coupons').val(selectedCoupons.join(','));
                $('#btn-move-to-trash-all').css('display', selectedCoupons.length === 0 ? 'none' : 'block');
            }
            // --- End Logic Checkbox ---

            @if (session()->has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: '{{ session('success') }}',
                    timer: 2000
                });
            @endif

            @if ($errors->has('message'))
                Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: '{{ $errors->first('message') }}',
                    showConfirmButton: true
                });
            @endif

            // Phân Dòng 10 , 30 , 50 , 100
            $('#per_page').change(function() {
                var perPage = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });

            // Cập Nhật Trạng Thái
            $('.coupon-status-toggle').on('change', function() {
                const $toggle = $(this);
                var couponId = parseInt($(this).attr('id').split('-')[1]);
                const newStatus = $toggle.is(':checked') ? 1 : 0;

                $.ajax({
                    url: `/api/admin/coupons/update-coupon-status/${couponId}`,
                    method: 'POST',
                    data: {
                        is_active: newStatus,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response from server:', response);
                        Swal.fire({
                            icon: response.status ? 'success' : 'error',
                            // title: response.status ? 'Thành công!' : 'Lỗi!',
                            text: response.message,
                            timer: response.status ? 1500 : undefined,
                            showConfirmButton: response.status
                        }).then(() => {
                            if (response.status) {
                                $toggle.prop('checked', newStatus === 1);
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON ?
                            xhr.responseJSON.message :
                            'Có lỗi xảy ra khi gửi yêu cầu';
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: errorMessage
                        });
                    }
                });
            });
        });
    </script>
@endpush
