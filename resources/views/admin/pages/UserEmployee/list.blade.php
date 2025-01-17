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
                                <h5>{{ __('form.user_employee') }}</h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex"
                                    href="{{ route('admin.users.employee.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.users') }}
                                </a>
                            </div>
                        </div>
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
                                <button class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                    id="btn-lock-all">
                                    {{ __('message.lock_all') }}
                                </button>
                                <a href="{{ route('admin.users.employee.lock') }}"
                                    class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                    <i class="ri-lock-line"></i>
                                    {{ __('message.lock_list') }}
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $totalUserLock }}</span>
                                </a>
                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <form action="{{ route('admin.users.employee.index') }}" method="GET">
                                <div class="table-search">
                                    <label class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword"
                                        value="{{ request('_keyword') }}">
                                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
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
                                        @foreach ($ListUsers as $item)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="checkbox-table"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td>{{ $item->id }}</td>
                                                <td class="cursor-pointer">
                                                    <div class="user-round">
                                                        <h4>U</h4>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">{{ $item->fullname }}</td>
                                                <td class="cursor-pointer">{{ $item->email }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($item->role == 0)
                                                        <span>{{ __('form.user_employee') }}</span>
                                                    @elseif ($item->role == 1)
                                                        <span>{{ __('form.user_employee') }}</span>
                                                    @else
                                                        <span>{{ __('form.user_admin') }}</span>
                                                    @endif

                                                </td>
                                                <td class="cursor-pointer">{{ $item->created_at }}</td>
                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm">
                                                            <input type="checkbox" id="status-0" value=""
                                                                {{ $item->status == 1 ? 'checked' : '' }}>>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.users.employee.show', $item->id) }}"
                                                                class="btn-detail">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('admin.users.employee.edit', $item->id) }}"
                                                                class="btn-edit">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.users.employee.lockUser', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn-lock"
                                                                    onclick="return confirm('{{ __('message.confirm_lock_user') }}')">
                                                                    <i class="ri-lock-line"></i>
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
                            {{ $ListUsers->links() }}
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
                    $('#btn-lock-all').removeClass('visually-hidden');
                } else {
                    $('#btn-lock-all').addClass('visually-hidden');
                }

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#checkbox-table').prop('checked', total === checked);

                if ($(this).prop('checked')) {
                    $('#btn-lock-all').removeClass('visually-hidden');
                } else {
                    let isAnotherInputChecked = false;
                    $('.checkbox-input').not($(this)).each((index, checkboxInput) => {
                        if ($(checkboxInput).prop('checked')) {
                            isAnotherInputChecked = true;
                            return;
                        }
                    })

                    if (!isAnotherInputChecked) {
                        $('#btn-lock-all').addClass('visually-hidden');
                        $('#checkbox-table').prop('checked', false);
                    }
                }
            });
            // --- End Logic Checkbox ---


            $('#btn-lock-all').on('click', function(e) {

                let confirmMessage = confirm("{{ __('message.confirm_lock_all_user') }}");

                if (confirmMessage) {
                    console.log('Move to trash');
                }
            })

        });
    </script>
@endpush
