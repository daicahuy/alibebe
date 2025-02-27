@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-coupons">
        <div class="title text-center">
            <h2 class="fw-bold" style="color: #0da487;">Mã Giảm Giá Của Tôi</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
        </div>

        <div class="my-coupons mt-4">
            <div class="row g-4">
                <div id="couponCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($coupons->chunk(3) as $key => $chunk)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <div class="row">
                                    @foreach ($chunk as $coupon)
                                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                                            <div class="coupon-box p-4 rounded shadow-sm text-center"
                                                style="background-color: #d1f2eb; border-left: 5px solid #0da487;">
                                                <h4 class="fw-bold">
                                                    <a href="{{route('index')}}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Mua Sản Phẩm Ngay">
                                                        {{ $coupon->code }}
                                                    </a>
                                                    <span class="badge" style="background-color: #0da487; color: white;">
                                                        {{ $coupon->discount_value }}
                                                        {{ $coupon->discount_type == 0 ? 'Vnđ' : '%' }}
                                                    </span>
                                                </h4>
                                                <p class="text-muted text-truncate mt-3" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ $coupon->description }}">
                                                    {{ Str::limit($coupon->description, 50) }}
                                                </p>
        
                                                <hr>
                                                <ul class="list-unstyled text-start">
                                                    <li><strong>Hạn sử dụng:</strong>
                                                        {{ $coupon->is_expired == 1 ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : 'Vĩnh Viễn' }}
                                                    </li>
                                                    <li><strong>Trạng thái:</strong>
                                                        {{ $coupon->is_active ? 'Đang hoạt động' : 'Hết hạn' }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Nút điều hướng -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#couponCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#couponCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
               

        <div class="title text-center mt-5">
            <h2 class="fw-bold" style="color: #0da487;">Danh Sách Mã Giảm Giá</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
        </div>

        <div class="filter-section p-4 bg-white rounded shadow-sm mt-4">
            <form method="GET" action="" id="filter-form">
                <div class="row g-3">
                    <div class="col-md-12 text-center">
                        <label for="coupon-type" class="form-label fw-bold" style="color: #0da487;">Loại Mã Giảm
                            Giá:</label>
                        <div class="btn-group w-100 pb-2 pt-2 d-flex justify-content-center" role="group"
                            aria-label="Coupon Type">
                            <div class="d-inline-block mx-2">
                                <input type="radio" class="btn-check" name="coupon_type" id="type-all" value=""
                                    checked>
                                <label class="btn" style="background-color: #0da487; color: white;" for="type-all">Tất
                                    cả</label>
                            </div>
                            <div class="d-inline-block mx-2">
                                <input type="radio" class="btn-check" name="coupon_type" id="type-percentage"
                                    value="percentage">
                                <label class="btn" style="background-color: #0da487; color: white;"
                                    for="type-percentage">Giảm %</label>
                            </div>
                            <div class="d-inline-block mx-2">
                                <input type="radio" class="btn-check" name="coupon_type" id="type-fixed" value="fixed">
                                <label class="btn" style="background-color: #0da487; color: white;" for="type-fixed">Giảm
                                    giá cố định</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="coupon-list mt-4">
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="coupon-box p-4 rounded shadow-sm text-center"
                        style="background-color: #e9f7f5; border-left: 5px solid #0da487;">
                        <div class="coupon-icon mb-3">
                            <i class="fas fa-tag fa-2x" style="color: #0da487;"></i>
                        </div>
                        <h4 class="fw-bold">SAVE20 <span class="badge"
                                style="background-color: #0da487; color: white;">20%</span></h4>
                        <p class="text-muted">Giảm 20% cho đơn hàng từ 500k</p>
                        <hr>
                        <ul class="list-unstyled text-start">
                            <li><strong>Áp dụng cho:</strong> Tất cả sản phẩm</li>
                            <li><strong>Hạn sử dụng:</strong> 30/06/2025</li>
                            <li><strong>Trạng thái:</strong> Đang hoạt động</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="coupon-box p-4 rounded shadow-sm text-center"
                        style="background-color: #e9f7f5; border-left: 5px solid #0da487;">
                        <div class="coupon-icon mb-3">
                            <i class="fas fa-tag fa-2x" style="color: #0da487;"></i>
                        </div>
                        <h4 class="fw-bold">FREESHIP <span class="badge"
                                style="background-color: #0da487; color: white;">Miễn phí</span></h4>
                        <p class="text-muted">Miễn phí vận chuyển cho đơn hàng từ 300k</p>
                        <hr>
                        <ul class="list-unstyled text-start">
                            <li><strong>Áp dụng cho:</strong> Tất cả sản phẩm</li>
                            <li><strong>Hạn sử dụng:</strong> 15/07/2025</li>
                            <li><strong>Trạng thái:</strong> Đang hoạt động</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="coupon-box p-4 rounded shadow-sm text-center"
                        style="background-color: #e9f7f5; border-left: 5px solid #0da487;">
                        <div class="coupon-icon mb-3">
                            <i class="fas fa-tag fa-2x" style="color: #0da487;"></i>
                        </div>
                        <h4 class="fw-bold">DISCOUNT50 <span class="badge"
                                style="background-color: #0da487; color: white;">50K</span></h4>
                        <p class="text-muted">Giảm ngay 50.000đ cho đơn hàng từ 1 triệu</p>
                        <hr>
                        <ul class="list-unstyled text-start">
                            <li><strong>Áp dụng cho:</strong> Tất cả sản phẩm</li>
                            <li><strong>Hạn sử dụng:</strong> 20/08/2025</li>
                            <li><strong>Trạng thái:</strong> Đang hoạt động</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('input[name="coupon_type"]').on('change', function() {
                $('#filter-form').submit();
            });
        });
    </script>
@endpush
