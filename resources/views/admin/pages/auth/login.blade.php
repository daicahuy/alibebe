@extends('admin.layouts.basic')

@section('content')
<section class="log-in-section section-b-space">
    <div class="container w-100">
        <div class="row">
                <div class="d-flex">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Chào mừng bạn đến với Alibebe</h3>
                            <h4>Đăng nhập tài khoản</h4>
                        </div>
                      <div>
                        
                      </div>
                            <div class="input-box">
                                <form action="{{ route('auth.admin.handleLogin') }}" method="POST"
                                  novalidate="" class="row g-4">
                                  @csrf
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="email" name="email" id="email" formcontrolname="email"
                                                class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"
                                                placeholder="Email"><label for="email">Email</label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="password" name="password" id="password" formcontrolname="password"
                                                class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu "
                                                @error('password') is-invalid @enderror>
                                                <label
                                                for="password">Mật khẩu</label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span id="togglePassword" class="mt-2">
                                                <input type="checkbox"> Hiện mật khẩu?
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <a class="forgot-password"
                                                href="{{ route('auth.admin.showFormForgotPassword') }}">Quên mật khẩu?</a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-theme justify-content-center w-100" id="login_btn"
                                            type="submit">
                                            <div>Đăng nhập </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                          
                    </div>
                </div>  
                 <div class="image-contain">
                <img src="http://127.0.0.1:8000/theme/client/assets/images/inner-page/log-in.png" class="img-fluid" alt="">
            </div>
                </div>
            </div>
</div>
    </section>
 
 
    <script>
        $(document).ready(function() {
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

            $("#password").on("blur", function() {
                let password = $(this).val().trim(); // Lấy giá trị nhập vào

                if (password === "") {
                    $(this).removeClass("is-invalid"); // Xóa class lỗi
                    $(".invalid-feedback").hide(); // Ẩn thông báo lỗi
                }
            });

            $("#password").on("click", function() {
                if ($(this).hasClass("is-invalid")) {
                    $(".invalid-feedback").show(); // Nếu có lỗi, giữ nguyên thông báo
                }
            });

            // hiện mật khẩu 
            $("#togglePassword").click(function() {
                let passwordInput = $("#password");
                let icon = $(this).find("i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    passwordInput.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
            
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    timer: 1500,
                    showConfirmButton: true
                });
            @endif
            @if(session('error'))
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: "{{ session('error') }}",
                                showConfirmButton: true
                            });
            @endif
        });
    </script>
@endsection
