@extends('client.layouts.master')


@push('css_library')
@endpush



@push('css')
    <style>
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .checkbox_animated.is-invalid {
            border: 2px solid red !important;
        }

        .inputadd.is-invalid {
            border: 1px solid #dc3545 !important
        }
    </style>
@endpush


@section('content')
    <div class="bg-gray-50">

        <main class="mx-auto max-w-7xl px-4 pb-24 pt-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
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

                                <div id="address-container" class="flex items-start">
                                    {{-- <div>
                                        <div class="text-black font-medium">Hoàng Minh Ánh (+84)</div>
                                        <div class="text-black">832966003</div>
                                    </div>
                                    <div>
                                        <div class="text-black">
                                            19 Ngách 26, Ngõ 394 Đường Mỹ Đình, Phường Mỹ Đình 1, Quận Nam Từ Liêm, Hà Nội,
                                            Phường Mỹ Đình 1, Quận Nam Từ Liêm, Hà Nội
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm">Mặc
                                            Định</div>
                                        <button id="open-modal" class="text-blue-500 text-sm">Thay Đổi</button>
                                    </div> --}}
                                </div>
                            </div>


                        </div>



                        <!-- Payment -->
                        <div class="mt-10 border-t border-gray-200 pt-10">
                            <h2 class="text-lg font-medium text-gray-900">Phương thức thanh toán</h2>

                            <div class="mt-4">
                                <legend class="sr-only">Payment type</legend>
                                <div class="flex flex-row items-center ">
                                    <!-- Thay đổi thành flex-col để dễ quản lý -->
                                    <div class="flex items-center">
                                        <input id="credit-card" name="payment-type" type="radio" checked
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="credit-card" class="ml-3 block text-sm/6 font-medium text-gray-700">Thẻ
                                            ghi nợ</label>
                                    </div>
                                    <div class="flex items-center ml-3">
                                        <input id="paypal" name="payment-type" type="radio"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="paypal"
                                            class="ml-3 block text-sm/6 font-medium text-gray-700">PayPal</label>
                                    </div>
                                    <div class="flex items-center ml-3">
                                        <input id="etransfer" name="payment-type" type="radio"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="etransfer" class="ml-3 block text-sm/6 font-medium text-gray-700">Tiền
                                            mặt</label>
                                    </div>
                                </div>

                            </div>

                            <div class="mt-6 grid grid-cols-4 gap-x-4 gap-y-6">
                                <div class="col-span-4">
                                    <label for="card-number" class="block text-sm/6 font-medium text-gray-700">Card
                                        number</label>
                                    <div class="mt-2">
                                        <input type="text" id="card-number" name="card-number" autocomplete="cc-number"
                                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>

                                <div class="col-span-4">
                                    <label for="name-on-card" class="block text-sm/6 font-medium text-gray-700">Name on
                                        card</label>
                                    <div class="mt-2">
                                        <input type="text" id="name-on-card" name="name-on-card" autocomplete="cc-name"
                                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>

                                <div class="col-span-3">
                                    <label for="expiration-date"
                                        class="block text-sm/6 font-medium text-gray-700">Expiration date (MM/YY)</label>
                                    <div class="mt-2">
                                        <input type="text" name="expiration-date" id="expiration-date"
                                            autocomplete="cc-exp"
                                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>

                                <div>
                                    <label for="cvc" class="block text-sm/6 font-medium text-gray-700">CVC</label>
                                    <div class="mt-2">
                                        <input type="text" name="cvc" id="cvc" autocomplete="csc"
                                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order summary -->
                    <div class="mt-10 lg:mt-0">
                        <h2 class="text-lg font-medium text-gray-900">Tóm tắt đơn hàng</h2>

                        <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                            <h3 class="sr-only">Danh sách sản phẩm</h3>
                            <ul role="list" class="divide-y divide-gray-200">
                                <li class="flex px-4 py-6 sm:px-6">
                                    <div class="shrink-0">
                                        <img src="https://tailwindui.com/plus-assets/img/ecommerce-images/checkout-page-02-product-01.jpg"
                                            alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="flex">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm">
                                                    <a href="#"
                                                        class="font-medium text-gray-700 hover:text-gray-800">Basic Tee</a>
                                                </h4>
                                                <p class="mt-1 text-sm text-gray-500">Black</p>
                                                <p class="mt-1 text-sm text-gray-500">Large</p>
                                            </div>

                                            <div class="ml-4 flow-root shrink-0">
                                                <button type="button"
                                                    class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor"
                                                        aria-hidden="true" data-slot="icon">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <p class="mt-1 text-sm font-medium text-gray-900">$32.00</p>

                                            <div class="ml-4 grid grid-cols-1">
                                                <select id="quantity" name="quantity" aria-label="Quantity"
                                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                </select>
                                                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500 sm:size-4"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                                    data-slot="icon">
                                                    <path fill-rule="evenodd"
                                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="flex px-4 py-6 sm:px-6">
                                    <div class="shrink-0">
                                        <img src="https://tailwindui.com/plus-assets/img/ecommerce-images/checkout-page-02-product-01.jpg"
                                            alt="Front of men&#039;s Basic Tee in black." class="w-20 rounded-md">
                                    </div>

                                    <div class="ml-6 flex flex-1 flex-col">
                                        <div class="flex">
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm">
                                                    <a href="#"
                                                        class="font-medium text-gray-700 hover:text-gray-800">Basic Tee</a>
                                                </h4>
                                                <p class="mt-1 text-sm text-gray-500">Black</p>
                                                <p class="mt-1 text-sm text-gray-500">Large</p>
                                            </div>

                                            <div class="ml-4 flow-root shrink-0">
                                                <button type="button"
                                                    class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                                    <span class="sr-only">Remove</span>
                                                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor"
                                                        aria-hidden="true" data-slot="icon">
                                                        <path fill-rule="evenodd"
                                                            d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="flex flex-1 items-end justify-between pt-2">
                                            <p class="mt-1 text-sm font-medium text-gray-900">$32.00</p>

                                            <div class="ml-4 grid grid-cols-1">
                                                <select id="quantity" name="quantity" aria-label="Quantity"
                                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                </select>
                                                <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500 sm:size-4"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                                    data-slot="icon">
                                                    <path fill-rule="evenodd"
                                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <!-- More products... -->
                            </ul>
                            <dl class="space-y-6 border-t border-gray-200 px-4 py-6 sm:px-6">
                                <form>
                                    <label for="discount-code" class="block text-sm/6 font-medium text-gray-700">Mã giảm
                                        giá</label>
                                    <div class="mt-1 flex space-x-4">
                                        <input type="text" id="discount-code" name="discount-code"
                                            class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                        <button
                                            class="rounded-md bg-gray-200 px-4 text-sm font-medium text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Apply</button>
                                    </div>
                                </form>

                                <dl class="mt-10 space-y-6 text-sm font-medium text-gray-500">
                                    <div class="flex justify-between">
                                        <dt>Tổng tiền</dt>
                                        <dd class="text-gray-900">$210.00</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="flex">
                                            Giảm giá
                                            <span
                                                class="ml-2 rounded-full bg-gray-200 px-2 py-0.5 text-xs tracking-wide text-gray-600">CHEAPSKATE</span>
                                        </dt>
                                        <dd class="text-gray-900">-$24.00</dd>
                                    </div>

                                    <div class="flex justify-between">
                                        <dt>Shipping</dt>
                                        <dd class="text-gray-900">Free</dd>
                                    </div>
                                    <div
                                        class="flex items-center justify-between border-t border-gray-200 pt-6 text-gray-900">
                                        <dt class="text-base">Tổng</dt>
                                        <dd class="text-base">$341.68</dd>
                                    </div>
                                </dl>
                            </dl>
                        </div>


                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Xác
                                nhận đơn hàng</button>
                        </div>
                    </div>
                </div>
                </form>
        </main>

    </div>
    <div id="address-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
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
                                <input type="checkbox" id="id_default" name="id_default"
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
                                <input type="checkbox" id="id_default" name="id_default"
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
    </div>

    <!-- Modal: Thêm Địa Chỉ Mới (Add New Address) -->
