@extends('client.layouts.master')

@push('css')
    <style>
        .suggestions-list {
            background-color: white;
            max-height: 150px;
            overflow-y: auto;
            border-radius: 4px;
            z-index: 1000;
        }

        .suggestions-list div {
            padding: 10px;
            cursor: pointer;
        }

        .suggestions-list div:hover {
            background-color: #f0f0f0;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .checkbox_animated.is-invalid {
            border: 2px solid red !important;
        }

        .form-control.is-invalid {
            border: 1px solid #dc3545 !important
        }

        .tab-menu .nav-link {
            font-size: 14px;
            font-weight: bold;
        }

        .tab-menu .nav-link.active {
            border-bottom: 2px solid red;
            color: red;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .order-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            font-weight: bold;
        }

        .order-header .badge {
            font-size: 18px;
            padding: 12px 14px;
        }

        .order-body {
            padding: 15px;
        }

        .order-footer {
            padding: 10px 15px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-reorder {
            background-color: #ff5722;
            color: #fff;
        }

        .btn-reorder:hover {
            background-color: #e64a19;
            color: #ccc
        }

        .btn-return {
            border: 1px solid #adadad;
            color: #040404;
        }

        .btn-return:hover {
            background-color: #8d8b8b;
            color: #fff
        }

        .btn-success-return {
            background-color: #0da487;
            color: #fff
        }

        .btn-success-return:hover {
            background-color: #0c8b72;
            color: #fff
        }

        .btn-not-get:hover {
            color: #ffffff !important;
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

        .order-status {
            font-size: 16px;
            color: #28a745;
            font-weight: bold;
        }

        .cancel-order-refund {
            font-size: 16px;
            color: #fff;
            background-color: red;
            padding: .35em .65em;
            font-weight: bold;
            border-radius: .25rem;
        }

        .order-status.complete {
            color: #dc3545;
        }

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
    </style>
@endpush


@section('content')
    @php
        use App\Enums\OrderStatusType;
        use App\Enums\CouponDiscountType;

        $CouponDiscountType_PERCENT = CouponDiscountType::PERCENT;
        $CouponDiscountType_FIX_AMOUNT = CouponDiscountType::FIX_AMOUNT;

    @endphp
    <div class="container-fluid-lg">
        <!-- Tabs -->
        <ul class="nav nav-tabs tab-menu">
            <li class="nav-item tab" data-status="">
                <p class="nav-link active " style="cursor: pointer">Tất cả</p>
            </li>
            <li class="nav-item tab" data-status="{{ OrderStatusType::PENDING }}">
                <p class="nav-link " style="cursor: pointer">Chờ xử lý</p>
            </li>
            <li class="nav-item tab" data-status="{{ OrderStatusType::PROCESSING }}">
                <p class="nav-link " style="cursor: pointer">Đang xử lý </p>
            </li>
            <li class="nav-item tab" data-status="{{ OrderStatusType::SHIPPING }}">
                <p class="nav-link " style="cursor: pointer">Đang giao hàng</p>
            </li>
            {{-- <li class="nav-item tab" data-status="{{ OrderStatusType::DELIVERED }}">
                <p class="nav-link " style="cursor: pointer">Đã giao hàng</p>
            </li> --}}
            <li class="nav-item tab" data-status="{{ OrderStatusType::FAILED_DELIVERY }}">
                <p class="nav-link " style="cursor: pointer">Giao hàng thất bại</p>
            </li>
            <li class="nav-item tab" data-status= "{{ OrderStatusType::COMPLETED }}">
                <p class="nav-link " style="cursor: pointer">Hoàn thành</p>
            </li>
            <li class="nav-item tab" data-status="{{ OrderStatusType::CANCEL }}">
                <p class="nav-link " style="cursor: pointer">Đã hủy</p>
            </li>
            <li class="nav-item tab" data-status="{{ OrderStatusType::RETURN }}">
                <p class="nav-link " style="cursor: pointer">Hoàn hàng</p>
            </li>
        </ul>

        <!-- Search Bar -->
        <div class="mt-3 mb-3">
            <input type="text" class="form-control" id="inputSearchOrder"
                placeholder="Bạn có thể tìm kiếm theo ID đơn hàng hoặc Tên Sản phẩm">
        </div>


        <div id="listCard">



        </div>


        <!-- Order Card 2 -->
        <nav aria-label="Page navigation example" class="mt-3">
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>


    </div>
    <div id="loading-icon-load">
        <div id="loading-icon" style="display: none;">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAF9ElEQVR4nO2dTYwURRTH/5AMkLi7YlwTdlYTPxNFceUgLnjQXS6CCQsJZ4UbBm6IgjEROOBFQPSgcHUTlwMgygWRcFJBXT3AfsANLoIKy86asMmqa17yOum8VHdX9XTPVHe/X1JJp6e6p6re1Pua6mpAURRFURRFURRFUQrKQwD2A/gVwN9c6HgfgO52N65qbAIwDWA+otwFsLHdjaySMP6NEUZQqI4KpQVqatpCGEGZUvWVL/vFgM8C2Amgh8tOPheuszfnNlWa38RgkwAku0QdMvRKTsyIwV5mqLNM1GmoNPKjIQab1JSkV9Qhm6O0SGW9baGyRlUa+bHPYNRJKHUuuzI06s8COAzgSijwpONDAJZn3K/C0s1Bn4vb+6DjdywC8CmAf2LuS58dAVBDgaCO7QBwMfQL+xHAdv4sLRsdAsOhFG0+5yDwb4silDq7m1EdGY0wyC5CmUqYGa7CAM+MecfyMTxnUYIwgvJLk7+ubrYpo+wON/iee1OoqcBmSDU1BmADgE4uJORxUWcOwDPwmB0Ov6634A+HDcLoMtS7H8CEqHsQHnNRNPYbjg16+Tj82Q/whzHRtqGEBGe47mUUKJomQQQ87HEU3RBtIxUVRZfH/UjsGAkhQAXikcoiYZzxWGVdKavK2u5g1LfBHw6Jto2zAZfQuUlR9yN47vaOWgjjJ8+CquUGt3eCZ0MXl00GYZDb+zQ8p4djgihh/NxkYJgXR1IEhjSzCkGN44zv2fOa4eNtns2MMDVOh9gK46zHfSkNNU6HzMUIYo5nhgqjxTblIHtQwQy/zAbc61SJoiiKoiiKoiilZy2AY5z3ChZz0PFRAIPtblyVeBLABYv0ynkAT7S7sWXnZQB/OeS8qO6adje6rDwG4I8UWeHbPKty4XWeikGOh47XoxpcMAz2SQCvALiPy6sAThnqfdeKh2aq9HDMWkOfaT1xFO8Y6g9kPTOSpuY6lJdjhpmRxGlxzedZNui8hUBobWxZmRR9JTWVxIDhb+Hclvj0A1hdoQdkGqKvHRbXdOa5hks2aDW7cyqQNglEVRaaVlm0vCgz1lvYkNdQXo6KvpJrm8TX4prP8n6sLFw+QLkZNPSZXNso3jXUpxglc9axN9Xgcq7kMyNJbZ9m1dTBZdAwM8rugbaNR1OmTiifpUnGnFjjmFz8kz1SJUce59yUTaBMCUmlRQxwOmQ8lGwd43O5GHBFURRFUZTCUgOwGcBwaHnPDB8P82f6bEiLoKdvr1nEF9dS7qeiWLIQwIeO6ZD/ABzga5WMcRVGuJBQlAwZ4l97eJDv8YY0q0LLe1bx84f3DDOFdg1SMqBmsBnXATwXc80KADcMNsV7Q/8UgBOh/02Oi81ofGCzYWbECSMsFLm/I93La2HcjkhF+ySUYdE+UlNpNxr4Ah5zIsYIjsDftVYvOlz7kriW7uUtcslQuNDOos3wAICtAL7iQQiey5jkhQdbACzNca1VS5b4ZE3S+z3SsATAHsutYmkjzN18TRyVEcjxjFVWnXcQco0RLvG1tiqLXFtb+ouksnrZgJuMetwAmagb3EyXciPmO4eb2Pb1kyIZdfAgjLD6muZjV2Es4e2c5CD/DuA9AH2hwK2Pz9001Ked7hZbur3k0ibRVzS3Nyv2GAb3ywRd38HCt1nUFhUYxgnl+aIGhsjAm7prEMYCi2sXGIQyFeF9mVInsxxn9IcWwPWzmpqtaupkq0FNuXpBUn29GVH3QBM2qjLJxVOi42QfXHlf3IMCVhMLeWDlTIkrlUu/XxUDQLrblRccXdMNDn9QVUJNZRW0NRO8yb9wgwVw4+zaVvYv3JkMBNJVoUfuSqmyFE+MumLBFjGYN1O4vbfEPd7QkW8uMJwSAzriEBjKBOcdh7S8EsFug8s5kvB+j86IbHPcNhiKQ3LxkmFwb7F9WBlKbazkc1JNzfMb4kzJRSUF9SbT79c93fy/0PQYXhZjU+jVGY+0u/FlZTGn0OPeYRg24GQzVE21gKWctT0pUhsTHGeQa6velKIoiqIoaBv/A1UYRA8mSNHeAAAAAElFTkSuQmCC"
                alt="spinner-frame-5">
        </div>
    </div>
@endsection



<!-- Return Order Modal End -->
<!--Lấy id khách hàng  -->
@section('modal')
    <div class="modal fade theme-modal view-modal" id="returnOrderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid-lg">
                        <div id="listCard">
                            <div class="order-card">

                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <h4 class="ml-3 d-block" id="order-id"></h4>

                                    <div class="d-flex align-items-center">
                                        <div class="d-flex" style="align-items:center">

                                        </div>
                                        <span class="badge bg-success complete ms-2" id="order-status"
                                            style="font-size: 1.2em; ">

                                        </span>
                                    </div>
                                </div>

                                <div id="listItemOrder">

                                </div>


                                <div class="order-footer">
                                    <div class="d-flex flex-row" id="user_name">

                                    </div>
                                    <div>
                                        <div>
                                            <div>
                                                <span>Tổng tiền hoàn: </span>
                                                <span class="price-new" id="amount_refund"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <input type="text" hidden id="products">
                                </div>
                            </div>

                        </div>


                        <form id="formRefundItem" method="POST" enctype="multipart/form-data" class="flex justify-between">
                            <div class="flex items-start">
                                <div>
                                    <h4 class="mt-3">Thông tin hoàn tiền</h4>
                                    <textarea id="reason" name="reason" class="form-control" placeholder="Lý do hoàn hàng..."></textarea>
                                    <p>Hình ảnh minh chứng:</p>
                                    <input type="file" id="reason_image" name="reason_image"> <br>
                                    <img src="http://127.0.0.1:8000/storage/products/product_2.png" id="reason_image_show"
                                        alt="Product" class="me-3"
                                        style="width: 100px; height: 100px; object-fit: cover; display: none;"><br>
                                    <video id="reason_video_show" controls
                                        style="width: 300px; height: 200px; display: none;"></video><br>
                                    <label for="accountNumber" class="form-label">Số tài khoản</label>
                                    <input type="text" id="bank_account" name="bank_account" class="form-control"
                                        placeholder="Nhập số tài khoản">
                                    <label for="name" class="form-label mt-2">Tên người nhận</label>
                                    <input type="text" id="user_bank_name" name="user_bank_name" class="form-control"
                                        placeholder="Nhập tên người nhận">
                                    <label for="bankName" class="form-label mt-2">Ngân hàng</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control"
                                        placeholder="Nhập tên ngân hàng">
                                    <div id="suggestions" class="suggestions-list"
                                        style="display: none; border: 1px solid #ccc; max-height: 150px; overflow-y: auto; position: absolute; z-index: 1000;">
                                    </div>
                                    <label for="bankName" class="form-label mt-2">Số điện thoại liên hệ</label>
                                    <input type="text" id="phone_number" name="phone_number" class="form-control"
                                        placeholder="Nhập số điện thoại">
                                    <button class="btn btn-success-return mt-3" type="submit"
                                        id="confirmReturnOrder">Hoàn hàng</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Return Order Modal End -->
    <!--Lấy id khách hàng  -->
    <input type="hidden" id="isAuthenticated" value="{{ auth()->check() ? 'true' : 'false' }}">
@endsection

@section('modal2')
    <div class="modal fade theme-modal view-modal" id="showDetailOrder" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid-lg">
                        <div id="listCard">
                            <div class="order-card">

                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <h4 class="ml-3 d-block" id="order-id"></h4>

                                    <div class="d-flex align-items-center">
                                        <div class="d-flex" style="align-items:center">

                                        </div>
                                        <span class="badge bg-success complete ms-2" id="order-status"
                                            style="font-size: 1.2em; ">

                                        </span>
                                    </div>
                                </div>

                                <div id="listItemOrder">

                                </div>


                                <div class="order-footer">
                                    <div class="d-flex flex-row" id="data_discount">
                                        <ul style="display: flex;flex-direction: column;">
                                            <li>{{ __('message.total') }}: <span></span></li>
                                            <li></li>

                                            <li></li>
                                            <li class="d-flex" style="align-items: center">
                                                <span>Voucher: </span>
                                                <p style="margin-bottom: unset;margin-left: 4px"></p>
                                            </li>
                                            <li>{{ __('message.discount') }} <span class="text-danger"></span></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div>
                                            <div>
                                                <span>Tổng tiền: </span>
                                                <span class="price-new" id="amount_refund"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-2">
                                    <input type="text" hidden id="products">
                                </div>
                            </div>

                        </div>


                        <div>
                            <h3>Thông tin người nhận</h3>
                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="fullname">
                                <span>Người nhận:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>
                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="phone_number">
                                <span>Số điện thoại người nhận:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>
                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="address">
                                <span>Địa chỉ:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>

                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="payment">
                                <span>Phương thức thanh toán:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>
                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="is_paid">
                                <span>Tình trạng thanh toán:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>
                            <div style="display: flex;align-items: center;justify-items: center;margin-bottom: 6px; font-size: 16px;"
                                id="note">
                                <span>Ghi chú:</span>
                                <p style="margin-bottom: unset;margin-left: 4px;font-size: 16px;"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Return Order Modal End -->
    <!--Lấy id khách hàng  -->
@endsection

<div class="modal fade theme-modal view-modal" id="showImgBankRefund" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="address-container" class="flex justify-between">
                        <div class="flex items-start">
                            <h4 class="mt-3">Ảnh chuyển khoản</h4>
                            <img src="" alt="Product" class="me-3" id="img"
                                style="width: 100%;margin-top: 12px;">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade theme-modal view-modal" id="reasonModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="address-container" class="flex justify-between">
                        <div class="flex items-start">
                            <div>
                                <h4 class="mt-3">Lý do:</h4>
                                <textarea id="reason" class="form-control" disabled></textarea>
                                <div id="reason_reject_admin"></div>
                                <img src="http://127.0.0.1:8000/storage/products/product_2.png" alt="Product"
                                    class="me-3" id="img-reason"
                                    style="width: 100px; height: 100px; object-fit: cover;margin-top: 12px; display: none;">
                                <video id="reason-video"
                                    style="width: 300px; height: 200px; margin-top: 12px; display: none;" controls>
                                    Your browser does not support the video tag.
                                </video>
                                <div id="div-reason-admin">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalShowFailOrComplate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" id="btn-cancel-modal-Show" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="body-show">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmBank" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" id="btn-cancel-modal-Show" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" id="body-show">

                <!-- Số tài khoản -->
                <div class="mb-3">
                    <p for="bank_account" class="form-p" style="text-align: left">Số tài khoản</p>
                    <input type="text" class="form-control" id="bank_account" name="bank_account" disabled
                        placeholder="Nhập số tài khoản" required>
                </div>
                <!-- Tên tài khoản -->
                <div class="mb-3">
                    <p for="bank_name" class="form-p" style="text-align: left">Tên ngân hàng</p>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" disabled
                        placeholder="Nhập tên ngân hàng" required>
                    <div id="suggestions" class="suggestions-list"
                        style="display: none; border: 1px solid #ccc; max-height: 150px; min-width: 200px; overflow-y: auto; position: absolute; z-index: 1000;">
                    </div>
                </div>
                <!-- Chủ tài khoản -->
                <div class="mb-3">
                    <p for="user_bank_name" class="form-p" style="text-align: left">Chủ tài khoản</p>
                    <input type="text" class="form-control" id="user_bank_name" name="user_bank_name" disabled
                        placeholder="Nhập tên chủ tài khoản" required>
                </div>
                <input type="text" value="" hidden id="idOrder">

                <div class="button-box"
                    style="display: flex;
                    justify-items: center;
                    align-items: center;
                    justify-content: center;">
                    <app-button><button class="btn btn-md  fw-bold"
                            style="background-color: rgb(110, 110, 2); color: #fff;" id="btn_edit_bank"
                            type="submit" fdprocessedid="hbnu3">
                            <div> Sửa </div>
                        </button></app-button>
                    <app-button class="ml-2" style="margin-left: 8px">
                        <button class="btn btn-md btn-theme fw-bold ml-2" id="btn_confim_bank" type="submit"
                            fdprocessedid="qq0uf9">
                            <div> Xác nhận </div>
                        </button></app-button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade theme-modal question-modal" id="writereview" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body pt-0">
                <form class="product-review-form" id="reviewForm" action="{{ route('reviewsSp.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="order_id" id="review_order_id" value="">
                    <div class="product-wrapper">
                        <div class="product-image">

                            <img class="img-fluid" alt="" src="" width="100px">
                        </div>
                        <div class="product-content">

                            <h5 class="name"></h5>
                            <div class="product-review-rating">
                                <div class="product-rating">
                                    {{-- <h6 class="price-number">{{ number_format($detail->price) }} VND</h6> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="review-box">
                        <div class="product-review-rating">
                            <label>Rating</label>
                            <div class="product-rating">
                                <ul class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i data-feather="star" class="star"
                                                data-value="{{ $i }}"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <input type="hidden" name="rating" id="ratingValue">
                            </div>
                        </div>
                        <div id="rating-error" class="error-message text-danger"></div>
                    </div>
                    <div class="review-box">
                        <label for="content" class="form-label">Nội dung đánh giá *</label>
                        <textarea name="review_text" id="content" rows="3" class="form-control"
                            placeholder="Nhập nội dung đánh giá"></textarea>
                        <div id="review_text-error" class="error-message text-danger"></div>
                    </div>
                    <div class="review-box">
                        <label for="images" class="form-label">Hình ảnh (tối đa 5)</label>
                        <input type="file" name="images[]" id="images" class="form-control" accept="image/*"
                            multiple>
                        <span class="text-danger error-message" id="images-error"></span>
                    </div>
                    <div class="review-box">
                        <label for="videos" class="form-label">Video (tối đa 1)</label>
                        <input type="file" name="videos" id="videos" class="form-control" accept="video/*">
                        <span class="text-danger error-message" id="videos-error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-theme-outline fw-bold"
                    data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-md fw-bold text-light theme-bg-color" id="submitReview">Gửi
                    đánh giá</button>
            </div>
        </div>
    </div>
</div>



@push('js_library')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endpush

@push('js')
    <!-- Thêm SweetAlert2 CDN -->
    <script>
        $(document).ready(function() {
            const bankNames = [
                "Vietcombank", // Ngân hàng Thương mại Cổ phần Ngoại thương Việt Nam
                "BIDV", // Ngân hàng Đầu tư và Phát triển Việt Nam
                "VietinBank", // Ngân hàng Công Thương Việt Nam
                "Techcombank", // Ngân hàng Kỹ Thương Việt Nam
                "ACB", // Ngân hàng Á Châu
                "Sacombank", // Ngân hàng Sài Gòn Thương Tín
                "VPBank", // Ngân hàng Việt Nam Thịnh Vượng
                "Agribank", // Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam
                "MBBank", // Ngân hàng Quân Đội
                "SHB", // Ngân hàng Sài Gòn - Hà Nội
                "OCB", // Ngân hàng Phương Đông
                "HDBank", // Ngân hàng Phát triển TP.HCM
                "TPBank", // Ngân hàng Tiên Phong
                "LienVietPostBank", // Ngân hàng Bưu điện Liên Việt
                "Nam A Bank", // Ngân hàng Nam Á
                "Eximbank", // Ngân hàng Xuất Nhập Khẩu Việt Nam
                "Saigonbank" // Ngân hàng Sài Gòn
            ];
            let CouponDiscountType_FIX_AMOUNT = <?php echo json_encode($CouponDiscountType_FIX_AMOUNT); ?>;
            let CouponDiscountType_PERCENT = <?php echo json_encode($CouponDiscountType_PERCENT); ?>;
            const dataUser = <?php echo json_encode($user); ?>;
            let activeTab = null;
            let currentPage = 1;
            const itemsPerPage = 5;

            function getStatusInVietnamese(status) {
                const statusMap = {
                    'pending': 'Đang chờ',
                    'receiving': 'Chờ vận chuyển',
                    'completed': 'Hoàn hàng thành công',
                    'rejected': 'Bị từ chối',
                    'failed': 'Thất bại',
                    'cancel': 'Hủy'
                };
                return statusMap[status] || status;
            }

            function fetchOrders(search = null) {

                $("#loading-icon").show();
                // Gọi API
                $.ajax({
                    url: '{{ route('api.orders.getOrdersByUser') }}',
                    method: "POST",
                    data: {
                        order_status_id: activeTab,
                        search: search,
                        user_id: dataUser.id,
                        page: currentPage,
                        limit: itemsPerPage,
                    },
                    success: function(response) {
                        renderTable(response.orders, response.totalPages);



                        if (response
                            .totalPages
                        ) { // giả sử response có thuộc tính totalRecords chứa tổng số bản ghi
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


            let changedOrderRefundIds = [];
            let debounceTimerRefund;

            function handleStatusChangeRefund(orderId) {

                if (!changedOrderRefundIds.includes(orderId)) {
                    changedOrderRefundIds.push(orderId);
                }


                clearTimeout(debounceTimerRefund);
                debounceTimerRefund = setTimeout(() => {

                    fetchOrdersRefund();
                    changedOrderRefundIds = [];
                }, 2000);
            }

            function rederOrderRefunds(orders, totalPages) {
                const listCard = document.getElementById("listCard");
                listCard.innerHTML = "";

                if (orders.length === 0) {
                    listCard.innerHTML = `
            <div class="d-flex justify-center items-center" style="justify-content: center;">
                <h4>Không có đơn hàng</h4>
            </div>
        `;
                    return;
                }

                orders.forEach(order => {
                    let statusClass;

                    Pusher.logToConsole = true;

                    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                    });

                    var channel = pusher.subscribe('order-refund-status.' + order.id);
                    channel.bind('event-change-status-refund', function(data) {
                        handleStatusChangeRefund(data.orderId)
                    });

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
                            statusClass = 'bg-secondary'; // Màu khác nếu cần
                    }
                    let orderHTML = `
            <div class="order-card">
                    
                    <div class="d-flex justify-content-between align-items-center p-2">
                    <h4 class="ml-3 d-block">ID: ${order.order.code}</h4>

                    <div class="d-flex align-items-center">
                        <div class="d-flex" style="align-items:center">
${order.status == "receiving" && order.bank_account_status == "sent" ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="show-error confirm_bank" style="cursor: pointer; color: red" data-idorder="${order.id}">Xác nhận tài khoản ngân hàng</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        `:""}

                            ${order.status == "pending" ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="cancel-order-refund" data-idorder="${order.id}" style="cursor: pointer;" >Hủy đơn hàng hoàn</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ` :""}
                            ${order.status == "failed" ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="show-fail" style="cursor: pointer;" data-failreason="${order.fail_reason}" data-imgfailorcompleted="${order.img_fail_or_completed}">Xem lý do thất bại</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ` :""}
                            ${order.status == "completed" ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <h5 class="show-complate" style="cursor: pointer;" data-idorder="${order.id}" data-imgfailorcompleted="${order.img_fail_or_completed}" data-checkmoney="${order.is_send_money}">Xem minh chứng</h5>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ` :""}
                            <span class="badge bg-warning complete ms-2 btn-show-reason"  id="" data-reason="${order.reason}" data-reasonimg="${order.reason_image}" data-adminreason="${order.admin_reason}"  style="font-size: 1.2em;cursor: pointer;background-color: rgb(7 255 16) !important;">
                                Lý do
                            </span>
                        </div>
                        <span class="badge ${statusClass} ms-2" style="font-size: 1.2em; ">
                            ${getStatusInVietnamese(order.status)}
                        </span>



                    </div>
                </div>
                    `

                    orderHTML += order.refund_items.map(item => {
                        const imageUrl =
                            `{{ Storage::url('${item.product.thumbnail}') }}`;
                        return `
                        
                        <div class="d-flex flex-row"
                    style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                    <div class="order-body d-flex">
                        <img src="${imageUrl}" alt="Product" class="me-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="d-flex flex-row" style="justify-content: space-between">
                            <div>
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

                    orderHTML += `
                    
                    <div class="order-footer">
                    <div class="">
                        <p style="margin: 0">Tên khách hàng: ${order.user.fullname}</p>
                        <p style="margin: 0">STK: ${order.bank_account}</p>
                        <p style="margin: 0">Tên người nhận: ${order.user_bank_name}</p>
                        <p style="margin: 0">Ngân hàng: ${order.bank_name}</p>
                    </div>
                    <div>
                        <div>
                            <div>
                                <span>Tổng tiền: </span>
                                <span class="price-new">${formatCurrency(order.total_amount)}đ</span>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                    `
                    listCard.innerHTML += orderHTML;


                })
                $(".confirm_bank").on('click', async function() {
                    const idOrder = $(this).data("idorder");

                    await $.ajax({
                        url: `http://127.0.0.1:8000/api/refund-orders/${idOrder}`,
                        type: 'GET',

                        success: function(response) {

                            if (response.status == 200) {
                                const dataOrderRefund = response.dataOrderRefund

                                $("#modalConfirmBank #bank_account").val(dataOrderRefund
                                    .bank_account)
                                $("#modalConfirmBank #idOrder").val(idOrder)
                                $("#modalConfirmBank #bank_name").val(dataOrderRefund
                                    .bank_name)
                                $("#modalConfirmBank #user_bank_name").val(dataOrderRefund
                                    .user_bank_name)

                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });

                    $("#modalConfirmBank").modal("show");

                    $('#modalConfirmBank #btn_edit_bank').click(function() {
                        // Toggle disabled state for inputs
                        $('#modalConfirmBank #bank_account,#modalConfirmBank #bank_name,#modalConfirmBank #user_bank_name')
                            .each(function() {
                                $(this).prop('disabled', !$(this).prop('disabled'));
                            });
                    });

                    const input = $('#modalConfirmBank #bank_name');
                    const suggestionsList = $('#modalConfirmBank #suggestions');
                    input.on('input', function() {
                        const query = $(this).val().toLowerCase();
                        suggestionsList.empty(); //
                        suggestionsList.hide();

                        if (query) {
                            const filteredBanks = bankNames.filter(bank => bank.toLowerCase()
                                .includes(query));


                            filteredBanks.forEach(bank => {
                                suggestionsList.append($('<div>').text(bank).click(
                                    function() {
                                        input.val(
                                            bank
                                        );
                                        suggestionsList.empty()
                                            .hide();
                                    }));
                            });

                            if (filteredBanks.length > 0) {
                                suggestionsList.show();
                            }
                        }
                    });

                    input.on('blur', function() {
                        const enteredBankName = $(this).val().toLowerCase();
                        if (enteredBankName !== "" && !bankNames.some(bank => bank.toLowerCase()
                                .includes(enteredBankName))) {
                            alert(
                                'Tên ngân hàng không hợp lệ. Vui lòng chọn từ danh sách gợi ý.'
                            );
                            $(this).val('');
                        }
                    });

                    $(document).on('click', function(event) {
                        if (!$(event.target).closest('#modalConfirmBank #bank_name').length) {
                            suggestionsList.hide(); // Ẩn danh sách gợi ý
                        }
                    });
                })
                $('#modalConfirmBank #btn_confim_bank').off('click').on('click', function() {
                    const bank_account = $('#modalConfirmBank #bank_account').val();
                    const bank_name = $('#modalConfirmBank #bank_name').val();
                    const user_bank_name = $('#modalConfirmBank #user_bank_name').val();
                    const idOrder = $('#modalConfirmBank #idOrder').val();

                    $.ajax({
                        url: '{{ route('api.refund_orders.confirmBank') }}',
                        type: 'POST',
                        data: {
                            bank_account: bank_account,
                            bank_name: bank_name,
                            user_bank_name: user_bank_name,
                            idOrder: idOrder
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
                                fetchOrdersRefund()
                                $('#modalConfirmBank  .error-message').remove();
                                $('#modalConfirmBank  .is-invalid').removeClass('is-invalid');

                                $("#modalConfirmBank").modal("hide");
                            } else {
                                $('.error-message').remove();
                                $('.is-invalid').removeClass('is-invalid');
                                if (response.errors) {
                                    $.each(response.errors, function(field, messages) {
                                        let input = $(
                                            `#modalConfirmBank #${field}`);
                                        if (input.length > 0) {
                                            let errorDiv = $(
                                                '<div class="invalid-feedback error-message d-block">'
                                            );
                                            $.each(messages, function(index,
                                                message) {
                                                errorDiv.append('<span>' +
                                                    message +
                                                    '</span><br>');
                                            });
                                            input.addClass('is-invalid');
                                            input.after(errorDiv);
                                        }
                                    });
                                } else {
                                    alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                                    console.error('Lỗi không xác định:', response);
                                }
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });

                })

                $("#modalConfirmBank #btn-cancel-modal-Show").on("click", function(event) {
                    event.preventDefault();
                    $('#modalConfirmBank  .error-message').remove();
                    $('#modalConfirmBank  .is-invalid').removeClass('is-invalid');

                    $("#modalConfirmBank").modal("hide");
                });


                $(".btn-show-reason").on('click', function() {
                    $("#div-reason-admin").empty();
                    const reason = $(this).data("reason");
                    const reasonimg = $(this).data("reasonimg");
                    const adminreason = $(this).data("adminreason");
                    const imageUrl =
                        `{{ Storage::url('${reasonimg}') }}`;

                    // Kiểm tra xem đường dẫn có phải là video không
                    const isVideo = imageUrl.match(/\.(mp4|mov|avi|wmv|mkv)$/i);

                    if (isVideo) {
                        //
                        $("#reasonModal #img-reason").hide();
                        const videoElement = $("#reasonModal #reason-video").get(0);
                        videoElement.src = imageUrl;
                        videoElement.load();
                        $("#reasonModal #reason-video").show();
                    } else {

                        $("#reasonModal #reason-video").hide();
                        $("#reasonModal #img-reason").attr("src", imageUrl).show();
                    }

                    $("#reasonModal #reason").val(reason);
                    if (adminreason) {
                        $("#div-reason-admin").append(`
                                    <h4 class="mt-3">Lý do từ chối:</h4>
                                    <textarea id="admin-reason" class="form-control" disabled>${adminreason}</textarea>
                            `)
                    }




                    $("#reasonModal").modal('show');
                })

                $("#reasonModal .btn-close").on('click', function() {
                    const videoElement = $('#reasonModal #reason-video').get(0);
                    if (videoElement) {
                        videoElement.pause();
                        videoElement.currentTime = 0;
                    }
                })

                $(".cancel-order-refund").on('click', function() {
                    const idOrder = $(this).data("idorder");
                    if (!confirm('Bạn có chắc chắn hủy hoàn hàng không?')) {
                        return;
                    }

                    $.ajax({
                        url: '{{ route('api.refund_orders.changeStatusCancelOrder') }}',
                        type: 'POST',
                        data: {
                            idOrder: idOrder
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
                                fetchOrdersRefund();

                            }
                        },
                        error: function(error) {
                            console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });

                })

                $(".show-complate, .show-fail").on('click', function() {

                    const img_fail_or_completed = $(this).data("imgfailorcompleted")
                    const fail_reason = $(this).data("failreason")
                    const idOrder = $(this).data("idorder")
                    const checkmoney = $(this).data("checkmoney")
                    let checkmoneyText = "";
                    if (checkmoney == null) {
                        checkmoneyText = "Đã chuyển tiền";
                    } else if (checkmoney == 0) {
                        checkmoneyText = "Chưa nhận tiền";
                    } else if (checkmoney == 1) {
                        checkmoneyText = "Đã nhận tiền";
                    } else {
                        checkmoneyText = ""; // Xử lý trường hợp khác
                    }
                    $("#modalShowFailOrComplate #body-show").empty()

                    if (fail_reason) {
                        const imageUrl =
                            `{{ Storage::url('${img_fail_or_completed}') }}`;
                        $("#modalShowFailOrComplate #body-show").append(`
                        <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Nhập lý do thất bại" name="fail_reason" id="fail_reason" disable style="height: 100px">${fail_reason}</textarea>
                    <label for="fail_reason">Lý do thất bại</label>
                </div>
                    <div class="mb-3">
                        <div id="" class="mt-3">
                            <img src="${imageUrl}" alt="Preview Image" class="img-thumbnail" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                        `)
                    } else {
                        const imageUrl =
                            `{{ Storage::url('${img_fail_or_completed}') }}`;
                        $("#modalShowFailOrComplate #body-show").append(`
                    <div class="mb-3">
                        <h3 style="color:red">${checkmoneyText}</h3>
                        <div id="" class="mt-3">
                            <img src="${imageUrl}" alt="Preview Image" class="img-thumbnail" style="max-width: 100%; height: auto;">
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <app-button><button class="btn btn-md  fw-bold"
                                                style="background-color: red; color: #fff;" data-idOrder="${idOrder}"
                                                id="not_received_btn" type="submit" fdprocessedid="hbnu3">
                                                <div> Chưa nhận</div>
                                            </button></app-button>
                                        <app-button class="ml-2">
                                            <button class="btn btn-md btn-theme fw-bold" style="margin-left: 24px" data-idOrder="${idOrder}" id="received_btn"
                                                type="submit" fdprocessedid="qq0uf9">
                                                <div> Đã nhận </div>
                                            </button></app-button>
                            </div>

                    </div>
                        `)
                    }

                    $("#modalShowFailOrComplate").modal('show');
                    $("#modalShowFailOrComplate #received_btn").on('click', function() {
                        const idOrder = $(this).data("idorder")
                        if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                            return;
                        }
                        $.ajax({
                            url: '{{ route('api.refund_orders.userCheckReceivedBank') }}',
                            type: 'POST',
                            data: {
                                idOrder: idOrder,
                                statusCheckReceived: 1
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
                                    fetchOrdersRefund()
                                    $("#modalShowFailOrComplate").modal('hide');
                                }
                            },
                            error: function(error) {
                                console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });

                    })

                    $("#modalShowFailOrComplate #not_received_btn").on('click', function() {
                        const idOrder = $(this).data("idorder")
                        if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                            return;
                        }
                        $.ajax({
                            url: '{{ route('api.refund_orders.userCheckReceivedBank') }}',
                            type: 'POST',
                            data: {
                                idOrder: idOrder,
                                statusCheckReceived: 0
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

                                    fetchOrdersRefund()
                                    $("#modalShowFailOrComplate").modal('hide');
                                }
                            },
                            error: function(error) {
                                console.error("Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });

                    })
                })



                $("#modalShowFailOrComplate #btn-cancel-modal-Show").on("click", function(event) {
                    event.preventDefault(); // Ngăn hành động mặc định
                    $("#modalShowFailOrComplate").modal("hide"); // Chỉ đóng imageModal
                });


            }

            function fetchOrdersRefund(search = null) {

                $("#loading-icon").show();
                // Gọi API
                $.ajax({
                    url: '{{ route('api.refund_orders.getOrdersRefundByUser') }}',
                    method: "POST",
                    data: {
                        search: search,
                        user_id: dataUser.id,
                        page: currentPage,
                        limit: itemsPerPage,
                    },
                    success: function(response) {



                        rederOrderRefunds(response.refundOrders, response.totalPages);



                        if (response
                            .totalPages
                        ) { // giả sử response có thuộc tính totalRecords chứa tổng số bản ghi
                            $('#pagination').twbsPagination({
                                totalPages: response.totalPages,
                                visiblePages: 3,
                                startPage: currentPage, // Duy trì trang hiện tại
                                onPageClick: function(event, page) {
                                    currentPage = page;
                                    fetchOrdersRefund();
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

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), delay);
                }
            }

            const debouncedGetOrderList = debounce(function() {
                const search = $("#inputSearchOrder").val();
                if (activeTab == 8) {
                    fetchOrdersRefund(search);
                } else {

                    fetchOrders(search);
                }
            }, 400); // Delay 300ms

            $("#inputSearchOrder").on('input', debouncedGetOrderList)


            $(".tab").click(function() {
                $(".tab .nav-link").removeClass("active");
                $(this).find(".nav-link").addClass("active");

                activeTab = $(this).data("status");

                currentPage = 1;
                $('#pagination').twbsPagination('destroy');
                if (activeTab == 8) {
                    fetchOrdersRefund();
                } else {
                    fetchOrders();
                }
            });
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


            async function callApiGetItemInOrder(orderId) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `http://127.0.0.1:8000/api/orders/${orderId}`,
                        method: "get",
                        success: function(response) {
                            // Giải quyết promise với danh sách item order
                            resolve(response.listItemOrder);
                        },
                        error: function() {
                            alert("Error fetching data from API");
                            // Từ chối promise nếu có lỗi
                            reject("Error fetching data from API");
                        },
                    });
                });
            }

            let dataRefundProducts = {
                products: [],
                order_id: '',
                user_id: dataUser.id,
                total_amount: ''


            };

            async function fillOrderDetail(orderId) {
                const orderById = await callApiGetItemInOrder(orderId);
                $('#showDetailOrder #order-id').text(`ID: ${orderById[0].order.code}`);
                $('#showDetailOrder #order-status').text(orderById[0].order.order_statuses[0].name);

                $('#showDetailOrder #listItemOrder').empty();
                let amountAllItems = 0;
                orderById.forEach(dataProduct => {

                    if (!dataProduct.product_variant_id) {
                        console.log("dataProduct.name_variant", dataProduct.name_variant)
                        console.log("amountAllItems", amountAllItems)
                        amountAllItems += parseFloat(dataProduct.price) * parseInt(dataProduct
                            .quantity);
                    } else {
                        amountAllItems += parseFloat(dataProduct.price_variant) * parseInt(dataProduct)
                            .quantity_variant;
                        console.log("dataProduct.name_variant2", dataProduct.name_variant)
                    }
                })


                $("#showDetailOrder #fullname p").text(orderById[0].order.fullname)
                $("#showDetailOrder #phone_number p").text(orderById[0].order.phone_number)
                $("#showDetailOrder #address p").text(orderById[0].order.address)
                $("#showDetailOrder #payment p").text(orderById[0].order.payment.name)
                $("#showDetailOrder #is_paid p").text(orderById[0].order.is_paid == 0 ? "Chưa thanh toán" :
                    "Đã thanh toán")
                if (!orderById[0].order.note) {

                    $("#showDetailOrder #note").hide();
                } else {
                    $("#showDetailOrder #note").show();

                    $("#showDetailOrder #is_paid p").text(orderById[0].order.is_paid == 0 ? "Chưa thanh toán" :
                        "Đã thanh toán")

                }
                const totalList = $("#data_discount ul");
                totalList.find("li:nth-child(1) span").text(
                    `${formatCurrency(amountAllItems)}(VND)`
                );

                if (orderById[0].order.coupon_code) {
                    $("#data_discount ul").show();
                    if (orderById[0].order.coupon_discount_type == CouponDiscountType_PERCENT) {
                        totalList.find("li:nth-child(4) p").text(
                            `${orderById[0].order.coupon_code}:  -${parseFloat(orderById[0].order.coupon_discount_value)}%(Tối đa: ${formatCurrency(orderById[0].order.max_discount_value)}(VND))`
                        );
                        if (parseFloat(amountAllItems * orderById[0].order.coupon_discount_value) /
                            100 > parseFloat(orderById[0].order.coupon.restriction.max_discount_value)) {
                            totalList.find("li:nth-child(5) span").text(
                                `-${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(orderById[0].order.coupon.restriction.max_discount_value)):0}(VND)`
                            );
                            $('#showDetailOrder #amount_refund').text(
                                `${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(orderById[0].order.coupon.restriction.max_discount_value)):formatCurrency(parseFloat(amountAllItems))}(VND)`
                            );

                        } else {
                            totalList.find("li:nth-child(5) span").text(
                                `-${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems*orderById[0].order.coupon_discount_value)/100):0}(VND)`
                            );
                            $('#showDetailOrder #amount_refund').text(
                                `${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(amountAllItems*orderById[0].order.coupon_discount_value)/100):formatCurrency(parseFloat(amountAllItems))}(VND)`
                            );

                        }

                    } else if (orderById[0].order.coupon_discount_type ==
                        CouponDiscountType_FIX_AMOUNT) {
                        totalList.find("li:nth-child(4) p").text(
                            ` ${orderById[0].order.coupon_code}: -${formatCurrency(orderById[0].order.coupon_discount_value)}(VND) `
                        );
                        totalList.find("li:nth-child(5) span").text(
                            `-${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(orderById[0].order.coupon_discount_value)):0}(VND)`
                        );
                        $('#showDetailOrder #amount_refund').text(
                            `${orderById[0].order.coupon_discount_value?formatCurrency(parseFloat(amountAllItems) - parseFloat(orderById[0].order.coupon_discount_value)):formatCurrency(parseFloat(amountAllItems))}(VND)`
                        );

                    } else {
                        $('#showDetailOrder #amount_refund').text(
                            `${formatCurrency(amountAllItems)}(VND)`
                        );
                    }


                } else {
                    $("#data_discount ul").hide();
                    $('#showDetailOrder #amount_refund').text(
                        `${formatCurrency(amountAllItems)}(VND)`
                    );
                }

                orderById.forEach((order) => {

                    const imageUrl = `{{ Storage::url('${order.product.thumbnail}') }}`;
                    parseInt(order.quantity); // Số lượng tối đa
                    $('#showDetailOrder #listItemOrder').append(
                        `
    <div class="d-flex flex-row order-body-div"
                style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                <div class="order-body d-flex">
                    <img src="${imageUrl}" alt="Product"
                        class="me-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="d-flex flex-row" style="justify-content: space-between">
                        <div>
                            <p class="mb-1">${order.name}</p>
                            <p class="text-muted mb-1" style="font-size: 14px;">
                                ${order.name_variant}
                            </p>
                            <div>
                                <span>x${order.product_variant_id?order.quantity_variant:order.quantity}</span>
                            </div>
                            <div style="margin-right: 15px">
                                <span class="price-new">
                                    ${order.product_variant_id?`${formatCurrency(order.price_variant)}`:`${formatCurrency(order.price)}`}₫
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row" style="margin-right: 15px">
                    <span>Thành tiền:</span>
                    <p class="price-new total-price-item">${order.product_variant_id?`${formatCurrency(parseFloat(order.price_variant)*parseInt(order.quantity_variant))}`:`${formatCurrency(parseFloat(order.price)*parseInt(order.quantity))}`}₫</p>
                </div>
            </div>
    
    `
                    )
                })
            }


            async function getItemProductByOrder(orderId) {

                const orderById = await callApiGetItemInOrder(orderId);
                $('#returnOrderModal #reason_image_show').attr('src', ""),
                    $('#returnOrderModal #order-id').text(`ID: ${orderById[0].order.code}`);
                $('#returnOrderModal #order-status').text(orderById[0].order.order_statuses[0].name);
                $('#returnOrderModal #user_name').text(`Khách hàng: ${orderById[0].order.fullname}`);

                $('#returnOrderModal #listItemOrder').empty();


                function updateAmountRefund() {
                    let total = 0;


                    $('#returnOrderModal .item-checkbox:checked').each(function() {
                        const productId = $(this).data('productid');
                        const productVariantId = $(this).data('productvariantid');
                        const inputElement = $(this).closest('.order-body').find('.quantity-input');
                        const quantity = parseInt(inputElement.val()); // Lấy giá trị số lượng
                        const pricePerUnit = parseFloat($(this).data('price')); // Giá trên mỗi đơn vị
                        const price = pricePerUnit * quantity; // Tính giá tổng

                        const productExists = dataRefundProducts.products.some(product => product
                            .productId === productId);

                        if (!productExists) {
                            dataRefundProducts.products.push({
                                productId: productId,
                                productVariantId: productVariantId,
                                count: quantity,
                                price: price
                            });
                        } else {
                            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
                            dataRefundProducts.products = dataRefundProducts.products.map(product => {
                                if (product.productId === productId) {
                                    product.count = quantity;
                                }
                                return product;
                            });
                        }

                        total += price;

                    });
                    dataRefundProducts.total_amount = total;

                    $("#returnOrderModal #amount_refund").text(`${formatCurrency(total)}₫`);

                    $('#returnOrderModal .item-checkbox:not(:checked)').each(function() {
                        const productId = $(this).data('productid');

                        dataRefundProducts.products = dataRefundProducts.products.filter(product =>
                            product.productId !== productId);
                    });

                }


                orderById.forEach((order) => {

                    const imageUrl = `{{ Storage::url('${order.product.thumbnail}') }}`;
                    const maxQuantity = order.product_variant_id ? parseInt(order.quantity_variant) :
                        parseInt(order.quantity); // Số lượng tối đa
                    $('#listItemOrder').append(
                        `
                        <div class="d-flex flex-row order-body-div"
                                    style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                                    <div class="order-body d-flex">
                                        <input type="checkbox" class="item-checkbox" data-productid="${order.product_id}" data-productvariantid="${order.product_variant_id}" data-price="${order.product_variant_id ? parseFloat(order.price_variant) : parseFloat(order.price)}">
                                        <img src="${imageUrl}" alt="Product"
                                            class="me-3" style="width: 100px; height: 100px; object-fit: cover;">
                                        <div class="d-flex flex-row" style="justify-content: space-between">
                                            <div>
                                                <p class="mb-1">${order.name}</p>
                                                <p class="text-muted mb-1" style="font-size: 14px;">
                                                    ${order.name_variant}
                                                </p>
                                                <div>
                        <input type="number" class="quantity-input" min="1" max="${maxQuantity}" value="${maxQuantity}"
                            style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
                    </div>
                                                <div style="margin-right: 15px">
                                                    <span class="price-old"></span>
                                                    <span class="price-new ms-2">
                                                        ${order.product_variant_id?`${formatCurrency(order.price_variant)}`:`${formatCurrency(order.price)}`}₫
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row" style="margin-right: 15px">
                                        <span>Thành tiền:</span>
                                        <p class="price-new total-price-item">${order.product_variant_id?`${formatCurrency(parseFloat(order.price_variant)*parseInt(order.quantity_variant))}`:`${formatCurrency(parseFloat(order.price)*parseInt(order.quantity))}`}₫</p>
                                    </div>
                                </div>
                        
                        `
                    )
                })

                $("#returnOrderModal #amount_refund").text(`${formatCurrency(0)}đ`)

                $('#returnOrderModal').on('change', '.item-checkbox, .quantity-input', function() {
                    const checkbox = $(this).closest('.order-body').find('.item-checkbox');
                    const inputElement = $(this).closest('.order-body').find('.quantity-input');
                    const maxQuantity = parseInt(inputElement.attr('max'));
                    const quantity = parseInt(inputElement.val());
                    const productId = checkbox.data('productid');
                    const productVariantId = checkbox.data('productvariantid');
                    const pricePerUnit = parseFloat(checkbox.data('price'));
                    const totalPrice = pricePerUnit * quantity;
                    // Kiểm tra số lượng hợp lệ
                    if (quantity > maxQuantity) {
                        inputElement.val(maxQuantity); // Nếu vượt quá, đặt về giá trị tối đa
                    } else if (quantity < 1 || isNaN(quantity)) {
                        inputElement.val(1); // Nếu nhỏ hơn 1, đặt về giá trị tối thiểu
                    }

                    $(this).closest('.order-body-div').find('.total-price-item').text(
                        `${formatCurrency(totalPrice)}₫`);

                    if (checkbox.is(':checked')) {
                        // Nếu checkbox đã được chọn, cập nhật thông tin trong dataRefundProducts
                        const productExists = dataRefundProducts.products.some(product => product
                            .productId === productId);

                        if (!productExists) {
                            // Nếu sản phẩm chưa tồn tại, thêm vào danh sách
                            dataRefundProducts.products.push({
                                productId: productId,
                                productVariantId: productVariantId,
                                count: quantity,
                                price: totalPrice
                            });
                        } else {
                            // Nếu sản phẩm đã tồn tại, cập nhật số lượng và giá tiền
                            dataRefundProducts.products = dataRefundProducts.products.map(product => {
                                if (product.productId === productId) {
                                    product.count = quantity; // Cập nhật số lượng
                                    product.price = totalPrice; // Cập nhật giá tiền
                                }
                                return product;
                            });
                        }
                    } else {
                        // Nếu checkbox bị bỏ chọn, xóa sản phẩm khỏi danh sách
                        dataRefundProducts.products = dataRefundProducts.products.filter(product =>
                            product.productId !== productId);
                    }

                    // Cập nhật tổng tiền hoàn trả
                    updateAmountRefund();
                });

                const input = $('#returnOrderModal #bank_name');
                const suggestionsList = $('#returnOrderModal #suggestions');

                input.on('input', function() {
                    const query = $(this).val().toLowerCase();
                    suggestionsList.empty(); // Xóa các gợi ý cũ
                    suggestionsList.hide(); // Ẩn danh sách gợi ý

                    if (query) {
                        const filteredBanks = bankNames.filter(bank => bank.toLowerCase().includes(
                            query));

                        // Hiển thị gợi ý
                        filteredBanks.forEach(bank => {
                            suggestionsList.append($('<div>').text(bank).click(function() {
                                input.val(bank); // Điền tên ngân hàng vào ô input
                                suggestionsList.empty().hide(); // Xóa gợi ý
                            }));
                        });

                        if (filteredBanks.length > 0) {
                            suggestionsList.show(); // Hiển thị danh sách gợi ý
                        }
                    }
                });

                input.on('blur', function() {
                    const enteredBankName = $(this).val().toLowerCase();
                    if (enteredBankName !== "" && !bankNames.some(bank => bank.toLowerCase().includes(
                            enteredBankName))) {
                        alert('Tên ngân hàng không hợp lệ. Vui lòng chọn từ danh sách gợi ý.');
                        $(this).val('');
                    }
                });

                $(document).on('click', function(event) {
                    if (!$(event.target).closest('#returnOrderModal #bank_name').length) {
                        suggestionsList.hide(); // Ẩn danh sách gợi ý
                    }
                });
            }


            function renderTable(orders, totalPages) {
                const listCard = document.getElementById("listCard");
                listCard.innerHTML = "";

                if (orders.length === 0) {
                    listCard.innerHTML = `
            <div class="d-flex justify-center items-center" style="justify-content: center;">
                <h4>Không có đơn hàng</h4>
            </div>
        `;
                    return;
                }

                // Duyệt qua các đơn hàng và tạo HTML
                orders.forEach(order => {


                    let discountValueOrder = 0;
                    let amountAllItems = 0;

                    Pusher.logToConsole = true;

                    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',


                    });

                    var channel = pusher.subscribe('order-status.' + order.id);
                    channel.bind('event-change-status', function(data) {
                        handleStatusChange(data.orderId)
                    });



                    let orderHTML = `
            <div class="order-card">

                <div class="d-flex justify-content-between align-items-center p-2">
    <h4 class="ml-3 d-block">ID: ${order.code}</h4>

    <div class="d-flex align-items-center">
        <div class="d-flex" style="align-items:center">
             
            
            ${order.is_refund == 1? "<p  class='' style='color:red; margin:unset'>Đã tạo đơn hàng hoàn</p>" : ""}
            ${order.is_refund_cancel == 0? "<p  class='' style='color:red; margin:unset'>Đang chờ hoàn tiền</p>" : ""}
            ${order.is_refund_cancel == 1? "<p  class='' style='color:red; margin:unset'>Đã hoàn tiền</p>" : ""}
            ${order.is_refund_cancel == 1&&order.check_refund_cancel==0? "<p  class='' style='color:red; margin:unset'>(Chưa nhận tiền)</p>" : ""}
            ${order.is_refund_cancel == 1&&order.check_refund_cancel==1? "<p  class='' style='color:red; margin:unset'>(Đã nhận tiền)</p>" : ""}
            ${order.img_send_refund_money ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <span class="badge bg-warning complete ms-2 btn-show-img-money" id="" data-orderid="${order.id}" data-img="${order.img_send_refund_money}" style="font-size: 1.2em;cursor: pointer;background-color: rgb(7 255 16) !important;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        Ảnh chuyển khoản
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    `:""}
            </div>

           
        <span class="badge bg-success complete ms-2"  style='font-size: 1.2em; ${order.order_statuses[0].id == 6?'background-color: red !important; color: #fff':''}'>
            ${order.order_statuses[0].name}
        </span>
        
        ${order.order_statuses[0].id == 5 ? "<span class='order-status ms-2'>Đơn hàng đã được giao thành công</span>" : ""}
        ${order.order_statuses[0].id == 6 ? "<span class='order-status ms-2' style='color: red'>Đơn hàng đã được hủy</span>" : ""}
        <span class='ms-2 order-detail' style="cursor: pointer;"  data-orderid="${order.id}" >Chi tiết đơn hàng</span>
    </div>
</div>

        `;


                    const updatedAt = new Date(order.order_statuses[0].pivot.updated_at);
                    const now = new Date();
                    const diffTime = Math.abs(now - updatedAt);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    const showReviewButton = (order.order_statuses[0].id === 5 && diffDays <= 7);

                    const showRefundButton = (order.order_statuses[0].id === 5 && order.is_refund == 0 &&
                        diffDays <= 7);

                    orderHTML += order.order_items.map(item => {

                        const oldPriceDisplay = item.old_price_variant ? item.old_price_variant :
                            item.old_price ?
                            item.old_price : "";
                        const formattedOldPrice = oldPriceDisplay ? `${oldPriceDisplay}₫` : "";

                        if (!item.product_variant_id) {
                            amountAllItems += parseFloat(item.price) * parseInt(item.quantity);
                        } else {
                            amountAllItems += parseFloat(item.price_variant) * parseInt(item
                                .quantity_variant);
                        }

                        const imageUrl =
                            `{{ Storage::url('${item.product.thumbnail}') }}`; // Đường dẫn ảnh
                        // const imageUrl = `/storage/${item.product.thumbnail}`; // Đường dẫn ảnh
                        return `
                <div class="d-flex flex-row" style="justify-content: space-between; align-items: center; border-top: 1px solid #ccc">
                    <div class="order-body d-flex">
                        <img src="${imageUrl}" alt="Product" class="me-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <div class="d-flex flex-row" style="justify-content: space-between">
                            <div>
                                <a href="/products/${item.product.slug}" class="mb-1">${item.name}</a>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    ${
                                        item.product_variant_id
                                            ? `Phân loại hàng: ${item.name_variant}`
                                            : ""
                                    }
                                </p>
                                <p class="text-muted mb-1" style="font-size: 14px;">
                                    x${
                                        item.product_variant_id
                                            ? item.quantity_variant
                                            : item.quantity
                                    }
                                </p>
                                <div style="margin-right: 15px">
                        <span class="price-old">${formattedOldPrice}</span>
                        <span class="price-new ms-2">
                            ${
                                item.product_variant_id
                                    ? formatCurrency(item.price_variant)
                                    : formatCurrency(item.price)
                            }₫
                        </span>
                    </div>
                            </div>
                        </div>
                    </div>
                   <div class="d-flex" style="margin-right: 15px;flex-direction: column;">
    ${showReviewButton ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a data-bs-toggle="modal"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       data-bs-target="#writereview"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       href="#"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       class="text"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       style="align-items: center;text-align: end;margin-bottom: 11px;cursor: pointer;font-size: 17px;color: #b5d000;"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       data-order-id="${item.order_id}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   data-product-id="${item.product.id || item.product_variant_id}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   data-product-name="${item.product.name}"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   data-product-image="{{ Storage::url('${item.product.thumbnail}') }} ">Đánh giá</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `:""}
    <div class="d-flex flex-row " style="align-items: center;justify-content: center;justify-items: center;">
        <span>Thành tiền: </span> <p class="price-new" style="margin-bottom: unset">${item.product_variant_id ? formatCurrency(parseFloat(item.quantity_variant) * parseFloat(item.price_variant)) : formatCurrency(parseFloat(item.quantity) * parseFloat(item.price))}₫</p>
    </div>
</div>
                </div>
            `;
                    }).join(""); // Kết hợp tất cả các sản phẩm thành một chuỗi

                    if (order.coupon_discount_type == CouponDiscountType_PERCENT) {
                        if (amountAllItems * order.coupon_discount_value / 100 >
                            order.coupon.restriction.max_discount_value) {
                            discountValueOrder = order.coupon.restriction.max_discount_value

                        } else {
                            discountValueOrder = amountAllItems * order.coupon_discount_value / 100
                        }
                    } else if (order.coupon_discount_type == CouponDiscountType_FIX_AMOUNT) {
                        discountValueOrder = order.coupon_discount_value

                    }


                    // Thêm phần footer của đơn hàng
                    orderHTML += `
            <div class="order-footer">
                <div class="d-flex flex-row">
${showRefundButton ? `<button class="btn btn-sm btn-not-get btn-refund-order"  data-idOrderRefund="${order.id}" style="background-color: red; color: #fff;">
                                        Hoàn hàng
                                        </button>
                                        <ul class="count_time_${order.id}" style="align-items: center;justify-content: center;display: flex;">
                                        
                                        </ul>
                                        `:""}

${order.order_statuses[0].id == 6 && order.is_refund_cancel ==1 &&order.check_refund_cancel !=1 ?`
                                                                                                            
                                        <button class="btn me-2 btn-not-get btn-received-money"  data-idorder="${order.id}" style="background-color: green; color: #fff;">
                                        Đã nhận tiền
                                        </button>
                                        <button class="btn btn-reorder btn-not-received-money me-2"  data-idorder="${order.id}" >Chưa nhận tiền</button>

                                        `:""}
${order.order_statuses[0].id === 1? `<button  class="btn btn-reorder me-2 btn-cancel-order" data-idOrderCancel="${order.id}" data-ispaid="${order.is_paid}">Hủy hàng</button>` : ""}
</div>
<div>
<div>${order.coupon_discount_type ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                        <span>Giảm giá: </span>
                                        <span class="price-new">${formatCurrency(discountValueOrder)}₫</span>
                                        </div>


                                        `:""}
<div>
                        <span>Tổng tiền: </span>
                    <span class="price-new">${formatCurrency(order.total_amount)}₫</span>
                        </div>
                </div>
            </div>
        </div>
        `;
                    // Thêm HTML của đơn hàng vào danh sách
                    listCard.innerHTML += orderHTML;

                    const timer = () => {
                        const now = new Date().getTime();
                        const distance = updatedAt.getTime() + (7 * 24 * 60 * 60 * 1000) - now;

                        // Tính toán thời gian còn lại
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // Tạo một chuỗi duy nhất cho cập nhật HTML
                        const html = `
    <li>
      <div class="counter d-flex ml-3" style="margin-left: 8px">
        <div class="d-block">
          <h5>${days}</h5>
        </div>
        <h6>Ngày</h6>
      </div>
    </li>
    <li>
      <div class="counter d-flex ml-3" style="margin-left: 8px">
        <div class="d-block">
          <h5>${hours}</h5>
        </div>
        <h6>Giờ</h6>
      </div>
    </li>
    <li>
      <div class="counter d-flex ml-3" style="margin-left: 8px">
        <div class="d-block">
          <h5>${minutes}</h5>
        </div>
        <h6>Phút</h6>
      </div>
    </li>
    <li>
      <div class="counter d-flex ml-3" style="margin-left: 8px">
        <div class="d-block">
          <h5>${seconds}</h5>
        </div>
        <h6>Giây</h6>
      </div>
    </li>
  `;

                        // Cập nhật toàn bộ danh sách cùng một lúc
                        $(`.count_time_${order.id}`).html(html);


                        // Kiểm tra xem thời gian đã hết chưa
                        if (distance < 0) {
                            cancelAnimationFrame(
                                animationFrameId); // Sử dụng cancelAnimationFrame để dừng vòng lặp
                            $(`.count_time_${order.id}`).html(
                                `<li>Thời gian đã hết!</li>`
                            ); // Hoặc hiển thị thông báo "Thời gian đã hết!"
                            return;
                        }

                        animationFrameId = requestAnimationFrame(timer);
                    };
                    let animationFrameId = requestAnimationFrame(timer);
                });

                $('.order-detail').click(async function() {
                    const orderId = $(this).data('orderid');
                    console.log(orderId);
                    await fillOrderDetail(orderId)
                    $("#showDetailOrder").modal('show');
                })


                $(".btn-show-img-money").click(function() {
                    const orderId = $(this).data("orderid");
                    const img = $(this).data("img");
                    const imageUrl =
                        `{{ Storage::url('${img}') }}`;
                    $("#showImgBankRefund #img").attr('src', imageUrl)
                    $("#showImgBankRefund").modal('show');

                })

                $(".btn-received-money").click(function() {
                    const orderId = $(this).data("idorder");
                    if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                        return; // Ngưng nếu người dùng không xác nhận
                    }
                    $.ajax({
                        url: '{{ route('api.orders.userCheckRefundMoney') }}',
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            status: 1,
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                fetchOrders();
                            }
                        },
                        error: function(error) {
                            console.error(
                                "Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });

                })

                $(".btn-not-received-money").click(function() {
                    const orderId = $(this).data("idorder");
                    if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                        return; // Ngưng nếu người dùng không xác nhận
                    }
                    $.ajax({
                        url: '{{ route('api.orders.userCheckRefundMoney') }}',
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            status: 0,
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                fetchOrders();
                            }
                        },
                        error: function(error) {
                            console.error(
                                "Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });

                })

                $(".btn-cancel-order").click(function() {
                    const orderId = $(this).data("idordercancel");
                    const ispaid = $(this).data("ispaid");


                    if (!confirm('Bạn có chắc chắn hủy hàng không?')) {
                        return;
                    }

                    if (ispaid == 1) {
                        if (!dataUser.bank_account && !dataUser.user_bank_name && !dataUser.bank_name) {
                            alert("Hãy điền thông tin ngân hàng để được hoàn tiền!");
                            return
                        }


                        $.ajax({
                            url: '{{ route('api.orders.changeStatusRefundMoney') }}',
                            type: 'POST',
                            data: {
                                order_id: orderId,
                                status: 0
                            },
                            success: function(response) {

                                if (response.status == 200) {
                                    Toastify({
                                        text: "Tiền sẽ được hoàn sớm nhất vào tài khoản của bạn!",
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
                                }
                            },
                            error: function(error) {
                                console.error(
                                    "Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });

                        $.ajax({
                            url: '{{ route('api.orders.changeStatusOrder') }}',
                            type: 'POST',
                            data: {
                                order_id: orderId,
                                status_id: 6,

                            },
                            success: function(response) {

                                if (response.status == 200) {
                                    fetchOrders();
                                }
                            },
                            error: function(error) {
                                console.error(
                                    "Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });





                    } else {
                        $.ajax({
                            url: '{{ route('api.orders.changeStatusOrder') }}',
                            type: 'POST',
                            data: {
                                order_id: orderId,
                                status_id: 6,

                            },
                            success: function(response) {

                                if (response.status == 200) {
                                    fetchOrders();
                                }
                            },
                            error: function(error) {
                                console.error(
                                    "Lỗi cập nhật trạng thái đơn hàng:",
                                    error);
                            }
                        });
                    }


                });

                $(".btn-received-order").click(function() {
                    const orderId = $(this).data("idorderreceived");
                    if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                        return; // Ngưng nếu người dùng không xác nhận
                    }


                    $.ajax({
                        url: '{{ route('api.orders.updateOrderStatusWithUserCheck') }}',
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            customer_check: 1,
                            status_id: 5
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                fetchOrders();
                            }
                        },
                        error: function(error) {
                            console.error(
                                "Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });


                })

                $(".btn-not-received-order").click(function() {
                    const orderId = $(this).data("idordernotreceived");

                    if (!confirm('Bạn có chắc chắn thao tác này không?')) {
                        return; // Ngưng nếu người dùng không xác nhận
                    }

                    $.ajax({
                        url: '{{ route('api.orders.updateOrderStatusWithUserCheck') }}',
                        type: 'POST',
                        data: {
                            order_id: orderId,
                            customer_check: 0,
                            status_id: null
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                fetchOrders();
                            }
                        },
                        error: function(error) {
                            console.error(
                                "Lỗi cập nhật trạng thái đơn hàng:",
                                error);
                        }
                    });
                })


                $(".btn-refund-order").click(async function() {
                    const orderId = $(this).data("idorderrefund");
                    await getItemProductByOrder(orderId);

                    dataRefundProducts.order_id = orderId;

                    $('#returnOrderModal #bank_account').val(dataUser.bank_account ? dataUser
                        .bank_account : "")
                    $('#returnOrderModal #user_bank_name').val(dataUser.user_bank_name ? dataUser
                        .user_bank_name : "")
                    $('#returnOrderModal #bank_name').val(dataUser.bank_name ? dataUser.bank_name : "")

                    $("#returnOrderModal").modal('show');

                    $('#returnOrderModal #reason_image').on('change', function(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            const fileType = file.type.split('/')[0];

                            reader.onload = function(e) {
                                if (fileType === 'image') {
                                    $('#returnOrderModal #reason_image_show')
                                        .attr('src', e.target.result)
                                        .show();
                                    $('#returnOrderModal #reason_video_show').hide();
                                } else if (fileType === 'video') {
                                    $('#returnOrderModal #reason_video_show')
                                        .attr('src', e.target.result)
                                        .show();
                                    $('#returnOrderModal #reason_image_show').hide();
                                }
                            }

                            reader.readAsDataURL(file); // Đọc file ảnh
                        }
                    });


                })

                $("#returnOrderModal .btn-close").click(function() {
                    $('#returnOrderModal #formRefundItem')[0].reset();
                    $('#returnOrderModal .error-message').remove();
                    $('#returnOrderModal .is-invalid').removeClass('is-invalid');
                    dataRefundProducts = {
                        products: [],
                        order_id: '',
                        user_id: dataUser.id,
                        total_amount: ''
                    };
                });

                $("#returnOrderModal #formRefundItem").off('submit').on('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(this);
                    formData.append('dataRefundProducts', JSON.stringify(dataRefundProducts));
                    $.ajax({
                        url: `{{ route('api.refund_orders.createOrderRefund') }}`,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            if (response.status == 200) {


                                fetchOrders()
                                Toastify({
                                    text: "Tạo đơn hàng hoàn thành công",
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

                                $('#returnOrderModal #formRefundItem')[0].reset();
                                $('#returnOrderModal .error-message').remove();
                                $('#returnOrderModal .is-invalid').removeClass('is-invalid');
                                dataRefundProducts = {
                                    products: [],
                                    order_id: '',
                                    user_id: dataUser.id,
                                    total_amount: ''
                                };
                                $("#returnOrderModal").modal('hide')
                            } else {
                                $('#returnOrderModal .error-message').remove();
                                $('#returnOrderModal .is-invalid').removeClass('is-invalid');
                                if (response.errors) {
                                    $.each(response.errors, function(field, messages) {
                                        let input = $(`#returnOrderModal #${field}`);
                                        if (input.length > 0) {
                                            let errorDiv = $(
                                                '<div class="invalid-feedback error-message d-block">'
                                            );
                                            $.each(messages, function(index, message) {
                                                errorDiv.append('<span>' +
                                                    message +
                                                    '</span><br>');
                                            });
                                            input.addClass('is-invalid');
                                            input.after(errorDiv);
                                        }
                                    });
                                }
                            }
                        },
                        error: function(error) {
                            console.error("Lỗi thêm dữ liệu:", error);
                        }
                    });

                })

            }

            fetchOrders();

        })
        // comapre-count
        function getCookie(name) {
            let cookieValue = null;
            if (document.cookie && document.cookie !== '') {
                const cookies = document.cookie.split(';');
                for (let i = 0; i < cookies.length; i++) {
                    const cookie = cookies[i].trim();
                    // Does this cookie string begin with the name we want?
                    if (cookie.startsWith(name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }

        function updateCompareCountBadge() {
            const compareCookieName = 'compare_list';
            const compareListCookie = getCookie(compareCookieName);
            let compareCount = 0;
            if (compareListCookie) {
                try {
                    const compareList = JSON.parse(compareListCookie);
                    compareCount = compareList.length;
                } catch (error) {
                    console.error('Lỗi khi parse cookie compare_list:', error);
                }
            }
            $('#compare-count-badge').text(compareCount);
            if (compareCount > 0) {
                $('#compare-count-badge').show(); // Hoặc sử dụng class để hiển thị
            } else {
                $('#compare-count-badge').hide(); // Hoặc sử dụng class để ẩn
            }
        }

        // Gọi hàm này khi trang sản phẩm được tải
        updateCompareCountBadge(); //end compare

        $('#writereview').on('show.bs.modal', function(event) {
            const reviewButton = $(event.relatedTarget);
            const orderId = reviewButton.data('order-id');
            const productId = reviewButton.data('product-id');
            const productName = reviewButton.data('product-name'); // Lấy tên sản phẩm
            const productImage = reviewButton.data('product-image'); // Lấy URL hình ảnh sản phẩm

            $('#review_order_id').val(orderId);

            const productIdInput = $("#reviewForm input[name='product_id']");
            if (productIdInput.length === 0) {
                $("#reviewForm").append(`<input type="hidden" name="product_id" value="${productId}">`);
            } else {
                productIdInput.val(productId);
            }

            // Hiển thị thông tin sản phẩm trong modal
            const modalProductImage = $(this).find('.product-image');
            const modalProductName = $(this).find('.product-content .name');

            if (modalProductImage.length > 0) {
                modalProductImage.html(
                    `<img class="img-fluid" alt="${productName}" src="${productImage}" width="100px">`);
            }

            if (modalProductName.length > 0) {
                modalProductName.text(productName);
            }
        });


        // đánh giá

        document.addEventListener('DOMContentLoaded', function() {
            // --- Khai báo các biến ---
            const stars = document.querySelectorAll('.star');
            const ratingValue = document.getElementById('ratingValue');
            const reviewForm = document.getElementById('reviewForm');
            const submitButton = document.getElementById('submitReview');
            const reviewText = document.getElementById('content');
            const imagesInput = document.getElementById('images');
            const videosInput = document.getElementById('videos');
            const isAuthenticated = document.getElementById('isAuthenticated')?.value === 'true';
            const reviewContainer = document.querySelector(
                '.reviews-section'
            ); // Selector cho khu vực hiển thị đánh giá (CẦN CHỈNH SỬA SELECTOR NÀY CHO PHÙ HỢP)

            // --- Hàm xử lý chọn sao đánh giá ---
            function handleStarRating(starElement) {
                if (!isAuthenticated) {
                    showLoginRequiredAlert();
                    return;
                }

                const value = starElement.getAttribute('data-value');
                ratingValue.value = value;

                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('fill');
                    } else {
                        s.classList.remove('fill');
                    }
                });
            }
            // return cookieValue; // Dòng này có vẻ như bạn muốn trả về cookie ở đây, nhưng nó nằm ngoài hàm

            // --- Hàm hiển thị thông báo yêu cầu đăng nhập ---
            function showLoginRequiredAlert() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo!',
                    text: 'Bạn cần đăng nhập để đánh giá!',
                });
            }

            // --- Hàm kiểm tra số lượng ảnh   ---
            function validateImageCount() {
                const files = imagesInput.files;
                if (files.length > 5) {
                    return {
                        'images_count': 'Bạn chỉ được phép tải lên tối đa 5 hình ảnh.'
                    };
                }
                return null; // Không có lỗi
            }

            // --- Hàm xử lý gửi đánh giá ---
            async function submitReviewForm(event) {
                event.preventDefault();
                event.stopPropagation();

                if (!isAuthenticated) {
                    showLoginRequiredAlert();
                    return;
                }

                // Xóa thông báo lỗi hiện tại
                clearErrorMessages();

                // Kiểm tra số lượng ảnh
                const imageCountError = validateImageCount();
                if (imageCountError) {
                    displayErrorMessages(imageCountError);
                    return; // Dừng gửi form nếu lỗi số lượng ảnh
                }

                // Kiểm tra tính hợp lệ của dữ liệu
                const validationErrors = validateInput();
                if (validationErrors) {
                    displayErrorMessages(validationErrors);
                    return;
                }

                // Hiển thị thông báo đang gửi
                Swal.fire({
                    title: 'Đang gửi đánh giá...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Gửi form data bằng Fetch API
                try {
                    const formData = new FormData(reviewForm);
                    const response = await fetch(reviewForm.action, {
                        method: 'POST',
                        body: formData,
                    });

                    if (response.ok) {
                        const responseData = await response.json(); // Lấy dữ liệu JSON từ response
                        handleSuccessResponse(responseData);
                    } else {
                        handleErrorResponse(response);
                    }
                } catch (error) {
                    handleFetchError(error);
                } finally {
                    Swal.close(); // Đóng thông báo đang gửi
                }
            }

            // --- Hàm xóa tất cả thông báo lỗi ---
            function clearErrorMessages() {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            }

            // --- Hàm kiểm tra dữ liệu đầu vào   ---
            function validateInput() {
                let errors = {};
                if (!ratingValue.value) {
                    errors['rating'] = 'Vui lòng chọn số sao.';
                }
                if (!reviewText.value) {
                    errors['review_text'] = 'Vui lòng nhập nội dung đánh giá.';
                }
                return Object.keys(errors).length > 0 ? errors : null;
            }

            // --- Hàm hiển thị thông báo lỗi ---
            function displayErrorMessages(errors) {
                for (const key in errors) {
                    let errorElement = null;

                    if (key === 'rating') {
                        errorElement = document.getElementById('rating-error');
                    } else if (key === 'review_text') {
                        errorElement = document.getElementById('review_text-error');
                    } else if (key === 'images' || key === 'images_count') {
                        errorElement = document.getElementById('images-error');
                    } else if (key.startsWith('images.')) {
                        errorElement = document.getElementById(
                            'images-error');
                    } else if (key.startsWith('videos.')) {
                        errorElement = document.getElementById('videos-error');
                    }

                    if (errorElement) {
                        errorElement.textContent = errors[key];
                    }
                }
            }

            // --- Hàm xử lý khi gửi đánh giá thành công ---
            function handleSuccessResponse() {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Đánh giá thành công!',
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    location.reload();
                });
            }
            // --- Hàm tạo HTML cho một đánh giá ---
            function createReviewHtml(review) {
                // BẠN CẦN TỰ VIẾT HÀM NÀY ĐỂ TẠO HTML HIỂN THỊ ĐÁNH GIÁ DỰA TRÊN CẤU TRÚC DỮ LIỆU TRẢ VỀ TỪ SERVER
                // Ví dụ (cần điều chỉnh theo cấu trúc dữ liệu và HTML của bạn):
                return `
        <div class="single-review">
            <div class="review-header">
                <p>Người dùng ID: ${review.user_id}</p>
                <div class="rating">
                    ${renderStars(review.rating)}
                </div>
            </div>
            <div class="review-body">
                <p>${review.review_text}</p>
                ${review.review_multimedia ? renderReviewMultimedia(review.review_multimedia) : ''}
                <p class="review-date">${new Date(review.created_at).toLocaleDateString()}</p>
            </div>
        </div>
    `;
            }

            // --- Hàm render sao đánh giá (ví dụ) ---
            function renderStars(rating) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        starsHtml += '<i data-feather="star" class="fill"></i>';
                    } else {
                        starsHtml += '<i data-feather="star"></i>';
                    }
                }
                return starsHtml;
            }

            // --- Hàm render hình ảnh/video đánh giá (ví dụ) ---
            function renderReviewMultimedia(multimedia) {
                let multimediaHtml = '';
                multimedia.forEach(item => {
                    if (item.file_type === 0) { // Hình ảnh
                        multimediaHtml +=
                            `<img src="/storage/${item.file}" alt="Review Image" class="img-fluid mb-2">`;
                    } else if (item.file_type === 1) { // Video
                        multimediaHtml +=
                            `<video src="/storage/${item.file}" controls class="w-100 mb-2"></video>`;
                    }
                });
                return multimediaHtml;
            }

            // --- Hàm xử lý khi có lỗi từ server ---
            async function handleErrorResponse(response) {
                try {
                    const data = await response.json();

                    if (data && data.errors) {
                        displayErrorMessages(data.errors);
                    } else if (data && data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: data.error,
                        });
                    }
                } catch (jsonError) {
                    handleFetchError(jsonError);
                }
            }


            // --- Hàm xử lý lỗi Fetch API ---
            function handleFetchError(error) {
                console.error('Lỗi Fetch:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi gửi đánh giá.',
                });
            }


            // --- Gắn kết các sự kiện ---
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    handleStarRating(this);
                });
            });

            if (submitButton && reviewForm) {
                submitButton.addEventListener('click', submitReviewForm);
            }

            // Lấy order_id và product_id từ thuộc tính data-* khi modal được hiển thị
            $('#writereview').on('show.bs.modal', function(event) {
                const reviewButton = $(event.relatedTarget); // Lấy thẻ <a> đã kích hoạt modal
                const orderId = reviewButton.data('order-id');
                const productId = reviewButton.data('product-id');

                $('#review_order_id').val(orderId);

                // Thêm hoặc cập nhật input hidden cho product_id
                const productIdInput = $("#reviewForm input[name='product_id']");
                if (productIdInput.length === 0) {
                    $("#reviewForm").append(`<input type="hidden" name="product_id" value="${productId}">`);
                } else {
                    productIdInput.val(productId);
                }
            });
        });
    </script>

    <script src="{{ asset('js/utility.js') }}"></script>
@endpush
