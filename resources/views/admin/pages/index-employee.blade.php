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

        .card-tiles {
            background-color: rgba(126, 211, 194, 0.452) !important;
            color: inherit !important;
        }

        .icon-box i {
            color: #ffffff !important;

        }

        .icon-box {
            background-color: #0da487 !important;
        }

        .card-tiles:after {
            background-color: #d5d4d4 !important;
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
                <form action="" method="GET">
                    {{-- @csrf --}}
                    <div class="d-flex align-items-center mb-2">
                        <div class="d-flex justify-content-center align-items-center me-4">
                            <p class="mb-0 me-2 fw-bold">Thời gian</p>
                            <div class="input-group custom-dt-picker">
                                <select name="start_date" class="form-control form-date">
                                    <option value="0" class="form-control form-date" 
                                        {{ request('start_date') == 0 ? 'selected' : '' }}>Hôm nay</option>
                                        <option value="1" class="form-control form-date" 
                                        {{ request('start_date') == 1 ? 'selected' : '' }}>7 ngày qua</option>
                                        <option value="2" class="form-control form-date" 
                                        {{ request('start_date') == 2 ? 'selected' : '' }}>30 ngày qua</option>
                                        <option value="3" class="form-control form-date" 
                                        {{ request('start_date') == 3 ? 'selected' : '' }}>1 năm qua</option>
                                        
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary" data-bs-original-title="" title=""
                                fdprocessedid="yl65za">Lọc</button>
                        </div>
                    </div>
                </form>
                <div class="row g-3 ">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>{{ __('message.total_revenue') }}</h5>
                                <h3>
                                    {{ number_format($revenue ?? 0, 0, ',', '.') }} VND
                                </h3>
                            </div>
                            <div class="icon-box"><i class="ri-wallet-line"></i></div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Đã đi đơn/Tổng đơn</h5>
                                <h3>{{ $countOrderDelivery ?? 0 }}/{{ $countOrder ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Chờ xử lý</h5>
                                <h3>{{ $countOrderPending ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Đang xử lý</h5>
                                <h3>{{ $countOrderProcessing ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Hoàn thành</h5>
                                <h3>{{ $countOrderComplete ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Xử lý đơn hoàn</h5>
                                <h3>{{ $countOrderReturns ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card-tiles">
                            <div>
                                <h5>Giao không thành công</h5>
                                <h3>{{ $countOrderFailed ?? 0 }} đơn</h3>
                            </div>
                            <div class="icon-box"><i class="ri-store-3-line"></i></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
            
        </div>
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
                                                <h5>Top Khách Hàng Rank Cao</h5>

                                            </div>
                                        </div>
                                        <div>
                                            <div class="table-responsive datatable-wrapper border-table">

                                                <table class="table all-package theme-table no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th> Họ Tên</th>
                                                            <th> Điểm </th>
                                                            <th> Rank </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($topUser as $data)
                                                            <tr>
                                                                <td class="cursor-pointer ">
                                                                    <a href="{{route('admin.users.customer.detail',['user'=>$data->id])}}"><div>{{ Str::limit($data->fullname, 15, '...') }}</div></a>
                                                                </td>
                                                                <td class="cursor-pointer ">
                                                                    <div>{{ $data->loyalty_points }}</div>
                                                                </td>
                                                                <td class="cursor-pointer ">
                                                                    <div>
                                                                        {{ $dashboardService->getUserRank($data->loyalty_points) }}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach

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
                                        @if ($topProduct->isEmpty())
                                        <h4>Chưa có sản phẩm được bán</h4>
                                        @else
                                        <div class="top-selling-table datatable-wrapper table-responsive">
                                            <table>
                                                @foreach ($topProduct as $data)
                                                    <tr>
                                                        <td>
                                                            <div class="img-info"><img alt="product" class="img-fluid"
                                                                    src="{{ Storage::url($data->thumbnail) }}">
                                                                <div>
                                                                    <h5>{{ $data->name }}</h5>
                                                                    <h6>Lượt bán:{{ $data->total_sold }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        @endif
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
    {{-- <pre>{{ print_r($chartData) }}</pre> --}}
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
        document.addEventListener("DOMContentLoaded", function() {
            var chartData = @json($chartData);
            let maxOrders = Math.max(...chartData.orders);
            let roundedMaxOrders = Math.ceil(maxOrders / 100) * 100; // Làm tròn lên bội số của 100
            let tickIntervalOrders = Math.ceil(roundedMaxOrders / 5); // Chia thành 5 khoảng
            console.log('ádasd');





            // Biểu đồ cột doanh thu & đơn hàng

            Highcharts.chart('columnChart', {
                chart: {
                    type: 'column'
                }, // Biểu đồ cột
                title: {
                    text: 'Thống Kê Doanh Thu & Số Lượng Đơn Hàng'
                },
                xAxis: {
                    categories: {!! json_encode($chartData['labels']) !!}
                },
                yAxis: [{
                        title: {
                            text: 'Doanh thu (VNĐ)'
                        },
                        labels: {
                            formatter: function() {
                                if (this.value >= 1e9) return (this.value / 1e9) +
                                    'B'; // 1 tỷ -> 1B
                                if (this.value >= 1e6) return (this.value / 1e6) +
                                    'M'; // 1 triệu -> 1M
                                return this.value + ' VNĐ'; // Dưới 1 triệu hiển thị bình thường
                            }
                        },
                        min: 0,

                        allowDecimals: true // Cho phép số thập phân
                    },
                    {
                        title: {
                            text: 'Số đơn hàng'
                        },
                        labels: {
                            format: '{value} đơn'
                        },
                        min: 0,
                        max: roundedMaxOrders, // Cập nhật max mới
                        tickInterval: tickIntervalOrders, // Đảm bảo 5 khoảng chia
                        allowDecimals: false, // Không cho phép số lẻ
                        opposite: true

                    }
                ],
                series: [{
                        name: 'Doanh thu',
                        data: {!! json_encode($chartData['revenues']) !!},
                        color: '#0da487',
                        yAxis: 0,
                        type: 'spline', // Hiển thị doanh thu dưới dạng đường
                        yAxis: 0, // Trục y đầu tiên (Doanh thu)
                        zIndex: 2, // Đưa doanh thu lên trên cùng
                        lineWidth: 3 // Đậm hơn để dễ nhìn
                    },
                    {
                        name: 'Số đơn hàng',
                        data: {!! json_encode($chartData['orders']) !!},
                        color: '#ff4d4d',
                        yAxis: 1,
                        type: 'column',
                        yAxis: 1, // Trục y thứ 2 (Số đơn hàng)
                        opacity: 0.9, // Làm mờ cột để nhìn thấy đường doanh thu
                    }
                ]
            });

            var order_status = @json($order_status);

            console.log("Dữ liệu order_status.orders:", order_status.orders);

            let allOrder_status = Object.values(order_status.orders)
                .flatMap(status => Object.values(status));

            console.log("Danh sách tất cả số lượng đơn hàng:", allOrder_status);

            let maxOrder_status = allOrder_status.length > 0 ?
                Math.max(...allOrder_status) :
                0;

            console.log("maxOrder_status:", maxOrder_status);

            let roundedMaxOrder_status = maxOrder_status > 0 ?
                Math.ceil(maxOrder_status / 100) * 100 :
                10;

            console.log("roundedMaxOrder_status:", roundedMaxOrder_status);

            let tickIntervalOrder_status = maxOrder_status > 0 ?
                Math.max(Math.ceil(roundedMaxOrder_status / 5), 5) :
                2;

            console.log("tickIntervalOrder_status:", tickIntervalOrder_status);




            console.log("Dữ liệu order_status từ PHP:", order_status);
            console.log("Danh sách nhãn thời gian:", order_status.labels);
            // Chuyển đổi dữ liệu sang dạng `series` tự động
            let seriesData = [];
            Object.keys(order_status.orders).forEach((status, index) => {
                seriesData.push({
                    name: status,
                    data: Object.values(order_status.orders[status]),
                    color: Highcharts.getOptions().colors[index] || '#000'
                });
            });

            // Biểu đồ spline
            Highcharts.chart('splineChart', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Thống Kê Trạng Thái Đơn Hàng'
                },
                xAxis: {
                    categories: order_status.labels
                },
                yAxis: {
                    title: {
                        text: 'Số lượng'
                    },
                    min: 0,
                    max: roundedMaxOrder_status,
                    tickInterval: tickIntervalOrder_status
                },
                legend: {
                    enabled: true
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        let tooltipHtml = `<b>${this.x}</b><br>`;
                        this.points.forEach(point => {
                            tooltipHtml +=
                                `<span style="color:${point.color}">●</span> ${point.series.name}: <b>${point.y} đơn</b><br>`;
                        });
                        return tooltipHtml;
                    }
                },
                series: seriesData
            });

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
       
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ $errors->first() }}",
                showConfirmButton: true
            });
        @endif
    });
    </script>
@endpush