@endsection

@push('js_library')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('js')
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
                    if (dataEditAddress.id_default == 1) {
                        $("#edit-address-modal #id_default").prop('checked', true).prop('disabled',
                            true); // Đánh dấu và vô hiệu hóa
                    } else {
                        $("#edit-address-modal #id_default").prop('checked', false).prop('disabled',
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

            let dataSaveOrder = {
                'fullname': "abc"


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
                            $('#address-container').html(`
                            <div>
                                        <div class="text-black font-medium">${data.dataAddressOne.fullname} (+84)</div>
                                        <div class="text-black">${data.dataAddressOne.phone_number}</div>
                                    </div>
                                    <div>
                                        <div class="text-black">
                                            ${data.dataAddressOne.address}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm">Mặc
                                            Định</div>
                                        <button id="open-modal" class="text-blue-500 text-sm">Thay Đổi</button>
                                    </div> 
                            `)
                        }
                    })

                $("#open-modal").click(function() {
                    $("#address-modal").removeClass("hidden");
                    $("#select-address-modal").removeClass("hidden"); // Hiển thị modal chọn địa chỉ
                    $("#add-address-modal").addClass("hidden"); // Ẩn modal thêm địa chỉ
                    $("body").addClass("overflow-hidden");
                    displayAddresses(); // Hiển thị danh sách địa chỉ
                });

                $("#add-more-address-button").on("click", () => {


                    $("#address-modal").removeClass("hidden");
                    $("#select-address-modal").addClass("hidden"); // Hiển thị modal chọn địa chỉ
                    $("#add-address-modal").removeClass("hidden"); // Ẩn modal thêm địa chỉ


                })
            }
            getAddressUser();

            function createAddressHTML(address) {

                return `
                <div class="mt-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <input type="radio" id="${address.id}" name="selected-address" value="${address.id}" class="mr-2 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" ${address.id_default ? 'checked' : ''}>
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
                                    ${address.id_default? `<div class="border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm">${address.id_default == 1 ?"Mặc Định":""}</div>` :""}
                                    
                                    <div class="text-blue-500 text-sm">Địa chỉ lấy hàng</div>
                                </div>
                            </div>
                        </div>
    `;

            }

            $("#select-address-confirm-button").on("click", function() {
                const selectedAddressId = $('input[name="selected-address"]:checked')
                    .val(); // Lấy giá trị của radio button đã chọn

                console.log("selectedAddressId", selectedAddressId);

                //             if (selectedAddressId) {
                //                 $('#address-container').empty();
                //                 await fetch(`http://127.0.0.1:8000/api/address/get-address-edit/${selectedAddressId}`)
                //                     .then(response => response.json())
                //                     .then(data => {
                //                         if (!data.dataEditAddress) {
                //                             $('#address-container').html(`
            //                             <button id="add-more-address-button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white focus:outline-none">
            //                                 Thêm địa chỉ nhận hàng
            //                             </button>
            // `);
                //                         } else {
                //                             $('#address-container').html(`
            //                         <div>
            //                                     <div class="text-black font-medium">${data.dataEditAddress.fullname} (+84)</div>
            //                                     <div class="text-black">${data.dataEditAddress.phone_number}</div>
            //                                 </div>
            //                                 <div>
            //                                     <div class="text-black">
            //                                         ${data.dataEditAddress.address}
            //                                     </div>
            //                                 </div>
            //                                 <div class="flex items-center space-x-2">
            //                                     <div class="border border-red-500 text-red-500 px-2 py-1 rounded-md text-sm">Mặc
            //                                         Định</div>
            //                                     <button id="open-modal" class="text-blue-500 text-sm">Thay Đổi</button>
            //                                 </div> 
            //                         `)
                //                         }
                //                     })

                //                 $("#address-modal").addClass("hidden");
                //                 $("#select-address-modal").addClass("hidden");





                //             }
                //     const selectedAddress = addresses.find(address => address.id ==
                //         selectedAddressId); // Tìm địa chỉ tương ứng

                //     // Xử lý dữ liệu của địa chỉ đã chọn
                //     console.log("Địa chỉ đã chọn:", selectedAddress);

                //     // Bạn có thể làm gì đó với selectedAddress, ví dụ, gửi dữ liệu tới server
                // } else {
                //     alert("Vui lòng chọn một địa chỉ.");
                // }
            });






            $('#add-address-modal').on('submit', (e) => {
                e.preventDefault();
                const fullname = $("#add-address-modal #fullname").val();
                const phone_number = $("#add-address-modal #phone_number").val();
                const address = $("#add-address-modal #address").val();
                const id_default = $("#add-address-modal #id_default").is(":checked") ? 1 :
                    0; // Lấy giá trị checkbox

                // console.log(fullname, phone_number, address, id_default);
                // return;

                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/address/add-address-user", // Sử dụng route của Laravel
                    data: {
                        fullname: fullname,
                        phone_number: phone_number,
                        address: address,
                        id_default: id_default,
                        user_id: dataUser.id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {
                            displayAddresses();
                            $("#add-address-modal").addClass("hidden");
                            $("#select-address-modal").removeClass("hidden");
                            document.getElementById('add-address-modal').reset();
                        } else {
                            // Xử lý lỗi
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field, messages) {
                                    let input = $(`#add-address-modal #${field}`);
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback error-message d-block">'
                                        );
                                        $.each(messages, function(index, message) {
                                            errorDiv.append('<span>' + message +
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
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert('Tên đăng nhập hoặc mật khẩu không đúng.');
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
                const id_default = $("#edit-address-modal #id_default").is(":checked") ? 1 :
                    0; // Lấy giá trị checkbox



                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8000/api/address/update-address-user", // Sử dụng route của Laravel
                    data: {
                        fullname: fullname,
                        phone_number: phone_number,
                        address: address,
                        id_default: id_default,
                        user_id: dataUser.id,
                        idAddress: idAddress
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status === 200) {
                            displayAddresses();
                            $("#edit-address-modal").addClass("hidden");
                            $("#select-address-modal").removeClass("hidden");
                            document.getElementById('edit-address-modal').reset();
                        } else {
                            // Xử lý lỗi
                            $('.error-message').remove();
                            $('.is-invalid').removeClass('is-invalid');
                            if (response.errors) {
                                $.each(response.errors, function(field, messages) {
                                    let input = $(`#edit-address-modal #${field}`);
                                    if (input.length > 0) {
                                        let errorDiv = $(
                                            '<div class="invalid-feedback error-message d-block">'
                                        );
                                        $.each(messages, function(index, message) {
                                            errorDiv.append('<span>' + message +
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
                    error: function(xhr) {
                        let errorResponse = JSON.parse(xhr.responseText);
                        console.error("Lỗi Đăng Nhập:", errorResponse);
                        if (errorResponse.message) {
                            alert(errorResponse.message);
                        } else {
                            alert('Tên đăng nhập hoặc mật khẩu không đúng.');
                        }
                    }
                });
            })


            $("#open-modal").click(function() {
                $("#address-modal").removeClass("hidden");
                $("#select-address-modal").removeClass("hidden"); // Hiển thị modal chọn địa chỉ
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


        })
    </script>
@endpush
