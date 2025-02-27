@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-order">
        <div class="title">
            <h2>Danh Sách Đơn Hàng</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>

        <div class="filter-section p-3 bg-light rounded shadow-sm">
            <form method="GET" action="" id="filter-form">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="order-name" class="form-label">Trạng Thái Đơn Hàng:</label>
                        <div class="btn-group w-100 pb-2 pt-2" role="group" aria-label="Order name"
                            style="overflow-x: auto; white-space: nowrap;">

                            <!-- Tùy chọn "All" -->
                            <div class="d-inline-block" style="margin-right: 10px;">
                                <input type="radio" class="btn-check" name="status" id="status-all" value=""
                                    checked>
                                <label class="btn theme-bg-color text-white fw-bold px-4 py-2" for="status-all">All</label>
                            </div>
                            <!-- Lặp qua các trạng thái đơn hàng -->
                            @foreach ($orders['orderStatuses'] as $key => $status)
                                <div class="d-inline-block" style="margin-right: 10px;">
                                    <input type="radio" class="btn-check" name="status" id="status-{{ $key }}"
                                        value="{{ $key }}">
                                    <label class="btn theme-bg-color text-white fw-bold px-4 py-2"
                                        for="status-{{ $key }}">{{ __('form.order_status.' . $status) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="order-contain mt-3">
            @if ($orders['dataOrders']->isEmpty())
                <p>Ba</p>
            @else
                @foreach ($orders['dataOrders'] as $order)
                    <div class="order-box dashboard-bg-box">
                        <div class="order-container">
                            <div class="order-icon">
                                <i data-feather="box"></i>
                                {{ $order->code }}
                            </div>

                            <div class="order-detail">
                                <h4>
                                    @foreach ($order->orderStatuses as $status)
                                        <span>
                                            {{ isset($status->name) ? $status->name : 'Chưa Có Trạng Thái' }}
                                        </span>
                                    @endforeach
                                </h4>

                                <h6 class="text-content">
                                    {{ $order->note }}
                                </h6>

                                <div class="mt-3 mb-3 d-flex justify-content-center">
                                    <a href="{{ route('account.order-history-detail', $order->id) }}"
                                        class="btn theme-bg-color text-white fw-bold px-3 py-1">
                                        {{ __('message.show') }}
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <nav class="custom-pagination">
            {{ $orders['dataOrders']->links() }}
        </nav>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('input[name="status"]').on('change', function() {
                $('#filter-form').submit();
            });
        });
    </script>
@endpush
