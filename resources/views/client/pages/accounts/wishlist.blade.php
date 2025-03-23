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

                                    $isSale = $product->is_sale == 1 && $product->sale_price > 0;

                                    if (!$isSale && $product->productVariants->isNotEmpty()) {
                                        $isSale = $product->productVariants
                                            ->where('is_active', 1)
                                            ->where('sale_price', '>', 0)
                                            ->isNotEmpty();
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
                                                data-id={{ $item->product->id }} class="btn btn-add-cart addcart-button">
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
                currency: 'đ'
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

            $('.detail-product-button').click(function() {
                const productId = $('#view').data('product-id'); // Lấy product-id từ modal

                if (productId) {
                    const productDetailUrl = "{{ route('products', ['product' => ':productId']) }}"
                        .replace(':productId', productId);
                    location.href = productDetailUrl;
                } else {
                    console.error("Không tìm thấy product_id hoặc phần tử #view không tồn tại.");
                    alert("Lỗi: Không tìm thấy thông tin sản phẩm.");
                }
            });


            let productVariantsData = {};
            $('.view-button').click(function() {
                const productId = $(this).data('product-id'); // Lấy product-id từ nút "View"
                $('#view').data('product-id', productId); // Gán product-id vào modal
            });

            $('#view').on('hidden.bs.modal', function() {
                $('#prdName, #prdPrice, #prdDescription, #prdBrand, #prdCategories').text('');
                $('#prdThumbnail').attr('src', '');
                $('#productVariants').empty();
                $('#cartProductId').val('');
                $('#cartProductVariantId').val('');
                productVariantsData = {};
            });

            function updateSelectedVariantUI(variantId) {
                let selectedVariant = productVariantsData[variantId];

                if (selectedVariant) {
                    console.log("📦 Cập nhật UI theo biến thể:", selectedVariant);

                    // Cập nhật thông tin sản phẩm theo biến thể đã chọn
                    $("#prdPrice").text(formatPrice(selectedVariant.price));
                    $("#prdThumbnail").attr("src", selectedVariant.thumbnail);
                    $(".product-stock span").text(`Kho: ${selectedVariant.stock_quantity}`);
                    $("#prdSoldCount").text(`Đã bán biến thể : (${selectedVariant.sold_count || 0})`);
                    $("#cartProductVariantId").val(selectedVariant.id);

                    // Cập nhật UI dropdown thuộc tính để phản ánh biến thể đã chọn
                    $(".attribute-select").each(function() {
                        let attrName = $(this).attr("id");
                        let matchingAttr = selectedVariant.attribute_values.find(attr => attr
                            .attributes_name === attrName);
                        if (matchingAttr) {
                            $(this).val(matchingAttr.id).trigger("change"); // 🟢 Chọn đúng thuộc tính
                        }
                    });
                }
            }

            $('a[data-bs-target="#view"]').click(function() {

                let productId = $(this).data('id');
                $('#view').data('product-id', productId);
                $('#cartProductId').val(productId);

                console.log("🔍 Modal mở cho Product ID:", productId);

                $.ajax({
                    url: '/api/product/' + productId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("📦 Dữ liệu sản phẩm:", response);

                        $('#prdName').text(response.name).data('product-name', response.name);
                        $('#prdDescription').text(response.short_description);
                        $('#prdThumbnail').attr('src', response.thumbnail).data(
                            'default-thumbnail', response.thumbnail);
                        $('#prdBrand').text(response.brand);
                        $('#prdCategories').text(response.categories);
                        $('#productVariants').empty();

                        // 🟢 Hiển thị đánh giá trung bình
                        const avgRating = response.avgRating || 0;
                        $('#prdRating ul.rating').html(
                            Array.from({
                                    length: 5
                                }, (_, i) =>
                                `<li><i data-feather="star" class="${i < avgRating ? 'fill' : ''}"></i></li>`
                            ).join('')
                        );
                        feather.replace();

                        // 🟢 Hiển thị kho sản phẩm thường trước khi chọn biến thể
                        var stockQuantity = response.stock || 0;
                        $('.product-stock span').text(`Kho: ${stockQuantity}`);
                        $('#productVariants').data('stock', stockQuantity);

                        // Đã bán
                        $('#prdSoldCount').text(`Đã bán (${response.sold_count})`);

                        productVariantsData = {};
                        let defaultPrice = response.price;
                        let defaultVariantId = null;

                        if (response.productVariants && response.productVariants.length > 0) {
                            let allAttributes = {};
                            let firstVariant = response.productVariants[
                                0]; // Chọn biến thể đầu tiên
                            defaultVariantId = firstVariant.id;
                            defaultPrice = firstVariant.sale_price ?? firstVariant.price;
                            // Lấy tồn kho từ product_stock
                            let firstStock = firstVariant.product_stock?.stock ?? 0;

                            response.productVariants.forEach(variant => {
                                let variantId = variant.id;
                                let stock = variant.product_stock?.stock ?? 0;

                                productVariantsData[variantId] = {
                                    id: variantId,
                                    price: variant.sale_price ?? variant.price,
                                    thumbnail: variant.thumbnail,
                                    attribute_values: variant.attribute_values,
                                    stock_quantity: stock,
                                    sold_count: variant.sold_count
                                };

                                variant.attribute_values.forEach(attr => {
                                    if (!allAttributes[attr.attributes_name]) {
                                        allAttributes[attr
                                            .attributes_name] = [];
                                    }
                                    if (!allAttributes[attr.attributes_name]
                                        .some(v => v.id === attr.id)) {
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
                                            ${allAttributes[attrName].map(attr => 
                                                `<option value="${attr.id}" ${firstVariant.attribute_values.some(a => a.id === attr.id) ? 'selected' : ''}>${attr.attribute_value}</option>`
                                            ).join('')}
                                        </select>
                                    </div>
                                </div>`;
                            }

                            $('#productVariants').html('<div class="row">' + attributesHtml +
                                '</div>');
                            $('.attribute-select').change(updateSelectedVariant);

                            // Cập nhật UI theo biến thể đầu tiên
                            $('#prdPrice').text(formatPrice(defaultPrice));
                            $('#prdThumbnail').attr('src', firstVariant.thumbnail);
                            $('.product-stock span').text(
                                `Kho: ${firstStock}`); // 🟢 Hiển thị kho chính xác
                            $('#prdSoldCount').text(
                                `Đã bán biến thể : (${firstVariant.sold_count || 0})`);
                            $('#cartProductVariantId').val(firstVariant.id);
                            updateSelectedVariantUI(
                                firstVariantId); // 🟢 Cập nhật UI theo biến thể mặc định
                            console.log("🟢 Mặc định chọn biến thể:", firstVariant);
                        } else {
                            $('#productVariants').html(
                                '<p>Sản phẩm này hiện không có biến thể.</p>');
                        }

                        $('#prdPrice').text(formatPrice(defaultPrice)).data('default-price',
                            defaultPrice);
                        $('#cartProductVariantId').val('');
                    },

                    error: function(xhr) {
                        alert('Không tìm thấy sản phẩm.');
                    }
                });
            });


            function getCurrentVariantId() {
                let selectedAttributes = {};

                $('.attribute-select').each(function() {
                    let attrName = $(this).attr('id');
                    let selectedValueId = $(this).val();
                    if (selectedValueId) {
                        selectedAttributes[attrName] = parseInt(selectedValueId);
                    }
                });

                console.log("🔍 Thuộc tính đã chọn:", selectedAttributes);

                let matchedVariant = Object.values(productVariantsData).find(variant => {
                    if (!variant.attribute_values || variant.attribute_values.length === 0) {
                        return false;
                    }

                    return variant.attribute_values.every(attr => {
                        return selectedAttributes[attr.attributes_name] === attr.id;
                    });
                });

                return matchedVariant ? matchedVariant.id : null;
            }

            function updateSelectedVariant() {
                let selectedAttributes = {};
                $(".attribute-select").each(function() {
                    let attrName = $(this).attr("id");
                    let attrValue = $(this).val();
                    if (attrValue) selectedAttributes[attrName] = attrValue;
                });

                let selectedVariant = Object.values(productVariantsData).find(variant => {
                    return variant.attribute_values.every(attr =>
                        selectedAttributes[attr.attributes_name] == attr.id
                    );
                });

                if (selectedVariant) {
                    console.log("📦 Biến thể được chọn:", selectedVariant);
                    console.log("Số lượng đã bán của biến thể:", selectedVariant
                        .sold_count); // Thêm dòng này để debug

                    $("#prdPrice").text(formatPrice(selectedVariant.price));
                    $("#prdThumbnail").attr("src", selectedVariant.thumbnail);
                    $(".product-stock span").text(`Kho: ${selectedVariant.stock_quantity}`);
                    $("#prdSoldCount").text(
                        `Đã bán biến thể : (${selectedVariant.sold_count || 0})`); // 🟢 Hiển thị số lượng đã bán
                    $("#cartProductVariantId").val(selectedVariant.id);
                }
            }

            $('#addToCartForm').submit(function(e) {
                e.preventDefault();

                // Kiểm tra trạng thái đăng nhập

                let productId = $('#cartProductId').val();
                let selectedVariantId = $('#cartProductVariantId').val(); // 🟢 Lấy giá trị biến thể đã chọn

                let hasVariant = $('#productVariants .attribute-select').length > 0;

                console.log("🛒 ID sản phẩm:", productId);
                console.log("🛒 ID biến thể đã chọn:", selectedVariantId);
                console.log("🔍 Sản phẩm có biến thể?", hasVariant);

                // 🟢 Nếu có biến thể nhưng chưa chọn, lấy biến thể mặc định
                if (hasVariant && (!selectedVariantId || selectedVariantId.trim() === "")) {
                    let defaultVariantId = $('#productVariants').find('.attribute-select option[selected]')
                        .val();
                    selectedVariantId = defaultVariantId || $('#cartProductVariantId').val();

                    console.log("🟢 Tự động lấy biến thể mặc định:", selectedVariantId);
                    $('#cartProductVariantId').val(selectedVariantId);
                }

                // Kiểm tra số lượng tồn kho
                let stockQuantity = selectedVariantId ? productVariantsData[selectedVariantId]
                    ?.stock_quantity || 0 : $('#productVariants').data('stock') || 0;

                console.log("🛒 Số lượng tồn kho:", stockQuantity);

                // Kiểm tra nếu hết hàng
                if (stockQuantity <= 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Lỗi!",
                        text: "Sản phẩm này đã hết hàng.",
                    });
                    return;
                }

                // Gửi AJAX thêm vào giỏ hàng
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
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: "Có lỗi xảy ra khi thêm vào giỏ hàng.",
                        });
                    }
                });
            });
        }); // end document
    </script>
@endpush
