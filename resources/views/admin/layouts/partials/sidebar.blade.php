<div class="sidebar-wrapper">
    <div>
        <!-- START LOGO -->
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
        <!-- END LOGO -->

        <!-- START SIDEBAR MAIN -->
        <nav class="sidebar-main">
            <div id="left-arrow" class="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul id="simple-bar" class="sidebar-links">
                    <li class="back-btn"></li>
                    <li class="sidebar-list">
                        <a href="{{ route('admin.index') }}"
                            class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin') ? 'active' : '' }}">
                            <span>
                                <div class="d-flex align-items-center">
                                    <i class="ri-home-line"></i>
                                    <div class="sidebar-main-link">{{ __('message.dashboard') }}</div>
                                </div>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{ route('admin.categories.index') }}"
                            class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/categories*') ? 'active' : '' }}">
                            <span>
                                <div class="d-flex align-items-center">
                                    <i class="ri-list-unordered"></i>
                                    <div class="sidebar-main-link">{{ __('form.categories') }}</div>
                                </div>
                            </span>
                        </a>
                        <ul class="sidebar-submenu"></ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="debar-link link-nav sidebar-link sidebar-title">
                            <span>
                                <div class="d-flex align-items-center"><i class="ri-store-3-line"></i>
                                    <div class="sidebar-main-link">{{ __('form.products') }}</div>
                                </div>
                            </span>
                            <div class="according-menu">
                                @if (Request::is('admin/products*') || Request::is('admin/attribute*') || Request::is('admin/brands*') || Request::is('admin/tags*'))
                                    <i class="ri-arrow-down-s-line"></i>
                                @else
                                    <i class="ri-arrow-right-s-line"></i>
                                @endif
                            </div>
                        </a>
                        <ul class="sidebar-submenu" @style(['display: block;' => Request::is('admin/products*') || Request::is('admin/attribute*') || Request::is('admin/brands*') || Request::is('admin/tags*')])>
                            <li>
                                <a href="{{ route('admin.products.index') }}"
                                    class="{{ Request::is('admin/products*') ? 'active' : '' }}">
                                    <div>{{ __('form.product_manager') }}</div>
                                    {{-- <span class="badge bg-warning ml-3 text-dark"> 2 </span> --}}
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.attributes.index') }}"
                                    class="{{ Request::is('admin/attribute*') ? 'active' : '' }}">
                                    <div>{{ __('form.attributes') }}</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.brands.index') }}"
                                    class="{{ Request::is('admin/brands*') ? 'active' : '' }}">
                                    <div>{{ __('form.brands') }}</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.tags.index') }}"
                                    class="{{ Request::is('admin/tags*') ? 'active' : '' }}">
                                    <div>{{ __('form.tags') }}</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{ route('admin.orders.index') }}"
                            class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/orders*') ? 'active' : '' }}">
                            <span>
                                <div class="d-flex align-items-center">
                                    <i class="ri-article-line"></i>
                                    <div class="sidebar-main-link">{{ __('form.orders') }}</div>
                                </div>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="debar-link link-nav sidebar-link sidebar-title">
                            <span>
                                <div class="d-flex align-items-center"><i class="ri-contacts-line"></i>
                                    <div class="sidebar-main-link">{{ __('form.users') }}</div>
                                </div>
                            </span>
                            <div class="according-menu">
                                @if (Request::is('admin/users*'))
                                    <i class="ri-arrow-down-s-line"></i>
                                @else
                                    <i class="ri-arrow-right-s-line"></i>
                                @endif
                            </div>
                        </a>
                        <ul class="sidebar-submenu" @style(['display: block;' => Request::is('admin/users*')])>
                            <li>
                                <a href="{{ route('admin.users.customer.index') }}" class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                                    <div>{{ __('form.user_manager') }}</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.employee.index') }}" class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                                    <div>{{ __('form.user_staff') }}</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li>
                            {{-- <li>
                                <a href="/fastkart-admin/role">
                                    <div>Role</div>
                                </a>
                                <ul class="sidebar-submenu"></ul>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{ route('admin.reviews.index') }}"
                            class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/reviews*') ? 'active' : '' }}">
                            <span>
                                <div class="d-flex align-items-center">
                                    <i class="ri-star-line"></i>
                                    <div class="sidebar-main-link">{{ __('form.reviews') }}</div>
                                </div>
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a href="{{ route('admin.coupons.index') }}"
                            class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/coupons*') ? 'active' : '' }}">
                            <span>
                                <div class="d-flex align-items-center">
                                    <i class="ri-coupon-2-line"></i>
                                    <div class="sidebar-main-link">{{ __('form.coupons') }}</div>
                                </div>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR MAIN -->
    </div>
</div>
