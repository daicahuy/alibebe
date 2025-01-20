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
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
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
                                <h5>{{ __('form.attributes') }}</h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex"
                                    href="{{ route('admin.attributes.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.attributes') }}
                                </a>
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <select class="form-control" onchange="window.location.href=this.value;">
                                    <option value="{{ route('admin.attributes.index', ['perpage' => 15]) }}" 
                                        @if(request()->input('perpage') == 15) selected @endif>
                                        15
                                    </option>
                                    <option value="{{ route('admin.attributes.index', ['perpage' => 30]) }}" 
                                        @if(request()->input('perpage') == 30) selected @endif>
                                        30
                                    </option>
                                    <option value="{{ route('admin.attributes.index', ['perpage' => 45]) }}" 
                                        @if(request()->input('perpage') == 45) selected @endif>
                                        45
                                    </option>
                                </select>
                                <label>{{ __('message.items_per_page') }}</label>
                                <form action="{{ route('admin.attributes.destroy') }}" method="POST" id="delete-all-form">
                                    @csrf
                                    @method('DELETE')

                                    <input type="hidden" name="ids" id="ids-to-delete" value="">
                                    <button class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                    id="btn-delete-all">
                                    {{ __('message.delete_all') }}
                                    </button>

                            </form>
                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <!-- Start Switch Button -->
                            @component('components.button-switch-react', [
                                'viewOnly1' => __('message.all'),
                                'viewOnly2' => __('message.attribute_only'),
                                'with' => 170,
                            ])
                            @endcomponent
                            <!-- End Switch Button -->
                            <div class="d-inline-block">
                                <select name="" class="form-select" onchange="window.location.href=this.value;">
                                    <option value="{{ route('admin.attributes.index', ['filter' => '', '_keyword' => request()->input('_keyword')]) }}" 
                                        @if (request()->input('filter') === '') selected @endif>
                                        {{ __('form.attribute_all') }}</option>
                                    <option value="{{ route('admin.attributes.index', ['filter' => 0, '_keyword' => request()->input('_keyword')]) }}"
                                        @if (request()->input('filter') === '0') selected @endif>
                                        {{ __('form.attribute_specifications') }}</option>
                                    <option value="{{ route('admin.attributes.index', ['filter' => 1, '_keyword' => request()->input('_keyword')]) }}"
                                        @if (request()->input('filter') === '1') selected @endif>
                                        {{ __('form.attribute_variants') }}</option>
                                </select>
                            </div>

                            <form action="" method="GET">
                                <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" >
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
                                            <th class="sm-width">
                                                {{ __('form.attribute.id') }}
                                                <div class="filter-arrow" onclick="sortTable('id')">
                                                    <div>
                                                        <i class="{{ $sortColumn === 'id' && $sortDirection === 'asc' ? 'ri-arrow-up-s-fill' : 'ri-arrow-down-s-fill' }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="cursor-pointer">
                                                {{ __('form.attribute.name') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.attribute.is_active') }}
                                                <div class="filter-arrow" onclick="sortTable('is_active')">
                                                    <div>
                                                        <i class="{{ $sortColumn === 'is_active' && $sortDirection === 'asc' ? 'ri-arrow-up-s-fill' : 'ri-arrow-down-s-fill' }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.attribute.created_at') }}
                                                <div class="filter-arrow" onclick="sortTable('created_at')">
                                                    <div>
                                                        <i class="{{ $sortColumn === 'created_at' && $sortDirection === 'asc' ? 'ri-arrow-up-s-fill' : 'ri-arrow-down-s-fill' }}"></i>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                {{ __('form.attribute.updated_at') }}
                                                <div class="filter-arrow" onclick="sortTable('updated_at')">
                                                    <div>
                                                        <i class="{{ $sortColumn === 'updated_at' && $sortDirection === 'asc' ? 'ri-arrow-up-s-fill' : 'ri-arrow-down-s-fill' }}"></i>
                                                    </div>
                                                </div></th>
                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $atb)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="{{ $atb->id }}" id="checkbox-table"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width"> {{$atb->id}} </td>
                                            <td class="cursor-pointer">
                                                <a href="{{ route('admin.attributes.attribute_values.index', ['attribute' => $atb->id]) }}" class="fs-6 fw-bold w-100">{{$atb->name}}</a>
                                                <div class="ms-5 ps-md-5 ps-sm-2">

                                                    @foreach ($atb['attributeValues'] as $value)
                                                        <div class="item pl-2">
                                                            <a class="subcategory-link w-100 d-block text-start"
                                                            href="">
                                                            <span>-- {{$value['value']}}</span>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                   
                                                </div>
                                            </td>

                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <form id="updateForm-{{$atb->id}}" class="status-form" data-post-id="{{$atb->id}}" action="{{ route('admin.attributes.index') }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input 
                                                                type="checkbox" 
                                                                id="status-{{$atb->id}}" 
                                                                value="1" 
                                                                {{ $atb->is_active ? 'checked' : '' }}
                                                                class="switch-input">
                                                            <span class="switch-state"></span>
                                                        </form>
                                                        
                                                    </label>
                                                </div>
                                            </td>
                                            
                                            <td class="cursor-pointer">

                                                {{$atb->created_at}}

                                            </td>
                                            <td class="cursor-pointer">

                                                {{$atb->updated_at}}

                                            </td>


                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="{{ route('admin.attributes.attribute_values.index', ['attribute' =>$atb->id]) }}"
                                                            class="btn-detail">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.attributes.edit', $atb->id) }}" class="btn-edit">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.attributes.destroy') }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $atb->id }}">
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
                            {{$data->links()}}
                        </div>
                        <!-- END PAGINATIOn -->

                    </div>

                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/admin/attributes.js')
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

            // --- Logic Hide, Show Detail Attribute ---
            $('.item.pl-2').hide();

            $btnSwitch.on('click', function() {
                const isChecked = $inputSwitch.prop('checked');

                if (!isChecked) {
                    // Ẩn các danh mục con
                    $('.item.pl-2').slideUp(300);
                } else {
                    // Hiển thị các danh mục con
                    $('.item.pl-2').slideDown(300);
                }
            })
            // --- End Logic Hide, Show Detail Attribute ---

            $('#btn-delete-all').on('click', function(e) {
                // Ngăn không cho form submit ngay lập tức
                e.preventDefault();

                // Lấy tất cả ID của các mục đã chọn
                let selectedIds = [];
                $('.checkbox-input:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length > 0) {
                    // Hiển thị hộp thoại xác nhận
                    let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");

                    if (confirmMessage) {
                        // Gửi request xóa tất cả các mục đã chọn
                        $('#delete-all-form').find('input[name="ids"]').val(selectedIds.join(','));
                        $('#delete-all-form').submit(); // Submit form để xóa các mục
                    }
                } else {
                    alert("{{ __('message.no_item_selected') }}");
                }
            })


        });
    </script>
   <script>
    function sortTable(column) {
        // Lấy URL hiện tại
        let url = new URL(window.location.href);

        // Kiểm tra chiều sắp xếp hiện tại
        let currentDirection = url.searchParams.get('sortDirection') || 'desc';
        let newDirection = currentDirection === 'asc' ? 'desc' : 'asc';

        // Cập nhật query parameters
        url.searchParams.set('sortColumn', column);
        url.searchParams.set('sortDirection', newDirection);

        // Điều hướng tới URL mới
        window.location.href = url.toString();
    }
</script>

@endpush
