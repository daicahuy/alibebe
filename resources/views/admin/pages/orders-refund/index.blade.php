@extends('admin.layouts.master')



@push('css')
    <style>
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

        .price-old {
            text-decoration: line-through;
            color: #999;
            font-size: 12px;
        }

        .price-new {
            color: red;
            font-weight: bold;
            font-size: 16px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Màu đen mờ */
            z-index: 1000;
            /* Đảm bảo overlay ở trên cùng */
            display: none;
            /* Ẩn overlay ban đầu */
        }

        .modal-open .overlay {
            display: block;
            /* Hiện overlay khi modal mở */
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>Hoàn hàng</h5>
                            </div>
                        </div><!----><app-table>
                            <div class="show-box">
                                <div class="selection-box"></div>
                                <div class="datepicker-wrap"><!----></div>
                                <div class="table-search"><label for="role-search" class="form-label">Tìm kiếm
                                        :</label><input type="search" id="search"
                                        class="form-control ng-untouched ng-pristine ng-valid"></div>
                            </div><!---->
                            <div>
                                <div class="table-responsive datatable-wrapper border-table"><!---->
                                    <table id="orderTable" class="table all-package theme-table no-footer">
                                        <thead>
                                            <tr><!---->
                                                <th> Order Code <!----></th>
                                                <th class="cursor-pointer">Tên khách hàng <div class="filter-arrow">
                                                        <div><i class="ri-arrow-up-s-fill"></i><!----><!----></div>
                                                    </div><!----></th>
                                                <th> Trạng thái <!----></th>
                                                <th class="cursor-pointer"> Ngày tạo <div class="filter-arrow">
                                                        <div><i class="ri-arrow-up-s-fill"></i><!----><!----></div>
                                                    </div><!----></th><!---->
                                                <th>Hành động</th><!---->
                                            </tr>
                                        </thead>
                                        <tbody id="bodyTable">

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
                            <nav aria-label="Page navigation example" class="mt-3">
                                <ul class="pagination justify-content-center" id="pagination"></ul>
                            </nav>
                            <!----><app-delete-modal><!----></app-delete-modal><app-confirmation-modal><!----></app-confirmation-modal>
                        </app-table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirm" tabindex="-1" aria-hidden="true">
        <div class="overlay">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                    <div class="modal-body text-center">
                        <div class="modal-content" id="modalConfirm">
                            <div class="modal-header">
                                <h3 class="mb-1 fw-semibold">Hoàn hàng</h3><app-button><button fdprocessedid="b2b4oc"
                                        class="btn btn-close" id="payout_close_btn" type="submit">
                                    </button></app-button>
                            </div>
                            <div class="modal-body">
                                <div class="border rounded-3">
                                    <input type="text" hidden id="idOrderRefund">
                                    <table class="table all-package theme-table no-footer">
                                        <tbody><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Nhân viên đang xử lý</td>
                                                <td class="text-start" id="user_handle"></td>
                                            </tr><!---->
                                            <tr class="" id="div_comfirm_order_with_admin" style="display: none">

                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Lý do </td>
                                                <td class="text-start" id="reason"></td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Hình ảnh/video</td>
                                                <td class="text-start"><img src="" alt=""
                                                        id="reason-thumbnail-image" class="thumbnail-image"
                                                        style="width: 50px; height: 50px;display: none;">
                                                    <video id="reason-thumbnail-video" class="thumbnail-video"
                                                        style="width: 200px; height: 100px; display: none;" controls>
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Giá trị hoàn</td>
                                                <td class="text-start" id="total_amount"></td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Số điện thoại liên hệ</td>
                                                <td class="text-start" id="phone_number"></td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Tên người thụ hưởng </td>
                                                <td class="text-start" id="user_bank_name"></td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Tên ngân hàng </td>
                                                <td class="text-start"id="bank_name"></td>
                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Số tài khoản </td>
                                                <td class="text-start" id="bank_account"></td>
                                            </tr><!---->
                                            <tr class="" id="div_comfirm_bank" style="display: none">

                                            </tr><!---->
                                            <tr>
                                                <td class="text-start fw-semibold">Trạng thái</td>
                                                <td class="text-start">
                                                    <div class="status"><span id="status"></span></div>
                                                </td>
                                            </tr><!---->
                                        </tbody>
                                    </table>
                                </div>
                                <form id="formCompltedOrFail" method="POST" enctype="multipart/form-data">
                                    <div class="mt-2" id="admin_reason_div">


                                    </div>
                                    <div class="mt-2">
                                        <div class="button-box" id="button-box-footer">
                                        </div><!---->
                                    </div><!---->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hình Ảnh -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hình ảnh</h5>
                    <button type="button" class="btn-close" id="btn-close-modal-img" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="Hình ảnh phóng to" id="modalImage" style="max-width: 100%; height: auto;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btn-cancel-modal-img">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmProduct" tabindex="-1" aria-hidden="true">
        <div class="overlay">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 800px">
                <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                    <div class="modal-body text-center">
                        <div class="modal-content" id="modalConfirm">
                            <div class="modal-header">
                                <h3 class="mb-1 fw-semibold">Sản phẩm hoàn</h3><app-button><button fdprocessedid="b2b4oc"
                                        class="btn btn-close" id="payout_close_btn_product" type="submit">
                                    </button></app-button>
                            </div>
                            <div class="modal-body" id="listItem">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_library')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const dataUser = <?php echo json_encode($user); ?>;

            let currentPage = 1;
            let itemsPerPage = 5;

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), delay);
                }
            }

            function getStatusInVietnamese(status) {
                const statusMap = {
                    'pending': 'Đang chờ',
                    'receiving': 'Chờ vận chuyển',
                    'completed': 'Hoàn hàng thành công',
                    'rejected': 'Bị từ chối',
                    'failed': 'Thất bại',
                    'cancel': 'Hủy'
                };
                return statusMap[status] || status; //
            }

            function getStatusBank(status) {
                const statusMap = {
                    'unverified': 'Chưa xác nhận tài khoản',
                    'sent': 'Chờ xác nhận tài khoản',
                    'verified': 'Đã xác nhân tài khoản',

                };
                return statusMap[status] || status;
            }

            function renderHtmlModalOrderRefund(dataOrderRefund) {

                Pusher.logToConsole = true;

                var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                });

                var channel = pusher.subscribe('order-refund-status.' + dataOrderRefund.id);
                channel.bind('event-change-status-refund', function(data) {
                    callApiGetDataOrderRefund()
                });
                console.log("dataOrderRefund", dataOrderRefund)
                $('#button-box-footer').empty();
                $("#modalConfirm #admin_reason_div").empty();
                $("#modalConfirm #admin_reason_div").append(`<div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="admin_reason" style="height: 100px"></textarea>
                                        <label for="floatingTextarea2">Lý do từ chối</label>
                                    </div>`)
                const imageUrl =
                    `{{ Storage::url('${dataOrderRefund.reason_image}') }}`;

                const jsImageUrl = imageUrl.replace(/\{\{\s*|\s*\}\}/g, '');
                const isVideo = jsImageUrl.match(/\.(mp4|mov|avi|wmv|mkv)$/i);

                if (isVideo) {

                    $("#modalConfirm #reason-thumbnail-image").hide();
                    $("#modalConfirm #reason-thumbnail-video")
                        .attr("src", jsImageUrl)
                        .show();
                } else {

                    $("#modalConfirm #reason-thumbnail-video").hide();
                    $("#modalConfirm #reason-thumbnail-image")
                        .attr("src", jsImageUrl)
                        .show();
                }
                $("#modalConfirm #reason").text(dataOrderRefund.reason ? dataOrderRefund.reason : "")
                $("#modalConfirm #user_handle").text(dataOrderRefund.handle_user && dataOrderRefund.handle_user
                    .fullname != null ? dataOrderRefund
                    .handle_user
                    .fullname : "")
                $("#modalConfirm #idOrderRefund").val(dataOrderRefund.id)
                $("#modalConfirm #total_amount").text(`${formatCurrency(dataOrderRefund.total_amount)}đ`)
                $("#modalConfirm #phone_number").text(dataOrderRefund.phone_number ? dataOrderRefund
                    .phone_number : "")
                $("#modalConfirm #user_bank_name").text(dataOrderRefund.user_bank_name ? dataOrderRefund
                    .user_bank_name : "")
                $("#modalConfirm #bank_name").text(dataOrderRefund.bank_name ? dataOrderRefund.bank_name : "")
                $("#modalConfirm #bank_account").text(dataOrderRefund.bank_account ? dataOrderRefund.bank_account :
                    "")
                $("#modalConfirm #status").text(dataOrderRefund.status ? getStatusInVietnamese(dataOrderRefund
                    .status) : "")
                if (dataOrderRefund.status == 'rejected' || dataOrderRefund.status == 'pending') {
                    $("#modalConfirm #admin_reason").val(dataOrderRefund.admin_reason ? dataOrderRefund
                        .admin_reason :
                        "")
                } else {
                    $("#modalConfirm #admin_reason_div").empty()
                }
                if (dataOrderRefund.status == 'rejected') {
                    $("#div_comfirm_bank").empty()
                    $("#div_comfirm_order_with_admin").empty()
                    $("#div_comfirm_order_with_admin").show()

                    if (dataUser.role != 2) {

                        if (dataOrderRefund.confirm_order_with_admin == null) {

                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id=""><button id="btn_confirm_order_with_admin" class="btn btn-primary">Gửi xác nhận</button></td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else if (dataOrderRefund.confirm_order_with_admin == 2) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đã gửi xác nhận</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        } else if (dataOrderRefund.confirm_order_with_admin == 1) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đồng ý đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', false);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Từ chối đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        }
                    }


                    $("#modalConfirm #admin_reason").attr("disabled", true);
                }
                if (dataOrderRefund.status == 'pending') {
                    $("#div_comfirm_bank").empty()

                    $("#div_comfirm_order_with_admin").empty()
                    $("#div_comfirm_order_with_admin").show()

                    if (dataUser.role != 2) {

                        if (dataOrderRefund.confirm_order_with_admin == null) {

                            $("#div_comfirm_order_with_admin").append(`
                                <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
                                <td class="text-start" id=""><button id="btn_confirm_order_with_admin" class="btn btn-primary">Gửi xác nhận</button></td>
                            `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else if (dataOrderRefund.confirm_order_with_admin == 2) {
                            $("#div_comfirm_order_with_admin").append(`
                                <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
                                <td class="text-start" id="">Đã gửi xác nhận</td>
                            `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        } else if (dataOrderRefund.confirm_order_with_admin == 1) {
                            $("#div_comfirm_order_with_admin").append(`
                                <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
                                <td class="text-start" id="">Đồng ý đơn hàng</td>
                            `)

                            $('#withdrawal_approved_btn').prop('disabled', false);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else {
                            $("#div_comfirm_order_with_admin").append(`
                                <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
                                <td class="text-start" id="">Từ chối đơn hàng</td>
                            `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        }

                        $("#btn_confirm_order_with_admin").on('click', function() {
                            $.ajax({
                                url: '{{ route('api.refund_orders.sentConfirmOrderWithAdmin') }}',
                                type: 'POST',
                                data: {
                                    id_order_refund: dataOrderRefund.id,
                                    status: 2
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        Toastify({
                                            text: "Thao tác thành công",
                                            duration: 2000,
                                            newWindow: true,
                                            close: true,
                                            gravity: "top",
                                            position: "right",
                                            stopOnFocus: true,
                                            style: {
                                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                                            },
                                        }).showToast();
                                        callApiGetDataOrderRefund(dataOrderRefund.id)
                                        fetchOrders()
                                    }
                                },
                                error: function(error) {
                                    console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                        error);
                                }
                            });


                        })
                    }


                    $('#button-box-footer').append(`<app-button><button class="btn btn-md  fw-bold"
                                                style="background-color: red; color: #fff;" disabled
                                                id="withdrawal_rejected_btn"  fdprocessedid="hbnu3">
                                                <div> Từ chối </div>
                                            </button></app-button>
                                        <app-button>
                                            <button class="btn btn-md btn-theme fw-bold" id="withdrawal_approved_btn"
                                                 fdprocessedid="qq0uf9" ${dataUser.role != 2 && dataOrderRefund.confirm_order_with_admin !=1 ? "disabled":""}>
                                                <div> Đông ý </div>
                                            </button></app-button>`)
                }

                if (dataOrderRefund.status == 'receiving') {
                    $("#div_comfirm_bank").empty()
                    $("#div_comfirm_bank").show();

                    $("#div_comfirm_order_with_admin").empty()
                    $("#div_comfirm_order_with_admin").show()

                    if (dataUser.role != 2) {

                        if (dataOrderRefund.confirm_order_with_admin == null) {

                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id=""><button id="btn_confirm_order_with_admin" class="btn btn-primary">Gửi xác nhận</button></td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else if (dataOrderRefund.confirm_order_with_admin == 2) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đã gửi xác nhận</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        } else if (dataOrderRefund.confirm_order_with_admin == 1) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đồng ý đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', false);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Từ chối đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        }
                    }


                    if (dataOrderRefund.bank_account_status == "unverified") {

                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id=""><button id="btn_confirm_bank" class="btn btn-primary">Gửi xác nhận</button></td>
                        `)
                    } else if (dataOrderRefund.bank_account_status == "sent") {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã gửi xác nhận</td>
                        `)
                    } else {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã xác nhận</td>
                        `)
                    }


                    $("#btn_confirm_bank").on('click', function() {
                        $.ajax({
                            url: '{{ route('api.refund_orders.sentConfirmBank') }}',
                            type: 'POST',
                            data: {
                                id_order_refund: dataOrderRefund.id,
                                status: 'sent'
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    Toastify({
                                        text: "Thao tác thành công",
                                        duration: 2000,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: "right",
                                        stopOnFocus: true,
                                        style: {
                                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                                        },
                                    }).showToast();
                                    callApiGetDataOrderRefund(dataOrderRefund.id)
                                    fetchOrders()
                                }
                            },
                            error: function(error) {
                                console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });


                    })



                    $("#modalConfirm #admin_reason_div").append(`
                    
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Nhập lý do thất bại" name="fail_reason" id="fail_reason" style="height: 100px"></textarea>
                            <label for="fail_reason">Lý do thất bại</label>
                        </div>
                        <div class="mb-3">
                            <label for="img_fail_or_completed" class="form-label">Tải lên ảnh</label>
                            <input class="form-control" type="file" id="img_fail_or_completed" name="img_fail_or_completed">
                            <div id="image_preview" class="mt-3">
                            <!-- Preview ảnh sẽ được hiển thị ở đây -->
                        </div>
                        </div>
                    `);

                    $('#button-box-footer').append(`<app-button><button class="btn btn-md  fw-bold"
                                                style="background-color: red; color: #fff;" disabled
                                                id="failed_btn" type="submit" fdprocessedid="hbnu3">
                                                <div> Thất bại </div>
                                            </button></app-button>
                                        <app-button>
                                            <button class="btn btn-md btn-theme fw-bold" id="completed_btn" disabled
                                                type="submit" fdprocessedid="qq0uf9">
                                                <div> Hoàn thành </div>
                                            </button></app-button>
                                        `)

                    $('#fail_reason, #img_fail_or_completed').on('input change', function() {
                        const reason = $('#fail_reason').val().trim();
                        const hasFile = $('#img_fail_or_completed').val();
                        const failedButton = $('#failed_btn');
                        const completedButton = $('#completed_btn');


                        if (reason.length > 0) {
                            failedButton.prop('disabled', false);
                        } else {
                            failedButton.prop('disabled', true);
                        }


                        if (reason.length === 0 && hasFile && dataOrderRefund.bank_account_status ==
                            "verified") {
                            completedButton.prop('disabled', false);
                        } else {
                            completedButton.prop('disabled', true);
                        }
                    });

                    $('#img_fail_or_completed').on('change', function() {
                        const file = this.files[0];
                        const previewContainer = $('#image_preview');


                        previewContainer.empty();

                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {

                                previewContainer.append(`
                        <img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="max-width: 100%; height: auto;">
                    `);
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                }

                if (dataOrderRefund.status == 'completed') {
                    $("#div_comfirm_bank").empty()
                    $("#div_comfirm_bank").show();
                    $("#div_comfirm_order_with_admin").empty()
                    $("#div_comfirm_order_with_admin").show()

                    if (dataUser.role != 2) {

                        if (dataOrderRefund.confirm_order_with_admin == null) {

                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id=""><button id="btn_confirm_order_with_admin" class="btn btn-primary">Gửi xác nhận</button></td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else if (dataOrderRefund.confirm_order_with_admin == 2) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đã gửi xác nhận</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        } else if (dataOrderRefund.confirm_order_with_admin == 1) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đồng ý đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', false);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Từ chối đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        }
                    }


                    if (dataOrderRefund.bank_account_status == "unverified") {

                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id=""><button id="btn_confirm_bank" class="btn btn-primary">Gửi xác nhận</button></td>
                        `)
                    } else if (dataOrderRefund.bank_account_status == "sent") {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã gửi xác nhận</td>
                        `)
                    } else {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã xác nhận</td>
                        `)
                    }
                    const imageUrl =
                        `{{ Storage::url('${dataOrderRefund.img_fail_or_completed}') }}`;
                    $("#modalConfirm #admin_reason_div").append(`

                        <div class="mb-3">
                            <div id="" class="mt-3">
                                <img src="${imageUrl}" alt="Preview Image" class="img-thumbnail" style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                    `);
                }

                if (dataOrderRefund.status == 'failed') {
                    $("#div_comfirm_bank").empty()
                    $("#div_comfirm_bank").show();
                    $("#div_comfirm_order_with_admin").empty()
                    $("#div_comfirm_order_with_admin").show()

                    if (dataUser.role != 2) {

                        if (dataOrderRefund.confirm_order_with_admin == null) {

                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id=""><button id="btn_confirm_order_with_admin" class="btn btn-primary">Gửi xác nhận</button></td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else if (dataOrderRefund.confirm_order_with_admin == 2) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đã gửi xác nhận</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        } else if (dataOrderRefund.confirm_order_with_admin == 1) {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Đồng ý đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', false);
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                        } else {
                            $("#div_comfirm_order_with_admin").append(`
        <td class="text-start fw-semibold">Xác nhận đơn hàng với admin</td>
        <td class="text-start" id="">Từ chối đơn hàng</td>
    `)

                            $('#withdrawal_approved_btn').prop('disabled', true);
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                        }
                    }


                    if (dataOrderRefund.bank_account_status == "unverified") {

                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id=""><button id="btn_confirm_bank" class="btn btn-primary">Gửi xác nhận</button></td>
                        `)
                    } else if (dataOrderRefund.bank_account_status == "sent") {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã gửi xác nhận</td>
                        `)
                    } else {
                        $("#div_comfirm_bank").append(`
                            <td class="text-start fw-semibold">Xác nhận số tài khoản</td>
                            <td class="text-start" id="">Đã xác nhận</td>
                        `)
                    }
                    if (dataOrderRefund.img_fail_or_completed) {

                        const imageUrl =
                            `{{ Storage::url('${dataOrderRefund.img_fail_or_completed}') }}`;
                        $("#modalConfirm #admin_reason_div").append(`
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Nhập lý do thất bại" name="fail_reason" id="fail_reason" disable style="height: 100px">${dataOrderRefund.fail_reason}</textarea>
                            <label for="fail_reason">Lý do thất bại</label>
                        </div>
                            <div class="mb-3">
                                <div id="" class="mt-3">
                                    <img src="${imageUrl}" alt="Preview Image" class="img-thumbnail" style="max-width: 100%; height: auto;">
                                </div>
                            </div>
                        `);
                    } else {
                        $("#modalConfirm #admin_reason_div").append(`
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Nhập lý do thất bại" name="fail_reason" id="fail_reason" disable style="height: 100px">${dataOrderRefund.fail_reason}</textarea>
                            <label for="fail_reason">Lý do thất bại</label>
                        </div>`);
                    }
                }



                $('#admin_reason').on('input', function() {
                    const reason = $(this).val()
                        .trim();
                    const rejectButton = $('#withdrawal_rejected_btn');
                    const approvedButton = $('#withdrawal_approved_btn');

                    if (dataUser.role == 2) {
                        if (reason.length > 0) {
                            $('#withdrawal_rejected_btn').prop('disabled', false);
                            $('#withdrawal_approved_btn').prop('disabled', true);
                        } else {
                            // Vô hiệu hóa cả hai nút nếu không có lý do
                            $('#withdrawal_rejected_btn').prop('disabled', true);
                            $('#withdrawal_approved_btn').prop('disabled', true);

                        }
                    } else {

                        if (dataOrderRefund.confirm_order_with_admin !== null && dataOrderRefund
                            .confirm_order_with_admin !== 2) {
                            if (reason.length > 0) {
                                $('#withdrawal_rejected_btn').prop('disabled', false);
                                $('#withdrawal_approved_btn').prop('disabled', true);
                            } else {
                                // Vô hiệu hóa cả hai nút nếu không có lý do
                                $('#withdrawal_rejected_btn').prop('disabled', true);
                                $('#withdrawal_approved_btn').prop('disabled', true);
                            }
                        }
                    }

                });
                $("#withdrawal_rejected_btn").off("click").on("click", function(event) {
                    event.preventDefault();
                    if (!confirm("Bạn có chắn chắn thao tác này không?")) {
                        return;
                    }

                    const adminReason = $("#modalConfirm #admin_reason").val();
                    const idRefund = $("#modalConfirm #idOrderRefund").val();
                    $.ajax({
                        url: '{{ route('api.refund_orders.changeStatus') }}',
                        type: 'POST',
                        data: {
                            adminReason: adminReason,
                            idRefund: idRefund,
                            user_handle: dataUser.id
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Toastify({
                                    text: "Thao tác thành công",
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    },
                                }).showToast();
                                callApiGetDataOrderRefund(idRefund)
                                fetchOrders()
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });



                })

                $("#withdrawal_approved_btn").off("click").on("click", function(event) {

                    console.log("!23")
                    event.preventDefault();
                    if (!confirm("Bạn có chắn chắn thao tác này không?")) {
                        return;
                    }

                    const idRefund = $("#modalConfirm #idOrderRefund").val();
                    $.ajax({
                        url: '{{ route('api.refund_orders.changeStatus') }}',
                        type: 'POST',
                        data: {
                            idRefund: idRefund,
                            user_handle: dataUser.id
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                Toastify({
                                    text: "Thao tác thành công",
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    },
                                }).showToast();
                                callApiGetDataOrderRefund(idRefund)
                                fetchOrders()
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });



                })

                $("#modalConfirm #formCompltedOrFail").off('submit').on('submit', function(event) {
                    event.preventDefault();
                    if (!confirm("Bạn chắc chắn với thao tác này không?")) {
                        return;
                    }

                    const formData = new FormData(this);
                    formData.append('id_order_refund', JSON.stringify(dataOrderRefund.id));
                    console.log(formData);
                    $.ajax({
                        url: '{{ route('api.refund_orders.changeStatusWithImg') }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            if (response.status == 200) {
                                Toastify({
                                    text: "Thao tác thành công",
                                    duration: 2000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    },
                                }).showToast();
                                callApiGetDataOrderRefund(dataOrderRefund.id)
                                fetchOrders();

                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });
                })



            }

            $('.thumbnail-image').on('click', function() {
                console.log('Image');
                var imageSrc = $(this).attr('src'); //
                $('#modalImage').attr('src', imageSrc);
                $('#imageModal').modal('show');
            });

            $("#btn-close-modal-img, #btn-cancel-modal-img").on("click", function(event) {
                event.preventDefault();
                $("#imageModal").modal("hide");
            });
            $("#imageModal").on("hidden.bs.modal", function(event) {
                if ($("#modalConfirm").hasClass("show")) {
                    $("body").addClass("modal-open");
                }
            });

            function callApiGetDataOrderRefund(idOrderRefund) {

                $.ajax({
                    url: `http://127.0.0.1:8000/api/refund-orders/${idOrderRefund}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            renderHtmlModalOrderRefund(response.dataOrderRefund)

                        } else {
                            alert('Something error happened');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi call api:", xhr.responseText);
                        alert(
                            "Lỗi call api"
                        );
                    }
                });


            }


            function renderHtmlModalProductOrderRefund(listItems) {
                $("#modalConfirmProduct #listItem").empty();
                let orderHTML = ``;

                orderHTML += listItems.map(item => {
                    const imageUrl =
                        `{{ Storage::url('${item.product.thumbnail}') }}`;
                    return `
                        
                        <div class="d-flex flex-row"
                    style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                    <div class="order-body d-flex">
                        <img src="${imageUrl}" alt="Product" class="me-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="d-flex flex-row" style="justify-content: space-between">
                            <div style="text-align: left">
                                <a href="/products/${item.product.slug}" class="mb-1">${item.name}</a>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    ${
                                        item.variant_id
                                            ? `Phân loại hàng: ${item.name_variant}`
                                            : ""
                                    }
                                </p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    x${
                                        item.variant_id
                                            ? item.quantity_variant
                                            : item.quantity
                                    }
                                </p>
                                <div style="margin-right: 15px">
                                         <span class="price-new ms-2">
                                    ${
                                        item.variant_id
                                            ? formatCurrency(item.price_variant)
                                            : formatCurrency(item.price)
                                    }₫
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row" style="margin-right: 15px">
                        <span>Thành tiền:</span>
                        <p class="price-new">${item.variant_id?`${formatCurrency(parseFloat(item.price_variant)*parseInt(item.quantity_variant))}`:`${formatCurrency(parseFloat(item.price)*parseInt(item.quantity))}`}₫</p>
                    </div>
                </div>    
                        
                        `
                })
                $("#modalConfirmProduct #listItem").append(orderHTML)

            }

            function callApiGetDataProductOrderRefund(idOrderRefund) {

                $.ajax({
                    url: `http://127.0.0.1:8000/api/refund-orders/${idOrderRefund}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            renderHtmlModalProductOrderRefund(response.dataOrderRefund
                                .refund_items)

                        } else {
                            alert('Something error happened');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi call api:", xhr.responseText);
                        alert(
                            "Lỗi call api"
                        );
                    }
                });


            }


            let changedOrderIds = [];
            let debounceTimer;

            function handleStatusChange(orderId) {

                if (!changedOrderIds.includes(orderId)) {
                    changedOrderIds.push(orderId);
                }


                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {

                    fetchOrders();
                    changedOrderIds = [];
                }, 2000);
            }

            function renderTable(orders, totalPages) {
                $("#orderTable tbody").empty();

                if (orders.length === 0) {
                    $("#orderTable tbody").append(`
            <tr>
              <p>Không có dữ liệu</p>
            </tr>
          `);
                } else {
                    orders.forEach(order => {
                        let statusClass;

                        Pusher.logToConsole = true;

                        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                        });

                        var channel = pusher.subscribe('order-refund-status.' + order.id);
                        channel.bind('event-change-status-refund', function(data) {
                            handleStatusChange(data.orderId)
                        });


                        // Xác định màu sắc của badge dựa trên trạng thái đơn hàng
                        switch (order.status) {
                            case 'completed':
                                statusClass = 'bg-success'; // Xanh
                                break;
                            case 'rejected':
                                statusClass = 'bg-danger'; // Đỏ
                                break;
                            case 'failed':
                                statusClass = 'bg-danger'; // Đỏ
                                break;
                            case 'pending':
                                statusClass = 'bg-warning'; // Vàng
                                break;
                            case 'cancel':
                                statusClass = 'bg-danger'; // Vàng
                                break;
                            default:
                                statusClass = 'bg-info'; // Màu khác nếu cần
                        }

                        $("#orderTable tbody").append(`
                    <tr data-id="${order.id}">
                        <td class="cursor-pointer">
                            <div><span class="fw-bolder">${order.order.code}</span></div>

                        </td>
                        <td class="cursor-pointer">
                            <div>${order.user.fullname}</div>
                        </td>
                        <td class="cursor-pointer">
                            <div>
                                <div class="status-approved"><span class="${statusClass}" style="border: unset">${getStatusInVietnamese(order.status)}</span>
                                    ${order.status == "receiving" ? `<span style="border: unset; margin-top: 6px; color: red">${getStatusBank(order.bank_account_status)}</span>`:""}
                                    ${order.status == "completed" && order.is_send_money == 0 ? `<span style="border: unset; margin-top: 6px; color: red">Xung đột</span>`:""}
                                    </div>
                            </div>
                        </td>
                        <td class="cursor-pointer">${convertDate(order.created_at)}

                        </td>
                        <td>
                            <ul id="actions">
                                <li class='action-view-order' data-order="${order.id}"><a href="javascript:void(0)"><i class="ri-eye-line"></i></a>
                                </li>
                                <li class='action-view-product' data-order="${order.id}"><a href="javascript:void(0)"><i class="ri-store-3-line"></i></a>
                                </li>
                            </ul>
                        </td>
                    </tr>
            `);
                    })

                    $('#actions .action-view-order').on("click", function() {
                        const orderId = $(this).data(
                            'order');

                        console.log(orderId);

                        callApiGetDataOrderRefund(orderId);

                        $('#modalConfirm').modal('show'); // Hiển thị modal
                    });

                    $('#actions .action-view-product').on("click", function() {
                        const orderId = $(this).data(
                            'order');

                        callApiGetDataProductOrderRefund(orderId)

                        $('#modalConfirmProduct').modal('show');
                    });


                }
            }



            $('#payout_close_btn').on('click', function(event) {
                event.stopPropagation();
                $('#button-box-footer').empty();
                const videoElement = $('#reason-thumbnail-video').get(0); // Lấy phần tử video
                if (videoElement) {
                    videoElement.pause(); // Tạm dừng video
                    videoElement.currentTime = 0; // Đặt thời gian phát về 0 (tùy chọn)
                }
                $('#modalConfirm').modal('hide');

            });
            $('#payout_close_btn_product').on('click', function(event) {
                event.stopPropagation();
                $('#modalConfirmProduct').modal('hide');

            })

            function fetchOrders(search = "") {
                $("#loading-icon").show();
                $.ajax({
                    url: '{{ route('api.refund_orders.index') }}',
                    method: "GET",
                    data: {
                        search,
                        page: currentPage,
                        limit: itemsPerPage,
                        user_id: dataUser.id,
                        user_role: dataUser.role
                    },
                    success: function(response) {
                        renderTable(response.refundOrders, response.totalPages);
                        if (response
                            .totalPages
                        ) {
                            $('#pagination').twbsPagination({
                                totalPages: response.totalPages,
                                visiblePages: 3,
                                startPage: currentPage, // Duy trì trang hiện tại
                                onPageClick: function(event, page) {
                                    currentPage = page;
                                    fetchOrders();
                                }
                            });
                        }


                    },
                    error: function() {
                        alert("Error fetching data from API");
                    },
                    complete: function() {
                        $("#loading-icon")
                            .hide(); // Ẩn icon loading khi API hoàn tất (thành công hoặc thất bại)
                    }
                });
            }

            const debouncedGetOrderRefund = debounce(function() {
                const search = $("#search").val();
                fetchOrders(search);
            }, 500); // Delay 300ms
            $("#search").on('input', debouncedGetOrderRefund)

            fetchOrders();

            Pusher.logToConsole = true;

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channel = pusher.subscribe('order-refund-create-update');
            channel.bind('event-create-order-refund', function(data) {
                fetchOrders()
            });
        })
    </script>
    <script src="{{ asset('js/utility.js') }}"></script>
@endpush
