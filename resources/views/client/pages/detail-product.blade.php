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
                                        @if ($detail->sale_price !== null && $detail->is_sale == 1)
                                            {{ number_format($detail->sale_price, 0, ',', '.') }} ₫
                                            <br><del class="text-content">{{ number_format($detail->price, 0, ',', '.') }}
                                                ₫</del>
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
                                        <input type="hidden" id="isAuthenticated"
                                            value="{{ auth()->check() ? 'true' : 'false' }}">
                                    </div>
                                </div>

                                <div class="product-contain">
                                    <p class="w-100">{{ $detail->short_description }}</p>
                                </div>

                                <div class="product-package">
                                    @foreach ($detail->attributes as $attributeName => $attributeValues)
                                        <div class="product-title">
                                            <h4>{{ $attributeName }}</h4>
                                        </div>
                                        <ul class="circle select-package"
                                            id="{{ str_replace(' ', '-', strtolower($attributeName)) }}-options">
                                            @foreach ($attributeValues as $index => $attrValue)
                                                <li>
                                                    <button type="button"
                                                        class="option {{ str_replace(' ', '-', strtolower($attributeName)) }}-option "
                                                        data-attribute-name="{{ $attributeName }}"
                                                        data-attribute-value-id="{{ $attrValue->id }}"
                                                        data-attribute-value="{{ $attrValue->value }}">{{ $attrValue->value }}</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach

                                    <br>
                                    @if ($detail->type == 1)
                                        <span id="productStock"></span>
                                    @else
                                        <span id="productStock">Số lượng tồn kho :
                                            {{ $detail->productStock->stock ?? 0 }}</span>
                                    @endif
                                </div>


                                <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" id="clockdiv-1"
                                    @if ($detail->is_sale == 1 && $detail->sale_price_start_at && $detail->sale_price_end_at) data-start-date="{{ $detail->sale_price_start_at->timestamp }}"
                                     data-end-date="{{ $detail->sale_price_end_at->timestamp }}"
                                    @else
                                    style="display: none;" @endif>
                                    <div class="my-timer-product-title">
                                        <h4 class="my-timer-promotion-message" id="promotion-message">Nhanh lên! Khuyến
                                            mạikết thúc vào</h4>

                                    </div>
                                    <ul>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="d-block">
                                                    <h5 class="my-timer-days-value"></h5>
                                                </div>
                                                <h6>Days</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-hours-value"></h5>
                                                </div>
                                                <h6>Hours</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-minutes-value"></h5>
                                                </div>
                                                <h6>Min</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-seconds-value"></h5>
                                                </div>
                                                <h6>Sec</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" id="cartProductId">
                                    <input type="hidden" name="product_variant_id" id="cartProductVariantId">
                                    <div class="note-box product-package">
                                        <div class="cart_qty qty-box product-qty">
                                            <div class="input-group">
                                                <button type="button" class="qty-left-minus" data-type="minus"
                                                    data-field="">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="text"
                                                    name="quantity" value="1">
                                                <button type="button" class="qty-right-plus" data-type="plus"
                                                    data-field="">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <button type="submit" id="addToCartButton"
                                            class="btn btn-md bg-dark cart-button text-white w-100">Thêm vào giỏ
                                            hàng</button>
                                    </div>
                                </form>


                                <div class="buy-box">
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                        <a href="javascript:void(0);" class="notifi-wishlist wishlist-toggle"
                                            data-product-id="{{ $detail->id }}">
                                            <i data-feather="heart" class="wishlist-icon"></i>
                                            <span>Add To Wishlist</span>
                                        </a>
                                    </li>

                                </div>

                                <div class="payment-option">
                                    <div class="product-title">
                                        <h4>Đảm bảo thanh toán an toàn !</h4>
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
                                        @foreach ($detail->productAccessories as $dk)
                                            <li>
                                                <div class="product-box product-box-bg wow fadeInUp">
                                                    <div class="product-header">
                                                        <div class="product-image">
                                                            <a href="{{route('products',$dk->id)}}">
                                                                <img src="{{ asset('storage/' . $dk->thumbnail) }}"
                                                                    class="img-fluid blur-up lazyload"
                                                                    alt="{{ $dk->name }}">
                                                            </a>

                                                            <ul class="product-option">
                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                    data-bs-target="#view" data-id={{ $dk->id }}>
                                                                    <i data-feather="eye"></i>
                                                                </a>
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
                                                    </div>
                                                    <div class="product-detail">
                                                        <a href="#">
                                                            <h6 class="name">{{ $dk->name }}</h6>
                                                        </a>

                                                        <h5 class="sold text-content">
                                                            @if ($dk->sale_price == null)
                                                                <del>{{ number_format($dk->price, 0, ',', '.') }} ₫</del>
                                                            @else
                                                                <span
                                                                    class="theme-color price">{{ number_format($dk->sale_price, 0, ',', '.') }}
                                                                    ₫</span>
                                                                <br>
                                                                <del>{{ number_format($dk->price, 0, ',', '.') }} ₫</del>
                                                            @endif
                                                        </h5>
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
                                        <p>{!! $detail->description !!}</p>
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
                                                                        <h5>{{ $i }}<i data-feather="star"></i>
                                                                        </h5>
                                                                        <div class="progress">
                                                                            @php
                                                                                $count = $detail->review
                                                                                    ->where('rating', $i)
                                                                                    ->count();
                                                                                $totalReviews = $detail->review->count();
                                                                                $percentage =
                                                                                    $totalReviews > 0
                                                                                        ? ($count / $totalReviews) * 100
                                                                                        : 0;
                                                                            @endphp
                                                                            <div class="progress-bar"
                                                                                style="width: {{ $percentage }}%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">{{ $count }}</h5>
                                                                    </div>
                                                                </li>
                                                            @endfor
                                                        </ul>

                                                        {{-- <div class="review-title-2">
                                                            <h4 class="fw-bold">Đánh giá sản phẩm này</h4>
                                                            <p>Hãy cho những khách hàng khác biết suy nghĩ của bạn</p>
                                                            <button class="btn" type="button" data-bs-toggle="modal"
                                                                data-bs-target="#writereview">Đánh giá</button>
                                                        </div> --}}
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

                            <div class="tab-pane fade  active" id="comments" role="tabpanel">
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
                        @foreach ($detail->relatedProducts as $related)
                            <div>
                                <div class="product-box-3 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="{{ route('products', $related->id) }}">
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
                                                    <a href="javascript:void(0);" class="notifi-wishlist wishlist-toggle"
                                                        data-product-id="{{ $related->id }}">
                                                        <i data-feather="heart" class="wishlist-icon"></i>
                                                       
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">{{ $related->brand->name }}</span>
                                            <a href="{{route('products',$related->id)}}">
                                                <h5 class="name">{{ $related->name }}</h5>
                                            </a>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li>
                                                            <i data-feather="star"
                                                                class="{{ $i <= round($related->average_rating) ? 'fill' : '' }}"></i>
                                                        </li>
                                                    @endfor
                                                </ul>
                                                <span>({{ number_format($related->average_rating, 1) }})</span>
                                            </div>
                                            <h5 class="price">
                                                @if ($related->productVariants->count() > 0)
                                                @php
                                                    // Lọc ra biến thể có sale_price > 1 và sắp xếp theo sale_price tăng dần
                                                    $variant = $related->productVariants->where('sale_price', '>', 1)->sortBy('sale_price')->first();
                                                    $variantPrice = $variant ? $variant->price : $related->price;
                                                    $variantSalePrice = $variant ? $variant->sale_price : null;
                                                    $isSale = $variant ? $related->is_sale : $related->is_sale;
                                                @endphp
                                            
                                                @if ($isSale == 1 && $variantSalePrice !== null)
                                                    {{ number_format($variantSalePrice, 0, ',', '.') }} ₫
                                                    <br><del class="text-content">{{ number_format($variantPrice, 0, ',', '.') }} ₫</del>
                                                @else
                                                    {{ number_format($variantPrice, 0, ',', '.') }} ₫
                                                @endif
                                            @else
                                                @if ($related->is_sale == 1 && $related->sale_price > 1)
                                                    {{ number_format($related->sale_price, 0, ',', '.') }} ₫
                                                    <br><del class="text-content">{{ number_format($related->price, 0, ',', '.') }} ₫</del>
                                                @else
                                                    {{ number_format($related->price, 0, ',', '.') }} ₫
                                                @endif
                                            @endif
                                            
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <button class="btn btn-add-cart addcart-button">add </button>

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


                                <div id="productVariants">

                                </div>

                                <div class="modal-button">
                                    <form id="addToCartFormModal" method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" id="cartProductId">
                                        <input type="hidden" name="product_variant_id" id="cartProductVariantId">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-md add-cart-button icon">Thêm vào giỏ
                                            hàng</button>
                                    </form>

                                    <a href="#"
                                        class="xem-chi-tiet-button mb-3 btn theme-bg-color view-button icon text-white fw-bold btn-md ">Xem
                                        chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        //thêm vào giỏ hàng 




        // Hàm định dạng giá tiền sang VNĐ
        function formatPrice(price) {
            const number = parseFloat(price) // Chuyển đổi giá sang số thực
            return isNaN(number) ? "0 đ" : number.toLocaleString('vi-VN', { // Định dạng số sang VNĐ
                style: 'currency',
                currency: 'VND'
            })
        }

        $(document).ready(function() {

            $('a.xem-chi-tiet-button').click(function(
                e) { // Bắt sự kiện click trên nút "Xem chi tiết" (class 'xem-chi-tiet-button')
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a> (nếu có href)

                const productId = $(this).data(
                    'id'); // Lấy product ID từ thuộc tính `data-id` của nút "Xem chi tiết"


                const productDetailPageUrl = `/products/${productId}`;

                // Chuyển hướng trình duyệt đến trang chi tiết sản phẩm
                window.location.href = productDetailPageUrl;
            });

            // Khai báo biến toàn cục để lưu trữ variantMap
            let globalVariantMap = {};

            $('a[data-bs-target="#view"]').click(function() { // Bắt sự kiện  mở modal

                const productId = $(this).data('id')

                $('a.xem-chi-tiet-button').click(function(
                    e) {
                    e.preventDefault();


                    const productDetailPageUrl = `/products/${productId}`;

                    window.location.href = productDetailPageUrl;
                });

                $('#view').data('product-id', productId); // Lưu product_id vào data của modal #view

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
                        $('#prdDescription').text(response.short_description)
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

                        // đã bán
                        var soldCountText = "Đã bán (" + response.sold_count + ")";
                        $('#prdSoldCount').text(soldCountText);


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
                                    variant_id: variant
                                        .id, // Thêm variant_id vào đây
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


            function updateProductInfo(variant) {
                $('#prdPrice').text(formatPrice(variant.price))
                $('#prdThumbnail').attr('src', variant.thumbnail)
            }

            function setSelectedAttributes(attributes) {
                attributes.forEach(attr => {
                    const attrSlug = attr.attributes_slug
                    $(`select[data-attribute="${attrSlug}"]`).val(attr
                        .id
                    )
                })
            }

            function getSelectedAttributes() {
                const selected = []
                $('.variant-attribute').each(function() {
                    const val = $(this).val()
                    if (val) selected.push(
                        val)
                })
                return selected
            }

            function updateStockInfo(variant) {
                const stock = variant.product_stock ? variant.product_stock.stock :
                    0;
                $('.product-stock span').text(
                    `Kho: ${stock}`);
            }


            // add to cart

            $('.add-cart-button').click(function(event) {
                // event.preventDefault(); **BỎ NGĂN CHẶN SUBMIT FORM MẶC ĐỊNH**

                // Lấy product_id từ modal
                const productId = $('#view').data('product-id');

                // Kiểm tra xem sản phẩm có biến thể hay không
                const hasVariants = $('#productVariants .variant-attribute').length > 0;

                const addToCartForm = document.getElementById('addToCartFormModal'); // Lấy form

                if (hasVariants) {
                    // Xử lý sản phẩm có biến thể
                    const selectedValues = getSelectedAttributes();
                    const variantKey = selectedValues.sort((a, b) => a - b).join('-');
                    const selectedVariant = globalVariantMap[variantKey];

                    if (!selectedVariant) {
                        Swal.fire({ // **SWEETALERT2 ERROR MESSAGE**
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Vui lòng chọn đầy đủ thuộc tính sản phẩm!',
                            confirmButtonText: 'Đóng'
                        });
                        return;
                    }

                    // **CẬP NHẬT INPUT HIDDEN product_variant_id TRONG FORM**
                    addToCartForm.querySelector('#cartProductVariantId').value = selectedVariant.variant_id;


                } else {
                    // Xử lý sản phẩm không có biến thể
                    // **ĐẢM BẢO INPUT HIDDEN product_variant_id TRONG FORM ĐƯỢC XÓA/RỖNG**
                    addToCartForm.querySelector('#cartProductVariantId').value =
                        ''; // hoặc null, hoặc xóa thuộc tính value
                }

                // **CẬP NHẬT INPUT HIDDEN product_id TRONG FORM**
                addToCartForm.querySelector('#cartProductId').value = productId;


                // **FORM SẼ ĐƯỢC SUBMIT ĐI (vì đã bỏ event.preventDefault())**
                // KHÔNG CẦN AJAX NỮA - FORM SUBMIT MẶC ĐỊNH SẼ ĐƯỢC THỰC HIỆN
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                    showConfirmButton: false,
                    timer: 1500
                });

            });
        })
        //////
        // console.log(productVariants);

        //Chọn biến thể

        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButton = document.getElementById('addToCartButton');
            // console.log("Phần tử addToCartButton:", addToCartButton);

            if (addToCartButton) {
                addToCartButton.addEventListener('click', function(event) {
                    // event.preventDefault(); // Ngăn chặn form submit mặc định

                    // debugger;
                    console.log("Nút 'Thêm vào giỏ hàng' đã được click!");

                    // **LẤY DỮ LIỆU TỪ FORM VÀ CẬP NHẬT INPUT HIDDEN TRONG FORM**
                    const addToCartForm = document.getElementById('addToCartForm'); // Lấy form
                    const productId = "{{ $detail->id }}"; // Lấy product_id từ Blade
                    let productVariantId = currentVariant ? currentVariant.id :
                        null; // Lấy product_variant_id từ biến currentVariant (nếu có)
                    const quantity = addToCartForm.querySelector('.qty-input')
                        .value; // Lấy quantity từ input trong form

                    // **[PHẦN THÊM MỚI] - TỰ ĐỘNG CHỌN BIẾN THỂ RẺ NHẤT NẾU CHƯA CHỌN VÀ CÓ BIẾN THỂ**
                    if (!currentVariant && productVariants.length > 0) {
                        currentVariant =
                            defaultVariant; // Sử dụng biến thể mặc định rẻ nhất đã tìm ở DOMContentLoaded
                        productVariantId = currentVariant.id; // Lấy ID của biến thể mặc định
                        console.log('Tự động chọn biến thể rẻ nhất (mặc định):', currentVariant);

                        // **Cập nhật lại input cartProductVariantId với ID biến thể mặc định**
                        addToCartForm.querySelector('#cartProductVariantId').value = productVariantId;
                    }

                    // **CẬP NHẬT GIÁ TRỊ CHO CÁC INPUT HIDDEN TRONG FORM**
                    addToCartForm.querySelector('#cartProductId').value = productId;
                    addToCartForm.querySelector('#cartProductVariantId').value = productVariantId ||
                        ''; // Gán giá trị hoặc chuỗi rỗng nếu null (hoặc đã được gán ở trên)
                    addToCartForm.querySelector('.qty-input').value =
                        quantity; // Cập nhật lại qty-input (mặc dù giá trị đã có, nhưng để đồng bộ)

                    console.log('Input form đã được cập nhật với dữ liệu:');
                    console.log('product_id:', productId);
                    console.log('product_variant_id:', productVariantId);
                    console.log('quantity:', quantity);

                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                });
            } else {
                console.error("LỖI: Không tìm thấy nút 'addToCartButton' trong DOM! Kiểm tra ID nút trong HTML.");
            }


            const productPriceDisplay = document.getElementById('productPrice');
            const variantOptions = document.querySelectorAll('.option');
            let selectedVariantAttributes = {};
            let currentVariant =
                null; // **Khai báo currentVariant ở phạm vi ngoài cùng (global scope trong DOMContentLoaded)**
            const productVariants = @json($detail->productVariants); // Lấy danh sách biến thể từ Blade

            let defaultVariant = null;

            if (productVariants.length > 0) {
                // **Tìm biến thể mặc định: Ưu tiên giá thấp nhất, sau đó biến thể đầu tiên**
                defaultVariant = productVariants.reduce((minVariant, currentVariant) => {
                    let minPrice = minVariant ? (minVariant.sale_price !== null ? minVariant.sale_price :
                        minVariant.price) : Infinity;
                    let currentPrice = currentVariant.sale_price !== null ? currentVariant.sale_price :
                        currentVariant.price;

                    if (currentPrice < minPrice) {
                        return currentVariant;
                    } else if (currentPrice === minPrice && !minVariant) {
                        return currentVariant;
                    } else {
                        return minVariant || currentVariant;
                    }
                }, null);

                if (defaultVariant) {
                    console.log('Biến thể mặc định được chọn ban đầu (giá rẻ nhất):', defaultVariant);
                    // Chọn các option tương ứng với biến thể mặc định khi trang tải
                    defaultVariant.attribute_values.forEach(attrValue => {
                        const optionButton = document.querySelector(
                            `.option[data-attribute-name="${attrValue.attribute.name}"][data-attribute-value="${attrValue.value}"]`
                        );
                        if (optionButton) {
                            optionButton.classList.add('active');
                            selectedVariantAttributes[attrValue.attribute.name] = attrValue.value;
                        }
                    });
                    updateProductDisplay(defaultVariant); // Cập nhật hiển thị ban đầu với biến thể mặc định
                }
            }


            variantOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // 1. Xóa active class khỏi các option khác trong cùng nhóm thuộc tính
                    const attributeGroupOptions = this.closest('.select-package').querySelectorAll(
                        '.option');
                    attributeGroupOptions.forEach(opt => opt.classList.remove('active'));
                    // 2. Thêm active class vào option vừa click
                    this.classList.add('active');

                    // 3. Thu thập thuộc tính đã chọn
                    const attributeName = this.dataset.attributeName;
                    const attributeValue = this.dataset.attributeValue;
                    selectedVariantAttributes[attributeName] = attributeValue;
                    console.log('Thuộc tính biến thể đã chọn:', selectedVariantAttributes);

                    // 4. Tìm biến thể phù hợp
                    currentVariant = findMatchingVariant(selectedVariantAttributes,
                        productVariants);

                    if (currentVariant) {
                        console.log('Biến thể phù hợp đã chọn:', currentVariant);
                        updateProductDisplay(currentVariant);

                        // **PHẦN THÊM MỚI - CẬP NHẬT INPUT cartProductVariantId KHI CHỌN BIẾN THỂ**
                        const addToCartForm = document.getElementById('addToCartForm'); // Lấy form
                        addToCartForm.querySelector('#cartProductVariantId').value = currentVariant
                            .id; // Gán currentVariant.id vào input

                        console.log('Input cartProductVariantId đã được cập nhật với ID biến thể:',
                            currentVariant.id); // Log để kiểm tra

                    } else {
                        console.log('Không tìm thấy biến thể phù hợp');
                        document.getElementById('productStock').textContent =
                            ' Không có sẵn với lựa chọn này';
                        document.getElementById('productPrice').textContent = 'Liên hệ';
                        // **NẾU KHÔNG TÌM THẤY BIẾN THỂ, CŨNG CẦN XÓA GIÁ TRỊ INPUT cartProductVariantId**
                        const addToCartForm = document.getElementById(
                            'addToCartForm'); // Lấy form lại (cho chắc chắn)
                        addToCartForm.querySelector('#cartProductVariantId').value =
                            ''; // Xóa giá trị input khi không có biến thể
                        console.log(
                            'Input cartProductVariantId đã được XÓA vì không có biến thể phù hợp.'
                        ); // Log để kiểm tra
                    }
                });
            });

            function findMatchingVariant(selectedAttributes, productVariants) {
                for (const variant of productVariants) {
                    let match = true;
                    for (const attrName in selectedAttributes) {
                        const selectedAttrValue = selectedAttributes[attrName];
                        let variantHasAttrValue = false;
                        for (const variantAttrValue of variant.attribute_values) {
                            if (variantAttrValue.attribute.name === attrName && variantAttrValue.value ===
                                selectedAttrValue) {
                                variantHasAttrValue = true;
                                break;
                            }
                        }
                        if (!variantHasAttrValue) {
                            match = false;
                            break;
                        }
                    }
                    if (match) {
                        return variant;
                    }
                }
                return null; // Không tìm thấy biến thể phù hợp
            }


            function updateProductDisplay(variant) {
                const productPriceElement = document.getElementById('productPrice');
                const productStockElement = document.getElementById('productStock');
                const productImageElement = document.getElementById('productImage');

                // Cập nhật giá (ưu tiên giá sale nếu có)
                if (variant.sale_price !== null) {
                    productPriceElement.innerHTML = formatPrice(variant.sale_price) +
                        ' ₫ <br><del class="text-content">' + formatPrice(variant.price) + ' ₫</del>';
                } else {
                    productPriceElement.innerHTML = formatPrice(variant.price) + ' ₫';
                }

                // Cập nhật số lượng tồn kho
                if (variant.product_stock && variant.product_stock.stock > 0) {
                    productStockElement.textContent = 'Số lượng tồn kho: ' + variant.product_stock.stock;
                } else {
                    productStockElement.textContent = 'Hết hàng';
                }

                // Cập nhật ảnh (nếu có thumbnail cho biến thể)
                if (variant.thumbnail) {
                    productImageElement.src = "{{ asset('storage/') }}/" + variant.thumbnail;
                    productImageElement.dataset.zoomImage = "{{ asset('storage/') }}/" + variant.thumbnail;
                } else {
                    productImageElement.src = "{{ asset('storage/' . $detail->thumbnail) }}";
                    productImageElement.dataset.zoomImage = "{{ asset('storage/' . $detail->thumbnail) }}";
                }
            }


            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN').format(price);
            }


        });


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
            // --- Khai báo các biến ---
            const stars = document.querySelectorAll('.star');
            const ratingValue = document.getElementById('ratingValue');
            const reviewForm = document.getElementById('reviewForm');
            const submitButton = document.getElementById('submitReview');
            const reviewText = document.getElementById('content');
            const imagesInput = document.getElementById('images');
            const videosInput = document.getElementById('videos');
            const isAuthenticated = document.getElementById('isAuthenticated')?.value === 'true';

            // --- Hàm xử lý chọn sao đánh giá ---
            function handleStarRating(starElement) {
                if (!isAuthenticated) {
                    showLoginRequiredAlert();
                    return;
                }

                const value = starElement.getAttribute('data-value');
                ratingValue.value = value;

                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('fill');
                    } else {
                        s.classList.remove('fill');
                    }
                });
            }

            // --- Hàm hiển thị thông báo yêu cầu đăng nhập ---
            function showLoginRequiredAlert() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo!',
                    text: 'Bạn cần đăng nhập để đánh giá!',
                });
            }

            // --- Hàm kiểm tra số lượng ảnh (Client-side) ---
            function validateImageCount() {
                const files = imagesInput.files;
                if (files.length > 5) {
                    return {
                        'images_count': 'Bạn chỉ được phép tải lên tối đa 5 hình ảnh.'
                    };
                }
                return null; // Không có lỗi
            }

            // --- Hàm xử lý gửi đánh giá ---
            async function submitReviewForm(event) {
                event.preventDefault();
                event.stopPropagation();

                if (!isAuthenticated) {
                    showLoginRequiredAlert();
                    return;
                }

                // Xóa thông báo lỗi hiện tại
                clearErrorMessages();

                // Kiểm tra số lượng ảnh (Client-side)
                const imageCountError = validateImageCount();
                if (imageCountError) {
                    displayErrorMessages(imageCountError);
                    return; // Dừng gửi form nếu lỗi số lượng ảnh
                }

                // Kiểm tra tính hợp lệ của dữ liệu (Client-side - basic, can remove if you rely solely on backend validation)
                const validationErrors = validateInput();
                if (validationErrors) {
                    displayErrorMessages(validationErrors);
                    return;
                }

                // Gửi form data bằng Fetch API
                try {
                    const formData = new FormData(reviewForm);
                    const response = await fetch(reviewForm.action, {
                        method: 'POST',
                        body: formData,
                    });

                    if (response.ok) {
                        handleSuccessResponse();
                    } else {
                        handleErrorResponse(response);
                    }
                } catch (error) {
                    handleFetchError(error);
                }
            }

            // --- Hàm xóa tất cả thông báo lỗi ---
            function clearErrorMessages() {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            }

            // --- Hàm kiểm tra dữ liệu đầu vào (Client-side - basic, can remove if you rely solely on backend validation) ---
            function validateInput() {
                let errors = {};
                if (!ratingValue.value) {
                    errors['rating'] = 'Vui lòng chọn số sao.';
                }
                if (!reviewText.value) {
                    errors['review_text'] = 'Vui lòng nhập nội dung đánh giá.';
                }
                return Object.keys(errors).length > 0 ? errors : null;
            }

            // --- Hàm hiển thị thông báo lỗi ---
            function displayErrorMessages(errors) {
                for (const key in errors) {
                    let errorElement = null;

                    if (key === 'rating') {
                        errorElement = document.getElementById('rating-error');
                    } else if (key === 'review_text') {
                        errorElement = document.getElementById('review_text-error');
                    } else if (key === 'images' || key === 'images_count') { // Thêm 'images_count' key here
                        errorElement = document.getElementById('images-error');
                    } else if (key.startsWith('images.')) { // For individual image errors like format, size
                        errorElement = document.getElementById(
                            'images-error'); // Display all image errors under the same span
                    } else if (key.startsWith('videos.')) { // For video errors
                        errorElement = document.getElementById('videos-error');
                    }

                    if (errorElement) {
                        errorElement.textContent = errors[key];
                    }
                }
            }

            // --- Hàm xử lý khi gửi đánh giá thành công ---
            function handleSuccessResponse() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đánh giá thành công!',
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });
            }

            // --- Hàm xử lý khi có lỗi từ server ---
            async function handleErrorResponse(response) {
                try {
                    const data = await response.json();

                    if (data && data.errors) {
                        displayErrorMessages(data.errors);
                    } else if (data && data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: data.error,
                        });
                    }
                } catch (jsonError) {
                    handleFetchError(jsonError);
                }
            }


            // --- Hàm xử lý lỗi Fetch API ---
            function handleFetchError(error) {
                console.error('Lỗi Fetch:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi gửi đánh giá.',
                });
            }


            // --- Gắn kết các sự kiện ---
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    handleStarRating(this);
                });
            });

            if (submitButton && reviewForm) {
                submitButton.addEventListener('click', submitReviewForm);
            }
        });

        //Khuyến mãi 

        document.addEventListener('DOMContentLoaded', function() {
            // --- Timer Javascript code ---
            const timerContainer = document.getElementById(
                'clockdiv-1'); // Keep the ID the same if you want to target the existing div
            if (timerContainer && timerContainer.dataset.startDate && timerContainer.dataset.endDate) {
                const startTimeStamp = timerContainer.dataset.startDate;
                const endTimeStamp = timerContainer.dataset.endDate;

                const promotionMessageElement = timerContainer.querySelector(
                    '.my-timer-promotion-message'); // New class name

                if (startTimeStamp && endTimeStamp) {
                    const startTime = new Date(startTimeStamp * 1000);
                    const endTime = new Date(endTimeStamp * 1000);
                    const now = new Date();

                    let targetTime;
                    let promotionMessage = "Nhanh lên! Khuyến mại kết thúc vào";

                    if (now < startTime) {
                        targetTime = startTime;
                        promotionMessage = "Khuyến mại bắt đầu sau";
                    } else if (now >= endTime) {
                        timerContainer.innerHTML =
                            "<div class='my-timer-product-title'><h4 class='my-timer-promotion-ended'>Khuyến mại đã kết thúc!</h4></div>";
                        return;
                    } else {
                        targetTime = endTime;
                        promotionMessage = "Nhanh lên! Khuyến mại kết thúc vào";
                    }

                    if (promotionMessageElement) {
                        promotionMessageElement.textContent = promotionMessage;
                    }

                    function updateClock() {
                        const now = new Date();
                        const timeDiff = targetTime - now;

                        if (timeDiff <= 0) {
                            clearInterval(timeInterval);
                            if (now < startTime) {
                                targetTime = endTime;
                                if (promotionMessageElement) {
                                    promotionMessageElement.textContent =
                                        "Nhanh lên! Khuyến mại kết thúc vào";
                                }
                                timeInterval = setInterval(updateClock, 1000);
                            } else {
                                timerContainer.innerHTML =
                                    "<div class='my-timer-product-title'><h4 class='my-timer-promotion-ended'>Khuyến mại đã kết thúc!</h4></div>"; // New class names
                                return;
                            }
                        }

                        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                        timerContainer.querySelector('.my-timer-days-value').textContent = formatTime(
                            days); // New class names
                        timerContainer.querySelector('.my-timer-hours-value').textContent = formatTime(
                            hours); // New class names
                        timerContainer.querySelector('.my-timer-minutes-value').textContent = formatTime(
                            minutes); // New class names
                        timerContainer.querySelector('.my-timer-seconds-value').textContent = formatTime(
                            seconds); // New class names
                    }

                    function formatTime(time) {
                        return time < 10 ? "0" + time : time;
                    }

                    updateClock();
                    let timeInterval = setInterval(updateClock, 1000);
                }
            }
        });

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
