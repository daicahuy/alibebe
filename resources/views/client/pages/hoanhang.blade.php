@extends('client.layouts.master')

@push('css')
    <style>
        .tab-menu .nav-link {
            font-size: 14px;
            font-weight: bold;
        }

        .tab-menu .nav-link.active {
            border-bottom: 2px solid red;
            color: red;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .order-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            font-weight: bold;
        }

        .order-header .badge {
            font-size: 18px;
            padding: 12px 14px;
        }

        .order-body {
            padding: 15px;
        }

        .order-footer {
            padding: 10px 15px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-reorder {
            background-color: #ff5722;
            color: #fff;
        }

        .btn-reorder:hover {
            background-color: #e64a19;
            color: #ccc
        }

        .btn-return {
            border: 1px solid #adadad;
            color: #040404;
        }

        .btn-return:hover {
            background-color: #8d8b8b;
            color: #fff
        }

        .btn-success-return {
            background-color: #0da487;
            color: #fff
        }

        .btn-success-return:hover {
            background-color: #0c8b72;
            color: #fff
        }

        .btn-not-get:hover {
            color: #ffffff !important;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
        }

        .price-new {
            color: red;
            font-weight: bold;
            font-size: 16px;
        }

        .order-status {
            font-size: 16px;
            color: #28a745;
            font-weight: bold;
        }

        .order-status.complete {
            color: #dc3545;
        }

        #loading-icon-load {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loading-icon {
            animation: rotate 2s linear infinite;
            width: 100px;
            height: 100px;

        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush


@section('content')
    @php
        use App\Enums\OrderStatusType;
        use App\Enums\CouponDiscountType;

        $CouponDiscountType_PERCENT = CouponDiscountType::PERCENT;
        $CouponDiscountType_FIX_AMOUNT = CouponDiscountType::FIX_AMOUNT;

    @endphp
    <div class="container-fluid-lg">
        <!-- Tabs -->
        <ul class="nav nav-tabs tab-menu">
            <li class="nav-item tab" data-status="">
                <p class="nav-link active" style="cursor: pointer">Tất cả</p>
            </li>
            <li class="nav-item tab" data-status="1">
                <p class="nav-link" style="cursor: pointer">Chờ xử lý</p>
            </li>
            <li class="nav-item tab" data-status="2">
                <p class="nav-link" style="cursor: pointer">Đang xử lý </p>
            </li>
            <li class="nav-item tab" data-status="3">
                <p class="nav-link" style="cursor: pointer">Đang giao hàng</p>
            </li>
            <li class="nav-item tab" data-status="4">
                <p class="nav-link" style="cursor: pointer">Đã giao hàng</p>
            </li>
            <li class="nav-item tab" data-status="5">
                <p class="nav-link" style="cursor: pointer">Giao hàng thất bại</p>
            </li>
            <li class="nav-item tab" data-status="6">
                <p class="nav-link" style="cursor: pointer">Hoàn thành</p>
            </li>
            <li class="nav-item tab" data-status="7">
                <p class="nav-link" style="cursor: pointer">Đã hủy</p>
            </li>
            <li class="nav-item tab" data-status="8">
                <p class="nav-link" style="cursor: pointer">Hoàn hàng</p>
            </li>
        </ul>

        <!-- Search Bar -->
        <div class="mt-3 mb-3">
            <input type="text" class="form-control" id="inputSearchOrder"
                placeholder="Bạn có thể tìm kiếm theo ID đơn hàng hoặc Tên Sản phẩm" fdprocessedid="sicgy">
        </div>


        <div id="listCard">
            <div class="order-card">

                <div class="d-flex justify-content-between align-items-center p-2">
                    <h4 class="ml-3 d-block">ID: ORDER-11032025134330.273-553</h4>

                    <div class="d-flex align-items-center">
                        <div class="d-flex" style="align-items:center">
                            <span class="badge bg-warning complete ms-2" style="font-size: 1.2em; " data-bs-toggle="modal" data-bs-target="#reasonModal">
                                Lý do
                            </span>
                        </div>
                        <span class="badge bg-success complete ms-2" style="font-size: 1.2em; ">
                            Hoàn hàng
                        </span>



                    </div>
                </div>


                <div class="d-flex flex-row"
                    style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                    <div class="order-body d-flex">
                        <img src="http://127.0.0.1:8000/storage/products/product_2.png" alt="Product" class="me-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="d-flex flex-row" style="justify-content: space-between">
                            <div>
                                <p class="mb-1">Laptop Z63 Ultra 691...</p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    Phân loại hàng: 256GB,
                                    Màu đen
                                </p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    x1
                                </p>
                                <div style="margin-right: 15px">
                                    <span class="price-old"></span>
                                    <span class="price-new ms-2">
                                        8.268.070,00₫
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row" style="margin-right: 15px">
                        <span>Thành tiền:</span>
                        <p class="price-new">8.268.070,00₫</p>
                    </div>
                </div>

                <div class="d-flex flex-row"
                    style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                    <div class="order-body d-flex">
                        <img src="http://127.0.0.1:8000/storage/products/product_2.png" alt="Product" class="me-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="d-flex flex-row" style="justify-content: space-between">
                            <div>
                                <p class="mb-1">Smartwatch S41 Air 6...</p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    Phân loại hàng: 128GB,
                                    Màu đen
                                </p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    x1
                                </p>
                                <div style="margin-right: 15px">
                                    <span class="price-old"></span>
                                    <span class="price-new ms-2">
                                        1.087.235,00₫
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row" style="margin-right: 15px">
                        <span>Thành tiền:</span>
                        <p class="price-new">1.087.235,00₫</p>
                    </div>
                </div>

                <div class="order-footer">
                    <div class="">
                        <p style="margin: 0">Tên khách hàng: đẹp trai nhất thiên hạ</p>
                        <p style="margin: 0">STK: 123123123123</p>
                        <p style="margin: 0">Tên người nhận: NGUYEN MINH QUAN</p>
                        <p style="margin: 0">Ngân hàng: Techcombank</p>
                    </div>
                    <div>
                        <div>
                            <div>
                                <span>Tổng tiền: </span>
                                <span class="price-new">9.355.305,00₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Order Card 2 -->
            <nav aria-label="Page navigation example" class="mt-3">
                <ul class="pagination justify-content-center" id="pagination">
                    <li class="page-item first disabled"><a href="#" class="page-link">First</a></li>
                    <li class="page-item prev disabled"><a href="#" class="page-link">Previous</a></li>
                    <li class="page-item active"><a href="#" class="page-link">1</a></li>
                    <li class="page-item next disabled"><a href="#" class="page-link">Next</a></li>
                    <li class="page-item last disabled"><a href="#" class="page-link">Last</a></li>
                </ul>
            </nav>


        </div>
    @endsection
    @section('modal')
    <!-- Return Order Modal Start -->
    <div class="modal fade theme-modal view-modal" id="reasonModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-m modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div id="address-container" class="flex justify-between">
                            <div class="flex items-start">
                                <div>
                                    <h4 class="mt-3">Lý do:</h4>
                                    <textarea id="returnReason" class="form-control" disabled>Hàng rõ là đểu, mua về chơi phi phai được 2 trận đã hết pin</textarea>
                                    <p>Hình ảnh minh chứng:</p>
                                    <img src="http://127.0.0.1:8000/storage/products/product_2.png" alt="Product"
                                            class="me-3" style="width: 100px; height: 100px; object-fit: cover;"><br>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Return Order Modal End -->
@endsection