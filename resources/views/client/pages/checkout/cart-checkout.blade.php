@extends('client.layouts.master')


@push('css_library')
@endpush



@push('css')
    <style>
        .price-old {
            text-decoration: line-through;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .checkbox_animated.is-invalid {
            border: 2px solid red !important;
        }

        .inputadd.is-invalid {
            border: 1px solid #dc3545 !important;
        }

        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Nền trắng mờ */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            /* Đảm bảo nó ở trên cùng */
        }

        .spinner {
            border: 5px solid #f3f3f3;
            /* Màu xám nhạt */
            border-top: 5px solid #3498db;
            /* Màu xanh dương */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .scrollable-items {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 8px 0;
            padding-left: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        /* Individual item styles */
        .scrollable-items .item {
            flex: 0 0 auto;
            background-color: var(--theme-color);
            padding: 0 10px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .scrollable-items .item:hover {
            background-color: #2ded97;
        }

        .discount-value {
            font-size: 12px;
            color: #fff;

        }

        /* Responsive scrollable items */
        @media (max-width: 400px) {
            .scrollable-items .item {
                padding: 8px 16px;
                font-size: 12px;
            }
        }
    </style>
@endpush


@section('content')
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>
    <div class="bg-gray-50">

        <main class="container-fluid-lg">
            <div class="row">

                <h1 class="sr-only">Checkout</h1>

                <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                    <div>
                        <div class="mt-10 border-t border-gray-200 pt-10">
                            <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                            <div class="space-y-2">
                                <div class="text-red-500 font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="w-6 h-6 mr-1">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 12a3 3 0 11-6 0 3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                        <path d="M12 14.25a6.75 6.75 0 00-6.75 6.75h13.5a6.75 6.75 0 00-6.75-6.75z" />
                                    </svg>
                                    Địa Chỉ Nhận Hàng
                                </div>

                                <div id="address-container" class="flex justify-between">

                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="comment" class="block text-sm/6 font-medium text-gray-900">Ghi chú</label>
                                <div class="mt-2">
                                    <textarea rows="4" name="noteOrder" id="noteOrder"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"></textarea>
                                </div>
                            </div>


                        </div>



                        <!-- Payment -->
                        <div class="mt-10 border-t border-gray-200 pt-10">
                            <h2 class="text-lg font-medium text-gray-900">Phương thức thanh toán</h2>

                            <div class="mt-4">
                                <legend class="sr-only">Payment type</legend>
                                <div class="flex flex-row items-center " id="list-payment">

                                </div>

                            </div>

                        </div>
                    </div>

                    <!-- Order summary -->
                    <div class="mt-10 lg:mt-0">
                        <h2 class="text-lg font-medium text-gray-900">Tóm tắt đơn hàng</h2>

                        <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                            <h3 class="sr-only">Danh sách sản phẩm</h3>
                            <ul role="list" id="listProductCheckout" class="divide-y divide-gray-200">



                                <!-- More products... -->
                            </ul>
                            <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                                <form id="formDiscountCode">
                                    @csrf
                                    <label for="discount-code" class="block text-sm/6 font-medium text-gray-700">Mã giảm
                                        giá</label>
                                    <div class="mt-1 flex space-x-4" id="inputadddiv">
                                        <input type="text" id="discountCode" name="discountCode"
                                            class="block w-full inputadd rounded-md bg-white px-3 py-2 text-base text-gray-900 border-1 placeholder:text-gray-400   sm:text-sm/6">
                                        <button style="width: 130px" type="submit"
                                            class="rounded-md bg-gray-200 px-4 text-sm font-medium text-gray-600 hover:bg-gray-300  focus:ring-offset-2 focus:ring-offset-gray-50">Xác
                                            nhận</button>
                                    </div>

                                </form>
                                {{-- <div class="scrollable-items" id="discount-items"> --}}
                                <div class="flex justify-between items-center">
                                    <button id="choseVouchers" class="text-green-600 px-2 py-2"
                                        style="margin-top: unset">Chọn
                                        Voucher</button>

                                    <button id="cancelChoseVouchers" class="text-red-600 px-2 py-2"
                                        style="margin-top: unset">
                                        Bỏ Chọn Voucher</button>
                                </div>
                                {{-- </div> --}}

                                <dl class="mt-10 space-y-6 text-sm font-medium text-gray-500">
                                    <div class="flex justify-between">
                                        <dt>Tổng tiền</dt>
                                        <dd class="text-gray-900" id="totalItemsMoney"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="flex">
                                            Giảm giá
                                            <span id="codeDiscountSelected"
                                                class="ml-2 rounded-full bg-gray-200 px-2 py-0.5 text-xs tracking-wide text-gray-600"></span>
                                        </dt>
                                        <dd class="text-gray-900" id="discountValue">0</dd>
                                    </div>

                                    <div class="flex justify-between">
                                        <dt>Shipping</dt>
                                        <dd class="text-gray-900">Free</dd>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-t border-gray-200 pt-6 text-gray-900">
                                        <dt class="text-base">Tổng</dt>
                                        <dd class="text-base" id="totalAllOrderMoney"></dd>
                                    </div>
                                </dl>
                            </dl>
                        </div>


                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <button style="background-color: var(--theme-color);" id="button-confirm-order"
                                class="w-full rounded-md border border-transparent  px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Xác
                                nhận đơn hàng</button>
                        </div>
                    </div>
                </div>
                </form>
        </main>

    </div>
    <div id="address-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-4 sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div id="select-address-modal" class="modal-content">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Địa Chỉ Của Tôi
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Chọn địa chỉ giao hàng của bạn
                            </p>

                            <!-- Địa chỉ hiện có -->
                            <div id="existing-addresses" class="mt-4">
                                <!-- Các địa chỉ sẽ được thêm vào đây bằng JavaScript -->
                            </div>

                            <!-- Thêm địa chỉ mới -->
                            <div class="mt-4">
                                <button id="add-new-address-button" class="text-gray-500">+ Thêm Địa Chỉ Mới</button>
                            </div>

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button id="select-address-confirm-button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Xác nhận
                        </button>
                        <button id="select-address-cancel-button" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Huỷ
                        </button>
                    </div>
                </div>

                <!-- Modal: Thêm Địa Chỉ Mới (Add New Address) -->
                <form id="add-address-modal" class="modal-content hidden">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Thêm Địa Chỉ Mới
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Nhập địa chỉ giao hàng mới của bạn
                            </p>

                            <!-- Form nhập địa chỉ mới -->
                            <div class="mt-4 grid grid-cols-12 gap-2">
                                <div class="mb-4 col-span-6">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Họ và
                                        Tên:</label>
                                    <input type="text" id="fullname" name="fullname"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none ">
                                </div>
                                <div class="mb-4 col-span-6">
                                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Số Điện
                                        Thoại:</label>
                                    <input type="text" id="phone_number" name="phone_number"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none ">
                                </div>
                                <div class="mb-4 col-span-12">
                                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Địa
                                        Chỉ:</label>
                                    <textarea id="address" name="address"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none "></textarea>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_default" name="is_default"
                                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="checkbox" class="ml-2 block text-sm text-gray-700">Đặt làm mặc định</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button id="add-address-complete-button" type="submit"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Hoàn Thành
                        </button>
                        <button id="add-address-back-button" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Trở Lại
                        </button>
                    </div>
                </form>

                <form id="edit-address-modal" class="modal-content hidden">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Sửa Địa Chỉ
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Sửa địa chỉ giao hàng mới của bạn
                            </p>
                            <input type="hidden" hidden id="idAddress" name="idAddress">

                            <!-- Form nhập địa chỉ mới -->
                            <div class="mt-4 grid grid-cols-12 gap-2">
                                <div class="mb-4 col-span-6">
                                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Họ và
                                        Tên:</label>
                                    <input type="text" id="fullname" name="fullname"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none ">
                                </div>
                                <div class="mb-4 col-span-6">
                                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Số Điện
                                        Thoại:</label>
                                    <input type="text" id="phone_number" name="phone_number"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none ">
                                </div>
                                <div class="mb-4 col-span-12">
                                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Địa
                                        Chỉ:</label>
                                    <textarea id="address" name="address"
                                        class="inputadd appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none "></textarea>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_default" name="is_default"
                                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="checkbox" class="ml-2 block text-sm text-gray-700">Đặt làm mặc định</label>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button id="add-address-complete-button" type="submit"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Hoàn Thành
                        </button>
                        <button id="edit-address-back-button" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Trở Lại
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="modal-voucher" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-4 sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div id="select-voucher-modal" class="modal-content">
                    <div class="bg-white rounded-lg shadow-md p-4 w-full ">
                        <!-- Tiêu đề -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Chọn Voucher</h2>

                        </div>

                        <!-- Tìm kiếm voucher -->
                        <div class="flex items-center space-x-2 mb-4">
                            <input type="text" id="inputSearchVoucher" placeholder="Mã Voucher"
                                class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Danh sách voucher -->
                        <div id="listVoucherModal" class="space-y-4 max-h-[300px] overflow-y-auto">
                            <!-- Voucher 1 -->

                        </div>



                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button id="select-voucher-confirm-button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Xác nhận
                        </button>
                        <button id="select-voucher-cancel-button" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Huỷ
                        </button>
                    </div>
                </div>

                <!-- Modal: Thêm Địa Chỉ Mới (Add New Address) -->



            </div>

        </div>
    </div>

    <!-- Modal: Thêm Địa Chỉ Mới (Add New Address) -->
@endsection

@push('js_library')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('js')
    <script>
        let sessionData = <?php echo json_encode(session('selectedProducts')); ?>;
        console.log(sessionData); // Kiểm tra dữ liệu trên console
    </script>


    <script>
        async function openAddressEdit(id) {
            document.getElementById('edit-address-modal').reset();

            await fetch(`http://127.0.0.1:8000/api/address/get-address-edit/${id}`)
                .then(response => response.json())
                .then(data => {
                    let dataEditAddress = data.dataEditAddress
                    console.log("dataEditAddress", dataEditAddress)
                    $("#edit-address-modal #fullname").val(dataEditAddress.fullname)
                    $("#edit-address-modal #phone_number").val(dataEditAddress.phone_number)
                    $("#edit-address-modal #address").val(dataEditAddress.address)
                    $("#edit-address-modal #idAddress").val(id)
                    if (dataEditAddress.is_default == 1) {
                        $("#edit-address-modal #is_default").prop('checked', true).prop('disabled',
                            true); // Đánh dấu và vô hiệu hóa
                    } else {
                        $("#edit-address-modal #is_default").prop('checked', false).prop('disabled',
                            false); // Bỏ đánh dấu và kích hoạt
                    }

                })
                .catch(error => console.error("Error fetching address data:", error));


            $("#edit-address-modal").removeClass("hidden");
            $("#select-address-modal").addClass("hidden");
        }

        $("#open-modal").click(function() {
            $("#address-modal").removeClass("hidden");
            $("#select-address-modal").removeClass("hidden"); // Hiển thị modal chọn địa chỉ
            $("#add-address-modal").addClass("hidden"); // Ẩn modal thêm địa chỉ
            $("body").addClass("overflow-hidden");
            displayAddresses(); // Hiển thị danh sách địa chỉ
        });

        $(document).ready(function() {
            const dataUser = <?php echo json_encode($user); ?>;
            let selectedProducts = <?php echo json_encode(session('selectedProducts'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;
            let totalPrice = <?php echo json_encode(session('totalPrice'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>;

            let dataSaveOrder = {
                fullname: "",
                user_id: dataUser.id,
                phone_number: "",
                payment_id: "",
                email: dataUser.email,
                address: "",
                note: "",
                total_amount: totalPrice,
                is_paid: "",
                coupon_id: "",
                coupon_code: "",
                coupon_discount_type: "",
                coupon_discount_value: "",
                total_amount_discounted: totalPrice,
            }

            const ordersItem = selectedProducts;
            // const ordersItem = [{
            //         product_id: 1,
            //         image: "products/product_iphone-16-pro-max.webp",
            //         product_variant_id: null,
            //         name: "Sản phẩm A",
            //         old_price: null,
            //         price: 50000,
            //         quantity: 2,
            //         name_variant: "",
            //         attributes_variant: "",
            //         old_price_variant: null,
            //         price_variant: 199.99,
            //         quantity_variant: 2,
            //     },
            //     {
            //         product_id: 2,
            //         image: "products/product_iphone-16-pro-max.webp",
            //         product_variant_id: 1,
            //         name: "Sản phẩm B",
            //         old_price: 60000,
            //         price: 50000,
            //         quantity: 1,
            //         name_variant: "Màu xanh - M",
            //         attributes_variant: "",
            //         old_price_variant: null,
            //         price_variant: 50000,
            //         quantity_variant: 2,
            //     },
            // ];



            $("#listProductCheckout").empty();


            ordersItem.forEach((item) => {

                const oldPriceDisplay = item.old_price_variant ? item.old_price_variant : item.old_price ?
                    item.old_price : "";
                const formattedOldPrice = oldPriceDisplay ? `${oldPriceDisplay}₫` : "";
                const imageUrl =
                    `{{ Storage::url('${item.image}') }}`; // Đường dẫn ảnh
                $("#listProductCheckout").append(`
            
            <li class="flex px-4 py-6 sm:px-6">
                                    <div class="shrink-0">
                                        <img src="${imageUrl}"
                                            alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="flex">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm">
                                                    <a href="#"
                                                        class="font-medium text-gray-700 hover:text-gray-800">${item.name}</a>
                                                </h4>
                                                <p class="mt-1 text-sm text-gray-500">${item.product_variant_id ? item.name_variant: ""}</p>
                                            </div>

                                            <p>Số lượng: ${item.product_variant_id ? item.quantity_variant: item.quantity}</p>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <div>
                                                <span class="price-old">${formattedOldPrice}</span>
                                                <p class="text-sm font-medium text-red-900">${item.product_variant_id ? formatCurrency(parseFloat(item.price_variant)): formatCurrency(parseFloat(item.price))}đ</p>
                                                </div>

                                            <div class="ml-4 grid grid-cols-1">
                                                <p>Thành tiền: ${item.product_variant_id ? formatCurrency(parseInt(item.quantity_variant)*parseFloat(item.price_variant)): formatCurrency(parseInt(item.quantity)*parseFloat(item.price))}đ</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
            
            
            `);

            })



            dataSaveOrder.payment_id = $("input[name='payment-type']:checked").val()
            dataSaveOrder.total_amount_discounted = dataSaveOrder.total_amount

            function displayPaymentMethods(paymentMethods) {
                const paymentMethodsContainer = $("#list-payment"); // Chọn container

                paymentMethodsContainer.empty(); // Xóa các radio button cũ

                paymentMethods.forEach(paymentMethod => {
                    const div = $("<div>").addClass("flex items-center ml-3 divChosePayment");
                    const input = $("<input>")
                        .attr("type", "radio")
                        .attr("id", paymentMethod.id)
                        .attr("name", "payment-type")
                        .addClass(
                            "h-4 w-4 text-indigo-600 focus:ring-indigo-500 inputChosePayment border-gray-300 rounded"
                        )
                        .val(paymentMethod.id); // Thêm value để dễ dàng lấy giá trị sau này

                    const label = $("<label>")
                        .attr("for", paymentMethod.id)
                        .addClass("ml-3 block text-sm/6 font-medium text-gray-700")
                        .text(paymentMethod.name); // Giả sử API trả về trường "name"

                    div.append(input).append(label);
                    paymentMethodsContainer.append(div);

                    // Đặt checked cho phương thức thanh toán đầu tiên (nếu cần)
                    if (paymentMethods.indexOf(paymentMethod) === 0) {
                        input.prop("checked", true);
                    }
                });
            }


            async function getPaymentMethods() {
                try {
                    await fetch(`http://127.0.0.1:8000/api/payment/list`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data)
                            if (data.status == 200) {
                                displayPaymentMethods(data.listPayment)
                            } else {
                                console.error("Lỗi khi lấy phương thức thanh toán:", data);
                                alert(
                                    "Không thể lấy danh sách phương thức thanh toán. Vui lòng thử lại sau."
                                );
                            }
                        })
                } catch (error) {
                    console.error("Lỗi fetch:", error);
                    alert("Có lỗi xảy ra khi kết nối đến server. Vui lòng thử lại sau.");
                }
            }

            async function displayAddresses() {
                const existingAddressesDiv = $("#existing-addresses");
                existingAddressesDiv.empty(); // Xóa nội dung cũ
                let addresses;
                await fetch(`http://127.0.0.1:8000/api/address/list/${dataUser.id}`)
                    .then(response => response.json())
                    .then(data => {
                        addresses = data.dataAddress
                        console.log(addresses);


                    });
                addresses.forEach(address => {
                    existingAddressesDiv.append(createAddressHTML(address));
                });



            }

            async function getAddressUser() {
                await fetch(`http://127.0.0.1:8000/api/address/get-address-one/${dataUser.id}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("data: ", data);
                        if (!data.dataAddressOne) {
                            $('#address-container').html(`
                                <button id="add-more-address-button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white focus:outline-none">
                                    Thêm địa chỉ nhận hàng
                                </button>
    `);
                        } else {

                            dataSaveOrder.fullname = data.dataAddressOne.fullname;
                            dataSaveOrder.address = data.dataAddressOne.address
                            dataSaveOrder.phone_number = data.dataAddressOne.phone_number

                            $('#address-container').html(`
                            <div class="flex items-start">
                                    <div>
                                        <div class="text-black font-medium">${data.dataAddressOne.fullname}</div>
                                        <div class="text-black"> (+84)${data.dataAddressOne.phone_number}</div>
                                    </div>
                                    <div>
                                        <div class="text-black">
                                            ${data.dataAddressOne.address}
                                        </div>
                                    </div>
                                </div>
                                    <div class="flex items-center space-x-2">
                                        ${data.dataAddressOne.is_default == 1?"<div class='border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm'>Mặc Định</div>":""}
                                        <button id="open-modal" class="text-blue-500 text-sm">Thay Đổi</button>
                                    </div> 
                            `)
                        }
                    })

                $("#open-modal").click(function() {
                    $("#address-modal").removeClass("hidden");
                    $("#select-address-modal").removeClass(
                        "hidden"); // Hiển thị modal chọn địa chỉ
                    $("#add-address-modal").addClass("hidden"); // Ẩn modal thêm địa chỉ
                    $("body").addClass("overflow-hidden");
                    displayAddresses(); // Hiển thị danh sách địa chỉ
                });

                $("#add-more-address-button").on("click", () => {


                    $("#address-modal").removeClass("hidden");
                    $("#select-address-modal").addClass(
                        "hidden"); // Hiển thị modal chọn địa chỉ
                    $("#add-address-modal").removeClass("hidden"); // Ẩn modal thêm địa chỉ


                })
            }

            function createAddressHTML(address) {
                return `
                <div class="mt-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <input type="radio" id="${address.id}" name="selected-address" value="${address.id}" class="mr-2 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" ${address.is_default ? 'checked' : ''}>
                                    <div class="flex justify-between items-center">
                                        <div class="text-black font-medium">${address.fullname} (+84)</div>
                                        <div class="text-black">${address.phone_number}</div>
                                    </div>
                                </div>

                                <div class="flex-end">
                                    <button onclick="openAddressEdit(${address.id})" class="text-blue-500 text-sm">Cập nhật</button>
                                </div>

                            </div>
                            <div class="ml-4">
                                <div class="text-black">
                                    ${address.address}
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    ${address.is_default? `<div class="border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm">${address.is_default == 1 ?"Mặc Định":""}</div>` :""}
                                    
                                    <div class="text-blue-500 text-sm">Địa chỉ lấy hàng</div>
                                </div>
                            </div>
                        </div>
    `;

            }

            getAddressUser();
            getPaymentMethods();


            $("#select-address-confirm-button").on("click", async function() {
                const selectedAddressId = $('input[name="selected-address"]:checked')
                    .val(); // Lấy giá trị của radio button đã chọn

                console.log("selectedAddressId", selectedAddressId);

                if (selectedAddressId) {
                    $('#address-container').empty();
                    await fetch(
                            `http://127.0.0.1:8000/api/address/get-address-edit/${selectedAddressId}`
                        )
                        .then(response => response.json())
                        .then(data => {

                            console.log(data);
                            if (!data.dataEditAddress) {
                                $('#address-container').html(`
                                        <button id="add-more-address-button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white focus:outline-none">
                                            Thêm địa chỉ nhận hàng
                                        </button>
                                    `);
                            } else {
                                dataSaveOrder.fullname = data.dataEditAddress.fullname;
                                dataSaveOrder.address = data.dataEditAddress.address
                                dataSaveOrder.phone_number = data.dataEditAddress.phone_number

                                $('#address-container').html(`
                                <div class="flex items-start">
                                            <div>
                                                <div class="text-black font-medium">${data.dataEditAddress.fullname}</div>
                                                <div class="text-black"> (+84)${data.dataEditAddress.phone_number}</div>
                                            </div>
                                            <div>
                                                <div class="text-black">
                                                    ${data.dataEditAddress.address}
                                                </div>
                                            </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                ${data.dataEditAddress.is_default == 1?"<div class='border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm'>Mặc Định</div>":""}
                                                <button id="open-modal" class="text-blue-500 text-sm">Thay Đổi</button>
                                            </div> 
                                    `)
                            }
                            $("#open-modal").click(function() {
                                $("#address-modal").removeClass("hidden");
                                $("#select-address-modal").removeClass(
                                    "hidden"); // Hiển thị modal chọn địa chỉ
                                $("#add-address-modal").addClass(
                                    "hidden"); // Ẩn modal thêm địa chỉ
                                $("body").addClass("overflow-hidden");
                                displayAddresses(); // Hiển thị danh sách địa chỉ
                            });
                        });


                }

                $("#select-address-modal").addClass("hidden");
                $("#address-modal").addClass("hidden");
                $("body").removeClass("overflow-hidden");

            })

            $('#add-address-modal').on('submit', (e) => {
                e.preventDefault();
                const fullname = $("#add-address-modal #fullname").val();
                const phone_number = $("#add-address-modal #phone_number").val();
                const address = $("#add-address-modal #address").val();
                const is_default = $("#add-address-modal #is_default").is(":checked") ?
                    1 :
                    0; // Lấy giá trị checkbox

                // console.log(fullname, phone_number, address, is_default);
                // return;

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/address/add-address-user", // Sử dụng route của Laravel
                    data: {
                        fullname: fullname,
                        phone_number: phone_number,
                        address: address,
                        is_default: is_default,
                        user_id: dataUser.id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {
                            displayAddresses();
                            $("#add-address-modal").addClass("hidden");
                            $("#select-address-modal").removeClass(
                                "hidden");
                            document.getElementById('add-address-modal')
                                .reset();
                        } else {
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field,
                                    messages) {
                                    let input = $(
                                        `#add-address-modal #${field}`
                                    );
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback error-message d-block">'
                                        );
                                        $.each(messages, function(
                                            index, message
                                        ) {
                                            errorDiv.append(
                                                '<span>' +
                                                message +
                                                '</span><br>'
                                            );
                                        });
                                        input.addClass(
                                            'is-invalid');
                                        input.after(errorDiv);
                                    }
                                });
                            } else {
                                alert(
                                    'Có lỗi xảy ra. Vui lòng thử lại sau.'
                                );
                                console.error('Lỗi không xác định:',
                                    response);
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert(
                                'Tên đăng nhập hoặc mật khẩu không đúng.'
                            );
                        }
                    }
                });
            })

            $('#edit-address-modal').on('submit', (e) => {
                e.preventDefault();
                const fullname = $("#edit-address-modal #fullname").val();
                const phone_number = $("#edit-address-modal #phone_number").val();
                const address = $("#edit-address-modal #address").val();
                const idAddress = $("#edit-address-modal #idAddress").val();
                const is_default = $("#edit-address-modal #is_default").is(":checked") ?
                    1 :
                    0; // Lấy giá trị checkbox



                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/address/update-address-user", // Sử dụng route của Laravel
                    data: {
                        fullname: fullname,
                        phone_number: phone_number,
                        address: address,
                        is_default: is_default,
                        user_id: dataUser.id,
                        idAddress: idAddress
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {
                            displayAddresses();
                            $("#edit-address-modal").addClass("hidden");
                            $("#select-address-modal").removeClass(
                                "hidden");
                            document.getElementById('edit-address-modal')
                                .reset();
                        } else {
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field,
                                    messages) {
                                    let input = $(
                                        `#edit-address-modal #${field}`
                                    );
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback error-message d-block">'
                                        );
                                        $.each(messages, function(
                                            index, message
                                        ) {
                                            errorDiv.append(
                                                '<span>' +
                                                message +
                                                '</span><br>'
                                            );
                                        });
                                        input.addClass(
                                            'is-invalid');
                                        input.after(errorDiv);
                                    }
                                });
                            } else {
                                alert(
                                    'Có lỗi xảy ra. Vui lòng thử lại sau.'
                                );
                                console.error('Lỗi không xác định:',
                                    response);
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert(
                                'Tên đăng nhập hoặc mật khẩu không đúng.'
                            );
                        }
                    }
                });
            })

            $("#open-modal").click(function() {
                $("#address-modal").removeClass("hidden");
                $("#select-address-modal").removeClass(
                    "hidden"); // Hiển thị modal chọn địa chỉ
                $("#add-address-modal").addClass("hidden"); // Ẩn modal thêm địa chỉ
                $("body").addClass("overflow-hidden");
                displayAddresses(); // Hiển thị danh sách địa chỉ
            });

            $("#add-new-address-button").click(function() {
                $("#select-address-modal").addClass("hidden");
                $("#add-address-modal").removeClass("hidden");
            });

            $("#add-address-back-button").click(function() {
                $("#add-address-modal").addClass("hidden");
                $("#select-address-modal").removeClass("hidden");
                document.getElementById('add-address-modal').reset();
            });

            $("#edit-address-back-button").click(function() {
                $("#edit-address-modal").addClass("hidden");
                $("#select-address-modal").removeClass("hidden");
                document.getElementById('edit-address-modal').reset();
            });

            $("#select-address-cancel-button").click(function() {
                $("#address-modal").addClass("hidden");
                $("body").removeClass("overflow-hidden");
            });

            $("#address-modal").click(function(event) {
                if (event.target === this) {
                    $("#address-modal").addClass("hidden");
                    $("body").removeClass("overflow-hidden");
                }
            });



            $("#totalItemsMoney").text(`${formatCurrency(dataSaveOrder.total_amount)}(VND)`);
            $("#totalAllOrderMoney").text(`${formatCurrency(dataSaveOrder.total_amount)}(VND)`);


            $("#button-confirm-order").on("click", async function() {

                dataSaveOrder.note = $("#noteOrder").val();
                if ($("input[name='payment-type']:checked").val() == 1) {

                    //chưa thanh toán
                    dataSaveOrder.payment_id = $("input[name='payment-type']:checked").val();
                    dataSaveOrder.is_paid = 0;
                    // console.log("ordersItem: ", ordersItem);
                    // return;
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/createOrder',
                        type: 'POST',
                        data: {
                            dataOrder: dataSaveOrder,
                            ordersItem: ordersItem,
                            _token: '{{ csrf_token() }}' // Laravel CSRF token
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                window.location.href = '/page_successfully';
                            } else {
                                Toastify({
                                    text: response.message,
                                    duration: 4000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: "red",
                                    },
                                }).showToast();
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });


                } else {
                    dataSaveOrder.payment_id = $("input[name='payment-type']:checked").val();
                    dataSaveOrder.is_paid = 1;

                    $.ajax({
                        url: 'http://127.0.0.1:8000/payment/vnpay',
                        type: 'POST',
                        data: {
                            amount: dataSaveOrder.total_amount_discounted,
                            dataOrder: dataSaveOrder,
                            ordersItem: ordersItem,
                            _token: '{{ csrf_token() }}' // Laravel CSRF token
                        },
                        success: function(response) {
                            if (response.url) {
                                // Chuyển hướng tới VNPay để thanh toán
                                window.location.href = response.url;
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });
                }


            })


            async function callApiGetValueDiscount(discountCode, total_amount) {

                $("#codeDiscountSelected").empty();
                await $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/getValueDiscount", // Sử dụng route của Laravel
                    data: {
                        discountCode: discountCode,
                        user_id: dataUser.id,
                        total_amount: total_amount
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        // return;
                        if (response.status === 200) {
                            $('#formDiscountCode .error-message').remove();
                            $('#formDiscountCode input.is-invalid').removeClass('is-invalid');

                            $("#codeDiscountSelected").text(response.dataDiscount.code);
                            $("#totalItemsMoney").text(
                                `${formatCurrency(total_amount)}(VND)`);

                            const formattedDiscountValue = "-" + formatCurrency(response
                                .dataDiscount.discount_amount) + "(VND)"; // Giả sử trả về số dương

                            $("#discountValue").text(formattedDiscountValue);


                            $("#totalAllOrderMoney").text(
                                `${formatCurrency(total_amount - response.dataDiscount.discount_amount)}(VND)`
                            );

                            dataSaveOrder.total_amount_discounted = total_amount - response
                                .dataDiscount.discount_amount;
                            dataSaveOrder.coupon_discount_value = response.dataDiscount
                                .discount_value;
                            dataSaveOrder.coupon_discount_type = response.dataDiscount
                                .discount_type;
                            dataSaveOrder.coupon_id = response.dataDiscount.coupon_id;
                            dataSaveOrder.coupon_code = response.dataDiscount.code;


                        } else {
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field,
                                    messages) {
                                    let input = $(
                                        `#formDiscountCode #${field}`
                                    );

                                    let formInputDiscount = $("#inputadddiv")
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback errDiscount error-message d-block">'
                                        );
                                        $.each(messages, function(
                                            index, message
                                        ) {
                                            errorDiv.append(
                                                '<span>' +
                                                message +
                                                '</span><br>'
                                            );
                                        });
                                        input.addClass(
                                            'is-invalid');
                                        formInputDiscount.after(errorDiv);
                                    }
                                });
                            } else {
                                alert(
                                    'Có lỗi xảy ra. Vui lòng thử lại sau.'
                                );
                                console.error('Lỗi không xác định:',
                                    response);
                            }
                        }
                    },
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert(
                                'Tên đăng nhập hoặc mật khẩu không đúng.'
                            );
                        }
                    }
                });
            }

            $("#formDiscountCode").on("submit", async function(event) {
                event.preventDefault(); // Ngăn chặn form submit mặc định

                // Lấy mã giảm giá từ input
                const discountCode = $("#discountCode").val();
                callApiGetValueDiscount(discountCode, dataSaveOrder.total_amount)

            });


            function renderHtmlListCouponUser(listCoupons) {
                const listVoucherModal = $("#listVoucherModal");
                $("#listVoucherModal").empty();

                listCoupons.forEach(function(voucher) {
                    // Tạo HTML cho mỗi voucher
                    let voucherHtml = `
                    <div class="${parseFloat(dataSaveOrder.total_amount) < parseFloat(voucher.coupon.restriction.min_order_value)?"bg-gray-300" :"bg-gray-50"}  border border-gray-200 rounded-lg p-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-teal-100 text-teal-600 rounded-lg p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Code: ${voucher.coupon.code}</p>
                                ${voucher.coupon.discount_type == 1 ? `<h3 class='text-sm font-medium text-gray-700'>Giảm ${voucher.coupon.discount_value}% Giảm tối đa ${voucher.coupon.restriction.max_discount_value ? parseFloat(voucher.coupon.restriction.max_discount_value)/1000 + 'k' : '...' }</h3>`:`<h3 class='text-sm font-medium text-gray-700'>Giảm ${parseFloat(voucher.coupon.discount_value)/1000 + 'k'}</h3>`}
                                <p class="text-xs text-gray-500">Đơn Tối Thiếu ₫${voucher.coupon.restriction.min_order_value ? parseFloat(voucher.coupon.restriction.min_order_value)/1000 + 'k' : '...' }</p>
                                ${voucher.coupon.is_shopee_video ? '<div class="bg-red-50 text-red-500 text-xs font-medium rounded-full px-2 py-1 mt-1 inline-block">Chỉ có trên Shopee Video</div>' : ''}
                               
                                <div class="text-xs text-gray-500">Đã dùng ${parseFloat(voucher.coupon.usage_count)/parseFloat(voucher.coupon.usage_limit)*100}%, HSD: ${voucher.coupon.end_date?formatDateString(voucher.coupon.end_date):"Không"}</div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-xs text-gray-400">x${voucher.amount}</span>
                            <input type="radio" name="voucher" ${parseFloat(dataSaveOrder.total_amount) < parseFloat(voucher.coupon.restriction.min_order_value)?"disabled":""} value="${voucher.coupon.code}" class="form-radio h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300">
                        </div>
                    </div>
                `;

                    listVoucherModal.append(voucherHtml);
                });
            }

            $("#choseVouchers").on("click", async function(e) {
                $("#listVoucherModal").empty();
                await $.ajax({
                    url: `http://127.0.0.1:8000/api/listDiscountsByUser/${dataUser.id}?total_amount=${dataSaveOrder.total_amount}`, // Thay đổi URL API của bạn
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        const listVoucherModal = $("#listVoucherModal");

                        // console.log(response.listCouponsByUser)
                        // return;
                        renderHtmlListCouponUser(response.listCouponsByUser)
                        // Xử lý thành công
                        // populateDiscountItems(response.listCouponsByUser)
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi áp dụng mã giảm giá:", xhr.responseText);
                        alert(
                            "Mã giảm giá không hợp lệ hoặc đã hết hạn."
                        ); // Ví dụ: Hiển thị thông báo lỗi
                    }
                });
                $("#modal-voucher").removeClass("hidden")


            })

            $("#select-voucher-cancel-button").on("click", function(e) {
                $("#modal-voucher").addClass("hidden")

            })


            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), delay);
                }
            }

            function getCouponList(code) {

                let url = `http://127.0.0.1:8000/api/listDiscountsByUser/${dataUser.id}`;
                if (code) {
                    url += `?code=${code}&total_amount=${dataSaveOrder.total_amount}`; // Thêm tham số code nếu có
                }

                $.ajax({
                    url: url, // Thay đổi URL API của bạn
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            renderHtmlListCouponUser(response.listCouponsByUser)

                        } else {
                            alert('Something error happened');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi áp dụng mã giảm giá:", xhr.responseText);
                        alert(
                            "Mã giảm giá không hợp lệ hoặc đã hết hạn."
                        ); // Ví dụ: Hiển thị thông báo lỗi
                    }
                });
            }

            const debouncedGetCouponList = debounce(function() {
                const code = $("#inputSearchVoucher").val();
                getCouponList(code);
            }, 400); // Delay 300ms


            $("#inputSearchVoucher").on('input', debouncedGetCouponList)

            $('#modal-voucher #select-voucher-confirm-button').on("click", async function() {
                var selectedValue = $('#modal-voucher input[name="voucher"]:checked').val();

                if (selectedValue) {
                    $("#discountCode").val(selectedValue);
                    await callApiGetValueDiscount(selectedValue, dataSaveOrder.total_amount)
                    $("#modal-voucher").addClass("hidden")
                } else {
                    $("#modal-voucher").addClass("hidden")
                    console.log(
                        'Chưa chọn voucher nào.'); // Thông báo nếu không có voucher nào được chọn
                }
            });

            $("#cancelChoseVouchers").on("click", function(e) {

                $("#codeDiscountSelected").text("");

                $("#totalAllOrderMoney").text(
                    `${formatCurrency(dataSaveOrder.total_amount)}(VND)`
                );

                $("#discountValue").text(0);
                $(".errDiscount").empty();

                $("#discountCode").val("");
                $(`#formDiscountCode #discountCode`).removeClass("is-invalid")

                dataSaveOrder.total_amount_discounted = dataSaveOrder.total_amount;
                dataSaveOrder.coupon_discount_value = "";
                dataSaveOrder.coupon_discount_type = "";
                dataSaveOrder.coupon_id = "";
                dataSaveOrder.coupon_code = "";


            })

            $('#loading-overlay').fadeOut();
        })
    </script>
    <script src="{{ asset('js/utility.js') }}"></script>

    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 4000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "red",
                },
            }).showToast();
        </script>
    @endif
@endpush
