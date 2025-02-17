@extends('client.layouts.master')
@push('css')
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .checkbox_animated.is-invalid {
            border: 2px solid red !important;
        }

        .form-control.is-invalid {
            border: 1px solid #dc3545 !important
        }
    </style>
@endpush
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2 class="mb-2">Update Password</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Update Password</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Login section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('theme/client/assets/images/inner-page/log-in.png') }}" class="img-fluid"
                            alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Đổi mật khẩu</h3>
                            <h4>Vui lòng nhập mật khẩu!</h4>
                        </div>
                        <div class="input-box">
                            <form id="formEditPassword" novalidate="" class="row g-4">
                                @csrf

                                <h5 class="text-content"> Đổi mật khẩu cho tài khoản:
                                    <span>{{ session('otp_email') }}</span>
                                </h5>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input name="password" id="password" class="form-control  "
                                            placeholder="New Password" type="password">
                                        <label for="password">Mật Khẩu mới</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input id="password_confirmation" name="password_confirmation" class="form-control"
                                            placeholder="Password" type="password">
                                        <label for="password_confirmation">Xác nhận mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-animation w-100 mt-3" type="submit">Đổi mật khẩu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login section end -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $('#formEditPassword').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của form

                let formData = $(this).serializeArray(); //Chuyển đổi dữ liệu form thành mảng
                let data = {};
                $(formData).each(function(index, obj) {
                    data[obj.name] = obj.value;
                });
                data['otp_email'] = localStorage.getItem('emailForget')

                console.log(data);


                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/changePassword",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(response) {

                        // console.log(response);
                        // return;
                        if (response.status === 200) {
                            localStorage.removeItem('emailForget');

                            Toastify({
                                text: "Đổi mật khẩU thành công",
                                duration: 2000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "right", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function() {} // Callback after click
                            }).showToast();

                            setTimeout(function() {
                                window.location.href = '/login';
                            }, 2000);
                            // Chuyển hướng hoặc thao tác khác
                        } else {
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field, messages) {
                                    let input = $(`#${field}`);
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback error-message d-block">'
                                        );
                                        $.each(messages, function(index, message) {
                                            errorDiv.append('<span>' + message +
                                                '</span><br>');
                                        });
                                        input.addClass('is-invalid');
                                        input.after(errorDiv);
                                    }
                                });
                            } else {
                                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                                console.error('Lỗi không xác định:', response);
                            }

                        }
                    },
                    error: function(error) {
                        console.error("Lỗi Đăng Ký", error);
                    }

                });



            })
        })
    </script>
@endpush
