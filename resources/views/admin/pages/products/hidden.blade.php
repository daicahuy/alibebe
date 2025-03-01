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
                                    <a class="link" href="{{ route('admin.products.index') }}">{{ __('form.products') }}</a>
                                    <span class="fs-6 fw-light">></span> {{ __('message.hidden') }}
                                </h5>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <form action="{{ route('admin.products.hidden') }}" method="GET" id="filterForm">

                            <div class="show-box">
                                <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                    <label for="perPageSelect">{{ __('message.show') }} :</label>
                                    <select id="perPageSelect" class="form-control" name="per_page"
                                        onchange="document.getElementById('filterForm').submit();">
                                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15
                                        </option>
                                        <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30
                                        </option>
                                        <option value="45" {{ $perPage == 45 ? 'selected' : '' }}>45
                                        </option>
                                    </select>
                                    <label>{{ __('message.items_per_page') }}</label>
                                    <button type="button"
                                        class="align-items-center btn btn-outline btn-sm d-flex ms-2 visually-hidden"
                                        id="btn-restore-all">
                                        {{ __('message.restore_all') }}
                                    </button>
                                    <button type="button"
                                        class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                        id="btn-delete-all">
                                        {{ __('message.delete_all') }}
                                    </button>
                                </div>
                                <div class="datepicker-wrap">

                                </div>

                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" id="role-search"
                                        value="{{ $keyword ?? '' }}">
                                    <button type="submit" class="btn btn-primary">{{ __('message.search') }}</button>
                                </div>

                            </div>
                        </form>

                        <!-- END HEADER TABLE -->



                        <!-- START TABLE -->
                        <div>
                            <div class="table-responsive datatable-wrapper border-table mt-3">
                                <table class="table all-package theme-table no-footer">
                                    <thead>
                                        <tr>
                                            <th class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="select-all"
                                                        class="custom-control-input checkbox_animated">
                                                </div>
                                            </th>
                                            <th class="sm-width">
                                                {{ __('form.product.id') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.product.sku') }}</th>
                                            <th class="cursor-pointer sm-width">{{ __('form.images') }}</th>
                                            <th class="cursor-pointer">
                                                {{ __('form.product.name') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th class="cursor-pointer">{{ __('form.categories') }}</th>
                                            <th class="cursor-pointer">
                                                {{ __('form.product.price') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th class="cursor-pointer">
                                                {{ __('form.product_stocks') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th class="cursor-pointer">{{ __('form.product_stock_status') }}</th>
                                            <th class="cursor-pointer">{{ __('form.product.is_active') }}</th>
                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listHidden as $trash)
                                            <tr>
                                                <td class="sm-width">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="ids[]" value="{{ $trash->id }}"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width">{{ $trash->id }}</td>
                                                <td class="cursor-pointer">{{ $trash->sku }}</td>
                                                <td class="cursor-pointer sm-width"><img alt="image" class="tbl-image"
                                                        src="{{ Storage::url($trash->thumbnail) }}">
                                                </td>
                                                <td class="cursor-pointer">{{ $trash->name }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($trash->categories->isNotEmpty())
                                                        {{ $trash->categories->pluck('name')->implode(', ') }}
                                                    @else
                                                        <span class="text-muted">Không có danh mục</span>
                                                    @endif
                                                </td>
                                                <td class="cursor-pointer">{{ $trash->price_range }} </td>
                                                <td class="cursor-pointer">{{ $trash->stock_quantity }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($trash->stock_quantity > 10)
                                                        <div class="status-in_stock">
                                                            <span>{{ __('form.product_stock_in_stock') }}</span>{{-- còn  --}}
                                                        </div>
                                                    @elseif($trash->stock_quantity > 0)
                                                        <div class="status-low_stock">
                                                            <span>{{ __('form.product_stock_low_stock') }}</span>{{-- hết  --}}
                                                        </div>
                                                    @else
                                                        <div class="status-out_of_stock">
                                                            <span>{{ __('form.product_stock_out_of_stock') }}</span>{{-- sắp hết  --}}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm">
                                                            <input type="checkbox"  class="toggle-active-products-hidden"
                                                            data-product-id="{{ $trash->id }}"
                                                                {{ $trash->is_active == 1 ? 'checked' : '' }} >
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <form action="{{ route('admin.products.restore', $trash) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn-restore">
                                                                    <i class="ri-refresh-line"></i>
                                                                </button>
                                                            </form>
                                                        </li>

                                                        <li>
                                                            <form action="{{ route('admin.products.destroy', $trash) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-delete"
                                                                    onclick="return confirm('{{ __('message.confirm_delete_item') }}')">
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
                            {{ $listHidden->links() }}
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
            $('#select-all').on('click', function() {

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
                toggleBulkActionButtons();

            });
            // toggleBulkActionButtons();

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#select-all').prop('checked', total === checked);
                toggleBulkActionButtons();

            });

            // chạy hàm khi load trang
            toggleBulkActionButtons();


            // click  button
            $('#btn-restore-all').on('click', function() {
                handleBulkAction('restore');
            });

            $('#btn-delete-all').on('click', function() {
                let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");

                if (confirmMessage) {
                    handleBulkAction('destroy');
                }

            });


            // Hàm ẩn/hiên button 
            function toggleBulkActionButtons() {
                if ($('.checkbox-input:checked').length > 0) {
                    $('#btn-restore-all').removeClass('visually-hidden');
                    $('#btn-delete-all').removeClass('visually-hidden');
                } else {
                    $('#btn-restore-all').addClass('visually-hidden');
                    $('#btn-delete-all').addClass('visually-hidden');
                }
            }



            // --- Xử lý submit bằng AJAX ---
            function handleBulkAction(action) {

                // Truyền ids vào mảng
                let checkedIds = [];
                $('.checkbox-input:checked').each(function() {
                    checkedIds.push($(this).val());
                });

                if (checkedIds.length === 0) {
                    alert("Vui lòng chọn ít nhất một mục.");
                    return;
                }

                let url = '';
                if (action === 'restore') {
                    url = "{{ route('admin.products.bulkRestore') }}";
                } else if (action === 'destroy') {
                    url = "{{ route('admin.products.bulkDestroy') }}";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulk_ids: checkedIds,
                        // _method: action === 'restore' ? 'PUT' : 'DELETE'
                    },
                    success: function(response) {
                        console.log("Response từ server:", response);

                        if (response && typeof response === 'object') { // Kiểm tra response là object
                            if (response.success === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.message,
                                    timer: 1500, // Tự động đóng sau 1.5 giây
                                    showConfirmButton: false,
                                }).then(() => {
                                    location.reload();
                                });

                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    html: response.message,
                                });
                            }
                        } else {
                            console.error("Response không đúng định dạng:", response);
                            alert("Đã có lỗi xảy ra khi xử lý yêu cầu.");
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi AJAX:", error);
                        alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                    }
                });
            }
            // --- End Logic Checkbox ---


            // update Is_active Api
            $('.toggle-active-products-hidden').change(function() {
                // console.log("Checkbox toggle-active changed!", $(this).data('category-id'), $(this).is(
                //     ':checked'));
                let $this = $(this);
                let productId = $this.data('product-id');
                let isActive = $this.is(':checked') ? 1 : 0;
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/api/products/' + productId + '/active',
                    type: 'PATCH',
                    data: {
                        is_active: isActive,
                        _token: csrfToken
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                html: response.message,
                                // timer: 1500, // Tự động đóng sau 1.5 giây
                                // showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });

                        } else {
                            console.error(response.message);
                            $this.prop('checked', !
                                isActive); // 
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Lỗi AJAX: " + textStatus + ", " + errorThrown);
                        $this.prop('checked', !isActive); // 
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            alert(jqXHR.responseJSON.message);
                        } else {
                            alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
                        }
                    }
                });
            });


            // alert
            // Kiểm tra session flash message
            let message = "{{ session('msg') }}";
            let type = "{{ session('type') }}";

            if (message && type) {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'Thành công!' : 'Lỗi!',
                    text: message,
                });
            }

        });
    </script>
@endpush
