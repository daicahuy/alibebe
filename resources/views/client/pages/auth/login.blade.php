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

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Nền trắng mờ */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Đảm bảo nó ở trên cùng */
        }

        .spinner {
            border: 5px solid #f3f3f3;
            /* Màu xám nhạt */
            border-top: 5px solid #3498db;
            /* Màu xanh dương */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2 class="mb-2">{{ __('form.auth.login') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('form.auth.login') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
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
                            <h3>{{ __('form.auth.welcome') }}</h3>
                            <h4>{{ __('form.auth.login_account') }}</h4>
                        </div>

                        <div class="input-box">
                            <form class="row g-4" id="formLoginCustomer">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" id="phone_number_or_email"
                                            name="phone_number_or_email"
                                            placeholder={{ __('form.auth.email_or_phone_number') }}>
                                        <label for="phone-number">{{ __('form.auth.email_or_phone_number') }}</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder={{ __('form.auth.password') }}>
                                        <label for="password">{{ __('form.auth.password') }}</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox" name="remember_me"
                                                id="flexCheckDefault">
                                            <label class="form-check-label"
                                                for="flexCheckDefault">{{ __('form.auth.remember_me') }}</label>
                                        </div>
                                        <a href="{{ route('auth.customer.showFormForgotPassword') }}"
                                            class="forgot-password">{{ __('form.auth.forgot_password') }}</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center"
                                        type="submit">{{ __('form.auth.login') }}</button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in">
                            <h6>{{ __('message.or') }}</h6>
                        </div>

                        <div class="log-in-button">
                            <ul>
                                <li>
                                    <a href="{{ route('api.auth.googleLogin') }}" class="btn google-button w-100">
                                        <img src="{{ asset('theme/client/assets/images/inner-page/google.png') }}"
                                            class="blur-up lazyload" alt="">
                                        {{ __('form.auth.login_with_google') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('api.auth.facebookLogin') }}" class="btn google-button w-100">
                                        <img src="{{ asset('theme/client/assets/images/inner-page/facebook.png') }}"
                                            class="blur-up lazyload" alt="">
                                        {{ __('form.auth.login_with_facebook') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>

                        <div class="sign-up-box">
                            <h4> {{ __('form.auth.not_have_account') }}</h4>
                            <a href="{{ route('auth.customer.showFormRegister') }}"> {{ __('form.auth.register') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection

@push('js_library')
    <!-- Flatpickr JS -->
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#formLoginCustomer').on('submit', function(event) {
                event.preventDefault();
                $("#loading-overlay").show();
                let formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/loginCustomer", // Sử dụng route của Laravel
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {


                            Toastify({
                                text: "Đăng nhập thành công",
                                duration: 2000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "right",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                            }).showToast();
                            setTimeout(function() {
                                window.location.href = '/';
                            }, 500);
                        } else {
                            // Xử lý lỗi
                            if (response.errorsLogin) {
                                Toastify({
                                    text: "Tài khoản đã bị khóa!",
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "linear-gradient(to right, red, #96c93d)",
                                    },
                                }).showToast();
                                return
                            }

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
                    complete: function() {
                        $("#loading-overlay")
                            .hide(); // Ẩn icon loading khi API hoàn tất (thành công hoặc thất bại)
                    },
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert('Tên đăng nhập hoặc mật khẩu không đúng.');
                        }
                    }
                });
            });

            $('#loading-overlay').fadeOut();
        });
    </script>

    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, red, #96c93d)",
                },
            }).showToast();
        </script>
    @endif
@endpush
