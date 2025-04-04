@extends('client.layouts.master')

@push('css')
    <style>
        #btn-delete-all {
            border: 2px solid #dc3545 !important;
            /* Viền đỏ */
            color: #dc3545 !important;
            /* Chữ đỏ */
            height: 29px;
            /* Chiều cao */
            background-color: transparent !important;
            /* Nền trong suốt */
            transition: all 0.3s ease-in-out;
            /* Hiệu ứng mượt */
        }

        /* Khi di chuột vào */
        #btn-delete-all:hover {
            background-color: #dc3545 !important;
            /* Nền đỏ */
            color: white !important;
            /* Chữ trắng */
        }

        /* Nếu trong nút có icon SVG */
        #btn-delete-all:hover svg {
            fill: white !important;
            /* Đổi màu icon thành trắng */
        }

        /* css cục biến thể */
        .variation-container {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            border-radius: 8px;
            z-index: 1000;
            /* Giúp popup luôn hiển thị trên các phần tử khác */
        }

        .variation-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Chỉnh các nút chọn thành hàng ngang */
        .variation-container div {
            display: flex;
            flex-wrap: wrap;
            /* Tự động xuống hàng nếu không đủ chỗ */
            gap: 10px;
        }

        .product-variation {
            flex: 1 1 calc(50% - 10px);
            /* Chia 2 button trên 1 dòng (50%) */
            min-width: 90px;
            /* Giới hạn kích thước tối thiểu */
            padding: 8px;
            max-width: 150px;
            /*Giữ kích thước cố định, không quá rộng*/
            border: 1px solid #ccc;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
            transition: 0.3s;
        }

        .product-variation:hover,
        .product-variation--selected {
            background: #999;
            color: white;
            border-color: #999;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .cancel-btn,
        .confirm-btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .cancel-btn {
            background: #ccc;
            color: black;
        }

        .cancel-btn:hover {
            background: #999;
        }

        .confirm-btn {
            background: #0da487;
            color: white;
        }

        .confirm-btn:hover {
            background: #0b8c70;
        }

        .toggle-button {
            background: #d8d8d8;
            color: rgb(10, 10, 10);
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .toggle-button:hover {
            background: #c5c5c6;
        }

        .selected-variation {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* submit delete */
        .submit-delete {
            border: none;
            /* Xóa viền */
            background: none;
            /* Xóa nền */
            cursor: pointer;
            /* Hiển thị con trỏ tay khi hover */
            padding: 5px;
            /* Giữ khoảng cách hợp lý */
        }

        .submit-delete svg {
            color: red;
            /* Đổi màu icon thành đỏ */
            width: 20px;
            /* Điều chỉnh kích thước nếu cần */
            height: 20px;
            transition: color 0.3s ease;
            /* Hiệu ứng đổi màu mượt mà */
        }

        .submit-delete:hover svg {
            color: darkred;
            /* Khi hover, chuyển sang màu đỏ đậm */
        }

        .cart-table {
            overflow-x: auto;
            max-width: 100%;
        }

        .table-responsive {
            overflow-x: hidden;
        }

        body {
            overflow-x: hidden;
        }

        .input-group {
            border: 1px solid rgb(248, 248, 248) !important;
        }
    </style>
@endpush
@section('content')
    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Giỏ hàng</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Giỏ hàng</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container mt-4 mb-4">
        <div class="d-flex ">
            <div class="sm-width pt-1 pb-1">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="checkbox-table" class="custom-control-input checkbox_animated">Chọn tất cả
                </div>
            </div>
            <form action="{{ route('cart.delete') }}" method="POST" id="delete-all-form">
                @csrf
                @method('DELETE')

                <input type="hidden" name="ids" id="ids-to-delete" value="">

                <button class="align-items-center btn btn-outline-danger btn-sm d-flex ms-2 visually-hidden"
                    id="btn-delete-all"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                        <path
                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                    </svg>
                    <div class="m-1">
                        {{ __('message.delete_all') }}

                    </div>
                </button>
            </form>
        </div>

        <div class="row g-xl-5 g-sm-4 g-3 pt-3">
            <div class="col-xxl-9 col-xl-8">
                <div class="cart-table">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @if ($data->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <strong>Bạn chưa thêm sản phẩm vào giỏ hàng</strong>
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $totalSum = 0; // Khởi tạo tổng tiền giỏ hàng
                                @endphp

                                @foreach ($data as $cartItem)
                                    <tr class="product-box-contain product-item" data-id="{{ $cartItem->id }}"
                                        data-product-id="{{ $cartItem->product->id ?? '' }}"
                                        data-product-variant-id="{{ $cartItem->productVariant->id ?? '' }}">

                                        <td class="product-detail">
                                            <div class="product border-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" value="{{ $cartItem->id }}" id="checkbox-table"
                                                        class="custom-control-input checkbox_animated checkbox-input">
                                                </div>

                                                @php
                                                    // Kiểm tra nếu có productVariant thì lấy ảnh từ productVariant, nếu không thì lấy ảnh từ product
                                                    $thumbnail =
                                                        $cartItem->productVariant->product->thumbnail ??
                                                        $cartItem->product->thumbnail;
                                                @endphp
                                                <a class="product-image"
                                                    href="{{ route('products', $cartItem->product->slug) }}">
                                                    <img alt="product" class="img-fluid"
                                                        src="{{ Storage::url($thumbnail) }}">
                                                </a>

                                                <div class="product-detail">
                                                    <ul>
                                                        <li class="name">
                                                            <a class="name_product"
                                                                href="{{ route('products', $cartItem->product->slug) }}">
                                                                {{ Str::limit($cartItem->productVariant->product->name ?? $cartItem->product->name, 20, '...') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            Phân loại hàng:
                                                            <span class="selected-variation">
                                                                @if ($cartItem->productVariant)
                                                                    @foreach ($cartItem->productVariant->attributeValues as $attributeValue)
                                                                        {{ $attributeValue->value }}{{ !$loop->last ? ', ' : '' }}
                                                                    @endforeach
                                                                @else
                                                                    Không có phân loại
                                                                @endif
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>

                                        @php
                                            // Kiểm tra nếu biến thể tồn tại và đang hoạt động (is_active = 1), thì lấy giá từ biến thể, nếu không thì lấy từ product
                                            $price =
                                                $cartItem->productVariant && $cartItem->productVariant->is_active == 1
                                                    ? $cartItem->productVariant->price
                                                    : $cartItem->product->price;

                                            // Xác định giá sale (ưu tiên biến thể nếu nó đang hoạt động)
                                            if (
                                                $cartItem->productVariant &&
                                                $cartItem->productVariant->is_active == 1
                                            ) {
                                                if (
                                                    !is_null($cartItem->productVariant->sale_price) &&
                                                    $cartItem->productVariant->sale_price > 0
                                                ) {
                                                    // Nếu biến thể có sale_price hợp lệ, dùng nó
                                                    $salePrice = $cartItem->productVariant->sale_price;
                                                } else {
                                                    // Nếu không có sale_price, lấy giá gốc của biến thể
                                                    $salePrice = $cartItem->productVariant->price;
                                                }
                                            } elseif (
                                                $cartItem->product?->sale_price > 0 &&
                                                $cartItem->product?->is_sale == 1
                                            ) {
                                                // Nếu product có sale_price và đang sale, dùng nó
                                                $salePrice = $cartItem->product->sale_price;
                                            } else {
                                                // Nếu không có giảm giá, dùng giá gốc (price)
                                                $salePrice = $price;
                                            }

                                            // Tính số tiền tiết kiệm
                                            $saving = $price - $salePrice;

                                            // Tính tổng tiền sản phẩm này
                                            $sumOnePrd = $cartItem->quantity * $salePrice;
                                            $totalSum += $sumOnePrd;
                                        @endphp

                                        {{-- <input type="hi" class="original-price" value="{{ $cartItem->productVariant->price ?? $cartItem->product->price}}">
                                            <input type="text" class="sale-price" value="{{ $cartItem->productVariant?->sale_price > 0
                                                    ? $cartItem->productVariant->sale_price
                                                    : null}}"> --}}
                                        <input type="hidden" class="price"
                                            value="{{ $cartItem->product->price ?? $cartItem->productVariant->product->price }}">
                                        <input type="hidden" class="old_price"
                                            value="{{ $cartItem->product?->sale_price ?? $cartItem->productVariant?->product->sale_price }}">
                                        <input type="hidden" class="price_variant"
                                            value="{{ $cartItem->productVariant?->price > 0 ? $cartItem->productVariant->price : null }}">
                                        <input type="hidden" class="old_price_variant"
                                            value="{{ $cartItem->productVariant?->sale_price > 0 ? $cartItem->productVariant->sale_price : null }}">
                                        <input type="hidden" class="is_sale" value="{{ $cartItem->product->is_sale }}">
                                        @if ($cartItem->productVariant)
                                            <!-- Sản phẩm có biến thể -->
                                            @if ($cartItem->productVariant->productStock)
                                                <input type="hidden" class="stock"
                                                    value="{{ $cartItem->productVariant->productStock->stock }}">
                                            @endif
                                        @else
                                            <!-- Sản phẩm không có biến thể -->
                                            @if ($cartItem->product->productStock)
                                                <input type="hidden" class="stock"
                                                    value="{{ $cartItem->product->productStock->stock }}">
                                            @endif
                                        @endif
                                        <td class="price">
                                            <h4 class="table-title text-content">Giá</h4>
                                            <h5>
                                                {{ number_format($salePrice, 0, ',', '.') }}đ
                                                @if ($salePrice < $price)
                                                    <del
                                                        class="text-content">{{ number_format($price, 0, ',', '.') }}đ</del>
                                                @endif
                                            </h5>
                                            @if ($saving > 0)
                                                <h6 class="theme-color">Tiết kiệm:
                                                    {{ number_format($saving, 0, ',', '.') }}đ</h6>
                                            @endif
                                        </td>

                                        <td class="quantity">
                                            <h4 class="table-title text-content">Số lượng</h4>
                                            <div class="quantity-price">
                                                <div class="cart_qty">
                                                    <div class="input-group">
                                                        <button class="btn qty-left-minus" type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-dash"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                            </svg>
                                                        </button>

                                                        <input type="text" name="quantity"
                                                            value="{{ $cartItem->quantity }}"
                                                            class="form-control input-number"
                                                            data-max-stock="{{ $cartItem->productVariant?->productStock?->stock ?? ($cartItem->product?->productStock?->stock ?? 1) }}">
                                                        <button class="btn qty-right-plus" type="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-plus"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="subtotal">
                                            <h4 class="table-title text-content">Tổng</h4>
                                            <h5>{{ number_format($sumOnePrd, 0, ',', '.') }}đ</h5>
                                        </td>

                                        <td class="save-remove">
                                            <h4 class="table-title text-content">Thao tác</h4>
                                            <form method="POST" action="{{ route('cart.delete') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $cartItem->id }}">
                                                <button class="submit-delete" type="submit"
                                                    onclick="return confirm('{{ __('message.confirm_move_to_trash_item') }}')"
                                                    class="remove close_button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Hiển thị tổng tiền giỏ hàng --}}


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-4">
                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Hóa đơn</h3>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Tổng tiền</h4>
                            <h4 class="price theme-color total">0đ</h4>
                        </li>
                    </ul>
                    <div class="button-group cart-button">
                        <ul>
                            <li><a class="btn btn-animation proceed-btn fw-bold checkout-btn disabled"
                                    href="{{ route('cartCheckout') }}">Thanh
                                    toán</a>
                            </li>
                            <li><a class="btn shopping-button text-dark" href="{{ route('index') }}"><i
                                        class="ri-arrow-left-line me-2"></i> Quay lại mua sắm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Hiển thị thông báo nếu có session success hoặc error
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
            // Khi checkbox chọn tất cả được click
            $('#checkbox-table').on('change', function() {
                let isChecked = $(this).prop('checked');
                $('.checkbox-input').prop('checked', isChecked);
                toggleDeleteButton();
            });

            // Khi checkbox con được click
            $('.checkbox-input').on('change', function() {
                let total = $('.checkbox-input').length;
                let checked = $('.checkbox-input:checked').length;
                $('#checkbox-table').prop('checked', total === checked);
                toggleDeleteButton();
            });

            // Khi nhấn nút xóa tất cả
            $('#btn-delete-all').on('click', function(e) {
                e.preventDefault();

                let selectedIds = $('.checkbox-input:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    $('#ids-to-delete').val(selectedIds.join(','));
                    $('#delete-all-form').submit();
                }
            });

            // Hàm ẩn/hiện nút xóa tất cả
            function toggleDeleteButton() {
                let checked = $('.checkbox-input:checked').length > 0;
                $('#btn-delete-all').toggleClass('visually-hidden', !checked);
            }


            // Cập nhật số lượng sản phẩm khi nhấn nút +/- trong giỏ hàng
            $(".qty-left-minus, .qty-right-plus").off("click").on("click", function() {
                let status = '';
                let qtyInput = $(this).closest(".cart_qty").find(".input-number");
                let cartItemId = $(this).closest("tr").data("id");
                let checked = $(this).closest("tr").find(".checkbox-input").prop("checked");
                console.log(checked);

                let qty = parseInt(qtyInput.val()) || 1;
                let maxStock = parseInt(qtyInput.data("max-stock")) || 1;

                // Thay đổi số lượng
                if ($(this).hasClass("qty-left-minus") && qty > 1) {
                    qty -= 1;
                } else if ($(this).hasClass("qty-right-plus") && qty < maxStock) {
                    qty += 1;
                }

                qtyInput.val(qty);

                // Gọi hàm cập nhật giỏ hàng và cập nhật session ngay lập tức
                if (!checked) {
                    updateCartQuantity(cartItemId, qty, qtyInput);
                } else {
                    let obj = {
                        type: "check"
                    }
                    updateCartQuantity(cartItemId, qty, qtyInput, obj);
                }

                updateCartSession(); // 🔥 Cập nhật session ngay lập tức
                updateTotalPrice(); // Cập nhật tổng tiền sau khi thay đổi
            });

            // Xử lý khi thay đổi giá trị trực tiếp trong input số lượng
            $(".input-number").on("change", function() {
                let cartItemId = $(this).closest("tr").data("id");
                let newQty = parseInt($(this).val()) || 1;
                let maxStock = parseInt($(this).data("max-stock")) || 1;

                // Đảm bảo giá trị số lượng hợp lệ
                if (newQty < 1) {
                    newQty = 1;
                } else if (newQty > maxStock) {
                    newQty = maxStock;
                }

                $(this).val(newQty);

                // Gọi hàm cập nhật giỏ hàng và cập nhật session ngay lập tức
                updateCartQuantity(cartItemId, newQty, $(this));
                updateCartSession(); // 🔥 Cập nhật session ngay lập tức
                updateTotalPrice(); // Cập nhật tổng tiền sau khi thay đổi
            });

            // Cập nhật giỏ hàng trong dropdown cart (header)
            function updateDropdownCart(cartItemId, newQty, newsSubtotal) {
                console.log("🔄 Đang cập nhật dropdown cart:", cartItemId, newQty, newsSubtotal); // 🔥 Debug

                let dropdownItem = $(".drop-cart[data-id='" + cartItemId + "']");

                if (dropdownItem.length) {
                    // Cập nhật số lượng hiển thị
                    dropdownItem.find(".input-number").text(newQty + " x");

                    // Kiểm tra nếu `newSubtotal` từ server đã có thì dùng, nếu không thì tự tính lại
                    let price = parseInt(dropdownItem.find(".sale_price").val()) || 0;
                    // let totalPrice = price * newQty;

                    dropdownItem.find("h6").html(
                        newQty + " x " + price.toLocaleString("vi-VN") + "đ"
                    );

                    // console.log("✅ Dropdown cart đã cập nhật:", dropdownItem.html()); // Kiểm tra DOM có đổi chưa
                } else {
                    // console.log("❌ Không tìm thấy .drop-cart[data-id='" + cartItemId + "']");
                }
            }

            // Cập nhật tổng giá trị trong dropdown cart

            function updateDropdownTotal() {
                let selectedProducts = [];
                let totalSum = 0;

                $(".product-box-contain.product-item").each(function() {
                    let row = $(this);
                    let cartItemId = row.data("id");
                    let qty = parseInt(row.find(".input-number").val()) || 1;
                    let productId = row.data("product-id") || null;
                    let productVariantId = row.data("product-variant-id") || null;
                    let productName = row.find(".name_product").text().trim();
                    let nameVariant = row.find(".selected-variation").text().trim() || null;
                    let imageUrl = row.find(".product-image img").attr("src") || "";

                    // Loại bỏ URL đầy đủ, chỉ giữ phần đường dẫn sau "/storage/"
                    if (imageUrl.startsWith("http")) {
                        let url = new URL(imageUrl);
                        imageUrl = url.pathname.replace("/storage/", "").replace(/^\/+/, "");
                    }
                    // Lấy giá của sản phẩm gốc
                    let originalPrice = parseInt(row.find(".price").val()) || 0;
                    let salePrice = parseInt(row.find(".old_price").val()) || 0;

                    // Lấy giá của biến thể
                    let priceVariant = parseInt(row.find(".price_variant").val()) || 0;
                    let salePriceVariant = parseInt(row.find(".old_price_variant").val()) || 0;

                    let isSale = parseInt(row.find(".is_sale").val());
                    let stock = parseInt(row.find(".stock").val());


                    let finalPrice, oldPrice;
                    let finalPriceVariant, oldPriceVariant;

                    // Xử lý giá cho sản phẩm gốc
                    if (isSale == 1) {
                        finalPrice = salePrice > 0 ? salePrice : originalPrice;
                        oldPrice = salePrice > 0 ? originalPrice : null;
                    } else {
                        finalPrice = originalPrice > 0 ? originalPrice : 0;
                        oldPrice = null;
                    }

                    // Xử lý giá cho sản phẩm biến thể (nếu có)
                    finalPriceVariant = salePriceVariant > 0 ? salePriceVariant : priceVariant;
                    oldPriceVariant = salePriceVariant > 0 ? priceVariant : null;

                    selectedProducts.push({
                        id: cartItemId,
                        product_id: productId,
                        product_variant_id: productVariantId,
                        name: productName,
                        name_variant: nameVariant,
                        image: imageUrl,
                        price: finalPrice, // Lưu giá của sản phẩm gốc
                        old_price: oldPrice, // Lưu giá cũ của sản phẩm gốc
                        price_variant: productVariantId ? finalPriceVariant : null,
                        old_price_variant: productVariantId ? oldPriceVariant : null,
                        quantity: productVariantId ? null : qty,
                        quantity_variant: productVariantId ? qty : null,
                        is_sale: isSale,
                        stock: stock,
                    });

                    totalSum += (productVariantId ?
                            (isSale == 1 ? finalPriceVariant : (oldPriceVariant ??
                                finalPriceVariant)) // Nếu có biến thể
                            :
                            (isSale == 1 ? finalPrice : (oldPrice ?? finalPrice))) // Nếu không có biến thể
                        *
                        qty;

                });

                $.ajax({
                    url: "{{ route('cart.saveSession') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        selectedProducts: selectedProducts,
                        total: totalSum
                    },
                    success: function(response) {
                        let price = numberFormat(response.total)
                        $(".total-dropdown-price").text(price);
                    }
                });
            }

            function updateDropdownTotal2(status) {
                let totalDrop = $(".total-dropdown-price").text().replace('đ', '').trim();

                // Loại bỏ tất cả dấu chấm (dùng regex) để có số nguyên đúng
                let number = Number(totalDrop.replace(/\./g, ''));

                let selectedProducts = [];
                let selectedProducts2 = [];
                let totalSum = 0;
                let totalSum2 = 0;

                $(".product-box-contain.product-item").each(function() {
                    let row = $(this);
                    let checked = row.find(".checkbox-input").prop('checked');

                    if (checked) {
                        let cartItemId = row.data("id");
                        let qty = parseInt(row.find(".input-number").val()) || 1;
                        let productId = row.data("product-id") || null;
                        let productVariantId = row.data("product-variant-id") || null;
                        let productName = row.find(".name_product").text().trim();
                        let nameVariant = row.find(".selected-variation").text().trim() || null;
                        let imageUrl = row.find(".product-image img").attr("src") || "";

                        // Loại bỏ URL đầy đủ, chỉ giữ phần đường dẫn sau "/storage/"
                        if (imageUrl.startsWith("http")) {
                            let url = new URL(imageUrl);
                            imageUrl = url.pathname.replace("/storage/", "").replace(/^\/+/, "");
                        }
                        // Lấy giá của sản phẩm gốc
                        let originalPrice = parseInt(row.find(".price").val()) || 0;
                        let salePrice = parseInt(row.find(".old_price").val()) || 0;

                        // Lấy giá của biến thể
                        let priceVariant = parseInt(row.find(".price_variant").val()) || 0;
                        let salePriceVariant = parseInt(row.find(".old_price_variant").val()) || 0;
                        let isSale = parseInt(row.find(".is_sale").val());
                        let stock = parseInt(row.find(".stock").val());
                        let finalPrice, oldPrice;
                        let finalPriceVariant, oldPriceVariant;

                        // Xử lý giá cho sản phẩm gốc
                        if (isSale == 1) {
                        finalPrice = salePrice > 0 ? salePrice : originalPrice;
                        oldPrice = salePrice > 0 ? originalPrice : null;
                    } else {
                        finalPrice = originalPrice > 0 ? originalPrice : 0;
                        oldPrice = null;
                    }

                        // Xử lý giá cho sản phẩm biến thể (nếu có)
                        finalPriceVariant = salePriceVariant > 0 ? salePriceVariant : priceVariant;
                        oldPriceVariant = salePriceVariant > 0 ? priceVariant : null;

                        selectedProducts.push({
                            id: cartItemId,
                            product_id: productId,
                            product_variant_id: productVariantId,
                            name: productName,
                            name_variant: nameVariant,
                            image: imageUrl,
                            price: finalPrice, // Lưu giá của sản phẩm gốc
                            old_price: oldPrice, // Lưu giá cũ của sản phẩm gốc
                            price_variant: productVariantId ? finalPriceVariant : null,
                            old_price_variant: productVariantId ? oldPriceVariant : null,
                            quantity: productVariantId ? null : qty,
                            quantity_variant: productVariantId ? qty : null,
                            is_sale: isSale,
                            stock: stock,
                        });

                        totalSum += (productVariantId ?
                                (isSale == 1 ? finalPriceVariant : (oldPriceVariant ??
                                    finalPriceVariant)) // Nếu có biến thể
                                :
                                (isSale == 1 ? finalPrice : (oldPrice ?? finalPrice))
                            ) // Nếu không có biến thể
                            *
                            qty;

                    }
                });

                $(".product-box-contain.product-item").each(function() {
                    let row = $(this);
                    let cartItemId = row.data("id");
                    let qty = parseInt(row.find(".input-number").val()) || 1;
                    let productId = row.data("product-id") || null;
                    let productVariantId = row.data("product-variant-id") || null;
                    let productName = row.find(".name_product").text().trim();
                    let nameVariant = row.find(".selected-variation").text().trim() || null;
                    let imageUrl = row.find(".product-image img").attr("src") || "";

                    // Loại bỏ URL đầy đủ, chỉ giữ phần đường dẫn sau "/storage/"
                    if (imageUrl.startsWith("http")) {
                        let url = new URL(imageUrl);
                        imageUrl = url.pathname.replace("/storage/", "").replace(/^\/+/, "");
                    }
                    // Lấy giá của sản phẩm gốc
                    let originalPrice = parseInt(row.find(".price").val()) || 0;
                    let salePrice = parseInt(row.find(".old_price").val()) || 0;

                    // Lấy giá của biến thể
                    let priceVariant = parseInt(row.find(".price_variant").val()) || 0;
                    let salePriceVariant = parseInt(row.find(".old_price_variant").val()) || 0;
                    let isSale = parseInt(row.find(".is_sale").val());
                    let stock = parseInt(row.find(".stock").val());
                    let finalPrice, oldPrice;
                    let finalPriceVariant, oldPriceVariant;

                    // Xử lý giá cho sản phẩm gốc
                    if (isSale == 1) {
                        finalPrice = salePrice > 0 ? salePrice : originalPrice;
                        oldPrice = salePrice > 0 ? originalPrice : null;
                    } else {
                        finalPrice = originalPrice > 0 ? originalPrice : 0;
                        oldPrice = null;
                    }

                    // Xử lý giá cho sản phẩm biến thể (nếu có)
                    finalPriceVariant = salePriceVariant > 0 ? salePriceVariant : priceVariant;
                    oldPriceVariant = salePriceVariant > 0 ? priceVariant : null;

                    selectedProducts2.push({
                        id: cartItemId,
                        product_id: productId,
                        product_variant_id: productVariantId,
                        name: productName,
                        name_variant: nameVariant,
                        image: imageUrl,
                        price: finalPrice, // Lưu giá của sản phẩm gốc
                        old_price: oldPrice, // Lưu giá cũ của sản phẩm gốc
                        price_variant: productVariantId ? finalPriceVariant : null,
                        old_price_variant: productVariantId ? oldPriceVariant : null,
                        quantity: productVariantId ? null : qty,
                        quantity_variant: productVariantId ? qty : null,
                        is_sale: isSale,
                        stock: stock,
                    });

                    totalSum2 += (productVariantId ?
                            (isSale == 1 ? finalPriceVariant : (oldPriceVariant ??
                                finalPriceVariant)) // Nếu có biến thể
                            :
                            (isSale == 1 ? finalPrice : (oldPrice ?? finalPrice))) // Nếu không có biến thể
                        *
                        qty;


                });

                $.ajax({
                    url: "{{ route('cart.saveSession') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        selectedProducts: selectedProducts,
                        total: totalSum,
                        type: 'price'
                    },
                    success: function(response) {
                        let price = parseInt(response.total2) || 0; // Đảm bảo giá trị là số
                        console.log("Status:", status, "Price:", price);

                        let lastPrice = totalSum2;

                        console.log("Last Price:", lastPrice);

                        $(".total-dropdown-price").text(numberFormat(lastPrice));
                    }
                });
            }

            function numberFormat(x) {
                let formatted = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(x);

                // Thay thế "VND" bằng "đ"
                return formatted.replace('VND', 'đ');
            }

            // Hàm AJAX cập nhật giỏ hàng
            function updateCartQuantity(cartItemId, newQty, qtyInput, data) {
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cartItemId,
                        quantity: newQty
                    },
                    success: function(response) {
                        console.log("Response từ server:", response);
                        if (response.success) {
                            qtyInput.closest("tr").find(".subtotal h5").text(response.newSubtotal);
                            updateTotalPrice(); // Cập nhật tổng tiền giỏ hàng
                            updateDropdownCart(cartItemId, newQty, response
                                .newSubtotal); // Cập nhật dropdown cart ngay lập tức
                            if (data && data.type) {
                                updateDropdownTotal2(data
                                    .status); // Cập nhật tổng tiền trong dropdown cart
                            } else {
                                updateDropdownTotal(); // Cập nhật tổng tiền trong dropdown cart
                            }
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Lỗi!",
                            text: "Không thể cập nhật số lượng.",
                            showConfirmButton: true
                        });
                    }
                });
            }

            // Cập nhật tổng tiền
            function updateTotalPrice() {
                let totalSum = 0;

                $(".checkbox-input:checked").each(function() {
                    let row = $(this).closest("tr");
                    let priceText = row.find(".subtotal h5").text().trim();
                    let price = parseInt(priceText.replace(/\D/g, "")) || 0;

                    totalSum += price;
                });

                // Cập nhật tổng tiền trong giao diện
                $(".summery-total .total").text(totalSum.toLocaleString("vi-VN") + "đ");
                $(".summery-contain .total").text(totalSum.toLocaleString("vi-VN") + "đ");
            }

            // Hàm lưu session giỏ hàng
            function updateCartSession() {

                let selectedProducts = [];
                let totalSum = 0;

                $(".checkbox-input:checked").each(function() {
                    let row = $(this).closest("tr");
                    let cartItemId = row.data("id");
                    let qty = parseInt(row.find(".input-number").val()) || 1;
                    let productId = row.data("product-id") || null;
                    let productVariantId = row.data("product-variant-id") || null;
                    let productName = row.find(".name_product").text().trim();
                    let nameVariant = row.find(".selected-variation").text().trim() || null;
                    let imageUrl = row.find(".product-image img").attr("src") || "";

                    // Loại bỏ URL đầy đủ, chỉ giữ phần đường dẫn sau "/storage/"
                    if (imageUrl.startsWith("http")) {
                        let url = new URL(imageUrl);
                        imageUrl = url.pathname.replace("/storage/", "").replace(/^\/+/, "");
                    }
                    // Lấy giá của sản phẩm gốc
                    let originalPrice = parseInt(row.find(".price").val()) || 0;
                    let salePrice = parseInt(row.find(".old_price").val()) || 0;

                    // Lấy giá của biến thể
                    let priceVariant = parseInt(row.find(".price_variant").val()) || 0;
                    let salePriceVariant = parseInt(row.find(".old_price_variant").val()) || 0;
                    let isSale = parseInt(row.find(".is_sale").val());
                    let stock = parseInt(row.find(".stock").val());
                    let finalPrice, oldPrice;
                    let finalPriceVariant, oldPriceVariant;

                    // Xử lý giá cho sản phẩm gốc
                    if (isSale == 1) {
                        finalPrice = salePrice > 0 ? salePrice : originalPrice;
                        oldPrice = salePrice > 0 ? originalPrice : null;
                    } else {
                        finalPrice = originalPrice > 0 ? originalPrice : 0;
                        oldPrice = null;
                    }

                    // Xử lý giá cho sản phẩm biến thể (nếu có)
                    finalPriceVariant = salePriceVariant > 0 ? salePriceVariant : priceVariant;
                    oldPriceVariant = salePriceVariant > 0 ? priceVariant : null;

                    selectedProducts.push({
                        id: cartItemId,
                        product_id: productId,
                        product_variant_id: productVariantId,
                        name: productName,
                        name_variant: nameVariant,
                        image: imageUrl,
                        price: finalPrice, // Lưu giá của sản phẩm gốc
                        old_price: oldPrice, // Lưu giá cũ của sản phẩm gốc
                        price_variant: productVariantId ? finalPriceVariant : null,
                        old_price_variant: productVariantId ? oldPriceVariant : null,
                        quantity: productVariantId ? null : qty,
                        quantity_variant: productVariantId ? qty : null,
                        is_sale: isSale,
                        stock: stock,
                    });

                    totalSum += (productVariantId ?
                            (isSale == 1 ? finalPriceVariant : (oldPriceVariant ??
                                finalPriceVariant)) // Nếu có biến thể
                            :
                            (isSale == 1 ? finalPrice : (oldPrice ?? finalPrice))) // Nếu không có biến thể
                        *
                        qty;

                });

                console.log("Dữ liệu gửi lên:", selectedProducts);
                console.log("Tổng tiền:", totalSum);
                

                $.ajax({
                    url: "{{ route('cart.saveSession') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        selectedProducts: selectedProducts,
                        total: totalSum
                    },
                    success: function(response) {
                        console.log("Session updated!", response);
                    },
                });
            }


            function toggleCheckoutButton() {
                let hasCheckedItems = $(".checkbox-input:checked").length > 0;

                if (hasCheckedItems) {
                    $(".checkout-btn").removeClass("disabled"); // Bật nút
                } else {
                    $(".checkout-btn").addClass("disabled"); // Disable nếu không có sản phẩm nào
                }
            }
            // Cập nhật session khi checkbox thay đổi
            $(".checkbox-input").on("click", function() {
                updateCartSession();
                toggleCheckoutButton();
                updateTotalPrice(); // Cập nhật tổng tiền ngay khi thay đổi checkbox
            });

            // Cập nhật session và tổng tiền khi chọn tất cả
            $("#checkbox-table").on("click", function() {
                $(".checkbox-input").prop("checked", $(this).prop("checked"));
                updateCartSession(); // Cập nhật ngay lập tức khi chọn tất cả
                toggleCheckoutButton();
                updateTotalPrice(); // Cập nhật tổng tiền ngay khi chọn tất cả
            });
            toggleCheckoutButton();

            // comapre-count
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

            function updateCompareCountBadge() {
                const compareCookieName = 'compare_list';
                const compareListCookie = getCookie(compareCookieName);
                let compareCount = 0;
                if (compareListCookie) {
                    try {
                        const compareList = JSON.parse(compareListCookie);
                        compareCount = compareList.length;
                    } catch (error) {
                        console.error('Lỗi khi parse cookie compare_list:', error);
                    }
                }
                $('#compare-count-badge').text(compareCount);
                if (compareCount > 0) {
                    $('#compare-count-badge').show(); // Hoặc sử dụng class để hiển thị
                } else {
                    $('#compare-count-badge').hide(); // Hoặc sử dụng class để ẩn
                }
            }

            // Gọi hàm này khi trang sản phẩm được tải
            updateCompareCountBadge(); //end compare

        });
    </script>
@endpush
