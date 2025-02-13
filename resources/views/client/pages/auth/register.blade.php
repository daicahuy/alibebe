@extends('client.layouts.master')


@push('css_library')
    <!-- Flatpickr CSS -->
@endpush

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
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2> {{ __('form.auth.register') }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('form.auth.register') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('theme/client/assets/images/inner-page/sign-up.png') }}" class="img-fluid"
                            alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>{{ __('form.auth.welcome') }}</h3>
                            <h4>{{ __('form.auth.created_account') }}</h4>
                        </div>

                        <div class="input-box">
                            <form class="row g-4" id="formRegisterCustomer">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="fullname" name="fullname"
                                            placeholder={{ __('form.user.fullname') }}>
                                        <label for="fullname">{{ __('form.user.fullname') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            placeholder={{ __('form.user.phone_number') }}>
                                        <label for="phone-number">{{ __('form.user.phone_number') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder={{ __('form.user.email') }}>
                                        <label for="email">{{ __('form.user.email') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder={{ __('form.user.password') }}>
                                        <label for="password">{{ __('form.user.password') }}</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder={{ __('form.user.confirm_password') }}>
                                        <label for="confirm-password">{{ __('form.user.confirm_password') }}</label>
                                    </div>
                                </div>

                                {{-- <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class=" check-box checkbox_animated" type="checkbox"
                                                name="terms_and_privacy" id="terms_and_privacy">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I agree with
                                                <span>Terms</span> and <span>Privacy</span>
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <button class="btn btn-animation w-100"
                                        type="submit">{{ __('form.auth.register') }}</button>
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
                                        {{ __('form.auth.signup_with_google') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('api.auth.facebookLogin') }}" class="btn google-button w-100">
                                        <img src="{{ asset('theme/client/assets/images/inner-page/facebook.png') }}"
                                            class="blur-up lazyload" alt="">
                                        {{ __('form.auth.signup_with_facebook') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>

                        <div class="sign-up-box">
                            <h4>{{ __('form.auth.have_account') }}</h4>
                            <a href="{{ route('auth.customer.showFormLogin') }}">{{ __('form.auth.login') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection
@push('js_library')
    <!-- Flatpickr JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

            $('#formRegisterCustomer').on('submit', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của form

                let formData = $(this).serializeArray(); //Chuyển đổi dữ liệu form thành mảng
                let data = {};
                $(formData).each(function(index, obj) {
                    data[obj.name] = obj.value;
                });

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/registerCustomer",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(response) {

                        // console.log(response);
                        // return;
                        if (response.status === 'success') {

                            Toastify({
                                text: "Đăng ký thành công",
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
                            }, 1000);
                            // Chuyển hướng hoặc thao tác khác
                        } else {
                            // Xử lý lỗi bất ngờ
                            $('.error-message').remove(); // Xóa các thông báo lỗi cũ
                            $('.is-invalid').removeClass(
                                'is-invalid'); // Xóa class is-invalid cũ

                            if (response.errors) {
                                if (response.errors.terms_and_privacy) {
                                    $('#terms_and_privacy').addClass('is-invalid');
                                }

                                // Xử lý lỗi cho các trường khác
                                $.each(response.errors, function(field, messages) {
                                    if (field !==
                                        'terms_and_privacy'
                                    ) { // Bỏ qua trường terms_and_privacy
                                        let input = $(`#${field}`);
                                        if (input.length > 0) {
                                            let errorDiv = $(
                                                '<div class="invalid-feedback error-message d-block">'
                                            );
                                            $.each(messages, function(index, message) {
                                                errorDiv.append('<span>' +
                                                    message + '</span><br>');
                                            });
                                            input.addClass('is-invalid');
                                            input.after(errorDiv);
                                        }
                                    }
                                });
                            } else {
                                // Xử lý các lỗi khác (không phải lỗi xác thực)
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
