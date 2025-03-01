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
                                <h5>{{ __('form.products') }}</h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex"
                                    href="{{ route('admin.products.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.products') }}
                                </a>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <form action="{{ route('admin.products.index') }}" method="GET" id="filterForm">

                            <div class="show-box">
                                {{-- perpage --}}
                                <div class="selection-box">

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
                                    <button class="align-items-center btn btn-outline btn-sm d-flex ms-2 visually-hidden"
                                        type="button" id="btn-move-to-trash-all">
                                        {{ __('message.move_to_trash') }}
                                    </button>
                                    <a href="{{ route('admin.products.hidden') }}"
                                        class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                        <i class="ri-folder-forbid-fill"></i>
                                        {{ __('message.hidden') }}
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $countHidden ?? 0 }}</span>
                                    </a>
                                    <a href="{{ route('admin.products.trash') }}"
                                        class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                        <i class="ri-delete-bin-line"></i>
                                        {{ __('message.trash') }}
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $countTrash ?? 0 }}</span>
                                    </a>

                                </div>
                                <div class="datepicker-wrap">

                                </div>

                                {{-- category --}}
                                <div>
                                    <select name="category_id" class="form-select"
                                        onchange="document.getElementById('filterForm').submit();">
                                        <option value="">{{ __('form.category_all') }}</option>
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"{{ $categoryId == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- stock --}}
                                <div>
                                    <select name="stock_status" class="form-select"
                                        onchange="document.getElementById('filterForm').submit();">
                                        <option value="" {{ $stockStatus == '' ? 'selected' : '' }}>
                                            {{ __('form.product_stock_status_all') }}</option>
                                        <option value="in_stock" {{ $stockStatus == 'in_stock' ? 'selected' : '' }}>
                                            {{ __('form.product_stock_in_stock') }}</option>
                                        <option value="out_of_stock"
                                            {{ $stockStatus == 'out_of_stock' ? 'selected' : '' }}>
                                            {{ __('form.product_stock_out_of_stock') }}</option>
                                        <option value="low_stock" {{ $stockStatus == 'low_stock' ? 'selected' : '' }}>
                                            {{ __('form.product_stock_low_stock') }}</option>
                                    </select>
                                </div>

                                {{-- search --}}
                                {{-- <form action="" method="GET"> --}}
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" id="role-search"
                                        value="{{ $keyword ?? '' }}">
                                    <button type="submit" class="btn btn-primary">{{ __('message.search') }}</button>
                                </div>
                                {{-- </form> --}}


                            </div>
                        </form>

                        <!-- END HEADER TABLE -->



                        <!-- START TABLE -->
                        <div>
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
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="sm-width">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="" value="{{ $product->id }}"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width">{{ $product->id }}</td>
                                                <td class="cursor-pointer">{{ $product->sku }}</td>
                                                <td class="cursor-pointer sm-width"><img alt="image" class="tbl-image"
                                                        src="{{ Storage::url($product->thumbnail) }}">
                                                </td>
                                                <td class="cursor-pointer">{{ $product->name }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($product->categories->isNotEmpty())
                                                        {{ $product->categories->pluck('name')->implode(', ') }}
                                                    @else
                                                        <span class="text-muted">Không có danh mục</span>
                                                    @endif
                                                </td>
                                                <td class="cursor-pointer">{{  $product->price_range}} </td>
                                                <td class="cursor-pointer">{{ $product->stock_quantity }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($product->stock_quantity > 10)
                                                        <div class="status-in_stock">
                                                            <span>{{ __('form.product_stock_in_stock') }}</span>{{-- còn  --}}
                                                        </div>
                                                    @elseif($product->stock_quantity > 0)
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
                                                            <input type="checkbox" class="toggle-active-products"
                                                                data-product-id="{{ $product->id }}"{{-- Data attribute chứa ID --}}
                                                                {{ $product->is_active == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.products.show', $product->slug) }}" class="btn-detail"><i
                                                                    class="ri-eye-line"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn-edit"><i
                                                                    class="ri-pencil-line"></i></a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.products.delete', $product) }}"
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
                        <!-- END TABLE -->


                        <!-- START PAGINATION -->
                        <div class="custom-pagination">
                            {{ $products->links() }}
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

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
                toggleBulkActionButton();

            });

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#checkbox-table').prop('checked', total === checked);
                toggleBulkActionButton();

            });


            // --- Xử lý sự kiện click nút "Xóa tất cả" ---
            $('#btn-move-to-trash-all').on('click', function() {
                handleBulkAction(); // 6.1 Gọi hàm xử lý
            });

            //  Hàm ẩn/hiện nút "Xóa tất cả"
            function toggleBulkActionButton() {
                if ($('.checkbox-input:checked').length > 0) {
                    $('#btn-move-to-trash-all').removeClass('visually-hidden'); // checkbox => hiện
                } else {
                    $('#btn-move-to-trash-all').addClass('visually-hidden'); //  ẩn
                }
            }

            toggleBulkActionButton(); // 5. Gọi hàm lần đầu khi trang tải

            // Lấy ids và gửi AJAX request
            function handleBulkAction() {

                const selectedIds = [];
                $('.checkbox-input:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length == 0) { // 6.2 Kiểm tra nếu không có ID nào được chọn
                    alert('Vui lòng chọn ít nhất một danh mục.');
                    return; // Dừng thực thi nếu không có ID
                }

                if (confirm(
                        "{{ __('message.confirm_move_to_trash_all_item') }}"
                    )) {
                    $.ajax({ // Gửi AJAX request
                        url: '{{ route('admin.products.bulkTrash') }}', //  URL của route xử lý
                        method: 'POST', //  Phương thức POST
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_ids: selectedIds,
                        },

                        success: function(response) {
                            console.log("data:", selectedIds);

                            console.log("Response:", response);

                            if (response && typeof response === 'object') {

                                if (response.success === true) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thành công!',
                                        html: response.message,
                                        timer: 1500, // Tự động đóng sau 1.5 giây
                                        showConfirmButton: false,
                                    }).then(() => {
                                        location.reload();
                                    });

                                } else {

                                    // let errorMessage = "Đã có lỗi xảy ra.";

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi!',
                                        html: response.message,
                                    }).then(() => {
                                        location.reload();
                                    });
                                }

                            } else {
                                console.error("Response không đúng định dạng:", response);
                                alert("Đã có lỗi xảy ra trong quá trình xử lý.");
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi AJAX:", error);
                            alert("Đã có lỗi xảy ra. Vui lòng thử lại.");
                        }
                    });
                }

            }

            // --- End Logic Checkbox ---


            // $('#btn-move-to-trash').on('click', function(e) {

            //     let confirmMessage = confirm("{{ __('message.confirm_move_to_trash_all_item') }}");

            //     if (confirmMessage) {
            //         console.log('Move to trash');
            //     }
            // })

            // update Is_active Api
            $('.toggle-active-products').change(function() {
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


            // thông báo sw2


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
