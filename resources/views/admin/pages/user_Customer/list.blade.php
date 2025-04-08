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
                                <h5>{{ __('form.users') }}</h5>
                            </div>

                        </div>

                        <!-- HEADER TABLE -->
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <form action="{{ route('admin.users.customer.index') }}" method="GET" id="filter-form">
                                    <select class="form-control" name="limit" id="limit-select">
                                        <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                                        <option value="45" {{ request('limit') == 45 ? 'selected' : '' }}>45</option>
                                    </select>
                                </form>

                                <label>{{ __('message.items_per_page') }}</label>
                                <button class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                                    id="btn-lock-all">
                                    {{ __('message.lock_all') }}
                                </button>
                                <a href="{{ route('admin.users.customer.lock') }}"
                                    class="align-items-center btn btn-outline-danger btn-sm d-flex position-relative ms-2">
                                    <i class="ri-lock-line"></i>
                                    {{ __('message.lock_list') }}
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $totalUserLock }}</span>
                                </a>
                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <form action="{{ route('admin.users.customer.index') }}" method="GET">
                                <div class="table-search">
                                    <label class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword"
                                        value="{{ request('_keyword') }}" placeholder ="Tìm kiếm bằng tên, email, sđt...">
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
                                                    <input type="checkbox" id="checkbox-all"
                                                        class="custom-control-input checkbox_animated">

                                                </div>
                                            </th>
                                            <th class="sm-width">{{ __('form.user.id') }}</th>
                                            <th>{{ __('form.user.avatar') }}</th>
                                            <th class="cursor-pointer" id="sort-fullname" data-order="asc">
                                                {{ __('form.user.fullname') }}
                                                <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div>
                                            </th>

                                            <th>{{ __('form.user.phone_number') }}</th>
                                            <th>Email</th>
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
                                        @foreach ($ListUsers as $index => $item)
                                            @php
                                                $page = request('page') ?? 1;
                                                $index = $limit * ($page - 1) + $index + 1;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            class="custom-control-input checkbox_animated checkbox-input"
                                                            data-id="{{ $item->id }}">

                                                    </div>
                                                </td>
                                                <td>{{ $index }}</td>
                                                <td class="cursor-pointer">
                                                    <div class="user-round">
                                                        <h4>{{ strtoupper(substr($item->fullname, 0, 1)) }}</h4>
                                                    </div>
                                                </td>
                                                <td class="cursor-pointer">{{ $item->fullname }}</td>
                                                <td class="cursor-pointer">{{ $item->phone_number }}</td>
                                                <td class="cursor-pointer">{{ $item->email }}</td>
                                                <td class="cursor-pointer">
                                                    @if ($item->role == 0)
                                                        <span>{{ __('form.user_customer') }}</span>
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
                                                            <input type="checkbox" class="status-toggle"
                                                                data-id="{{ $item->id }}"
                                                                {{ $item->status == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.users.customer.detail', $item->id) }}"
                                                                class="btn-detail">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('admin.users.customer.edit', $item->id) }}"
                                                                class="btn-edit">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="btn-lock" data-bs-toggle="modal"
                                                                data-bs-target="#lockUserModal"
                                                                data-user-id="{{ $item->id }}">
                                                                <i class="ri-lock-line"></i>
                                                            </button>
                                                        </li>
                                                        @if (Auth::user()->role == 2)
                                                            <li>
                                                                <form action="{{ route('admin.users.customer.decentralization', $item->id) }}" method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="button" class="btn-lock" onclick="confirmDecentralization({{ $item->id }})">
                                                                        <i class="ri-arrow-up-circle-fill"
                                                                            style="color: #0da487"></i>
                                                                    </button>
                                                                </form>
                                                           
                                                        </li>
                                                        @endif
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
    <!-- Modal nhập lý do khóa -->
    <div class="modal fade" id="lockUserModal" tabindex="-1" aria-labelledby="lockUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="lockUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="lockUserModalLabel">Bạn có chắc muốn khóa người này !</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea name="reason_lock" id="reason_lock" class="form-control" placeholder="Nhập lý do khóa..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Khóa</button>
                    </div>
                </form>
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

