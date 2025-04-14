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
                                            <h5>{{ __('form.order.code') }} <span class="span-code"></span></h5>
                                        </div>
                                        <div id="select-change-status">
                                        </div>

                                        <div _ngcontent-ng-c1063460097="" class="ng-star-inserted span-completed">
                                            <div class="status-completed"><span>{{ __('message.completed') }}</span></div>
                                        </div>
                                        <div _ngcontent-ng-c1063460097="" class="ng-star-inserted span-failed">
                                            <div class="status-failed"><span>{{ __('message.canceled') }}</span></div>
                                        </div>
                                    </div>
                                    <div class="tracking-wrapper table-responsive">
                                        <table class="table product-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('form.order_item.image') }}</th>
                                                    <th scope="col">{{ __('form.order_item.name') }}</th>
                                                    <th scope="col">{{ __('form.order_item.name_variant') }}</th>
                                                    <th scope="col">{{ __('form.order_item.price') }}(VND)</th>
                                                    <th scope="col">{{ __('form.order_item.quantity') }}</th>
                                                    <th scope="col">{{ __('form.order_item.total_amount') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <div id="loading-icon-load">
                                            <div id="loading-icon" style="display: none;">
                                                <img src="data:image/png;base64,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"
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
                                                <h5>{{ __('message.invoice') }}</h5>
                                            </div>
                                            <div button="" class="ng-star-inserted printOrder"><button
                                                    class="btn btn-animation btn-sm ms-auto"
                                                    id="printOrder">{{ __('message.export_order') }}
                                                    <i class="ri-download-2-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tracking-total tracking-wrapper">
                                        <ul>
                                            <li>{{ __('message.total') }} <span></span></li>
                                            <li>{{ __('message.shipping_fee') }} <span></span></li>
                                            <li>Voucher</li>
                                            <li class="d-flex justify-content-end">
                                                <p></p>
                                            </li>
                                            <li>{{ __('message.discount') }} <span class="text-danger"></span></li>
                                            <li>{{ __('message.total_amount') }} <span class="text-danger"></span></li>
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
                                            <h5>{{ __('message.information') }}</h5>
                                        </div>
                                    </div>
                                    <div class="customer-detail tracking-wrapper">
                                        <ul>
                                            <li><label>{{ __('form.order.fullname') }}:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>{{ __('form.order.phone_number') }}:</label>
                                                <h4></h4>
                                            </li>

                                            <li><label>{{ __('form.order.address') }}:</label>
                                                <h4>
                                                </h4>
                                            </li>
                                            <li><label>{{ __('form.order.note') }}:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>{{ __('form.order.type_payment') }}:</label>
                                                <h4></h4>
                                            </li>
                                            <li><label>{{ __('form.order.is_paid') }}:</label>
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

    @component('components.modal.confirm', [
        'id' => 'modalUpload',
        'title' => 'Tải ảnh minh chứng',
    ])
        <form id="formUploadImageOrder" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" hidden value="" name="order_id" class="hiddenIDOrderUpload">
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="icon">
                    Ảnh đơn hàng
                </label>
                <div class="col-sm-9">
                    <input type="file" name="employee_evidence" id="employee_evidence" class="form-control">
                </div>

                <div class="invalid-feedback error-confirm"></div>

            </div>
            <div class="align-items-center g-2 mb-4 row">
                <label class="col-sm-3 form-label-title mb-0 text-start" for="name">
                    Ghi chú
                    <span class="theme-color ms-2 required-dot ">*</span>
                </label>
                <div class="col-sm-9">
                    <textarea name="note" id="text-note-checkout-order-upload" cols="15" class="form-control note"></textarea>
                </div>
            </div>

            <div class="button-box justify-content-end">
                <button class="btn btn-md btn-secondary fw-bold btn-cancel" type="button">
                    {{ __('message.cancel') }}
                </button>
                <button class="btn btn-md btn-theme fw-bold btn-action" type="submit">
                    Xác nhận
                </button>
            </div>
        </form>
    @endcomponent
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.2/jspdf.umd.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {


            const dataUser = <?php echo json_encode($user); ?>;

            $('#modalUpload').on('shown.bs.modal', function() {
                //Xử lý khi modal được hiển thị
                $('.btn-cancel').click(function() {
                    $('#formUploadImageOrder')[0].reset(); //Reset form
                    $('.error-confirm').html(''); //Xóa thông báo lỗi
                    $('.note').val(''); // Xóa nội dung textarea nếu có
                });
            });
            let imageUploaded = false;


            $('#formUploadImageOrder').on("submit", function(event) {
                event.preventDefault();

                const formData = new FormData(this);
                const order_id = $("#formUploadImageOrder .hiddenIDOrderUpload").val();

                $.ajax({
                    url: `http://127.0.0.1:8000/api/orders/uploadImgConfirm/${order_id}`,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#formUploadImageOrder .error-confirm').text("Trường bắt buộc")
                        }
                        if (response.status == 200) {

                            imageUploaded = true;
                            $('.error-confirm').html('');
                            $('#formUploadImageOrder .note').val("")
                            $('#formUploadImageOrder')[0].reset();
                            $('#modalUpload').modal('hide');
                            fillOrderDetails(order_id);
                            alert("Cập nhật thành công.");
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:", error);
                    }
                });

            });

            let CouponDiscountType_FIX_AMOUNT = <?php echo json_encode($CouponDiscountType_FIX_AMOUNT); ?>;
            let CouponDiscountType_PERCENT = <?php echo json_encode($CouponDiscountType_PERCENT); ?>;


            let dataDetailOrder;

            const pathSegments = window.location.pathname.split('/');
            const orderId = pathSegments[pathSegments.length - 1];

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channel = pusher.subscribe('order-status.' + orderId);
            channel.bind('event-change-status', function(data) {
                if (data.userID != dataUser.id) {

                    fillOrderDetails(orderId)
                }
            });

            var channel = pusher.subscribe('order-status-lock.' + orderId);
            channel.bind('event-change-status-lock', function(data) {
                if (data.userID != dataUser.id) {
                    if (data.status == 0) {
                        $(`#select_status`).prop('disabled', false);
                    } else {
                        $(`#select_status`).prop('disabled', true);
                    }

                }
            });

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
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
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
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
                                    
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
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
                                    
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
                                            src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Giao hàng thất bại</div>
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
                                    
                                        </div>
                                </div>
                            </li>
                                `
                                    break;
                                case 6:
                                    htmlStatusTimeLine = `
                                    <li class="ng-star-inserted cancelled-box active">
                                <div class="panel-content">
                                    <div class="icon"><img alt="image" class="img-fluid"
                                            src="/theme/admin/assets/svg/cancelled.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Hủy hàng</div>
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
                                    
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
                                            src="/theme/admin/assets/svg/delivered.svg" width="100px">
                                    </div>
                                    <div>
                                        <div class="status">Hoàn thành</div>
                                        <span style="font-size: 10px">${convertDate(item.created_at)}</span>
                                        <p style="font-size: 12px">${item.user?item.user.fullname:""}</p>
                                    
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

                            if (!dataProduct.product_variant_id) {
                                console.log("dataProduct.name_variant", dataProduct.name_variant)
                                console.log("amountAllItems", amountAllItems)
                                amountAllItems += dataProduct.price * dataProduct.quantity;
                            } else {
                                amountAllItems += dataProduct.price_variant * dataProduct
                                    .quantity_variant;
                                console.log("dataProduct.name_variant2", dataProduct.name_variant)

                            }
                            const imageUrl =
                                `{{ Storage::url('${dataProduct.product.thumbnail}') }}`; //Laravel Blade syntax
                            //Chuyển đổi thành Javascript string
                            const jsImageUrl = imageUrl.replace(/\{\{\s*|\s*\}\}/g, '');

                            const row = `
                    <tr class="ng-star-inserted">
                        <td class="product-image"><img  class="img-fluid" src="${jsImageUrl}" width="30px" height="30px" style="object-fit: cover"></td>
                        <td><h6>${dataProduct.name}</h6></td>
                        <td><h6>${dataProduct.product_variant_id?dataProduct.name_variant:"Không"}</h6></td>
                        <td><h6>${dataProduct.product_variant_id?formatCurrency(parseFloat(dataProduct.price_variant)):formatCurrency(parseFloat(dataProduct.price))}</h6></td>
                        <td><h6>${dataProduct.product_variant_id?dataProduct.quantity_variant:dataProduct.quantity}</h6></td>
                        <td><h6>${dataProduct.product_variant_id?formatCurrency(parseFloat(dataProduct.price_variant) * parseFloat(dataProduct.quantity_variant)):formatCurrency(parseFloat(dataProduct.price)*parseFloat(dataProduct.quantity))}</h6></td>
                    </tr>`;
                            tbody.append(row);
                        });

                        const totalList = $(".tracking-total ul");
                        console.log("amountAllItems,", amountAllItems);
                        totalList.find("li:nth-child(1) span").text(`${formatCurrency(amountAllItems)}(VND)`);
                        totalList.find("li:nth-child(2) span").text(`Miễn ship`);
                        console.log("data:", data)
                        if (data.listItemOrder[0].order.coupon_discount_type == CouponDiscountType_PERCENT) {
                            totalList.find("li:nth-child(4) p").text(
                                `${data.listItemOrder[0].order.coupon_code}:  -${parseFloat(data.listItemOrder[0].order.coupon_discount_value)}%`
                            );
                            if (parseFloat(amountAllItems * data.listItemOrder[0].order.coupon_discount_value) /
                                100 > parseFloat(data
                                    .listItemOrder[0].order.coupon.restriction.max_discount_value)) {
                                totalList.find("li:nth-child(5) span").text(
                                    `-${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(data.listItemOrder[0].order.coupon.restriction.max_discount_value)):0}(VND)`
                                );
                                totalList.find("li:nth-child(6) span").text(
                                    `${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(data.listItemOrder[0].order.coupon.restriction.max_discount_value)):formatCurrency(parseFloat(amountAllItems))}(VND)`
                                );

                            } else {
                                totalList.find("li:nth-child(5) span").text(
                                    `-${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems*data.listItemOrder[0].order.coupon_discount_value)/100):0}(VND)`
                                );
                                totalList.find("li:nth-child(6) span").text(
                                    `${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(amountAllItems*data.listItemOrder[0].order.coupon_discount_value)/100):formatCurrency(parseFloat(amountAllItems))}(VND)`
                                );

                            }



                        } else if (data.listItemOrder[0].order.coupon_discount_type ==
                            CouponDiscountType_FIX_AMOUNT) {
                            totalList.find("li:nth-child(4) p").text(
                                `${data.listItemOrder[0].order.coupon_code}:  `);
                            totalList.find("li:nth-child(5) span").text(
                                `-${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(data.listItemOrder[0].order.coupon_discount_value)):0}(VND)`
                            );
                            totalList.find("li:nth-child(6) span").text(
                                `${data.listItemOrder[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(data.listItemOrder[0].order.coupon_discount_value)):formatCurrency(parseFloat(amountAllItems))}(VND)`
                            );

                        } else {
                            totalList.find("li:nth-child(6) span").text(
                                `${formatCurrency(amountAllItems)}(VND)`
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

                        const orderStatuses = [{
                                id: 1,
                                name: "Chờ xử lý",
                                next: [1, 2, 7]
                            },
                            {
                                id: 2,
                                name: "Đang xử lý",
                                next: [2, 3, 7]
                            },
                            {
                                id: 3,
                                name: "Đang giao hàng",
                                next: [3, 4, 5]
                            },
                            // {
                            //     id: 4,
                            //     name: "Đã giao hàng",
                            //     next: [4, 6, 7]
                            // },
                            {
                                id: 4,
                                name: "Giao hàng thất bại",
                                next: [4, 6]
                            },
                            {
                                id: 5,
                                name: "Hoàn thành",
                                next: [6, 7]
                            },
                            {
                                id: 6,
                                name: "Đã hủy",
                                next: []
                            }
                        ];

                        const currentStatusId = data.listItemOrder[0].order.order_statuses[0].id;
                        let selectHtmlStatus = `
                    <select class="font-serif form-select form-select-sm orderStatus" style="width: unset" ${data.listItemOrder[0].order.locked_status == 1 ? "disabled":""} id="select_status">
                `;

                        orderStatuses.forEach(status => {
                            selectHtmlStatus += `
                    <option value="${status.id}">${status.name}</option>
                `;
                        });

                        selectHtmlStatus += `</select>`;

                        console.log("currentStatusId:", currentStatusId)

                        $('#select-change-status').append(selectHtmlStatus);
                        $('#select-change-status #select_status').val(currentStatusId);
                        // Hàm để cập nhật trạng thái disabled của các option
                        function updateSelectStatus() {
                            const currentStatus = parseInt(currentStatusId);
                            const currentStatusObj = orderStatuses.find(s => s.id === currentStatus);
                            console.log("currentStatusObj", currentStatusObj)
                            $('#select_status option').each(function() {
                                const status = parseInt($(this).val(), 10);
                                $(this).prop('disabled', !currentStatusObj.next.includes(status));
                            });
                        }

                        // Gọi hàm để thiết lập trạng thái ban đầu
                        updateSelectStatus();

                        // Gọi hàm mỗi khi select thay đổi
                        // $('#select_status').on('change', updateSelectStatus);



                        if (data.listItemOrder[0].order.order_statuses[0].id == 6) {
                            $(".span-failed").addClass("active");
                            $(".span-completed").removeClass("active");
                            $(".orderStatus").removeClass("active");
                        } else if (data.listItemOrder[0].order.order_statuses[0].id == 5) {
                            $(".span-failed").removeClass("active");
                            $(".span-completed").addClass("active");
                            $(".orderStatus").removeClass("active");
                        } else {
                            $(".span-failed").removeClass("active");
                            $(".span-completed").removeClass("active");
                            $(".orderStatus").addClass("active");
                        }
                        const currentValue = $('.orderStatus').val();

                        $('.orderStatus').on('change', function() {

                            const selectedValue = parseInt($(this).val());

                            if (!confirm('Bạn có chắn chắn muốn thay đổi trạng thái?')) {
                                $('.orderStatus').val(currentValue);
                                updateSelectStatus();
                                return;
                            }

                            // if (selectedValue === 4) { // Nếu chọn "Đã giao hàng" (id 4)

                            //     $("#modalUpload .hiddenIDOrderUpload").val(orderId);
                            //     $('#modalUpload').on('hidden.bs.modal', function() {
                            //         if (!imageUploaded) {
                            //             // Nếu ảnh chưa được upload, đặt lại trạng thái về "Đang giao hàng"
                            //             $('.orderStatus').val(3);
                            //             updateSelectStatus();
                            //         }
                            //     });
                            //     $('#modalUpload').modal('show');
                            //     return;
                            // }

                            $.ajax({
                                url: '{{ route('api.orders.changeStatusOrder') }}',
                                type: 'POST',
                                data: {
                                    order_id: orderId,
                                    status_id: selectedValue,
                                    user_id: dataUser.id
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        fillOrderDetails(orderId);
                                        // updateSelectStatus()
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

                        // $('.orderStatus').on('focus', function() {
                        //     $(this).data('previous-value', $(this).val());
                        // });

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

            let lockTimers = {};
            let blurTimers = {};



            function lockOrder(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.lockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        user_id: dataUser.id
                    },
                    success: function(response) {
                        console.log("responselockkkkkkk:", response);
                        if (response.status == 200) {
                            // selectElement.prop('disabled', true);

                            console.log("loked order lock order")
                            if (lockTimers[orderId]) {
                                clearTimeout(lockTimers[orderId]);
                            }
                            lockTimers[orderId] = setTimeout(() => unlockOrder(orderId, selectElement),
                                60000);

                            if (blurTimers[orderId]) {
                                clearTimeout(blurTimers[orderId]);
                            }
                            blurTimers[orderId] = setTimeout(() => {
                                if (selectElement) {
                                    selectElement.blur();
                                    console.log('Automatically blurred select.');
                                }
                                selectElement.prop('disabled', false);

                            }, 60000);
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }

            function unlockOrder(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.unlockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        user_id: dataUser.id

                    },
                    success: function(response) {
                        console.log("response0000000000000000lockkkkkkk:", response);

                        if (response.status == 200) {
                            console.log(" un loked order lock order")
                            selectElement.prop('disabled', false);

                            clearTimeout(lockTimers[orderId]);
                            clearTimeout(blurTimers[orderId]);
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }


            function checkOrderLock(orderId, selectElement) {
                $.ajax({
                    url: '{{ route('api.orders.checkLockOrder') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == 200) {
                            if (response.locked == 1) {
                                selectElement.prop('disabled', true);
                                alert('Đơn hàng này đã bị khóa.');

                            } else {
                                lockOrder(orderId, selectElement)
                            }
                        }
                    },
                    error: function(error) {
                        console.error("Lỗi cập nhật trạng thái đơn hàng:",
                            error);
                    }
                });
            }

            $('#select-change-status').on('focus', '.orderStatus', function() {
                checkOrderLock(orderId, $(this));
                console.log("orderId11111:", orderId);

            }).on('blur', '.orderStatus', function() {
                console.log("orderId22222222222222:", orderId);

                unlockOrder(orderId, $(this));
            });



            // echo.channel('order-status.' + orderId)
            //     .listen('OrderStatusUpdated', (e) => {
            //         console.log('Order status updated:', e.status);

            //         fillOrderDetails(orderId)
            //     });


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
    //
@endpush
