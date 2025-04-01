<header class="pb-md-4 pb-0">
    <div class="header-top">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 d-xxl-block d-none">
                    <div class="top-left-header">
                        <i class="iconly-Location icli text-white"></i>
                        <i class="iconly-light-user"></i>
                        <span class="text-white">1418 Riverwood Drive, CA 96052, US</span>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                    <div class="header-offer">
                        <div class="notification-slider">
                            <div>
                                <div class="timer-notification">
                                    <h6><strong class="me-1">Welcome to Fastkart!</strong>Wrap new offers/gift
                                        every single day on Weekends.<strong class="ms-1">New Coupon Code: Fast024
                                        </strong>

                                    </h6>
                                </div>
                            </div>

                            <div>
                                <div class="timer-notification">
                                    <h6>Something you love is now on sale!
                                        <a href="shop-left-sidebar.html" class="text-white">Buy Now
                                            !</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <ul class="about-list right-nav-about">
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-language"
                                    data-bs-toggle="dropdown">
                                    <img src="{{ asset('theme/client/assets/images/country/united-states.png') }}"
                                        class="img-fluid blur-up lazyload" alt="">
                                    <span>English</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="english">
                                            <img src="{{ asset('theme/client/assets/images/country/united-kingdom.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                            <span>English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="france">
                                            <img src="{{ asset('theme/client/assets/images/country/germany.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                            <span>Germany</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0)" id="chinese">
                                            <img src="{{ asset('theme/client/assets/images/country/turkish.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                            <span>Turki</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-dollar"
                                    data-bs-toggle="dropdown">
                                    <span>USD</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end sm-dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" id="aud" href="javascript:void(0)">AUD</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="eur" href="javascript:void(0)">EUR</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="cny" href="javascript:void(0)">CNY</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="top-nav top-header sticky-header">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="navbar-top">
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                            <span class="navbar-toggler-icon">
                                <i class="fa-solid fa-bars"></i>
                            </span>
                        </button>
                        <a href="{{ route('index') }}" class="web-logo nav-logo">
                            <img src="{{ asset('theme/client/assets/images/logo/1.png') }}"
                                class="img-fluid blur-up lazyload" alt="">
                        </a>

                        <div class="middle-box">
                            <div class="search-box">
                                <form action="{{ route('search') }}" method="GET" class="w-100">
                                    <div class="input-group d-flex align-items-center flex-nowrap">
                                        <input type="search" class="form-control" id="searchInput" name="query"
                                            placeholder="Im searching for..." autocomplete="off"
                                            value="{{ request('query') }}">
                                        <button class="btn" type="submit" id="button-addon2">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                    <ul id="suggestions" class="suggestions-list"
                                        style="position: absolute; top: 100%; left: 0; width: 100%; background-color: white; border: 1px solid #ccc; border-top: none; list-style-type: none; padding: 0; margin: 0; display: none; z-index: 10; overflow-y: auto; max-height: 200px;">
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <div class="rightside-box">
                            <div class="search-full w-100">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i data-feather="search" class="font-light"></i>
                                    </span>
                                    <input type="text" class="form-control search-type"
                                        placeholder="Search here..">
                                    <span class="input-group-text close-search">
                                        <i data-feather="x" class="font-light"></i>
                                    </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <a href="contact-us.html" class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="phone-call"></i>
                                        </div>
                                        <div class="delivery-detail">
                                            <h6>24/7 Delivery</h6>
                                            <h5>+91 888 104 2340</h5>
                                        </div>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <a href="{{ route('compare.page') }}"
                                        class="btn p-0 position-relative header-compare">
                                        <i data-feather="refresh-cw"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge-compare"
                                            id="compare-count-badge">0
                                        </span>
                                    </a>
                                </li>
                                <style>
                                    .header-compare .badge-compare {
                                        /* Selector CSS cho badge của nút Compare */
                                        width: 18px;
                                        height: 18px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        background-color: #ff7272;
                                        /* Màu nền đỏ (giống Wishlist badge) */
                                        color: #fff;
                                        /* Màu chữ trắng (giống Wishlist badge) */
                                        font-size: 12px;
                                        padding: 0;
                                        border-radius: 2px;
                                        position: absolute !important;
                                        top: 0 !important;
                                        left: 100% !important;
                                        -webkit-transform: translate(-50%, -50%) !important;
                                        transform: translate(-50%, -50%) !important;
                                    }

                                    .btn .badge-compare {
                                        /* Áp dụng thêm nếu badge nằm trong button (có thể cần hoặc không) */
                                        position: relative;
                                        top: -1px;
                                    }

                                    .search-box {
                                        position: relative;
                                        /* Để định vị tuyệt đối cho danh sách gợi ý */
                                        width: 100%;
                                        /* Hoặc một kích thước cố định nếu cần */
                                        max-width: 600px;
                                        /* Ví dụ, giới hạn chiều rộng tối đa */
                                        margin: 0 auto;
                                        /* Để căn giữa nếu cần */
                                    }

                                    /*  cho input group (nếu bạn đang sử dụng Bootstrap hoặc tương tự) */
                                    .input-group {
                                        display: flex;
                                        border: 1px solid #ccc;
                                        /* Ví dụ về border cho input group */
                                        border-radius: 5px;
                                        /* Bo tròn góc */
                                        overflow: hidden;
                                        /* Ẩn border thừa */
                                    }

                                    /*  ô input tìm kiếm */
                                    #searchInput {
                                        flex-grow: 1;
                                        /* Để input chiếm phần lớn chiều rộng */
                                        padding: 10px;
                                        border: none;
                                        outline: none;
                                    }

                                    /*  nút tìm kiếm */
                                    #button-addon2 {
                                        background-color: #ffa53b;
                                        /* Màu nền nhạt */
                                        color: white;
                                        border: none;
                                        padding: 10px 15px;
                                        cursor: pointer;
                                    }

                                    #button-addon2:hover {
                                        background-color: #e9ecef;
                                    }

                                    #button-addon2 i {
                                        /*  cho icon tìm kiếm (nếu bạn đang dùng Feather Icons) */
                                        display: inline-block;
                                        width: 16px;
                                        height: 16px;
                                        stroke-width: 3;
                                        stroke: currentColor;
                                        fill: none;
                                        vertical-align: middle;
                                    }

                                    /*  cho danh sách gợi ý */
                                    .suggestions-list {
                                        position: absolute;
                                        top: 100%;
                                        /* Hiển thị ngay dưới input */
                                        left: 0;
                                        width: 100%;
                                        /* Chiều rộng bằng input */
                                        background-color: white;
                                        border: 1px solid #ccc;
                                        border-top: none;
                                        list-style-type: none;
                                        padding: 0;
                                        margin: 0;
                                        display: none;
                                        /* Ẩn ban đầu */
                                        z-index: 10;
                                        /* Đảm bảo hiển thị trên các phần tử khác */
                                        overflow-y: auto;
                                        /* Thêm thanh cuộn nếu nhiều gợi ý */
                                        max-height: 200px;
                                        /* Chiều cao tối đa của danh sách gợi ý */
                                        border-radius: 0 0 5px 5px;
                                        /* Bo tròn góc dưới */
                                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                                        /* Hiệu ứng đổ bóng nhẹ */
                                    }

                                    /*  cho từng mục gợi ý */
                                    .suggestions-list li {
                                        display: block;
                                        /* Đảm bảo mỗi gợi ý là một dòng */
                                        padding: 10px 15px;
                                        cursor: pointer;
                                        white-space: nowrap;
                                        /* Ngăn văn bản xuống dòng */
                                        overflow: hidden;
                                        /* Ẩn phần văn bản bị tràn */
                                        text-overflow: ellipsis;
                                        /* Hiển thị dấu ba chấm */
                                    }

                                    /*  khi hover vào mục gợi ý */
                                    .suggestions-list li:hover {
                                        background-color: #f0f0f0;
                                    }
                                </style>
                                <li class="right-side">
                                    <a href="{{ route('account.wishlist') }}"
                                        class="btn p-0 position-relative header-wishlist">
                                        <i data-feather="heart"></i>
                                        <span
                                            class="wishlist-count badge bg-danger position-absolute top-0 start-100 translate-middle">
                                            {{ $wishlistCount ?? 0 }}
                                        </span>
                                    </a>
                                </li>


                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                            <a href="{{ route('cart') }}"><i data-feather="shopping-cart"></i></a>
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge">{{ auth()->check() ? $cartItems->count() : 0 }}
                                                <span class="visually-hidden">unread messages</span>
                                            </span>
                                        </button>

                                        <div class="onhover-div">
                                            <ul class="cart-list">
                                                @if (!auth()->check() || $cartItems->isEmpty())
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <strong>Bạn chưa thêm sản phẩm vào giỏ hàng</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $totalSum = 0; // Khởi tạo tổng tiền giỏ hàng
                                                @endphp

                                                @foreach ($cartItems as $cartItem)
                                                    <li class="product-box-contain">
                                                        <div class="drop-cart" data-id="{{ $cartItem->id }}"
                                                            data-product-id="{{ $cartItem->product->id ?? '' }}"
                                                            data-product-variant-id="{{ $cartItem->productVariant->id ?? '' }}">
                                                            @php
                                                                // Kiểm tra nếu có productVariant thì lấy ảnh từ productVariant, nếu không thì lấy ảnh từ product
                                                                $thumbnail =
                                                                    $cartItem->productVariant->product->thumbnail ??
                                                                    $cartItem->product->thumbnail;
                                                            @endphp

                                                            <a href="{{ route('products', $cartItem->product->slug) }}"
                                                                class="drop-image">
                                                                <img src="{{ Storage::url($thumbnail) }}"
                                                                    class="blur-up lazyload" alt="">
                                                            </a>

                                                            <div class="drop-contain">
                                                                <a
                                                                    href="{{ route('products', $cartItem->product->slug) }}">
                                                                    <h5>{{ Str::limit($cartItem->productVariant->product->name ?? $cartItem->product->name, 20, '...') }}
                                                                    </h5>
                                                                </a>
                                                                <div>
                                                                    Phân loại hàng:
                                                                    <span class="selected-variation">
                                                                        @if ($cartItem->productVariant)
                                                                            @foreach ($cartItem->productVariant->attributeValues as $attributeValue)
                                                                                {{ $attributeValue->value }}{{ !$loop->last ? ', ' : '' }}
                                                                            @endforeach
                                                                        @else
                                                                            Không có phân loại
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                @php
                                                                    // Lấy giá gốc từ product hoặc productVariant
                                                                    $price =
                                                                        $cartItem->productVariant->price ??
                                                                        $cartItem->product->price;

                                                                    // Kiểm tra nếu sản phẩm có biến thể
                                                                    $salePrice = null;
                                                                    if ($cartItem->productVariant?->sale_price > 0) {
                                                                        $salePrice =
                                                                            $cartItem->productVariant->sale_price;
                                                                    } elseif (
                                                                        $cartItem->product?->sale_price > 0 &&
                                                                        $cartItem->product?->is_sale == 1
                                                                    ) {
                                                                        $salePrice = $cartItem->product->sale_price;
                                                                    } else {
                                                                        $salePrice = $price; // Nếu không có giảm giá, salePrice bằng giá gốc
                                                                    }

                                                                    // Tính tiền tiết kiệm
                                                                    $saving = $price - $salePrice;

                                                                    // Tính tổng tiền sản phẩm
                                                                    $sumOnePrd = $cartItem->quantity * $salePrice;
                                                                    $totalSum += $sumOnePrd;
                                                                @endphp
                                                                <input type="hidden" class="price"
                                                                    value="{{ $cartItem->product->price ?? $cartItem->productVariant->product->price }}">
                                                                <input type="hidden" class="old_price"
                                                                    value="{{ $cartItem->product?->sale_price ?? $cartItem->productVariant?->product->sale_price }}">
                                                                <input type="hidden" class="price_variant"
                                                                    value="{{ $cartItem->productVariant?->price > 0 ? $cartItem->productVariant->price : null }}">
                                                                <input type="hidden" class="old_price_variant"
                                                                    value="{{ $cartItem->productVariant?->sale_price > 0 ? $cartItem->productVariant->sale_price : null }}">
                                                                <input type="hidden" class="is_sale"
                                                                    value="{{ $cartItem->product->is_sale }}">
                                                                @if ($cartItem->productVariant)
                                                                    <!-- Sản phẩm có biến thể -->
                                                                    @if ($cartItem->productVariant->productStock)
                                                                        <input type="hidden" class="stock"
                                                                            value="{{ $cartItem->productVariant->productStock->stock }}">
                                                                    @endif
                                                                @else
                                                                    <!-- Sản phẩm không có biến thể -->
                                                                    @if ($cartItem->product->productStock)
                                                                        <input type="hidden" class="stock"
                                                                            value="{{ $cartItem->product->productStock->stock }}">
                                                                    @endif
                                                                @endif

                                                                <h6><span class="input-number" name="quantity"
                                                                        data-max-stock="{{ $cartItem->productVariant?->productStock?->stock ?? ($cartItem->product?->productStock?->stock ?? 1) }}">{{ $cartItem->quantity }}
                                                                    </span>x
                                                                    {{ number_format($salePrice, 0, ',', '.') }}đ
                                                                    @if ($salePrice < $price)
                                                                        <del
                                                                            class="text-content">{{ number_format($price, 0, ',', '.') }}đ</del>
                                                                    @endif
                                                                </h6>
                                                                <input type="hidden" class="sale_price"
                                                                    value="{{ $salePrice }}">


                                                                <form method="POST"
                                                                    action="{{ route('cart.delete') }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $cartItem->id }}">
                                                                    <button class="close-button close_button">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach

                                            </ul>
                                            @if (!auth()->check() || !$cartItems->isEmpty())
                                                <div class="price-box">
                                                    <h5>Tổng cộng :</h5>
                                                    <h4 class="theme-color fw-bold total-dropdown-price">
                                                        {{ number_format($totalSum, 0, ',', '.') }}đ
                                                    </h4>
                                                </div>


                                                <div class="button-group">
                                                    {{-- <a href="{{ route('cart', ['user' => auth()->id()]) }}"
                                                    class="btn btn-sm cart-button">Giỏ hàng</a> --}}
                                                    <a href="{{ route('cartCheckout') }}"
                                                        class="btn btn-sm cart-button theme-bg-color
                                                text-white">Thanh
                                                        toán</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <i data-feather="user"></i>
                                        </div>

                                        @auth
                                            <div class="delivery-detail">
                                                <h6>{{ __('message.hello') }},</h6>
                                                <h5> {{ Str::limit(Auth::user()->fullname, 10, '...') }}</h5>
                                            </div>
                                        @endauth

                                    </div>

                                    <div class="onhover-div onhover-div-login">

                                        @auth
                                            <ul class="user-box-name">
                                                <li class="product-box-contain">
                                                    <a
                                                        href="{{ route('account.dashboard') }}">{{ __('form.accounts') }}</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a href="{{ route('listOrder') }}">Đơn hàng</a>
                                                </li>
                                                <li class="product-box-contain">
                                                    <a
                                                        href="{{ route('api.auth.logout') }}">{{ __('form.auth.logout') }}</a>
                                                </li>
                                            </ul>
                                        @endauth

                                        @auth
                                            @if (!Auth::user()->email_verified_at)
                                                <div class="mt-2 user-box-name">
                                                    <p class="mt-2" style="color: red">Tài khoản chưa xác minh</p>
                                                    <button
                                                        class="btn btn-sm cart-button theme-bg-color
                                                text-white product-box-contain"
                                                        id="verifyButton">Gửi xác minh</button>
                                                    <p id="statusText"></p>
                                                    <p id="timer"></p>
                                                </div>
                                            @endif
                                        @endauth

                                        @guest
                                            <ul class="user-box-name">
                                                <li class="product-box-contain">
                                                    <a
                                                        href="{{ route('auth.customer.showFormLogin') }}">{{ __('form.auth.login') }}</a>
                                                </li>

                                                <li class="product-box-contain">
                                                    <a
                                                        href="{{ route('auth.customer.showFormRegister') }}">{{ __('form.auth.register') }}</a>
                                                </li>

                                                <li class="product-box-contain">
                                                    <a
                                                        href="{{ route('auth.customer.showFormForgotPassword') }}">{{ __('form.auth.forgot_password') }}</a>
                                                </li>
                                            </ul>
                                        @endguest


                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="header-nav">
                    <div class="header-nav-left">
                        <a href="{{ route('categories') }}">
                            <button class="dropdown-category">
                                <i data-feather="align-left"></i>
                                <span>Danh Mục</span>
                            </button>
                        </a>

                        <div class="category-dropdown">
                            <div class="category-title">
                                <h5>Categories</h5>
                                <button type="button" class="btn p-0 close-button text-content">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <ul class="category-list">
                                @foreach ($categories as $category)
                                    <li class="onhover-category-list">
                                        <a href="{{ route('categories', $category->slug) }}" class="category-name">
                                            <img src="{{ Storage::url($category->icon) }}"
                                                alt="{{ $category->name }}">
                                            <h6>{{ $category->name }}</h6>

                                            @if ($category->categories->count() > 0)
                                                <i class="fa-solid fa-angle-right"></i>
                                            @endif
                                        </a>

                                        @if ($category->categories->count() > 0)
                                            <div class="onhover-category-box">
                                                <ul
                                                    class="list-unstyled d-flex flex-column gap-2 align-items-start m-0 p-0">
                                                    @foreach ($category->categories as $subCategory)
                                                        <li>
                                                            <a href="{{ route('categories', $subCategory->slug) }}"
                                                                class="text-decoration-none text-dark px-2 py-1 d-block">
                                                                {{ $subCategory->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                    <div class="header-nav-middle">
                        <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                            <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                <div class="offcanvas-header navbar-shadow">
                                    <h5>Menu</h5>
                                    <button class="btn-close lead" type="button"
                                        data-bs-dismiss="offcanvas"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="{{ route('index') }}"
                                                data-bs-toggle="dropdown">Home</a>

                                            {{-- <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="index.html">Kartshop</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-2.html">Sweetshop</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-3.html">Organic</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-4.html">Supershop</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-5.html">Classic shop</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-6.html">Furniture</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-7.html">Search
                                                        Oriented</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-8.html">Category
                                                        Focus</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-9.html">Fashion</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-10.html">Book</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="index-11.html">Digital</a>
                                                </li>
                                            </ul> --}}
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Shop</a>

                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="shop-category-slider.html">Shop
                                                        Category Slider</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-category.html">Shop
                                                        Category Sidebar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-banner.html">Shop
                                                        Banner</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-left-sidebar.html">Shop
                                                        Left
                                                        Sidebar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-list.html">Shop List</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-right-sidebar.html">Shop
                                                        Right Sidebar</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="shop-top-filter.html">Shop Top
                                                        Filter</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Product</a>

                                            <div class="dropdown-menu dropdown-menu-3 dropdown-menu-2">
                                                <div class="row">
                                                    <div class="col-xl-3">
                                                        <div class="dropdown-column m-0">
                                                            <h5 class="dropdown-header">
                                                                Product Pages </h5>
                                                            <a class="dropdown-item"
                                                                href="product-left-thumbnail.html">Product
                                                                Thumbnail</a>
                                                            <a class="dropdown-item"
                                                                href="product-4-image.html">Product Images</a>
                                                            <a class="dropdown-item"
                                                                href="product-slider.html">Product Slider</a>
                                                            <a class="dropdown-item"
                                                                href="product-sticky.html">Product Sticky</a>
                                                            <a class="dropdown-item"
                                                                href="product-accordion.html">Product Accordion</a>
                                                            <a class="dropdown-item"
                                                                href="product-circle.html">Product Tab</a>
                                                            <a class="dropdown-item"
                                                                href="product-digital.html">Product Digital</a>

                                                            <h5 class="custom-mt dropdown-header">Product Features
                                                            </h5>
                                                            <a class="dropdown-item" href="product-circle.html">Bundle
                                                                (Cross Sale)</a>
                                                            <a class="dropdown-item"
                                                                href="product-left-thumbnail.html">Hot Stock
                                                                Progress <label class="menu-label">New</label>
                                                            </a>
                                                            <a class="dropdown-item" href="product-sold-out.html">SOLD
                                                                OUT</a>
                                                            <a class="dropdown-item" href="product-circle.html">
                                                                Sale Countdown</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="dropdown-column m-0">
                                                            <h5 class="dropdown-header">
                                                                Product Variants Style </h5>
                                                            <a class="dropdown-item"
                                                                href="product-rectangle.html">Variant Rectangle</a>
                                                            <a class="dropdown-item"
                                                                href="product-circle.html">Variant Circle <label
                                                                    class="menu-label">New</label></a>
                                                            <a class="dropdown-item"
                                                                href="product-color-image.html">Variant Image
                                                                Swatch</a>
                                                            <a class="dropdown-item" href="product-color.html">Variant
                                                                Color</a>
                                                            <a class="dropdown-item" href="product-radio.html">Variant
                                                                Radio Button</a>
                                                            <a class="dropdown-item"
                                                                href="product-dropdown.html">Variant Dropdown</a>
                                                            <h5 class="custom-mt dropdown-header">Product Features
                                                            </h5>
                                                            <a class="dropdown-item"
                                                                href="product-left-thumbnail.html">Sticky
                                                                Checkout</a>
                                                            <a class="dropdown-item"
                                                                href="product-dynamic.html">Dynamic Checkout</a>
                                                            <a class="dropdown-item" href="product-sticky.html">Secure
                                                                Checkout</a>
                                                            <a class="dropdown-item" href="product-bundle.html">Active
                                                                Product view</a>
                                                            <a class="dropdown-item" href="product-bundle.html">
                                                                Active
                                                                Last Orders
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <div class="dropdown-column m-0">
                                                            <h5 class="dropdown-header">
                                                                Product Features </h5>
                                                            <a class="dropdown-item" href="product-image.html">Product
                                                                Simple</a>
                                                            <a class="dropdown-item" href="product-rectangle.html">
                                                                Product Classified <label
                                                                    class="menu-label">New</label>
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="product-size-chart.html">Size Chart <label
                                                                    class="menu-label">New</label></a>
                                                            <a class="dropdown-item"
                                                                href="product-size-chart.html">Delivery &
                                                                Return</a>
                                                            <a class="dropdown-item"
                                                                href="product-size-chart.html">Product Review</a>
                                                            <a class="dropdown-item" href="product-expert.html">Ask
                                                                an Expert</a>
                                                            <h5 class="custom-mt dropdown-header">Product Features
                                                            </h5>
                                                            <a class="dropdown-item"
                                                                href="product-bottom-thumbnail.html">Product
                                                                Tags</a>
                                                            <a class="dropdown-item" href="product-image.html">Store
                                                                Information</a>
                                                            <a class="dropdown-item" href="product-image.html">Social
                                                                Share <label
                                                                    class="menu-label warning-label">Hot</label>
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="product-left-thumbnail.html">Related Products
                                                                <label class="menu-label warning-label">Hot</label>
                                                            </a>
                                                            <a class="dropdown-item"
                                                                href="product-right-thumbnail.html">Wishlist &
                                                                Compare</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 d-xl-block d-none">
                                                        <div class="dropdown-column m-0">
                                                            <div class="menu-img-banner">
                                                                <a class="text-title" href="product-circle.html">
                                                                    <img src="{{ asset('theme/client/assets/images/mega-menu.png') }}"
                                                                        alt="banner">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="nav-item dropdown dropdown-mega">
                                            <a class="nav-link dropdown-toggle ps-xl-2 ps-0" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Mega Menu</a>

                                            <div class="dropdown-menu dropdown-menu-2">
                                                <div class="row">
                                                    <div class="dropdown-column col-xl-3">
                                                        <h5 class="dropdown-header">Daily Vegetables</h5>
                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Beans
                                                            & Brinjals</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Broccoli &
                                                            Cauliflower</a>

                                                        <a href="shop-left-sidebar.html"
                                                            class="dropdown-item">Chilies, Garlic</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Vegetables & Salads</a>

                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Gourd,
                                                            Cucumber</a>

                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Herbs
                                                            & Sprouts</a>

                                                        <a href="demo-personal-portfolio.html"
                                                            class="dropdown-item">Lettuce & Leafy</a>
                                                    </div>

                                                    <div class="dropdown-column col-xl-3">
                                                        <h5 class="dropdown-header">Baby Tender</h5>
                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Beans
                                                            & Brinjals</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Broccoli &
                                                            Cauliflower</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Chilies, Garlic</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Vegetables & Salads</a>

                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Gourd,
                                                            Cucumber</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Potatoes & Tomatoes</a>

                                                        <a href="shop-left-sidebar.html" class="dropdown-item">Peas
                                                            & Corn</a>
                                                    </div>

                                                    <div class="dropdown-column col-xl-3">
                                                        <h5 class="dropdown-header">Exotic Vegetables</h5>
                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Asparagus &
                                                            Artichokes</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Avocados & Peppers</a>

                                                        <a class="dropdown-item"
                                                            href="shop-left-sidebar.html">Broccoli & Zucchini</a>

                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Celery,
                                                            Fennel &
                                                            Leeks</a>

                                                        <a class="dropdown-item" href="shop-left-sidebar.html">Chilies
                                                            & Lime</a>
                                                    </div>

                                                    <div class="dropdown-column dropdown-column-img col-3"></div>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Blog</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="blog-detail.html">Blog
                                                        Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="blog-grid.html">Blog Grid</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="blog-list.html">Blog List</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown new-nav-item">
                                            <label class="new-dropdown">New</label>
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Pages</a>
                                            <ul class="dropdown-menu">
                                                <li class="sub-dropdown-hover">
                                                    <a class="dropdown-item" href="javascript:void(0)">Email
                                                        Template <span class="new-text"><i
                                                                class="fa-solid fa-bolt-lightning"></i></span></a>
                                                    <ul class="sub-menu">
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/email-templete/abandonment-email.html">Abandonment</a>
                                                        </li>
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/email-templete/offer-template.html">Offer
                                                                Template</a>
                                                        </li>
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/email-templete/order-success.html">Order
                                                                Success</a>
                                                        </li>
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/email-templete/reset-password.html">Reset
                                                                Password</a>
                                                        </li>
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/email-templete/welcome.html">Welcome
                                                                template</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="sub-dropdown-hover">
                                                    <a class="dropdown-item" href="javascript:void(0)">Invoice
                                                        Template <span class="new-text"><i
                                                                class="fa-solid fa-bolt-lightning"></i></span></a>
                                                    <ul class="sub-menu">
                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/invoice/invoice-1.html">Invoice
                                                                1</a>
                                                        </li>

                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/invoice/invoice-2.html">Invoice
                                                                2</a>
                                                        </li>

                                                        <li>
                                                            <a
                                                                href="https://themes.pixelstrap.com/fastkart/invoice/invoice-3.html">Invoice
                                                                3</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="404.html">404</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="about-us.html">About Us</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="cart.html">Cart</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="contact-us.html">Contact</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="checkout.html">Checkout</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="coming-soon.html">Coming
                                                        Soon</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="compare.html">Compare</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="faq.html">Faq</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="order-success.html">Order
                                                        Success</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="order-tracking.html">Order
                                                        Tracking</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="otp.html">OTP</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="search.html">Search</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="user-dashboard.html">User
                                                        Dashboard</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="wishlist.html">Wishlist</a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)"
                                                data-bs-toggle="dropdown">Seller</a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="seller-become.html">Become a
                                                        Seller</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="seller-dashboard.html">Seller
                                                        Dashboard</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="seller-detail.html">Seller
                                                        Detail</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="seller-detail-2.html">Seller
                                                        Detail 2</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="seller-grid.html">Seller
                                                        Grid</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="seller-grid-2.html">Seller Grid
                                                        2</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="header-nav-right">
                        <button class="btn deal-button" data-bs-toggle="modal" data-bs-target="#deal-box">
                            <i data-feather="zap"></i>
                            <span>Deal Today</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@push('js')
<script type="module">
    import Echo from '/js/app.js'; 
    $(document).ready(function() {
        const userId = $('meta[name="user-id"]').attr('content');

        if (userId) {
            Echo.private(`user.${userId}`) 
                .listen('UserLocked', (e) => {
                    localStorage.removeItem('authToken');
                    sessionStorage.removeItem('authToken');
                    window.location.href = '/logout';
                    alert('Tài khoản của bạn đã bị khóa bởi quản trị viên. Vui lòng liên hệ quản trị viên để biết thêm chi tiết.');
                });
        }
    });
</script>
    <script>
        
        let countdown = 60;
        let timerInterval;

        $(document).ready(function() {
            // Hàm xác minh email
            $('#verifyButton').on('click', function() {
                const userId = {{ Auth::id() }};
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const statusTextElement = $('#statusText');
                const timerElement = $('#timer');
                const verifyButton = $('#verifyButton');

                // Hiển thị trạng thái "Đang gửi..." và bắt đầu đếm ngược ngay lập tức
                statusTextElement.text("Đang gửi...");
                startCountdown(timerElement, verifyButton); // Bắt đầu đếm ngược ngay khi nhấn

                $.ajax({
                    url: `{{ route('api.auth.verification.verify', ['id' => ':userId']) }}`
                        .replace(':userId', userId),
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Thêm CSRF token
                    },
                    success: function(data) {
                        if (data.status) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Gửi Mã Thành công!',
                                text: 'Vui lòng kiểm tra email của bạn!',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            // Xóa trạng thái "Đang gửi..." sau khi thành công
                            statusTextElement.text("");
                        } else {
                            // Hiển thị thông báo lỗi nếu có
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message
                            });

                            // Xóa trạng thái "Đang gửi..." nếu có lỗi
                            statusTextElement.text("");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra',
                            text: 'Vui lòng thử lại sau.'
                        });

                        // Xóa trạng thái "Đang gửi..." nếu có lỗi
                        statusTextElement.text("");
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });

        // Hàm đếm ngược và vô hiệu hóa nút gửi lại mã
        function startCountdown(timerElement, verifyButton) {
            verifyButton.prop('disabled', true); // Vô hiệu hóa nút sau khi nhấn
            countdown = 60; // Reset lại thời gian đếm ngược

            // Đảm bảo xóa bộ đếm trước khi tạo bộ mới
            if (timerInterval) {
                clearInterval(timerInterval);
            }

            timerInterval = setInterval(function() {
                countdown--;
                timerElement.text(`Bạn có thể gửi lại sau ${countdown} giây.`);
                if (countdown <= 0) {
                    clearInterval(timerInterval); // Dừng đếm ngược
                    timerElement.text('');
                    verifyButton.prop('disabled', false); // Kích hoạt lại nút sau khi 60 giây
                }
            }, 1000);
        }
    </script>
    <script>
        function updateCartSessionForHeader() {
            console.log("⚡ Hàm updateCartSessionForHeader() được gọi");

            let selectedProducts = [];
            let totalSum = 0;

            $(".drop-cart").each(function() {
                let row = $(this);
                let cartItemId = row.data("id");
                let qty = parseInt(row.find(".input-number").text()) || 1;
                let productId = row.data("product-id") || null;
                let productVariantId = row.data("product-variant-id") || null;
                let productName = row.find("h5").text().trim();
                let nameVariant = row.find(".selected-variation").text().trim() || null;
                let imageUrl = row.find(".drop-image img").attr("src") || "";

                if (imageUrl.startsWith("http")) {
                    let url = new URL(imageUrl);
                    imageUrl = url.pathname.replace("/storage/", "").replace(/^\/+/, "");
                }

                let originalPrice = parseInt(row.find(".price").val()) || 0;
                let salePrice = parseInt(row.find(".old_price").val()) || 0;
                let priceVariant = parseInt(row.find(".price_variant").val()) || 0;
                let salePriceVariant = parseInt(row.find(".old_price_variant").val()) || 0;
                let isSale = parseInt(row.find(".is_sale").val());
                let stock = parseInt(row.find(".stock").val());
                let finalPrice = salePrice > 0 ? salePrice : originalPrice;
                let oldPrice = salePrice > 0 ? originalPrice : null;

                let finalPriceVariant = salePriceVariant > 0 ? salePriceVariant : priceVariant;
                let oldPriceVariant = salePriceVariant > 0 ? priceVariant : null;

                selectedProducts.push({
                    id: cartItemId,
                    product_id: productId,
                    product_variant_id: productVariantId,
                    name: productName,
                    name_variant: nameVariant,
                    image: imageUrl,
                    price: finalPrice,
                    old_price: oldPrice,
                    price_variant: productVariantId ? finalPriceVariant : null,
                    old_price_variant: productVariantId ? oldPriceVariant : null,
                    quantity: productVariantId ? null : qty,
                    quantity_variant: productVariantId ? qty : null,
                    is_sale: isSale,
                    stock: stock,
                });

                totalSum += (productVariantId ? finalPriceVariant : finalPrice) * qty;
            });

            console.log("📤 Dữ liệu gửi lên server:", selectedProducts);
            console.log("📤 Tổng tiền gửi lên server:", totalSum);

            $.ajax({
                url: "{{ route('cart.saveSession') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    selectedProducts: selectedProducts,
                    total: totalSum
                },
                success: function(response) {
                    console.log("✅ Giỏ hàng header cập nhật thành công!", response);
                },
                error: function(xhr, status, error) {
                    console.log("❌ Lỗi khi cập nhật giỏ hàng:", xhr.responseText);
                }
            });

        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const suggestionsList = document.getElementById('suggestions');
            const searchBox = searchInput.closest('.search-box');
            const searchForm = searchInput.closest('form');

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                suggestionsList.innerHTML = '';

                if (query.length < 2) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                fetch(`/api/search/suggestions?query=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.length > 0) {
                            data.forEach(product => {
                                const listItem = document.createElement('li');
                                listItem.classList.add('suggestion-item');

                                const image = document.createElement('img');
                                image.src = `/storage/${product.thumbnail}`;
                                image.alt = product.name;
                                image.style.width = '30px';
                                image.style.height = '30px';
                                image.style.marginRight = '5px';
                                image.style.verticalAlign = 'middle';

                                const link = document.createElement('a');
                                link.href = `/products/${product.slug}`;
                                link.textContent = product.name;
                                link.style.textDecoration = 'none';
                                link.style.color = '#333';

                                listItem.appendChild(image);
                                listItem.appendChild(link);

                                listItem.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedProductName = product
                                        .name; // Get the name of the clicked product
                                    localStorage.setItem('selectedSuggestionName',
                                        selectedProductName); // Store the name
                                    window.location.href = link.href;
                                });

                                suggestionsList.appendChild(listItem);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        suggestionsList.style.display = 'none';
                    });
            });

    // Khôi phục tên sản phẩm đã chọn khi trang được load
    window.onload = function() {
        const selectedName = localStorage.getItem('selectedSuggestionName');
        if (selectedName) {
            searchInput.value = selectedName;
            localStorage.removeItem('selectedSuggestionName');
        }
    };


            // Ẩn gợi ý khi click ra ngoài
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });

        $(document).ready(function() {
            $(".button-group .cart-button.theme-bg-color").on("click", function() {
                console.log("⚡ Nút Thanh toán được click");
                updateCartSessionForHeader();
            });
        });

        // wishList
        function updateWishlistCount(count) {
            document.querySelector(".wishlist-count").textContent = count;
        }

        document.querySelectorAll(".wishlist-button").forEach(button => {
            button.addEventListener("click", function() {
                let productId = this.dataset.id;

                fetch(`/wishlist/toggle/${productId}`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.result) {
                            updateWishlistCount(data.wishlistCount);
                        }
                    })
                    .catch(error => console.error("Error updating wishlist:", error));
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const suggestionsList = document.getElementById('suggestions');
            const searchBox = searchInput.closest('.search-box');
            const searchForm = searchInput.closest('form');

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                suggestionsList.innerHTML = '';

                if (query.length < 2) {
                    suggestionsList.style.display = 'none';
                    return;
                }

                fetch(`/api/search/suggestions?query=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.length > 0) {
                            data.forEach(suggestion => {
                                const listItem = document.createElement('li');
                                listItem.textContent = suggestion;
                                listItem.addEventListener('click', function() {
                                    searchInput.value = suggestion;
                                    suggestionsList.style.display = 'none';
                                    searchForm
                                        .submit(); // Tự động submit form khi chọn gợi ý
                                });
                                suggestionsList.appendChild(listItem);
                            });
                            suggestionsList.style.display = 'block';
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching suggestions:', error);
                        suggestionsList.style.display = 'none';
                    });
            });

            // Ẩn gợi ý khi click ra ngoài
            document.addEventListener('click', function(event) {
                if (!searchBox.contains(event.target)) {
                    suggestionsList.style.display = 'none';
                }
            });
        });

        
    </script>
@endpush
