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
                                    <tr class="product-box-contain" data-id="{{ $cartItem->id }}">
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
                                                <a class="product-image" href="/fastkart/product/fresh-pear">
                                                    <img alt="product" class="img-fluid"
                                                        src="{{ Storage::url($thumbnail) }}">
                                                </a>

                                                <div class="product-detail">
                                                    <ul>
                                                        <li class="name">
                                                            <a class="name_product" href="/fastkart/product/fresh-pear">
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
                                            // Nếu sản phẩm có biến thể, lấy giá từ biến thể, nếu không thì lấy từ product
                                            $price = $cartItem->productVariant->price ?? $cartItem->product->price;
                                            $salePrice =
                                                $cartItem->productVariant?->sale_price > 0
                                                    ? $cartItem->productVariant->sale_price
                                                    : $price;
                                            $saving = $price - $salePrice;

                                            // Tính tổng tiền sản phẩm này
                                            $sumOnePrd = $cartItem->quantity * $salePrice;
                                            $totalSum += $sumOnePrd;
                                        @endphp


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

                                        <td class="quantity" >
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
                                                            class="form-control input-number">

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
                        <h3>Tổng giỏ hàng</h3>
                    </div>
                    <div class="summery-contain">
                        <ul>
                            <li>
                                <h4>Tổng cộng</h4>
                                <h4 class="price total">0đ</h4>
                            </li>
                           
                        </ul>
                    </div>
                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Tổng tiền</h4>
                            <h4 class="price theme-color total">0đ</h4>
                        </li>
                    </ul>
                    <div class="button-group cart-button">
                        <ul>
                            <li><a class="btn btn-animation proceed-btn fw-bold" href="/fastkart/checkout">Thanh toán</a>
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

@section('modal')
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

    $(".qty-left-minus").off("click").on("click", function () {
        let qtyInput = $(this).closest(".cart_qty").find(".input-number");
        let cartItemId = $(this).closest("tr").data("id"); // Lấy ID sản phẩm
        let qty = parseInt(qtyInput.val()) || 1;
        if (qty > 1) {
            qtyInput.val(qty - 1);
            updateCartQuantity(cartItemId, qty - 1, qtyInput);
        }
    });

    $(".qty-right-plus").off("click").on("click", function () {
        let qtyInput = $(this).closest(".cart_qty").find(".input-number");
        let cartItemId = $(this).closest("tr").data("id"); // Lấy ID sản phẩm
        let qty = parseInt(qtyInput.val()) || 1;
        qtyInput.val(qty + 1);
        updateCartQuantity(cartItemId, qty + 1, qtyInput);
    });

    // --- Logic Checkbox ---
    $('#checkbox-table').on('click', function() {
        let isChecked = $(this).prop('checked');
        $('.checkbox-input').prop('checked', isChecked);
        toggleDeleteAllButton();
        updateIdsToDelete();
        updateTotalPrice(); // Cập nhật tổng tiền khi chọn tất cả
    });

    $('.checkbox-input').on('click', function() {
        const total = $('.checkbox-input').length;
        const checked = $('.checkbox-input:checked').length;

        $('#checkbox-table').prop('checked', total === checked);
        toggleDeleteAllButton();
        updateIdsToDelete();
        updateTotalPrice(); // Cập nhật tổng tiền khi chọn checkbox
    });

    function toggleDeleteAllButton() {
        if ($('.checkbox-input:checked').length > 0) {
            $('#btn-delete-all').removeClass('visually-hidden');
        } else {
            $('#btn-delete-all').addClass('visually-hidden');
        }
    }

     // Hàm AJAX cập nhật giỏ hàng
     function updateCartQuantity(cartItemId, newQty, qtyInput) {
        $.ajax({
            url: "{{ route('cart.update') }}", // Đặt route cập nhật giỏ hàng
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: cartItemId,
                quantity: newQty
            },
            success: function(response) {
                if (response.success) {

                    qtyInput.closest("tr").find(".subtotal h5").text(response.newSubtotal);
                    updateTotalPrice();
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

    // tính tổng tiền
    function updateIdsToDelete() {
        let selectedIds = [];
        $('.checkbox-input:checked').each(function() {
            selectedIds.push($(this).val());
        });

        $('#ids-to-delete').val(selectedIds.join(',')); 
    }

    function updateTotalPrice() {
        let totalSum = 0;

        $(".checkbox-input:checked").each(function() {
            let row = $(this).closest("tr");
            let priceText = row.find(".subtotal h5").text().trim();
            let price = parseInt(priceText.replace(/\D/g, "")) || 0;

            totalSum += price;
        });

        $(".summery-total .total").text(totalSum.toLocaleString("vi-VN") + "đ");
        $(".summery-contain .total").text(totalSum.toLocaleString("vi-VN") + "đ");
    }

    // --- Phân loại ---
    $(".toggle-button").click(function(e) {
        let $parent = $(this).closest(".variation-selection");
        let $variationBox = $parent.find(".variation-container");

        $(".variation-container").not($variationBox).hide();

        let buttonOffset = $(this).offset();
        let buttonHeight = $(this).outerHeight();

        $variationBox.css({
            "top": buttonOffset.top + buttonHeight + 5 + "px",
            "left": buttonOffset.left + "px",
            "position": "absolute",
            "z-index": "1000",
            "display": "block"
        });

        e.stopPropagation();
    });

    $(".product-variation").click(function() {
        let $parent = $(this).closest(".variation-selection");
        let type = $(this).data("type");
        let value = $(this).data("value");

        if (type === "size") {
            $parent.data("selectedSize", value);
            $parent.find("[data-type='size']").removeClass("product-variation--selected");
        } else if (type === "color") {
            $parent.data("selectedColor", value);
            $parent.find("[data-type='color']").removeClass("product-variation--selected");
        }

        $(this).addClass("product-variation--selected");
    });

    $(".confirm-btn").click(function() {
        let $parent = $(this).closest(".variation-selection");
        let selectedSize = $parent.data("selectedSize") || "1 Chiếc 1cm";
        let selectedColor = $parent.data("selectedColor") || "Bạc";

        $parent.find(".selected-variation").text(`${selectedSize}, ${selectedColor}`);
        $parent.find(".variation-container").hide();
    });

    $(".cancel-btn").click(function() {
        $(this).closest(".variation-selection").find(".variation-container").hide();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest(".variation-selection").length) {
            $(".variation-container").hide();
        }
    });
});

    </script>
@endpush
