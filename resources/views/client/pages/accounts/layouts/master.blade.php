@extends('client.layouts.master')
@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
    @include('client.pages.accounts.layouts.partials.breadcrumb')
    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                @include('client.pages.accounts.layouts.partials.sidebar')
                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu</button>
                    <div class="dashboard-right-sidebar">
                        @yield('content_account')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- User Dashboard Section End -->
    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->
@endsection

@push('js_library')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Sweat Alert 2 JS -->
    <script src="{{ asset('theme/admin/assets/js/sweetalert2.all.min.js') }}"></script>
@endpush

@push('js')
    <script>
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            }).then(() => {
                @if (session()->has('logout_required'))
                    window.location.href =
                        "{{ route('api.auth.logout') }}"; // Chuyển hướng đến route đăng xuất
                @endif
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra',
                html: "{!! implode('<br>', $errors->all()) !!}",
                showConfirmButton: true
            });
        @endif
    </script>
@endpush
