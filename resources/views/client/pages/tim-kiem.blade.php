@extends('client.layouts.master')

@section('content')
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Kết quả tìm kiếm</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Kết quả tìm kiếm</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space search-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="search-top-contain">
                        <p class="mb-0">
                            Đã tìm thấy <span class="text-theme fw-bold">{{ $results->total() }}</span> kết quả cho từ khóa
                            <span class="text-theme fw-bold">{{ request('q') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-4 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 mt-3">
                @forelse ($results as $product)
                    <div>
                        <div class="product-box-3 h-100">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="{{ route('products', $product->slug) }}">
                                        <img src="{{ Storage::url($product->thumbnail) }}" class="img-fluid-m"
                                            alt="{{ $product->name }}">
                                    </a>

                                    <ul class="product-option">
                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view"
                                                data-id={{ $product->id }} data-slug={{$product->slug}}>
                                                <i data-feather="eye"></i>
                                            </a>
                                        </li>

                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="So sánh">
                                            <a href="javascript:;" class="compare-toggle" data-state="unselected"
                                                data-product-id="{{ $product->id }}"
                                                data-product-category-id="{{ $product->categories->first()->id ?? null }}">
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
                                                data-product-id="{{ $product->id }}">
                                                <i data-feather="heart" class="wishlist-icon"
                                                    style="color: {{ in_array($product->id, $wishlistProductIds) ? 'red' : 'black' }};"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-footer">
                                <div class="product-detail">
                                    
                                    @if ($product->categories->isNotEmpty())
                                        {{ $product->categories->pluck('name')->implode(', ') }}
                                    @else
                                        <span class="text-muted">Không có danh mục</span>
                                    @endif
                                    <a href="{{ route('products', $product->id) }}">
                                        <h5 class="name">{{ $product->name }}</h5>
                                    </a>
                                    <p class="text-content mt-1 mb-2 product-content">
                                        {!! $product->short_description !!}</p>
                                    <div class="product-rating mt-2">
                                        <ul class="rating">
                                            @php
                                                $avgRating = $product->reviews->avg('rating');
                                                $roundedRating = floor($avgRating); //làm tròn xuống
                                            @endphp
                                            @empty($product->reviews)
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
                                    <h6 class="unit">{{ $product->views }} lượt xem</h6>
                                    {{-- <h6 class="unit">{{ $item->sold_count ?? 0 }} đã bán</h6> --}}
                                    <h6 class="unit">{{ $product->getSoldQuantity() }} đã bán</h6>

                                    <h5 class="price">
                                        @if ($product->productVariants->isNotEmpty())
                                            {{-- Sản phẩm có biến thể --}}
                                            @php
                                                $lowestPriceVariant = $product->productVariants->sortBy('price')->first();
                                            @endphp
                                            @if ($lowestPriceVariant)
                                                <span class="theme-color">{{ number_format($lowestPriceVariant->sale_price ?? $lowestPriceVariant->price) }}đ</span>
                                                @if ($lowestPriceVariant->sale_price < $lowestPriceVariant->price)
                                                    <del>{{ number_format($lowestPriceVariant->price) }}đ</del>
                                                @endif
                                            @else
                                                {{-- Trường hợp không tìm thấy biến thể nào (nên không xảy ra) --}}
                                                <span class="theme-color">{{ number_format($product->sale_price ?? $product->price) }}đ</span>
                                                @if ($product->is_sale == 1)
                                                    <del>{{ number_format($product->price) }}đ</del>
                                                @endif
                                            @endif
                                        @else
                                            {{-- Sản phẩm không có biến thể --}}
                                            <span class="theme-color">{{ number_format($product->sale_price ?? $product->price) }}đ</span>
                                            @if ($product->is_sale == 1)
                                                <del>{{ number_format($product->price) }}đ</del>
                                            @endif
                                        @endif
                                    </h5>
                                    <div class="add-to-cart-box bg-white">
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#view" data-id={{ $product->id }}
                                            class="btn btn-add-cart addcart-button">
                                            Thêm vào giỏ hàng
                                        </a>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ request('q') }}".</p>
                    </div>
                @endforelse
            </div>

            {{-- {{ $results->appends(request()->query())->links('vendor.pagination.bootstrap-5') }} --}}
            <div class="custom-pagination">
                {{ $results->appends(request()->query())->links() }}
            </div>
        </div>
    </section>
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
                                    <span class="ms-2 text-danger" id="prdSoldCount"></span>
                                </div>

                                <div class="product-stock">
                                    <span> </span>
                                </div>

                                <div class="product-detail">
                                    <h4>Chi tiết sản phẩm :</h4>
                                    <p id='prdDescription'></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Thương hiệu:</h5>
                                            <h6 id = 'prdBrand'></h6>
                                        </div>
                                    </li>
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
                                        Xem chi tiết
                                    </button>
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
            // $('.detail-product-button').click(function() {
            //     const productId = $('#view').data('product-id');

            //     if (productId) {
            //         const productDetailUrl = "{{ route('products', ['product' => ':productId']) }}"
            //             .replace(':productId', productId);
            //         location.href = productDetailUrl;
            //     } else {
            //         console.error("Không tìm thấy product_id...");
            //         alert("Lỗi:...");
            //     }
            // });
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

                $('.detail-product-button').click(function(
                    e) {
                    e.preventDefault();


                    const productDetailPageUrl = `/products/${productSlug}`;

                    window.location.href = productDetailPageUrl;
                });

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
