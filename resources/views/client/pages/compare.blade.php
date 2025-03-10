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

                                </tr>

                                <tr>
                                    <th>Weight</th>
                                    <td class="text-content">5.00kg</td>
                                    <td class="text-content">1.00kg</td>
                                    <td class="text-content">0.75kg</td>

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
                                            <button type="button"
                                                class="btn btn-success w-100 d-flex align-items-center justify-content-center remove-compare-button"
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
        // Xử lý sự kiện xóa sản phẩm
        document.addEventListener('DOMContentLoaded', function() {
            // Sự kiện click cho nút xóa
            document.querySelectorAll('.remove-compare-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;

                    // Gọi hàm xóa và xử lý reload
                    removeFromCompareCookie(productId);


                });
            });
        });

        // Hàm xóa cookie
        function removeFromCompareCookie(productId) {
            let compareList = getCompareListFromCookie();
            const index = compareList.findIndex(id => id.toString() === productId.toString());


            if (index > -1) {
                compareList.splice(index, 1);
                console.log('Danh sách trước khi xóa:', compareList);
                console.log('ID cần xóa:', productId);
                if (compareList.length === 0) {
                    deleteCookie(compareCookieName);
                } else {
                    setCookie(compareCookieName, JSON.stringify(compareList), 30);
                }
                updateCompareCountBadgeCookie();
                // Thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Đã xóa!',
                    text: 'Sản phẩm đã được xóa khỏi so sánh',
                    timer: 1500
                }).then(() => {
                    // Reload trang sau khi SweetAlert đóng
                    window.location.reload(true);
                });
            }
        }


        // comapre cookie
        const compareCookieName = 'compare_list'; // Tên cookie để lưu danh sách so sánh

        // Hàm lấy cookie theo tên
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

        // Hàm set cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        // Hàm xóa cookie
        function deleteCookie(name) {
            document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
        }

        // Hàm lấy danh sách sản phẩm so sánh từ cookie
        function getCompareListFromCookie() {
            let compareListCookie = getCookie(compareCookieName);
            return compareListCookie ? JSON.parse(compareListCookie) : [];
        }

        // Hàm thêm sản phẩm vào so sánh (lưu vào cookie)
        function addProductToCompareCookie(productId) {
            let compareListCookie = getCookie(compareCookieName);
            let compareList = compareListCookie ? JSON.parse(compareListCookie) : [];

            if (!compareList.includes(productId)) { // Kiểm tra sản phẩm đã có trong list chưa
                compareList.push(productId); // Thêm sản phẩm vào list
                setCookie(compareCookieName, JSON.stringify(compareList),
                    30); // Lưu lại vào cookie (JSON string, hết hạn sau 30 ngày)
                updateCompareCountBadgeCookie(); // Cập nhật badge số lượng
            }
        }
        // Hàm cập nhật badge số lượng sản phẩm so sánh (dùng jQuery)
        function updateCompareCountBadgeCookie() {
            const compareCount = getCompareListFromCookie().length; // Đếm số lượng từ cookie
            $('.header-compare .badge-compare').text(compareCount); // Cập nhật text badge
            if (compareCount > 0) {
                $('.header-compare .badge-compare').show(); // Hiển thị badge nếu có sản phẩm
            } else {
                $('.header-compare .badge-compare').hide(); // Ẩn badge nếu không có sản phẩm
            }
        }


        function updateCompareCount() {
            updateCompareCountBadgeCookie(); // GỌI HÀM CẬP NHẬT BADGE DỰA TRÊN COOKIE TRỰC TIẾP
        }
        updateCompareCount();
    </script>
@endpush
