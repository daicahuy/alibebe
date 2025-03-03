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
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <div class="coupon-box p-4 rounded shadow-sm text-center"
                                style="background-color: #d1f2eb; border-left: 5px solid #0da487;">
                                <h4 class="fw-bold">
                                    <a href="{{ route('index') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Mua Sản Phẩm Ngay">
                                        {{ $coupon->code }}
                                    </a>
                                    <span class="badge" style="background-color: #0da487; color: white;">
                                        {{ $coupon->discount_value }}
                                        {{ $coupon->discount_type == 0 ? 'Vnđ' : '%' }}
                                    </span>
                                </h4>
                                <p class="text-muted text-truncate mt-3" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ $coupon->description }}">
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
                @endif
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
