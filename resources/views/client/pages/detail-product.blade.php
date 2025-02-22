@extends('client.layouts.master')
<style>
    .product-box-3 {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-detail {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-detail h5.name {
        min-height: 48px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }

    .product-box {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-detail {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-detail h6.name {
        min-height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }

    .product-image {
        position: relative;
        text-align: center;
    }

    .accessory-checkbox {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .option {
        padding: 8px 12px;
        border: 2px solid transparent;
        cursor: pointer;
        display: inline-block;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        border-radius: 5px;
        font-size: 14px;
    }

    .option.active {
        border-color: #0da487;
        background-color: #0da487;
        color: white;
    }
</style>
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Creamy Chocolate Cake</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">Creamy Chocolate Cake</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-11 col-xl-10 col-lg-9 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-sm-4 g-2">
                                    <div class="col-12">
                                        <div class="product-main no-arrow">
                                            <!-- Ảnh mặc định từ bảng products -->
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        data-zoom-image="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="Ảnh chính"
                                                        id="productImage">
                                                </div>
                                            </div>

                                            <!-- Ảnh từ productGallery -->
                                            @foreach ($detail->productGallery as $index => $gallery)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ asset('storage/' . $gallery->image) }}"
                                                            data-zoom-image="{{ asset('storage/' . $gallery->image) }}"
                                                            class="img-fluid image_zoom_cls-{{ $index + 1 }} blur-up lazyload"
                                                            alt="Ảnh phụ">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="left-slider-image left-slider no-arrow slick-top">
                                            <!-- Ảnh mặc định từ bảng products -->
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        class="img-fluid blur-up lazyload" alt="Ảnh chính">
                                                </div>
                                            </div>

                                            <!-- Ảnh từ productGallery -->
                                            @foreach ($detail->productGallery as $gallery)
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="{{ asset('storage/' . $gallery->image) }}"
                                                            class="img-fluid blur-up lazyload" alt="Ảnh phụ">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 wow fadeInUp">
                            @php
                                $pt = $detail->price - $detail->sale_price;
                                $sl = ($pt / $detail->price) * 100;
                            @endphp
                            <div class="right-box-contain">
                                {{-- <h6 class="offer-top">{{ Str::before($sl, '.') }}% off</h6> --}}
                                <h2 class="name">{{ $detail->name }}</h2>
                                <div class="price-rating">
                                    <h2 class="theme-color price" id="productPrice">
                                        {{ number_format($detail->sale_price, 0, ',', '.') }} ₫
                                        <br><del class="text-content">{{ number_format($detail->price, 0, ',', '.') }}
                                            ₫</del><span class="offer theme-color">({{ Str::before($sl, '.') }}%
                                            off)</span>

                                    </h2>
                                    
                                    <div class="product-rating custom-rate">
                                        <ul class="rating">

                                            <li>
                                                <span>{{ $detail->averageRating }}</span>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                        </ul>
                                        <span class="review">{{ $detail->totalReviews }} đánh giá</span>
                                    </div>
                                </div>

                                <div class="product-contain">
                                    <p class="w-100">{{ $detail->short_description }}</p>
                                </div>

                                <div class="product-package">
                                    <!-- Màu sắc -->
                                    <div class="product-title">
                                        <h4>Màu sắc</h4>
                                    </div>
                                    <ul class="color circle select-package" id="color-options">
                                        @php
                                            $displayedColors = [];
                                        @endphp
                                        @foreach ($detail->productVariants as $item)
                                            @foreach ($item->attributeValues as $attrValue)
                                                @if ($attrValue->attribute->name == 'Màu sắc' && !in_array($attrValue->value, $displayedColors))
                                                    @php
                                                        $displayedColors[] = $attrValue->value;
                                                    @endphp
                                                    <li>
                                                        <button type="button" class="option color-option"
                                                            data-value="{{ $attrValue->value }}">{{ $attrValue->value }}</button>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>

                                    <!-- Bộ nhớ RAM -->
                                    <div class="product-title">
                                        <h4>Bộ nhớ RAM</h4>
                                    </div>
                                    <ul class="circle select-package" id="memory-options">
                                        @php
                                            $displayedMemories = [];
                                        @endphp
                                        @foreach ($detail->productVariants as $item)
                                            @foreach ($item->attributeValues as $attrValue)
                                                @if ($attrValue->attribute->name == 'Bộ nhớ RAM' && !in_array($attrValue->value, $displayedMemories))
                                                    @php
                                                        $displayedMemories[] = $attrValue->value;
                                                    @endphp
                                                    <li>
                                                        <button type="button" class="option memory-option"
                                                            data-value="{{ $attrValue->value }}">{{ $attrValue->value }}</button>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>

                                    <br>
                                    <span>Số lượng tồn kho : {{ $detail->productStock->stock }}</span>
                                </div>


                                <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" id="clockdiv-1"
                                    data-hours="1" data-minutes="2" data-seconds="3">
                                    <div class="product-title">
                                        <h4>Hurry up! Sales Ends In</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="days d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Days</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="hours d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Hours</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="minutes d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Min</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="seconds d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Sec</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>



                                <div class="note-box product-package">
                                    <div class="cart_qty qty-box product-qty">
                                        <div class="input-group">
                                            <button type="button" class="qty-left-minus" data-type="minus" data-field="">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                name="quantity" value="1">
                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button onclick="location.href = 'cart.html';"
                                        class="btn btn-md bg-dark cart-button text-white w-100">Add To Cart</button>
                                </div>

                                <div class="buy-box">
                                    <a href="wishlist.html">
                                        <i data-feather="heart"></i>
                                        <span>Add To Wishlist</span>
                                    </a>

                                    <a href="compare.html">
                                        <i data-feather="shuffle"></i>
                                        <span>Add To Compare</span>
                                    </a>
                                </div>

                                <div class="payment-option">
                                    <div class="product-title">
                                        <h4>Guaranteed Safe Checkout</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastka{{ asset('theme/client/assets/images/product/payment/1.svg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastka{{ asset('theme/client/assets/images/product/payment/2.svg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastka{{ asset('theme/client/assets/images/product/payment/3.svg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastka{{ asset('theme/client/assets/images/product/payment/4.svg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="https://themes.pixelstrap.com/fastka{{ asset('theme/client/assets/images/product/payment/5.svg') }}"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    <!-- Related Product Section Start -->
    @if ($detail->productAccessories->isNotEmpty())
        <section class="related-product-2">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="related-product">
                            <div class="product-title-2">
                                <h4>Sản phẩm & Phụ kiện đi kèm</h4>
                            </div>
                            <div class="related-box">
                                <div class="related-image">
                                    <ul>
                                        <li>
                                            <div class="product-box product-box-bg wow fadeInUp">
                                                <div class="product-image">
                                                    <a href="#">
                                                        <img src="{{ asset('storage/' . $detail->thumbnail) }}"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                </div>
                                                <div class="product-detail">
                                                    <a href="#">
                                                        <h6 class="name">{{ $detail->name }}</h6>
                                                    </a>

                                                    <h5 class="sold text-content">
                                                        <span
                                                            class="theme-color price">{{ number_format($detail->sale_price, 0, ',', '.') }}
                                                            ₫</span>
                                                        <del>{{ number_format($detail->price, 0, ',', '.') }} ₫</del>
                                                    </h5>
                                                </div>
                                            </div>
                                        </li>
                                        @foreach ($detail->productAccessories as $dk)
                                            <li>
                                                <div class="product-box product-box-bg wow fadeInUp">
                                                    <div class="product-image">
                                                        <input type="checkbox" class="accessory-checkbox"
                                                            data-price="{{ $dk->sale_price }}">
                                                        <a href="#">
                                                            <img src="{{ asset('storage/' . $dk->thumbnail) }}"
                                                                class="img-fluid blur-up lazyload" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="product-detail">
                                                        <a href="#">
                                                            <h6 class="name">{{ $dk->name }}</h6>
                                                        </a>

                                                        <h5 class="sold text-content">
                                                            <span
                                                                class="theme-color price">{{ number_format($dk->sale_price, 0, ',', '.') }}
                                                                ₫</span>
                                                            <del>{{ number_format($dk->price, 0, ',', '.') }} ₫</del>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="bundle-list">
                                    <ul>
                                        <li class="content">
                                            <h5>Tổng tiền:</h5>
                                            <h4 class="theme-color">
                                                <span id="total-price">0</span> ₫
                                            </h4>
                                            <button class="btn text-white theme-bg-color btn-md mt-sm-4 mt-3 fw-bold">
                                                <i class="fa-solid fa-cart-shopping me-2"></i> Thêm vào giỏ hàng
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Related Product Section End -->

    <!-- Nav Tab Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="product-section-box">
                        <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab">Mô tả</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                    type="button" role="tab">Thông số kĩ thuật</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                    type="button" role="tab">Đánh giá sản phẩm</button>
                            </li>
                        </ul>

                        <div class="tab-content custom-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel">
                                <div class="product-description">
                                    <div class="nav-desh">
                                        <p>{{ $detail->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="info" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table info-table">
                                        <tbody>
                                            @php
                                                $groupedAttributes = $detail->attributeValues->groupBy(
                                                    'attribute.name',
                                                );
                                            @endphp

                                            @foreach ($groupedAttributes as $attributeName => $values)
                                                <tr>
                                                    <td>{{ $attributeName }}</td>
                                                    <td>
                                                        {{ $values->pluck('value')->join(', ') }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            {{-- <tr>
                                                <td>Ingredient Type</td>
                                                <td>Vegetarian</td>
                                            </tr>
                                            <tr>
                                                <td>Brand</td>
                                                <td>Lavian Exotique</td>
                                            </tr>
                                            <tr>
                                                <td>Form</td>
                                                <td>Bar Brownie</td>
                                            </tr>
                                            <tr>
                                                <td>Package Information</td>
                                                <td>Box</td>
                                            </tr>
                                            <tr>
                                                <td>Manufacturer</td>
                                                <td>Prayagh Nutri Product Pvt Ltd</td>
                                            </tr>
                                            <tr>
                                                <td>Item part number</td>
                                                <td>LE 014 - 20pcs Crème Bakes (Pack of 2)</td>
                                            </tr>
                                            <tr>
                                                <td>Net Quantity</td>
                                                <td>40.00 count</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="review" role="tabpanel">
                                <div class="review-box">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <div class="product-rating-box">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="product-main-rating">
                                                            <h2>3.40
                                                                <i data-feather="star"></i>
                                                            </h2>

                                                            <h5>5 Overall Rating</h5>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <ul class="product-rating-list">
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>5<i data-feather="star"></i></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: 40%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">2</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>4<i data-feather="star"></i></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: 20%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">1</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>3<i data-feather="star"></i></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: 0%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">0</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>2<i data-feather="star"></i></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: 20%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">1</h5>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <h5>1<i data-feather="star"></i></h5>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" style="width: 20%;">
                                                                        </div>
                                                                    </div>
                                                                    <h5 class="total">1</h5>
                                                                </div>
                                                            </li>

                                                        </ul>

                                                        <div class="review-title-2">
                                                            <h4 class="fw-bold">Review this product</h4>
                                                            <p>Let other customers know what you think</p>
                                                            <button class="btn" type="button"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#writereview">Write a
                                                                review</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-7">
                                            <div class="review-people">
                                                <ul class="review-list">
                                                    @foreach ($detail->reviews as $item)
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    @if ($item->user->avatar == null)
                                                                        <div class="people-image people-text">
                                                                            <h3 class="text-center rounded-circle bg-white d-inline-flex align-items-center justify-content-center"
                                                                                style="width: 70px; height: 70px;">
                                                                                {{ strtoupper(substr($item->user->fullname, 0, 1)) }}
                                                                            </h3>

                                                                        </div>
                                                                    @else
                                                                        <div class="people-image people-text">
                                                                            <img alt="user" class="img-fluid "
                                                                                src="{{ asset('storage/' . $item->user->avatar) }}">
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a href="javascript:void(0)"
                                                                            class="name">{{ $item->user->fullname }}</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content">
                                                                                {{ $item->created_at }}
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                                        <li>
                                                                                            <i data-feather="star"
                                                                                                class="{{ $i <= $item->rating ? 'fill' : '' }}"></i>
                                                                                        </li>
                                                                                    @endfor
                                                                                </ul>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>{{ $item->review_text }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach


                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Nav Tab Section End -->

    <!-- Related Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Sản phẩm tương tự</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('theme/client/assets/svg/leaf.svg') }}#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-6_1 product-wrapper">
                        @foreach ($detail->related_products as $related)
                            <div>
                                <div class="product-box-3 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="#">
                                                <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="{{ $related->name }}">
                                            </a>

                                            <ul class="product-option">
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                data-bs-target="#view" data-id={{ $related->id }}>
                                                <i data-feather="eye"></i>
                                            </a>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                                    <a href="compare.html">
                                                        <i data-feather="refresh-cw"></i>
                                                    </a>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                    <a href="wishlist.html" class="notifi-wishlist">
                                                        <i data-feather="heart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">{{ $related->brand->name }}</span>
                                            <a href="#">
                                                <h5 class="name">{{ $related->name }}</h5>
                                            </a>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li>
                                                            <i data-feather="star"
                                                                class="{{ $i <= round($related->reviews_avg_rating) ? 'fill' : '' }}"></i>
                                                        </li>
                                                    @endfor
                                                </ul>
                                                <span>({{ number_format($related->reviews_avg_rating, 1) }})</span>
                                            </div>
                                            <h5 class="price">
                                                <span
                                                    class="theme-color">{{ number_format($related->sale_price ?: $related->price, 0, ',', '.') }}
                                                    ₫</span>
                                                @if ($related->sale_price)
                                                    <del>{{ number_format($related->price, 0, ',', '.') }} ₫</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <button class="btn btn-add-cart addcart-button">Thêm vào giỏ
                                                    <span class="add-icon bg-light-gray">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </span>
                                                </button>
                                                <div class="cart_qty qty-box">
                                                    <div class="input-group bg-white">
                                                        {{-- <button type="button" class="qty-left-minus bg-gray"
                                                            data-type="minus" data-field="">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input class="form-control input-number qty-input" type="text"
                                                            name="quantity" value="0">
                                                        <button type="button" class="qty-right-plus bg-gray"
                                                            data-type="plus" data-field="">
                                                            <i class="fa fa-plus"></i>
                                                        </button> --}}
                                                    </div>
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

        <div class="modal fade theme-modal question-modal" id="writereview" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Write a review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <form class="product-review-form">
                            <div class="product-wrapper">
                                <div class="product-image">
                                    <img class="img-fluid" alt="Solid Collared Tshirts"
                                        src="../assets/images/fashion/product/26.jpg">
                                </div>
                                <div class="product-content">
                                    <h5 class="name">Solid Collared Tshirts</h5>
                                    <div class="product-review-rating">
                                        <div class="product-rating">
                                            <h6 class="price-number">$16.00</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review-box">
                                <div class="product-review-rating">
                                    <label>Rating</label>
                                    <div class="product-rating">
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
                                    </div>
                                </div>
                            </div>
                            <div class="review-box">
                                <label for="content" class="form-label">Your Question *</label>
                                <textarea id="content" rows="3" class="form-control" placeholder="Your Question"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-theme-outline fw-bold"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-md fw-bold text-light theme-bg-color">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Product Section End -->
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
                                    {{-- <span class="ms-2">8 Reviews</span>
                                    <span class="ms-2 text-danger">6 sold in last 16 hours</span> --}}
                                </div>

                                <div class="product-stock">
                                    <span> </span>
                                </div>

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
                                                <option value="15inch">15 inch</option>
                                                <option value="17inch">17 inch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div id="productVariants">

                                </div>

                                <div class="modal-button">
                                    <button type="button" class="btn btn-md add-cart-button icon">Thêm vào giỏ
                                        hàng</button>
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
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".accessory-checkbox");
            const totalPriceEl = document.getElementById("total-price");
            const addToCartBtn = document.getElementById("add-to-cart");
            const mainProductPrice = parseFloat("{{ $detail->sale_price }}"); // Giá sản phẩm chính
            let totalPrice = mainProductPrice;

            // Hiển thị giá ban đầu
            totalPriceEl.textContent = totalPrice.toLocaleString("vi-VN") + " ₫";

            // Kiểm tra có checkbox nào được chọn không
            function updateButtonState() {
                let anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                addToCartBtn.disabled = !anyChecked; // Vô hiệu hóa nếu không có phụ kiện nào được chọn
            }

            // Xử lý sự kiện khi chọn checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let price = parseFloat(this.dataset.price);

                    if (this.checked) {
                        totalPrice += price;
                    } else {
                        totalPrice -= price;
                    }

                    totalPriceEl.textContent = totalPrice.toLocaleString("vi-VN") + " ₫";
                    updateButtonState();
                });
            });

            // Gọi lần đầu để kiểm tra trạng thái ban đầu của nút
            updateButtonState();
        });

        /////


        // Hàm định dạng giá tiền sang VNĐ
        function formatPrice(price) {
            const number = parseFloat(price) // Chuyển đổi giá sang số thực
            return isNaN(number) ? "0 đ" : number.toLocaleString('vi-VN', { // Định dạng số sang VNĐ
                style: 'currency',
                currency: 'VND'
            })
        }

        $(document).ready(function() {

            // Khai báo biến toàn cục để lưu trữ variantMap
            let globalVariantMap = {};

            $('a[data-bs-target="#view"]').click(function() { // Bắt sự kiện  mở modal
                const productId = $(this).data('id') // Lấy product ID từ thuộc tính `data-id` của thẻ `<a>`


                $('#view').data('product-id', productId); // Lưu product_id vào data của modal #view
                // loadProductDetails(productId);


                $.ajax({
                    url: '/api/products/' +
                        productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(
                        response
                    ) {
                        // Cập nhật thông tin cơ bản của sản phẩm trong modal
                        $('#prdName').text(response.name)
                        $('#prdDescription').text(response.description)
                        $('#prdBrand').text(response.brand)
                        $('#prdCategories').text(response.categories)

                        // Xử lý rating (start)
                        const avgRating = response.avgRating ||
                            0
                        $('#prdRating ul.rating').html(
                            Array.from({
                                    length: 5
                                }, (_, i) => // Tạo mảng 5 phần tử để lặp qua 5 ngôi sao
                                `<li><i data-feather="star" class="${i < avgRating ? 'fill' : ''}"></i></li>` // Tạo thẻ <li> chứa icon star, 
                            ).join('') // Chuyển mảng thành chuỗi HTML
                        )
                        feather
                            .replace() // loai lại idcon start


                        // Xử lý biến thể sản phẩm (Product Variants)
                        const variants = response.productVariants ||
                        [] // Lấy mảng biến thể, mặc định là mảng rỗng nếu không có

                        $('#productVariants')
                            .empty() // Xóa nội dung hiện tại (để chuẩn bị hiển thị biến thể mới)

                        if (variants.length > 0) { // Kiểm tra nếu sản phẩm có biến thể

                            // Cập nhật globalVariantMap
                            variants.forEach(variant => {
                                const key = variant.attribute_values
                                    .map(attr => attr.id)
                                    .sort((a, b) => a - b)
                                    .join('-');

                                globalVariantMap[key] = {
                                    variant_id: variant.id,
                                    price: variant.price,
                                    thumbnail: variant.thumbnail,
                                    product_stock: variant.product_stock
                                };
                            });
                            console.log("Global Variant Map updated:", globalVariantMap);

                            // Tạo map attribute và options (loại bỏ trùng lặp giá trị thuộc tính)
                            const
                                attributes = {} //  tạo object để lưu trữ thông tin thuộc tính và giá trị

                            variants.forEach(variant => {
                                variant.attribute_values.forEach(
                                    attr => { // Lặp qua từng giá trị thuộc tính của biến thể

                                        const attrSlug = attr
                                            .attributes_slug // Định dạng tên thuộc tính  -> slug)

                                        if (!attributes[
                                                attrSlug
                                                ]) { // Nếu thuộc tính này chưa có trong object `attributes`
                                            attributes[attrSlug] =
                                                new Map() // Tạo Map mới để lưu trữ giá trị thuộc tính (sử dụng Map để loại bỏ giá trị trùng lặp)
                                        }
                                        attributes[attrSlug].set(attr.id, attr
                                            .attribute_value
                                        ) // Thêm giá trị thuộc tính vào Map, key là ID, value là tên giá trị
                                    })
                            })

                            // Tạo HTML cho các select dropdown chọn thuộc tính biến thể
                            let attributesHtml = ''
                            Object.entries(attributes).forEach(([attrSlug, valuesMap]) => {
                                // Để có giá trị đến attr.attributes_name,  cần  lấy lại thông tin attribute tương ứng với slug.
                                // Tìm một attribute_value bất kỳ trong valuesMap có slug này và lấy attributes_name từ đó.
                                let sampleAttrValue;
                                for (const [id, value] of valuesMap.entries()) {
                                    sampleAttrValue = variants.reduce((found,
                                        variant) => {
                                        if (found)
                                            return found; // Nếu đã tìm thấy, không cần tìm tiếp
                                        return variant.attribute_values.find(
                                            av => av.attributes_slug ===
                                            attrSlug);
                                    }, null);
                                    if (sampleAttrValue)
                                        break; // Tìm thấy một attribute_value, dừng vòng lặp
                                }

                                // hiện thị select option
                                attributesHtml += `
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>${sampleAttrValue ? sampleAttrValue.attributes_name : attrSlug.split('-').join(' ')}</label>
                                            <select class="form-control variant-attribute"
                                                data-attribute="${attrSlug}">
                                                ${Array.from(valuesMap).map(([id, value]) =>
                                                    `<option value="${id}">${value}</option>`
                                                ).join('')}
                                            </select>
                                        </div>
                                    </div>
                                `;
                            });
                            $('#productVariants').html(
                                `<div class="row">${attributesHtml}</div>`)


                            // Tạo variant map (Map ánh xạ giữa combination thuộc tính và thông tin biến thể) - QUAN TRỌNG
                            const variantMap = {} // Khởi tạo object để lưu trữ map biến thể
                            variants.forEach(variant => { // Lặp qua từng biến thể

                                const key = variant
                                    .attribute_values // Tạo key cho variantMap dựa trên ID của các giá trị thuộc tính
                                    .map(attr => attr
                                        .id) // Lấy mảng ID giá trị thuộc tính
                                    .sort((a, b) => a -
                                        b
                                        ) // Sắp xếp ID để đảm bảo key nhất quán (ví dụ: luôn theo thứ tự tăng dần)
                                    .join(
                                        '-'
                                        ); // Nối các ID bằng dấu '-' để tạo key duy nhất (ví dụ: "1-35")
                                console.log("Variant Key:", key, " - Variant:",
                                    variant); // Log key và variant

                                variantMap[
                                    key
                                    ] = { // Lưu thông tin biến thể vào variantMap, key là chuỗi ID thuộc tính
                                    price: variant.price, // Giá biến thể
                                    thumbnail: variant
                                        .thumbnail, // Thumbnail biến thể
                                    product_stock: variant
                                        .product_stock // Thông tin stock của biến thể
                                }

                            })
                            console.log("Variant Map:",
                                variantMap); // Log toàn bộ variantMap sau khi tạo

                            // Tìm và hiển thị biến thể có giá thấp nhất làm mặc định
                            const lowestVariant = variants.reduce((prev,
                                    curr
                                    ) => // Sử dụng reduce để tìm biến thể có giá thấp nhất
                                parseFloat(prev.price) < parseFloat(curr.price) ? prev :
                                curr // So sánh giá và trả về biến thể có giá thấp hơn
                            )
                            // cập nhật thông tin theo biến thể giá min
                            updateProductInfo(lowestVariant) // Cập nhật giá và thumbnail 
                            setSelectedAttributes(lowestVariant.attribute_values) // selected
                            updateStockInfo(lowestVariant) // kho

                            // Xử lý sự kiện thay đổi select dropdown thuộc tính biến thể
                            $('.variant-attribute').change(
                                function() { // Bắt sự kiện `change` trên các select dropdown `.variant-attribute`
                                    const selectedValues =
                                        getSelectedAttributes() // Lấy ID của các giá trị thuộc tính đã chọn từ dropdown

                                    const variantKey = selectedValues.sort((a, b) => a - b)
                                        .join(
                                            '-'
                                            ) // Tạo key tương ứng với combination thuộc tính đã chọn

                                    const variant = variantMap[
                                            variantKey
                                            ] // Tìm biến thể tương ứng trong variantMap

                                    // console.log("Variant object khi thay đổi thuộc tính:",variant); // Log object variant vào console để debug
                                    console.log("Selected Values:",
                                        selectedValues); // Log mảng ID thuộc tính đã chọn
                                    console.log("Variant Key (change event):",
                                        variantKey
                                        ); // Log variantKey tạo trong sự kiện change
                                    console.log("Variant object khi thay đổi thuộc tính:",
                                        variant); // Log variant tìm được từ variantMap


                                    if (variant) { // Nếu tìm thấy biến thể tương ứng với combination thuộc tính đã chọn
                                        updateProductInfo(variant)
                                        updateStockInfo(variant);
                                    } else {
                                        $('#prdPrice').text(formatPrice(response.price ||
                                            0))
                                        $('#prdThumbnail').attr('src', response.thumbnail)
                                        $('.product-stock span').text(
                                            `Kho: 0`
                                            ); // Cập nhật stock thành "Kho: 0" (hoặc giá trị mặc định khác)
                                    }
                                })

                        } else { // Trường hợp sản phẩm không có biến thể
                            $('#productVariants').html('<p>Sản phẩm này không có biến thể</p>')
                            $('#prdPrice').text(formatPrice(response.price || 0))
                            $('#prdThumbnail').attr('src', response.thumbnail)
                            $('.product-stock span').text(`Kho: 0`);
                        }
                    },
                    error: () => alert(
                        'Không tìm thấy sản phẩm'
                    )
                })
            })

            // Hàm cập nhật giá và thumbnail sản phẩm trong modal

            function updateProductInfo(variant) {
                $('#prdPrice').text(formatPrice(variant.price))
                $('#prdThumbnail').attr('src', variant.thumbnail)
            }

            // Hàm chọn giá trị thuộc tính trong dropdown (dựa trên biến thể được chọn)
            function setSelectedAttributes(attributes) {
                attributes.forEach(attr => { // Lặp qua mảng giá trị thuộc tính của biến thể
                    const attrSlug = attr.attributes_slug // Định dạng tên thuộc tính
                    $(`select[data-attribute="${attrSlug}"]`).val(attr
                        .id
                    ) // Chọn option trong select dropdown có `data-attribute` tương ứng và `value` là ID giá trị thuộc tính
                })
            }

            // Hàm lấy ID của các giá trị thuộc tính đã được chọn từ dropdown
            function getSelectedAttributes() {
                const selected = [] // Khởi tạo mảng rỗng để lưu ID giá trị đã chọn
                $('.variant-attribute').each(function() { // Lặp qua từng select dropdown `.variant-attribute`
                    const val = $(this).val() // Lấy value (ID giá trị thuộc tính) của select dropdown
                    if (val) selected.push(
                        val) // Nếu có value (không phải option mặc định), thêm vào mảng `selected`
                })
                return selected // Trả về mảng ID giá trị thuộc tính đã chọn
            }
            // Hàm cập nhật thông tin stock sản phẩm trong modal
            function updateStockInfo(variant) { //  HÀM  ĐỂ CẬP NHẬT STOCK
                const stock = variant.product_stock ? variant.product_stock.stock :
                    0; // Lấy stock từ variant.product_stock
                $('.product-stock span').text(
                    `Kho: ${stock}`);
            }

            // add to cart

            $('.add-cart-button').click(function() {
                // Lấy product_id từ modal
                const productId = $('#view').data('product-id');

                // Kiểm tra xem sản phẩm có biến thể hay không
                const hasVariants = $('#productVariants .variant-attribute').length > 0;

                let cartData;

                if (hasVariants) {
                    // Xử lý sản phẩm có biến thể
                    const selectedValues = getSelectedAttributes();
                    const variantKey = selectedValues.sort((a, b) => a - b).join('-');
                    const selectedVariant = globalVariantMap[variantKey];

                    if (!selectedVariant) {
                        alert('Vui lòng chọn đầy đủ thuộc tính sản phẩm');
                        return;
                    }

                    // Lấy thông tin chi tiết về các biến thể đã chọn
                    const variantDetails = [];
                    $('.variant-attribute').each(function() {
                        const $select = $(this);
                        const attributeSlug = $select.data('attribute');
                        const attributeName = $select.prev('label').text();
                        const attributeValue = $select.find('option:selected').text();

                        variantDetails.push({
                            attribute_name: attributeName,
                            attribute_value: attributeValue
                        });
                    });

                    cartData = {
                        product_id: productId,
                        product_variant_id: selectedVariant.variant_id,
                        quantity: 1,
                        variant_info: {
                            price: selectedVariant.price,
                            thumbnail: selectedVariant.thumbnail,
                            details: variantDetails
                        }
                    };
                } else {
                    // Xử lý sản phẩm không có biến thể
                    cartData = {
                        product_id: productId,
                        quantity: 1,
                        variant_info: {
                            price: $('#prdPrice').text().replace(/[^\d]/g,
                                ''), // Loại bỏ ký tự không phải số
                            thumbnail: $('#prdThumbnail').attr('src')
                        }
                    };
                }
                // Log dữ liệu để kiểm tra
                console.log('Cart Data:', cartData);

               
            });
        })

        //////
        // console.log(productVariants);

        document.addEventListener("DOMContentLoaded", function () {
    let productVariants = JSON.parse(document.getElementById("productVariantsData").textContent);

    console.log("🛠 Danh sách biến thể:", productVariants);

    let selectedColor = null;
    let selectedMemory = null;
    let defaultSalePrice = "{{ $detail->sale_price !== null ? number_format($detail->sale_price, 0, ',', '.') : 'null' }}";
    let defaultPrice = "{{ number_format($detail->price, 0, ',', '.') }}";
    let discountPercent = "{{ Str::before($sl, '.') }}"; // Phần trăm giảm giá
    let defaultImage = "{{ asset('storage/' . $detail->thumbnail) }}";

    let productImageElement = document.getElementById("productImage");
    let priceElement = document.getElementById("productPrice");

    function selectDefaultVariant() {
        if (productVariants.length > 0) {
            let firstVariant = productVariants[0];

            selectedColor = firstVariant.attribute_values.find(attr => attr.name === "Màu sắc")?.value || null;
            selectedMemory = firstVariant.attribute_values.find(attr => attr.name === "Dung lượng")?.value || null;

            console.log("✅ Biến thể mặc định:", firstVariant);
            console.log("🎨 Màu mặc định:", selectedColor);
            console.log("💾 Dung lượng mặc định:", selectedMemory);

            updateImage();
            updatePrice();

            if (selectedColor) {
                let colorBtn = document.querySelector(`.color-option[data-value="${selectedColor}"]`);
                if (colorBtn) colorBtn.classList.add("active");
            }

            if (selectedMemory) {
                let memoryBtn = document.querySelector(`.memory-option[data-value="${selectedMemory}"]`);
                if (memoryBtn) memoryBtn.classList.add("active");
            }
        }
    }

    document.querySelectorAll(".color-option").forEach(colorBtn => {
        colorBtn.addEventListener("click", function () {
            document.querySelectorAll(".color-option").forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            selectedColor = this.getAttribute("data-value")?.trim();
            console.log("🔴 Màu sắc đã chọn:", selectedColor || "⚠️ Không lấy được giá trị");

            updateImage();
            updatePrice();
        });
    });

    document.querySelectorAll(".memory-option").forEach(memoryBtn => {
        memoryBtn.addEventListener("click", function () {
            document.querySelectorAll(".memory-option").forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            selectedMemory = this.getAttribute("data-value")?.trim();
            console.log("🔵 Dung lượng đã chọn:", selectedMemory || "⚠️ Không lấy được giá trị");

            updatePrice();
        });
    });

    function updatePrice() {
        let selectedVariant = productVariants.find(variant => {
            let hasColor = selectedColor ? variant.attribute_values?.some(attr => attr?.value?.trim() === selectedColor) : true;
            let hasMemory = selectedMemory ? variant.attribute_values?.some(attr => attr?.value?.trim() === selectedMemory) : true;
            return hasColor && hasMemory;
        });

        if (selectedVariant) {
            console.log("✅ Biến thể được chọn:", selectedVariant);

            let salePrice = selectedVariant.sale_price !== null ? formatPrice(selectedVariant.sale_price) : null;
            let originalPrice = formatPrice(selectedVariant.price);
            let discount = salePrice ? calculateDiscount(selectedVariant.price, selectedVariant.sale_price) : null;

            if (salePrice) {
                priceElement.innerHTML = `
                    ${salePrice} ₫
                    <br><del class="text-content">${originalPrice} ₫</del>
                    <span class="offer theme-color">(${discount}% off)</span>
                `;
            } else {
                priceElement.innerHTML = `${originalPrice} ₫`;
            }
        } else {
            console.log("⚠️ Không tìm thấy biến thể phù hợp.");
            updatePriceWithoutVariant();
        }
    }

    function updatePriceWithoutVariant() {
        let filteredVariants = productVariants.filter(variant => {
            let hasColor = selectedColor ? variant.attribute_values.some(attr => attr.value.trim() === selectedColor) : false;
            let hasMemory = selectedMemory ? variant.attribute_values.some(attr => attr.value.trim() === selectedMemory) : false;
            return hasColor || hasMemory;
        });

        if (filteredVariants.length > 0) {
            let maxPriceVariant = filteredVariants.reduce((max, variant) => {
                let price = parseFloat(variant.sale_price ?? variant.price);
                return price > parseFloat(max.sale_price ?? max.price) ? variant : max;
            }, filteredVariants[0]);

            let salePrice = maxPriceVariant.sale_price !== null ? formatPrice(maxPriceVariant.sale_price) : null;
            let originalPrice = formatPrice(maxPriceVariant.price);
            let discount = salePrice ? calculateDiscount(maxPriceVariant.price, maxPriceVariant.sale_price) : null;

            if (salePrice) {
                priceElement.innerHTML = `
                    ${salePrice} ₫
                    <br><del class="text-content">${originalPrice} ₫</del>
                    <span class="offer theme-color">(${discount}% off)</span>
                `;
            } else {
                priceElement.innerHTML = `${originalPrice} ₫`;
            }
        } else {
            if (defaultSalePrice !== "null") {
                priceElement.innerHTML = `
                    ${defaultSalePrice} ₫
                    <br><del class="text-content">${defaultPrice} ₫</del>
                    <span class="offer theme-color">(${discountPercent}% off)</span>
                `;
            } else {
                priceElement.innerHTML = `${defaultPrice} ₫`;
            }
        }
    }

    function updateImage() {
        let selectedVariant = productVariants.find(variant =>
            variant.attribute_values.some(attr => attr.value.trim() === selectedColor)
        );

        if (selectedVariant && selectedVariant.thumbnail) {
            productImageElement.src = "{{ asset('storage/') }}/" + selectedVariant.thumbnail;
            console.log("🖼 Ảnh hiển thị:", selectedVariant.thumbnail);
        } else {
            productImageElement.src = defaultImage;
            console.log("🖼 Hiển thị ảnh mặc định");
        }
    }

    function formatPrice(price) {
        return new Intl.NumberFormat("vi-VN").format(price);
    }

    function calculateDiscount(original, sale) {
        let discount = ((original - sale) / original) * 100;
        return Math.round(discount);
    }

    // Chạy khi trang load để chọn biến thể đầu tiên
    selectDefaultVariant();
});

    </script>
    <!-- JSON chứa danh sách biến thể sản phẩm -->
    <script type="application/json" id="productVariantsData">
    {!! json_encode($detail->productVariants) !!}
</script>
    <!-- sidebar open js -->
    <script src="{{ asset('theme/client/assets/js/filter-sidebar.js') }}"></script>

    <!-- Zoom Js -->
    <script src="{{ asset('theme/client/assets/js/jquery.elevatezoom.js') }}"></script>
    <script src="{{ asset('theme/client/assets/js/zoom-filter.js') }}"></script>

    <!-- Sticky-bar js -->
    <script src="{{ asset('theme/client/assets/js/sticky-cart-bottom.js') }}"></script>
@endpush
