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
                                                <a href="">{{ $category->name }}</a>
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
                                <h3>Trending Products</h3>

                                <ul class="product-list border-0 p-0 d-block">

                                    @foreach ($trendingProducts as $trendingProduct)
                                        <li>
                                            <div class="offer-product">
                                                <a href="product-left-thumbnail.html" class="offer-image">
                                                    <img src="{{ Storage::url($trendingProduct->thumbnail) }}"
                                                        class="blur-up lazyload" alt="">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="product-left-thumbnail.html" class="text-title">
                                                            <h6 class="name">{{ $trendingProduct->name }}</h6>
                                                        </a>
                                                        <span>{{ $trendingProduct->views }}</span>
                                                        <h6 class="price theme-color">{{ $trendingProduct->price }}</h6>
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
                                                    <a href="product-left-thumbnail.html">
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
                                                    <a href="product-left-thumbnail.html">
                                                        <h6 class="name">{{ $topSell->product_names }}</h6>
                                                    </a>

                                                    <h5 class="sold text-content">
                                                        <span class="theme-color price">{{ $topSell->price }}</span>
                                                        <del>{{ $topSell->sale_price }}</del>
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

                                                        <h6 class="theme-color">
                                                            {{ $topSell->stock_quantity >= 1 ? 'In Stock' : 'Out of Stock' }}
                                                        </h6>
                                                    </div>

                                                    <div class="add-to-cart-box">
                                                        <button class="btn btn-add-cart addcart-button">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
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
                                <a href="shop-left-sidebar.html" class="category-box category-dark">
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
                                                    <a href="product-left-thumbnail.html">
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
                                                            <a href="wishlist.html" class="notifi-wishlist">
                                                                <i data-feather="heart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="product-detail">
                                                    <a href="product-left-thumbnail.html">
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
                                                        <button class="btn btn-add-cart addcart-button">Add
                                                            <span class="add-icon">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </span>
                                                        </button>
                                                        <div class="cart_qty qty-box">
                                                            <div class="input-group">
                                                                <button type="button" class="qty-left-minus"
                                                                    data-type="minus" data-field="">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                                <input class="form-control input-number qty-input"
                                                                    type="text" name="quantity" value="0">
                                                                <button type="button" class="qty-right-plus"
                                                                    data-type="plus" data-field="">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
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
                                                <a href="" class="offer-image">
                                                    <img src="{{ $product->thumbnail }}" class="blur-up lazyload"
                                                        alt="{{ $product->product_name }}">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="" class="text-title">
                                                            <h6 class="name">{{ $product->product_name }}</h6>
                                                        </a>
                                                        <span>{{ $product->total_sold }} đã bán</span>
                                                        <h6 class="price theme-color">
                                                            ${{ number_format($product->price, 2) }}</h6>
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
                                    <button onclick="location.href = 'cart.html';"
                                        class="btn btn-md add-cart-button icon">Add
                                        To Cart</button>
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
    <script>
        $(document).ready(function() {
            $('a[data-bs-target="#view"]').click(function() {
                var productId = $(this).data('id');

                $.ajax({
                    url: '/api/product/' + productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        $('#prdName').text(response.name);
                        $('#prdPrice').text(response.price);
                        $('#prdDescription').text(response.description);
                        $('#prdThumbnail').attr('src', response.thumbnail);
                        $('#prdBrand').text(response.brand);
                        $('#prdCategories').text(response.categories);

                        $('#productVariants').empty();

                        if (response.productVariants && response.productVariants.length > 0) {
                            let productVariantsData = {};

                            const allAttributes = {};

                            response.productVariants.forEach(variant => {
                                variant.attribute_values.forEach(attr => {
                                    if (!allAttributes[attr.attributes_name]) {
                                        allAttributes[attr
                                            .attributes_name] = [];
                                    }
                                    const existingValue = allAttributes[attr
                                        .attributes_name].find(v => v
                                        .attribute_value === attr
                                        .attribute_value);
                                    if (!existingValue) {
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

                            // LƯU TRỮ DỮ LIỆU BIẾN THỂ VÀ XỬ LÝ SỰ KIỆN CHANGE 
                            response.productVariants.forEach(productVariant => {
                                const variantId = generateVariantId(productVariant
                                    .attribute_values);
                                productVariantsData[variantId] = {
                                    price: productVariant.price,
                                    thumbnail: productVariant.thumbnail,
                                };


                            });

                            $('.attribute-select').change(function() {
                                const selectedVariantId = getCurrentVariantId();
                                console.log("Selected Variant ID:", selectedVariantId);

                                const selectedVariant = productVariantsData[
                                    selectedVariantId];
                                console.log("Selected Variant Data:", selectedVariant);

                                if (selectedVariant) {
                                    $('#prdPrice').text(selectedVariant.price);
                                    $('#prdThumbnail').attr('src', selectedVariant
                                        .thumbnail);
                                } else {
                                    $('#prdPrice').text(response.price);
                                    $('#prdThumbnail').attr('src', response.thumbnail);
                                }
                            });


                            function generateVariantId(attributes) {
                                if (!attributes || attributes.length === 0) return "default";
                                let id = "";
                                attributes.sort((a, b) => a.attributes_name.localeCompare(b
                                    .attributes_name));
                                attributes.forEach(attr => {
                                    id += attr.attributes_name + "-" + attr.id + "_";
                                });
                                return id.slice(0, -1);
                            }

                            function getCurrentVariantId() {
                                let currentVariant = {};
                                $('.attribute-select').each(function() {
                                    const attrName = $(this).attr('id');
                                    const selectedValueId = $(this).val();
                                    if (selectedValueId) {
                                        currentVariant[attrName] = selectedValueId;
                                    }
                                });
                                if (Object.keys(currentVariant).length === 0) return "default";
                                let id = "";
                                let arr = Object.keys(currentVariant).sort();
                                arr.forEach(key => {
                                    id += key + "-" + currentVariant[key] + "_";
                                });
                                return id.slice(0, -1);
                            }

                        } else {
                            $('#productVariants').html(
                                '<p>Sản phẩm này hiện không có biến thể.</p>');
                        }


                    },
                    error: function(xhr) {
                        alert('Không tìm thấy sản phẩm.');
                    }
                })
            })
        })
    </script>
@endpush
