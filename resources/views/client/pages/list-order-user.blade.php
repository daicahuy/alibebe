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

        .btn-not-get:hover {
            color: #ccc !important;
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
    </style>s
@endpush


@section('content')
    <div class="container-fluid-lg">
        <!-- Tabs -->
        <ul class="nav nav-tabs tab-menu">
            <li class="nav-item">
                <a class="nav-link active" href="#">Tất cả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Chờ xử lý</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đang xử lý </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đang giao hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đã giao hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Giao hàng thất bại</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Hoàn thành</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Đã hủy</a>
            </li>
        </ul>

        <!-- Search Bar -->
        <div class="mt-3 mb-3">
            <input type="text" class="form-control"
                placeholder="Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm">
        </div>

        <!-- Order Card 1 -->
        <div class="order-card">

            <div class="d-flex flex-end p-2" style="flex-direction: row-reverse">
                <span class="badge bg-success complete ms-2" style="font-size: 1.2em">Hoàn thành</span>
                <span class="order-status">Đơn hàng đã được giao thành công</span>
            </div>
            <div class="d-flex flex-row" style="justify-content: space-between; align-items: center;">

                <div class="order-body d-flex">
                    <img src="https://via.placeholder.com/100" alt="Product" class="me-3"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="d-flex flex-row" style="justify-content: space-between">
                        <div>

                            <p class="mb-1">Áo Thể Thao Nam TSIMPLE cổ tròn tay ngắn tập gym vải thun lạnh thoáng mát co
                                giãn
                                chuẩn form AHRBC</p>
                            <p class="text-muted mb-1" style="font-size: 14px;">Phân loại hàng: Đen, XL (63 - 74kg)</p>
                            <p class="text-muted mb-1" style="font-size: 14px;">x1</p>
                        </div>

                    </div>
                </div>
                <div>
                    <span class="price-old">415.000₫</span>
                    <span class="price-new ms-2">89.000₫</span>
                </div>
            </div>
            <div class="order-footer">
                <div class="d-flex flex-row">
                    <button class="btn  me-2 btn-not-get" style="background-color: green; color: #fff;">Đã nhận </button>
                    <button class="btn btn-reorder me-2">Chưa nhận </button>
                </div>
                <div>
                    <span>Thành tiền: </span>
                    <span class="price-new">₫95.702</span>
                </div>
            </div>
        </div>

        <!-- Order Card 2 -->

    </div>
@endsection
