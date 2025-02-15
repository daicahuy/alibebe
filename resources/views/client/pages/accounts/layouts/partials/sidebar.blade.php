<div class="col-xxl-3 col-lg-4">
    <div class="dashboard-left-sidebar">
        <div class="close-button d-flex d-lg-none">
            <button class="close-sidebar">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="profile-box">
            <div class="cover-image">
                <img src="../theme/client/assets/images/inner-page/cover-img.jpg" class="img-fluid blur-up lazyload"
                    alt="">
            </div>

            <div class="profile-contain">
                <div class="profile-image">
                    <div class="position-relative">
                        <img src="../theme/client/assets/images/inner-page/user/1.jpg"
                            class="blur-up lazyload update_img" alt="">
                        <div class="cover-icon">
                            <i class="fa-solid fa-pen">
                                <input type="file" onchange="readURL(this,0)">
                            </i>
                        </div>
                    </div>
                </div>

                <div class="profile-name">
                    <h3>Vicki E. Pope</h3>
                    <h6 class="text-content">vicki.pope@gmail.com</h6>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Request::is('account') ? 'active' : '' }}" id="pills-dashboard-tab"
                    data-bs-target="#pills-dashboard" href="{{ route('account.index') }}">
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
    </div>
</div>
