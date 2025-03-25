@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
    <style>
        .custom-dt-picker .form-control {
            border: 1px solid #919191;
        }

        .custom-dt-picker .btn {
            border: 1px solid #919191 !important;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="row">
        <section class="dashboard-tiles">
            <div class="container-fluid">
                <div class="d-flex align-items-center mb-2">
                    <div class="d-flex justify-content-center align-items-center me-4">
                        <p class="mb-0 me-2 fw-bold">{{ __('message.from') }}</p>
                        <div class="input-group custom-dt-picker">
                            <input placeholder="YYY-MM-DD" id="start_date_input" class="form-control form-date">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="ri-calendar-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center me-4">
                        <p class="mb-0 me-2 fw-bold">{{ __('message.to') }}</p>
                        <div class="input-group custom-dt-picker">
                            <input placeholder="YYY-MM-DD" id="end_date_input" class="form-control form-date">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="ri-calendar-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary" data-bs-original-title="" title=""
                            fdprocessedid="yl65za">Lọc</button>
                    </div>
                </div>
                <div class="row g-3 ">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h6>{{ __('message.total_revenue') }}</h6>
                                <h3>$1,346.42</h3>
                            </div>
                            <div class="icon-box"><i class="ri-wallet-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h6>{{ __('message.total_orders_completed') }}</h6>
                                <h3>11</h3>
                            </div>
                            <div class="icon-box"><i class="ri-file-text-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h6>{{ __('message.total_products') }}</h6>
                                <h3>9</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h6>{{ __('message.total_customers') }}</h6>
                                <h3>6</h3>
                            </div>
                            <div class="icon-box"><i class="ri-group-line"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="row m-0">
                <div class="col-xl-8 col-md-6 p-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="title-header">
                                            <div class="w-100 d-flex align-items-center justify-content-between">
                                                <h5>{{ __('message.revenue_and_orders') }}</h5>



                                            </div>
                                        </div>
                                        <div id="columnChart" style="min-height: 360px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 p-0 ">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="title-header">
                                            <div class="w-100 d-flex align-items-center justify-content-between">
                                                <h5>{{ __('message.top_customers') }}</h5>
                                              
                                            </div>
                                        </div>
                                        <div>
                                            <div class="table-responsive datatable-wrapper border-table">

                                                <table class="table all-package theme-table no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th> Store Name</th>
                                                            <th> Orders </th>
                                                            <th> Earning </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Trendy Fashions</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>4</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>156.58</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Docks Sports</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Mega Appliances</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>1</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>201.48</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Hailey Beauty</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Craft Furnishings</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>1</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>24.12</div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="cursor-pointer ">
                                                                <div>Pets Provisions</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                            <td class="cursor-pointer ">
                                                                <div>0</div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row m-0">
                <div class="col-xl-5 col-md-6 p-0 ">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="title-header">
                                            <div class="w-100 d-flex align-items-center justify-content-between">
                                                <h5>{{ __('message.top_selling_products') }}</h5>
                                              
                                            </div>
                                        </div>
                                        <div class="top-selling-table datatable-wrapper table-responsive">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div class="img-info"><img alt="product" class="img-fluid"
                                                                src="https://laravel.pixelstrap.net/fastkart/storage/90/Pomegranate_2.png">
                                                            <div>
                                                                <h6>25 Aug 2023</h6>
                                                                <h5>Gourmet Fresh Pomegranate</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6>Price</h6>
                                                        <h5>$4.65</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Orders</h6>
                                                        <h5>2</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Stock</h6>
                                                        <h5>12</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Amount</h6>
                                                        <h5>$733.91</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="img-info"><img alt="product" class="img-fluid"
                                                                src="https://laravel.pixelstrap.net/fastkart/storage/93/Strawberry_1.png">
                                                            <div>
                                                                <h6>25 Aug 2023</h6>
                                                                <h5>Deliciously Sweet Strawberry</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6>Price</h6>
                                                        <h5>$6.37</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Orders</h6>
                                                        <h5>10</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Stock</h6>
                                                        <h5>7</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Amount</h6>
                                                        <h5>$1,404.82</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="img-info"><img alt="product" class="img-fluid"
                                                                src="https://laravel.pixelstrap.net/fastkart/storage/100/Watermelon_4.png">
                                                            <div>
                                                                <h6>25 Aug 2023</h6>
                                                                <h5>Deliciously Sweet Watermelon</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6>Price</h6>
                                                        <h5>$5.46</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Orders</h6>
                                                        <h5>13</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Stock</h6>
                                                        <h5>9</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Amount</h6>
                                                        <h5>$1,664.94</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="img-info"><img alt="product" class="img-fluid"
                                                                src="https://laravel.pixelstrap.net/fastkart/storage/87/Plum_2.png">
                                                            <div>
                                                                <h6>24 Aug 2023</h6>
                                                                <h5>Palm Bliss Unleashed</h5>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6>Price</h6>
                                                        <h5>$7.36</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Orders</h6>
                                                        <h5>8</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Stock</h6>
                                                        <h5>5</h5>
                                                    </td>
                                                    <td>
                                                        <h6>Amount</h6>
                                                        <h5>$670.91</h5>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-7 col-md-6 p-0 ">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="title-header">
                                            <div class="w-100 d-flex align-items-center justify-content-between">
                                                <h5>{{ __('message.orders_status') }}</h5>
                                               
                                            </div>
                                        </div>
                                        <div id="splineChart" style="min-height: 360px;"></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
        // Biểu đồ đường spline
        Highcharts.chart('splineChart', {!! json_encode($splineChart->options) !!});

        // Biểu đồ cột doanh thu & đơn hàng
        Highcharts.chart('columnChart', {!! json_encode($columnChart->options) !!});
    });
        $(".form-date").flatpickr({
            dateFormat: "Y-m-d"
        });

        $("#start_date_input").click(function() {
            $("#start_date_input").open();
        });

        $("#end_date_input").click(function() {
            $("#end_date_input").open();
        });

        $("#start_date_input_2").click(function() {
            $("#start_date_input_2").open();
        });

        $("#end_date_input_2").click(function() {
            $("#end_date_input_2").open();
        });

        $(document).ready(function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 2000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                }).showToast();
                setTimeout(function() {
                    window.location.href = 'admin';
                }, 500);
            @endif

        })
    </script>
@endpush
