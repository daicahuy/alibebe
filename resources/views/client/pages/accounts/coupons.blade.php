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
                @if ($coupons->isEmpty())
                    <div class="mt-3 mb-3 text-center">
                        <p>Bạn Chưa Có Mã Giảm Giá Nào !!!</p>
                    </div>
                @else
                    @foreach ($coupons as $coupon)
                        @php
                            $percent =
                                $coupon->usage_limit > 0
                                    ? round(($coupon->usage_count / $coupon->usage_limit) * 100)
                                    : 0;
                        @endphp
                        <div class="col-12 col-md-6 col-lg-4 mb-3 d-flex">
                            <div class="coupon-box p-4 rounded shadow-sm text-center w-100 d-flex flex-column justify-content-between"
                                style="background-color: #d1f2eb; border-left: 5px solid #0da487;">
                                <div>
                                    <h4 class="fw-bold d-flex flex-column justify-content-center align-items-center gap-2">
                                        <a href="{{ route('index') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Mua Sản Phẩm Ngay" class="d-block">
                                            {{ $coupon->code }}
                                        </a>
                                        <span class="badge" style="background-color: #0da487; color: white;">
                                            {{ $coupon->discount_value }} {{ $coupon->discount_type == 0 ? 'Vnđ' : '%' }}
                                        </span>
                                    </h4>

                                    <p class="text-muted mt-3" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ $coupon->description }}">
                                        {{ Str::limit($coupon->description, 80) }}
                                    </p>

                                    <ul class="list-unstyled text-start mb-3">
                                        <li class="mb-1"><strong>Hạn sử dụng:</strong>
                                            {{ $coupon->is_expired == 1 ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : 'Vĩnh Viễn' }}
                                        </li>
                                        <li class="mb-1"><strong>Trạng thái:</strong>
                                            {{ $coupon->is_active ? 'Đang hoạt động' : 'Hết hạn' }}</li>
                                    </ul>

                                    <div class="mb-3 text-start">
                                        <small class="d-block mb-1"><strong>Đã sử dụng:</strong> {{ $coupon->usage_count }}
                                            / {{ $coupon->usage_limit ?: '∞' }}</small>
                                        <div class="progress" style="height: 8px; border-radius: 4px; overflow: hidden;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"
                                                aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                    class="btn theme-bg-color text-white fw-bold btn-sm mt-2 view-coupon-btn"
                                    data-bs-toggle="modal" data-bs-target="#couponDetailModal"
                                    data-code="{{ $coupon->code }}"
                                    data-discount="{{ $coupon->discount_value }} {{ $coupon->discount_type == 0 ? 'Vnđ' : '%' }}"
                                    data-description="{{ $coupon->description }}"
                                    data-expiry="{{ $coupon->is_expired == 1 ? \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') : 'Vĩnh Viễn' }}"
                                    data-status="{{ $coupon->is_active ? 'Đang hoạt động' : 'Hết hạn' }}"
                                    data-usage-count="{{ $coupon->usage_count }}"
                                    data-usage-limit="{{ $coupon->usage_limit }}">
                                    Xem chi tiết
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection 

@section('modal')
    <!-- Coupon Detail Modal Start -->
    <div class="modal fade" id="couponDetailModal" tabindex="-1" aria-labelledby="couponDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content overflow-hidden rounded shadow">
                <div class="modal-header bg-light">
                    <h5 id="couponDetailModalLabel" class="modal-title">Chi tiết mã giảm giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row gy-2">
                        <div class="col-sm-4 text-end"><strong>Mã:</strong></div>
                        <div class="col-sm-8"><span id="modalCouponCode"></span></div>

                        <div class="col-sm-4 text-end"><strong>Giảm:</strong></div>
                        <div class="col-sm-8"><span id="modalCouponDiscount"></span></div>

                        <div class="col-sm-4 text-end align-self-start"><strong>Mô tả:</strong></div>
                        <div class="col-sm-8">
                            <p id="modalCouponDescription" class="mb-0"></p>
                        </div>

                        <div class="col-sm-4 text-end"><strong>Hạn sử dụng:</strong></div>
                        <div class="col-sm-8"><span id="modalCouponExpiry"></span></div>

                        <div class="col-sm-4 text-end"><strong>Trạng thái:</strong></div>
                        <div class="col-sm-8"><span id="modalCouponStatus"></span></div>

                        <div class="col-sm-4 text-end"><strong>Đã sử dụng:</strong></div>
                        <div class="col-sm-8"><span id="modalUsageCount"></span> / <span id="modalUsageLimit"></span></div>

                        <div class="col-sm-4 text-end"><strong>Tiến độ:</strong></div>
                        <div class="col-sm-8">
                            <div class="progress mb-0" style="height: 12px; border-radius: 6px; overflow: hidden;">
                                <div id="modalProgressBar" class="progress-bar" role="progressbar" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('index') }}" class="btn theme-bg-color text-white fw-bold btn-sm mt-2">Mua ngay</a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('#couponDetailModal').on('show.bs.modal', function(event) {
                const btn = $(event.relatedTarget);
                const count = btn.data('usage-count');
                const limit = btn.data('usage-limit');
                const percent = limit > 0 ? Math.round(count / limit * 100) : 0;

                $('#modalCouponCode').text(btn.data('code'));
                $('#modalCouponDiscount').text(btn.data('discount'));
                $('#modalCouponDescription').text(btn.data('description'));
                $('#modalCouponExpiry').text(btn.data('expiry'));
                $('#modalCouponStatus').text(btn.data('status'));

                $('#modalUsageCount').text(count);
                $('#modalUsageLimit').text(limit || '∞');
                $('#modalProgressBar')
                    .css('width', percent + '%')
                    .attr('aria-valuenow', percent)
                    .text(percent + '%');
            });
        });
    </script>
@endpush
