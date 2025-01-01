<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Fastkart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, Fastkart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('') }}/theme/admin/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('') }}/theme/admin/assets/images/favicon.png" type="image/x-icon">
    <title>Fastkart - Dashboard</title>

    <!-- Remixicon CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/remixicon.css') }}">

    <!-- Feather Icon css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/vendors/feather-icon.css') }}">

    @stack('css_library')

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/style2.css') }}">

    @stack('css')

</head>

<body>

<div id="pageWrapper" class="page-wrapper compact-wrapper">
    <div class="page-header">
        <div class="header-wrapper m-0">
            <div class="header-logo-wrapper p-0">
                <div checked="checked" class="toggle-sidebar">
                    <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                    <a href="/fastkart-admin/dashboard">
                        <img alt="header-logo" class="img-fluid"
                             src="https://laravel.pixelstrap.net/fastkart/storage/4/logo-dark.png">
                    </a>
                </div>
            </div>
            <form novalidate="" class="form-inline search-full ng-untouched ng-pristine ng-valid">
                <div class="form-group w-100">
                    <input type="text" autocomplete="off"
                           class="demo-input Typeahead-input form-control-plaintext w-100 ng-untouched ng-pristine ng-valid"
                           placeholder="Search Fastkart ..">
                    <i class="ri-close-line close-icon"></i>
                </div>
                <div class="onhover-dropdown">
                    <ul></ul>
                </div>
            </form>
            <div class="nav-right right-header p-0">
                <ul class="nav-menus">
                    <li><span class="header-search"><i class="ri-search-line"></i></span></li>
                    <li>
                        <div class="profile-nav onhover-dropdown translate-btn p-0">
                            <div class="media profile-media">
                                <button class="btn dropdown-toggle p-0" id="translate_btn" type="submit">
                                    <div><i class="ri-translate-2"></i></div>
                                </button>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-i">
                                        <div class="iti-flag us"></div>
                                        <span>English</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="dropdown-i">
                                        <div class="fr iti-flag"></div>
                                        <span>Français</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="onhover-dropdown">
                            <div class="notification-box">
                                <div><i class="ri-notification-line"></i></div>
                            </div>
                            <ul class="notification-dropdown onhover-show-div">
                                <li>
                                    <i class="ri-notification-line"></i>
                                    <h6 class="f-18 mb-0">Notifications</h6>
                                </li>
                                <li>
                                    <p><i class="ri-record-circle-line me-2 txt-primary"></i> A refund request has been
                                        rece... </p>
                                </li>
                                <li>
                                    <p><i class="ri-record-circle-line me-2 txt-primary"></i> A refund request has been
                                        rece... </p>
                                </li>
                                <li>
                                    <p><i class="ri-record-circle-line me-2 txt-primary"></i> A refund request has been
                                        rece... </p>
                                </li>
                                <li>
                                    <a class="btn btn-theme" href="/fastkart-admin/notification"> Check All Notification
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <li class="profile-nav onhover-dropdown pe-0 me-0">
                        <div class="media profile-media">
                            <div class="profile-img">
                                <div class="user-round">
                                    <h4>S</h4>
                                </div>
                            </div>
                            <div class="user-name-hide media-body"><span>Super Admin</span>
                                <p class="mb-0 font-roboto">
                                    admin
                                    <i class="middle ri-arrow-down-s-line"></i>
                                </p>
                            </div>
                        </div>
                        <ul class="profile-dropdown onhover-show-div">
                            <li>
                                <a href="/fastkart-admin/account">
                                    <i class="ri-user-line"></i><span>
                                            My Account</span></a>
                            </li>
                            <li>
                                <a><i class="ri-logout-box-line"></i><span>Log out</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-body-wrapper">
        <div class="sidebar-wrapper">
            <div>
                <div class="logo-wrapper logo-wrapper-center">
                    <a href="/fastkart-admin/dashboard">
                        <img alt="logo" class="img-fluid for-white"
                             src="https://laravel.pixelstrap.net/fastkart/storage/3/logo-white.png">
                    </a>
                    <img alt="logo" class="img-fluid logo-sm"
                         src="https://laravel.pixelstrap.net/fastkart/storage/5/tiny-logo.png">
                    <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                    <div class="toggle-sidebar">
                        <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                    </div>
                </div>
                <nav class="sidebar-main">
                    <div id="left-arrow" class="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="sidebar-menu">
                        <ul id="simple-bar" class="sidebar-links">
                            <li class="back-btn"></li>
                            <li class="sidebar-list">
                                <a href="/fastkart-admin/dashboard" class="debar-link link-nav sidebar-link sidebar-title">
                                    <span>
                                        <div class="d-flex align-items-center">
                                            <i class="ri-home-line"></i>
                                            <div class="sidebar-main-link">Dashboard</div>
                                        </div>
                                    </span>
                                </a>
                            </li>
                            <li class="sidebar-list">
                                <a class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center"><i class="ri-contacts-line"></i>
                                                <div class="sidebar-main-link">Users</div>
                                            </div>
                                        </span>
                                    <div class="according-menu"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a href="/fastkart-admin/user/create">
                                            <div>Add User</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/user">
                                            <div>All Users</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/role">
                                            <div>Role</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><a class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center"><i class="ri-store-3-line"></i>
                                                <div class="sidebar-main-link">Products</div>
                                            </div>
                                        </span>
                                    <div class="according-menu"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a href="/fastkart-admin/product/create">
                                            <div>Add Product</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/product">
                                            <div>All Products</div>
                                            <span class="badge bg-warning ml-3 text-dark"> 2
                                                </span>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/attribute">
                                            <div>Attributes</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/category">
                                            <div>Categories</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/tag">
                                            <div>Tags</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/qna">
                                            <div>Q&amp;A</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <a class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center"><i class="ri-store-2-line"></i>
                                                <div class="sidebar-main-link">Stores</div>
                                            </div>
                                        </span>
                                    <div class="according-menu"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a href="/fastkart-admin/store/create">
                                            <div>Add Store</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/store">
                                            <div>All Stores</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/vendor-wallet">
                                            <div>Wallet</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/commission">
                                            <div>Commission History</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/payment-details">
                                            <div>Payout Details</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/withdrawal">
                                            <div>Withdrawal</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-list"><a class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-list-unordered"></i>
                                                <div class="sidebar-main-link">Orders</div>
                                            </div>
                                        </span>
                                    <div class="according-menu"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a href="/fastkart-admin/order">
                                            <div>All Orders</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/order/create">
                                            <div>Create Order</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-list">
                                <a href="/fastkart-admin/media" class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center"><i class="ri-image-line"></i>
                                                <div class="sidebar-main-link">Media</div>
                                            </div>
                                        </span>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            <li class="sidebar-list">
                                <a class="debar-link link-nav sidebar-link sidebar-title">
                                        <span>
                                            <div class="d-flex align-items-center">
                                                <i class="ri-article-line"></i>
                                                <div class="sidebar-main-link">Blog</div>
                                            </div>
                                        </span>
                                    <div class="according-menu"><i class="ri-arrow-right-s-line"></i></div>
                                </a>
                                <ul class="sidebar-submenu">
                                    <li>
                                        <a href="/fastkart-admin/blog">
                                            <div>All Blogs</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/blog/category">
                                            <div>Categories</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                    <li>
                                        <a href="/fastkart-admin/blog/tag">
                                            <div>Tags</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="page-body">
            <div class="container-fuild">
                @yield('content')
            </div>
        </div>
    </div>
