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
                                allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tài khoản ngân hàng3da  -->
            <div class="col-12">
                <div class="dashboard-content-title d-flex align-items-center justify-content-between">
                    <h4>Tài Khoản Ngân Hàng</h4>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#bankAccount" class="text-primary">
                        <i class="fas fa-pencil-alt me-1"></i>
                        {{ empty($data['user']->bank_name) ? 'Thêm tài khoản' : 'Cập nhật' }}
                    </a>
                </div>

                @if (empty($data['user']->bank_name) && empty($data['user']->user_bank_name) && empty($data['user']->bank_account))
                    <div class="card shadow-sm border-0 p-4 text-center">
                        <div class="py-4">
                            <i class="fas fa-university fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Bạn chưa thêm tài khoản ngân hàng</p>
                            <p class="text-muted">Vui lòng nhấn <a href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#bankAccount" class="text-primary">vào đây</a> để thêm tài khoản</p>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm border-0 p-0">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead style="background-color: #f7f7f7;">
                                        <tr>
                                            <th class="border-0">Ngân Hàng</th>
                                            <th class="border-0">Tên Tài Khoản</th>
                                            <th class="border-0">Số Tài Khoản</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bank-icon me-3">
                                                        <i class="fas fa-university text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $data['user']->bank_name ?? 'N/A' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $data['user']->user_bank_name ?? 'N/A' }}</td>
                                            <td>{{ $data['user']->bank_account ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal Bank User -->
    <div class="modal fade" id="bankAccount" tabindex="-1" aria-labelledby="BankAccountLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <!-- Modal Header with Gradient -->
                <div class="modal-header border-0 position-relative"
                    style="background: #0da487; min-height: 100px; border-radius: 0.5rem 0.5rem 0 0;">
                    <div class="position-absolute w-100 text-center" style="top: 50%; transform: translateY(-50%);">
                        <h4 class="modal-title text-white mb-0 fw-bold" id="BankAccountLabel">
                            <i class="fas fa-university me-2" style="color: #FFD700;"></i>
                            Tài Khoản Ngân Hàng
                        </h4>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <form action="{{ route('account.bank') }}" method="POST" id="bankAccountForm">
                        @csrf
                        @method('PATCH')
                        <div class="container">
                            <div class="row">
                                <!-- Bank Logo and Selection -->
                                <div class="col-md-12 mb-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-landmark text-primary me-2"></i>Chọn Ngân Hàng
                                            </h5>
                                            <div class="form-group">
                                                <select class="form-select form-control" name="bank_name" id="bank_name"
                                                    required>
                                                    <option value="" disabled selected>-- Chọn Ngân Hàng --</option>
                                                    <option value="Vietcombank"
                                                        {{ $data['user']->bank_name == 'Vietcombank' ? 'selected' : '' }}>
                                                        Vietcombank</option>
                                                    <option value="BIDV"
                                                        {{ $data['user']->bank_name == 'BIDV' ? 'selected' : '' }}>BIDV
                                                    </option>
                                                    <option value="Vietinbank"
                                                        {{ $data['user']->bank_name == 'Vietinbank' ? 'selected' : '' }}>
                                                        Vietinbank</option>
                                                    <option value="Techcombank"
                                                        {{ $data['user']->bank_name == 'Techcombank' ? 'selected' : '' }}>
                                                        Techcombank</option>
                                                    <option value="ACB"
                                                        {{ $data['user']->bank_name == 'ACB' ? 'selected' : '' }}>ACB
                                                    </option>
                                                    <option value="VPBank"
                                                        {{ $data['user']->bank_name == 'VPBank' ? 'selected' : '' }}>VPBank
                                                    </option>
                                                    <option value="MBBank"
                                                        {{ $data['user']->bank_name == 'MBBank' ? 'selected' : '' }}>MBBank
                                                    </option>
                                                    <option value="Sacombank"
                                                        {{ $data['user']->bank_name == 'Sacombank' ? 'selected' : '' }}>
                                                        Sacombank</option>
                                                    <option value="TPBank"
                                                        {{ $data['user']->bank_name == 'TPBank' ? 'selected' : '' }}>TPBank
                                                    </option>
                                                    <option value="HDBBank"
                                                        {{ $data['user']->bank_name == 'HDBBank' ? 'selected' : '' }}>
                                                        HDBank</option>
                                                    <option value="OCB"
                                                        {{ $data['user']->bank_name == 'OCB' ? 'selected' : '' }}>OCB
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Holder Name -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-user text-success me-2"></i>Tên Chủ Tài Khoản
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="user_bank_name"
                                                    id="user_bank_name" placeholder="Nhập tên chủ tài khoản"
                                                    value="{{ $data['user']->user_bank_name ?? '' }}" required>
                                                <small class="form-text text-muted">Vui lòng nhập chính xác tên chủ tài
                                                    khoản ngân hàng</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Number -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fas fa-credit-card text-danger me-2"></i>Số Tài Khoản
                                            </h5>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="bank_account"
                                                    id="bank_account" placeholder="Nhập số tài khoản"
                                                    value="{{ $data['user']->bank_account ?? '' }}" required>
                                                <small class="form-text text-muted">Vui lòng nhập chính xác số tài khoản
                                                    ngân hàng</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Information Note -->
                                <div class="col-12">
                                    <div class="alert alert-info p-3">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-info-circle fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="alert-heading mb-2">Lưu ý quan trọng:</h6>
                                                <p class="mb-0 small">
                                                    Thông tin tài khoản ngân hàng của bạn sẽ được sử dụng cho các giao dịch
                                                    hoàn tiền,
                                                    chi trả hoa hồng và các khoản thanh toán khác. Vui lòng kiểm tra kỹ
                                                    thông tin trước khi lưu.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Đóng
                    </button>
                    <button type="submit" form="bankAccountForm" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Lưu Thông Tin
                    </button>
                </div>
            </div>
        </div>
    </div>
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

                    <div class="mt-5">
                        <h6 class="text-center mb-4 fw-bold text-muted">
                            <i class="fas fa-chart-bar me-2"></i>Tiến Độ Lên Hạng
                        </h6>

                        @php
                            $loyaltyRanges = [
                                1 => [0, 100],
                                2 => [101, 300],
                                3 => [301, 500],
                                4 => [501, 700],
                                5 => [701, 850],
                                6 => [851, 999],
                                7 => [1000, PHP_INT_MAX],
                            ];

                            $currentPoints = $data['point'];
                            $currentGroupId = null;
                            $nextGroupId = null;
                            $currentMin = 0;
                            $currentMax = 0;
                            $nextMin = 0;
                            $nextMax = 0;
                            $pointsToNextLevel = 0;
                            $progressPercentage = 0;
                            $nextGroupName = '';

                            foreach ($loyaltyRanges as $group => [$min, $max]) {
                                if ($currentPoints >= $min && $currentPoints <= $max) {
                                    $currentGroupId = $group;
                                    $currentMin = $min;
                                    $currentMax = $max;
                                    break;
                                }
                            }

                            if ($currentGroupId < 7) {
                                $nextGroupId = $currentGroupId + 1;
                                $nextMin = $loyaltyRanges[$nextGroupId][0];
                                $nextMax = $loyaltyRanges[$nextGroupId][1];

                                $pointsToNextLevel = $nextMin - $currentPoints;
                                $totalPointsInLevel = $currentMax - $currentMin;
                                $pointsGained = $currentPoints - $currentMin;
                                $progressPercentage = ($pointsGained / $totalPointsInLevel) * 100;

                                switch ($nextGroupId) {
                                    case 1:
                                        $nextGroupName = 'Newbie';
                                        break;
                                    case 2:
                                        $nextGroupName = 'Iron';
                                        break;
                                    case 3:
                                        $nextGroupName = 'Bronze';
                                        break;
                                    case 4:
                                        $nextGroupName = 'Silver';
                                        break;
                                    case 5:
                                        $nextGroupName = 'Gold';
                                        break;
                                    case 6:
                                        $nextGroupName = 'Platinum';
                                        break;
                                    case 7:
                                        $nextGroupName = 'Diamond';
                                        break;
                                    default:
                                        $nextGroupName = 'Unknown';
                                }
                            } else {
                                $progressPercentage = 100;
                            }
                        @endphp

                        @if ($currentGroupId < 7)
                            <div class="card border-0 shadow-sm p-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold text-success">
                                        <i class="fas fa-angle-double-up me-1"></i>
                                        Hạng tiếp theo: {{ $nextGroupName }}
                                    </span>
                                    <span class="badge bg-primary px-3 py-2">
                                        <i class="fas fa-gem me-1"></i>
                                        Còn {{ number_format($pointsToNextLevel) }} điểm để lên hạng
                                    </span>
                                </div>

                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: {{ $progressPercentage }}%;"
                                        aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ round($progressPercentage) }}%
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">{{ number_format($currentMin) }} điểm</small>
                                    <small class="text-muted">{{ number_format($currentMax) }} điểm</small>
                                </div>
                            </div>
                        @else
                            <div class="card border-0 shadow-sm p-4 mb-4 text-center">
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-crown me-2" style="color: #FFD700;"></i>
                                    Chúc mừng! Bạn đã đạt cấp độ cao nhất (Diamond)
                                </div>
                            </div>
                        @endif

                        <!-- Rank Benefits Info -->
                        <div class="card border-0 shadow-sm p-3 mt-4">
                            <div class="card-body text-center">
                                <h6 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Thông Tin Đặc Quyền
                                </h6>
                                <p class="mb-0 small text-muted">
                                    Mỗi cấp độ sẽ nhận được những đặc quyền và ưu đãi khác nhau.
                                    Tích lũy điểm loyalty qua các đơn hàng để nâng cấp hạng thành viên của bạn.
                                </p>
                            </div>
                        </div>
                    </div>
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
