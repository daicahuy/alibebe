<style>
    .notification-unread {
        background-color: #f0f8ff;
        font-weight: bold;
    }

    .notification-read {
        background-color: #ffffff;
    }
</style>
<div class="page-header">
    <div class="header-wrapper m-0">
        <div class="header-logo-wrapper p-0">
            <div checked="checked" class="toggle-sidebar">
                <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
                <a href="{{ Auth::user()->isAdmin() ? route('admin.index') : route('admin.detail-index-employee') }}">
                    <img alt="header-logo" class="img-fluid" src="{{ asset('theme/admin/assets/images/logo/1.png') }}">
                </a>
            </div>
        </div>
        <form novalidate="" class="form-inline search-full ng-untouched ng-pristine ng-valid">
            <div class="form-group w-100">
                <input type="text" autocomplete="off"
                    class="demo-input Typeahead-input form-control-plaintext w-100 ng-untouched ng-pristine ng-valid"
                    placeholder="Tìm kiếm...">
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
                {{-- <li>
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
                </li> --}}
                <li>
                    <div class="onhover-dropdown">
                        <div class="notification-box">
                            <div>
                                <i class="ri-notification-line"></i>
                                <span class="badge bg-danger unread-count"></span>
                            </div>
                        </div>
                        <!-- Notification Dropdown -->
                        <ul id="notification-list" class="notification-dropdown onhover-show-div">
                            <li>
                                <i class="ri-notification-line"></i>
                                <h6 class="f-18 mb-0">Notifications</h6>
                            </li>
                            <li>
                                <a class="btn btn-theme" href="#" id="open-notification-offcanvas">
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
                            <div class="user-round">
                                <img src="{{ Storage::url($user->avatar) }}" alt="avatar"
                                    style="width: 50px; height: 40px; border-radius: 50%; object-fit: cover;">
                            </div>
                        </div>

                        <div class="user-name-hide media-body">
                            <span
                                style="display: inline-block; width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $user->fullname }}
                            </span>

                            <p class="mb-0 font-roboto">
                                {{ $user->isAdmin() ? 'Admin' : 'Nhân Viên' }} <i
                                    class="middle ri-arrow-down-s-line"></i>
                            </p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a href="{{ route('admin.account.index') }}">
                                <i class="ri-user-line"></i>
                                <span>Tài khoản của tôi</span>
                            </a>
                        </li>
                        <li>
                            <a onclick="return confirm('Bạn muốn đăng xuất?')" href="{{ route('auth.admin.logout') }}">
                                <i class="ri-logout-box-line"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="notificationOffcanvas"
    aria-labelledby="notificationOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="notificationOffcanvasLabel">Danh sách thông báo</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="notification-offcanvas-list">
            <!-- Danh sách thông báo chi tiết sẽ được load ở đây -->
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    $(document).ready(function() {
        window.currentUserId = "{{ auth()->id() }}";
        const MAX_NOTIFICATION = 5;

        // Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            }
        });
        const couponChannel = pusher.subscribe('coupon-notification');
        const orderChannel = pusher.subscribe('admin-notifications');
        const systemChannel = pusher.subscribe('system-notification.' + window.currentUserId);

        couponChannel.bind('event-coupon', data => handleNotification(data, 'coupon'));
        orderChannel.bind('new-order-customer', data => handleNotification(data, 'order'));
        systemChannel.bind('event-system', data => handleNotification(data, 'system'));

        function handleNotification(data, type) {
            const count = parseInt($('.unread-count').text()) || 0;
            $('.unread-count').text(count + 1).show();
            // Dropdown update
            const $list = $('#notification-list');
            $list.find('li.notification-item:last').before(renderNotificationItem(data, type));
            let items = $list.find('li.notification-item');
            if (items.length > MAX_NOTIFICATION) items.last().remove();
            // Offcanvas update
            if ($('#notificationOffcanvas').hasClass('show')) {
                prependOffcanvasItem(data, type);
            }
            showAlert(data.message);
        }

        function showAlert(msg) {
            Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: msg,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000
            });
        }

        function renderNotificationItem(data, type) {
            let icon = 'ri-record-circle-line',
                content = data.message || '';
            const readClass = data.read ? 'notification-read' : 'notification-unread';

            if (type === 'coupon') {
                icon = 'ri-coupon-line';
                content += ` <small class="text-muted">(${data.coupon.code})</small>`;
            } else if (type === 'order') {
                icon = 'ri-shopping-basket-line';
                content += ` <small class="text-muted">(${data.order.code})</small>`;
            } else if (type === 'system') {
                icon = 'ri-shield-user-line';
                content += ` <small class="text-muted">(Hệ thống)</small>`;
            }

            return `<li class="notification-item ${readClass}" data-id="${data.id}">` +
                `<p><i class="${icon} me-2 txt-primary"></i>${content}</p></li>`;
        }

        function prependOffcanvasItem(data, type) {
            $('#notification-offcanvas-list').prepend(renderNotificationOffcanvasItem(data, type));
        }

        function formatCurrency(a) {
            if (a == null) return '0 đ';
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(a);
        }

        function renderNotificationOffcanvasItem(d, type) {
            let details = '',
                readClass = d.read ? 'notification-read' : 'notification-unread';

            if (type === 'coupon') {
                const c = d.coupon,
                    dt = c.discount_type == 0 ? 'Giá Cố Định' : 'Phần Trăm';
                details = `<div class="coupon-details mt-2">` +
                    `<div class="row">` +
                    `<div class="col-6"><small class="text-muted">Mã code:</small><p class="mb-1 fw-bold">${c.code}</p></div>` +
                    `<div class="col-6"><small class="text-muted">Hết hạn:</small><p class="mb-1">${c.end_date ? new Date(c.end_date).toLocaleDateString() : 'Không'}</p></div>` +
                    `<div class="col-6"><small class="text-muted">Đã dùng:</small><p class="mb-1">${c.usage_count}/${c.usage_limit}</p></div>` +
                    `<div class="col-6"><small class="text-muted">Loại:</small><p class="mb-1">${dt}</p></div>` +
                    `</div></div>`;
            } else if (type === 'order') {
                const o = d.order;
                details = `<div class="order-details mt-2">` +
                    `<div class="row">` +
                    `<div class="col-6"><small class="text-muted">Mã đơn:</small><p class="mb-1 fw-bold">${o.code}</p></div>` +
                    `<div class="col-6"><small class="text-muted">Tổng tiền:</small><p class="mb-1">${formatCurrency(o.total_amount)}</p></div>` +
                    `<div class="col-6"><small class="text-muted">Người đặt:</small><p class="mb-1 fw-bold">${o.fullname}</p></div>` +
                    `<div class="col-6"><small class="text-muted">SĐT:</small><p class="mb-1">${o.phone_number}</p></div>` +
                    `</div></div>`;
            } else if (type === 'system') {
                details = `<div class="system-details mt-2">` +
                    `<small class="text-muted">${d.message} :</small> <span>${d.target_user.id}</span>` +
                    `<a href="http://127.0.0.1:8000/admin/users/customer/lock" target="_blank">Xem</a>` +
                    `</div>`;
            }

            return `<div class="notification-item mb-2 p-2 border rounded ${readClass}" data-id="${d.id}">` +
                `<div class="d-flex justify-content-between align-items-start">` +
                `<div class="flex-grow-1"><p class="mb-1">${d.message}</p>${details}</div>` +
                `<button class="btn btn-sm btn-danger delete-notifi" data-id="${d.id}">Xóa</button>` +
                `</div></div>`;
        }

        // Dropdown load
        function loadNotifications() {
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                data: {
                    user_id: window.currentUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(r) {
                    let items = r.notifications.data || [];
                    if (r.unread_count !== undefined)
                        $('.unread-count').text(r.unread_count).toggle(!!r.unread_count);
                    items = items.slice(0, MAX_NOTIFICATION);
                    const $l = $('#notification-list');
                    $l.find('li.notification-item').remove();
                    if (items.length)
                        items.forEach(i => $l.find('li:last').before(
                            renderNotificationItem(i, i.type == 2 ? 'system' : (i.type == 0 ?
                                'coupon' : 'order'))
                        ));
                    else
                        $l.find('li:last').before(
                            '<li class="notification-item"><p>Không có thông báo nào!</p></li>');
                }
            });
        }

        // Offcanvas load với pagination
        let offPage = 1,
            offPer = 5,
            offLoad = false;

        function loadNotificationsOffcanvas(reset = false) {
            if (offLoad) return;
            offLoad = true;
            if (reset) {
                offPage = 1;
                $('#notification-offcanvas-list').empty();
            }
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                data: {
                    user_id: window.currentUserId,
                    page: offPage,
                    per_page: offPer
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(r) {
                    const items = r.notifications.data || [];
                    if (!items.length && offPage === 1)
                        $('#notification-offcanvas-list').html('<p>Không có thông báo nào!</p>');
                    else
                        items.forEach(i => $('#notification-offcanvas-list').append(
                            renderNotificationOffcanvasItem(i, i.type == 2 ? 'system' : (i
                                .type == 0 ? 'coupon' : 'order'))
                        ));
                    // Pagination controls
                    $('#offcanvas-pagination').remove();
                    if (r.notifications.last_page > 1) {
                        $('#notification-offcanvas-list').append(`
                            <div id="offcanvas-pagination" class="d-flex justify-content-between align-items-center px-2 my-2">
                                <button id="off-prev" class="btn btn-sm btn-link" ${offPage<=1?'disabled':''}>Prev</button>
                                <span>Trang ${offPage}/${r.notifications.last_page}</span>
                                <button id="off-next" class="btn btn-sm btn-link" ${offPage>=r.notifications.last_page?'disabled':''}>Next</button>
                            </div>
                        `);
                    }
                    $('.delete-notifi').off('click').on('click', function() {
                        deleteNotification($(this).data('id'));
                    });
                    offLoad = false;
                },
                error: function() {
                    offLoad = false;
                }
            });
        }
        $(document).on('click', '#off-prev', () => {
            if (offPage > 1) {
                offPage--;
                loadNotificationsOffcanvas();
            }
        });
        $(document).on('click', '#off-next', () => {
            offPage++;
            loadNotificationsOffcanvas();
        });

        function deleteNotification(id) {
            $.ajax({
                url: '/api/notifications/' + id,
                method: 'DELETE',
                data: {
                    user_id: window.currentUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    loadNotifications();
                    loadNotificationsOffcanvas(true);
                    Swal.fire({
                        icon: 'success',
                        title: 'Đã xóa',
                        timer: 2000
                    });
                }
            });
        }

        function markRead(i, e) {
            $.ajax({
                url: '/api/notifications/' + i + '/read',
                method: 'PATCH',
                data: {
                    user_id: window.currentUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(r) {
                    e.removeClass('notification-unread').addClass('notification-read');
                    if (r.unread_count !== undefined) $('.unread-count').text(r.unread_count)
                        .toggle(!!r.unread_count);
                }
            });
        }

        // Init
        loadNotifications();
        loadNotificationsOffcanvas(true);
        $('#open-notification-offcanvas').on('click', function(e) {
            e.preventDefault();
            loadNotificationsOffcanvas(true);
            new bootstrap.Offcanvas($('#notificationOffcanvas')[0], {
                backdrop: false
            }).show();
        });
        $(document).on('click', '.notification-item', function() {
            const id = $(this).data('id');
            if (id) markRead(id, $(this));
        });
    });
</script>
