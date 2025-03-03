@extends('client.layouts.master')

@section('content')
    <!-- Home Section Start -->


    <section class="home-section pt-2">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xl-8 ratio_65">
                    <div class="home-contain h-100">
                        <div class="h-100">
                            <img src="{{ asset('theme/client/assets/images/product/bia1.png') }}"
                                class="bg-img blur-up lazyload" alt="">
                        </div>
                        <div class="home-detail p-center-left w-75">
                            <div>
                                <h6>Exclusive offer <span>30% Off</span></h6>
                                <h1 class="text-uppercase">Stay home & delivered your <span class="daily">Daily
                                        Needs</span></h1>
                                <p class="w-75 d-none d-sm-block">Vegetables contain many vitamins and minerals that
                                    are
                                    good for your health.</p>
                                <button onclick="location.href = 'shop-left-sidebar.html';"
                                    class="btn btn-animation mt-xxl-4 mt-2 home-button mend-auto">Mua Ngay <i
                                        class="fa-solid fa-right-long icon"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 ratio_65">
                    <div class="row g-4">
                        <div class="col-xl-12 col-md-6">
                            <div class="home-contain">
                                <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="home-detail p-center-left home-p-sm w-75">
                                    <div>
                                        <h2 class="mt-0 text-danger">45% <span class="discount text-title">OFF</span>
                                        </h2>
                                        <h3 class="theme-color">Nut Collection</h3>
                                        <p class="w-75">We deliver organic vegetables & fruits</p>
                                        <a href="shop-left-sidebar.html" class="shop-button">Mua Ngay <i
                                                class="fa-solid fa-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6">
                            <div class="home-contain">
                                <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="home-detail p-center-left home-p-sm w-75">
                                    <div>
                                        <h3 class="mt-0 theme-color fw-bold">Healthy Food</h3>
                                        <h4 class="text-danger">Organic Market</h4>
                                        <p class="organic">Start your daily shopping with some Organic food</p>
                                        <a href="shop-left-sidebar.html" class="shop-button">Mua Ngay <i
                                                class="fa-solid fa-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Section End -->

    <!-- Banner Section Start -->
    <section class="banner-section ratio_60 wow fadeInUp">
        <div class="container-fluid-lg">
            <div class="banner-slider">
                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Hot Deals on New Items</h5>
                                <h6 class="text-content">Daily Essentials Eggs & Dairy</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Buy More & Save More</h5>
                                <h6 class="text-content">Fresh Vegetables</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/bia1.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Organic Meat Prepared</h5>
                                <h6 class="text-content">Delivered to Your Home</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Buy More & Save More</h5>
                                <h6 class="text-content">Nuts & Snacks</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-3 col-xl-4 d-none d-xl-block">
                    <div class="p-sticky">
                        <div class="category-menu">
                            <h3>Danh Mục</h3>


                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <div class="category-list">
                                            <img src="{{ Storage::url($category->icon) }}" class="blur-up lazyload"
                                                alt="">
                                            <h5>
                                                <a
                                                    href="{{ route('categories', ['category' => $category->id]) }}">{{ $category->name }}</a>
                                            </h5>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <ul class="value-list">
                                <li>
                                    <div class="category-list">
                                        <h5 class="ms-0 text-title">
                                            <a href="shop-left-sidebar.html">Value of the Day</a>
                                        </h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="category-list">
                                        <h5 class="ms-0 text-title">
                                            <a href="shop-left-sidebar.html">Top 50 Offers</a>
                                        </h5>
                                    </div>
                                </li>
                                <li class="mb-0">
                                    <div class="category-list">
                                        <h5 class="ms-0 text-title">
                                            <a href="shop-left-sidebar.html">New Arrivals</a>
                                        </h5>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="ratio_156 section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ asset('theme/client/assets/images/vegetable/banner/8.jpg') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner">Seafood</h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold">Freshes</span> Products</h3>
                                        <h3 class="fw-light">every hour</h3>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md mend-auto">Mua Ngay <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ratio_medium section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ asset('theme/client/assets/images/vegetable/banner/11.jpg') }}"
                                    class="img-fluid blur-up lazyload" alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h4 class="text-yellow text-exo home-banner">Organic</h4>
                                        <h2 class="text-uppercase fw-normal mb-0 text-russo theme-color">fresh</h2>
                                        <h2 class="text-uppercase fw-normal text-title">Vegetables</h2>
                                        <p class="mb-3">Super Offer to 50% Off</p>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md mend-auto">Mua Ngay <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-t-space">
                            <div class="category-menu">
                                <h3>Sản Phẩm Hót</h3>

                                <ul class="product-list border-0 p-0 d-block">

                                    @foreach ($trendingProducts as $trendingProduct)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ route('categories', ['category' => $trendingProduct->id]) }}"
                                                    class="offer-image">
                                                    <img src="{{ Storage::url($trendingProduct->thumbnail) }}"
                                                        class="blur-up lazyload" alt="">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ route('categories', ['category' => $trendingProduct->id]) }}"
                                                            class="text-title">
                                                            <h6 class="name">{{ $trendingProduct->name }}</h6>
                                                        </a>
                                                        <span>{{ $trendingProduct->views }}</span>
                                                        <h6 class="price theme-color">
                                                            {{ number_format($trendingProduct->price, 0, ',', '.') }}₫</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>

                        <div class="section-t-space">
                            <div class="category-menu">
                                <h3>Customer Comment</h3>

                                <div class="review-box">
                                    <div class="review-contain">
                                        <h5 class="w-75">We Care About Our Customer Experience</h5>
                                        <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly
                                            used to demonstrate the visual form of a document or a typeface without
                                            relying on meaningful content.</p>
                                    </div>

                                    <div class="review-profile">
                                        <div class="review-image">
                                            <img src="{{ asset('theme/client/assets/images/vegetable/review/1.jpg') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                        <div class="review-detail">
                                            <h5>Tina Mcdonnale</h5>
                                            <h6>Sale Manager</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8">
                    <div class="title title-flex">
                        <div>
                            <h2>Các sản phẩm bán chạy nhất hôm nay.</h2>
                            <p></p>
                        </div>

                    </div>

                    <div class="section-b-space">
                        <div class="product-border  overflow-hidden">
                            <div>
                                <div class="row gx-3 gy-4">
                                    @foreach ($bestSellProductsToday as $topSell)
                                        <div class="col-lg-3 col-md-4 col-sm-6 ">
                                            <div class="product-box border rounded shadow-sm p-3">
                                                <div class="product-image">
                                                    <a href="{{ route('products', ['product' => $topSell->id]) }}">
                                                        <img src="{{ Storage::url($topSell->thumbnail) }}"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <ul class="product-option">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#view" data-id={{ $topSell->id }}>
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Compare">
                                                            <a href="compare.html">
                                                                <i data-feather="refresh-cw"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="wishlist.html" class="notifi-wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product-detail">
                                                    <a href="{{ route('products', ['product' => $topSell->id]) }}">
                                                        <h6 class="name">{{ $topSell->product_names }}</h6>
                                                    </a>

                                                    <h5 class="sold text-content">
                                                        <span
                                                            class="theme-color price">{{ number_format($topSell->price, 0, ',', '.') }}₫</span>
                                                        <del>{{ number_format($topSell->sale_price, 0, ',', '.') }}₫</del>
                                                    </h5>


                                                    <div class="product-rating mt-sm-2 mt-1">
                                                        <ul class="rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star"
                                                                        class="{{ $i <= round($topSell->average_rating) ? 'fill' : '' }}"></i>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </div>

                                                    <div class="add-to-cart-box">
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#view" data-id={{ $topSell->id }}
                                                        class="btn btn-add-cart addcart-button">
                                                        Add
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title">
                        <h2>Các danh mục nổi bật hàng đầu của tuần.</h2>
                    </div>

                    <div class="category-slider-2 product-wrapper no-arrow">
                        @foreach ($topCategoriesInweek as $topCategory)
                            <div>
                                <a href="{{ route('categories', ['category' => $topCategory->id]) }}"
                                    class="category-box category-dark">
                                    <div>
                                        <img src="{{ Storage::url($topCategory->icon) }}" class="blur-up lazyload"
                                            alt="">
                                        <h5>{{ $topCategory->name }}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-t-space section-b-space">
                        <div class="row g-md-4 g-3">
                            <div class="col-md-6">
                                <div class="banner-contain hover-effect">
                                    <img src="{{ asset('theme/client/assets/images/vegetable/banner/9.jpg') }}"
                                        class="bg-img blur-up lazyload" alt="">
                                    <div class="banner-details p-center-left p-4">
                                        <div>
                                            <h3 class="text-exo">50% offer</h3>
                                            <h4 class="text-russo fw-normal theme-color mb-2">Testy Mushrooms</h4>
                                            <button onclick="location.href = 'shop-left-sidebar.html';"
                                                class="btn btn-animation btn-sm mend-auto">Mua Ngay <i
                                                    class="fa-solid fa-arrow-right icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-contain hover-effect">
                                    <img src="{{ asset('theme/client/assets/images/vegetable/banner/10.jpg') }}"
                                        class="bg-img blur-up lazyload" alt="">
                                    <div class="banner-details p-center-left p-4">
                                        <div>
                                            <h3 class="text-exo">50% offer</h3>
                                            <h4 class="text-russo fw-normal theme-color mb-2">Fresh MEAT</h4>
                                            <button onclick="location.href = 'shop-left-sidebar.html';"
                                                class="btn btn-animation btn-sm mend-auto">Mua Ngay <i
                                                    class="fa-solid fa-arrow-right icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title d-block">
                        <h2>Sản phẩm dành cho bạn.</h2>
                        <p></p>
                    </div>

                    <div class="section-b-space">
                        <div class="product-border  overflow-hidden">
                            <div>
                                <div class="row gx-3 gy-4">
                                    @foreach ($aiSuggestedProducts as $aiSuggest)
                                        <div class="col-lg-3 col-md-4 col-sm-6 ">
                                            <div class="product-box border rounded shadow-sm p-3">
                                                <div class="product-image">
                                                    <a href="{{ route('products', ['product' => $aiSuggest->id]) }}">
                                                        <img src="{{ Storage::url($aiSuggest->thumbnail) }}"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <ul class="product-option">
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#view" data-id={{ $aiSuggest->id }}>
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Compare">
                                                            <a href="compare.html">
                                                                <i data-feather="refresh-cw"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="notifi-wishlist wishlist-toggle"
                                                                data-product-id="{{ $aiSuggest->id }}">
                                                                <i data-feather="heart" class="wishlist-icon"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product-detail">
                                                    <a href="{{ route('products', ['product' => $aiSuggest->id]) }}">
                                                        <h6 class="name">{{ $aiSuggest->name }}</h6>
                                                    </a>

                                                    <h5 class="sold text-content">
                                                        <span
                                                            class="theme-color price">{{ number_format($aiSuggest->sale_price ?? $aiSuggest->price) }}
                                                            ₫</span>
                                                        @if ($aiSuggest->sale_price)
                                                            <del>{{ number_format($aiSuggest->price) }} ₫</del>
                                                        @endif
                                                    </h5>

                                                    <div class="product-rating mt-sm-2 mt-1">
                                                        <ul class="rating">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i data-feather="star"
                                                                        class="{{ $i <= round($aiSuggest->average_rating) ? 'fill text-warning' : '' }}"></i>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </div>

                                                    <div class="add-to-cart-box">
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#view" data-id={{ $aiSuggest->id }}
                                                            class="btn btn-add-cart addcart-button">
                                                            Add
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="section-t-space">
                        <div class="banner-contain">
                            <img src="{{ asset('theme/client/assets/images/vegetable/banner/15.jpg') }}"
                                class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center p-4 text-white text-center">
                                <div>
                                    <h3 class="lh-base fw-bold offer-text">Get $3 Cashback! Min Order of $30</h3>
                                    <h6 class="coupon-code">Use Code : GROCERY1920</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-t-space section-b-space">
                        <div class="row g-md-4 g-3">
                            <div class="col-xxl-8 col-xl-12 col-md-7">
                                <div class="banner-contain hover-effect">
                                    <img src="{{ asset('theme/client/assets/images/vegetable/banner/12.jpg') }}"
                                        class="bg-img blur-up lazyload" alt="">
                                    <div class="banner-details p-center-left p-4">
                                        <div>
                                            <h2 class="text-kaushan fw-normal theme-color">Get Ready To</h2>
                                            <h3 class="mt-2 mb-3">TAKE ON THE DAY!</h3>
                                            <p class="text-content banner-text">In publishing and graphic design,
                                                Lorem
                                                ipsum is a placeholder text commonly used to demonstrate.</p>
                                            <button onclick="location.href = 'shop-left-sidebar.html';"
                                                class="btn btn-animation btn-sm mend-auto">Mua Ngay <i
                                                    class="fa-solid fa-arrow-right icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-12 col-md-5">
                                <a href="shop-left-sidebar.html" class="banner-contain hover-effect h-100">
                                    <img src="{{ asset('theme/client/assets/images/vegetable/banner/13.jpg') }}"
                                        class="bg-img blur-up lazyload" alt="">
                                    <div class="banner-details p-center-left p-4 h-100">
                                        <div>
                                            <h2 class="text-kaushan fw-normal text-danger">20% Off</h2>
                                            <h3 class="mt-2 mb-2 theme-color">SUMMRY</h3>
                                            <h3 class="fw-normal product-name text-title">Product</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="title d-block">
                        <div>
                            <h2>Sản phẩm bán chạy nhất của chúng tôi</h2>
                        </div>
                    </div>


                    <div class="best-selling-slider product-wrapper wow fadeInUp">
                        @foreach ($bestSellingProducts->chunk(4) as $chunk)
                            <div>
                                <ul class="product-list">
                                    @foreach ($chunk as $product)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ route('products', ['product' => $product->product_id]) }}"
                                                    class="offer-image">
                                                    <img src="{{ $product->thumbnail }}" class="blur-up lazyload"
                                                        alt="{{ $product->product_name }}">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ route('products', ['product' => $product->product_id]) }}"
                                                            class="text-title">
                                                            <h6 class="name">{{ $product->product_name }}</h6>
                                                        </a>
                                                        <span>{{ $product->total_sold }} đã bán</span>
                                                        <h6 class="price theme-color">
                                                            {{ number_format($product->price) }}₫</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <div class="section-t-space">
                        <div class="banner-contain hover-effect">
                            <img src="{{ asset('theme/client/assets/images/vegetable/banner/14.jpg') }}"
                                class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center banner-b-space w-100 text-center">
                                <div>
                                    <h6 class="ls-expanded theme-color mb-sm-3 mb-1">SUMMER</h6>
                                    <h2 class="banner-title">VEGETABLE</h2>
                                    <h5 class="lh-sm mx-auto mt-1 text-content">Save up to 5% OFF</h5>
                                    <button onclick="location.href = 'shop-left-sidebar.html';"
                                        class="btn btn-animation btn-sm mx-auto mt-sm-3 mt-2">Mua Ngay <i
                                            class="fa-solid fa-arrow-right icon"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    <!-- Newsletter Section Start -->
    <section class="newsletter-section section-b-space">
        <div class="container-fluid-lg">
            <div class="newsletter-box newsletter-box-2">
                <div class="newsletter-contain py-5">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xxl-4 col-lg-5 col-md-7 col-sm-9 offset-xxl-2 offset-md-1">
                                <div class="newsletter-detail">
                                    <h2>Join our newsletter and get...</h2>
                                    <h5>$20 discount for your first order</h5>
                                    <div class="input-box">
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Your Email">
                                        <i class="fa-solid fa-envelope arrow"></i>
                                        <button class="sub-btn  btn-animation">
                                            <span class="d-sm-block d-none">Subscribe</span>
                                            <i class="fa-solid fa-arrow-right icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Newsletter Section End -->
