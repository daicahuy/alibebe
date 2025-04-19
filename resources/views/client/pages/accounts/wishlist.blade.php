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
                                @php
                                    $product = $item->product;
                                    
                                    // Lọc biến thể có is_active = 1
                                    $activeVariants = $product->productVariants->where('is_active', 1);
                                    
                                    $isSale = $product->is_sale == 1 && $product->sale_price > 0;
                                    
                                    if (!$isSale && $activeVariants->isNotEmpty()) {
                                        $isSale = $activeVariants->where('sale_price', '>', 0)->isNotEmpty();
                                    }
                                @endphp

                                @if ($isSale)
                                    <span class="badge bg-danger position-absolute top-1 end-0">Giảm giá</span>
                                @endif

                                <div class="product-header">
                                    <div class="product-image">
                                        <a href="{{ route('products', ['product' => $item->product->slug]) }}"
                                            class="text-title">
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
                                        <a href="{{ route('products', ['product' => $item->product->slug]) }}"
                                            class="text-title">
                                            <h6 class="name">{{ $item->product->name }}</h6>
                                        </a>
                                        <h5 class="price">
                                            @php
                                                $product = $item->product;
                                            @endphp

                                            @if ($product->price != 0)
                                                @if ($product->is_sale == 1 && $product->sale_price > 0)
                                                    <span class="theme-color">
                                                        {{ number_format($product->sale_price, 0, ',', '.') }} đ
                                                    </span>
                                                    <del>{{ number_format($product->price, 0, ',', '.') }} đ</del>
                                                @else
                                                    {{-- Không sale --}}
                                                    <span class="theme-color">
                                                        {{ number_format($product->price, 0, ',', '.') }} đ
                                                    </span>
                                                @endif

                                                {{-- Nếu là sản phẩm có biến thể (price == 0) --}}
                                            @else
                                                @php
                                                    // Lọc các biến thể active
                                                    $activeVariants = $product->productVariants->where('is_active', 1);
                                                @endphp

                                                {{-- Nếu không có biến thể hoặc rỗng --}}
                                                @if ($activeVariants->isEmpty())
                                                    <span class="theme-color">Liên hệ</span>
                                                @else
                                                    {{-- Có biến thể, hiển thị tag sale nếu product->is_sale == 1 --}}
                                                    @if ($product->is_sale == 1 && $product->sale_price > 0)
                                                        <span class="badges sale">Giảm giá</span>
                                                    @endif

                                                    @php
                                                        // Tính khoảng giá (theo cột price của variant)
                                                        $prices = $activeVariants->pluck('price')->filter()->sort();
                                                        if ($prices->isNotEmpty()) {
                                                            $minPrice = $prices->first();
                                                            $maxPrice = $prices->last();
                                                            $priceRange =
                                                                number_format($minPrice, 0, ',', '.') .
                                                                ' - ' .
                                                                number_format($maxPrice, 0, ',', '.') .
                                                                ' đ';
                                                        } else {
                                                            $priceRange = 'Liên hệ';
                                                        }
                                                    @endphp

                                                    <span class="theme-color">{{ $priceRange }}</span>
                                                @endif
                                            @endif
                                        </h5>

                                        <div class="add-to-cart-box bg-white">
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#view"
                                                data-id={{ $item->product->id }} data-slug={{ $item->product->slug }}
                                                class="btn btn-add-cart addcart-button">
                                                Thêm vào giỏ hàng
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="custom-pagination p-4">
                    {{ $wishlist->links() }}
                </div>
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
                                    <h4>Chi Tiết Sản Phẩm :</h4>
                                    <p id='prdDescription'></p>
                                </div>

                                <ul class="brand-list">
                                    <li>
                                        <div class="brand-box">
                                            <h5>Thương Hiệu:</h5>
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
                                            <h5>Danh Mục:</h5>
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
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md detail-product-button">
                                        Xem Chi Tiết Sản Phẩm</button>
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
            }).replace('VND', 'đ');
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

            $('.detail-product-button').click(function() {
                if (currentProductSlug) {
                    const productDetailUrl = "{{ route('products', ['product' => ':slug']) }}"
                        .replace(':slug', currentProductSlug);
                    window.location.href = productDetailUrl;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Không tìm thấy thông tin sản phẩm'
                    });
                }
            });

            let productVariantsData = {};
            let currentProductSlug = null;

            // Reset modal khi đóng
            $('#view').on('hidden.bs.modal', function() {
                $('#prdName, #prdDescription, #prdBrand, #prdCategories').text('');
                $('#prdThumbnail').attr('src', '');
                $('#productVariants').empty();
                $('#cartProductId, #cartProductVariantId').val('');
                $(".product-stock span").text('');
                productVariantsData = {};
                currentProductSlug = null;
            });

            // Xử lý mở modal chi tiết sản phẩm
            $('a[data-bs-target="#view"]').click(function() {
                let productId = $(this).data('id');
                const productSlug = $(this).data('slug');

                currentProductSlug = productSlug;
                $('#view').data('slug', productSlug);
                $('#view').data('product-id', productId);
                $('#cartProductId').val(productId);

                $.ajax({
                    url: '/api/product/' + productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("Response từ API:", response); // Debug API response
                        // Cập nhật thông tin sản phẩm
                        $('#prdName').text(response.name);
                        $('#prdDescription').text(response.short_description);
                        $('#prdThumbnail').attr('src', response.thumbnail);
                        $('#prdBrand').text(response.brand);
                        $('#prdCategories').text(response.categories);

                        let defaultPrice = response.price;
                        let defaultPriceDisplay = formatPrice(defaultPrice);

                        console.log(defaultPrice, defaultPriceDisplay);

                        // Nếu có sale
                        if (response.is_sale && response.display_price > 0) {
                            defaultPrice = response.display_price;
                            defaultPriceDisplay = `
                                <span class="theme-color">${formatPrice(response.display_price)}</span>
                                <del>${formatPrice(response.original_price || response.price)}</del>
                            `;
                        }
                        $('#prdPrice').html(defaultPriceDisplay);

                        // Xử lý biến thể
                        productVariantsData = {};
                        $('#productVariants').empty();

                        // Lọc biến thể có is_active = 1
                        const activeVariants = response.productVariants ? 
                            response.productVariants.filter(variant => variant.is_active === 1) : [];

                        if (activeVariants && activeVariants.length > 0) {
                            let allAttributes = {};
                            let firstVariant = activeVariants[0];

                            activeVariants.forEach(variant => {
                                let variantId = variant.id;
                                let stock = variant.product_stock?.stock ?? 0;
                                let variantPrice = variant.display_price ?? variant.price;
                                let variantPriceDisplay = variant.display_price ?
                                    `
                                        <span class="theme-color">${formatPrice(variant.display_price)}</span>
                                        <del>${formatPrice(variant.price)}</del>
                                    ` :
                                    formatPrice(variantPrice);

                                productVariantsData[variantId] = {
                                    id: variantId,
                                    price: variantPrice,
                                    priceDisplay: variantPriceDisplay,
                                    thumbnail: variant.thumbnail,
                                    attribute_values: variant.attribute_values,
                                    stock_quantity: stock,
                                    sold_count: variant.sold_count || 0
                                };

                                // Debug từng variant
                                console.log("Variant", variantId, productVariantsData[
                                    variantId]);

                                variant.attribute_values.forEach(attr => {
                                    if (!allAttributes[attr.attributes_name]) {
                                        allAttributes[attr.attributes_name] = [];
                                    }
                                    if (!allAttributes[attr.attributes_name]
                                        .some(v => v.id === attr.id)) {
                                        allAttributes[attr.attributes_name]
                                            .push({
                                                id: attr.id,
                                                attribute_value: attr.attribute_value
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
                                                ${allAttributes[attrName].map(attr => 
                                                    `<option value="${attr.id}">${attr.attribute_value}</option>`
                                                ).join('')}
                                            </select>
                                        </div>
                                    </div>`;
                            }

                            $('#productVariants').html('<div class="row">' + attributesHtml +
                                '</div>');
                            $('.attribute-select').change(updateSelectedVariant);

                            updateSelectedVariantUI(firstVariant.id);
                        } else {
                            // Nếu sản phẩm không có biến thể, tạo variant mặc định dựa trên thông tin sản phẩm
                            productVariantsData["default"] = {
                                id: "default",
                                price: defaultPrice,
                                priceDisplay: defaultPriceDisplay,
                                thumbnail: response.thumbnail,
                                stock_quantity: response.stock || 0,
                                sold_count: response.sold_count || 0
                            };

                            // Debug thông tin sản phẩm đơn
                            console.log("Variant mặc định của sản phẩm đơn:",
                                productVariantsData["default"]);

                            // Hiển thị thông báo sản phẩm không có biến thể (hoặc bạn có thể ẩn phần này)
                            $('#productVariants').html(
                                '<p>Sản phẩm này không có biến thể.</p>');
                            // Cập nhật stock và variant mặc định
                            $(".product-stock span").text(
                                `Kho: ${productVariantsData["default"].stock_quantity}`);
                            $("#prdSoldCount").text(
                                `Đã bán: (${productVariantsData["default"].sold_count})`);
                            $('#cartProductVariantId').val("default");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Không tìm thấy thông tin sản phẩm.'
                        });
                    }
                });
            });

            function updateSelectedVariantUI(variantId) {
                let selectedVariant = productVariantsData[variantId];
                console.log("Variant được chọn:", selectedVariant); // Debug variant được chọn

                if (selectedVariant) {
                    $("#prdPrice").html(selectedVariant.priceDisplay);
                    $("#prdThumbnail").attr("src", selectedVariant.thumbnail);
                    $(".product-stock span").text(`Kho: ${selectedVariant.stock_quantity}`);
                    $("#prdSoldCount").text(`Đã bán: (${selectedVariant.sold_count || 0})`);
                    $("#cartProductVariantId").val(selectedVariant.id);

                    $(".attribute-select").each(function() {
                        let attrName = $(this).attr("id");
                        let matchingAttr = selectedVariant.attribute_values.find(attr => attr
                            .attributes_name === attrName);
                        if (matchingAttr) {
                            $(this).val(matchingAttr.id).trigger("change");
                        }
                    });
                }
            }

            function updateSelectedVariant() {
                let selectedVariant = findSelectedVariant();

                if (selectedVariant) {
                    $("#prdPrice").html(selectedVariant.priceDisplay);
                    $("#prdThumbnail").attr("src", selectedVariant.thumbnail);
                    $(".product-stock span").text(`Kho: ${selectedVariant.stock_quantity}`);
                    $("#prdSoldCount").text(`Đã bán: (${selectedVariant.sold_count || 0})`);
                    $("#cartProductVariantId").val(selectedVariant.id);
                    console.log("Variant sau khi cập nhật thuộc tính:",
                        selectedVariant); // Debug variant sau cập nhật
                }
            }

            function findSelectedVariant() {
                let selectedAttributes = {};
                $(".attribute-select").each(function() {
                    let attrName = $(this).attr("id");
                    let attrValue = $(this).val();
                    if (attrValue) selectedAttributes[attrName] = attrValue;
                });

                console.log("Thuộc tính đã chọn:", selectedAttributes); // Debug các thuộc tính đã chọn

                return Object.values(productVariantsData).find(variant =>
                    variant.attribute_values.every(attr =>
                        selectedAttributes[attr.attributes_name] == attr.id
                    )
                );
            }

            $('#addToCartForm').submit(function(e) {
                e.preventDefault();

                let productId = $('#cartProductId').val();
                let selectedVariantId = $('#cartProductVariantId').val();
                let hasVariant = $('#productVariants .attribute-select').length > 0;

                // Nếu sản phẩm không có biến thể thì loại bỏ trường product_variant_id
                if (!hasVariant) {
                    // Xóa giá trị trường product_variant_id để không gửi lên
                    $('#cartProductVariantId').val('');
                }

                let stockQuantity = 0;
                if (hasVariant) {
                    stockQuantity = productVariantsData[selectedVariantId]?.stock_quantity || 0;
                } else {
                    // Với sản phẩm đơn, hãy lấy số lượng kho từ response hoặc từ một biến nào đó
                    // Ví dụ: nếu response của sản phẩm đơn có chứa 'stock_quantity'
                    stockQuantity = productVariantsData["default"]?.stock_quantity || 0;
                }
                console.log("Stock quantity của variant:", stockQuantity);

                if (stockQuantity <= 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Sản phẩm này đã hết hàng.",
                    });
                    return;
                }

                $.ajax({
                    url: $('#addToCartForm').attr('action'),
                    method: $('#addToCartForm').attr('method'),
                    data: $('#addToCartForm').serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Thêm vào giỏ hàng thành công!",
                            text: "Sản phẩm của bạn đã được thêm vào giỏ hàng.",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        console.log(err);
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra khi thêm vào giỏ hàng.",
                        });
                    }
                });
            });

        });
    </script>
@endpush
