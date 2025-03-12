@extends('client.layouts.master')

@section('content')

    <!-- Breadcrumb Section Start -->
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Danh sách danh mục</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Danh sách danh mục</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Category Section Start -->
    <section class="wow fadeInUp">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="slider-7_1 no-space shop-box no-arrow">
                        {{-- menu category --}}

                        @foreach ($listParentCategories as $item)
                            <div>
                                <div class="shop-category-box">
                                    <a href="{{ route('categories', $item->slug) }}">
                                        <div class="shop-category-image">
                                            <img src="{{ Storage::url($item->icon) }}" class="blur-up lazyload"
                                                alt="">
                                        </div>
                                        <div class="category-box-name">
                                            <h6>{{ $item->name }}</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Category Section End -->

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                {{-- Filter --}}
                <div class="col-custom-3 wow fadeInUp">
                    <div class="left-box">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                            </div>

                            <form action="{{ route('categories') }}" method="GET" id="filter-form">
                                <div class="accordion custom-accordion" id="accordionExample">
                                    {{-- Categories --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne">
                                                <span>Categories</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show">
                                            <div class="accordion-body">

                                                {{-- search --}}
                                                <div class="form-floating theme-form-floating-2 search-box">
                                                    <input type="search" class="form-control" id="search-category"
                                                        name='search' placeholder="Search .."
                                                        value="{{ $currentFilters['search'] ?? '' }}">
                                                    <label for="search-category">Search</label>
                                                </div>

                                                <ul class="category-list custom-padding custom-height">
                                                    @foreach ($listParentCategories as $item)
                                                        <li>
                                                            <div class="form-check ps-0 m-0 category-list-box">
                                                                <input class="checkbox_animated" type="checkbox"
                                                                    name='category[]' value="{{ $item->id }}"
                                                                    id="category-{{ $item->id }}"
                                                                    {{ in_array($item->id, $currentFilters['category'] ?? []) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="category-{{ $item->id }}">
                                                                    <span class="name">{{ $item->name }}</span>
                                                                    <span
                                                                        class="number">({{ $item->products_count }})</span>
                                                                    {{-- $item->child_products_count +$item->products_count --}}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Search Price Range --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                <span>Price</span>
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <div class="price-range-inputs">
                                                    <div class="price-input">
                                                        <label for="min_price">Giá từ:</label>
                                                        <input type="number"
                                                            class="form-control @error('min_price') is-invalid @enderror"
                                                            id="min_price" name="min_price" placeholder="Giá tối thiểu"
                                                            value="{{ $currentFilters['min_price'] ?? '' }}">
                                                        <div class="invalid-feedback">
                                                            @error('min_price')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="price-input">
                                                        <label for="max_price">Giá đến:</label>
                                                        <input type="number"
                                                            class="form-control @error('max_price') is-invalid @enderror"
                                                            id="max_price" name="max_price" placeholder="Giá tối đa"
                                                            value="{{ $currentFilters['max_price'] ?? '' }}">
                                                        <div class="invalid-feedback">
                                                            @error('max_price')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <style>
                                        .price-range-inputs {
                                            display: flex;
                                            gap: 10px;
                                            /* Khoảng cách giữa hai ô input */
                                        }

                                        .price-input {
                                            flex: 1;
                                            /* Chia đều không gian cho cả hai ô input */
                                        }

                                        .price-input label {
                                            display: block;
                                            /* Label hiển thị trên ô input */
                                            margin-bottom: 5px;
                                            font-weight: bold;
                                            /* Làm đậm label (tùy chọn) */
                                        }
                                    </style>

                                    {{-- rating --}}
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                                <span>Rating</span>
                                            </button>
                                        </h2>
                                        <div id="collapseSix" class="accordion-collapse collapse show">
                                            <div class="accordion-body">

                                                <ul class="category-list custom-padding">
                                                    @foreach ($listStar as $start)
                                                        <li>
                                                            <div class="form-check ps-0 m-0 category-list-box">
                                                                <input class="checkbox_animated" type="checkbox"
                                                                    id="rating-{{ $start->rating }}" name="rating[]"
                                                                    value="{{ $start->rating }}"
                                                                    {{ in_array($start->rating, $currentFilters['rating'] ?? []) ? 'checked' : '' }}>
                                                                <div class="form-check-label">
                                                                    <ul class="rating">

                                                                        @for ($i = 0; $i < 5; $i++)
                                                                            <li>
                                                                                @if ($i < $start->rating)
                                                                                    <i data-feather="star"
                                                                                        class="fill"></i>
                                                                                @else
                                                                                    <i data-feather="star"></i>
                                                                                @endif
                                                                            </li>
                                                                        @endfor

                                                                    </ul>
                                                                    <span class="text-content">({{ $start->rating }}
                                                                        Start)</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach



                                                </ul>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Thuộc tính biến thể --}}
                                    @foreach ($listVariantAttributes as $attrName => $attrValues)
                                        {{-- @if ($attrName == 'Màu sắc') --}}
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="panelsStayOpen-heading{{ $loop->index }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $loop->index }}">
                                                    <span>{{ $attrName }}</span>
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $loop->index }}"
                                                class="accordion-collapse collapse show">
                                                <div class="accordion-body">

                                                    <ul class="category-list custom-padding custom-height">
                                                        @foreach ($attrValues as $attrValue)
                                                            <li>
                                                                <div class="form-check ps-0 m-0 category-list-box">
                                                                    @php
                                                                        $slug = optional($attrValue->attribute)->slug;
                                                                        $checked =
                                                                            isset($currentFilters[$slug]) &&
                                                                            in_array(
                                                                                $attrValue->value,
                                                                                $currentFilters[$slug],
                                                                            ); // Kiểm tra giá trị trong $currentFilters[$slug]
                                                                    @endphp
                                                                    <input class="checkbox_animated" type="checkbox"
                                                                        id="{{ $slug }}-{{ Str::slug($attrValue->value) }}"
                                                                        name="{{ $slug }}[]"
                                                                        value="{{ $attrValue->value }}"
                                                                        @if ($checked) checked @endif>
                                                                    <label class="form-check-label"
                                                                        for="{{ $slug }}-{{ Str::slug($attrValue->value) }}">
                                                                        <span
                                                                            class="name">{{ $attrValue->value }}</span>
                                                                        <span
                                                                            class="number">({{ $attrValue->product_count }})</span>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
                                    @endforeach
                                    {{-- <button type="submit" class="btn btn-primary filter-button">Lọc sản phẩm</button> --}}
                                    <button class="btn btn-animation w-100 justify-content-center filter-button"
                                        type="submit">Lọc sản phẩm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sotr By --}}
                <div class="col-custom- wow fadeInUp">
                    <div class="show-button">
                        {{-- <div class="filter-button-group mt-0">
                            <div class="filter-button d-inline-block d-lg-none">
                                <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                            </div>
                        </div> --}}

                        <div class="top-filter-menu">
                            <div class="category-dropdown">
                                <h5 class="text-content">Sắp xếp :</h5>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown">
                                        <span>
                                            @if ($sortBy == 'default')
                                                Tất cả sản phẩm
                                            @elseif($sortBy == 'low')
                                                Giá thấp - cao
                                            @elseif($sortBy == 'high')
                                                Giá cao - thấp
                                            @elseif($sortBy == 'aToz')
                                                Theo tên A - Z
                                            @elseif($sortBy == 'zToa')
                                                Theo tên Z - A
                                            @elseif($sortBy == 'rating')
                                                Đánh giá trung bình
                                            @elseif($sortBy == 'manyViews')
                                                Xem nhiều
                                            @elseif($sortBy == 'sellWell')
                                                Bán chạy
                                            @endif
                                        </span> <i class="fa-solid fa-angle-down"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" id="default"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'default']) }}">Tất cả
                                                sản
                                                phẩm</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="low"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'low']) }}">Giá thấp -
                                                cao</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="high"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'high']) }}">Giá cao -
                                                thấp</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="rating"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'rating']) }}">Đánh giá
                                                trung bình</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="aToz"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'aToz']) }}">Theo tên A
                                                - Z</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="zToa"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'zToa']) }}">Theo tên Z
                                                - A
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="manyViews"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'manyViews']) }}">Xem
                                                nhiều
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" id="sellWell"
                                                href="{{ request()->fullUrlWithQuery(['sort_by' => 'sellWell']) }}">Bán
                                                chạy
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="grid-option d-none d-md-block">
                                <ul>
                                    <li class="three-grid">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('theme/client/assets/svg/grid-3.svg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li class="grid-btn d-xxl-inline-block d-none active">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('theme/client/assets/svg/grid-4.svg') }}"
                                                class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                            <img src="{{ asset('theme/client/assets/svg/grid.svg') }}"
                                                class="blur-up lazyload img-fluid d-lg-none d-inline-block"
                                                alt="">
                                        </a>
                                    </li>
                                    <li class="list-btn">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('theme/client/assets/svg/list.svg') }}"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        {{-- products --}}
                        @foreach ($listProductCate as $item)
                            <div>
                                <div class="product-box-3 h-100 wow fadeInUp">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="{{ route('products', $item->id) }}">
                                                <img src="{{ Storage::url($item->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>

                                            <ul class="product-option">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#view" data-id={{ $item->id }}>
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="So sánh">
                                                    <a href="javascript:;" class="compare-toggle" data-state="unselected"
                                                        data-product-id="{{ $item->id }}"
                                                        data-product-category-id="{{ $item->categories->first()->id ?? null }}">
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
                                                        data-product-id="{{ $item->id }}">
                                                        <i data-feather="heart" class="wishlist-icon"
                                                            style="color: {{ in_array($item->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-footer">
                                        <div class="product-detail">
                                            {{-- @if ($item->categories)
                                                @foreach ($item->categories as $cate)
                                                    <span class="span-name">{{ $cate->name }}</span>
                                                @endforeach
                                            @endif --}}
                                            @if ($item->categories->isNotEmpty())
                                                {{ $item->categories->pluck('name')->implode(', ') }}
                                            @else
                                                <span class="text-muted">Không có danh mục</span>
                                            @endif
                                            <a href="{{ route('products', $item->id) }}">
                                                <h5 class="name">{{ $item->name }}</h5>
                                            </a>
                                            <p class="text-content mt-1 mb-2 product-content">
                                                {!! $item->short_description !!}</p>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    @php
                                                        $avgRating = $item->reviews->avg('rating');
                                                        $roundedRating = floor($avgRating); //làm tròn xuống
                                                    @endphp
                                                    @empty($item->reviews)
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        @endfor
                                                        <span>(0)</span>
                                                    @else
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <li>
                                                                @if ($i <= $roundedRating)
                                                                    <i data-feather="star" class="fill"></i>
                                                                @else
                                                                    <i data-feather="star"></i>
                                                                @endif
                                                            </li>
                                                        @endfor
                                                        <span>({{ number_format($avgRating, 1) }})</span>
                                                    @endempty
                                                </ul>
                                            </div>
                                            <h6 class="unit">{{ $item->views }} lượt xem</h6>
                                            {{-- <h6 class="unit">{{ $item->sold_count ?? 0 }} đã bán</h6> --}}
                                            <h6 class="unit">{{ $item->getSoldQuantity() }} đã bán</h6>

                                            <h5 class="price">
                                                <span
                                                    class="theme-color">{{ number_format($item->display_price) }}đ</span>
                                                {{-- Kiểm tra is_sale thay vì sale_price --}}
                                                @if ($item->is_sale == 1)
                                                    <del>{{ number_format($item->original_price) }}đ</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#view" data-id={{ $item->id }}
                                                    class="btn btn-add-cart addcart-button">
                                                    Thêm vào giỏ hàng
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>

                    <!-- Phân trang -->
                    <nav class="custom-pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Nút Previous -->
                            <li class="page-item {{ $listProductCate->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $listProductCate->previousPageUrl() }}" tabindex="-1">
                                    <i class="fa-solid fa-angles-left"></i>
                                </a>
                            </li>

                            <!-- Hiển thị các trang xung quanh trang hiện tại -->
                            @php
                                $currentPage = $listProductCate->currentPage();
                                $lastPage = $listProductCate->lastPage();
                                $startPage = max($currentPage - 2, 1); // Bắt đầu = hiện tại - 2
                                $endPage = min($currentPage + 2, $lastPage); // Kết thúc = hiện tại + 2
                            @endphp

                            <!-- Hiển thị trang đầu tiên nếu không nằm trong khoảng hiển thị -->
                            @if ($startPage > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $listProductCate->url(1) }}">1</a>
                                </li>
                                @if ($startPage > 2)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                            @endif

                            <!-- Hiển thị các trang trong khoảng -->
                            @for ($page = $startPage; $page <= $endPage; $page++)
                                <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                    <a class="page-link"
                                        href="{{ $listProductCate->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor

                            <!-- Hiển thị trang cuối cùng nếu không nằm trong khoảng hiển thị -->
                            @if ($endPage < $lastPage)
                                @if ($endPage < $lastPage - 1)
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $listProductCate->url($lastPage) }}">{{ $lastPage }}</a>
                                </li>
                            @endif

                            <!-- Nút Next -->
                            <li class="page-item {{ $listProductCate->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $listProductCate->nextPageUrl() }}">
                                    <i class="fa-solid fa-angles-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->


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
                                    <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" id="cartProductId">
                                        <input type="hidden" name="product_variant_id" id="cartProductVariantId">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-md add-cart-button icon">Thêm vào giỏ
                                            hàng</button>
                                    </form>
                                    <button class="btn theme-bg-color view-button icon text-white fw-bold btn-md detail-product-button">
                                        View More Details
                                    </button>
                                    {{-- <a href="{{ route('products', $listProductCate) }}" class="btn theme-bg-color view-button icon text-white fw-bold btn-md">Chi tiết sản phẩm</a> --}}
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
    <!-- Price Range Js -->
    <script src="{{ asset('theme/admin/assets/js/ion.rangeSlider.min.js') }}"></script>

    <!-- sidebar open js -->
    <script src="{{ asset('theme/admin/assets/js/filter-sidebar.js') }}"></script>

    <script>
        // Hàm định dạng giá tiền sang VNĐ
        function formatPrice(price) {
            const number = parseFloat(price);
            return isNaN(number) ? "0 đ" : number.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }

        $(document).ready(function() {
            $('.detail-product-button').click(function() {
            const productId = $('#view').data('product-id');

            if (productId) {
                const productDetailUrl = "{{ route('products', ['product' => ':productId']) }}".replace(':productId', productId);
                location.href = productDetailUrl;
            } else {
                console.error("Không tìm thấy product_id...");
                alert("Lỗi:...");
            }
        });
            // Thông báo alert (giữ nguyên)
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

            // Khai báo biến toàn cục để lưu trữ variantMap
            let globalVariantMap = {};

            $('a[data-bs-target="#view"]').click(function() {
                const productId = $(this).data('id');
                $('#view').data('product-id', productId);
                $('#cartProductId').val(productId);

                $.ajax({
                    url: '/api/productListCate/' + productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Cập nhật thông tin cơ bản của sản phẩm
                        $('#prdName').text(response.name);
                        $('#prdDescription').html(response.short_description);
                        $('#prdBrand').text(response.brand);
                        $('#prdCategories').text(response.categories);

                        // Xử lý rating
                        const avgRating = response.avgRating || 0;
                        $('#prdRating ul.rating').html(
                            Array.from({
                                    length: 5
                                }, (_, i) =>
                                `<li><i data-feather="star" class="${i < avgRating ? 'fill' : ''}"></i></li>`
                            ).join('')
                        );
                        feather.replace();

                        // Đã bán
                        $('#prdSoldCount').text(`Đã bán (${response.sold_count})`);

                        // Xử lý biến thể sản phẩm
                        const variants = response.productVariants || [];
                        console.log("response.productVariants from service:", response
                            .productVariants); // In ra toàn bộ mảng productVariants

                        $('#productVariants').empty();

                        // Lọc các biến thể active
                        const activeVariants = variants.filter(variant => variant.is_active ===
                            1);

                        if (activeVariants.length > 0) {
                            // Cập nhật globalVariantMap với các biến thể active
                            activeVariants.forEach(variant => {
                                const key = variant.attribute_values
                                    .map(attr => attr.id)
                                    .sort((a, b) => a - b)
                                    .join('-');
                                globalVariantMap[key] = {
                                    id: variant.id,
                                    price: variant.price,
                                    thumbnail: variant.thumbnail,
                                    product_stock: variant.product_stock,
                                    is_sale: variant.is_sale || 0,
                                    sale_price: variant.sale_price || 0,
                                    display_price: variant.display_price || variant
                                        .price,
                                    original_price: variant.original_price ||
                                        variant.price,
                                    sold_count: variant.sold_count,
                                };
                            });
                            console.log("Global Variant Map updated:", globalVariantMap);

                            // Tạo map thuộc tính từ các biến thể active
                            const attributes = {};
                            activeVariants.forEach(variant => {
                                variant.attribute_values.forEach(attr => {
                                    const attrSlug = attr.attributes_slug;
                                    if (!attributes[attrSlug]) {
                                        attributes[attrSlug] = new Map();
                                    }
                                    attributes[attrSlug].set(attr.id, attr
                                        .attribute_value);
                                });
                            });

                            // Tạo HTML cho dropdown thuộc tính
                            let attributesHtml = '';
                            Object.entries(attributes).forEach(([attrSlug, valuesMap]) => {
                                let sampleAttrValue = activeVariants.reduce((found,
                                    variant) => {
                                    return found || variant.attribute_values
                                        .find(av => av.attributes_slug ===
                                            attrSlug);
                                }, null);

                                attributesHtml += `
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>${sampleAttrValue ? sampleAttrValue.attributes_name : attrSlug.split('-').join(' ')}</label>
                                            <select class="form-control variant-attribute" data-attribute="${attrSlug}">
                                                ${Array.from(valuesMap).map(([id, value]) =>
                                                    `<option value="${id}">${value}</option>`
                                                ).join('')}
                                            </select>
                                        </div>
                                    </div>
                                `;
                            });
                            $('#productVariants').html(
                                `<div class="row">${attributesHtml}</div>`);

                            // Tìm biến thể giá thấp nhất từ activeVariants
                            const lowestVariant = activeVariants.reduce((prev, curr) => {
                                const prevDisplayPrice = prev.is_sale && prev
                                    .display_price ? prev.display_price : prev
                                    .original_price;
                                const currDisplayPrice = curr.is_sale && curr
                                    .display_price ? curr.display_price : curr
                                    .original_price;
                                return parseFloat(prevDisplayPrice) < parseFloat(
                                    currDisplayPrice) ? prev : curr;
                            });

                            // Cập nhật thông tin ban đầu
                            updateProductInfo(lowestVariant, response.is_sale);
                            setSelectedAttributes(lowestVariant.attribute_values);
                            updateStockInfo(lowestVariant);
                            $('#cartProductVariantId').val(lowestVariant.id);

                            // Xử lý sự kiện thay đổi dropdown
                            $('.variant-attribute').change(function() {
                                const selectedValues = getSelectedAttributes();
                                const variantKey = selectedValues.sort((a, b) => a - b)
                                    .join('-');
                                const variant = globalVariantMap[variantKey];
                                // **THÊM console.log ĐỂ KIỂM TRA variant TRONG CHANGE EVENT**
                                console.log("change event - variantKey:",
                                    variantKey); // In ra variantKey
                                console.log("change event - variant:",
                                    variant); // In ra object variant tìm được
                                if (variant) {
                                    $('#cartProductVariantId').val(variant.id);
                                    updateProductInfo(variant, response.is_sale);
                                    updateStockInfo(variant);
                                    // **XOÁ thông báo lỗi (nếu có) khi tìm thấy variant**
                                    $('#variant-not-found-message')
                                        .hide(); // Ẩn thông báo lỗi
                                } else {
                                    console.log("Không tìm thấy biến thể cho key:",
                                        variantKey);
                                    $('#cartProductVariantId').val('');
                                    // **HIỂN THỊ thông báo lỗi khi không tìm thấy variant**
                                    $('#prdPrice').html(
                                        '<p class="text-danger" id="variant-not-found-message">Biến thể không có sẵn</p>'
                                    ); // Hiển thị thông báo lỗi ở khu vực giá
                                    $('.product-stock span').text(
                                        ''); // Xóa thông tin kho
                                    $('#prdSoldCount').text(''); // Xóa thông tin đã bán
                                }
                            });
                        } else {
                            // Xử lý khi không có biến thể active
                            let priceHtml;
                            if (response.is_sale && response.display_price) {
                                priceHtml =
                                    `${formatPrice(response.display_price)} <small><del>${formatPrice(response.original_price)}</del></small>`;
                            } else {
                                priceHtml = formatPrice(response.original_price || 0);
                            }
                            $('#prdPrice').html(priceHtml);
                            $('#prdThumbnail').attr('src', response.thumbnail ||
                                '/path/to/default-image.jpg');
                            $('.product-stock span').text(`Kho: ${response.stock || 0}`);
                            $('#cartProductVariantId').val('');
                        }
                    },
                    error: () => alert('Không tìm thấy sản phẩm')
                });
            });

            // Hàm cập nhật giá và thumbnail
            function updateProductInfo(variant, isSale) {
                let priceHtml;
                const isVariantOnSale = isSale && variant.display_price && variant.original_price && parseFloat(
                    variant.display_price) < parseFloat(variant.original_price);
                if (isVariantOnSale) {
                    priceHtml =
                        `${formatPrice(variant.display_price)} <small><del>${formatPrice(variant.original_price)}</del></small>`;
                } else {
                    priceHtml = formatPrice(variant.original_price || 0);
                }
                $('#prdPrice').html(priceHtml);
                $('#prdThumbnail').attr('src', variant.thumbnail);
            }

            // Hàm chọn giá trị thuộc tính trong dropdown
            function setSelectedAttributes(attributes) {
                attributes.forEach(attr => {
                    const attrSlug = attr.attributes_slug;
                    $(`select[data-attribute="${attrSlug}"]`).val(attr.id);
                });
            }

            // Hàm lấy các giá trị thuộc tính đã chọn
            function getSelectedAttributes() {
                const selected = [];
                $('.variant-attribute').each(function() {
                    const val = $(this).val();
                    if (val) selected.push(val);
                });
                return selected;
            }

            // Hàm cập nhật thông tin kho
            function updateStockInfo(variant) {
                if (variant) { // **KIỂM TRA variant CÓ TỒN TẠI**
                    const stock = variant.product_stock ? variant.product_stock.stock : 0;
                    $('.product-stock span').text(`Kho: ${stock}`);
                    // **THÊM console.log ĐỂ KIỂM TRA variant.sold_count**
                    console.log("updateStockInfo - variant:", variant); // In ra toàn bộ object variant
                    console.log("updateStockInfo - variant.sold_count:", variant
                        .sold_count); // In ra giá trị sold_count
                    $('#prdSoldCount').text(`Đã bán biến thể (${variant.sold_count || 0})`);
                } else {
                    $('.product-stock span').text(''); // Xóa thông tin kho khi không có variant
                    $('#prdSoldCount').text(''); // Xóa thông tin đã bán khi không có variant
                }
            }

            // Thêm vào giỏ hàng
            $('.add-cart-button').click(function() {
                const productId = $('#view').data('product-id');
                const hasVariants = $('#productVariants .variant-attribute').length > 0;
                let cartData;

                if (hasVariants) {
                    const selectedValues = getSelectedAttributes();
                    const variantKey = selectedValues.sort((a, b) => a - b).join('-');
                    const selectedVariant = globalVariantMap[variantKey];
                    if (!selectedVariant) {
                        alert('Vui lòng chọn đầy đủ thuộc tính sản phẩm');
                        return;
                    }
                    cartData = {
                        product_id: productId,
                        product_variant_id: selectedVariant.id,
                        quantity: 1
                    };
                } else {
                    cartData = {
                        product_id: productId,
                        quantity: 1
                    };
                }
                this.submit();
            }); // end modal-addToCard


            
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

            
        }); // end document



        // wish list - của Bảo
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
@endpush
