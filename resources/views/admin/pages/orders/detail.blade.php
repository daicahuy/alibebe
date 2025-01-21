@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        /* Set background color of the header row to gray */
        #loading-icon-load {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #loading-icon {
            animation: rotate 2s linear infinite;
            width: 100px;
            height: 100px;

        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .printOrder {
            display: none
        }

        .printOrder.active {
            display: block;
        }

        .orderStatus {
            display: none;
        }

        .orderStatus.active {
            display: block;
        }

        .span-completed {
            display: none;
        }

        .span-completed.active {
            display: block;
        }

        .span-failed {
            display: none;
        }

        .span-failed.active {
            display: block;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    @php
        use App\Enums\CouponDiscountType;

        $CouponDiscountType_PERCENT = CouponDiscountType::PERCENT;
        $CouponDiscountType_FIX_AMOUNT = CouponDiscountType::FIX_AMOUNT;

    @endphp
    <div class="">
        <div class="row g-2">
            <div class="col-xxl-9">
                <div class="mb-4 ng-star-inserted">
                    <div class="tracking-panel" id="time-line-status">
                        <ul>







                        </ul>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header ng-star-inserted"
                                        style="justify-content: space-between; flex-wrap: wrap;">
                                        <div class="d-flex align-items-center">
                                            <h5>Mã Đơn Hàng <span class="span-code"></span></h5>
                                        </div>
                                        <div id="select-change-status">

                                        </div>

                                        <div _ngcontent-ng-c1063460097="" class="ng-star-inserted span-completed">
                                            <div class="status-completed"><span>Hoàn thành</span></div>
                                        </div>
                                        <div _ngcontent-ng-c1063460097="" class="ng-star-inserted span-failed">
                                            <div class="status-failed"><span>Đã hủy</span></div>
                                        </div>
                                    </div>
                                    <div class="tracking-wrapper table-responsive">
                                        <table class="table product-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Ảnh</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Biến thể</th>
                                                    <th scope="col">Giá(VND)</th>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Tổng tiền</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <div id="loading-icon-load">
                                            <div id="loading-icon" style="display: none;">
                                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAF9ElEQVR4nO2dTYwURRTH/5AMkLi7YlwTdlYTPxNFceUgLnjQXS6CCQsJZ4UbBm6IgjEROOBFQPSgcHUTlwMgygWRcFJBXT3AfsANLoIKy86asMmqa17yOum8VHdX9XTPVHe/X1JJp6e6p6re1Pua6mpAURRFURRFURRFUQrKQwD2A/gVwN9c6HgfgO52N65qbAIwDWA+otwFsLHdjaySMP6NEUZQqI4KpQVqatpCGEGZUvWVL/vFgM8C2Amgh8tOPheuszfnNlWa38RgkwAku0QdMvRKTsyIwV5mqLNM1GmoNPKjIQab1JSkV9Qhm6O0SGW9baGyRlUa+bHPYNRJKHUuuzI06s8COAzgSijwpONDAJZn3K/C0s1Bn4vb+6DjdywC8CmAf2LuS58dAVBDgaCO7QBwMfQL+xHAdv4sLRsdAsOhFG0+5yDwb4silDq7m1EdGY0wyC5CmUqYGa7CAM+MecfyMTxnUYIwgvJLk7+ubrYpo+wON/iee1OoqcBmSDU1BmADgE4uJORxUWcOwDPwmB0Ov6634A+HDcLoMtS7H8CEqHsQHnNRNPYbjg16+Tj82Q/whzHRtqGEBGe47mUUKJomQQQ87HEU3RBtIxUVRZfH/UjsGAkhQAXikcoiYZzxWGVdKavK2u5g1LfBHw6Jto2zAZfQuUlR9yN47vaOWgjjJ8+CquUGt3eCZ0MXl00GYZDb+zQ8p4djgihh/NxkYJgXR1IEhjSzCkGN44zv2fOa4eNtns2MMDVOh9gK46zHfSkNNU6HzMUIYo5nhgqjxTblIHtQwQy/zAbc61SJoiiKoiiKoiilZy2AY5z3ChZz0PFRAIPtblyVeBLABYv0ynkAT7S7sWXnZQB/OeS8qO6adje6rDwG4I8UWeHbPKty4XWeikGOh47XoxpcMAz2SQCvALiPy6sAThnqfdeKh2aq9HDMWkOfaT1xFO8Y6g9kPTOSpuY6lJdjhpmRxGlxzedZNui8hUBobWxZmRR9JTWVxIDhb+Hclvj0A1hdoQdkGqKvHRbXdOa5hks2aDW7cyqQNglEVRaaVlm0vCgz1lvYkNdQXo6KvpJrm8TX4prP8n6sLFw+QLkZNPSZXNso3jXUpxglc9axN9Xgcq7kMyNJbZ9m1dTBZdAwM8rugbaNR1OmTiifpUnGnFjjmFz8kz1SJUce59yUTaBMCUmlRQxwOmQ8lGwd43O5GHBFURRFUZTCUgOwGcBwaHnPDB8P82f6bEiLoKdvr1nEF9dS7qeiWLIQwIeO6ZD/ABzga5WMcRVGuJBQlAwZ4l97eJDv8YY0q0LLe1bx84f3DDOFdg1SMqBmsBnXATwXc80KADcMNsV7Q/8UgBOh/02Oi81ofGCzYWbECSMsFLm/I93La2HcjkhF+ySUYdE+UlNpNxr4Ah5zIsYIjsDftVYvOlz7kriW7uUtcslQuNDOos3wAICtAL7iQQiey5jkhQdbACzNca1VS5b4ZE3S+z3SsATAHsutYmkjzN18TRyVEcjxjFVWnXcQco0RLvG1tiqLXFtb+ouksnrZgJuMetwAmagb3EyXciPmO4eb2Pb1kyIZdfAgjLD6muZjV2Es4e2c5CD/DuA9AH2hwK2Pz9001Ked7hZbur3k0ibRVzS3Nyv2GAb3ywRd38HCt1nUFhUYxgnl+aIGhsjAm7prEMYCi2sXGIQyFeF9mVInsxxn9IcWwPWzmpqtaupkq0FNuXpBUn29GVH3QBM2qjLJxVOi42QfXHlf3IMCVhMLeWDlTIkrlUu/XxUDQLrblRccXdMNDn9QVUJNZRW0NRO8yb9wgwVw4+zaVvYv3JkMBNJVoUfuSqmyFE+MumLBFjGYN1O4vbfEPd7QkW8uMJwSAzriEBjKBOcdh7S8EsFug8s5kvB+j86IbHPcNhiKQ3LxkmFwb7F9WBlKbazkc1JNzfMb4kzJRSUF9SbT79c93fy/0PQYXhZjU+jVGY+0u/FlZTGn0OPeYRg24GQzVE21gKWctT0pUhsTHGeQa6velKIoiqIoaBv/A1UYRA8mSNHeAAAAAElFTkSuQmCC"
                                                    alt="spinner-frame-5">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xxl-3">
                <div class="sticky-top-sec">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="title-header ng-star-inserted">
                                            <div class="d-flex align-items-center">
                                                <h5>Hóa đơn</h5>
                                            </div>
                                            <div button="" class="ng-star-inserted printOrder"><button
                                                    class="btn btn-animation btn-sm ms-auto" id="printOrder">Xuất đơn
                                                    hàng
                                                    <i class="ri-download-2-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tracking-total tracking-wrapper">
                                        <ul>
                                            <li>Tổng cộng <span></span></li>
                                            <li>Phí ship <span></span></li>
                                            <li>Voucher</li>
                                            <li class="d-flex justify-content-end">
                                                <p></p>
                                            </li>
                                            <li>Giảm giá <span class="text-danger"></span></li>
                                            <li>Thành tiền <span class="text-danger"></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header ng-star-inserted">
                                        <div class="d-flex align-items-center">
                                            <h5>Thông tin</h5>
                                        </div>
                                    </div>
                                    <div class="customer-detail tracking-wrapper">
                                        <ul>
                                            <li><label>Tên:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>Số điện thoại:</label>
                                                <h4></h4>
                                            </li>

                                            <li><label>Giao đến:</label>
                                                <h4>
                                                </h4>
                                            </li>
                                            <li><label>Ghi chú:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>Phương thức thanh toán:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>Thanh toán:</label>
                                                <h4></h4>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.2/jspdf.umd.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {


            let CouponDiscountType_FIX_AMOUNT = <?php echo json_encode($CouponDiscountType_FIX_AMOUNT); ?>;
            let CouponDiscountType_PERCENT = <?php echo json_encode($CouponDiscountType_PERCENT); ?>;


            let dataDetailOrder;

            const pathSegments = window.location.pathname.split('/');
            const orderId = pathSegments[pathSegments.length - 1];

            function fillOrderDetails(orderId) {

                $("#loading-icon").show();
                $("#time-line-status ul").empty();
                fetch(`http://127.0.0.1:8000/api/orders/${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        let amountAllItems = 0;
                        data.listStatusHistory.forEach((item) => {
                            let htmlStatusTimeLine = '';
                            switch (item.order_status_id) {
                                case 1:
                                    htmlStatusTimeLine = `
                                <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/pending.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Chờ xử lý</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 2:
                                    htmlStatusTimeLine = `
                                    <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/processing.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Đang xử lý</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 3:
                                    htmlStatusTimeLine = `
                                    <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/shiped.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Đang giao hàng</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 4:
                                    htmlStatusTimeLine = `
                                    
                            <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/delivered.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Đã giao hàng</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 5:
                                    htmlStatusTimeLine = `
                                    <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Giao hàng thất bại</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 7:
                                    htmlStatusTimeLine = `
                                    <li class="ng-star-inserted cancelled-box active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Hủy hàng</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 6:
                                    htmlStatusTimeLine = `
                                   
                            <li class="ng-star-inserted active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/delivered.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Hoàn thành</div>
                                    </div>
                                </div>
                            </li>
                                `
                                    break;

                                default:
                                    break;
                            }

                            $("#time-line-status ul").append(htmlStatusTimeLine);

                        })

                        // return;
                        $(".title-header .span-code").text(`#${data.listItemOrder[0].order.code}`);
                        $("#select_status").val(data.listItemOrder[0].order.order_statuses[0].id);

                        if (data.listItemOrder[0].order.order_statuses[0].id == 2) {
                            $(".printOrder").addClass("active");
                        } else {
                            $(".printOrder").removeClass("active");
                        }

                        $('#select-change-status').empty();
                        const tbody = $(".product-table tbody");
                        tbody.empty();
                        dataDetailOrder = data.listItemOrder
                        data.listItemOrder.forEach(dataProduct => {
                            amountAllItems += dataProduct.price_variant * dataProduct.quantity_variant;
                            const row = `
                    <tr class="ng-star-inserted">
                        <td class="product-image"><img  class="img-fluid" src="${dataProduct.product.thumbnail}" width="30px" height="30px" style="object-fit: cover"></td>
                        <td><h6>${dataProduct.name}</h6></td>
                        <td><h6>${dataProduct.name_variant}</h6></td>
                        <td><h6>${formatCurrency(dataProduct.price_variant)}</h6></td>
                        <td><h6>${dataProduct.quantity_variant}</h6></td>
                        <td><h6>${formatCurrency(dataProduct.price_variant * dataProduct.quantity_variant)}</h6></td>
                    </tr>`;
                            tbody.append(row);
                        });

                        const totalList = $(".tracking-total ul");
                        totalList.find("li:nth-child(1) span").text(`${formatCurrency(amountAllItems)}(VND)`);
                        totalList.find("li:nth-child(2) span").text(`Miễn ship`);

                        if (data.listItemOrder[0].order.coupon_discount_type == CouponDiscountType_PERCENT) {
                            totalList.find("li:nth-child(4) p").text(
                                `${data.listItemOrder[0].order.coupon_code}:  ${data.listItemOrder[0].order.coupon_discount_value}%`
                            );
                            totalList.find("li:nth-child(5) span").text(
                                `-${formatCurrency(amountAllItems*data.listItemOrder[0].order.coupon_discount_value/100)}(VND)`
                            );
                            totalList.find("li:nth-child(6) span").text(
                                `${formatCurrency(amountAllItems - amountAllItems*data.listItemOrder[0].order.coupon_discount_value/100)}(VND)`
                            );

                        } else if (data.listItemOrder[0].order.coupon_discount_type ==
                            CouponDiscountType_FIX_AMOUNT) {
                            totalList.find("li:nth-child(4) p").text(
                                `${data.listItemOrder[0].order.coupon_code}:  `);
                            totalList.find("li:nth-child(5) span").text(
                                `-${formatCurrency(data.listItemOrder[0].order.coupon_discount_value)}(VND)`
                            );
                            totalList.find("li:nth-child(6) span").text(
                                `${formatCurrency(amountAllItems - data.listItemOrder[0].order.coupon_discount_value)}(VND)`
                            );
                        }

                        $(".btn-animation").attr("href", data.listItemOrder.invoice_url);

                        //Cập nhật thông tin khách hàng
                        const customerDetail = $(".customer-detail ul");
                        customerDetail.find("li:nth-child(1) h4").text(
                            `${data.listItemOrder[0].order.fullname}`);
                        customerDetail.find("li:nth-child(2) h4").text(
                            `${data.listItemOrder[0].order.phone_number}`);
                        customerDetail.find("li:nth-child(3) h4").text(
                            `${data.listItemOrder[0].order.address}`);
                        customerDetail.find("li:nth-child(4) h4").text(
                            `${data.listItemOrder[0].order.note??""}`);
                        customerDetail.find("li:nth-child(5) h4").text(
                            `${data.listItemOrder[0].order.payment.name}`);
                        if (data.listItemOrder[0].order.is_paid == 1) {
                            customerDetail.find("li:nth-child(6) h4").text(`Đã thanh toán`);
                        } else {
                            customerDetail.find("li:nth-child(6) h4").text(`Chưa thanh toán`);
                        }

                        const selectHtmlStatus = `
                        <select class="font-serif form-select form-select-sm orderStatus" style="width: unset" id="select_status">
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "1" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=1 ? "disabled" : ""} value="1">Chờ xử lý</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "2" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=2 ? "disabled" : ""} value="2">Đang xử lý</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "3" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=3 ? "disabled" : ""} value="3">Đang giao hàng</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "4" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=4 ? "disabled" : ""} value="4">Đã giao hàng</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "5" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=5 ? "disabled" : ""} value="5">Giao hàng thất bại</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "6" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=6 ? "disabled" : ""} value="6">Hoàn thành</option>
                        <option ${data.listItemOrder[0].order.order_statuses[0].id == "7" ? "selected" : ""} ${data.listItemOrder[0].order.order_statuses[0].id>=7 ? "disabled" : ""} value="7">Đã hủy</option>
                         </select>
                    
                    `
                        $('#select-change-status').append(selectHtmlStatus);

                        if (data.listItemOrder[0].order.order_statuses[0].id == 7) {
                            $(".span-failed").addClass("active");
                            $(".span-completed").removeClass("active");
                            $(".orderStatus").removeClass("active");
                        } else if (data.listItemOrder[0].order.order_statuses[0].id == 6) {
                            $(".span-failed").removeClass("active");
                            $(".span-completed").addClass("active");
                            $(".orderStatus").removeClass("active");
                        } else {
                            $(".span-failed").removeClass("active");
                            $(".span-completed").removeClass("active");
                            $(".orderStatus").addClass("active");
                        }

                        $('.orderStatus').on('change', function() {

                            const selectedValue = $(this).val();

                            $.ajax({
                                url: '{{ route('api.orders.changeStatusOrder') }}',
                                type: 'POST',
                                data: {
                                    order_id: orderId,
                                    status_id: selectedValue
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        fillOrderDetails(orderId);
                                        if (selectedValue == 1) {
                                            $(".printOrder").addClass("active");
                                        } else {
                                            $(".printOrder").removeClass("active");

                                        }
                                    }
                                },
                                error: function(error) {
                                    console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                        error);
                                }
                            });
                        });

                    })
                    .catch(error => {
                        console.error("Lỗi khi lấy dữ liệu:", error);
                        alert("Lỗi khi lấy dữ liệu từ API!");
                    })
                    .finally(() => {
                        // Ẩn icon loading
                        $("#loading-icon").hide();
                    });
            }






            if (!isNaN(parseInt(orderId))) {
                fillOrderDetails(orderId);
            } else {
                console.error("Không tìm thấy id_order trong URL hoặc id_order không phải là số.");
            }

            $("#printOrder").click(function() {


                fetch(`http://127.0.0.1:8000/api/orders/invoice/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Nếu dùng Laravel
                        },
                        body: JSON.stringify({
                            orderData: dataDetailOrder
                        }) // orderData là dữ liệu đơn hàng của bạn
                    })
                    .then((response) => {
                        return response.blob();
                    }) // response.blob() nếu muốn trả về file pdf trực tiếp. response.json() nếu trả về đường dẫn
                    .then(blob => {
                        //Tạo link download
                        const url = window.URL.createObjectURL(blob);
                        window.open(url); // Mở PDF trong tab mới
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });


            })


        })
    </script>
    <!-- Thêm SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/utility.js') }}"></script>
@endpush
