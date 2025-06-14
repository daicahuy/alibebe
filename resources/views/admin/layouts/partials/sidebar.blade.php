<div class="sidebar-wrapper">
    <div>
        <!-- START LOGO -->
        <div class="logo-wrapper logo-wrapper-center">
            <a href="{{ Auth::user()->isAdmin() ? route('admin.index') : route('admin.detail-index-employee') }}">
                <img alt="logo" class="img-fluid for-white"
                    src="{{ asset('theme/admin/assets/images/logo/full-white.png') }}">
            </a>
            <img alt="logo" class="img-fluid logo-sm" src="{{ asset('theme/admin/assets/images/logo/logo.png') }}">
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
                    {{-- Admin --}}
                    @if (Auth::user()->isAdmin())
                        <li class="sidebar-list">
                            <a  href="{{ route('admin.index') }}" class="debar-link link-nav sidebar-link sidebar-title">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-home-line"></i>
                                        <div class="sidebar-main-link">{{ __('message.dashboard') }}</div>
                                    </div>
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- Employee --}}
                    @if (Auth::user()->isEmployee())
                        <li class="sidebar-list">
                            <a href="{{ route('admin.index-employee') }}" class="debar-link link-nav sidebar-link sidebar-title">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-home-line"></i>
                                        <div class="sidebar-main-link">{{ __('message.dashboard') }}</div>
                                    </div>
                                </span>
                            </a>
                        </li>
                    @endif


                    @if (Auth::user()->isAdmin())
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
                    @endif
                    @if (Auth::user()->isAdmin())
                        <li class="sidebar-list">
                            <a class="debar-link link-nav sidebar-link sidebar-title">
                                <span>
                                    <div class="d-flex align-items-center"><i class="ri-store-3-line"></i>
                                        <div class="sidebar-main-link">{{ __('form.products') }}</div>
                                    </div>
                                </span>
                                <div class="according-menu">
                                    @if (Request::is('admin/products*') ||
                                            Request::is('admin/attribute*') ||
                                            Request::is('admin/brands*') ||
                                            Request::is('admin/tags*'))
                                        <i class="ri-arrow-down-s-line"></i>
                                    @else
                                        <i class="ri-arrow-right-s-line"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="sidebar-submenu" @style([
                                'display: block;' => Request::is('admin/products*') || Request::is('admin/attribute*') || Request::is('admin/brands*') || Request::is('admin/tags*'),
                            ])>
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
                    @endif
                    @if (Auth::user()->isAdmin() || Auth::user()->isEmployee())
                        <li class="sidebar-list">
                            <a class="debar-link link-nav sidebar-link sidebar-title">
                                <span>
                                    <div class="d-flex align-items-center"><i class="ri-inbox-archive-line"></i>
                                        <div class="sidebar-main-link">{{ __('form.inventory') }}</div>
                                    </div>
                                </span>
                                <div class="according-menu">
                                    @if (Request::is('admin/inventory*'))
                                        <i class="ri-arrow-down-s-line"></i>
                                    @else
                                        <i class="ri-arrow-right-s-line"></i>
                                    @endif
                                </div>
                            </a>
                            <ul class="sidebar-submenu" @style([
                                'display: block;' => Request::is('admin/inventory*'),
                            ])>
                                <li>
                                    <a href="{{ route('admin.inventory.index') }}"
                                        class="{{ Request::is('admin/inventory') ? 'active' : '' }}">
                                        <div>{{ __('form.inventory_manager') }}</div>
                                    </a>
                                    <ul class="sidebar-submenu"></ul>
                                </li>
                                <li>
                                    <a href="{{ route('admin.inventory.history') }}"
                                        class="{{ Request::is('admin/inventory/history') ? 'active' : '' }}">
                                        <div>{{ __('form.inventory_history') }}</div>
                                    </a>
                                    <ul class="sidebar-submenu"></ul>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->isAdmin() || Auth::user()->isEmployee())
                        <li class="sidebar-list">
                            <a href="{{ route('admin.orders.index') }}"
                                class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/orders*') ? 'active' : '' }}">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-article-line"></i>
                                        <div class="sidebar-main-link">{{ __('form.orders') }}</div>
                                    </div>
                                    <div class="p-2" id="div_count_order">
                                    </div>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->isAdmin() || Auth::user()->isEmployee())
                        <li class="sidebar-list">
                            <a href="{{ route('admin.orderRefund.index') }}"
                                class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/orderRefund*') ? 'active' : '' }}">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-exchange-dollar-line"></i>
                                        <div class="sidebar-main-link">Hoàn hàng</div>
                                    </div>
                                    <div class="p-2" id="div_count_order_refund">
                                    </div>
                                </span>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->isEmployee() || Auth::user()->isAdmin())
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
                                    <a href="{{ route('admin.users.customer.index') }}"
                                        class="{{ Request::is('admin/users/customer*') ? 'active' : '' }}">
                                        <div>{{ __('form.user_customer_manager') }}</div>
                                    </a>
                                    <ul class="sidebar-submenu"></ul>
                                </li>
                                @if (Auth::user()->isAdmin())
                                    <li>
                                        <a href="{{ route('admin.users.employee.index') }}"
                                            class="{{ Request::is('admin/users/employee*') ? 'active' : '' }}">
                                            <div>{{ __('form.user_employee_manager') }}</div>
                                        </a>
                                        <ul class="sidebar-submenu"></ul>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->isEmployee() || Auth::user()->isAdmin())
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
                    @endif
                    @if (Auth::user()->isAdmin())
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
                    @endif
                    @if (Auth::user()->isEmployee() || Auth::user()->isAdmin())
                        <li class="sidebar-list">
                            <a href="{{ route('admin.comments.index') }}"
                                class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/comments*') ? 'active' : '' }}">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-chat-2-line"></i>
                                        <div class="sidebar-main-link">{{ __('form.comments') }}</div>
                                    </div>
                                </span>
                            </a>
                        </li>
                    @endif
                    @php
                        use App\Models\Message;
                        use App\Enums\UserRoleType;

                        $unreadMessagesCount = Message::whereNull('read_at')
                            ->whereHas('sender', function ($query) {
                                $query->where('role', UserRoleType::CUSTOMER);
                            })
                            ->count();
                    @endphp
                    @if (Auth::user()->isEmployee() || Auth::user()->isAdmin())
                        <li class="sidebar-list">
                            <a href="{{ route('admin.chats.index') }}"
                                class="debar-link link-nav sidebar-link sidebar-title {{ Request::is('admin/chats*') ? 'active' : '' }}">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-mail-line"></i>
                                        <div class="sidebar-main-link">{{ __('form.messages') }}</div>
                                    </div>
                                    <span class="badge bg-warning ml-2">{{ $unreadMessagesCount }}</span>
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR MAIN -->
    </div>
