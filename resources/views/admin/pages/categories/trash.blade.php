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
                            <button type="button"
                                class="align-items-center btn btn-outline btn-sm d-flex ms-2 visually-hidden"
                                id="btn-restore-all">
                                {{ __('message.restore_all') }}
                            </button>
                            <button type="button"
                                class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                id="btn-delete-all">
                                {{ __('message.delete_all') }}
                            </button>
                        </div>
                        <div class="datepicker-wrap">

                        </div>

                        {{-- <form action="" method="GET">
                            <div class="table-search">
                                <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                <input type="search" class="form-control" name="_keyword">
                            </div>
                        </form> --}}

                    </div>
                    <!-- END HEADER TABLE -->

                    @if (session('msg'))
                        <div class="alert alert-{{ session('type') }} alert-dismissible fade show" role="alert">
                            <strong>{{ session('msg') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                                <input type="checkbox" id="select-all"
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
                                    @foreach ($listTrash as $trash)
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" id="ids[]" value="{{ $trash->id }}"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                </div>
                                            </td>
                                            <td class="cursor-pointer sm-width"> {{ $trash->id }}

                                            </td>
                                            <td class="cursor-pointer sm-width">
                                                @if ($trash->icon)
                                                    <img alt="image" class="tbl-image icon-image"
                                                        src="{{ Storage::url($trash->icon) }}">
                                                @else
                                                    <img alt="image" class="tbl-image icon-image"
                                                        src="{{ asset('/theme/admin/assets/images/categories/no-image.svg') }}">
                                                @endif
                                            </td>
                                            <td class="cursor-pointer">

                                                <div>
                                                    <a href="{{ route('admin.categories.show', $trash) }}"
                                                        class="fs-6 fw-bold w-100">{{ $trash->name }} </a>

                                                    <div class="ms-5 ps-md-4 ps-sm-2">
                                                        {{-- @foreach ($cate->categories as $child)
                                                        <div class="item pl-2">
                                                            <a class="subcategory-link w-100 d-block text-start" href="">
                                                                <span>-- {{ $child->name }}</span>
                                                            </a>
                                                        </div>
                                                        @endforeach --}}
                                                    </div>
                                                </div>

                                            </td>

                                            <td class="cursor-pointer">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch switch-sm"><input type="checkbox" id="is_active"
                                                            value="1" {{ $trash->is_active == 1 ? 'checked' : '' }} disabled>
                                                        <span class="switch-state"></span></label>
                                                </div>
                                            </td>
                                            <td class="cursor-pointer">

                                                {{ $trash->created_at }}

                                            </td>
                                            <td class="cursor-pointer">

                                                {{ $trash->updated_at }}

                                            </td>
                                            <td class="cursor-pointer">

                                                {{ $trash->deleted_at }}

                                            </td>
                                            {{-- <td>
                                                <p>Kiểu $listTrash: {{ gettype($listTrash) }}</p> <--- IN KIỂU DỮ LIỆU CỦA
                                                    $listTrash <p>Kiểu $category: {{ gettype($trash) }}</p> <--- IN KIỂU DỮ
                                                        LIỆU CỦA $category <p>URL: {{ route('admin.categories.destroy',
                                                        $trash) }}</p> <--- Vẫn in URL {{ $trash->name }}
                                            </td> --}}

                                            <td>
                                                <ul id="actions">
                                                    <li>
                                                        <form action="{{ route('admin.categories.restore', $trash) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn-restore">
                                                                <i class="ri-refresh-line"></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.categories.destroy', $trash) }}"
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
{{-- JS --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script>
        $(document).ready(function () {

            // --- Logic Checkbox ---
            $('#select-all').on('click', function () {

                $('.checkbox-input').prop('checked', $(this).prop('checked'));
                toggleBulkActionButtons();

            });
            // toggleBulkActionButtons();

            $('.checkbox-input').on('click', function () {

                const total = $('.checkbox-input').length;
                const checked = $('.checkbox-input:checked').length;

                $('#select-all').prop('checked', total === checked);
                toggleBulkActionButtons();

            });

            // chạy hàm khi load trang
            toggleBulkActionButtons();


            // click  button
            $('#btn-restore-all').on('click', function () {
                handleBulkAction('restore');
            });

            $('#btn-delete-all').on('click', function () {
                let confirmMessage = confirm("{{ __('message.confirm_delete_all_item') }}");

                if (confirmMessage) {
                    handleBulkAction('destroy');
                }

            });
            // --- Logic Checkbox ---
            // $('#select-all').on('click', function() {
            //     $('.checkbox-input').prop('checked', $(this).prop('checked'));
            //     toggleBulkActionButtons();
            // });

            // $('.checkbox-input').on('click', function() {
            //     const total = $('.checkbox-input').length;
            //     const checked = $('.checkbox-input:checked').length;
            //     $('#select-all').prop('checked', total === checked);
            //     toggleBulkActionButtons();
            // });

            // Hàm ẩn/hiên button 
            function toggleBulkActionButtons() {
                if ($('.checkbox-input:checked').length > 0) {
                    $('#btn-restore-all').removeClass('visually-hidden');
                    $('#btn-delete-all').removeClass('visually-hidden');
                } else {
                    $('#btn-restore-all').addClass('visually-hidden');
                    $('#btn-delete-all').addClass('visually-hidden');
                }
            }



            // --- Xử lý submit bằng AJAX ---
            function handleBulkAction(action) {

                // Truyền ids vào mảng
                let checkedIds = [];
                $('.checkbox-input:checked').each(function () {
                    checkedIds.push($(this).val());
                });

                if (checkedIds.length === 0) {
                    alert("Vui lòng chọn ít nhất một mục.");
                    return;
                }

                let url = '';
                if (action === 'restore') {
                    url = "{{ route('admin.categories.bulkRestore') }}";
                } else if (action === 'destroy') {
                    url = "{{ route('admin.categories.bulkDestroy') }}";
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulk_ids: checkedIds,
                        // _method: action === 'restore' ? 'PUT' : 'DELETE'
                    },
                    success: function (response) {
                        console.log("Response từ server:", response);

                        if (response && typeof response === 'object') { // Kiểm tra response là object
                            if (response.success === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.message,
                                    timer: 1500, // Tự động đóng sau 1.5 giây
                                    showConfirmButton: false,
                                }).then(() => {
                                    location.reload();
                                });

                            } else {

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
                            alert("Đã có lỗi xảy ra khi xử lý yêu cầu.");
                        }
                    },
                    error: function (error) {
                        console.error("Lỗi AJAX:", error);
                        alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                    }
                });
            }
            // --- End Logic Checkbox ---


            // update Is_active Api
            $('.toggle-active').change(function() {
        let $this = $(this);
        let categoryId = $this.data('category-id');
        let isActive = $this.is(':checked') ? 1 : 0;
        let csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/api/categories/' + categoryId + '/active',
            type: 'PATCH',
            data: { is_active: isActive, _token: csrfToken },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.message);
                    window.location.reload(); // Load lại trang
                } else {
                    console.error(response.message);
                    $this.prop('checked', !isActive); // Sửa ở đây: isActive (không có $)
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