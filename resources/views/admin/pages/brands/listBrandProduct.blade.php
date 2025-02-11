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
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fuild">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>
                                    <a class="link" href="{{ route('admin.brands.index') }}">{{ __('form.brands') }}</a>
                                    <span class="fs-6 fw-light">></span> Product
                                </h5>
                            </div>
                            {{-- <div>
                                <a class="align-items-center btn btn-theme d-flex" href="{{ route('admin.brands.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.brands') }}
                                </a>
                            </div> --}}
                        </div>

                        {{-- <!-- HEADER TABLE -->
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <select class="form-control" id="per_page">
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <label>{{ __('message.items_per_page') }}</label>
                                <form action="{{ route('admin.brands.destroy') }}" method="POST" id="delete-all-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="ids" id="ids-to-delete" value="">
                                    <button
                                        class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                        id="btn-delete-all">
                                        {{ __('message.delete_all') }}
                                    </button>
                                </form>
                                <a href="{{ route('admin.brands.hidden') }}"
                                    class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2">
                                    Ẩn
                                </a>

                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <form action="{{ route('admin.brands.index') }}" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword"
                                        value="{{ request('_keyword') }}" placeholder="Tìm kiếm theo tên ">
                                </div>
                            </form>

                        </div>
                        <!-- END HEADER TABLE --> --}}

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
                                            <th class="sm-width">STT</th>   
                                            <th class="cursor-pointer">
                                                {{ __('form.product.name') }}
                                            </th>
                                            <th>
                                                {{ __('form.product.is_active') }}
                                            </th>
                                            <th>{{ __('form.product.thumbnail') }}</th>
                                            <th>{{ __('form.product.price') }}</th>
                                            <th>{{ __('form.product.type') }}</th>
                                            <th>{{ __('form.product.start_at') }} 
                                            <th>{{ __('form.product.created_at') }} 
                                            </th>
                                            <th>{{ __('form.product.updated_at') }} </th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($products->isEmpty())
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <div class="alert alert-warning m-0">
                                                        {{ __('Không có bản ghi nào phù hợp với tìm kiếm của bạn.') }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @php
                                                $index = $products->total() - ($products->currentPage() - 1) * $products->perPage();
                                            @endphp
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" id="checkbox-table"
                                                                class="custom-control-input checkbox_animated checkbox-input"
                                                                value="{{ $product->id }}">
                                                        </div>
                                                    </td>
                                                    <td class="cursor-pointer sm-width">
                                                        {{ $index-- }}
                                                    </td>
                                                    
                                                    <td class="cursor-pointer">

                                                        <a href="#!"
                                                            class="fs-6 fw-bold w-100">{{ $product->name }}</a>

                                                    </td>

                                                    <td class="cursor-pointer">
                                                        <div class="form-check form-switch ps-0">
                                                            <label class="switch switch-sm">
                                                                <input type="checkbox" id="status-{{ $product->id }}"
                                                                    value="1" data-id="{{ $product->id }}"
                                                                    class="update-status"
                                                                    {{ $product->is_active ? 'checked' : '' }}>
                                                                <span class="switch-state"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="cursor-pointer sm-width">
                                                        <img alt="image" class="tbl-image "
                                                            style="max-height: 200px; object-fit: contain;"
                                                            src="{{ Storage::url($product->logo) }}">
                                                    </td>
                                                    <td class="cursor-pointer">

                                                        <a href="#!"
                                                            class="fs-6 fw-bold w-100">{{ $product->price }}</a>

                                                    </td>
                                                    <td class="cursor-pointer">

                                                        <a href="#!"
                                                            class="fs-6 fw-bold w-100">{{ $product->type }}</a>

                                                    </td>
                                                    <td class="cursor-pointer">

                                                        {{ $product->start_at }}

                                                    </td>
                                                    <td class="cursor-pointer">

                                                        {{ $product->created_at }}

                                                    </td>
                                                    <td class="cursor-pointer">

                                                        {{ $product->updated_at }}

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
                            {{ $products->appends(request()->query())->links() }}
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
                e.preventDefault();

                let selectedIds = [];
                $('.checkbox-input:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");
                    if (confirmMessage) {
                        const firstId = selectedIds[0]; // Lấy ID đầu tiên làm tham số `brand`
                        const form = $('#delete-all-form');

                        // Cập nhật action URL của form với giá trị `brand`
                        form.attr('action', form.attr('action').replace('/0', `/${firstId}`));

                        // Gán danh sách ID vào input ẩn
                        $('#ids-to-delete').val(selectedIds.join(','));
                        form.submit();
                    }
                } else {
                    alert("{{ __('message.no_item_selected') }}");
                }
            });

        });


        // #
        $('#per_page').change(function() {

            var perPage = $(this).val();
            var url = new URL(window.location.href);

            url.searchParams.set('per_page', perPage);
            if ($('input[name="_keyword"]').val()) {
                url.searchParams.set('_keyword', $('input[name="_keyword"]').val());
            }
            window.location.href = url.toString();
        });

        // cập nhật is_active
        $(document).ready(function() {
            $('.update-status').on('change', function() {
                let brandId = $(this).data('id'); // ID thương hiệu
                let status = $(this).is(':checked') ? 1 : 0; // Trạng thái mới

                $.ajax({
                    url: '/api/brands/' + brandId + '/status',
                    type: 'PUT',
                    data: {
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
                    },
                    success: function(response) {
                        console.log(response); // Log phản hồi
                        // Hiển thị modal thành công với icon tích xanh và nút OK
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            showConfirmButton: true, // Hiển thị nút OK
                            confirmButtonText: 'OK' // Đặt nội dung nút
                        }).then(() => {
                            location.reload(); // Reload trang sau khi nhấn OK
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText); // Log chi tiết lỗi
                        // Hiển thị modal lỗi với icon đỏ
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra, vui lòng thử lại!',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        // 
        function sortTable(column) {
            // Lấy URL hiện tại
            let url = new URL(window.location.href);

            // Kiểm tra chiều sắp xếp hiện tại
            let currentDirection = url.searchParams.get('order') || 'desc';
            let newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

            // Cập nhật query parameters
            url.searchParams.set('sort', column);
            url.searchParams.set('order', newDirection);

            // Điều hướng tới URL mới
            window.location.href = url.toString();
        }
        // paginate
        function changePerPage(perPage) {
            let params = new URLSearchParams(window.location.search);
            params.set('perpage', perPage); // Cập nhật giá trị perpage
            window.location.href = "{{ route('admin.brands.index') }}?" + params.toString();
        }
    </script>
@endpush
