@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-profile">
        <div class="title">
            <h2>{{ __('form.account.profile') }}</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>

        <div class="profile-detail dashboard-bg-box">
            <div class="dashboard-title">
                <h3>{{ __('form.account.profile_name') }}</h3>
            </div>
            <div class="profile-name-detail">
                <div class="d-sm-flex align-items-center d-block">
                    <h3>{{ $user->fullname }}</h3>
                </div>

                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editProfile">Chỉnh Sửa</a>
            </div>

            <div class="location-profile">
                <ul>
                    <li>
                        <div class="location-box">
                            <i data-feather="map-pin"></i>
                            <h6>{{ $user->defaultAddress ? $user->defaultAddress->address : 'Chưa Có địa chỉ mặc định' }}
                            </h6>
                        </div>
                    </li>

                    <li>
                        <div class="location-box">
                            <i data-feather="mail"></i>
                            <h6>{{ $user->email }}</h6>
                        </div>
                    </li>

                    <li>
                        <div class="location-box">
                            <i data-feather="check-square"></i>
                            <h6>
                                {{ !empty($user->email_verified_at) ? 'Đã Xác Thực' : 'Chưa Xác Thực' }}
                            </h6>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="profile-about dashboard-bg-box">
            <div class="row">
                <div class="col-xxl-8">
                    <div class="dashboard-title mb-3">
                        <h3>{{ __('form.account.profile_about') }}</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>{{ __('form.user.gender') }}:</td>
                                    <td>{{ $user->gender == 0 ? 'Nam' : ($user->gender == 1 ? 'Nữ' : 'Khác') }}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('form.user.birthday') }} :</td>
                                    <td>
                                        {{ $user->birthday ? \Carbon\Carbon::parse($user->birthday)->format('Y-m-d') : 'Chưa Cài Đặt' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('form.user.phone_number') }}</td>
                                    <td>
                                        <a href="javascript:void(0)">
                                            {{ $user->phone_number }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('form.account.default_address') }}</td>
                                    <td>
                                        {{ $user->defaultAddress ? $user->defaultAddress->address : 'Chưa Có địa chỉ mặc định' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="dashboard-title mb-3">
                        <h3>{{ __('form.account.login_detail') }}</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Email :</td>
                                    <td>
                                        <a href="javascript:void(0)">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Password :</td>
                                    <td>
                                        <a href="javascript:void(0)">
                                            ******************
                                            <span data-bs-toggle="modal" data-bs-target="#changePasswordModal">Chỉnh
                                                Sửa</span>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xxl-4">
                    <div class="profile-image">
                        <img src="{{ Storage::url($user->avatar) }}" class="img-fluid blur-up lazyload" alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('modal')
    <!-- Edit Profile Start -->
    <div class="modal fade theme-modal" id="editProfile" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <form action="{{ route('account.update-infomation') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mt-3 mb-3 row">
                                    <div class="col-sm-12 text-center">
                                        <img src="{{ Storage::url($user->avatar) }}" class="img-fluid rounded-top"
                                            style="width:200px" alt="" />
                                    </div>
                                    <div class="form-floating theme-form-floating col-sm-12 mt-3">
                                        <input type="file" class="form-control" name="avatar" id="avatar">
                                        <label for="avatar">{{ __('form.user.avatar') }}</label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <!-- Fullname -->
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" name="fullname" id="pname"
                                            value="{{ old('fullname', $user->fullname) }}">
                                        <label for="pname">{{ __('form.user.fullname') }}</label>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    {{-- Gender --}}
                                    <div class="form-floating theme-form-floating mt-3 col-sm-4">
                                        <select name="gender" id="gender" class="form-control">
                                            @foreach ($genders as $key => $gender)
                                                <option value="{{ $key }}"
                                                    @if ($key === $user->gender) selected @endif>
                                                    {{ __('form.user.' . $gender) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="gender">{{ __('form.user.gender') }}</label>
                                    </div>
                                    {{-- Birthday --}}
                                    <div class="form-floating theme-form-floating mt-3 col-sm-8 d-flex">
                                        <input type="date" name="birthday" id="birthday_input" readonly=""
                                            value="{{ old('birthday', $user->birthday) }}" class="form-control">
                                        <label for="birthday_input">{{ __('form.user.birthday') }}</label>
                                        <button type="button" id="startDatePickerBtn" class="btn btn-outline-secondary">
                                            <i class="fa-solid fa-calendar-days"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Address -->
                                @if ($user->addresses->isEmpty())
                                    <!-- Hiển thị ô nhập địa chỉ nếu không có địa chỉ nào -->
                                    <div class="form-floating theme-form-floating mt-3">
                                        <input type="text" name="new_address" class="form-control"
                                            placeholder="Nhập địa chỉ mới" value="{{ old('new_address') }}">
                                        <label for="new_address">{{ __('Nhập địa chỉ mới') }}</label>
                                    </div>
                                @else
                                    <!-- Hiển thị select nếu đã có địa chỉ -->
                                    <div class="form-floating theme-form-floating mt-3">
                                        <select name="address" id="address" class="form-control">
                                            <option value="" selected>{{ __('Chọn địa chỉ mặc định') }}</option>
                                            @foreach ($user->addresses as $address)
                                                <option value="{{ $address->id }}"
                                                    {{ $user->defaultAddress && $user->defaultAddress->id == $address->id ? 'selected' : '' }}>
                                                    {{ $address->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="address">{{ __('form.user_addresses') }}</label>
                                    </div>
                                @endif
                                <!-- Thêm trường số điện thoại nếu chưa có -->
                                @if (empty($user->phone_number))
                                    <div class="form-floating theme-form-floating mt-3">
                                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                                            value="{{ old('phone_number') }}" placeholder="Nhập số điện thoại">
                                        <label for="phone_number">{{ __('form.user.phone_number') }}</label>
                                    </div>
                                @endif

                                <!-- Submit and Cancel Buttons -->
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-animation btn-md fw-bold"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn theme-bg-color btn-md fw-bold text-light">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->

    <!-- Modal for Changing Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Thay Đổi Mật Khẩu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="password-form" method="POST" action="{{ route('account.update-password') }}">
                        @csrf
                        @method('PATCH')

                        @if (auth()->user()->is_change_password === 1)
                            <div class="mb-3">
                                <label for="old-password" class="form-label">Mật Khẩu Cũ</label>
                                <input type="password" class="form-control" name="current_password" id="old-password"
                                    value="{{ old('current_password') }}">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="new-password" class="form-label">Mật Khẩu Mới</label>
                            <input type="password" class="form-control" name="new_password" id="new-password"
                                value="{{ old('new_password') }}">
                        </div>

                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Xác Nhận Mật Khẩu Mới</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="confirm-password">
                        </div>

                        <button type="submit" class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3">Lưu Mật
                            Khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            var datePicker = $('#birthday_input').flatpickr({
                dateFormat: 'Y-m-d',
                allowInput: true,
                defaultDate: $('#birthday_input').val()
            });

            // Open Flatpickr calendar when the button is clicked
            $('#startDatePickerBtn').on('click', function() {
                // Open the date picker when the button is clicked
                datePicker.open();
            });
        });
        $(document).ready(function() {
            function getCookie(name) {
                let cookieValue = null;
                if (document.cookie && document.cookie !== '') {
                    const cookies = document.cookie.split(';');
                    for (let i = 0; i < cookies.length; i++) {
                        const cookie = cookies[i].trim();
                        // Does this cookie string begin with the name we want?
                        if (cookie.startsWith(name + '=')) {
                            cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                            break;
                        }
                    }
                }
                return cookieValue;
            }

            function updateCompareCountBadge() {
                const compareCookieName = 'compare_list';
                const compareListCookie = getCookie(compareCookieName);
                let compareCount = 0;
                if (compareListCookie) {
                    try {
                        const compareList = JSON.parse(compareListCookie);
                        compareCount = compareList.length;
                    } catch (error) {
                        console.error('Lỗi khi parse cookie compare_list:', error);
                    }
                }
                $('#compare-count-badge').text(compareCount);
                if (compareCount > 0) {
                    $('#compare-count-badge').show(); // Hoặc sử dụng class để hiển thị
                } else {
                    $('#compare-count-badge').hide(); // Hoặc sử dụng class để ẩn
                }
            }

            // Gọi hàm này khi trang sản phẩm được tải
            updateCompareCountBadge();
        });
    </script>
@endpush
