@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Đổi mật khẩu</h3>
                            <h4>Vui lòng nhập mật khẩu!</h4>
                        </div>
                        <div class="input-box">
                            <form action="{{ route('auth.admin.updatePassword') }}" method="POST" novalidate=""
                                class="row g-4">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input name="password" id="password" class="form-control  @error('password') is-invalid @enderror"
                                            placeholder="New Password" type="password">
                                        <label for="password">Mật Khẩu mới</label>
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Password" type="password">
                                        <label for="password_confirmation">Xác nhận mật khẩu</label>
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-theme justify-content-center w-100" id="pass_btn"
                                        type="submit">
                                        <div> Đổi mật khẩu </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
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

            $("#password_confirmation").on("blur", function() {
                let password_confirmation = $(this).val().trim(); // Lấy giá trị nhập vào

                if (password_confirmation === "") {
                    $(this).removeClass("is-invalid"); // Xóa class lỗi
                    $(".invalid-feedback").hide(); // Ẩn thông báo lỗi
                }
            });

            $("#password_confirmation").on("click", function() {
                if ($(this).hasClass("is-invalid")) {
                    $(".invalid-feedback").show(); // Nếu có lỗi, giữ nguyên thông báo
                }
            });
        });
    </script>
@endpush