</div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    $(document).ready(function() {

        function updateCountOrder(count) {
            $("#div_count_order").empty();

            if (count > 0) {
                $("#div_count_order").append(`
                <span class="badge bg-warning ml-2" id="">${count}</span>

                `)
            }
        }

        function fetchPendingOrderCount() {
            $.ajax({
                url: '{{ route('api.orders.countPending') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    updateCountOrder(data.count);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching pending order count:', error);
                }
            });
        }

        function updateCountOrderRefund(count) {
            $("#div_count_order_refund").empty();

            if (count > 0) {
                $("#div_count_order_refund").append(`
                <span class="badge bg-warning ml-2" id="">${count}</span>

                `)
            }
        }

        function fetchPendingOrderRefundCount() {
            $.ajax({
                url: '{{ route('api.refund_orders.countPending') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    updateCountOrderRefund(data.count);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching pending order count:', error);
                }
            });
        }

        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('order-pending-count');
        channel.bind('pending-count-updated', function(data) {
            updateCountOrder(data.count)
        });
        var channel2 = pusher.subscribe('order-refund-pending-count');
        channel2.bind('order-refund-pending-count-updated', function(data) {
            updateCountOrderRefund(data.count)
        });


        fetchPendingOrderCount();
        fetchPendingOrderRefundCount();


    })
</script>
