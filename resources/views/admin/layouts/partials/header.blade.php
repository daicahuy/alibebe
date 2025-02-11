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
                <li>
                    <span class="header-search"><i class="ri-search-line"></i></span>
                </li>
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
                            <div>
                                <i class="ri-notification-line"></i>
                            </div>
                        </div>
                        <ul class="notification-dropdown onhover-show-div">
                            <li>
                                <i class="ri-notification-line"></i>
                                <h6 class="f-18 mb-0">Notifications</h6>
                            </li>
                            <li>
                                <p>
                                    <i class="ri-record-circle-line me-2 txt-primary"></i>
                                    A refund request has been rece...
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="ri-record-circle-line me-2 txt-primary"></i>
                                    A refund request has been rece...
                                </p>
                            </li>
                            <li>
                                <p>
                                    <i class="ri-record-circle-line me-2 txt-primary"></i>
                                    A refund request has been rece...
                                </p>
                            </li>
                            <li>
                                <a class="btn btn-theme" href="/fastkart-admin/notification">
                                    Check All Notification
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <div class="mode"><i class="ri-moon-line"></i></div>
                </li>
                <li class="profile-nav onhover-dropdown pe-0 me-0">
                    <div class="media profile-media">
                        <div class="profile-img">
                            <div class="user-round"><h4>S</h4></div>
                        </div>
                        <div class="user-name-hide media-body">
                            <span>Super Admin</span>
                            <p class="mb-0 font-roboto">
                                admin <i class="middle ri-arrow-down-s-line"></i>
                            </p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a href="/fastkart-admin/account">
                                <i class="ri-user-line"></i>
                                <span>My Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('auth.admin.logout')}}">
                                <i class="ri-logout-box-line"></i>
                                <span>Log out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
