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
                                <h5>{{ __('form.brands') }}</h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex" href="{{ route('admin.brands.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.brands') }}
                                </a>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <select class="form-control" id="per_page">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <label>{{ __('message.items_per_page') }}</label>
                                <button class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                    id="btn-delete-all">
                                    {{ __('message.delete_all') }}
                                </button>

                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <form action="" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" id="keyWord" >
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
                                            <th class="sm-width">{{ __('form.brand.id') }}</th>
                                            <th>{{ __('form.brand.logo') }}</th>
                                            <th class="cursor-pointer">
                                                {{ __('form.brand.name') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.brand.is_active') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.brand.created_at') }}</th>
                                            <th>{{ __('form.brand.updated_at') }}</th>
                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="checkbox-table"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width">
                                                    {{ $brand->id }}
                                                </td>
                                                <td class="cursor-pointer sm-width">
                                                    <img alt="image" class="tbl-image "
                                                        style="max-height: 200px; object-fit: contain;"
                                                        src="{{ Storage::url($brand->logo) }}">
                                                </td>
                                                <td class="cursor-pointer">

                                                    <a href="#!" class="fs-6 fw-bold w-100">{{ $brand->name }}</a>

                                                </td>

                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm"><input type="checkbox"
                                                                id="status-0" value="1"
                                                                {{ $brand->is_active ? 'checked' : '' }}><span
                                                                class="switch-state"></span></label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $brand->created_at }}

                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $brand->updated_at }}

                                                </td>


                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                                class="btn-edit">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.brands.destroy', $brand->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn-delete"
                                                                    onclick="return confirm('{{ __('message.confirm_delete_all_item') }}')">
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
                            {{ $brands->links() }}
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

                let confirmMessage = confirm("{{ __('message.confirm_delete_all_all_item') }}");

                if (confirmMessage) {
                    console.log('Move to trash');
                }
            })

            // #
            $('#per_page').change(function() {
                var perPage = $(this).val();
                var url = new URL(window.location.href);
                url.searchParams.set('per_page', perPage);
                window.location.href = url.toString();
            });

            // search #
            $(document).ready(function() {
                // Attach keyup event to the search input field
                $('#role-search').on('keyup', function() {
                    // Get the search keyword
                    let keyword = $(this).val().toLowerCase();

                    // Filter table rows based on the keyword
                    $('#brand-table tbody tr').filter(function() {
                        // Toggle visibility of the row
                        $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
                    });
                });
            });


        });
    </script>
@endpush
