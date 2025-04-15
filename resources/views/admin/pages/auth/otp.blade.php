@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="d-flex">
                    <div class="col-xl-5 col-lg-6 me-auto">
                        <div class="log-in-box">
                            <form action="{{ route('auth.admin.verifyOtp') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ old('email', session('otp_email')) }}">
                                <div class="log-in-title">
                                    <h3 class="text-content">Vui lòng nhập mã xác nhận OTP!</h3>
                                    <h5 class="text-content"> Mã OTP đã được gửi đến <span>{{ session('otp_email') }}</span>
                                    </h5>
                                </div>
                                <div id="otp" class="row d-flex row-cols-6 g-2 mb-5">
                                    <div class="outer-otp">
                                        <div class="inner-otp">
                                            <input type="text" maxlength="6" name="otp"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="send-box pt-4">
                                    <h5>Bạn chưa có code? <a href="javascript:void(0)" id="resend-otp"
                                            class="theme-color fw-bold" onclick="resendOtp()" disabled>Gửi lại</a></h5>
                                    <span id="countdown">Chờ 60 giây để gửi lại OTP</span>

                                </div>
                                <button class="btn btn-theme justify-content-center w-100" id="otp_btn" type="submit">
                                    <div> Xác nhận </div>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="image-contain">
                        <img src="http://127.0.0.1:8000/theme/client/assets/images/inner-page/otp.png" class="img-fluid"
                        alt="">
                    </div>
                </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    timer: 1500,
                    showConfirmButton: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true
                });
            @endif

            let countdownTime = 60; // 60 seconds
            let countdownInterval;

            // Disable resend OTP initially and start countdown
            $('#resend-otp').prop('disabled', true);
            $('#countdown').text('Chờ ' + countdownTime + ' giây để gửi lại OTP');

            // Countdown function
            function startCountdown() {
                countdownInterval = setInterval(function() {
                    countdownTime--;
                    $('#countdown').text('Chờ ' + countdownTime + ' giây để gửi lại OTP');

                    // Enable resend OTP when countdown reaches 0
                    if (countdownTime <= 0) {
                        clearInterval(countdownInterval);
                        $('#resend-otp').prop('disabled', false); // Enable resend OTP link
                        $('#countdown').text('Bạn có thể gửi lại OTP.');
                    }
                }, 1000);
            }

            // Start countdown when page loads
            startCountdown();

            // Function to resend OTP
            window.resendOtp = function() {
                if ($('#resend-otp').prop('disabled')) {
                    // If the resend OTP link is disabled, don't do anything
                    return;
                }

                $.ajax({
                    url: '{{ route('auth.admin.resendOtp') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: true
                        });
                        // Restart countdown
                        countdownTime = 60;
                        $('#resend-otp').prop('disabled', true); // Disable the link again
                        startCountdown();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi gửi lại mã OTP.',
                            showConfirmButton: true
                        });
                    }
                });
            };
        });
    </script>
@endpush