</div>

{{--<!-- latest js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/jquery-3.6.0.min.js') }}"></script>--}}

{{--<!-- Bootstrap js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>--}}

{{--<!-- Simplebar js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/scrollbar/simplebar.js') }}"></script>--}}
{{--<script src="{{ asset('theme/admin/assets/js/scrollbar/custom.js') }}"></script>--}}
{{--<script src="{{ asset('theme/admin/assets/js/config.js') }}"></script>--}}

{{--<!-- Sidebar effect -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/sidebareffect.js') }}"></script>--}}

{{--<!-- tooltip init js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/tooltip-init.js') }}"></script>--}}

{{--<!-- Plugins JS -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/sidebar-menu.js') }}"></script>--}}

{{--<!-- Slick Slider js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/slick.min.js') }}"></script>--}}
{{--<script src="{{ asset('theme/admin/assets/js/custom-slick.js') }}"></script>--}}

{{--<!-- Ratio js -->--}}
{{--<script src="{{ asset('theme/admin/assets/js/ratio.js') }}"></script>--}}

<!-- latest js -->
<script src="/theme/admin/assets/js/jquery-3.6.0.min.js"></script>

<!-- Bootstrap js -->
<script src="/theme/admin/assets/js/bootstrap/bootstrap.bundle.min.js"></script>

<!-- feather icon js -->
<script src="/theme/admin/assets/js/icons/feather-icon/feather.min.js"></script>
<script src="/theme/admin/assets/js/icons/feather-icon/feather-icon.js"></script>

<!-- scrollbar simplebar js -->
<script src="/theme/admin/assets/js/scrollbar/simplebar.js"></script>
<script src="/theme/admin/assets/js/scrollbar/custom.js"></script>

<!-- Sidebar jquery -->
<script src="/theme/admin/assets/js/config.js"></script>

<!-- tooltip init js -->
<script src="/theme/admin/assets/js/tooltip-init.js"></script>

<!-- Plugins JS -->
<script src="/theme/admin/assets/js/sidebar-menu.js"></script>
{{--<script src="/theme/admin/assets/js/notify/bootstrap-notify.min.js"></script>--}}
{{-- <script src="/theme/admin/assets/js/notify/index.js"></script> --}}

<!-- slick slider js -->
<script src="/theme/admin/assets/js/slick.min.js"></script>
<script src="/theme/admin/assets/js/custom-slick.js"></script>

<!-- customizer js -->
<script src="/theme/admin/assets/js/customizer.js"></script>

@stack('js_library')

@stack('js')

</body>

</html>
