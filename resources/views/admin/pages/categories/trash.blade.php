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
                                        href="{{ route('admin.categories.index') }}">{{ __('form.categories') }}</a>
                                    <span class="fs-6 fw-light">></span> {{ __('message.trash') }}
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
                                    id="btn-restore-all">
                                    {{ __('message.restore_all') }}
                                </button>
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
                                    <input type="search" class="form-control" name="_keyword">
                                </div>
                            </form>

                        </div>
                        <!-- END HEADER TABLE -->

                        @if (session('msg'))
                            <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                                <strong>{{ session('msg') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

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
                                            <th class="sm-width">{{ __('form.category.id') }}</th>
                                            <th>{{ __('form.category.icon') }}</th>
                                            <th class="cursor-pointer">
                                                {{ __('form.category.name') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.category.is_active') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>{{ __('form.category.created_at') }}</th>
                                            <th>{{ __('form.category.updated_at') }}</th>
                                            <th>{{ __('form.category.deleted_at') }}</th>

                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listTrash as $category)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="checkbox-table"
                                                            class="custom-control-input checkbox_animated checkbox-input">
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width"> {{ $category->id }}

                                                </td>
                                                <td class="cursor-pointer sm-width">
                                                    <img alt="image" class="tbl-image icon-image"
                                                        src="{{ Storage::url($category->icon) }}">
                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>
                                                        <a href="{{ route('admin.categories.show', $category) }}"
                                                            class="fs-6 fw-bold w-100">{{ $category->name }} </a>

                                                        <div class="ms-5 ps-md-4 ps-sm-2">
                                                            {{-- @foreach ($cate->categories as $child)
                                                                <div class="item pl-2">
                                                                    <a class="subcategory-link w-100 d-block text-start"
                                                                        href="">
                                                                        <span>-- {{ $child->name }}</span>
                                                                    </a>
                                                                </div>
                                                            @endforeach --}}
                                                        </div>
                                                    </div>

                                                </td>

                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm"><input type="checkbox"
                                                                id="{{ $category->is_active }}"
                                                                value="{{ $category->is_active }}"
                                                                {{ $category->is_active == 1 ? 'checked' : '' }}><span><span
                                                                    class="switch-state"></span></label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $category->created_at }}

                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $category->updated_at }}

                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $category->deleted_at }}

                                                </td>
                                                {{-- <td>
                                                    <p>Kiểu $listTrash: {{ gettype($listTrash) }}</p> <--- IN KIỂU DỮ LIỆU CỦA $listTrash
                                                    <p>Kiểu $category: {{ gettype($trash) }}</p> <--- IN KIỂU DỮ LIỆU CỦA $category
                                                    <p>URL: {{ route('admin.categories.destroy', $trash) }}</p> <--- Vẫn in URL
                                                    {{ $trash->name }}
                                                </td> --}}

                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <form action="#!" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn-restore">
                                                                    <i class="ri-refresh-line"></i>
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.categories.destroy', $category) }}"
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
                            {{ $listTrash->links() }}
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
                    $('#btn-restore-all').removeClass('visually-hidden');
                } else {
                    $('#btn-delete-all').addClass('visually-hidden');
                    $('#btn-restore-all').addClass('visually-hidden');
                }

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
            });

            $('.checkbox-input').on('click', function() {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#checkbox-table').prop('checked', total === checked);

                if ($(this).prop('checked')) {
                    $('#btn-delete-all').removeClass('visually-hidden');
                    $('#btn-restore-all').removeClass('visually-hidden');
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
                        $('#btn-restore-all').addClass('visually-hidden');
                        $('#checkbox-table').prop('checked', false);
                    }
                }
            });
            // --- End Logic Checkbox ---


            $('#btn-delete-all').on('click', function(e) {

                let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");

                if (confirmMessage) {
                    console.log('Move to trash');
                }
            })

        });
    </script>
@endpush
