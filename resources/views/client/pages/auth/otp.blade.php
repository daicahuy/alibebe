@extends('client.layouts.master')

@push('css')
    <style>
        .error-border {
            border: 2px solid red !important;
        }

        .error-text {
            color: red !important;
        }

        .disabled-link {
            pointer-events: none;
            /* Ngăn chặn click */
            opacity: 0.5;
            /* Làm mờ */
            cursor: default;
            /* Thay đổi con trỏ chuột */
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
                        <h2>OTP</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">OTP</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section otp-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('theme/client/assets/images/inner-page/otp.png') }}" class="img-fluid"
                            alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <form id='formVerifyOtp'>
                            @csrf
                            <div class="log-in-box">
                                <input type="hidden" name="email" id="email" value="{{ session('otp_email') }}">
                                <input type="hidden" name="otp_expire" id="otp_expire" value="{{ session('otp_expire') }}">
                                <input type="hidden" name="otpSession" id="otpSession" value="{{ session('otp') }}">
                                <div class="log-in-title">
                                    <h3 class="text-content">Vui lòng nhập mã xác nhận OTP!</h3>
                                    <h5 class="text-content"> Mã OTP đã được gửi đến
                                        <span>{{ session('otp_email') }}{{ session('otp_expire') }}{{ session('otp') }}</span>
                                    </h5>
                                </div>

                                <div id="otp" class="inputs d-flex flex-row justify-content-center">
                                    <input class="text-center form-control rounded" type="text" id="first"
                                        maxlength="1" placeholder="0">
                                    <input class="text-center form-control rounded" type="text" id="second"
                                        maxlength="1" placeholder="0">
                                    <input class="text-center form-control rounded" type="text" id="third"
                                        maxlength="1" placeholder="0">
                                    <input class="text-center form-control rounded" type="text" id="fourth"
                                        maxlength="1" placeholder="0">
                                    <input class="text-center form-control rounded" type="text" id="fifth"
                                        maxlength="1" placeholder="0">
                                    <input class="text-center form-control rounded" type="text" id="sixth"
                                        maxlength="1" placeholder="0">
                                </div>
                                <div id="divErr"></div>

                                <div class="send-box pt-4">
                                    <h5>Bạn chưa có code? <a href="#" id="resend-otp" class="theme-color fw-bold">Gửi
                                            lại</a></h5>
                                    <span id="countdown"></span>
                                </div>

                                <button class="btn btn-animation w-100 mt-3" type="submit">Xác nhận</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#otp input').attr('type', 'number').attr('pattern', '[0-9]').attr('maxlength', '1');
            $('#otp input').keyup(function(e) {
                let input = $(this);
                if (input.val() === '') { // Kiểm tra nếu ô input rỗng
                    if (input.prev('input').length > 0) { // Kiểm tra xem có ô input trước đó không
                        input.prev('input').focus(); // Chuyển con trỏ đến ô input trước đó
                    }
                } else if (input.val().length == input.attr('maxlength')) {
                    $(this).next('input').focus();
                }

                // Chỉ cho phép nhập số
                if (!$.isNumeric(this.value)) {
                    this.value = '';
                }
            });
            let emailForget = localStorage.getItem('emailForget')

            console.log(emailForget);
            $('#formVerifyOtp').on('submit', function(e) {
                e.preventDefault();
                let otp = $('#otp input').map(function() {
                    return $(this).val();
                }).get().join('');

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/verifyOpt",
                    data: {
                        email: emailForget,
                        otp: otp,
                    },
                    dataType: "json",
                    success: function(response) {


                        if (response.status === 200) {
                            Toastify({
                                text: "Gửi mã thành công",
                                duration: 1000,
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
                                window.location.href = '/new-password';
                            }, 700);
                        } else {
                            // Xử lý lỗi

                            $('#otp input').addClass('error-border').addClass(
                                'error-text'); // Thêm class error
                            let errorMessage = "";
                            if (response.errors.otp) {
                                errorMessage =
                                    response.errors.otp[0]
                            } else {
                                errorMessage = response.errors.otpError[0]
                            }

                            let errorDiv = $(
                                '<div class="error-message" style="color: red; margin-top: 10px;"></div>'
                            ).text(errorMessage); // Tạo div chứa thông báo lỗi
                            $('#divErr').append(errorDiv); // Thêm div lỗi vào form

                        }
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
            })

            let countdownInterval;
            let timeLeft = 60; // Thời gian đếm ngược (60 giây)
            $('#resend-otp').on('click', function(e) {
                $('#resend-otp').addClass('disabled-link');
                $('#countdown').text('Đang gửi...');
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/reSendOpt",
                    data: {
                        email: emailForget,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        startCountdown();

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

            })

            function startCountdown() {
                countdownInterval = setInterval(function() {
                    timeLeft--;
                    $('#countdown').text(`Vui lòng chờ ${timeLeft} giây`);
                    if (timeLeft <= 0) {
                        clearInterval(countdownInterval);
                        $('#countdown').empty();
                        $('#resend-otp').removeClass('disabled-link');
                        $('#resend-otp').text('Gửi lại');
                        timeLeft = 60; // Reset thời gian đếm ngược
                    }
                }, 1000);


            };
        })
    </script>
@endpush
