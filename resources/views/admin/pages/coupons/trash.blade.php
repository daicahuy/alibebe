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
                            <a class="link" href="{{ route('admin.coupons.index') }}">{{ __('form.coupons') }}</a>
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
                            <form action="{{ route('admin.coupons.restore-selected') }}" method="POST"
                                id="restore-selected-form">
                                @csrf
                                <input type="hidden" name="selected_coupons" id="selected_coupons_restore">
                                <button type="submit" class="btn btn-outline btn-sm" style="display:none;"
                                    id="btn-restore-coupon-all">
                                    {{ __('message.restore') }}
                                </button>
                            </form>

                            <form action="{{ route('admin.coupons.force-destroy-selected') }}" method="POST"
                                id="destroy-selected-form">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected_coupons" id="selected_coupons_delete">
                                <button type="submit" class="btn btn-outline-danger btn-sm" style="display:none;"
                                    id="btn-force-delete">
                                    {{ __('message.delete_all') }}
                                </button>
                            </form>
                        </div>

                        <div class="datepicker-wrap">

                        </div>

                    <div class="table-responsive datatable-wrapper border-table">
                        <table class="table all-package theme-table no-footer">
                            <thead>
                                <tr>
                                    <th class="sm-width">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" id="checkbox-table"
                                                class="custom-control-input checkbox_animated">
                                        </div>
                                    </th>
                                    <th class="sm-width cursor-pointer">
                                        <a
                                            href="{{ route('admin.coupons.trash', ['sortField' => 'id', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
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
                                            href="{{ route('admin.coupons.trash', ['sortField' => 'code', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
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
                                            href="{{ route('admin.coupons.trash', ['sortField' => 'title', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
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
                                            href="{{ route('admin.coupons.trash', ['sortField' => 'start_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
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
                                        href="{{ route('admin.coupons.trash', ['sortField' => 'end_date', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
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
                                    <th class="cursor-pointer">
                                        <a
                                        href="{{ route('admin.coupons.trash', ['sortField' => 'deleted_at', 'sortDirection' => request('sortDirection') === 'asc' ? 'desc' : 'asc']) }}">
                                        {{__('form.coupon.deleted_at')}}
                                        @if (request('sortField') === 'deleted_at')
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
                                        <td colspan="8">Không có mã giảm giá nào trong thùng rác.</td>
                                    </tr>
                                @else
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
                                                <div>{{ $coupon->title }}</div>
                                            </td>
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" id="status-{{ $coupon->id }}"
                                                            value="{{ $coupon->is_active }}"
                                                            @if ($coupon->is_active === 1) checked @endif disabled>
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
                                            <td class="cursor-pointer">
                                                {{ $coupon->deleted_at ? \Carbon\Carbon::parse($coupon->deleted_at)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') : 'N/A' }}
                                            </td>
                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <form action="{{ route('admin.coupons.restore', $coupon->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button class="btn-restore"
                                                                onclick="return confirm('{{ __('message.confirm_restore_out_trash_item') }}')">
                                                                <i class="ri-refresh-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.coupons.force-destroy', $coupon->id) }}"
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
                $('#btn-restore-coupon-all').css('display', !$(this).prop('checked') ? 'none' : 'block');
                $('#btn-force-delete').css('display', $('.checkbox-input:checked').length > 0 ? 'block' :
                    'none');
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

                // Cập nhật giá trị cho từng form
                $('#selected_coupons_restore').val(selectedCoupons.join(','));
                $('#selected_coupons_delete').val(selectedCoupons.join(','));

                // Hiển thị nút nếu có coupon được chọn
                $('#btn-restore-coupon-all').css('display', selectedCoupons.length === 0 ? 'none' : 'block');
                $('#btn-force-delete').css('display', selectedCoupons.length === 0 ? 'none' : 'block');
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
        });
    </script>
@endpush
