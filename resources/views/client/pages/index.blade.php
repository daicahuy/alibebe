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
                        {{-- <div class="home-detail p-center-left w-75">
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
                        </div> --}}
                    </div>
                </div>

                <div class="col-xl-4 ratio_65">
                    <div class="row g-4">
                        <div class="col-xl-12 col-md-6">
                            <div class="home-contain">
                                <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                {{-- <div class="home-detail p-center-left home-p-sm w-75">
                                    <div>
                                        <h2 class="mt-0 text-danger">45% <span class="discount text-title">OFF</span>
                                        </h2>
                                        <h3 class="theme-color">Nut Collection</h3>
                                        <p class="w-75">We deliver organic vegetables & fruits</p>
                                        <a href="shop-left-sidebar.html" class="shop-button">Mua Ngay <i
                                                class="fa-solid fa-right-long"></i></a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6">
                            <div class="home-contain">
                                <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                {{-- <div class="home-detail p-center-left home-p-sm w-75">
                                    <div>
                                        <h3 class="mt-0 theme-color fw-bold">Healthy Food</h3>
                                        <h4 class="text-danger">Organic Market</h4>
                                        <p class="organic">Start your daily shopping with some Organic food</p>
                                        <a href="shop-left-sidebar.html" class="shop-button">Mua Ngay <i
                                                class="fa-solid fa-right-long"></i></a>
                                    </div>
                                </div> --}}
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
                        {{-- <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Hot Deals on New Items</h5>
                                <h6 class="text-content">Daily Essentials Eggs & Dairy</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div> --}}
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        {{-- <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Buy More & Save More</h5>
                                <h6 class="text-content">Fresh Vegetables</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div> --}}
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/bia1.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        {{-- <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Organic Meat Prepared</h5>
                                <h6 class="text-content">Delivered to Your Home</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div> --}}
                    </div>
                </div>

                <div>
                    <div class="banner-contain hover-effect">
                        <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                            class="bg-img blur-up lazyload" alt="">
                        {{-- <div class="banner-details">
                            <div class="banner-box">
                                <h6 class="text-danger">5% OFF</h6>
                                <h5>Buy More & Save More</h5>
                                <h6 class="text-content">Nuts & Snacks</h6>
                            </div>
                            <a href="shop-left-sidebar.html" class="banner-button text-white">Mua Ngay <i
                                    class="fa-solid fa-right-long ms-2"></i></a>
                        </div> --}}
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
                                                    href="{{ route('categories', $category->slug) }}">{{ $category->name }}</a>
                                            </h5>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- <ul class="value-list">
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
                            </ul> --}}
                        </div>

                        <div class="ratio_156 section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                                    class="bg-img blur-up lazyload" alt="">
                                {{-- <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner">Seafood</h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold">Freshes</span> Products</h3>
                                        <h3 class="fw-light">every hour</h3>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md mend-auto">Mua Ngay <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="ratio_medium section-t-space">
                            <div class="home-contain hover-effect">
                                <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                                    class="img-fluid blur-up lazyload" alt="">
                                {{-- <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h4 class="text-yellow text-exo home-banner">Organic</h4>
                                        <h2 class="text-uppercase fw-normal mb-0 text-russo theme-color">fresh</h2>
                                        <h2 class="text-uppercase fw-normal text-title">Vegetables</h2>
                                        <p class="mb-3">Super Offer to 50% Off</p>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md mend-auto">Mua Ngay <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        <div class="section-t-space">
                            <div class="category-menu">
                                <h3>Sản Phẩm Hót</h3>

                                <ul class="product-list border-0 p-0 d-block">

                                    @foreach ($trendingProducts->take(10) as $trendingProduct)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ route('products', ['product' => $trendingProduct->id]) }}"
                                                    class="offer-image">
                                                    <img src="{{ Storage::url($trendingProduct->thumbnail) }}"
                                                        class="blur-up lazyload" alt="">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ route('products', ['product' => $trendingProduct->id]) }}"
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

                        {{-- <div class="section-t-space">
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
                                            <img src="{{ asset('theme/client/assets/images/product/vendor.png') }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                data-bs-target="#view" data-id={{ $topSell->id }}>
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="So sánh">
                                                            <a href="javascript:;" class="compare-toggle"
                                                                data-state="unselected"
                                                                data-product-id="{{ $topSell->id }}"
                                                                data-product-category-id="{{ $topSell->categories->first()->id ?? null }}">
                                                                <span class="icon-refresh">
                                                                    <i data-feather="refresh-cw"></i>
                                                                </span>
                                                                <span class="icon-check" style="display:none;">
                                                                    <i data-feather="check"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="notifi-wishlist wishlist-toggle"
                                                                data-product-id="{{ $topSell->id }}">
                                                                <i data-feather="heart" class="wishlist-icon"
                                                                    style="color: {{ in_array($topSell->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
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
                                                        <span
                                                            class="text-muted ms-2">({{ number_format($topSell->average_rating, 1) }})</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mt-sm-2 mt-1">
                                                        <h6 class="unit">Lượt xem: {{ $topSell->views_count }}</h6>
                                                        <h6 class="unit">Đã Bán: {{ $topSell->total_sold }}</h6>
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
                                    <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
                                        class="bg-img blur-up lazyload" alt="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner-contain hover-effect">
                                    <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
                                        class="bg-img blur-up lazyload" alt="">
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
                                                            title="So sánh">
                                                            <a href="javascript:;" class="compare-toggle"
                                                                data-state="unselected"
                                                                data-product-id="{{ $aiSuggest->id }}"
                                                                data-product-category-id="{{ $aiSuggest->categories->first()->id ?? null }}">
                                                                <span class="icon-refresh">
                                                                    <i data-feather="refresh-cw"></i>
                                                                </span>
                                                                <span class="icon-check" style="display:none;">
                                                                    <i data-feather="check"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="notifi-wishlist wishlist-toggle"
                                                                data-product-id="{{ $aiSuggest->id }}">
                                                                <i data-feather="heart" class="wishlist-icon"
                                                                    style="color: {{ in_array($aiSuggest->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product-detail">
                                                    <a href="{{ route('products', ['product' => $aiSuggest->id]) }}">
                                                        <h6 class="name">{{ $aiSuggest->name }}</h6>
                                                    </a>

                                                    <h5 class="sold text-content">
                                                        <span class="theme-color price">
                                                            {{ number_format($aiSuggest->sale_price > 0 ? $aiSuggest->sale_price : $aiSuggest->price) }}
                                                            ₫
                                                        </span>

                                                        @if (!is_null($aiSuggest->sale_price) && $aiSuggest->sale_price > 0 && $aiSuggest->sale_price != $aiSuggest->price)
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
                                                        <span
                                                            class="text-muted ms-2">({{ number_format($aiSuggest->average_rating, 1) }})</span>
                                                    </div>

                                                    <div class="d-flex justify-content-between mt-sm-2 mt-1">
                                                        <h6 class="unit">Lượt xem: {{ $aiSuggest->views_count }}</h6>

                                                        @if (isset($aiSuggest->total_sold))
                                                            <h6 class="unit">Đã Bán: {{ $aiSuggest->total_sold }}</h6>
                                                        @endif
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


                    {{-- <div class="section-t-space">
                        <div class="banner-contain">
                            <img src="{{ asset('theme/client/assets/images/product/bia1.png') }}"
                                class="bg-img blur-up lazyload" alt="">
                            <div class="banner-details p-center p-4 text-white text-center">
                                <div>
                                    <h3 class="lh-base fw-bold offer-text">Get $3 Cashback! Min Order of $30</h3>
                                    <h6 class="coupon-code">Use Code : GROCERY1920</h6>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="section-t-space section-b-space">
                        <div class="row g-md-4 g-3">
                            <div class="col-xxl-8 col-xl-12 col-md-7">
                                <div class="banner-contain hover-effect">
                                    <img src="{{ asset('theme/client/assets/images/product/image1.png') }}"
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
                                    <img src="{{ asset('theme/client/assets/images/product/image2.png') }}"
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
                    </div> --}}

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
                            <img src="{{ asset('theme/client/assets/images/product/vendor.png') }}"
                                class="bg-img blur-up lazyload" alt="">

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
                                <div class="product-rating" id="prdRating">
                                    <ul class="rating">

                                    </ul>
                                    {{-- <span class="ms-2">8 Reviews</span> --}}
                                    <span class="ms-2 text-danger" id="prdSoldCount"></span>
                                </div>

                                <div class="product-stock">
                                    <span> </span>
                                </div>

                                <div class="product-detail">
                                    <h4>Mô tả sản phẩm :</h4>
                                    <p id='prdDescription'></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Thương Hiệu:</h5>
                                            <h6 id = 'prdBrand'></h6>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="brand-box">
                                            <h5>Danh Mục:</h5>
                                            <h6 id="prdCategories"></h6>
                                        </div>
                                    </li>
                                </ul>

                                <div id="productVariants">

                                </div>

                                <div class="modal-button">
                                    <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" id="cartProductId">
                                        <input type="hidden" name="product_variant_id" id="cartProductVariantId">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-md add-cart-button icon">Thêm Vào giỏ
                                            hàng</button>
                                    </form>
                                    <button
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md detail-product-button"
                                        data-product-id="">
                                        Xem chi tiết sản phẩm
                                    </button>
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
        // Hàm định dạng giá tiền sang VNĐ
        function formatPrice(price) {
            const number = parseFloat(price) // Chuyển đổi giá sang số thực
            return isNaN(number) ? "0 đ" : number.toLocaleString('vi-VN', { // Định dạng số sang VNĐ
                style: 'currency',
                currency: 'VND'
            })
        }
        // sửa lại script để phù hợp với làm giỏ hàng

        $(document).ready(function() {
                $('.detail-product-button').click(function() {
                    const productId = $('#view').data('product-id'); // Lấy product-id từ modal

                    if (productId) {
                        const productDetailUrl = "{{ route('products', ['product' => ':productId']) }}"
                            .replace(':productId', productId);
                        location.href = productDetailUrl;
                    } else {
                        console.error("Không tìm thấy product_id hoặc phần tử #view không tồn tại.");
                        alert("Lỗi: Không tìm thấy thông tin sản phẩm.");
                    }
                });


                let productVariantsData = {};
                $('.view-button').click(function() {
                    const productId = $(this).data('product-id'); // Lấy product-id từ nút "View"
                    $('#view').data('product-id', productId); // Gán product-id vào modal
                });

                $('#view').on('hidden.bs.modal', function() {
                    $('#prdName, #prdPrice, #prdDescription, #prdBrand, #prdCategories').text('');
                    $('#prdThumbnail').attr('src', '');
                    $('#productVariants').empty();
                    $('#cartProductId').val('');
                    $('#cartProductVariantId').val('');
                    productVariantsData = {};
                });

                $('a[data-bs-target="#view"]').click(function() {

                    let productId = $(this).data('id');
                    $('#view').data('product-id', productId);
                    $('#cartProductId').val(productId);

                    console.log("🔍 Modal mở cho Product ID:", productId);

                    $.ajax({
                        url: '/api/product/' + productId,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log("📦 Dữ liệu sản phẩm:", response);

                            $('#prdName').text(response.name).data('product-name', response.name);
                            $('#prdDescription').text(response.short_description);
                            $('#prdThumbnail').attr('src', response.thumbnail).data(
                                'default-thumbnail', response.thumbnail);
                            $('#prdBrand').text(response.brand);
                            $('#prdCategories').text(response.categories);
                            $('#productVariants').empty();

                            // 🟢 Hiển thị đánh giá trung bình
                            const avgRating = response.avgRating || 0;
                            $('#prdRating ul.rating').html(
                                Array.from({
                                        length: 5
                                    }, (_, i) =>
                                    `<li><i data-feather="star" class="${i < avgRating ? 'fill' : ''}"></i></li>`
                                ).join('')
                            );
                            feather.replace();

                            // 🟢 Hiển thị kho sản phẩm thường trước khi chọn biến thể
                            var stockQuantity = response.stock_quantity || 0;
                            $('.product-stock span').text(`Kho: ${stockQuantity}`);
                            $('#productVariants').data('stock', stockQuantity);

                            // Đã bán
                            $('#prdSoldCount').text(`Đã bán (${response.sold_count})`);

                            productVariantsData = {};
                            let defaultPrice = response.price;
                            let defaultVariantId = null;

                            if (response.productVariants && response.productVariants.length > 0) {
                                let allAttributes = {};

                                response.productVariants.forEach(variant => {
                                    let variantId = variant.id;
                                    let stock = variant.product_stock?.stock ?? 0;

                                    productVariantsData[variantId] = {
                                        id: variantId,
                                        price: variant.sale_price ?? variant.price,
                                        thumbnail: variant.thumbnail,
                                        attribute_values: variant.attribute_values,
                                        stock_quantity: stock,
                                        sold_count: variant
                                            .sold_count // 🟢 Hiển thị số lượng đã bán của biến thể
                                    };

                                    if (!defaultVariantId) {
                                        defaultVariantId = variantId;
                                        defaultPrice = variant.sale_price ?? variant.price;
                                    }

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
                                $('.attribute-select').change(updateSelectedVariant);
                            } else {
                                $('#productVariants').html(
                                    '<p>Sản phẩm này hiện không có biến thể.</p>');
                            }

                            $('#prdPrice').text(formatPrice(defaultPrice)).data('default-price',
                                defaultPrice);
                            $('#cartProductVariantId').val('');
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
                            selectedAttributes[attrName] = parseInt(selectedValueId);
                        }
                    });

                    console.log("🔍 Thuộc tính đã chọn:", selectedAttributes);

                    let matchedVariant = Object.values(productVariantsData).find(variant => {
                        if (!variant.attribute_values || variant.attribute_values.length === 0) {
                            return false;
                        }

                        return variant.attribute_values.every(attr => {
                            return selectedAttributes[attr.attributes_name] === attr.id;
                        });
                    });

                    return matchedVariant ? matchedVariant.id : null;
                }

                function updateSelectedVariant() {
                    let selectedAttributes = {};
                    $(".attribute-select").each(function() {
                        let attrName = $(this).attr("id");
                        let attrValue = $(this).val();
                        if (attrValue) selectedAttributes[attrName] = attrValue;
                    });

                    let selectedVariant = Object.values(productVariantsData).find(variant => {
                        return variant.attribute_values.every(attr =>
                            selectedAttributes[attr.attributes_name] == attr.id
                        );
                    });

                    if (selectedVariant) {
                        console.log("📦 Biến thể được chọn:", selectedVariant);
                        console.log("Số lượng đã bán của biến thể:", selectedVariant
                        .sold_count); // Thêm dòng này để debug

                        $("#prdPrice").text(formatPrice(selectedVariant.price));
                        $("#prdThumbnail").attr("src", selectedVariant.thumbnail);
                        $(".product-stock span").text(`Kho: ${selectedVariant.stock_quantity}`);
                        $("#prdSoldCount").text(
                            `Đã bán biến thể : (${selectedVariant.sold_count || 0})`); // 🟢 Hiển thị số lượng đã bán
                        $("#cartProductVariantId").val(selectedVariant.id);
                    }
                }

                $('#addToCartForm').submit(function(e) {
                    e.preventDefault();

                    let productId = $('#cartProductId').val();
                    let selectedVariantId = $('#cartProductVariantId').val();
                    let hasVariant = $('#productVariants .attribute-select').length > 0;

                    console.log("🛒 ID sản phẩm trong form:", productId);
                    console.log("🛒 ID biến thể đã chọn:", selectedVariantId);
                    console.log("🔍 Sản phẩm có biến thể?", hasVariant);

                    // Kiểm tra nếu sản phẩm có biến thể nhưng chưa chọn
                    if (hasVariant && (!selectedVariantId || selectedVariantId.trim() === "")) {
                        Swal.fire({
                            icon: "warning",
                            title: "Vui lòng chọn biến thể!",
                            text: "Bạn cần chọn màu sắc hoặc kích thước trước khi thêm vào giỏ hàng.",
                        });
                        return;
                    }

                    // Lấy số lượng tồn kho của sản phẩm (có thể là sản phẩm chính hoặc biến thể)
                    let stockQuantity = 0;

                    if (selectedVariantId) {
                        let selectedVariant = productVariantsData[selectedVariantId];
                        stockQuantity = selectedVariant ? selectedVariant.stock_quantity : 0;
                    } else {
                        // Nếu không có biến thể, lấy số lượng tồn kho của sản phẩm chính
                        stockQuantity = $('#productVariants').data('stock') || 0;
                    }

                    console.log("🛒 Số lượng tồn kho:", stockQuantity);

                    // Kiểm tra nếu hết hàng
                    if (stockQuantity <= 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: "Sản phẩm này đã hết hàng.",
                        });
                        return;
                    }

                    // Nếu còn hàng, gửi yêu cầu thêm vào giỏ
                    $.ajax({
                        url: $('#addToCartForm').attr('action'),
                        method: $('#addToCartForm').attr('method'),
                        data: $('#addToCartForm').serialize(),
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Thêm vào giỏ hàng thành công!",
                                text: "Sản phẩm của bạn đã được thêm vào giỏ hàng.",
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: "error",
                                title: "Lỗi!",
                                text: "Có lỗi xảy ra khi thêm vào giỏ hàng.",
                            });
                        }
                    });
                });


                // comrpert
                 // comapre cookie
                const compareCookieName = 'compare_list'; // Tên cookie để lưu danh sách so sánh

                // Hàm lấy cookie theo tên
                function getCookie(name) {
                    let cookieValue = null;
                    if (document.cookie && document.cookie !== '') {
                        const cookies = document.cookie.split(';');
                        for (let i = 0; i < cookies.length; i++) {
                            const cookie = cookies[i].trim();
                            // Does this cookie string begin with the name we want?
                            if (cookie.startsWith(name + '=')) {
                                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                                break;
                            }
                        }
                    }
                    return cookieValue;
                }

                // Hàm set cookie
                function setCookie(name, value, days) {
                    var expires = "";
                    if (days) {
                        var date = new Date();
                        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                        expires = "; expires=" + date.toUTCString();
                    }
                    document.cookie = name + "=" + (value || "") + expires + "; path=/";
                }

                // Hàm xóa cookie
                function deleteCookie(name) {
                    document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
                }

                // Hàm lấy danh sách sản phẩm so sánh từ cookie
                function getCompareListFromCookie() {
                    let compareListCookie = getCookie(compareCookieName);
                    return compareListCookie ? JSON.parse(compareListCookie) : [];
                }

                // Hàm thêm sản phẩm vào so sánh (lưu vào cookie)
                function addProductToCompareCookie(productId) {
                    let compareListCookie = getCookie(compareCookieName);
                    let compareList = compareListCookie ? JSON.parse(compareListCookie) : [];

                    if (!compareList.includes(productId)) { // Kiểm tra sản phẩm đã có trong list chưa
                        compareList.push(productId); // Thêm sản phẩm vào list
                        setCookie(compareCookieName, JSON.stringify(compareList),
                            30); // Lưu lại vào cookie (JSON string, hết hạn sau 30 ngày)
                        updateCompareCountBadgeCookie(); // Cập nhật badge số lượng
                    }
                }

                // Hàm xóa sản phẩm khỏi so sánh (xóa khỏi cookie)
                function removeFromCompareCookie(
                    productId
                ) {
                    let compareListCookie = getCookie(compareCookieName);
                    let compareList = compareListCookie ? JSON.parse(compareListCookie) : [];
                    const index = compareList.indexOf(productId);
                    if (index > -1) {
                        compareList.splice(index, 1); // Xóa sản phẩm khỏi list
                        setCookie(compareCookieName, JSON.stringify(compareList), 30); // Lưu lại vào cookie
                        updateCompareCountBadgeCookie(); // Cập nhật badge số lượng
                        updateCompareButtonStatus(productId, false); // Cập nhật trạng thái nút (icon)
                    }
                }

                // Hàm cập nhật badge số lượng sản phẩm so sánh (dùng jQuery)
                function updateCompareCountBadgeCookie() {
                    const compareCount = getCompareListFromCookie().length; // Đếm số lượng từ cookie
                    $('.header-compare .badge-compare').text(compareCount); // Cập nhật text badge
                    if (compareCount > 0) {
                        $('.header-compare .badge-compare').show(); // Hiển thị badge nếu có sản phẩm
                    } else {
                        $('.header-compare .badge-compare').hide(); // Ẩn badge nếu không có sản phẩm
                    }
                }


                function updateCompareCount() {
                    updateCompareCountBadgeCookie(); // GỌI HÀM CẬP NHẬT BADGE DỰA TRÊN COOKIE TRỰC TIẾP
                }


                function updateCompareButtonStatus(productId, isCompared) {
                    var compareButton = $('.compare-toggle[data-product-id="' + productId + '"]');
                    if (compareButton.length) {
                        console.log(`[updateCompareButtonStatus] productId: ${productId}, isCompared: ${isCompared}`);
                        console.log(
                            `  Before update: data-state: ${compareButton.attr('data-state')}, icon-refresh visible: ${compareButton.find('.icon-refresh').is(':visible')}, icon-check visible: ${compareButton.find('.icon-check').is(':visible')}`
                        );
                        if (isCompared) {
                            compareButton.find('.icon-refresh').hide();
                            compareButton.find('.icon-check').show();
                            // **CHỈNH SỬA: DIRECT DOM MANIPULATION - SET data-state**
                            compareButton[0].dataset.state = 'selected'; // Sử dụng dataset để set data-state
                            console.log(`  **SET data-state to: selected (dataset)**`); // Log thay đổi
                        } else {
                            compareButton.find('.icon-check').hide();
                            compareButton.find('.icon-refresh').show();
                            // **CHỈNH SỬA: DIRECT DOM MANIPULATION - SET data-state**
                            compareButton[0].dataset.state = 'unselected'; // Sử dụng dataset để set data-state
                            console.log(`  **SET data-state to: unselected (dataset)**`); // Log thay đổi
                        }
                        feather.replace();
                        console.log(
                            `  After update: data-state: ${compareButton.attr('data-state')}, icon-refresh visible: ${compareButton.find('.icon-refresh').is(':visible')}, icon-check visible: ${compareButton.find('.icon-check').is(':visible')}`
                        );
                    }
                }


                function updateCompareButtonInitialStatus() { // cập nhật button ban đầu
                    const comparedProductIds = getCompareListFromCookie(); // **ĐỌC DANH SÁCH ID TỪ COOKIE**
                    comparedProductIds.forEach(function(productId) {
                        updateCompareButtonStatus(productId,
                            true); // khi load lại trang, CẬP NHẬT TRẠNG THÁI DỰA TRÊN COOKIE
                    });
                    updateCompareCount(); // CẬP NHẬT BADGE SỐ LƯỢNG DỰA TRÊN COOKIE
                }


                // $(document).ready(function() {

                updateCompareCount();
                updateCompareButtonInitialStatus();

                $('.compare-toggle').click(function(e) {
                    e.preventDefault();
                    var productId = $(this).data('product-id');
                    var productCategoryId = $(this).data('product-category-id');
                    var currentState = this.dataset.state;

                    console.log(
                        `[compare-toggle click] productId: ${productId}, productCategoryId: ${productCategoryId}, currentState: ${currentState}`
                    );

                    if (currentState === 'unselected') {
                        console.log(`  Action: Add product to compare`);
                        addProductToCompare(productId,
                            productCategoryId); // **ĐẢM BẢO DÒNG NÀY KHÔNG BỊ COMMENT VÀ GÕ ĐÚNG CHÍNH TẢ**
                    } else {
                        console.log(`  Action: Remove product from compare`);
                        removeFromCompareCookie(productId);
                        updateCompareCountBadgeCookie();
                        updateCompareButtonStatus(productId, false);
                    }
                }); //end compare-toggle

                feather.replace(); // load lại icon
                // });


                function addProductToCompare(productId, productCategoryId) { // GIỮ NGUYÊN tham số
                let compareListCookie = getCookie(compareCookieName);
                let compareList = compareListCookie ? JSON.parse(compareListCookie) : [];

                // Gửi AJAX request lên backend để kiểm tra và thêm sản phẩm (với check danh mục)
                $.ajax({
                    url: '/api/compare/add-with-check/' +
                        productId, // **ĐƯỜNG DẪN API MỚI - CÓ PRODUCT ID TRONG URL**
                    method: 'POST',
                    data: {
                        compareList: compareList // Gửi danh sách so sánh hiện tại từ cookie
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Backend cho phép thêm sản phẩm
                            addProductToCompareCookie(productId); // Thêm vào cookie
                            updateCompareCountBadgeCookie();
                            // **CHỈNH SỬA 2: BỌC updateCompareButtonStatus TRONG requestAnimationFrame (khi THÊM sản phẩm)**
                            requestAnimationFrame(() => { // **<-- THÊM requestAnimationFrame VÀO ĐÂY**
                                updateCompareButtonStatus(productId, true);
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Sản phẩm đã được thêm vào danh sách so sánh.',
                                showConfirmButton: true, // Ẩn nút "OK" mặc định
                                // timer: 1500 // Tự động đóng thông báo sau 1.5 giây (1500ms)
                            });
                        } else if (response.status === 'error') {
                            // Backend báo lỗi (ví dụ: không cùng danh mục)
                            alert(response.message); // Hiển thị thông báo lỗi cho người dùng
                            console.error('[addProductToCompare] Lỗi từ server:', response);
                        }
                    },
                    error: function(xhr, status, error) {
                        // **CALLBACK ERROR ĐÃ ĐƯỢC CHỈNH SỬA Ở CÁC BƯỚC TRƯỚC - GIỮ NGUYÊN**
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: xhr.responseJSON.message,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Lỗi khi thêm sản phẩm vào so sánh. Vui lòng thử lại sau.',
                            });
                        }
                        console.error('[addProductToCompare] Lỗi AJAX request:', error);
                    }
                });
            }
        });
            // wish list 
            $(document).on('click', '.wishlist-toggle', function(e) {
                    e.preventDefault();

                    @guest
                    // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
                    Swal.fire({
                        icon: 'warning',
                        title: 'Bạn chưa đăng nhập!',
                        text: 'Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích.',
                        showConfirmButton: true,
                        confirmButtonText: 'Đăng nhập',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/login'; // Điều hướng đến trang đăng nhập
                        }
                    });
                    return; // Dừng xử lý tiếp theo
                @endguest

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
                                text: data.message || 'Có lỗi xảy ra, vui lòng thử lại!',
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
    </script>
@endpush
