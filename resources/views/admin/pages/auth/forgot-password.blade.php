@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="d-flex">
                    <div class="col-xl-5 col-lg-6 me-auto">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3>Chào mừng đến với Alibebe</h3>
                                <h4>Quên mật khẩu</h4>
                            </div>
                            <div class="input-box">
                                <form action="{{ route('auth.admin.sendOtp') }}" method="POST" novalidate=""
                                    class="row g-4">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="email" id="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email Address">
                                            <label for="email">Nhập email</label>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-theme justify-content-center w-100" id="forgot_btn"
                                            type="submit">
                                            <div> Gửi OTP </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="image-contain">
                        <img src="http://127.0.0.1:8000/theme/client/assets/images/inner-page/forgot.png" class="img-fluid"
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

            $("#email").on("blur", function() {
                let email = $(this).val().trim(); // Lấy giá trị nhập vào

                if (email === "") {
                    $(this).removeClass("is-invalid"); // Xóa class lỗi
                    $(".invalid-feedback").hide(); // Ẩn thông báo lỗi
                }
            });

            $("#email").on("click", function() {
                if ($(this).hasClass("is-invalid")) {
                    $(".invalid-feedback").show(); // Nếu có lỗi, giữ nguyên thông báo
                }
            });
        });
    </script>
@endpush
