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
    .review-media-thumbnail {
    width: 100px;  
    height: 100px;
    object-fit: cover; 
    display: block;
  
}
</style>
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>{{ $detail->name }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">{{ $detail->name }}</li>
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
                                            mại kết thúc sau</h4>

                                    </div>
                                    <ul>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="d-block">
                                                    <h5 class="my-timer-days-value"></h5>
                                                </div>
                                                <h6>Ngày</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-hours-value"></h5>
                                                </div>
                                                <h6>Giờ</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-minutes-value"></h5>
                                                </div>
                                                <h6>Phút</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class=" d-block">
                                                    <h5 class="my-timer-seconds-value"></h5>
                                                </div>
                                                <h6>Giây</h6>
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
                                            <span>Thêm vào yêu thích</span>
                                        </a>
                                    </li>
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" title="So sánh">
                                        <a href="javascript:;" class="compare-toggle" data-state="unselected"
                                            data-product-id="{{ $detail->id }}"
                                            data-product-category-id="{{ $detail->categories->first()->id ?? null }}">
                                            <span class="icon-refresh">
                                                <i data-feather="refresh-cw"></i>
                                            </span>
                                            <span class="icon-check" style="display:none;">
                                                <i data-feather="check"></i>
                                            </span>
                                            <span>So sánh</span>
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
                                <h4>Phụ kiện đi kèm</h4>
                            </div>
                            <div class="related-box">
                                <div class="related-image">
                                    <ul>
                                        @foreach ($detail->productAccessories as $dk)
                                            <li>
                                                <div class="product-box product-box-bg wow fadeInUp">
                                                    <div class="product-header">
                                                        <div class="product-image">
                                                            <a href="{{ route('products', $dk->slug) }}">
                                                                <img src="{{ asset('storage/' . $dk->thumbnail) }}"
                                                                    class="img-fluid blur-up lazyload"
                                                                    alt="{{ $dk->name }}">
                                                            </a>
                                                            <ul class="product-option">
                                                                <li>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                        data-bs-target="#view" data-id={{ $dk->id }}
                                                                        data-slug={{ $dk->slug }}>
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="So sánh">
                                                                    <a href="javascript:;" class="compare-toggle"
                                                                        data-state="unselected"
                                                                        data-product-id="{{ $dk->id }}"
                                                                        data-product-category-id="{{ $dk->categories->first()->id ?? null }}">
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
                                                                        data-product-id="{{ $dk->id }}">
                                                                        <i data-feather="heart" class="wishlist-icon"
                                                                            style="color: {{ in_array($dk->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <a href="{{ route('products', $dk->slug) }}">
                                                            <h6 class="name">{{ $dk->name }}</h6>
                                                        </a>

                                                        <h5 class="sold text-content">
                                                            @if ($dk->productVariants->isNotEmpty())
                                                                @php
                                                                    $minVariant = $dk->productVariants
                                                                        ->where('is_active', 1)
                                                                        ->sortBy(function ($variant) {
                                                                            // Sắp xếp theo giá tăng dần
                                                                            return $variant->sale_price !== null
                                                                                ? $variant->sale_price
                                                                                : $variant->price;
                                                                        })
                                                                        ->first(); // Lấy biến thể đầu tiên sau khi sắp xếp, tức là biến thể có giá thấp nhất

                                                                    $minPrice =
                                                                        $minVariant->sale_price !== null
                                                                            ? $minVariant->sale_price
                                                                            : $minVariant->price; // Lấy giá thấp nhất từ biến thể đã tìm được
                                                                @endphp
                                                                <span>
                                                                    @if ($dk->is_sale == 1)
                                                                        <span
                                                                            class="theme-color price">{{ number_format($minPrice, 0, ',', '.') }}
                                                                            ₫</span>
                                                                        <br><del
                                                                            class="text-content">{{ number_format($minVariant->price, 0, ',', '.') }}
                                                                            ₫</del>
                                                                    @else
                                                                        {{ number_format($minPrice, 0, ',', '.') }} ₫
                                                                    @endif
                                                                </span>
                                                            @else
                                                                @if ($dk->is_sale == 1)
                                                                    <span
                                                                        class="theme-color price">{{ number_format($dk->sale_price, 0, ',', '.') }}
                                                                        ₫</span>
                                                                    <br>
                                                                    <del>{{ number_format($dk->price, 0, ',', '.') }}
                                                                        ₫</del>
                                                                @else
                                                                    <span>{{ number_format($dk->price, 0, ',', '.') }}
                                                                        ₫</span>
                                                                @endif
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
                            @if ($detail->description != null)
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="product-description">
                                        <div class="nav-desh">
                                            <p>{!! $detail->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span>Sản phẩm hiện không có mô tả</span>
                            @endif


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
                                                            @if ($purchaseReviewStatus['hasPurchased'] && $purchaseReviewStatus['canReview'] && !$purchaseReviewStatus['reviewPeriodExpired'])
                                                                <h4 class="fw-bold">Đánh giá sản phẩm này</h4>
                                                                <p>Hãy cho những khách hàng khác biết suy nghĩ của bạn</p>
                                                                <button class="btn" type="button"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#writereview">Đánh giá</button>
                                                            @endif
                                                            @if ($purchaseReviewStatus['hasPurchased'] && $purchaseReviewStatus['reviewPeriodExpired'])
                                                                <p class="text-muted">Thời gian đánh giá cho sản phẩm này
                                                                    đã kết thúc.</p>
                                                            @endif
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-rating mt-2">
                                                                        <ul class="rating">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                <li>
                                                                                    <i data-feather="star"
                                                                                        class="{{ $i <= round($item->rating) ? 'fill' : '' }}"></i>
                                                                                </li>
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>{{ $item->review_text }}</p>
                                                                    </div>
                                                                    @if ($item->reviewMultimedia && $item->reviewMultimedia->isNotEmpty())
                                                                        <div
                                                                            style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                                            {{-- Thêm style display: flex và gap --}}
                                                                            @foreach ($item->reviewMultimedia as $media)
                                                                                @if ($media->file_type == 0)
                                                                                    <img src="{{ asset('storage/' . $media->file) }}"
                                                                                        class="review-media-thumbnail"
                                                                                        {{-- Thêm class --}}
                                                                                        alt="Review Image">
                                                                                    {{-- Nên thêm alt text --}}
                                                                                @elseif ($media->file_type == 1)
                                                                                    <video
                                                                                        src="{{ asset('storage/' . $media->file) }}"
                                                                                        class="review-media-thumbnail"
                                                                                        {{-- Thêm class --}}
                                                                                        controls></video>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
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
                                            <a href="{{ route('products', $related->slug) }}">
                                                <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="{{ $related->name }}">
                                            </a>

                                            <ul class="product-option">
                                                <li>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#view" data-id={{ $related->id }}
                                                        data-slug={{ $related->slug }}>
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="So sánh">
                                                    <a href="javascript:;" class="compare-toggle" data-state="unselected"
                                                        data-product-id="{{ $related->id }}"
                                                        data-product-category-id="{{ $related->categories->first()->id ?? null }}">
                                                        <span class="icon-refresh">
                                                            <i data-feather="refresh-cw"></i>
                                                        </span>
                                                        <span class="icon-check" style="display:none;">
                                                            <i data-feather="check"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                    <a href="javascript:void(0);" class="notifi-wishlist wishlist-toggle"
                                                        data-product-id="{{ $related->id }}">
                                                        <i data-feather="heart" class="wishlist-icon"
                                                            style="color: {{ in_array($related->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">{{ $related->brand->name }}</span>
                                            <a href="{{ route('products', $related->slug) }}">
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
                                                        $variant = $related->productVariants
                                                            ->where('sale_price', '>', 1)
                                                            ->sortBy('sale_price')
                                                            ->first();
                                                        $variantPrice = $variant ? $variant->price : $related->price;
                                                        $variantSalePrice = $variant ? $variant->sale_price : null;
                                                        $isSale = $variant ? $related->is_sale : $related->is_sale;
                                                    @endphp

                                                    @if ($isSale == 1 && $variantSalePrice !== null)
                                                        {{ number_format($variantSalePrice, 0, ',', '.') }} ₫
                                                        <br><del
                                                            class="text-content">{{ number_format($variantPrice, 0, ',', '.') }}
                                                            ₫</del>
                                                    @else
                                                        {{ number_format($variantPrice, 0, ',', '.') }} ₫
                                                    @endif
                                                @else
                                                    @if ($related->is_sale == 1 && $related->sale_price > 1)
                                                        {{ number_format($related->sale_price, 0, ',', '.') }} ₫
                                                        <br><del
                                                            class="text-content">{{ number_format($related->price, 0, ',', '.') }}
                                                            ₫</del>
                                                    @else
                                                        {{ number_format($related->price, 0, ',', '.') }} ₫
                                                    @endif
                                                @endif

                                            </h5>

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
                            <input type="hidden" name="order_id" id="review_order_id" value="">
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
                                    <h4>Mô tả :</h4>
                                    <p id='prdDescription'></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Thương hiệu:</h5>
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
                                            <h5>Danh mục:</h5>
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

            // $('a.xem-chi-tiet-button').click(function(
            //     e) { // Bắt sự kiện click trên nút "Xem chi tiết" (class 'xem-chi-tiet-button')
            //     e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a> (nếu có href)

            //     const productId = $(this).data(
            //         'id'); // Lấy product ID từ thuộc tính `data-id` của nút "Xem chi tiết"


            //     const productDetailPageUrl = `/products/${productId}`;

            //     // Chuyển hướng trình duyệt đến trang chi tiết sản phẩm
            //     window.location.href = productDetailPageUrl;
            // });

            // Khai báo biến toàn cục để lưu trữ variantMap
            let globalVariantMap = {};

            $('a[data-bs-target="#view"]').click(function() { // Bắt sự kiện mở modal

                const productId = $(this).data('id')
                const productSlug = $(this).data('slug');

                $('a.xem-chi-tiet-button').click(function(
                    e) {
                    e.preventDefault();


                    const productDetailPageUrl = `/products/${productSlug}`;

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
                                    sale_price: variant
                                        .sale_price, // Thêm sale_price vào variantMap
                                    thumbnail: variant.thumbnail,
                                    product_stock: variant.product_stock,
                                    is_sale: response
                                        .is_sale // Thêm is_sale vào variantMap để sử dụng trong updateProductInfo
                                };
                            });
                            console.log("Global Variant Map updated:", globalVariantMap);

                            // Tạo map attribute và options (loại bỏ trùng lặp giá trị thuộc tính)
                            const
                                attributes = {} // tạo object để lưu trữ thông tin thuộc tính và giá trị

                            variants.forEach(variant => {
                                variant.attribute_values.forEach(
                                    attr => { // Lặp qua từng giá trị thuộc tính của biến thể

                                        const attrSlug = attr
                                            .attributes_slug // Định dạng tên thuộc tính -> slug)

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
                                // Để có giá trị đến attr.attributes_name, cần lấy lại thông tin attribute tương ứng với slug.
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
                                    sale_price: variant.sale_price,
                                    thumbnail: variant
                                        .thumbnail, // Thumbnail biến thể
                                    product_stock: variant

                                        .product_stock, // Thông tin stock của biến thể
                                    is_sale: response.is_sale
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
                            updateProductInfo(lowestVariant, response
                                .is_sale
                            ) // Cập nhật giá và thumbnail , Thêm is_sale vào đây
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
                                        updateProductInfo(variant, response
                                            .is_sale
                                        ) // Cập nhật giá và thumbnail, Thêm is_sale vào đây
                                        updateStockInfo(variant);
                                    } else {
                                        updateDefaultProductInfo(
                                            response
                                        ); // Cập nhật lại thông tin sản phẩm gốc khi không tìm thấy biến thể
                                    }
                                })

                        } else { // Trường hợp sản phẩm không có biến thể
                            $('#productVariants').html('<p>Sản phẩm này không có biến thể</p>')
                            updateDefaultProductInfo(
                                response); // Cập nhật thông tin sản phẩm gốc
                        }
                    },
                    error: () => alert(
                        'Không tìm thấy sản phẩm'
                    )
                })
            })


            function updateProductInfo(variant, isSale) { // Thêm isSale parameter
                if (isSale == 1 && variant.sale_price !== null) { // Kiểm tra is_sale và sale_price
                    $('#prdPrice').html(`
            <span class="theme-color price">${formatPrice(variant.sale_price)}</span>
            <del class="text-content">${formatPrice(variant.price)}</del>
          `); // Hiển thị giá sale và gạch giá gốc
                } else {
                    $('#prdPrice').text(formatPrice(variant
                        .price)); // Hiển thị giá gốc nếu không có sale hoặc is_sale = 0
                }

                $('#prdThumbnail').attr('src', variant.thumbnail)
            }

            function updateDefaultProductInfo(
                product
            ) { // Hàm cập nhật giá và thumbnail mặc định (khi không có biến thể hoặc không chọn biến thể)
                if (product.is_sale == 1 && product.sale_price !== null) {
                    $('#prdPrice').html(`
            <span class="theme-color price">${formatPrice(product.sale_price)}</span>
            <del class="text-content">${formatPrice(product.price)}</del>
          `); // Hiển thị giá sale và gạch giá gốc
                } else {
                    $('#prdPrice').text(formatPrice(product
                        .price)); // Hiển thị giá gốc nếu không có sale hoặc is_sale = 0
                }
                $('#prdThumbnail').attr('src', product.thumbnail)
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
                // Swal.fire({
                //   icon: 'success',
                //   title: 'Thành công!',
                //   text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                //   showConfirmButton: false,
                //   timer: 1500
                // });

            });
        })
        //////
        // console.log(productVariants);

        //Chọn biến thể

        document.addEventListener('DOMContentLoaded', function() {
            // === Phần xử lý nút Thêm vào giỏ hàng ===
            const addToCartButton = document.getElementById('addToCartButton');
            const addToCartForm = document.getElementById('addToCartForm'); // Lấy form ngay ở đây cho tiện
            const qtyInput = addToCartForm ? addToCartForm.querySelector('.qty-input') : null; // Lấy qty input

            // Kiểm tra sự tồn tại của các phần tử cần thiết cho Add To Cart
            if (!addToCartButton || !addToCartForm || !qtyInput) {
                console.error(
                    "LỖI: Thiếu một hoặc nhiều phần tử DOM cần thiết cho chức năng 'Thêm vào giỏ hàng' (addToCartButton, addToCartForm, .qty-input). Kiểm tra ID/class trong HTML."
                    );
                // Có thể return ở đây nếu chức năng chính của script là Add To Cart và không thể hoạt động
                // return;
            } else {
                // Thêm lắng nghe sự kiện click cho nút 'Thêm vào giỏ hàng'
                addToCartButton.addEventListener('click', function(event) {
                    // event.preventDefault(); // Giữ lại dòng này nếu bạn sẽ xử lý submit form hoặc AJAX bằng JS

                    console.log("Nút 'Thêm vào giỏ hàng' đã được click!");

                    // Lấy product_id từ Blade (đảm bảo biến $detail->id có sẵn trong Blade)
                    const productId = "{{ $detail->id }}";
                    // Lấy quantity từ input số lượng
                    const quantity = qtyInput.value;

                    // === KIỂM TRA BẮT BUỘC CHỌN BIẾN THỂ NẾU SẢN PHẨM CÓ BIẾN THỂ ===
                    // Kiểm tra xem productVariants có được định nghĩa, có phần tử (>0)
                    // VÀ biến currentVariant có đang là null hay không (chưa chọn biến thể)
                    if (typeof productVariants !== 'undefined' && productVariants.length > 0 && !
                        currentVariant) {
                        console.warn("Không thể thêm vào giỏ hàng: Vui lòng chọn một tùy chọn biến thể.");

                        // **Hiển thị thông báo lỗi cho người dùng**
                        // Sử dụng alert() là cách đơn giản nhất
                        alert(
                            'Vui lòng chọn một tùy chọn biến thể (ví dụ: Màu sắc, Kích thước) trước khi thêm vào giỏ hàng.');
                        // Nếu bạn đã tích hợp thư viện SweetAlert2, hãy dùng:
                        // Swal.fire({
                        //     icon: 'warning',
                        //     title: 'Lỗi!',
                        //     text: 'Vui lòng chọn một tùy chọn biến thể trước khi thêm vào giỏ hàng.',
                        //     confirmButtonText: 'Đồng ý'
                        // });


                        // **Ngăn chặn hành động thêm vào giỏ hàng (submit form hoặc gửi AJAX)**
                        if (event.preventDefault) {
                            event
                        .preventDefault(); // Ngăn chặn submit form mặc định nếu event là submit event
                        }
                        return; // Dừng hàm xử lý tại đây, không tiếp tục thêm vào giỏ
                    }
                    // =======================================================================

                    // Lấy productVariantId: Nếu currentVariant có giá trị, lấy id của nó; ngược lại là null.
                    // Kiểm tra này chỉ chạy nếu đã qua bước kiểm tra bắt buộc chọn biến thể (hoặc sản phẩm không có biến thể)
                    let productVariantId = currentVariant ? currentVariant.id : null;

                    // === CẬP NHẬT GIÁ TRỊ CHO CÁC INPUT HIDDEN TRONG FORM ===
                    // Đảm bảo các input hidden cần thiết tồn tại trong form addToCartForm
                    const cartProductIdInput = addToCartForm.querySelector('#cartProductId');
                    const cartProductVariantIdInput = addToCartForm.querySelector('#cartProductVariantId');
                    // const cartQuantityInput = addToCartForm.querySelector('.qty-input'); // Đã lấy qtyInput ở đầu

                    if (!cartProductIdInput || !cartProductVariantIdInput) {
                        console.error(
                            "LỖI: Không tìm thấy input hidden #cartProductId hoặc #cartProductVariantId trong form để cập nhật dữ liệu."
                            );
                        // Ngăn chặn submit nếu không tìm thấy input cần thiết
                        if (event.preventDefault) {
                            event.preventDefault();
                        }
                        return;
                    }


                    cartProductIdInput.value = productId; // Gán ID sản phẩm chính
                    // Gán ID biến thể. Nếu productVariantId là null (sản phẩm không có biến thể), gán chuỗi rỗng.
                    cartProductVariantIdInput.value = productVariantId || '';
                    // Gán quantity (mặc dù giá trị đã có trong qtyInput, gán lại để đồng bộ hóa với form)
                    // cartQuantityInput.value = quantity; // Hoặc chỉ cần đảm bảo qtyInput được lấy đúng giá trị ban đầu


                    console.log('Input form đã được cập nhật với dữ liệu:');
                    console.log('product_id:', productId);
                    console.log('product_variant_id:',
                    productVariantId); // Sẽ là null nếu không có biến thể hoặc chưa chọn (và đã qua kiểm tra bắt buộc)
                    console.log('quantity:', quantity);

                    // === Tiếp tục hành động thêm vào giỏ hàng (submit form hoặc gửi AJAX) ===
                    // Nếu bạn đã dùng event.preventDefault() ở đầu hàm click, bạn cần trigger submit form hoặc AJAX ở đây.
                    // Ví dụ: if (event.preventDefault) { addToCartForm.submit(); }
                    // Nếu không dùng event.preventDefault(), form sẽ tự submit (hành vi mặc định của button type="submit")
                    // =====================================================================

                    // ... (Swal.fire thông báo thành công nên chỉ hiển thị sau khi backend báo thêm vào giỏ hàng thành công) ...
                });
            }
            // === Hết phần xử lý nút Thêm vào giỏ hàng ===


            // === Phần xử lý chọn biến thể, cập nhật hiển thị, và tìm biến thể phù hợp ===
            const productPriceDisplay = document.getElementById('productPrice'); // Phần tử hiển thị giá sản phẩm
            const productStockElement = document.getElementById('productStock'); // Phần tử hiển thị tồn kho
            const productImageElement = document.getElementById('productImage'); // Phần tử hiển thị ảnh sản phẩm
            const variantOptions = document.querySelectorAll(
            '.option'); // Các nút/phần tử chọn tùy chọn biến thể (ví dụ: màu sắc, kích thước)

            // Kiểm tra sự tồn tại của các phần tử hiển thị thông tin sản phẩm
            if (!productPriceDisplay || !productStockElement || !productImageElement) {
                console.error(
                    "LỖI: Thiếu một hoặc nhiều phần tử DOM cần thiết để hiển thị thông tin sản phẩm (productPrice, productStock, productImage). Kiểm tra ID trong HTML."
                    );
                // Script vẫn có thể chạy phần Add To Cart nếu các phần tử này không critical cho chức năng đó
            }


            let
            selectedVariantAttributes = {}; // Đối tượng lưu trữ các thuộc tính biến thể đã được người dùng chọn. Ví dụ: { "Color": "Red", "Size": "M" }
            // Biến này cần được khai báo ở phạm vi đủ rộng (trong DOMContentLoaded) để cả click button và click option đều có thể truy cập và cập nhật nó
            let currentVariant =
            null; // Biến lưu trữ đối tượng biến thể ĐANG khớp với sự kết hợp thuộc tính mà người dùng đã chọn.

            // productVariants và isProductOnSale lấy từ Blade. Đảm bảo các biến Blade này được in ra JSON/giá trị số trước khối script này.
            // productVariants là một mảng các đối tượng biến thể, mỗi đối tượng biến thể có thuộc tính attribute_values là một mảng các thuộc tính cụ thể của biến thể đó.
            const productVariants =
            @json($detail->productVariants); // Danh sách tất cả biến thể của sản phẩm này từ Backend
            const isProductOnSale = {{ $detail->is_sale }}; // Trạng thái sale của sản phẩm chính (0 hoặc 1)

            let defaultVariant =
            null; // Biến lưu trữ biến thể mặc định (thường là biến thể có giá rẻ nhất hoặc biến thể đầu tiên nếu không có sale).

            // Tìm biến thể mặc định (rẻ nhất) và cập nhật hiển thị ban đầu khi trang tải xong
            // Chỉ thực hiện nếu sản phẩm có biến thể
            if (typeof productVariants !== 'undefined' && Array.isArray(productVariants) && productVariants.length >
                0) {
                console.log("Sản phẩm có biến thể. Số lượng biến thể:", productVariants.length);

                // **Tìm biến thể mặc định:** Logic tìm biến thể có giá (sale hoặc thường) thấp nhất. Nếu giá bằng nhau, có thể chọn biến thể đầu tiên trong danh sách.
                defaultVariant = productVariants.reduce((minVariant, current) => {
                    // Lấy giá của biến thể hiện tại (ưu tiên sale_price nếu có và isProductOnSale = 1)
                    let currentPrice = (isProductOnSale === 1 && current.sale_price !== null && current
                        .sale_price !== undefined) ? current.sale_price : current.price;

                    // Lấy giá của biến thể thấp nhất hiện tại trong quá trình reduce
                    let minPrice = minVariant ? ((isProductOnSale === 1 && minVariant.sale_price !== null &&
                            minVariant.sale_price !== undefined) ? minVariant.sale_price : minVariant
                        .price) : Infinity;

                    // So sánh giá
                    if (currentPrice < minPrice) {
                        return current; // Biến thể hiện tại có giá thấp hơn
                    } else if (currentPrice === minPrice && !minVariant) {
                        // Nếu giá bằng nhau và đây là biến thể đầu tiên được xem xét (minVariant đang null), chọn nó
                        return current;
                    }
                    // Nếu giá hiện tại lớn hơn hoặc bằng minPrice (và minVariant không null), giữ lại minVariant
                    return minVariant ||
                    current; // Trả về minVariant nếu đã tìm thấy, hoặc current nếu minVariant là null (chỉ xảy ra ở iteration đầu tiên của reduce)
                }, null); // Bắt đầu với minVariant là null


                // Nếu tìm thấy biến thể mặc định
                if (defaultVariant) {
                    console.log('Biến thể mặc định được chọn ban đầu (thường là giá rẻ nhất):', defaultVariant);

                    // Tự động "chọn" các tùy chọn thuộc tính tương ứng với biến thể mặc định trên giao diện (thêm class 'active')
                    if (typeof defaultVariant.attribute_values !== 'undefined' && Array.isArray(defaultVariant
                            .attribute_values)) {
                        defaultVariant.attribute_values.forEach(attrValue => {
                            // Đảm bảo dữ liệu thuộc tính của biến thể hợp lệ
                            if (attrValue && typeof attrValue === 'object' && attrValue.attribute &&
                                typeof attrValue.attribute.name === 'string' && typeof attrValue.value ===
                                'string') {
                                // Tìm phần tử HTML (nút option) trên trang tương ứng với thuộc tính và giá trị này
                                const optionButton = document.querySelector(
                                    `.option[data-attribute-name="${attrValue.attribute.name}"][data-attribute-value="${attrValue.value}"]`
                                );
                                if (optionButton) {
                                    // Thêm class 'active' để nó trông như được chọn
                                    optionButton.classList.add('active');
                                    // Lưu thuộc tính này vào đối tượng các thuộc tính đã chọn ban đầu
                                    selectedVariantAttributes[attrValue.attribute.name] = attrValue.value;
                                }
                            } else {
                                console.warn("Dữ liệu thuộc tính biến thể mặc định không đúng định dạng:",
                                    attrValue);
                            }
                        });
                        console.log('Các thuộc tính đã chọn ban đầu (từ biến thể mặc định):',
                            selectedVariantAttributes);

                    } else {
                        console.warn(
                            "Biến thể mặc định không có thuộc tính biến thể (attribute_values) hoặc không phải mảng."
                            );
                    }


                    updateProductDisplay(
                    defaultVariant); // Cập nhật hiển thị giá, tồn kho, ảnh dựa trên biến thể mặc định này
                    currentVariant = defaultVariant; // Gán biến thể mặc định cho biến currentVariant ban đầu
                    console.log('currentVariant được đặt là biến thể mặc định:', currentVariant);


                } else {
                    console.warn(
                        "Sản phẩm có biến thể nhưng không tìm thấy biến thể mặc định hợp lệ (có thể do dữ liệu biến thể rỗng hoặc không có cấu trúc giá hợp lệ)."
                        );
                    // Xử lý hiển thị khi không tìm thấy biến thể mặc định nếu cần (ví dụ: hiển thị giá/tồn kho sản phẩm chính)
                }
            } else {
                console.log("Sản phẩm này không có biến thể.");
                // Nếu sản phẩm không có biến thể, biến currentVariant vẫn là null
                // Bạn có thể thêm logic ở đây để đảm bảo thông tin hiển thị là của sản phẩm chính
                // và ẩn/disable các tùy chọn biến thể trên UI nếu chúng tồn tại
                // (Logic này tùy thuộc vào cấu trúc HTML và yêu cầu hiển thị của bạn)
            }


            // Thêm event listener cho các tùy chọn biến thể (khi người dùng click vào một option)
            if (variantOptions.length > 0) {
                variantOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        // Lấy tên thuộc tính (ví dụ: "Color") và giá trị (ví dụ: "Red") từ data attribute của nút được click
                        const attributeName = this.dataset.attributeName;
                        const attributeValue = this.dataset.attributeValue;

                        // Kiểm tra data attribute có tồn tại và hợp lệ không
                        if (!attributeName || !attributeValue) {
                            console.warn(
                                "Thiếu data-attribute-name hoặc data-attribute-value trên phần tử option:",
                                this);
                            return; // Bỏ qua xử lý nếu thiếu data attribute cần thiết
                        }


                        // 1. Quản lý class 'active': Xóa active class khỏi các option khác trong cùng nhóm thuộc tính
                        //closest('.select-package') giả định rằng các tùy chọn cùng một thuộc tính được bọc trong một phần tử cha có class 'select-package'
                        const attributeGroup = this.closest('.select-package');
                        if (attributeGroup) {
                            const attributeGroupOptions = attributeGroup.querySelectorAll(
                            '.option');
                            // Duyệt qua tất cả các option trong nhóm này và xóa class 'active'
                            attributeGroupOptions.forEach(opt => opt.classList.remove('active'));
                        } else {
                            console.warn("Không tìm thấy phần tử cha '.select-package' cho option:",
                                this, ". Chỉ xử lý class 'active' cho nút hiện tại.");
                            // Nếu không tìm thấy nhóm cha, chỉ xóa active trên chính nút này (không cần xóa các nút khác)
                        }

                        // 2. Thêm class 'active' vào option mà người dùng vừa click
                        this.classList.add('active');

                        // 3. Cập nhật đối tượng các thuộc tính đã chọn với lựa chọn mới nhất của người dùng
                        selectedVariantAttributes[attributeName] = attributeValue;
                        console.log('Thuộc tính biến thể đã chọn:', selectedVariantAttributes);

                        // 4. Tìm biến thể sản phẩm phù hợp trong danh sách productVariants dựa trên sự kết hợp các thuộc tính đã chọn
                        // Đảm bảo productVariants có sẵn và là mảng trước khi gọi hàm tìm kiếm
                        if (typeof productVariants !== 'undefined' && Array.isArray(
                            productVariants)) {
                            currentVariant = findMatchingVariant(selectedVariantAttributes,
                                productVariants);
                        } else {
                            console.error(
                                "Dữ liệu productVariants không khả dụng hoặc không phải là mảng khi tìm biến thể phù hợp."
                                );
                            currentVariant = null; // Reset currentVariant nếu dữ liệu biến thể lỗi
                        }


                        // 5. Cập nhật hiển thị thông tin sản phẩm dựa trên biến thể tìm được (hoặc không tìm thấy)
                        if (currentVariant) {
                            console.log('Biến thể phù hợp được tìm thấy:', currentVariant);
                            updateProductDisplay(currentVariant); // Gọi hàm cập nhật UI

                            // Cập nhật giá trị của input hidden cartProductVariantId trong form
                            // Logic này có thể nằm trong updateProductDisplay hoặc ở đây, đảm bảo nó chạy khi tìm thấy biến thể
                            if (addToCartForm) { // Kiểm tra form có tồn tại không
                                const cartProductVariantIdInput = addToCartForm.querySelector(
                                    '#cartProductVariantId');
                                if (cartProductVariantIdInput) {
                                    cartProductVariantIdInput.value = currentVariant.id;
                                    console.log(
                                        'Input cartProductVariantId đã được cập nhật với ID biến thể:',
                                        currentVariant.id);
                                } else {
                                    console.error(
                                        "Không tìm thấy input hidden #cartProductVariantId trong form để cập nhật ID biến thể."
                                        );
                                }
                            }


                        } else {
                            console.log(
                                'Không tìm thấy biến thể phù hợp với sự kết hợp thuộc tính đã chọn.'
                                );
                            // Cập nhật hiển thị khi không tìm thấy biến thể phù hợp
                            if (productStockElement) productStockElement.textContent =
                                'Không có sẵn với lựa chọn này';
                            if (productPriceDisplay) productPriceDisplay.textContent = 'Liên hệ';
                            // Có thể cần reset ảnh về ảnh sản phẩm chính hoặc hiển thị trạng thái không có ảnh biến thể
                            // (Cần có biến lưu trữ URL ảnh sản phẩm chính ban đầu)
                            // if (productImageElement) {
                            //      const mainProductThumbnail = "{{ asset('storage/' . $detail->thumbnail) }}"; // Cần lấy giá trị này từ Blade
                            //      productImageElement.src = mainProductThumbnail;
                            //      productImageElement.dataset.zoomImage = mainProductThumbnail;
                            // }


                            // Xóa giá trị của input hidden cartProductVariantId khi không tìm thấy biến thể phù hợp
                            if (addToCartForm) {
                                const cartProductVariantIdInput = addToCartForm.querySelector(
                                    '#cartProductVariantId');
                                if (cartProductVariantIdInput) {
                                    cartProductVariantIdInput.value = ''; // Xóa giá trị input
                                    console.log(
                                        'Input cartProductVariantId đã được XÓA vì không có biến thể phù hợp.'
                                        );
                                }
                            }

                        }
                    });
                });
            } else {
                console.log("Sản phẩm này không có bất kỳ tùy chọn biến thể nào để chọn.");
                // Xử lý hiển thị cho sản phẩm không có tùy chọn biến thể nếu cần (ví dụ: ẩn phần chọn biến thể)
                // (Logic này tùy thuộc vào HTML và yêu cầu)
            }


            // === Hàm hỗ trợ: Tìm biến thể phù hợp trong mảng productVariants ===
            // Dựa trên selectedAttributes (các thuộc tính đã chọn bởi người dùng)
            // selectedAttributes: { "Tên thuộc tính 1": "Giá trị 1", "Tên thuộc tính 2": "Giá trị 2", ... }
            // productVariants: Mảng các đối tượng biến thể (như từ @json($detail->productVariants))
            function findMatchingVariant(selectedAttributes, productVariants) {
                // Kiểm tra đầu vào có hợp lệ không
                if (!Array.isArray(productVariants) || typeof selectedAttributes !== 'object' ||
                    selectedAttributes === null) {
                    console.error("Dữ liệu đầu vào không hợp lệ cho hàm findMatchingVariant.");
                    return null;
                }

                const selectedAttrNames = Object.keys(
                selectedAttributes); // Lấy danh sách tên các thuộc tính đã chọn
                const selectedAttrCount = selectedAttrNames.length; // Đếm số lượng loại thuộc tính đã chọn

                // Nếu không có thuộc tính nào được chọn (ví dụ: sản phẩm không có biến thể), không tìm biến thể nào
                if (selectedAttrCount === 0) {
                    return null;
                }


                // Duyệt qua từng biến thể trong danh sách productVariants
                for (const variant of productVariants) {
                    // Kiểm tra xem đối tượng biến thể có hợp lệ và có danh sách thuộc tính không
                    if (!variant || typeof variant !== 'object' || !Array.isArray(variant.attribute_values)) {
                        // console.warn("Bỏ qua biến thể không hợp lệ trong danh sách productVariants:", variant); // Debug biến thể bị lỗi cấu trúc
                        continue; // Bỏ qua biến thể hiện tại nếu nó không đúng định dạng
                    }

                    let match =
                    true; // Biến cờ để xác định xem biến thể hiện tại có khớp hoàn toàn với các lựa chọn không
                    let matchedAttrCount = 0; // Đếm số lượng thuộc tính đã chọn khớp với biến thể hiện tại

                    // Duyệt qua từng thuộc tính mà người dùng đã chọn (ví dụ: "Color", "Size")
                    for (const attrName of selectedAttrNames) {
                        const selectedAttrValue = selectedAttributes[
                        attrName]; // Lấy giá trị đã chọn cho thuộc tính này (ví dụ: "Red", "M")

                        let variantHasAttrValue =
                        false; // Biến cờ kiểm tra biến thể hiện tại có thuộc tính 'attrName' với giá trị 'selectedAttrValue' không

                        // Duyệt qua các thuộc tính cụ thể của biến thể hiện tại (variant.attribute_values)
                        for (const variantAttrValue of variant.attribute_values) {
                            // Kiểm tra xem dữ liệu thuộc tính của biến thể có hợp lệ không
                            if (variantAttrValue && typeof variantAttrValue === 'object' && variantAttrValue
                                .attribute && typeof variantAttrValue.attribute.name === 'string' &&
                                typeof variantAttrValue.value === 'string') {
                                // So sánh tên thuộc tính và giá trị: Nếu tên thuộc tính của biến thể trùng với tên thuộc tính người dùng chọn,
                                // VÀ giá trị thuộc tính của biến thể trùng với giá trị người dùng chọn
                                if (variantAttrValue.attribute.name === attrName && variantAttrValue.value ===
                                    selectedAttrValue) {
                                    variantHasAttrValue =
                                    true; // Tìm thấy khớp cho thuộc tính 'attrName' với giá trị 'selectedAttrValue' trong biến thể này
                                    matchedAttrCount++; // Tăng số lượng thuộc tính đã khớp
                                    break; // Thoát khỏi vòng lặp thuộc tính của biến thể hiện tại, vì đã tìm thấy khớp cho 'attrName'
                                }
                            } else {
                                // console.warn("Dữ liệu thuộc tính cụ thể trong biến thể không đúng định dạng:", variantAttrValue); // Debug thuộc tính lỗi trong biến thể
                            }
                        }

                        // Nếu sau khi duyệt hết các thuộc tính của biến thể hiện tại mà KHÔNG tìm thấy khớp cho 'attrName' với giá trị 'selectedAttrValue'
                        if (!variantHasAttrValue) {
                            match =
                            false; // Biến thể hiện tại không khớp hoàn toàn với tất cả các lựa chọn của người dùng
                            break; // Thoát khỏi vòng lặp thuộc tính người dùng chọn, chuyển sang xem xét biến thể tiếp theo
                        }
                    }

                    // Kiểm tra xem biến thể hiện tại có khớp hoàn toàn hay không
                    // Biến thể khớp hoàn toàn khi tất cả các thuộc tính mà người dùng đã chọn đều tìm thấy trong biến thể đó
                    // Và số lượng thuộc tính khớp phải bằng tổng số loại thuộc tính mà người dùng đã chọn
                    if (match && matchedAttrCount === selectedAttrCount) {
                        // === Tùy chọn kiểm tra nâng cao: Đảm bảo biến thể có đủ số lượng thuộc tính tương ứng với các loại thuộc tính của sản phẩm ===
                        // Logic này có thể cần thiết nếu một biến thể có ít thuộc tính hơn các loại thuộc tính mà sản phẩm định nghĩa.
                        // Ví dụ: Sản phẩm có thuộc tính Màu sắc và Kích thước, nhưng có biến thể chỉ định Màu sắc mà không có Kích thước.
                        // Kiểm tra này phức tạp hơn và cần cấu trúc dữ liệu về các loại thuộc tính của sản phẩm chính.
                        // Tạm thời bỏ qua kiểm tra này để giữ hàm đơn giản, chỉ dựa vào việc các thuộc tính đã chọn có tồn tại trong biến thể hay không.
                        // =======================================================================================================================

                        return variant; // Trả về đối tượng biến thể đã khớp hoàn toàn
                    }
                }

                return null; // Nếu duyệt hết tất cả các biến thể mà không tìm thấy biến thể nào khớp hoàn toàn
            }
            // === Hết hàm findMatchingVariant ===


            // === Hàm hỗ trợ: Cập nhật hiển thị thông tin sản phẩm (giá, tồn kho, ảnh) trên UI ===
            // Dựa trên dữ liệu của biến thể (hoặc sản phẩm chính nếu không có biến thể)
            function updateProductDisplay(variant) {
                // Đảm bảo các phần tử DOM và đối tượng variant/product hợp lệ trước khi cập nhật
                if (!productPriceDisplay || !productStockElement || !productImageElement || !variant ||
                    typeof variant !== 'object') {
                    console.error(
                        "Không thể cập nhật hiển thị sản phẩm: Thiếu phần tử DOM hoặc dữ liệu biến thể/sản phẩm không hợp lệ."
                        );
                    return; // Dừng hàm nếu thiếu thông tin cần thiết
                }


                // Cập nhật giá: Hiển thị giá sale nếu isProductOnSale = 1 và biến thể có giá sale hợp lệ VÀ giá sale nhỏ hơn giá thường
                const currentPrice = variant.price; // Giá thường của biến thể
                const currentSalePrice = (variant.sale_price !== null && variant.sale_price !== undefined) ? variant
                    .sale_price : null; // Giá sale của biến thể

                if (isProductOnSale === 1 && currentSalePrice !== null && currentSalePrice < currentPrice) {
                    // Hiển thị giá sale và giá thường gạch ngang
                    productPriceDisplay.innerHTML = formatPrice(currentSalePrice) +
                        '  <br><del class="text-content">' + formatPrice(currentPrice) + ' </del>';
                } else {
                    // Hiển thị chỉ giá thường
                    productPriceDisplay.innerHTML = formatPrice(currentPrice) + ' đ';
                }

                // Cập nhật số lượng tồn kho: Lấy từ thuộc tính product_stock.stock của biến thể
                // Đảm bảo product_stock là object và stock là number
                if (variant.product_stock && typeof variant.product_stock === 'object' && typeof variant
                    .product_stock.stock === 'number' && variant.product_stock.stock > 0) {
                    productStockElement.textContent = 'Số lượng tồn kho: ' + variant.product_stock.stock;
                } else {
                    // Nếu không có thông tin stock, stock <= 0, hoặc cấu trúc dữ liệu sai
                    productStockElement.textContent = 'Hết hàng'; // Hoặc 'Số lượng tồn kho: 0'
                }

                // Cập nhật ảnh sản phẩm: Ưu tiên thumbnail của biến thể nếu có
                // Cần có cách để lấy URL ảnh sản phẩm chính mặc định từ Blade
                const mainProductThumbnail =
                "{{ asset('storage/' . $detail->thumbnail) }}"; // Lấy ảnh sản phẩm chính từ Blade


                if (variant.thumbnail && variant.thumbnail !== '') {
                    const variantThumbnailUrl = "{{ asset('storage/') }}/" + variant
                    .thumbnail; // Xây dựng URL ảnh biến thể
                    productImageElement.src = variantThumbnailUrl;
                    // Cập nhật cho thư viện zoom ảnh nếu đang dùng (ví dụ: data-zoom-image)
                    productImageElement.dataset.zoomImage = variantThumbnailUrl;
                } else {
                    // Nếu biến thể không có thumbnail, sử dụng ảnh sản phẩm chính mặc định
                    productImageElement.src = mainProductThumbnail;
                    productImageElement.dataset.zoomImage = mainProductThumbnail;
                }

                // TODO: Cập nhật các thông tin khác của sản phẩm nếu cần, ví dụ: mã SKU biến thể, mô tả ngắn biến thể (nếu có trong dữ liệu variant)
                // console.log("Biến thể hiện tại:", variant); // Dùng log để xem các thông tin khác có sẵn trong đối tượng variant
            }
            // === Hết hàm updateProductDisplay ===


            // === Hàm hỗ trợ: Format số tiền theo định dạng Việt Nam (ví dụ: 1.000.000) ===
            // function formatPrice(price) {
            //     // Kiểm tra xem giá trị có phải là số hợp lệ không
            //     if (typeof price !== 'number' || isNaN(price)) {
            //         console.warn("Giá trị không phải số hợp lệ khi formatPrice:", price);
            //         return price; // Trả về giá trị gốc nếu không phải số hoặc NaN
            //     }
            //     // Sử dụng Intl.NumberFormat để format số
            //     return new Intl.NumberFormat('vi-VN').format(price);
            // }
            // === Hết hàm formatPrice ===


        }); // Kết thúc DOMContentLoaded. Tất cả code bên trong sẽ chạy khi DOM đã sẵn sàng.

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

        // end document


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
                    let promotionMessage = "Nhanh lên! Khuyến mại kết thúc sau";

                    if (now < startTime) {
                        targetTime = startTime;
                        promotionMessage = "Khuyến mại bắt đầu sau";
                    } else if (now >= endTime) {
                        timerContainer.innerHTML =
                            "<div class='my-timer-product-title'><h4 class='my-timer-promotion-ended'>Khuyến mại đã kết thúc!</h4></div>";
                        return;
                    } else {
                        targetTime = endTime;
                        promotionMessage = "Nhanh lên! Khuyến mại kết thúc sau";
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
                                        "Nhanh lên! Khuyến mại kết thúc sau";
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

        $(document).ready(function() {
            // Lấy danh sách sản phẩm trong wishlist từ Local Storage (nếu có)
            let wishlistProductIds = JSON.parse(localStorage.getItem('wishlistProductIds')) || [];

            // Cập nhật màu của icon wishlist khi tải lại trang
            $('.wishlist-toggle').each(function() {
                let productId = $(this).data('product-id');
                let icon = $(this).find('.wishlist-icon');

                if (wishlistProductIds.includes(productId)) {
                    icon.css('color', 'red'); // Giữ màu đỏ nếu sản phẩm đã trong wishlist
                } else {
                    icon.css('color', 'black');
                }
            });

            // Xử lý khi click vào nút wishlist
            $(document).on('click', '.wishlist-toggle', function(e) {
                e.preventDefault();

                var productId = $(this).data('product-id'); // Lấy product ID
                var icon = $(this).find('.wishlist-icon'); // Lấy icon trong phần tử hiện tại

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
                                wishlistProductIds.push(productId); // Thêm vào danh sách
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã thêm!',
                                    text: 'Sản phẩm đã được thêm vào danh sách yêu thích!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else if (data.action === 'removed') {
                                icon.css('color', 'black'); // Đổi màu khi xóa khỏi wishlist
                                wishlistProductIds = wishlistProductIds.filter(id => id !==
                                    productId); // Xóa khỏi danh sách
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã xóa!',
                                    text: 'Sản phẩm đã bị xóa khỏi danh sách yêu thích!',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                            // Lưu danh sách mới vào Local Storage
                            localStorage.setItem('wishlistProductIds', JSON.stringify(
                                wishlistProductIds));
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: data.message ||
                                    'Có lỗi xảy ra, vui lòng thử lại!',
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Chưa đăng nhập!',
                                text: 'Bạn cần đăng nhập để thực hiện thao tác này!',
                                confirmButtonText: 'Đăng nhập'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/login';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra, vui lòng thử lại!',
                            });
                        }
                    }
                });
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

    <!-- Sticky-bar js -->
    <script src="{{ asset('theme/client/assets/js/sticky-cart-bottom.js') }}"></script>
@endpush
