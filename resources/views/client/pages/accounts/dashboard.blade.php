@extends('client.pages.accounts.layouts.master')

@section('css')
    <style>
        .modal-content {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .display-6 {
            font-size: 2rem;
        }

        .badge {
            padding: 0.5em 0.75em;
        }

        .progress {
            border-radius: 1rem;
            background-color: #e9ecef;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            border-radius: 1rem;
        }

        /* Animation for icons */
        .rank-icon,
        .points-icon,
        .orders-icon {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection

@section('content_account')
    <div class="dashboard-home">
        <!-- Tiêu đề trang -->
        <div class="title">
            <h2>Trang Quản Trị</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf"></use>
                </svg>
            </span>
        </div>

        <!-- Thông tin người dùng -->
        <div class="dashboard-user-name">
            <h6 class="text-content">Xin Chào, <b class="text-title">Vicki E. Pope</b></h6>
            <p class="text-content">Bạn sẽ thấy toàn bộ thông tin của bạn ở đây !!!</p>
        </div>

        <!-- Các số liệu tổng quan -->
        <div class="total-box">
            <div class="row g-sm-4 g-3">
                <!-- Tổng đơn hàng -->
                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain shadow-sm">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_order') }}</h5>
                            <h3>{{ $data['countOrder']['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
                <!-- Đơn hàng đang chờ xử lý -->
                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain shadow-sm">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_pending_order') }}</h5>
                            <h3>{{ $data['countOrder']['pending_orders'] }}</h3>
                        </div>
                    </div>
                </div>
                <!-- Wishlist -->
                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain shadow-sm">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/wishlist.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/wishlist.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_wishlist') }}</h5>
                            <h3>{{ $data['wishlist'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin tài khoản -->
        <div class="dashboard-title">
            <h3>{{ __('form.account.account_infomation') }}</h3>
        </div>

        <div class="row g-4">
            <!-- Thông tin liên hệ -->
            <div class="col-xxl-6">
                <div class="dashboard-content-title">
                    <h4>{{ __('form.account.contact_infomation') }}</h4>
                </div>
                <div class="dashboard-detail">
                    <h6 class="text-content">{{ $data['user']->fullname }}</h6>
                    <h6 class="text-content">{{ $data['user']->email }}</h6>
                </div>
            </div>

            <!-- Rank - Cấp bậc -->
            <div class="col-xxl-6">
                <div class="dashboard-content-title d-flex align-items-center justify-content-between">
                    <h4>
                        Rank - Cấp Bậc
                    </h4>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewRank">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                <div class="dashboard-detail">
                    <h6 class="text-content">Hạng Đạt Được: {{ __($data['userGroup']) }}</h6>
                </div>
            </div>

            <!-- Địa chỉ mặc định -->
            <div class="col-12">
                <div class="dashboard-content-title">
                    <h4>{{ __('form.account.address_book') }}</h4>
                </div>
                <div class="row g-4">
                    <!-- Thông tin địa chỉ -->
                    <div class="col-md-6">
                        <div class="dashboard-detail card p-3 shadow-sm">
                            <h6 class="text-content">Địa Chỉ Mặc Định</h6>
                            <p class="text-content">
                                {{ !empty($data['defaultAddress']->address) ? $data['defaultAddress']->address : 'Chưa Có Địa Chỉ Mặc Định !!!' }}
                            </p>
                        </div>
                    </div>
                    <!-- Bản đồ hiển thị địa chỉ -->
                    <div class="col-md-6">
                        <div class="map-container card shadow-sm p-0">
                            <iframe
                                src="https://www.google.com/maps/embed/v1/place?q={{ urlencode($data['defaultAddress'] && $data['defaultAddress']->address ? $data['defaultAddress']->address : 'Ho Chi Minh City, Vietnam') }}&key=AIzaSyD0KlXUweWDKJXEgy9bt8pbUsCxN96gBoU"
                                allowfullscreen=""  loading="lazy"></iframe>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Rank -->
    <div class="modal fade" id="viewRank" tabindex="-1" aria-labelledby="viewRankLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <!-- Modal Header with Gradient -->
                <div class="modal-header border-0 position-relative"
                    style="background: #0da487; min-height: 100px; border-radius: 0.5rem 0.5rem 0 0;">
                    <div class="position-absolute w-100 text-center" style="top: 50%; transform: translateY(-50%);">
                        <h4 class="modal-title text-white mb-0 fw-bold" id="viewRankLabel">
                            <i class="fas fa-crown me-2" style="color: #FFD700;"></i>
                            Xếp Hạng Thành Viên
                        </h4>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <!-- Current Rank Banner -->
                    <div class="text-center mb-4">
                        <div class="badge bg-gradient px-4 py-2 fs-6" style="background: #0da487">
                            Cấp Độ Hiện Tại
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row g-4 justify-content-center">
                        <!-- Rank Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-4"
                                    style="background: linear-gradient(135deg, #1e3c72, #2a5298);">
                                    <div class="rank-icon mb-3">
                                        <i class="fas fa-medal fa-3x" style="color: #FFD700;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Cấp Bậc</h5>
                                    <h3 class="text-warning fw-bold mb-0 display-6">
                                        {{ ucfirst($data['userGroup']) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-warning">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Points Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-4"
                                    style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <div class="points-icon mb-3">
                                        <i class="fas fa-gem fa-3x" style="color: #E0F7FA;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Điểm Loyalty</h5>
                                    <h3 class="text-white fw-bold mb-0 display-6">
                                        {{ number_format($data['point']) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-info">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Card -->
                        <div class="col-md-4">
                            <div class="card h-100 border-0 overflow-hidden position-relative">
                                <div class="card-body text-center p-4"
                                    style="background: linear-gradient(135deg, #eb3349, #f45c43);">
                                    <div class="orders-icon mb-3">
                                        <i class="fas fa-shopping-bag fa-3x" style="color: #FFF;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-3">Tổng Đơn Hàng</h5>
                                    <h3 class="text-white fw-bold mb-0 display-6">
                                        {{ number_format($data['countOrder']['total_orders']) }}
                                    </h3>
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <div class="badge bg-danger">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    {{-- <div class="mt-5">
                        <h6 class="text-center mb-4 fw-bold text-muted">
                            <i class="fas fa-chart-bar me-2"></i>Tiến Độ Lên Hạng
                        </h6>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0"
                                aria-valuemax="100">
                                75%
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-danger btn-lg px-4 fw-bold" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
