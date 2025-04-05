@extends('admin.layouts.master')

@section('content')
<style>
    .pos-container {
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .product-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 12px;
        overflow: hidden;
        background: white;
    }
    
    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .product-image-wrapper {
        height: 180px;
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 15px;
    }
    
    .stock-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.75rem;
        padding: 5px 10px;
    }
    
    .cart-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        height: calc(100vh - 40px);
        display: flex;
        flex-direction: column;
    }
    
    .cart-items-wrapper {
        flex: 1;
        overflow-y: auto;
        padding-right: 8px;
    }
    
    .cart-item {
        padding: 12px 0;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .quantity-control {
        width: 110px;
    }
    
    .quantity-control input {
        width: 40px !important;
        text-align: center;
    }
    
    @media (max-width: 992px) {
        .cart-section {
            height: auto;
            margin-top: 20px;
        }
        
        .product-image-wrapper {
            height: 150px;
        }
    }
    
    @media (max-width: 576px) {
        .search-filter-row {
            flex-direction: column;
            gap: 10px !important;
        }
    }
</style>

<div class="pos-container">
    <div class="container-fluid py-3">
        <div class="row g-3">
            <!-- Product List Section -->
            <div class="col-lg-8">
                <div class="card border-0">
                    <div class="card-body p-3">
                        <!-- Search and Filter -->
                        <div class="row search-filter-row g-3 mb-4">
                            <div class="col-md-8">
                                <div class="input-group border rounded-pill">
                                    <input type="text" 
                                           class="form-control border-0 rounded-pill" 
                                           placeholder="Tìm kiếm sản phẩm...">
                                    <button class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select rounded-pill">
                                    <option value="">Tất cả danh mục</option>
                                    <option>Điện thoại</option>
                                    <option>Laptop</option>
                                    <option>Phụ kiện</option>
                                </select>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            <!-- Product Item -->
                            <div class="col">
                                <div class="product-card h-100">
                                    <div class="product-image-wrapper">
                                        <img src="https://via.placeholder.com/200x150" 
                                             class="product-image" 
                                             alt="iPhone 14 Pro Max">
                                        <span class="stock-badge badge bg-success">Còn 15</span>
                                    </div>
                                    <div class="p-3">
                                        <h6 class="mb-1 fw-semibold">iPhone 14 Pro Max 128GB</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-danger fw-bold fs-5">25.990.000đ</span>
                                                <del class="text-muted small d-block">27.990.000đ</del>
                                            </div>
                                            <button class="btn btn-primary rounded-circle p-2">
                                                <i class="bi bi-cart-plus fs-5"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- More products... -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="col-lg-4">
                <div class="cart-section">
                    <div class="card-body p-3">
                        <h5 class="card-title mb-4 d-flex align-items-center">
                            <i class="bi bi-cart3 fs-4 me-2"></i>
                            <span class="fw-semibold">Giỏ hàng</span>
                        </h5>

                        <div class="cart-items-wrapper">
                            <!-- Cart Item -->
                            <div class="cart-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">iPhone 14 Pro Max</h6>
                                        <div class="text-muted small">25.990.000đ x 1</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="input-group quantity-control">
                                            <button class="btn btn-outline-secondary btn-sm rounded-start">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   value="1">
                                            <button class="btn btn-outline-secondary btn-sm rounded-end">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <button class="btn btn-link text-danger p-0">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- More cart items... -->
                        </div>

                        <!-- Cart Summary -->
                        <div class="cart-summary border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính:</span>
                                <span class="fw-semibold">57.980.000đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">VAT (10%):</span>
                                <span class="fw-semibold">5.798.000đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">Tổng tiền:</span>
                                <span class="text-danger fw-bold fs-5">63.778.000đ</span>
                            </div>

                            <button class="btn btn-danger w-100 rounded-pill py-2">
                                <i class="bi bi-credit-card me-2"></i>Thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection