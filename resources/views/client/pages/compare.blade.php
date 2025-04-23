@extends('client.layouts.master')

@section('content')
    <!-- Breadcrumb Section Start -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2 class="mb-2">Compare</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Shop</li>
                                <li class="breadcrumb-item active">Compare</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Compare Section Start -->
    <section class="compare-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table compare-table">
                            <tbody>
                                <tr>
                                    <th>Tên</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <a class="text-title"
                                                href="{{ route('products', $product['slug']) }}">{{ $product['name'] }}</a>
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th>Hình ảnh</th>

                                    @foreach ($productsData as $product)
                                        <td>
                                            <a href="{{ route('products', $product['slug']) }}">
                                                <img src="{{ $product['thumbnail'] }}" class="img-fluid blur-up lazyload"
                                                    alt="">
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                                {{-- Thông số kĩ thuật --}}
                                @php
                                    $allSpecificationNames = collect($productsData)
                                        ->pluck('specifications')
                                        ->map(function ($specs) {
                                            return array_keys($specs);
                                        })
                                        ->flatten()
                                        ->unique();
                                @endphp
                                @foreach ($allSpecificationNames as $specName)
                                    <tr>
                                        <th>{{ $specName }}</th>
                                        @foreach ($productsData as $product)
                                            <td class="text-content">{{ $product['specifications'][$specName] ?? 'X' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach{{-- End TSKT --}}


                                {{-- Thuộc tính biến thể --}}
                                @if (collect($productsData)->contains(function ($product) {
                                        return !empty($product['variant_attributes']);
                                    }))
                                    <tr>
                                        <th>Thuộc tính biến thể</th>
                                        <td colspan="{{ count($productsData) }}"></td> {{-- Cột tiêu đề thuộc tính biến thể sẽ trải dài --}}
                                    </tr>

                                    @php
                                        $allVariantAttributeNames = collect($productsData)
                                            ->pluck('variant_attributes')
                                            ->filter()
                                            ->flatten(1)
                                            ->map(function ($variantAttributeSet) {
                                                return array_keys($variantAttributeSet);
                                            })
                                            ->flatten()
                                            ->unique()
                                            ->values();
                                    @endphp

                                    @foreach ($allVariantAttributeNames as $variantAttributeName)
                                        {{-- **KIỂM TRA: Nếu KHÔNG PHẢI tất cả sản phẩm đều thiếu thuộc tính này thì HIỂN THỊ hàng** --}}
                                        @if (
                                            !collect($productsData)->every(function ($product) use ($variantAttributeName) {
                                                return empty($product['variant_attributes']) ||
                                                    !collect($product['variant_attributes'])->contains(function ($attributeSet) use ($variantAttributeName) {
                                                        return array_key_exists($variantAttributeName, $attributeSet);
                                                    });
                                            }))
                                            <tr>
                                                <th>{{ $variantAttributeName }}</th>
                                                @foreach ($productsData as $product)
                                                    <td class="text-content">
                                                        @if ($product['variant_attributes'])
                                                            @php
                                                                $variantAttributeValues = collect(
                                                                    $product['variant_attributes'],
                                                                )
                                                                    ->map(function ($variantAttributeSet) use (
                                                                        $variantAttributeName,
                                                                    ) {
                                                                        return $variantAttributeSet[
                                                                            $variantAttributeName
                                                                        ] ?? null;
                                                                    })
                                                                    ->filter()
                                                                    ->unique()
                                                                    ->implode(' | ');
                                                            @endphp
                                                            {{ $variantAttributeValues ?: 'X' }}
                                                        @else
                                                            X
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endif {{-- END IF: Không phải tất cả sản phẩm đều thiếu thuộc tính --}}
                                    @endforeach
                                @endif{{-- end biến thể --}}


                                <tr>
                                    <th>Price</th>
                                    @foreach ($productsData as $product)
                                        <td class="price text-content">
                                            @if ($product['type'] == 1)
                                                @if ($product['is_sale'] && $product['min_variant_sale_price'] !== null)
                                                    <del>
                                                        @if ($product['min_variant_price'] != $product['max_variant_price'])
                                                            {{ $product['min_variant_price'] }} -
                                                            {{ $product['max_variant_price'] }}đ
                                                        @else
                                                            {{ $product['min_variant_price'] }}đ
                                                        @endif
                                                    </del><br>
                                                    <span class="theme-color">
                                                        @if ($product['min_variant_sale_price'] != $product['max_variant_sale_price'])
                                                            {{ $product['min_variant_sale_price'] }} -
                                                            {{ $product['max_variant_sale_price'] }}đ
                                                        @else
                                                            {{ $product['min_variant_sale_price'] }}đ
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="theme-color">
                                                        @if ($product['min_variant_price'] != $product['max_variant_price'])
                                                            {{ $product['min_variant_price'] }} -
                                                            {{ $product['max_variant_price'] }}đ
                                                        @else
                                                            {{ $product['min_variant_price'] }}đ
                                                        @endif
                                                    </span>
                                                @endif
                                            @else
                                                @if ($product['is_sale'] && $product['sale_price'] !== null)
                                                    <del>{{ $product['price'] }}đ</del><br>
                                                    <span class="theme-color"> {{ $product['sale_price'] }}đ </span>
                                                @else
                                                    <span class="theme-color"> {{ $product['price'] }}đ </span>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                {{-- stock --}}
                                {{-- <tr>
                                    <th>Availability</th>
                                    <td class="text-content">In Stock</td>
                                    <td class="text-content">In Stock</td>
                                    <td class="text-content">In Stock</td>

                                </tr> --}}

                                {{-- rating --}}
                                {{-- <tr>
                                    <th>Rating</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <div class="compare-rating">
                                                <ul class="rating">
                                                    @for ($i = 0; $i < floor($product['rating']); $i++)
                                                        <li><i data-feather="star" class="fill"></i></li>
                                                    @endfor
                                                    @if (floor($product['rating']) < $product['rating'])
                                                        <li><i data-feather="star" class="fill"></i></li>
                                                    @endif
                                                    @for ($i = 0; $i < 5 - ceil($product['rating']); $i++)
                                                        <li><i data-feather="star"></i></li>
                                                    @endfor
                                                </ul>
                                                <span class="text-content">(Raring)</span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr> --}}
                                <tr>
                                    <th>Rating</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <div class="compare-rating">
                                                <ul class="rating">
                                                    @if ($product['rating_avg'] > 0)
                                                        @for ($i = 0; $i < floor($product['rating_avg']); $i++)
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                        @endfor
                                                        @if ($product['rating_avg'] - floor($product['rating_avg']) >= 0.5)
                                                            <li>
                                                                <i data-feather="star-half"></i>
                                                            </li>
                                                        @endif
                                                        @for ($i = ceil($product['rating_avg']); $i < 5; $i++)
                                                            <li>
                                                                <i data-feather="star" class=""></i>
                                                            </li>
                                                        @endfor
                                                    @else
                                                        <span class="text-content">Chưa có đánh giá</span>
                                                    @endif


                                                </ul>
                                                @if ($product['rating_avg'] > 0)
                                                    <span class="text-content">({{ $product['rating_avg'] }} Raring)</span>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- <tr>
                                    <th>Weight</th>
                                    <td class="text-content">5.00kg</td>
                                    <td class="text-content">1.00kg</td>
                                    <td class="text-content">0.75kg</td>

                                </tr> --}}

                                <tr>
                                    <th></th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            {{-- <button onclick="location.href = 'javascript:void(0)'" data-bs-toggle="modal"
                                                data-bs-target="#view" data-id={{ $product['id'] }}
                                                class="btn btn-animation btn-sm w-100">Add To Cart</button> --}}
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view"
                                                data-id={{ $product['id'] }} data-slug="{{ $product['slug'] }}"
                                                class="btn btn-animation btn-sm w-100">
                                                Add To Cart
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th></th>

                                    @foreach ($productsData as $product)
                                        <td>
                                            <button type="button"
                                                class="btn btn-success w-100 d-flex align-items-center justify-content-center remove-compare-button"
                                                data-product-id="{{ $product['id'] }}">
                                                <i class="fa-solid fa-trash-can me-2"></i> Remove
                                            </button>

                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- Compare Section End -->








    <!-- Tap to top and theme setting button start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top and theme setting button end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->
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
                                    <button
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md detail-product-button">
                                        Xem chi tiết sản phẩm
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
    <script>
        // Xử lý sự kiện xóa sản phẩm
        document.addEventListener('DOMContentLoaded', function() {
            // Sự kiện click cho nút xóa
            document.querySelectorAll('.remove-compare-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;

                    // Gọi hàm xóa và xử lý reload
                    removeFromCompareCookie(productId);


                });
            });
        });

        // Hàm xóa cookie
        function removeFromCompareCookie(productId) {
            let compareList = getCompareListFromCookie();
            const index = compareList.findIndex(id => id.toString() === productId.toString());


            if (index > -1) {
                compareList.splice(index, 1);
                console.log('Danh sách trước khi xóa:', compareList);
                console.log('ID cần xóa:', productId);
                if (compareList.length === 0) {
                    deleteCookie(compareCookieName);
                } else {
                    setCookie(compareCookieName, JSON.stringify(compareList), 30);
                }
                updateCompareCountBadgeCookie();
                // Thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Đã xóa!',
                    text: 'Sản phẩm đã được xóa khỏi so sánh',
                    timer: 1000,
                    showConfirmButton: false
                }).then(() => {
                    // Reload trang sau khi SweetAlert đóng
                    window.location.reload(true);
                });
            }
        }


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
        updateCompareCount();
        // end compare


        // detail modal 
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
                    const productDetailUrl = "{{ route('products', ['product' => ':productId']) }}"
                        .replace(':productId', productId);
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
                const productSlug = $(this).data('slug');

                $('#view').data('product-id', productId);
                $('#view').data('product-slug', productSlug);
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

            // view detial product
            $('.detail-product-button').click(function() {
                const productSlug = $('#view').data('product-slug');

                if (productSlug) {
                    const productDetailUrl = "{{ route('products', ['product' => ':slug']) }}".replace(
                        ':slug', productSlug);
                    location.href = productDetailUrl;
                } else {
                    console.error(
                        "Không tìm thấy productSlug để chuyển hướng đến trang chi tiết sản phẩm.");
                    alert(
                        "Lỗi: Không thể chuyển đến trang chi tiết sản phẩm. Không tìm thấy Slug sản phẩm."
                    );
                }
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
        }); // end document
    </script>
@endpush