function confirmDecentralization(userId) {
    Swal.fire({
        title: 'Xác nhận',
        text: 'Bạn có chắc muốn nâng quyền cho người dùng này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Gửi form nếu người dùng xác nhận
            document.getElementById('decentralizationForm-' + userId).submit();
        }
    });
}

        document.addEventListener('DOMContentLoaded', function() {
            // Khi modal được hiển thị
            const lockUserModal = document.getElementById('lockUserModal');
            lockUserModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Nút kích hoạt modal
                const userId = button.getAttribute('data-user-id'); // Lấy user ID từ data attribute

                // Cập nhật action của form trong modal
                const form = document.getElementById('lockUserForm');
                form.action = `/admin/users/customer/lockUser/${userId}`;
            });

            // Xử lý gửi form
            const lockUserForm = document.getElementById('lockUserForm');
            lockUserForm.addEventListener('submit', function(event) {
                event.preventDefault();

                const reason = document.getElementById('reason_lock').value.trim();
                if (!reason) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thông báo!',
                        text: 'Vui lòng nhập lý do khóa trước khi thực hiện!',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Gửi form
                lockUserForm.submit();
            });
        });


        function confirmLockUser(userId) {
            const reason = document.getElementById('reason_lock_' + userId).value.trim();

            if (!reason) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo!',
                    text: 'Vui lòng nhập lý do khóa trước khi thực hiện!',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: "Bạn có chắc chắn?",
                text: "Bạn có muốn khóa người dùng này không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Xác nhận",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('lockUserForm-' + userId).submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: "{{ session('error') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
        });
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


            $('#checkbox-all').on('click', function() {
                let isChecked = $(this).prop('checked');
                $('.checkbox-input').prop('checked', isChecked);
                toggleLockButton();
            });

            // Chọn từng user
            $('.checkbox-input').on('change', function() {
                let total = $('.checkbox-input').length;
                let checked = $('.checkbox-input:checked').length;

                $('#checkbox-all').prop('checked', total === checked);
                toggleLockButton();
            });

            // Hiển thị hoặc ẩn nút khóa
            function toggleLockButton() {
                if ($('.checkbox-input:checked').length > 0) {
                    $('#btn-lock-all').removeClass('visually-hidden');
                } else {
                    $('#btn-lock-all').addClass('visually-hidden');
                }
            }

            // Xử lý khi nhấn nút khóa tất cả
            $('#btn-lock-all').on('click', function(e) {
    e.preventDefault();

    let selectedUsers = [];
    $('.checkbox-input:checked').each(function() {
        let userId = $(this).data('id'); // Lấy ID từ `data-id`
        if (userId) {
            selectedUsers.push(userId);
        }
    });

    if (selectedUsers.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Thông báo',
            text: 'Vui lòng chọn ít nhất một người dùng để khóa!',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }

    Swal.fire({
        title: 'Nhập lý do khóa',
        input: 'textarea',
        inputPlaceholder: 'Nhập lý do khóa...',
        inputAttributes: {
            'aria-label': 'Nhập lý do khóa'
        },
        showCancelButton: true,
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy',
        inputValidator: (value) => {
            if (!value) {
                return 'Vui lòng nhập lý do khóa!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const reason = result.value;

            $.ajax({
                url: "{{ route('admin.users.customer.lockMultipleUsers') }}", // Đảm bảo route này đúng
                type: "POST", // Phương thức POST
                data: {
                    user_ids: selectedUsers,
                    reason_lock: reason,
                    _token: "{{ csrf_token() }}" // CSRF token
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON); // Debug lỗi từ server
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra, vui lòng thử lại!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
});

            // Tự động submit form khi chọn số lượng hiển thị
            document.getElementById('limit-select').addEventListener('change', function() {
                document.getElementById('filter-form').submit();
            });


        });
        $(document).ready(function() {
            $("#sort-fullname").click(function() {
                let url = new URL(window.location.href);
                let currentField = url.searchParams.get("sort_field");
                let currentOrder = url.searchParams.get("sort_order");

                let newOrder;

                if (currentField === "fullname") {
                    if (currentOrder === "asc") {
                        newOrder = "desc"; // Lần 2: Giảm dần
                    } else {
                        newOrder = "default"; // Lần 3: Trở về mặc định
                    }
                } else {
                    newOrder = "asc"; // Lần 1: Tăng dần
                }

                if (newOrder === "default") {
                    url.searchParams.delete("sort_field");
                    url.searchParams.delete("sort_order");
                } else {
                    url.searchParams.set("sort_field", "fullname");
                    url.searchParams.set("sort_order", newOrder);
                }

                window.location.href = url.toString();
            });
        });
        $(document).ready(function() {
            $(".status-toggle").each(function() {
                $(this).data("prev-state", $(this).prop("checked")); // Lưu trạng thái ban đầu
            });

            $(".status-toggle").change(function() {
                let $this = $(this);
                let userId = $this.data("id");
                let newStatus = $this.prop("checked") ? 1 : 0;
                let prevState = $this.data("prev-state"); // Lấy trạng thái ban đầu

                $.ajax({
                    url: "{{ route('admin.users.customer.update-status') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: userId,
                        status: newStatus
                    },
                    success: function(response) {
                        if (!response.success) {
                            Swal.fire({
                                icon: "error",
                                title: "Lỗi!",
                                text: "Không thể cập nhật trạng thái!",
                                timer: 2000
                            });
                            $this.prop("checked", prevState); // Khôi phục trạng thái cũ nếu lỗi
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "Thành công!",
                                text: "Trạng thái đã được cập nhật!",
                                timer: 2000
                            });
                            $this.data("prev-state", newStatus); // Cập nhật trạng thái mới
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi kết nối!",
                            text: "Có lỗi khi cập nhật trạng thái!",
                            timer: 2000
                        });
                        $this.prop("checked", prevState); // Khôi phục trạng thái cũ nếu lỗi
                    }
                });
            });
        });
    </script>
@endpush
