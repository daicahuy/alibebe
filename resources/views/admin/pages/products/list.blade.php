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
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <select class="form-control">
                                    <option value="15">15
                                    </option>
                                    <option value="30">30
                                    </option>
                                    <option value="45">45
                                    </option>
                                </select>
                                <label>{{ __('message.items_per_page') }}</label>
                                <button class="align-items-center btn btn-outline btn-sm d-flex ms-2 visually-hidden"
                                    id="btn-move-to-trash">
                                    {{ __('message.move_to_trash') }}
                                </button>
                                <a href="{{ route('admin.products.trash') }}"
                                    class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                    <i class="ri-delete-bin-line"></i>
                                    {{ __('message.trash') }}
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">10</span>
                                </a>

                            </div>
                            <div class="datepicker-wrap">

                            </div>
                            <div>
                                <select name="" class="form-select">
                                    <option value="">{{ __('form.category_all') }}</option>
                                    <option value="">Điện thoại</option>
                                </select>
                            </div>
                            <div>
                                <select name="" class="form-select">
                                    <option value="">{{ __('form.product_stock_status_all') }}</option>
                                    <option value="">{{ __('form.product_stock_in_stock') }}</option>
                                    <option value="">{{ __('form.product_stock_out_of_stock') }}</option>
                                    <option value="">{{ __('form.product_stock_low_stock') }}</option>
                                </select>
                            </div>
                            <form action="" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword">
                                </div>
                            </form>

                        </div>
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
                                        <tr>
                                            <td class="sm-width">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="checkbox-table"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width">1</td>
                                            <td class="cursor-pointer">PHO125821</td>
                                            <td class="cursor-pointer sm-width"><img alt="image" class="tbl-image"
                                                    src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png">
                                            </td>
                                            <td class="cursor-pointer">iPhone 16 Pro 128GB | Chính hãng VN/A</td>
                                            <td class="cursor-pointer">Điện thoại</td>
                                            <td class="cursor-pointer">45.000.000 VND</td>
                                            <td class="cursor-pointer">50</td>
                                            <td class="cursor-pointer">
                                                <div class="status-in_stock">
                                                    <span>{{ __('form.product_stock_in_stock') }}</span>
                                                </div>
                                                {{-- <div class="status-out_of_stock">
                                                    <span>{{ __('form.product_stock_out_of_stock') }}</span>
                                                </div>
                                                <div class="status-low_stock">
                                                    <span>{{ __('form.product_stock_low_stock') }}</span>
                                                </div> --}}
                                            </td>
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" id="status-0"value="0">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="" class="btn-detail"><i class="ri-eye-line"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-edit"><i class="ri-pencil-line"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="btn-move-to-trash"><i class="ri-delete-bin-line"></i></a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END TABLE -->


                        <!-- START PAGINATION -->
                        <div class="custom-pagination">

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
                    $('#btn-move-to-trash').removeClass('visually-hidden');
                } else {
                    $('#btn-move-to-trash').addClass('visually-hidden');
                }

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#checkbox-table').prop('checked', total === checked);

                if ($(this).prop('checked')) {
                    $('#btn-move-to-trash').removeClass('visually-hidden');
                } else {
                    let isAnotherInputChecked = false;
                    $('.checkbox-input').not($(this)).each((index, checkboxInput) => {
                        if ($(checkboxInput).prop('checked')) {
                            isAnotherInputChecked = true;
                            return;
                        }
                    })

                    if (!isAnotherInputChecked) {
                        $('#btn-move-to-trash').addClass('visually-hidden');
                        $('#checkbox-table').prop('checked', false);
                    }
                }
            });
            // --- End Logic Checkbox --


            $('#btn-move-to-trash').on('click', function(e) {

                let confirmMessage = confirm("{{ __('message.confirm_move_to_trash_all_item') }}");

                if (confirmMessage) {
                    console.log('Move to trash');
                }
            })

        });
    </script>
@endpush
