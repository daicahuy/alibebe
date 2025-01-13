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
                                    <a href="{{ route('admin.users.index') }}" class="link">{{ __('form.users') }}</a>
                                    <span class="fs-6 fw-light">></span> {{ __('message.lock_list') }}
                                </h5>
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
                                    id="btn-unlock-all">
                                    {{ __('message.unlock_all') }}
                                </button>
                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <div>
                                <select name="" class="form-select">
                                    <option value="">{{ __('form.user_all') }}</option>
                                    <option value="">{{ __('form.user_customer') }}</option>
                                    <option value="">{{ __('form.user_employee') }}</option>
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
                                            <th class="sm-width">{{ __('form.user.id') }}</th>
                                            <th>{{ __('form.user.avatar') }}</th>
                                            <th class="cursor-pointer">
                                                {{ __('form.user.fullname') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.user.email') }}</th>
                                            <th>{{ __('form.user.role') }}</th>
                                            <th class="cursor-pointer"> {{ __('form.user.created_at') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.user.status') }}</th>
                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="checkbox-table"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                </div>
                                            </td>
                                            <td>1123</td>
                                            <td class="cursor-pointer">
                                                <div class="user-round">
                                                    <h4>K</h4>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">Nguyen Van Kien</td>
                                            <td class="cursor-pointer">kevin.customer@example.com</td>
                                            <td class="cursor-pointer">Khách hàng</td>
                                            <td class="cursor-pointer">29 Sep 2023 01:15:PM</td>
                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" id="status-0" value="0">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <form action="" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn-unlock">
                                                                <i class="ri-lock-unlock-line"></i>
                                                            </button>
                                                        </form>
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
                $('#btn-unlock-all').removeClass('visually-hidden');
            } else {
                $('#btn-unlock-all').addClass('visually-hidden');
            }

            $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-input').on('click', function() {

            const total = $('.checkbox-input').length;
            const checked = $('.checkbox-input:checked').length;

            $('#checkbox-table').prop('checked', total === checked);

            if ($(this).prop('checked')) {
                $('#btn-unlock-all').removeClass('visually-hidden');
            } else {
                let isAnotherInputChecked = false;
                $('.checkbox-input').not($(this)).each((index, checkboxInput) => {
                    if ($(checkboxInput).prop('checked')) {
                        isAnotherInputChecked = true;
                        return;
                    }
                })

                if (!isAnotherInputChecked) {
                    $('#btn-unlock-all').addClass('visually-hidden');
                    $('#checkbox-table').prop('checked', false);
                }
            }
            });
            // --- End Logic Checkbox ---


            $('#btn-unlock-all').on('click', function(e) {

                
            })

        });
    </script>
@endpush
