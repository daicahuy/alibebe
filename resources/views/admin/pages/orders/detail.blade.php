@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        .order-offcanvas {
            z-index: 1055 !important;
            /* Giá trị cao hơn backdrop (thường là 1050) */
        }

        /* Remove vertical borders */
        .table-bordered th,
        .table-bordered td {
            border-left: none;
            border-right: none;
        }

        /* Round corners of the table */
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        /* Set background color of the header row to gray */
        .table thead tr {
            background-color: #f0f0f0;
        }

        /* Optional: Add a border to the whole table */
        .table-bordered {
            border: 1px solid #ccc;
        }

        /* Optional: Add a bottom border for the header row */
        .table thead th {
            border-bottom: 2px solid #ccc;
        }

        .font-weight-semibold {
            font-size: 15px;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class=""><router-outlet></router-outlet><app-details class="ng-star-inserted">
            <div class="row g-2">
                <div class="col-xxl-9">
                    <div class="mb-4 ng-star-inserted">
                        <div class="tracking-panel">
                            <ul>
                                <li class="ng-star-inserted active">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="/theme/admin/assets/svg/pending.svg" width="100px">
                                        </div>
                                        <div>
                                            <div class="status">Chờ xử lý</div>
                                            <div>12:07:12 <span>27/12/2024</span></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ng-star-inserted active">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="/theme/admin/assets/svg/processing.svg" width="100px">
                                        </div>
                                        <div>
                                            <div class="status">Đã lấy hàng</div>
                                            <div>12:07:12 <span>27/12/2024</span></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-none ng-star-inserted active">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                        </div>
                                        <div>
                                            <div class="status">Hủy hàng</div>
                                            <div>12:07:12 <span>27/12/2024</span></div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ng-star-inserted d-none">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="/theme/admin/assets/svg/tracking/shipped.svg">
                                        </div>
                                        <div class="status">Shipped</div>
                                    </div>
                                </li>
                                <li class="ng-star-inserted d-none">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="assets/svg/tracking/out-for-delivery.svg"></div>
                                        <div class="status">Out For Delivery</div>
                                    </div>
                                </li>
                                <li class="ng-star-inserted d-none">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="assets/svg/tracking/delivered.svg">
                                        </div>
                                        <div class="status">Delivered</div>
                                    </div>
                                </li><!---->
                                <li class="active cancelled-box ng-star-inserted">
                                    <div class="panel-content">
                                        <div class="icon"><img alt="image" class="img-fluid"
                                                src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                        </div>
                                        <div>
                                            <div class="status">Hủy hàng</div>
                                            <div>12:07:12 <span>27/12/2024</span></div>
                                        </div>
                                    </div>
                                </li><!---->
                            </ul>
                        </div>
                    </div><!----><app-page-wrapper><!---->
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="title-header ng-star-inserted">
                                                <div class="d-flex align-items-center">
                                                    <h5>Order Number: #1031</h5>
                                                </div><!---->
                                            </div><!---->
                                            <div class="tracking-wrapper table-responsive">
                                                <table class="table product-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Ảnh</th>
                                                            <th scope="col">Tên sản phẩm</th>
                                                            <th scope="col">Size</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col">Số lượng</th>
                                                            <th scope="col">Tổng tiền</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="ng-star-inserted">
                                                            <td class="product-image"><img alt="product" class="img-fluid"
                                                                    src="https://laravel.pixelstrap.net/fastkart/storage/1351/Shorts_01.png"
                                                                    width="100px">
                                                            </td>
                                                            <td>
                                                                <h6>Men Cotton Shorts</h6>
                                                            </td>
                                                            <td>
                                                                <h6>M</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$13.00</h6>
                                                            </td>
                                                            <td>
                                                                <h6>1</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$13.92</h6>
                                                            </td>

                                                        </tr>
                                                        <tr class="ng-star-inserted">
                                                            <td class="product-image"><img alt="product" class="img-fluid"
                                                                    src="https://laravel.pixelstrap.net/fastkart/storage/1255/CollarTshirt_01.png"
                                                                    width="100px">
                                                            </td>
                                                            <td>
                                                                <h6>Solid Polo Tshirt</h6>
                                                            </td>
                                                            <td>
                                                                <h6>M</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$5.00</h6>
                                                            </td>
                                                            <td>
                                                                <h6>1</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$5.64</h6>
                                                            </td>

                                                        </tr>
                                                        <tr class="ng-star-inserted">
                                                            <td class="product-image"><img alt="product" class="img-fluid"
                                                                    src="https://laravel.pixelstrap.net/fastkart/storage/1343/womenPent_01.png"
                                                                    width="100px">
                                                            </td>
                                                            <td>
                                                                <h6>Straight Fit Flat-Front
                                                                    Trousers</h6>
                                                            </td>
                                                            <td>
                                                                <h6>M</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$13.00</h6>
                                                            </td>
                                                            <td>
                                                                <h6>1</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$13.50</h6>
                                                            </td>

                                                        </tr>
                                                        <tr class="ng-star-inserted">
                                                            <td class="product-image"><img alt="product" class="img-fluid"
                                                                    src="https://laravel.pixelstrap.net/fastkart/storage/1250/Chapal_01.png"
                                                                    width="100px">
                                                            </td>
                                                            <td>
                                                                <h6>Men Flip Flops</h6>
                                                            </td>
                                                            <td>
                                                                <h6>M</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$4.00</h6>
                                                            </td>
                                                            <td>
                                                                <h6>1</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$4.75</h6>
                                                            </td>

                                                        </tr>
                                                        <tr class="ng-star-inserted">
                                                            <td class="product-image"><img alt="product"
                                                                    class="img-fluid"
                                                                    src="https://laravel.pixelstrap.net/fastkart/storage/1236/gymshorts_coffee-2.png"
                                                                    width="100px">
                                                            </td>
                                                            <td>
                                                                <h6>Women Polyester Activewear
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <h6>M</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$22.00</h6>
                                                            </td>
                                                            <td>
                                                                <h6>1</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$22.36</h6>
                                                            </td>

                                                        </tr><!---->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </app-page-wrapper><!---->
                </div>
                <div class="col-xxl-3">
                    <div class="sticky-top-sec"><app-page-wrapper _nghost-ng-c1743930539=""><!---->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header ng-star-inserted">
                                                    <div class="d-flex align-items-center">
                                                        <h5>Hóa đơn</h5>
                                                    </div>
                                                    <div button="" class="ng-star-inserted"><a download="download"
                                                            class="btn btn-animation btn-sm ms-auto"
                                                            href="https://laravel.pixelstrap.net/fastkart/order/invoice/1031">Invoice
                                                            <i class="ri-download-2-fill"></i></a></div><!---->
                                                </div><!---->
                                                <div class="tracking-total tracking-wrapper">
                                                    <ul>
                                                        <li>Tổng cộng <span>$60.17</span></li>
                                                        <li>Phí ship <span>$0</span></li>
                                                        <li>Voucher</li>
                                                        <li>
                                                            <p>ALIBEBE#3ALIBEBE#3</p>15%
                                                        </li>
                                                        <li>Giảm giá <span class="text-danger">-$4.35</span></li>
                                                        <li>Thành tiền <span class="text-danger">$64.52</span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </app-page-wrapper><app-page-wrapper _nghost-ng-c1743930539=""><!---->
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header ng-star-inserted">
                                                    <div class="d-flex align-items-center">
                                                        <h5>Thông tin</h5>
                                                    </div>
                                                </div><!---->
                                                <div class="customer-detail tracking-wrapper">
                                                    <ul>
                                                        <li><label>Tên:</label>
                                                            <h4>John Doe</h4>
                                                        </li>
                                                        <li><label>Số điện thoại:</label>
                                                            <h4>039153099</h4>
                                                        </li>
                                                        <li><label>Địa chỉ shop:</label>
                                                            <h4> 26, Starts Hollow Colony
                                                                Denver Colorado United States 80014 <br> Phone : +1
                                                                5551855359
                                                            </h4>
                                                        </li>
                                                        <li><label>Giao đến:</label>
                                                            <h4> 26, Starts Hollow Colony
                                                                Denver Colorado United States 80014 <br> Phone : +1
                                                                5551855359
                                                            </h4>
                                                        </li>
                                                        <li><label>Ghi chú:</label>
                                                            <h4>Em đang cần gấp ạ :\</h4>
                                                        </li>
                                                        <li><label>Phương thức thanh toán:</label>
                                                            <h4>PAYPAL</h4>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </app-page-wrapper></div>
                </div>
            </div>
        </app-details><!----><app-footer _nghost-ng-c3300754611="">
            <div _ngcontent-ng-c3300754611="" class="container-fluid">
                <footer _ngcontent-ng-c3300754611="" class="footer">
                    <div _ngcontent-ng-c3300754611="" class="row">
                        <div _ngcontent-ng-c3300754611="" class="col-md-12 footer-copyright text-center">
                            <p _ngcontent-ng-c3300754611="" class="mb-0">Copyright 2023 © Fastkart theme by pixelstrapp
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </app-footer></div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script></script>
    <!-- Thêm SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
