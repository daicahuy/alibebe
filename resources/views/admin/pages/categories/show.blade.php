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
                                    <span class="fs-6 fw-light">></span> {{ $show->name }}
                                </h5>
                            </div>
                            <div>
                                <a class="align-items-center btn btn-theme d-flex"
                                    href="{{ route('admin.categories.create') }}">
                                    <i class="ri-add-line"></i>
                                    {{ __('message.add') . ' ' . __('form.categories') }}
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
                                    id="btn-move-to-trash-all" type="button">
                                    {{ __('message.move_to_trash') }}
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
                                                {{ __('form.category_name_child') }}
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
                                        @if ($show->categories->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Không có danh mục con nào.
                                                </td>
                                            </tr>
                                        @endif
                                        @foreach ($show->categories as $item)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" id="" value="{{ $item->id }}"
                                                            class="custom-control-input checkbox_animated checkbox-input">

                                                    </div>
                                                </td>
                                                <td class="cursor-pointer sm-width"> {{ $item->id }}

                                                </td>
                                                <td class="cursor-pointer sm-width">
                                                    @if ($item->icon)
                                                        <img alt="image" class="tbl-image icon-image"
                                                            src="{{ Storage::url($item->icon) }}">
                                                    @else
                                                        <img alt="image" class="tbl-image icon-image"
                                                            src="{{ asset('/theme/admin/assets/images/categories/no-image.svg') }}">
                                                    @endif
                                                </td>
                                                <td class="cursor-pointer">

                                                    <div>
                                                        {{ $item->name }}
                                                    </div>

                                                </td>

                                                <td class="cursor-pointer">
                                                    <div class="form-check form-switch ps-0">
                                                        <label class="switch switch-sm">
                                                            <input type="checkbox" class="toggle-active-show"
                                                                {{-- Class để bắt sự kiện jQuery --}}
                                                                data-category-id="{{ $item->id }}"
                                                                {{-- Data attribute chứa ID --}}
                                                                {{ $item->is_active == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $item->created_at }}

                                                </td>
                                                <td class="cursor-pointer">

                                                    {{ $item->updated_at }}

                                                </td>


                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.categories.edit', $item->id) }}"
                                                                class="btn-edit">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.categories.delete', $item) }}"
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


            // update Is_active Api
            $('.toggle-active-show').change(function() {
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                html: response.message,
                                // timer: 1500, // Tự động đóng sau 1.5 giây
                                // showConfirmButton: false,
                            }).then(() => {
                                location.reload();
                            });
                            // window.location.reload(); // Load lại trang
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
