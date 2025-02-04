@extends('admin.layouts.master')


{{-- ================================== --}}
{{-- CSS --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
@endpush



{{-- ================================== --}}
{{-- CONTENT --}}
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
                                    <span class="fs-6 fw-light">></span> {{ __('message.hidden') }}
                                </h5>
                            </div>

                        </div>

                        <!-- HEADER TABLE -->
                        <form action="{{ route('admin.categories.search') }}" method="GET">
                            <div class="show-box">
                                <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                    <form action="{{ route('admin.categories.index') }}" method="GET">
                                        <select class="form-control" name="per_page" onchange="this.form.submit()">
                                            {{-- Thêm name và onchange --}}
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5
                                            </option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15
                                            </option>
                                            {{-- <option value="all" {{ request('per_page')=='all' ? 'selected' : '' }}>Tất
                                            cả --}}
                                            </option>
                                        </select>
                                    </form>

                                    <label>{{ __('message.items_per_page') }}</label>
                                    <button class="align-items-center btn btn-outline btn-sm d-flex ms-2 visually-hidden"
                                        id="btn-move-to-trash-all" type="button">
                                        {{ __('message.move_to_trash') }}
                                    </button>





                                </div>
                                <div class="datepicker-wrap">

                                </div>



                                {{-- <div class="table-search">
                                    <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword" id="role-search"
                                        value="{{ $keyword ?? '' }}">
                                    <button type="submit" class="btn btn-primary">{{ __('message.search') }}</button>
                                </div> --}}
                        </form>


                    </div>
                    <!-- END HEADER TABLE -->

                    @if (session('msg'))
                        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                            <strong>{{ session('msg') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- @dd(session('msg')); --}}

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
                                        <th>{{ __('form.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listHidden as $cate)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="" value="{{ $cate->id }}"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                    {{-- <label class="custom-control-label"
                                                    for="checkbox-{{ $cate->id }}"></label> --}}
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width"> {{ $cate->id }}

                                            </td>
                                            <td class="cursor-pointer sm-width">
                                                @if ($cate->icon)
                                                    <img alt="image" class="tbl-image icon-image"
                                                        src="{{ Storage::url($cate->icon) }}">
                                                @else
                                                    <img alt="image" class="tbl-image icon-image"
                                                        src="{{ asset('/theme/admin/assets/images/categories/no-image.svg') }}">
                                                @endif
                                            </td>
                                            <td class="cursor-pointer">

                                                <div>
                                                    <a href="{{ route('admin.categories.show', $cate->id) }}"
                                                        class="fs-6 fw-bold w-100">{{ $cate->name }} </a>

                                                    <div class="ms-5 ps-md-4 ps-sm-2">
                                                        @foreach ($cate->categories as $child)
                                                            <div class="item pl-2">
                                                                <a class="subcategory-link w-100 d-block text-start"
                                                                    href="">
                                                                    <span>-- {{ $child->name }}</span>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </td>

                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm">
                                                        <input type="checkbox" class="toggle-active" {{-- Class để bắt sự kiện jQuery --}}
                                                            data-category-id="{{ $cate->id }}" {{-- Data attribute chứa ID --}}
                                                            {{ $cate->is_active == 1 ? 'checked' : '' }}
                                                            {{-- ĐÂY LÀ THAY ĐỔI QUAN TRỌNG: BỎ THUỘC TÍNH name --}}>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">

                                                {{ $cate->created_at }}

                                            </td>
                                            <td class="cursor-pointer">

                                                {{ $cate->updated_at }}

                                            </td>


                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <a href="{{ route('admin.categories.show', $cate) }}"
                                                            class="btn-detail">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.categories.edit', $cate->id) }}"
                                                            class="btn-edit">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.categories.delete', $cate) }}"
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
                        {{ $listHidden->appends(request()->query())->links() }}
                    </div>
                    <!-- END PAGINATIOn -->

                </div>

            </div>
        </div>
    </div>
    </div>
@endsection



{{-- ================================== --}}
{{-- JS --}}
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
                        url: '{{ route('admin.categories.bulkTrash') }}', //  URL của route xử lý
                        method: 'POST', //  Phương thức POST
                        data: {
                            _token: '{{ csrf_token() }}',
                            category_ids: selectedIds,
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


            // --- Logic Hide, Show Sub Category ---
            // $('.item.pl-2').hide();

            // $btnSwitch.on('click', function() {
            //     const isChecked = $inputSwitch.prop('checked');

            //     if (!isChecked) {
            //         // Ẩn các danh mục con
            //         $('.item.pl-2').slideUp(300);
            //     } else {
            //         // Hiển thị các danh mục con
            //         $('.item.pl-2').slideDown(300);
            //     }
            // })
            // --- End Logic Hide, Show Sub Category ---

            // update Is_active Api
            $('.toggle-active').change(function() {
                let $this = $(this);
                let categoryId = $this.data('category-id');
                let isActive = $this.is(':checked') ? 1 : 0;
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '/api/categories/' + categoryId + '/active',
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
                            console.log(response.message);
                            window.location.reload(); // Load lại trang
                        } else {
                            console.error(response.message);
                            $this.prop('checked', !
                                isActive); // Sửa ở đây: isActive (không có $)
                            alert(response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Lỗi AJAX: " + textStatus + ", " + errorThrown);
                        $this.prop('checked', !isActive); // Sửa ở đây: isActive (không có $)
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            alert(jqXHR.responseJSON.message);
                        } else {
                            alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
                        }
                    }
                });
            });


        });
    </script>
@endpush
