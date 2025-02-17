@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
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
                            <button class="btn btn-theme justify-content-center w-100" id="otp_btn" type="submit">
                                <div> Xác nhận </div>
                            </button>
                        </form>
                    </div>
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
        });
    </script>
@endpush