@endsection

@section('modal')
    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2" id="productDetails">
                        <div class="col-lg-6">
                            <div class="slider-image">
                                <img id="prdThumbnail" src="" class="img-fluid blur-up lazyload" alt="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name" id='prdName'></h4>
                                <h4 class="price" id='prdPrice'></h4>
                                {{-- <div class="product-rating">
                                    <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>
                                    <span class="ms-2">8 Reviews</span>
                                    <span class="ms-2 text-danger">6 sold in last 16 hours</span>
                                </div> --}}

                                <div class="product-detail">
                                    <h4>Product Details :</h4>
                                    <p id='prdDescription'></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Brand:</h5>
                                            <h6 id = 'prdBrand'></h6>
                                        </div>
                                    </li>

                                    {{-- <li>
                                        <div class="brand-box">
                                            <h5>Product Code:</h5>
                                            <h6>W0690034</h6>
                                        </div>
                                    </li> --}}

                                    <li>
                                        <div class="brand-box">
                                            <h5>Category:</h5>
                                            <h6 id="prdCategories"></h6>
                                        </div>
                                    </li>
                                </ul>

                                {{-- Thuốc tính biến thể --}}
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="color">Color:</label>
                                            <select class="form-control" id="color">
                                                <option selected>Select Color</option>
                                                <option value="red">Red</option>
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ram">RAM:</label>
                                            <select class="form-control" id="ram">
                                                <option selected>Select RAM</option>
                                                <option value="4gb">4GB</option>
                                                <option value="8gb">8GB</option>
                                                <option value="16gb">16GB</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="screen">Screen Size:</label>
                                            <select class="form-control" id="screen">
                                                <option selected>Select Screen Size</option>
                                                <option value="13inch">13 inch</option>
