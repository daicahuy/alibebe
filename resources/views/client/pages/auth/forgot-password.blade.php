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
                        <h2>Forgot Password</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Forgot Password</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- log in section start -->
    <section class="log-in-section section-b-space forgot-section">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ asset('theme/client/assets/images/inner-page/forgot.png') }}" class="img-fluid"
                            alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3>Chào mừng đến với Alibebe</h3>
                                <h4>Quên mật khẩu</h4>
                            </div>

                            <div class="input-box">
                                <form id="formSendOtpToEmail" class="row g-4">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="text" class="form-control" id="email" name="email"
                                                placeholder="Email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" id="btnSubmit" type="submit">Gửi
                                            mã xác
                                            nhận</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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

            $('#formSendOtpToEmail').on('submit', function(e) {
                event.preventDefault();
                let formData = $(this).serialize();

                $('#btnSubmit').prop('disabled', true)
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/auth/sendOpt",
                    data: formData,
                    dataType: "json",
                    success: function(response) {

                        if (response.status === 200) {
                            localStorage.setItem('emailForget', response.email);
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
                            $('#submitBtn').prop('disabled', false)
                            setTimeout(function() {
                                window.location.href = `/otp`;
                            }, 1000);
                        } else {
                            // Xử lý lỗi
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


        })
    </script>
@endpush
