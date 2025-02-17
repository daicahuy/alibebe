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
                                    <a href="{{ route('categories', $item->id) }}">
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
                                                                        class="number">({{ $item->child_products_count + $item->products_count }})</span>
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
                                                        <input type="number" class="form-control" id="min_price"
                                                            name="min_price" placeholder="Giá tối thiểu"
                                                            value="{{ $currentFilters['min_price'] ?? '' }}">
                                                    </div>
                                                    <div class="price-input">
                                                        <label for="max_price">Giá đến:</label>
                                                        <input type="number" class="form-control" id="max_price"
                                                            name="max_price" placeholder="Giá tối đa"
                                                            value="{{ $currentFilters['max_price'] ?? '' }}">
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
                                                                            class="number">({{ $attrValue->product_variants_count }})</span>
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
                                            <a href="product-left-thumbnail.html">
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
                                            @if ($item->categories)
                                                @foreach ($item->categories as $cate)
                                                    <span class="span-name">{{ $cate->name }}</span>
                                                @endforeach
                                            @endif
                                            <a href="{{ route('categories', $item->id) }}">
                                                <h5 class="name">{{ $item->name }}</h5>
                                            </a>
                                            <p class="text-content mt-1 mb-2 product-content">
                                                {{ $item->short_description }}</p>
                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    @if ($item->reviews)
                                                        @foreach ($item->reviews as $review)
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <li>
                                                                    @if ($i < $review->rating)
                                                                        <i data-feather="star" class="fill"></i>
                                                                    @else
                                                                        <i data-feather="star"></i>
                                                                    @endif
                                                                </li>
                                                            @endfor
                                                            <span>({{ $review->rating }})</span>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <h6 class="unit">{{ $item->views }} lượt xem</h6>
                                            <h5 class="price"><span
                                                    class="theme-color">{{ number_format($item->price) }}đ</span>
                                                @if ($item->sale_price)
                                                    <del>{{ number_format($item->sale_price) }}đ</del>
                                                @endif
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <button class="btn btn-add-cart addcart-button">Add
                                                    <span class="add-icon bg-light-gray">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </span>
                                                </button>
                                                <div class="cart_qty qty-box">
                                                    <div class="input-group bg-white">
                                                        <button type="button" class="qty-left-minus bg-gray"
                                                            data-type="minus" data-field="">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <input class="form-control input-number qty-input" type="text"
                                                            name="quantity" value="0">
                                                        <button type="button" class="qty-right-plus bg-gray"
                                                            data-type="plus" data-field="">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
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
    <!-- Price Range Js -->
    <script src="{{ asset('theme/admin/assets/js/ion.rangeSlider.min.js') }}"></script>

    <!-- sidebar open js -->
    <script src="{{ asset('theme/admin/assets/js/filter-sidebar.js') }}"></script>

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