<option value="13inch">13 inch</option>
                                                <option value="15inch">15 inch</option>
                                                <option value="17inch">17 inch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div id="productVariants">

                                </div>

                                <div class="modal-button">
                                    <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" id="cartProductId">
                                        <input type="hidden" name="product_variant_id" id="cartProductVariantId">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-md add-cart-button icon">Add To
                                            Cart</button>
                                    </form>
                                    <button onclick="location.href = 'product-left.html';"
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // sửa lại script để phù hợp với làm giỏ hàng

        $(document).ready(function() {

            let productVariantsData = {};

            // Khi mở modal, reset nội dung để tránh hiển thị dữ liệu cũ
            $('#view').on('hidden.bs.modal', function() {
                $('#prdName, #prdPrice, #prdDescription, #prdBrand, #prdCategories').text('');
                $('#prdThumbnail').attr('src', '');
                $('#productVariants').empty();
                $('#cartProductId').val('');
                $('#cartProductVariantId').val('');
                productVariantsData = {};
            });

            // Khi nhấn vào xem sản phẩm (mở modal)
            $('a[data-bs-target="#view"]').click(function() {
                var productId = $(this).data('id');
                console.log("🔍 Modal mở cho Product ID:", productId);
                $('#cartProductId').val(productId);

                $.ajax({
                    url: '/api/product/' + productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("📦 Dữ liệu sản phẩm:", response);

                        // Cập nhật thông tin sản phẩm
                        $('#prdName').text(response.name).data('id', response.id);
                        $('#prdPrice').text(response.price).data('default-price', response
                            .price);
                        $('#prdDescription').text(response.description);
                        $('#prdThumbnail').attr('src', response.thumbnail).data(
                            'default-thumbnail', response.thumbnail);
                        $('#prdBrand').text(response.brand);
                        $('#prdCategories').text(response.categories);
                        $('#productVariants').empty();
                        productVariantsData = {};

                        if (response.productVariants && response.productVariants.length > 0) {
                            let allAttributes = {};

                            response.productVariants.forEach(variant => {
                                let variantId = variant.id;
                                productVariantsData[variantId] = {
                                    id: variantId,
                                    price: variant.sale_price ? variant.sale_price :
                                        variant.price,
                                    thumbnail: variant.thumbnail,
                                    attribute_values: variant.attribute_values
                                };

                                variant.attribute_values.forEach(attr => {
                                    if (!allAttributes[attr.attributes_name]) {
                                        allAttributes[attr
                                            .attributes_name] = [];
                                    }
                                    if (!allAttributes[attr.attributes_name]
                                        .some(v => v.id === attr.id)) {
                                        allAttributes[attr.attributes_name]
                                            .push({
                                                id: attr.id,
                                                attribute_value: attr
                                                    .attribute_value
                                            });
                                    }
                                });
                            });

                            let attributesHtml = '';
                            for (const attrName in allAttributes) {
                                attributesHtml += `
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="${attrName}">${attrName}:</label>
                                    <select class="form-control attribute-select" id="${attrName}">
                                        <option value="">Chọn ${attrName}</option>
                                        ${allAttributes[attrName].map(attr => `<option value="${attr.id}">${attr.attribute_value}</option>`).join('')}
                                    </select>
                                </div>
                            </div>`;
                            }

                            $('#productVariants').html('<div class="row">' + attributesHtml +
                                '</div>');

                            // Bắt sự kiện chọn thuộc tính để cập nhật biến thể
                            $('.attribute-select').change(updateSelectedVariant);
                        } else {
                            $('#productVariants').html(
                                '<p>Sản phẩm này hiện không có biến thể.</p>');
                        }
                    },
                    error: function(xhr) {
                        alert('Không tìm thấy sản phẩm.');
                    }
                });
            });

            function getCurrentVariantId() {
                let selectedAttributes = {};
                $('.attribute-select').each(function() {
                    let attrName = $(this).attr('id');
                    let selectedValueId = $(this).val();
                    if (selectedValueId) {
                        selectedAttributes[attrName] = selectedValueId;
                    }
                });

                let matchedVariant = Object.values(productVariantsData).find(variant => {
                    return variant.attribute_values.every(attr => selectedAttributes[attr
                        .attributes_name] == attr.id);
                });

                return matchedVariant ? matchedVariant.id : null;
            }

            function updateSelectedVariant() {
                let selectedVariantId = getCurrentVariantId();
                console.log("🛒 Biến thể được chọn:", selectedVariantId);

                if (selectedVariantId) {
                    let selectedVariant = productVariantsData[selectedVariantId];
                    $('#prdPrice').text(selectedVariant.price);
                    $('#prdThumbnail').attr('src', selectedVariant.thumbnail);
                    $('#cartProductVariantId').val(selectedVariantId);
                } else {
                    console.log("⚠️ Không tìm thấy biến thể phù hợp!");
                    $('#cartProductVariantId').val(null);
                    $('#prdPrice').text($('#prdPrice').data('default-price'));
                    $('#prdThumbnail').attr('src', $('#prdThumbnail').data('default-thumbnail'));
                }
            }

            $('#addToCartForm').submit(function(e) {
                e.preventDefault();

                let productId = $('#cartProductId').val();
                let selectedVariantId = $('#cartProductVariantId').val();

                console.log("🛒 ID sản phẩm trong form:", productId);
                console.log("🛒 ID biến thể đã chọn:", selectedVariantId);

                if (!productId) {
                    alert("Lỗi: Không tìm thấy ID sản phẩm.");
                    return;
                }

                this.submit();
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

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true
                });
            @endif

            $(document).on('click', '.wishlist-toggle', function(e) {
                e.preventDefault();

                var productId = $(this).data('product-id'); // Lấy product ID từ thuộc tính data-product-id
                var icon = $(this).find('.wishlist-icon'); // Chỉ chọn icon trong element hiện tại

                $.ajax({
                    url: `/account/wishlist/toggle/${productId}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {
                        product_id: productId
                    },
                    success: function(data) {
                        if (data.result) {
                            if (data.action === 'added') {
                                icon.css('color', 'red'); // Đổi màu khi thêm vào wishlist
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã thêm!',
                                    text: 'Sản phẩm đã được thêm vào danh sách yêu thích!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else if (data.action === 'removed') {
                                icon.css('color', 'black'); // Đổi màu khi xóa khỏi wishlist
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã xóa!',
                                    text: 'Sản phẩm đã bị xóa khỏi danh sách yêu thích!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message ||
                                    'Có lỗi xảy ra, vui lòng thử lại!',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra, vui lòng thử lại!',
                        });
                    }
                });
            });

        });
    </script>
@endpush
