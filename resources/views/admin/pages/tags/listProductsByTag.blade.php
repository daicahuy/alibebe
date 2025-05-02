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
                                    <a class="link" href="{{ route('admin.tags.index') }}">{{ __('form.tags') }}</a>
                                    <span class="fs-6 fw-light">></span> Product
                                </h5>
                            </div>
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
                                <form action="{{ route('admin.tags.destroy') }}" method="POST" id="delete-all-form">
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
                            <div class="datepicker-wrap">

                            </div>

                            <form action="{{ route('admin.tags.index') }}" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword"
                                        value="{{ request('_keyword') }}" placeholder="Tìm kiếm theo tên ">
                                </div>
                            </form>

                        </div>
                        <!-- END HEADER TABLE -->
 --}}


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
                                                            src="{{ Storage::url($product->thumbnail) }}">
                                                    </td>
                                                    <td class="cursor-pointer">

                                                        <a href="#!" class="fs-6 fw-bold w-100">
                                                            {{ number_format($product->price, 0, ',', '.') }} ₫
                                                        </a>

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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: "{{ session('success') }}",
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    @endif
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Thất Bại!',
            text: "{{ session('error') }}",
            showConfirmButton: true,
            confirmButtonText: 'OK'
        });
    @endif
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
            window.location.href = url.toString();
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
