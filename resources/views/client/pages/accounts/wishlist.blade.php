@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-wishlist">
        <div class="title">
            <h2>{{ __('form.wishlists') }}</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>
        <div class="row g-sm-4 g-3">
            @if ($wishlist->isEmpty())
                <div class="mt-3 mb-3 text-center">
                    <p>Bạn Chưa Có Sản Phẩm Yêu Thích Nào !!!</p>
                </div>
            @else
                @foreach ($wishlist as $item)
                    <div class="col-xxl-3 col-lg-3 col-md-3 col-sm-6">
                        <div>
                            <div class="product-box-3 h-100 wow fadeInUp" data-wow-delay="0.65s">
                                <div class="product-header">
                                    <div class="product-image">
                                        <a href="{{ route('products', $item->product->id) }}">
                                            <img src="{{ Storage::url($item->product->thumbnail) }}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </a>

                                        <div class="product-header-top">
                                            <form action="{{ route('account.remove-wishlist', $item->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn wishlist-button close_button">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="product-footer">
                                    <div class="product-detail">
                                        <span class="span-name">{{ $item->product->brand->name }}</span>
                                        <a href="{{ route('products', $item->product->id) }}">
                                            <h5 class="name">{{ $item->product->name }}</h5>
                                        </a>
                                        <h5 class="price">
                                            <span
                                                class="theme-color">{{ number_format($item->product->price, 0, ',', '.') }}
                                                VND</span>
                                        </h5>
                                        <div class="add-to-cart-box bg-white">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view"
                                                data-id={{ $item->id }} class="btn btn-add-cart addcart-button">
                                                Thêm vào giỏ hàng
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <nav class="custom-pagination">
                    {{ $wishlist->links() }}
                </nav>
            @endif
        </div>
    </div>
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
                                    <button onclick="location.href = {{ route('cart.add') }}"
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details</button>
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
        }); // end document
    </script>
@endpush
