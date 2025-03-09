@extends('client.layouts.master')

@section('content')
    <!-- Breadcrumb Section Start -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2 class="mb-2">Compare</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">Shop</li>
                                <li class="breadcrumb-item active">Compare</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Compare Section Start -->
    <section class="compare-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table compare-table">
                            <tbody>
                                <tr>
                                    <th>Product</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <a class="text-title"
                                                href="{{ route('products', $product['slug']) }}">{{ $product['name'] }}</a>
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th>Images</th>

                                    @foreach ($productsData as $product)
                                        <td>
                                            <a href="{{ route('products', $product['slug']) }}">
                                                <img src="{{ $product['thumbnail'] }}" class="img-fluid blur-up lazyload"
                                                    alt="">
                                            </a>
                                        </td>
                                    @endforeach
                                </tr>
                                {{-- Thông số kĩ thuật --}}
                                @php
                                    $allSpecificationNames = collect($productsData)
                                        ->pluck('specifications')
                                        ->map(function ($specs) {
                                            return array_keys($specs);
                                        })
                                        ->flatten()
                                        ->unique();
                                @endphp
                                @foreach ($allSpecificationNames as $specName)
                                    <tr>
                                        <th>{{ $specName }}</th>
                                        @foreach ($productsData as $product)
                                            <td class="text-content">{{ $product['specifications'][$specName] ?? 'X' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach{{-- End TSKT --}}


                                {{-- Thuộc tính biến thể --}}
                                @if (collect($productsData)->contains(function ($product) {
                                        return !empty($product['variant_attributes']);
                                    }))
                                    <tr>
                                        <th>Thuộc tính biến thể</th>
                                        <td colspan="{{ count($productsData) }}"></td> {{-- Cột tiêu đề thuộc tính biến thể sẽ trải dài --}}
                                    </tr>

                                    @php
                                        $allVariantAttributeNames = collect($productsData)
                                            ->pluck('variant_attributes') // Lấy mảng variant_attributes của mỗi sản phẩm
                                            ->filter() // Loại bỏ các sản phẩm không có variant_attributes (null hoặc rỗng)
                                            ->flatten(1) // Làm phẳng mảng 2 chiều thành 1 chiều (mỗi phần tử là 1 variantAttributeSet)
                                            ->map(function ($variantAttributeSet) {
                                                return array_keys($variantAttributeSet); // Lấy keys (tên thuộc tính) từ mỗi variantAttributeSet
                                            })
                                            ->flatten() // Làm phẳng mảng tên thuộc tính
                                            ->unique() // Lấy các tên thuộc tính duy nhất
                                            ->values(); // Reset key mảng
                                    @endphp

                                    @foreach ($allVariantAttributeNames as $variantAttributeName)
                                        <tr>
                                            <th>{{ $variantAttributeName }}</th>
                                            @foreach ($productsData as $product)
                                                <td class="text-content">
                                                    @if ($product['variant_attributes'])
                                                        @php
                                                            $variantAttributeValues = collect(
                                                                $product['variant_attributes'],
                                                            )
                                                                ->map(function ($variantAttributeSet) use (
                                                                    $variantAttributeName,
                                                                ) {
                                                                    return $variantAttributeSet[
                                                                        $variantAttributeName
                                                                    ] ?? null; // Lấy giá trị của thuộc tính hiện tại, hoặc null nếu không có
                                                                })
                                                                ->filter() // Loại bỏ giá trị null
                                                                ->unique()
                                                                ->implode(' | ');
                                                        @endphp
                                                        {{ $variantAttributeValues ?: 'X' }}
                                                    @else
                                                        X
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endif{{-- end biến thể --}}


                                <tr>
                                    <th>Price</th>
                                    @foreach ($productsData as $product)
                                        <td class="price text-content">
                                            @if ($product['sale_price'])
                                                <del>{{ number_format($product['price']) }}đ</del>
                                                <br>
                                                <span class="theme-color">
                                                    {{ number_format($product['sale_price']) }}đ</span>
                                            @else
                                                <span class="theme-color"> {{ number_format($product['price']) }}đ</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th>Availability</th>
                                    <td class="text-content">In Stock</td>
                                    <td class="text-content">In Stock</td>
                                    <td class="text-content">In Stock</td>

                                </tr>

                                {{-- rating --}}
                                {{-- <tr>
                                    <th>Rating</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <div class="compare-rating">
                                                <ul class="rating">
                                                    @for ($i = 0; $i < floor($product['rating']); $i++)
                                                        <li><i data-feather="star" class="fill"></i></li>
                                                    @endfor
                                                    @if (floor($product['rating']) < $product['rating'])
                                                        <li><i data-feather="star" class="fill"></i></li>
                                                    @endif
                                                    @for ($i = 0; $i < 5 - ceil($product['rating']); $i++)
                                                        <li><i data-feather="star"></i></li>
                                                    @endfor
                                                </ul>
                                                <span class="text-content">(Raring)</span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr> --}}
                                <tr>
                                    <th>Rating</th>
                                    <td>
                                        <div class="compare-rating">
                                            <ul class="rating">
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                            </ul>
                                            <span class="text-content">(20 Raring)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="compare-rating">
                                            <ul class="rating">
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                            </ul>
                                            <span class="text-content">(25 Raring)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="compare-rating">
                                            <ul class="rating">
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                            </ul>
                                            <span class="text-content">(50 Raring)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="compare-rating">
                                            <ul class="rating">
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star" class="fill"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                                <li>
                                                    <i data-feather="star"></i>
                                                </li>
                                            </ul>
                                            <span class="text-content">(30 Raring)</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Weight</th>
                                    <td class="text-content">5.00kg</td>
                                    <td class="text-content">1.00kg</td>
                                    <td class="text-content">0.75kg</td>
                                    <td class="text-content">0.50kg</td>
                                </tr>

                                <tr>
                                    <th>Purchase</th>
                                    @foreach ($productsData as $product)
                                        <td>
                                            <button onclick="location.href = '#';"
                                                class="btn btn-animation btn-sm w-100">Add To Cart</button>
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <th></th>

                                    @foreach ($productsData as $product)
                                        <td>
                                            <button type="button" class="remove-compare-button"
                                                data-product-id="{{ $product['id'] }}">
                                                <i class="fa-solid fa-trash-can me-2"></i> Remove
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- Compare Section End -->








    <!-- Tap to top and theme setting button start -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
    </div>
    <!-- Tap to top and theme setting button end -->

    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->
@endsection

@section('modal')
@endsection
@push('js')
    <script>
        // **ĐẢM BẢO RẰNG CÁC FUNCTIONS NÀY ĐƯỢC ĐỊNH NGHĨA TRƯỚC**
        function getCompareListFromCookie() {
            let cookieValue = document.cookie.split('; ').find(row => row.startsWith(
            'compare_list=')); // Thay 'compareList=' thành 'compare_list='
            let compareList = [];

            if (cookieValue) {
                cookieValue = cookieValue.substring('compare_list='
                .length); // Thay 'compareList='.length thành 'compare_list='.length
                try {
                    compareList = JSON.parse(cookieValue) || [];
                } catch (e) {
                    console.error("[getCompareListFromCookie] Error parsing JSON:", e);
                    compareList = [];
                }
            }
            return compareList;
        }

        function setCompareListCookie(compareList) {
            const cookieName = 'compare_list'; // Thay 'compareList' thành 'compare_list'
            const cookieValue = JSON.stringify(compareList);
            const expirationDays = 30;
            const expirationDate = new Date();
            expirationDate.setDate(expirationDate.getDate() + expirationDays);
            const cookieString = `${cookieName}=${cookieValue}; expires=${expirationDate.toUTCString()}; path=/`;

            document.cookie = cookieString;
            console.log("[setCompareListCookie] Cookie set:", cookieString);
        }

        function updateCompareListUI(compareList) { // **ĐỊNH NGHĨA updateCompareListUI**
            // (Code để cập nhật giao diện người dùng hiển thị danh sách so sánh mới - ví dụ: cập nhật số lượng sản phẩm trong giỏ so sánh, v.v.)
            console.log("[updateCompareListUI] UI updated with compareList:", compareList);
            // Ví dụ: Cập nhật số lượng sản phẩm trong badge giỏ so sánh (nếu có)
            const compareCountElement = document.querySelector(
            '.compare-count'); // Selector có thể khác tùy theo HTML của bạn
            if (compareCountElement) {
                compareCountElement.textContent = compareList.length;
            }
        }


        function removeProductFromCompare(productId) {
            console.log("[removeProductFromCompare] Function called for productId:", productId);
            let compareList = getCompareListFromCookie();
            console.log("[removeProductFromCompare] Current compareList:", compareList);

            // **CHUYỂN ĐỔI productId SANG KIỂU NUMBER**
            const productIdNumber = parseInt(productId, 10); // Chuyển productId sang số nguyên cơ số 10
            console.log("[removeProductFromCompare] Converted productId to Number:", productIdNumber, "Type:",
                typeof productIdNumber); // Log giá trị và kiểu sau khi chuyển đổi


            const indexToRemove = compareList.indexOf(productIdNumber); // Sử dụng productIdNumber (kiểu số) trong indexOf

            if (indexToRemove > -1) {
                compareList.splice(indexToRemove, 1);
                console.log("[removeProductFromCompare] Product ID removed at index:", indexToRemove, "New compareList:",
                    compareList);

                // Gọi API backend để xóa sản phẩm và cập nhật cookie (NON-ENCRYPTED)
                fetch('/compare/remove-product/' + productId, { // Thay '/compare/remove/' bằng route path thực tế của bạn
                        method: 'POST',

                        // body: JSON.stringify({ productId: productId }) // (Không cần body vì productId đã ở URL)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            console.log(
                                "[removeProductFromCompare] Product removed successfully from backend cookie. New compareList from response:",
                                data.compareList);

                            setCompareListCookie(data.compareList);
                            updateCompareListUI(data.compareList);
                            // (Có thể thêm logic thông báo thành công nếu cần)
                        } else {
                            console.error("[removeProductFromCompare] Error removing product from backend cookie:", data
                                .message);
                            // (Xử lý lỗi nếu cần - ví dụ: hiển thị thông báo lỗi cho người dùng)
                        }
                    })
                    .catch(error => {
                        console.error("[removeProductFromCompare] Fetch error:", error);
                        // (Xử lý lỗi fetch nếu cần - ví dụ: hiển thị thông báo lỗi chung)
                    });


            } else {
                console.warn("[removeProductFromCompare] Product ID not found in compareList:", productId, "Compare List:",
                    compareList); // Thêm log compareList vào đây để debug thêm
            }
        }

        // **ĐẢM BẢO ĐOẠN CODE NÀY ĐẶT SAU KHI removeProductFromCompare ĐÃ ĐƯỢC ĐỊNH NGHĨA**
        document.querySelectorAll('.remove-compare-button').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                removeProductFromCompare(
                productId); // **removeProductFromCompare ĐÃ ĐƯỢC ĐỊNH NGHĨA Ở TRÊN**
            });
        });
    </script>
@endpush
