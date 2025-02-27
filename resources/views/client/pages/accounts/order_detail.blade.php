@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <!-- Order Detail Section Start -->
    <section class="order-detail">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                @foreach ($orderDetail as $detail)
                    <div class="col-xxl-3 col-xl-4 col-lg-6">
                        <div class="order-image">
                            <img src="{{ Storage::url($detail->product->thumbnail) }}" class="img-fluid blur-up lazyload"
                                alt="">
                        </div>
                    </div>

                    <div class="col-xxl-9 col-xl-8 col-lg-6">
                        <div class="row g-sm-4 g-3">
                            <div class="col-xl-6 col-sm-6">
                                <div class="order-details-contain p-3">
                                    <div class="order-tracking-icon mb-3">
                                        <i data-feather="package" class="text-content"></i>
                                    </div>

                                    <div class="order-details-name">
                                        <h5 class="text-content">{{ __('form.order.code') }}</h5>
                                        <h5 class="theme-color">{{ $detail->order->code }}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="order-details-contain p-3">
                                    <div class="order-tracking-icon mb-3">
                                        <i class="text-content" data-feather="crosshair"></i>
                                    </div>

                                    <div class="order-details-name">
                                        <h5 class="text-content">{{ __('form.product.name') }}</h5>
                                        <h4 class="theme-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $detail->product->name }}">
                                            {{ $detail->product->name }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 overflow-hidden">
                    <ol class="progtrckr">
                        @foreach ($orderStatuses as $status)
                            <li class="progtrckr-done">
                                <h5>{{ __('form.order_status.' . $status) }}</h5>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Detail Section End -->

    <!-- Order Table Section Start -->
    <section class="order-table-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table order-tab-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Order Placed</td>
                                    <td>26 Sep 2021</td>
                                    <td>12:00 AM</td>
                                    <td>California</td>
                                </tr>

                                <tr>
                                    <td>Preparing to Ship</td>
                                    <td>03 Oct 2021</td>
                                    <td>12:00 AM</td>
                                    <td>Canada</td>
                                </tr>

                                <tr>
                                    <td>Shipped</td>
                                    <td>04 Oct 2021</td>
                                    <td>12:00 AM</td>
                                    <td>America</td>
                                </tr>

                                <tr>
                                    <td>Delivered</td>
                                    <td>10 Nav 2021</td>
                                    <td>12:00 AM</td>
                                    <td>Germany</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Table Section End -->
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
