@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-order">
        <div class="title">
            <h2>Danh Sách Đơn Hàng</h2>
            <span class="title-leaf title-leaf-gray">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>

        <div class="filter-section p-3 bg-light rounded shadow-sm">
            <form method="GET" action="" id="filter-form">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="order-name" class="form-label">Trạng Thái Đơn Hàng:</label>
                        <div class="btn-group w-100 pb-2 pt-2" role="group" aria-label="Order name"
                            style="overflow-x: auto; white-space: nowrap;">

                            <!-- Tùy chọn "All" -->
                            <div class="d-inline-block" style="margin-right: 10px;">
                                <input type="radio" class="btn-check" name="status" id="status-all" value=""
                                    checked>
                                <label class="btn theme-bg-color text-white fw-bold px-4 py-2" for="status-all">All</label>
                            </div>
                            <!-- Lặp qua các trạng thái đơn hàng -->
                            @foreach ($orders['orderStatuses'] as $key => $status)
                                <div class="d-inline-block" style="margin-right: 10px;">
                                    <input type="radio" class="btn-check" name="status" id="status-{{ $key }}"
                                        value="{{ $key }}">
                                    <label class="btn theme-bg-color text-white fw-bold px-4 py-2"
                                        for="status-{{ $key }}">{{ __('form.order_status.' . $status) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="order-contain mt-3">
            <div class="order-box dashboard-bg-box">
                <div class="order-container">
                    <div class="order-icon">
                        <i data-feather="box"></i>
                    </div>

                    <div class="order-detail">
                        <h4>Delivers <span>Pending</span></h4>
                        <h6 class="text-content">Gouda parmesan caerphilly mozzarella
                            cottage cheese cauliflower cheese taleggio gouda.</h6>
                    </div>
                </div>

                <div class="product-order-detail">
                    <a href="product-left-thumbnail.html" class="order-image">
                        <img src="../assets/images/vegetable/product/1.png" class="blur-up lazyload" alt="">
                    </a>

                    <div class="order-wrap">
                        <a href="product-left-thumbnail.html">
                            <h3>Fantasy Crunchy Choco Chip Cookies</h3>
                        </a>
                        <p class="text-content">Cheddar dolcelatte gouda. Macaroni cheese
                            cheese strings feta halloumi cottage cheese jarlsberg cheese
                            triangles say cheese.</p>
                        <ul class="product-size">
                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Price : </h6>
                                    <h5>$20.68</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Rate : </h6>
                                    <div class="product-rating ms-2">
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
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Sold By : </h6>
                                    <h5>Fresho</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Quantity : </h6>
                                    <h5>250 G</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="order-box dashboard-bg-box">
                <div class="order-container">
                    <div class="order-icon">
                        <i data-feather="box"></i>
                    </div>

                    <div class="order-detail">
                        <h4>Delivered <span class="success-bg">Success</span></h4>
                        <h6 class="text-content">Cheese on toast cheesy grin cheesy grin
                            cottage cheese caerphilly everyone loves cottage cheese the big
                            cheese.</h6>
                    </div>
                </div>

                <div class="product-order-detail">
                    <a href="product-left-thumbnail.html" class="order-image">
                        <img src="../assets/images/vegetable/product/2.png" alt="" class="blur-up lazyload">
                    </a>

                    <div class="order-wrap">
                        <a href="product-left-thumbnail.html">
                            <h3>Cold Brew Coffee Instant Coffee 50 g</h3>
                        </a>
                        <p class="text-content">Pecorino paneer port-salut when the cheese
                            comes out everybody's happy red leicester mascarpone blue
                            castello cauliflower cheese.</p>
                        <ul class="product-size">
                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Price : </h6>
                                    <h5>$20.68</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Rate : </h6>
                                    <div class="product-rating ms-2">
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
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Sold By : </h6>
                                    <h5>Fresho</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Quantity : </h6>
                                    <h5>250 G</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="order-box dashboard-bg-box">
                <div class="order-container">
                    <div class="order-icon">
                        <i data-feather="box"></i>
                    </div>

                    <div class="order-detail">
                        <h4>Delivere <span>Pending</span></h4>
                        <h6 class="text-content">Cheesy grin boursin cheesy grin cheesecake
                            blue castello cream cheese lancashire melted cheese.</h6>
                    </div>
                </div>

                <div class="product-order-detail">
                    <a href="product-left-thumbnail.html" class="order-image">
                        <img src="../assets/images/vegetable/product/3.png" alt="" class="blur-up lazyload">
                    </a>

                    <div class="order-wrap">
                        <a href="product-left-thumbnail.html">
                            <h3>Peanut Butter Bite Premium Butter Cookies 600 g</h3>
                        </a>
                        <p class="text-content">Cow bavarian bergkase mascarpone paneer
                            squirty cheese fromage frais cheese slices when the cheese comes
                            out everybody's happy.</p>
                        <ul class="product-size">
                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Price : </h6>
                                    <h5>$20.68</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Rate : </h6>
                                    <div class="product-rating ms-2">
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
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Sold By : </h6>
                                    <h5>Fresho</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Quantity : </h6>
                                    <h5>250 G</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="order-box dashboard-bg-box">
                <div class="order-container">
                    <div class="order-icon">
                        <i data-feather="box"></i>
                    </div>

                    <div class="order-detail">
                        <h4>Delivered <span class="success-bg">Success</span></h4>
                        <h6 class="text-content">Caerphilly port-salut parmesan pecorino
                            croque monsieur dolcelatte melted cheese cheese and wine.</h6>
                    </div>
                </div>

                <div class="product-order-detail">
                    <a href="product-left-thumbnail.html" class="order-image">
                        <img src="../assets/images/vegetable/product/4.png" class="blur-up lazyload" alt="">
                    </a>

                    <div class="order-wrap">
                        <a href="product-left-thumbnail.html">
                            <h3>SnackAmor Combo Pack of Jowar Stick and Jowar Chips</h3>
                        </a>
                        <p class="text-content">The big cheese cream cheese pepper jack
                            cheese slices danish fontina everyone loves cheese on toast
                            bavarian bergkase.</p>
                        <ul class="product-size">
                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Price : </h6>
                                    <h5>$20.68</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Rate : </h6>
                                    <div class="product-rating ms-2">
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
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Sold By : </h6>
                                    <h5>Fresho</h5>
                                </div>
                            </li>

                            <li>
                                <div class="size-box">
                                    <h6 class="text-content">Quantity : </h6>
                                    <h5>250 G</h5>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('input[name="status"]').on('change', function() {
                $('#filter-form').submit();
            });
        });
    </script>
@endpush
