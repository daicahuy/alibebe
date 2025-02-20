<div class="col-xxl-3 col-lg-4">
    <div class="dashboard-left-sidebar">
        <div class="close-button d-flex d-lg-none">
            <button class="close-sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="profile-box">
            <div class="cover-image">
                <img src="/theme/client/assets/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                    alt="">
            </div>

            <div class="profile-contain">
                <div class="profile-image">
                    <div class="position-relative">
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="blur-up lazyload update_img"
                            alt="">
                        <div class="cover-icon">
                            <form action="{{ route('account.update-image') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <label for="avatarInput">
                                    <i class="fa-solid fa-pen"></i>
                                </label>
                                <input type="file" name="avatar" id="avatarInput" style="display: none;"
                                    onchange="this.form.submit()">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="profile-name">
                    <h3>{{ Auth::user()->fullname }}</h3>
                    <h6 class="text-content">{{ Auth::user()->email }}</h6>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('account') ? 'active' : '' }}" id="pills-dashboard-tab"
                    data-bs-target="#pills-dashboard" href="{{ route('account.dashboard') }}">
                    <i data-feather="home"></i>
                    Trang Chủ
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link  {{ Request::is('account/order') ? 'active' : '' }}" id="pills-order-tab"
                    data-bs-target="#pills-order" href="{{ route('account.order') }}">
                    <i data-feather="shopping-bag"></i>
                    Đơn Hàng
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('account/wishlist') ? 'active' : '' }}" id="pills-wishlist-tab"
                    data-bs-target="#pills-wishlist" href="{{ route('account.wishlist') }}">
                    <i data-feather="heart"></i>
                    Danh Sách Yêu Thích
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('account/address') ? 'active' : '' }}" id="pills-address-tab"
                    data-bs-target="#pills-address" href="{{ route('account.address') }}">
                    <i data-feather="map-pin"></i>
                    Địa Chỉ
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('account/profile') ? 'active' : '' }}" id="pills-profile-tab"
                    data-bs-target="#pills-profile" href="{{ route('account.profile') }}">
                    <i data-feather="user"></i>
                    Thông Tin
                </a>
            </li>
        </ul>
        <div class="d-flex justify-content-center mt-3 mb-3">
            <form action="{{route('api.auth.logout')}}" method="get">
                @csrf
                <button class="btn theme-bg-color text-white fw-bold">
                    Đăng Xuất
                </button>
            </form>
        </div>
    </div>
</div>

@push('js_library')
    <!-- Flatpickr JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Toastify({
                        text: "{{ $error }}",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }).showToast();
                @endforeach
            @endif
        });
    </script>
@endpush
