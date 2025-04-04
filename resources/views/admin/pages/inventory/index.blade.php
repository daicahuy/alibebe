@extends('admin.layouts.master')

@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 100000;
        }

        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #009289;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush


@section('content')
    <div id="loading-overlay" style="display: none">
        <div class="spinner"></div>
    </div>
    <div class="container-fuild">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>{{ __('form.inventory') }}</h5>
                            </div>
                            <div class="d-flex">
                                <a class="align-items-center btn btn-theme me-2 disabled" id="import-stock-btn"
                                    href="#!">
                                    <i class="ri-add-line"></i>
                                    {{ __('form.stock_movement.import') }}
                                </a>
                                <a class="align-items-center btn btn-theme me-2" id="import-stock-by-excel-btn"
                                    href="#!">
                                    <i class="ri-add-line"></i>
                                    {{ __('form.stock_movement.import') . ' ' . __('message.by_excel') }}
                                </a>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <form action="{{ route('admin.inventory.index') }}" method="GET" id="filterForm">

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
                                                <td class="cursor-pointer">
                                                    @if ($product->show_sale)
                                                        <del>
                                                            {{ $product->original_price_display }}
                                                        </del><br>
                                                        <span class="theme-color">
                                                            {{ str_replace("\n", '<br>', str($product->price_range)->after("\n")) }}
                                                        </span>
                                                    @else
                                                        <span class="theme-color"> {{ $product->price_range }} </span>
                                                    @endif
                                                </td>
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

    <div class="modal fade" id="modal-import-stock" tabindex="-1" aria-hidden="true">
        <div class="overlay">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <form id="form-import-stock" action="{{ route('api.products.getAll') }}" method="GET">
                        <div class="modal-body text-center" style="overflow-y: auto; max-height: 92vh;">
                            <h3 class="modal-title my-4">Nhập kho</h3>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div id="product-import">

                            </div>

                            <div class="button-box justify-content-end">
                                <button class="btn btn-md btn-secondary fw-bold" id="btn-cancel-import-stock"
                                    type="button">
                                    {{ __('message.cancel') }}
                                </button>
                                <button class="btn btn-md btn-theme fw-bold btn-action" type="submit">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-import-stock-excel" tabindex="-1" aria-hidden="true">
        <div class="overlay">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="form-import-stock-excel" action="{{ route('api.products.getAll') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body text-center" style="overflow-y: auto; max-height: 92vh;">
                            <h3 class="modal-title mt-4 mb-2">Nhập kho bằng excel</h3>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                            <div class="form-group align-items-center g-3 p-3 row">
                                <div class="col-12">
                                    <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                        for="icon">
                                        File excel:
                                    </label>
                                    <div>
                                        <input type="file" name="file" class="form-control">
                                        <div class="invalid-feedback text-start"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-box justify-content-end">
                                <button class="btn btn-md btn-secondary fw-bold" id="btn-cancel-import-stock-excel"
                                    type="button">
                                    {{ __('message.cancel') }}
                                </button>
                                <button class="btn btn-md btn-theme fw-bold btn-action" type="submit">
                                    Xác nhận
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_library')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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

            //  Hàm ẩn/hiện nút "Xóa tất cả"
            function toggleBulkActionButton() {
                if ($('.checkbox-input:checked').length > 0) {
                    $('#import-stock-btn').removeClass('disabled')
                } else {
                    $('#import-stock-btn').addClass('disabled')
                }
            }

            toggleBulkActionButton();


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

            $('form').on('change', 'input, select, textarea', function () {
                console.log($(this));
                $(this).removeClass('is-invalid');
                $(this).closest('.form-group').find('.invalid-feedback').text('');
            });

            function renderProductImport(data) {
                $('#product-import').html("");
                const productsHTML = data.map(product => {
                    if (product.product_variants.length === 0) {
                        return `
                           <div class="py-3 px-2">
                                <div class="border">
                                    <div class="form-group align-items-center g-3 p-3 row">
                                        <input type="hidden" name="singleProducts[${product.id}][id]" value="${product.id}">
                                        <div class="form-group col-2">
                                            <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                                for="icon">
                                                Ảnh sản phẩm:
                                            </label>
                                            <div class="text-start">
                                                <img alt="image" class="tbl-image ms-2" src="http://127.0.0.1:8000/storage/${product.thumbnail}">
                                            </div>
                                        </div>
                                        <div class="form-group col-5">
                                            <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                                for="icon">
                                                Tên sản phẩm:
                                            </label>
                                            <div>
                                                <input type="text" class="form-control disabled" value="${product.name}" disabled>
                                                <div class="invalid-feedback text-start"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-3">
                                            <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                                for="icon">
                                                SKU:
                                            </label>
                                            <div>
                                                <input type="text" class="form-control disabled" value="${product.sku}" disabled>
                                                <div class="invalid-feedback text-start"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-2">
                                            <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                                for="icon">
                                                Số lượng:
                                            </label>
                                            <div>
                                                <input type="number" name="singleProducts[${product.id}][quantity]" class="form-control">
                                                <div class="invalid-feedback text-start"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        `;
                    }

                    const variantProducts = product.product_variants.map(productVariant => {
                        const nameVariant = productVariant.attribute_values.map(attributeValue => attributeValue.value).join(' | ');
                        return `
                            <tr class="variant">
                                <input type="hidden" name="variantProducts[${productVariant.id}][id]" value="${productVariant.id}">
                                <td class="form-group">
                                    <img alt="image" class="tbl-image ms-2" src="http://127.0.0.1:8000/storage/${productVariant.thumbnail}">
                                    <div class="invalid-feedback"></div>
                                </td>

                                <td class="form-group">
                                    ${productVariant.sku}
                                    <div class="invalid-feedback"></div>
                                </td>

                                <td class="form-group">
                                    <div>
                                        ${nameVariant}
                                        <input type="hidden" value="1" name="">
                                    </div>
                                    <div class="invalid-feedback text-start"></div>
                                </td>

                                <td class="form-group">
                                    <input type="number" name="variantProducts[${productVariant.id}][quantity]" class="form-control">
                                    <div class="invalid-feedback text-start"></div>
                                </td>
                            </tr>
                        `;
                    }).join('');

                    return `
                        <div class="py-3 px-2">
                            <div class="border">
                                <div class="form-group align-items-center g-3 p-3 row">
                                    <div class="col-12">
                                        <label class="form-label-title mb-0 w-100" style="text-align: left;"
                                            for="icon">
                                            Tên sản phẩm:
                                        </label>
                                        <div>
                                            <input type="text" class="form-control disabled" value="${product.name}" disabled>
                                            <div class="invalid-feedback text-start"></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="table all-package theme-table no-footer">
                                    <thead>
                                        <tr>
                                            <th>{{ __('form.product_variant.thumbnail') }}
                                            <th>{{ __('form.product_variant.sku') }}
                                            <th>{{ __('form.product_variants') }}</th>
                                            </th>
                                            <th>{{ __('form.stock_movement_detail.quantity') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${variantProducts}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `;
                })

                $('#product-import').html(productsHTML);
            }

            $('#import-stock-btn').on('click', async function(e) {
                e.preventDefault();
                const selectedIds = [];
                
                $('.checkbox-input:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                const data = {
                    productIds: selectedIds
                };

                await $.ajax({
                    url: "{{ route('api.products.getAll') }}",
                    type: "GET",
                    data,
                    beforeSend: function() {
                        $("#loading-overlay").show();
                    },
                    success: function (response) {
                        renderProductImport(response.data);
                    },
                    error: function (jqXHR) {
                        if (jqXHR.status !== 422) {
                            Swal.fire({
                                icon: "error",
                                title: jqXHR.responseJSON.message,
                            });
                            return
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Đã xảy ra một số lỗi",
                            text: "Vui lòng kiểm tra lại thông tin !",
                        });

                        const errors = jqXHR.responseJSON.errors;
                        console.log(errors);
                    },
                    complete: function() {
                        $("#loading-overlay").hide();
                    }
                });
                
                $('#modal-import-stock').modal('show');
            })

            $('#btn-cancel-import-stock').on('click', function(e) {
                e.preventDefault();
                $('#modal-import-stock').modal('hide');
            })

            $('#form-import-stock').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('api.stocks.importStock') }}",
                    type: "POST",
                    data: new FormData($("#form-import-stock")[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#loading-overlay").show();
                    },
                    success: function (response) {
                        $('#modal-import-stock').modal('hide');
                        
                        if (response.statusCode === 200) {
                            Swal.fire({
                                icon: "warning",
                                html: response.message,
                                focusConfirm: false,
                                draggable: true,
                            });
                        } else if (response.statusCode === 201) {
                            Swal.fire({
                                title: response.message,
                                icon: "success",
                                draggable: true
                            });
    
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function (jqXHR) {
                        if (jqXHR.status !== 422) {
                            Swal.fire({
                                icon: "error",
                                title: jqXHR.responseJSON.message,
                            });
                            return
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Đã xảy ra một số lỗi",
                            text: "Vui lòng kiểm tra lại thông tin !",
                        });

                        const errors = jqXHR.responseJSON.errors;
                        console.log(errors);

                        $(".invalid-feedback").text("");
                        $(".is-invalid").removeClass("is-invalid");

                        // Lặp qua danh sách lỗi
                        $.each(errors, function (key, message) {
                            const parts = key.split('.');
                            key = parts.reduce((accumulator, currentItem) => `${accumulator}[${currentItem}]`)

                            console.log(key);
                            
                            let inputField = $(`[name="${key}"]`);

                            if (inputField.length > 0) {
                                inputField.addClass("is-invalid");
                                inputField.closest('.form-group').find(".invalid-feedback").html(message);
                            }
                        });
                    },
                    complete: function() {
                        $("#loading-overlay").hide();
                    }
                });
            })
            
            $('#import-stock-by-excel-btn').on('click', function() {
                $('#modal-import-stock-excel').modal('show');
            })

            $('#btn-cancel-import-stock-excel').on('click', function() {
                $('#modal-import-stock-excel').modal('hide');
            })

            $('#form-import-stock-excel').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('api.stocks.importStockExcel') }}",
                    type: "POST",
                    data: new FormData($("#form-import-stock-excel")[0]),
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#loading-overlay").show();
                    },
                    success: function (response) {
                        $('#modal-import-stock-excel').modal('hide');
                        
                        if (response.statusCode === 200) {
                            Swal.fire({
                                icon: "warning",
                                html: response.message,
                                focusConfirm: false,
                                draggable: true,
                            });
                        } else if (response.statusCode === 201) {
                            Swal.fire({
                                title: response.message,
                                icon: "success",
                                draggable: true
                            });
    
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function (jqXHR) {
                        Swal.fire({
                            icon: "error",
                            title: "Đã xảy ra một số lỗi",
                            text: "Vui lòng kiểm tra lại thông tin !",
                        });

                        const errors = jqXHR.responseJSON.errors;
                        console.log(errors);

                        $(".invalid-feedback").text("");
                        $(".is-invalid").removeClass("is-invalid");

                        // Lặp qua danh sách lỗi
                        $.each(errors, function (key, message) {
                            const parts = key.split('.');
                            key = parts.reduce((accumulator, currentItem) => `${accumulator}[${currentItem}]`)

                            console.log(key);
                            
                            let inputField = $(`[name="${key}"]`);

                            if (inputField.length > 0) {
                                inputField.addClass("is-invalid");
                                inputField.closest('.form-group').find(".invalid-feedback").html(message);
                            }
                        });
                    },
                    complete: function() {
                        $("#loading-overlay").hide();
                    }
                });
            })
        });
    </script>
@endpush
