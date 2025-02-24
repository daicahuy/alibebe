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
                                            <div id="main-image-container">
                                                <div class="slider-image">
                                                    <img src="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        data-zoom-image="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="Ảnh chính"
                                                        id="productImage">
                                                </div>
                                            </div>

                                            @foreach ($detail->productGallery as $index => $gallery)
                                                <div class="gallery-image" data-index="{{ $index }}">
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
                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{ asset('storage/' . $detail->thumbnail) }}"
                                                        class="img-fluid blur-up lazyload" alt="Ảnh chính">
                                                </div>
                                            </div>

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

                            <div class="right-box-contain">
                                <h2 class="name">{{ $detail->name }}</h2>
                                <div class="price-rating">
                                    <h2 class="theme-color price" id="productPrice">
                                        @if ($detail->sale_price !== null)
                                            {{ number_format($detail->sale_price, 0, ',', '.') }} ₫
                                            <br><del class="text-content">{{ number_format($detail->price, 0, ',', '.') }}
                                                ₫</del>
                                            {{-- <span class="offer theme-color">({{ Str::before($sl, '.') }}% off)</span> --}}
                                        @else
                                            {{ number_format($detail->price, 0, ',', '.') }} ₫
                                        @endif
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
                                    @if (isset($detail->attributes['Màu sắc']))
                                        <div class="product-title">
                                            <h4>Màu sắc</h4>
                                        </div>
                                        <ul class="color circle select-package" id="color-options">
                                            @foreach ($detail->attributes['Màu sắc'] as $index => $attrValue)
                                                <li>
                                                    <button type="button"
                                                        class="option color-option {{ $index === 0 ? 'active' : '' }}"
                                                        data-value="{{ $attrValue->value }}">{{ $attrValue->value }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if (isset($detail->attributes['Bộ nhớ RAM']))
                                        <div class="product-title">
                                            <h4>Bộ nhớ RAM</h4>
                                        </div>
                                        <ul class="circle select-package" id="memory-options">
                                            @foreach ($detail->attributes['Bộ nhớ RAM'] as $index => $attrValue)
                                                <li>
                                                    <button type="button"
                                                        class="option memory-option {{ $index === 0 ? 'active' : '' }}"
                                                        data-value="{{ $attrValue->value }}">{{ $attrValue->value }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <br>
                                    <span id="productStock">{{ $detail->productStock->stock }}</span>
                                </div>


                                <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" id="clockdiv-1"
                                    data-hours="1" data-minutes="2" data-seconds="3">
                                    <div class="product-title">
                                        <h4>Nhanh lên! Khuyến mại kết thúc vào</h4>
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
                                        {{-- <li>
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
                                        </li> --}}
                                        @foreach ($detail->productAccessories as $dk)
                                            <li>
                                                <div class="product-box product-box-bg wow fadeInUp">
                                                    <div class="product-image">
                                                        <input type="checkbox" class="accessory-checkbox"
                                                            data-price="{{ $dk->sale_price }}">
                                                        <img src="{{ asset('storage/' . $dk->thumbnail) }}"
                                                            class="img-fluid blur-up lazyload" alt="">
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

                                {{-- <div class="bundle-list">
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
                                </div> --}}
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
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#comments" type="button"
                                    role="tab">Bình luận</button>
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
                                                            <h2>{{ $detail->averageRating }}
                                                                <i data-feather="star"></i>
                                                            </h2>

                                                            <h5>{{ $detail->totalReviews }} đánh giá chung</h5>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <ul class="product-rating-list">
                                                            @for ($i = 5; $i >= 1; $i--)
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>{{ $i }}<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            @php
                                                                                $count = $detail->review->where('rating', $i)->count();
                                                                                $totalReviews = $detail->review->count();
                                                                                $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                                            @endphp
                                                                            <div class="progress-bar" style="width: {{ $percentage }}%;"></div>
                                                                        </div>
                                                                        <h5 class="total">{{ $count }}</h5>
                                                                    </div>
                                                                </li>
                                                            @endfor
                                                        </ul>

                                                        <div class="review-title-2">
                                                            <h4 class="fw-bold">Đánh giá sản phẩm này</h4>
                                                            <p>Hãy cho những khách hàng khác biết suy nghĩ của bạn</p>
                                                            <button class="btn" type="button" data-bs-toggle="modal"
                                                                data-bs-target="#writereview">Đánh giá</button>
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
                                                                    @if ($item->reviewMultimedia && $item->reviewMultimedia->isNotEmpty())
                                                                        <div>
                                                                            @foreach ($item->reviewMultimedia as $media)
                                                                                <img src="{{ asset('storage/' . $media->file) }}"
                                                                                    style="max-width: 100px;">
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
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

                            <div class="tab-pane fade show active" id="comments" role="tabpanel">
                                <div class="review-box">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="review-people">
                                                <ul class="review-list">
                                                    @foreach ($detail->comments as $item)
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    @if ($item->user->avatar == null)
                                                                        <div class="people-image people-text">
                                                                            <h3 class="text-center rounded-circle bg-white d-inline-flex align-items-center justify-content-center"
                                                                                style="width: 70px; height: 70px;"
                                                                                data-user-id="{{ $item->user->id }}">
                                                                                {{ strtoupper(substr($item->user->fullname, 0, 1)) }}
                                                                            </h3>
                                                                        </div>
                                                                    @else
                                                                        <div class="people-image people-text">
                                                                            <img alt="user" class="img-fluid"
                                                                                src="{{ asset('storage/' . $item->user->avatar) }}">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name">
                                                                        <h3 class="name"
                                                                            data-user-id="{{ $item->user->id }}">
                                                                            {{ $item->user->fullname }}
                                                                        </h3>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content">
                                                                                {{ $item->created_at }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>{{ $item->content }}</p>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary reply-btn"
                                                                        data-comment-id="{{ $item->id }}">Trả
                                                                        lời</button>
                                                                    <div class="reply-input"
                                                                        id="reply-input-{{ $item->id }}"
                                                                        style="display: none; margin-top: 10px;">
                                                                        <textarea class="form-control reply-textarea" placeholder="Nhập phản hồi..."></textarea>
                                                                        <div id="reply-error-{{ $item->id }}"
                                                                            class="text-danger"></div>
                                                                        <button
                                                                            class="btn btn-success btn-sm mt-2 submit-reply"
                                                                            data-comment-id="{{ $item->id }}">Gửi</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <ul class="reply-list" style="margin-left: 50px;">
                                                                @foreach ($item->commentReplies as $reply)
                                                                    <li>
                                                                        <div class="people-box">
                                                                            <div>
                                                                                @if ($reply->user->avatar == null)
                                                                                    <div class="people-image people-text">
                                                                                        <h3 class="text-center rounded-circle bg-white d-inline-flex align-items-center justify-content-center"
                                                                                            style="width: 50px; height: 50px;"
                                                                                            data-user-id="{{ $reply->user->id }}">
                                                                                            {{ strtoupper(substr($reply->user->fullname, 0, 1)) }}
                                                                                        </h3>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="people-image people-text">
                                                                                        <img alt="user"
                                                                                            class="img-fluid"
                                                                                            src="{{ asset('storage/' . $reply->user->avatar) }}">
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="people-comment">
                                                                                <div class="people-name">
                                                                                    <h3 class="name"
                                                                                        data-user-id="{{ $reply->user->id }}">
                                                                                        {{ $reply->user->fullname }}
                                                                                    </h3>
                                                                                    <div class="date-time">
                                                                                        <h6 class="text-content">
                                                                                            {{ $reply->created_at }}
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="reply">
                                                                                    <p>{{ $reply->content }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="mt-4">
                                                    <textarea class="form-control" id="new-comment" placeholder="Nhập bình luận của bạn..." rows="3"></textarea>
                                                    <div id="comment-error" class="text-danger"></div>
                                                    <button class="btn btn-primary mt-2" id="submit-comment"
                                                        data-product-id="{{ $detail->id }}">
                                                        Gửi bình luận
                                                    </button>
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

        {{-- modal review --}}

        <div class="modal fade theme-modal question-modal" id="writereview" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <form class="product-review-form" id="reviewForm" action="{{ route('reviewsSp.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $detail->id }}">
                            <div class="product-wrapper">
                                <div class="product-image">
                                    <img class="img-fluid" alt="{{ $detail->name }}"
                                        src="{{ $detail->productGallery->isNotEmpty() ? asset('storage/' . $detail->productGallery->first()->image) : asset('path/to/placeholder-image.jpg') }}"
                                        width="100px">
                                </div>
                                <div class="product-content">
                                    <h5 class="name">{{ $detail->name }}</h5>
                                    <div class="product-review-rating">
                                        <div class="product-rating">
                                            <h6 class="price-number">{{ number_format($detail->price) }} VND</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review-box">
                                <div class="product-review-rating">
                                    <label>Rating</label>
                                    <div class="product-rating">
                                        <ul class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <i data-feather="star" class="star"
                                                        data-value="{{ $i }}"></i>
                                                </li>
                                            @endfor
                                        </ul>
                                        <input type="hidden" name="rating" id="ratingValue">
                                    </div>
                                </div>
                                <div id="rating-error" class="error-message text-danger"></div>
                            </div>
                            <div class="review-box">
                                <label for="content" class="form-label">Nội dung đánh giá *</label>
                                <textarea name="review_text" id="content" rows="3" class="form-control"
                                    placeholder="Nhập nội dung đánh giá"></textarea>
                                <div id="review_text-error" class="error-message text-danger"></div>
                            </div>
                            <div class="review-box">
                                <label for="images" class="form-label">Hình ảnh (tối đa 5)</label>
                                <input type="file" name="images[]" id="images" class="form-control"
                                    accept="image/*" multiple>
                                <span class="text-danger error-message" id="images-error"></span>
                            </div>
                            <div class="review-box">
                                <label for="videos" class="form-label">Video (tối đa 1)</label>
                                <input type="file" name="videos[]" id="videos" class="form-control"
                                    accept="video/*" multiple>
                                <span class="text-danger error-message" id="videos-error"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-theme-outline fw-bold"
                            data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-md fw-bold text-light theme-bg-color" id="submitReview">Gửi
                            đánh giá</button>
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

                                    <li>
                                        <div class="brand-box">
                                            <h5>Category:</h5>
                                            <h6 id="prdCategories"></h6>
                                        </div>
                                    </li>
                                </ul>


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
        /// Sản phẩm liêm kết

        // document.addEventListener("DOMContentLoaded", function() {
        //     const checkboxes = document.querySelectorAll(".accessory-checkbox");
        //     const totalPriceEl = document.getElementById("total-price");
        //     const addToCartBtn = document.getElementById("add-to-cart");
        //     const mainProductPrice = parseFloat("{{ $detail->sale_price }}"); // Giá sản phẩm chính
        //     let totalPrice = mainProductPrice;

        //     // Hiển thị giá ban đầu
        //     totalPriceEl.textContent = totalPrice.toLocaleString("vi-VN") + " ₫";

        //     // Kiểm tra có checkbox nào được chọn không
        //     function updateButtonState() {
        //         let anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        //         addToCartBtn.disabled = !anyChecked; // Vô hiệu hóa nếu không có phụ kiện nào được chọn
        //     }

        //     // Xử lý sự kiện khi chọn checkbox
        //     checkboxes.forEach(checkbox => {
        //         checkbox.addEventListener("change", function() {
        //             let price = parseFloat(this.dataset.price);

        //             if (this.checked) {
        //                 totalPrice += price;
        //             } else {
        //                 totalPrice -= price;
        //             }

        //             totalPriceEl.textContent = totalPrice.toLocaleString("vi-VN") + " ₫";
        //             updateButtonState();
        //         });
        //     });

        //     // Gọi lần đầu để kiểm tra trạng thái ban đầu của nút
        //     updateButtonState();
        // });

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

        //Chọn biến thể

        document.addEventListener("DOMContentLoaded", function() {
            let productVariants = JSON.parse(document.getElementById("productVariantsData").textContent);
            let productImageElement = document.getElementById("productImage");
            let priceElement = document.getElementById("productPrice");
            let stockElement = document.getElementById("productStock");
            let mainImageContainer = document.getElementById("main-image-container");
            let galleryImages = document.querySelectorAll(".gallery-image");

            let selectedColor = null;
            let selectedMemory = null;
            let defaultSalePrice =
                "{{ $detail->sale_price !== null ? number_format($detail->sale_price, 0, ',', '.') : 'null' }}";
            let defaultPrice = "{{ number_format($detail->price, 0, ',', '.') }}";
            let defaultImage = "{{ asset('storage/' . $detail->thumbnail) }}";
            let defaultStock = "{{ $detail->productStock->stock }}";

            function selectCheapestVariant() {
                if (productVariants.length > 0) {
                    let cheapestVariant = productVariants.reduce((min, variant) => {
                        return (variant.sale_price !== null ? variant.sale_price : variant.price) < (min
                            .sale_price !== null ? min.sale_price : min.price) ? variant : min;
                    });

                    selectedColor = cheapestVariant.attribute_values.find(attr => attr.name === "Màu sắc")?.value
                        ?.trim() || null;
                    selectedMemory = cheapestVariant.attribute_values.find(attr => attr.name === "Dung lượng")
                        ?.value?.trim() || null;

                    updateImage(cheapestVariant.thumbnail);
                    updatePrice(cheapestVariant);
                    updateStock(cheapestVariant);

                    if (selectedColor) {
                        let colorBtn = document.querySelector(`.color-option[data-value="${selectedColor}"]`);
                        if (colorBtn) {
                            colorBtn.classList.add("active");
                        }
                    }

                    if (selectedMemory) {
                        let memoryBtn = document.querySelector(`.memory-option[data-value="${selectedMemory}"]`);
                        if (memoryBtn) {
                            memoryBtn.classList.add("active");
                        }
                    }
                } else {
                    updatePriceWithoutVariant();
                    productImageElement.src = defaultImage;
                    stockElement.textContent = `Số lượng tồn kho: ${defaultStock}`;
                }
            }

            document.querySelectorAll(".color-option").forEach(colorBtn => {
                colorBtn.addEventListener("click", function() {
                    document.querySelectorAll(".color-option").forEach(btn => btn.classList.remove(
                        "active"));
                    this.classList.add("active");
                    selectedColor = this.getAttribute("data-value")?.trim();
                    updateVariant(true); // Pass true to update image
                });
            });

            document.querySelectorAll(".memory-option").forEach(memoryBtn => {
                memoryBtn.addEventListener("click", function() {
                    document.querySelectorAll(".memory-option").forEach(btn => btn.classList.remove(
                        "active"));
                    this.classList.add("active");
                    selectedMemory = this.getAttribute("data-value")?.trim();
                    updateVariant(false); // Pass false to not update image
                });
            });

            function updateVariant(updateImageFlag) {
                let selectedVariant = productVariants.find(variant => {
                    let hasColor = selectedColor ? variant.attribute_values?.some(attr => attr?.value
                    ?.trim() === selectedColor) : true;
                    let hasMemory = selectedMemory ? variant.attribute_values?.some(attr => attr?.value
                        ?.trim() === selectedMemory) : true;
                    return hasColor && hasMemory;
                });

                if (selectedVariant) {
                    if (updateImageFlag) {
                        updateImage(selectedVariant.thumbnail);
                    }
                    updatePrice(selectedVariant);
                    updateStock(selectedVariant);
                } else {
                    updatePriceWithoutVariant();
                    productImageElement.src = defaultImage;
                    stockElement.textContent = `Số lượng tồn kho: ${defaultStock}`;
                }
            }

            function updatePrice(variant) {
                let salePrice = variant.sale_price !== null ? formatPrice(variant.sale_price) : null;
                let originalPrice = formatPrice(variant.price);
                let discount = salePrice ? calculateDiscount(variant.price, variant.sale_price) : null;

                if (salePrice) {
                    priceElement.innerHTML =
                        `${salePrice} ₫ <br><del class="text-content">${originalPrice} ₫</del> <span class="offer theme-color">(${discount}% off)</span>`;
                } else {
                    priceElement.innerHTML = `${originalPrice} ₫`;
                }
            }

            function updatePriceWithoutVariant() {
                if (defaultSalePrice !== "null") {
                    priceElement.innerHTML =
                        `${defaultSalePrice} ₫ <br><del class="text-content">${defaultPrice} ₫</del> <span class="offer theme-color">(${calculateDiscount(parseFloat("{{ $detail->price }}"), parseFloat("{{ $detail->sale_price }}"))}% off)</span>`;
                } else {
                    priceElement.innerHTML = `${defaultPrice} ₫`;
                }
            }

            function updateImage(thumbnail) {
                if (thumbnail) {
                    let newImageSrc = "{{ asset('storage/') }}/" + thumbnail;
                    productImageElement.src = newImageSrc;
                    productImageElement.setAttribute("data-zoom-image", newImageSrc);
                    updateMainImageContainer(newImageSrc);
                } else {
                    productImageElement.src = defaultImage;
                    productImageElement.setAttribute("data-zoom-image", defaultImage);
                    updateMainImageContainer(defaultImage);
                }
            }

            function updateMainImageContainer(newImageSrc) {
                mainImageContainer.innerHTML = `<div class="slider-image">
            <img src="${newImageSrc}" data-zoom-image="${newImageSrc}" class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="Ảnh chính" id="productImage">
        </div>`;
            }

            function updateStock(variant) {
                if (variant.product_stock) {
                    stockElement.textContent = `Số lượng tồn kho: ${variant.product_stock.stock}`;
                } else {
                    stockElement.textContent = `Số lượng tồn kho: ${defaultStock}`;
                }
            }

            function formatPrice(price) {
                return new Intl.NumberFormat("vi-VN").format(price);
            }

            function calculateDiscount(original, sale) {
                let discount = ((original - sale) / original) * 100;
                return Math.round(discount);
            }

            function addActiveToCheapestVariant() {
                if (productVariants.length > 0) {
                    let cheapestVariant = productVariants.reduce((min, variant) => {
                        return (variant.sale_price !== null ? variant.sale_price : variant.price) < (min
                            .sale_price !== null ? min.sale_price : min.price) ? variant : min;
                    });

                    if (cheapestVariant.attribute_values) {
                        cheapestVariant.attribute_values.forEach(attr => {
                            if (attr.name === "Màu sắc") {
                                let colorBtn = document.querySelector(
                                    `.color-option[data-value="${attr.value.trim()}"]`);
                                if (colorBtn) {
                                    colorBtn.classList.add("active");
                                }
                            } else if (attr.name === "Dung lượng") {
                                let memoryBtn = document.querySelector(
                                    `.memory-option[data-value="${attr.value.trim()}"]`);
                                if (memoryBtn) {
                                    memoryBtn.classList.add("active");
                                }
                            }
                        });
                    }
                }
            }

            selectCheapestVariant();
            addActiveToCheapestVariant();
        });


        // document.addEventListener("DOMContentLoaded", function() {
        //     document.querySelectorAll(".reply-btn").forEach(button => {
        //         button.addEventListener("click", function() {
        //             let commentId = this.getAttribute("data-comment-id");
        //             let replyInput = document.getElementById("reply-input-" + commentId);
        //             if (replyInput.style.display === "none") {
        //                 replyInput.style.display = "block";
        //             } else {
        //                 replyInput.style.display = "none";
        //             }
        //         });
        //     });
        // });

        ///Bình luận


        $(document).ready(function() {
            // Submit Comment
            $('#submit-comment').click(function() {
                var productId = $(this).data('product-id');
                var content = $('#new-comment').val();

                // Clear previous error messages
                $('#comment-error').text('');

                $.ajax({
                    url: '/comments',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        content: content,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload(); // Reload page to show new comment
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 401) { // Kiểm tra mã trạng thái 401 (Unauthorized)
                            $('#comment-error').text('Vui lòng đăng nhập để bình luận.');
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.content) {
                                $('#comment-error').text(errors.content[0]);
                            }
                        } else {
                            $('#comment-error').text('Có lỗi xảy ra, vui lòng thử lại.');
                        }
                    }
                });
            });

            // Toggle Reply Input
            $('.reply-btn').click(function() {
                var commentId = $(this).data('comment-id');
                $('#reply-input-' + commentId).toggle();
            });

            // Submit Reply
            $('.submit-reply').click(function() {
                var commentId = $(this).data('comment-id');
                var content = $('#reply-input-' + commentId + ' .reply-textarea').val();
                var replyUserId = $(this).closest('.people-box').find('h3.name').data('user-id');

                // Clear previous error messages
                $('#reply-error-' + commentId).text('');

                $.ajax({
                    url: '/comment-replies',
                    type: 'POST',
                    data: {
                        comment_id: commentId,
                        content: content,
                        reply_user_id: replyUserId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload(); // Reload page to show new reply
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 401) { // Kiểm tra mã trạng thái 401 (Unauthorized)
                            $('#reply-error-' + commentId).text(
                                'Vui lòng đăng nhập để trả lời.');
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.content) {
                                $('#reply-error-' + commentId).text(errors.content[0]);
                            }
                        } else {
                            $('#reply-error-' + commentId).text(
                                'Có lỗi xảy ra, vui lòng thử lại.');
                        }
                    }
                });
            });
        });

        // đánh giá 

        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingValue = document.getElementById('ratingValue');
            const reviewForm = document.getElementById('reviewForm');
            const submitButton = document.getElementById('submitReview');
            const reviewText = document.getElementById('content');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    ratingValue.value = value;

                    stars.forEach(s => {
                        if (s.getAttribute('data-value') <= value) {
                            s.classList.add('fill');
                        } else {
                            s.classList.remove('fill');
                        }
                    });
                });
            });

            if (submitButton && reviewForm) {
                submitButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    // Xóa thông báo lỗi trước đó
                    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                    // Kiểm tra dữ liệu đầu vào
                    let hasError = false;
                    if (!ratingValue || !ratingValue.value) {
                        document.getElementById('rating-error').textContent = 'Vui lòng chọn số sao.';
                        hasError = true;
                    }
                    if (!reviewText || !reviewText.value) {
                        document.getElementById('review_text-error').textContent =
                            'Vui lòng nhập nội dung đánh giá.';
                        hasError = true;
                    }

                    if (hasError) {
                        return; // Ngăn chặn việc gửi form nếu có lỗi
                    }

                    const formData = new FormData(reviewForm);

                    fetch(reviewForm.action, {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: 'Đánh giá thành công!',
                                    timer: 2000,
                                    showConfirmButton: false,
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                return response.json();
                            }
                        })
                        .then(data => {
                            if (data && data.errors) {
                                for (const key in data.errors) {
                                    const errorElement = document.getElementById(key + '-error');
                                    if (errorElement) {
                                        errorElement.textContent = data.errors[key][0];
                                    }
                                }
                            } else if (data && data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: data.error,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi gửi đánh giá.',
                            });
                        });
                });
            }
        });
    </script>
    <!-- JSON chứa danh sách biến thể sản phẩm -->
    <script type="application/json" id="productVariantsData">
    {!! json_encode($detail->productVariants) !!}
</script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Product ID -->
    <script>
        var PRODUCT_ID = {{ $detail->id }};
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- sidebar open js -->
    <script src="{{ asset('theme/client/assets/js/filter-sidebar.js') }}"></script>

    <!-- Zoom Js -->
    <script src="{{ asset('theme/client/assets/js/jquery.elevatezoom.js') }}"></script>
    <script src="{{ asset('theme/client/assets/js/zoom-filter.js') }}"></script>

    <!-- Sticky-bar js -->
    <script src="{{ asset('theme/client/assets/js/sticky-cart-bottom.js') }}"></script>
@endpush
