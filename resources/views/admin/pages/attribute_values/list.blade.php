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

    <div class="container-fuild">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>
                                    <a class="link"
                                        href="{{ route('admin.attributes.index') }}">{{ __('form.attributes') }}</a>
                                    <span class="fs-6 fw-light">></span> {{ $attribute->name }}

                                </h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex"
                                    href="{{ route('admin.attributes.attribute_values.create', ['attribute' => $attribute->id]) }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.attribute_values') }}
                                </a>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        @php
                            // Lấy tất cả tham số hiện tại (trừ 'perpage')
                            $queryParams = request()->except('perpage');
                        @endphp
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <select class="form-control" onchange="window.location.href=this.value;">
                                    <option
                                        value="{{ route('admin.attributes.attribute_values.index', ['attribute' => $attribute->id, 'perpage' => 15]) }}"
                                        @if (request()->input('perpage') == 15) selected @endif>
                                        15
                                    </option>
                                    <option
                                        value="{{ route('admin.attributes.attribute_values.index', ['attribute' => $attribute->id, 'perpage' => 30]) }}"
                                        @if (request()->input('perpage') == 30) selected @endif>
                                        30
                                    </option>
                                    <option
                                        value="{{ route('admin.attributes.attribute_values.index', ['attribute' => $attribute->id, 'perpage' => 45]) }}"
                                        @if (request()->input('perpage') == 45) selected @endif>
                                        45
                                    </option>
                                </select>
                                <label>{{ __('message.items_per_page') }}</label>
                                <form
                                    action="{{ route('admin.attributes.attribute_values.destroy', ['attribute' => $attribute->id]) }}"
                                    method="POST" id="delete-all-form">
                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="ids" id="ids-to-delete" value="">
                                    <button
                                        class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                        id="btn-delete-all">
                                        {{ __('message.delete_all') }}
                                    </button>

                                </form>

                            </div>
                            <div class="position-relative d-inline-block">
                                <a href="{{ route('admin.attributes.attribute_values.hidden', ['attribute' => $attribute->id]) }}"
                                   class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2">
                                    Ẩn
                                </a>
                                @if($hiddenCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $hiddenCount }}
                                    </span>
                                @endif
                                @if($hiddenCount == 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    0
                                </span>
                            @endif
                        </div>

                            <div class="datepicker-wrap">

                            </div>

                            <form action="" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" placeholder="Tên giá trị thuộc tính">
                                </div>
                            </form>

                        </div>
                        <!-- END HEADER TABLE -->



                        <!-- START TABLE -->
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
                                            <th>
                                                STT
                                            </th>
                                            <th class="cursor-pointer">
                                                {{ __('form.attribute_value.value') }}
                                                <div class="filter-arrow" onclick="sortTable('value')">
                                                    <div>
                                                        <i
                                                            class="{{ request()->get('sortColumn') === 'value' && request()->get('sortDirection') === 'asc'
                                                                ? 'ri-arrow-up-s-fill'
                                                                : (request()->get('sortColumn') === 'value' && request()->get('sortDirection') === 'desc'
                                                                    ? 'ri-arrow-down-s-fill'
                                                                    : 'ri-arrow-down-s-fill') }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.attribute_value.is_active') }}
                                                <div class="filter-arrow">

                                                </div>
                                            </th>
                                            <th>{{ __('form.attribute_value.created_at') }}
                                                <div class="filter-arrow" onclick="sortTable('created_at')">
                                                    <div>
                                                        <i
                                                            class="{{ request()->get('sortColumn') === 'created_at' && request()->get('sortDirection') === 'asc'
                                                                ? 'ri-arrow-up-s-fill'
                                                                : (request()->get('sortColumn') === 'created_at' && request()->get('sortDirection') === 'desc'
                                                                    ? 'ri-arrow-down-s-fill'
                                                                    : 'ri-arrow-down-s-fill') }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.attribute_value.updated_at') }}
                                                <div class="filter-arrow" onclick="sortTable('updated_at')">
                                                    <div>
                                                        <i
                                                            class="{{ request()->get('sortColumn') === 'updated_at' && request()->get('sortDirection') === 'asc'
                                                                ? 'ri-arrow-up-s-fill'
                                                                : (request()->get('sortColumn') === 'updated_at' && request()->get('sortDirection') === 'desc'
                                                                    ? 'ri-arrow-down-s-fill'
                                                                    : 'ri-arrow-down-s-fill') }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($attributeValues->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <strong>Không có dữ liệu phù hợp</strong>
                                                </td>
                                            </tr>
                                        @endif
                                        @php 
                                           $index = ($attributeValues->currentPage() - 1) * $attributeValues->perPage() + 1;
                                        @endphp
                                        @foreach ($attributeValues as $atb_value)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="checkbox-table"
                                                            value="{{ $atb_value->id }}"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td>{{ $index++ }}</td>
                                                <td class="cursor-pointer">
                                                    {{ $atb_value->value }}
                                                </td>

                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm"><input type="checkbox"
                                                                id="status-{{ $atb_value->id }} "{{ $atb_value->is_active ? 'checked' : '' }}
                                                                onchange="updateStatus({{ $attribute->id }}, this, {{ $atb_value->id }})"
                                                                value="1"><span class="switch-state"></span></label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $atb_value->created_at }}

                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $atb_value->updated_at }}

                                                </td>


                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.attributes.attribute_values.edit', ['attribute' => $attribute->id, 'attributeValue' => $atb_value->id]) }}"
                                                                class="btn-edit">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.attributes.attribute_values.destroy', ['attribute' => $attribute->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="id"
                                                                    value="{{ $atb_value->id }}">
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
                        <!-- END TABLE -->


                        <!-- START PAGINATION -->
                        <div class="custom-pagination">
                            {{ $attributeValues->appends(request()->query())->links() }}
                        </div>
                        <!-- END PAGINATIOn -->

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
            @if(session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: "{{ session('success') }}",
                                timer: 1500,
                                showConfirmButton: true
                            });
                    @endif

                    @if(session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: "{{ session('error') }}",
                                showConfirmButton: true
                            });
                    @endif
            // --- Logic Checkbox ---
            $('#checkbox-table').on('click', function() {

                if ($(this).prop('checked')) {
                    $('#btn-delete-all').removeClass('visually-hidden');
                } else {
                    $('#btn-delete-all').addClass('visually-hidden');
                }

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#checkbox-table').prop('checked', total === checked);

                if ($(this).prop('checked')) {
                    $('#btn-delete-all').removeClass('visually-hidden');
                } else {
                    let isAnotherInputChecked = false;
                    $('.checkbox-input').not($(this)).each((index, checkboxInput) => {
                        if ($(checkboxInput).prop('checked')) {
                            isAnotherInputChecked = true;
                            return;
                        }
                    })

                    if (!isAnotherInputChecked) {
                        $('#btn-delete-all').addClass('visually-hidden');
                        $('#checkbox-table').prop('checked', false);
                    }
                }
            });
            // --- End Logic Checkbox ---

            $('#btn-delete-all').on('click', function(e) {
                // Ngăn không cho form submit ngay lập tức
                e.preventDefault();

                // Lấy tất cả ID của các mục đã chọn
                let selectedIds = [];
                $('.checkbox-input:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    // Hiển thị hộp thoại xác nhận
                    let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");

                    if (confirmMessage) {
                        // Gửi request xóa tất cả các mục đã chọn
                        $('#delete-all-form').find('input[name="ids"]').val(selectedIds.join(','));
                        $('#delete-all-form').submit(); // Submit form để xóa các mục
                    }
                } else {
                    alert("{{ __('message.no_item_selected') }}");
                }
            })

        });

        // {{-- Sắp xếp --}}
        function sortTable(column) {
            // Lấy URL hiện tại
            let url = new URL(window.location.href);

            // Kiểm tra chiều sắp xếp hiện tại
            let currentDirection = url.searchParams.get('sortDirection') || 'desc';
            let newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

            // Cập nhật query parameters
            url.searchParams.set('sortColumn', column);
            url.searchParams.set('sortDirection', newDirection);

            // Điều hướng tới URL mới
            window.location.href = url.toString();
        }

        // Update Is_active
        function updateStatus(attributeId, checkbox, attributeValueId = null) {
            const isActive = checkbox.checked ? 1 : 0; // 1 nếu bật, 0 nếu tắt

            // URL sẽ thay đổi tùy vào việc cập nhật attribute hay attribute_value
            let url = `/api/attributes/${attributeId}`;
            if (attributeValueId) {
                url += `/attribute_values/${attributeValueId}`;
            }

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        is_active: isActive
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.success ? 'success' : 'error',
                        title:'Thành công!',
                        text: data.message || (data.success ? 'Cập nhật thành công' : 'Cập nhật thất bại'),
                        timer: data.success ? 1500 : undefined,
                        showConfirmButton: true
                    }).then(() => {
                        if (data.success) {
                            location.reload(); // Reload lại trang sau khi xác nhận
                        } else {
                            checkbox.checked = !isActive; // Hoàn tác nếu thất bại
                        }
                    });
                })
                .catch(error => {
                    console.error('Lỗi:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại sau!'
                    });

                    checkbox.checked = !isActive; // Hoàn tác nếu xảy ra lỗi
                });
            // paginate
            function changePerPage(perPage) {
                let params = new URLSearchParams(window.location.search);
                params.set('perpage', perPage); // Cập nhật giá trị perpage
                window.location.href = "{{ route('admin.attributes.index') }}?" + params.toString();
            }
        }
    </script>
@endpush
