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
                                style="
                                display: inline-block;
                                width: 100px; /* Điều chỉnh kích thước phù hợp */
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;">
                                {{ $user->fullname }}
                            </span>

                            <p class="mb-0 font-roboto">
                                admin <i class="middle ri-arrow-down-s-line"></i>
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

        // Khởi tạo Pusher
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

        // Đăng ký kênh
        const couponChannel = pusher.subscribe('coupon-notification');
        const orderChannel = pusher.subscribe('admin-notifications');

        // Xử lý sự kiện coupon
        couponChannel.bind('event-coupon', function(data) {
            handleNotification(data, 'coupon');
        });

        // Xử lý sự kiện order
        orderChannel.bind('new-order-customer', function(data) {
            handleNotification(data, 'order');
        });

        // Xử lý sự kiện realtime từ Pusher
        function handleNotification(data, type) {
            const currentCount = parseInt($('.unread-count').text()) || 0;
            $('.unread-count').text(currentCount + 1).show();

            const $notificationList = $('#notification-list');
            const newNotificationHTML = renderNotificationItem(data, type);
            $notificationList.find('li:first').after(newNotificationHTML);

            if ($('#notificationOffcanvas').hasClass('show')) {
                const offcanvasHTML = renderNotificationOffcanvasItem(data, type);
                $('#notification-offcanvas-list').prepend(offcanvasHTML);
            }

            showNewNotificationAlert(data);
        }

        // Hiển thị thông báo dạng alert
        function showNewNotificationAlert(data) {
            Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: data.message,
                showConfirmButton: false,
                timer: 5000,
                toast: true,
                position: 'top-end',
            });
        }

        // Render HTML cho notification item trong dropdown
        function renderNotificationItem(data, type) {
            let icon = 'ri-record-circle-line';
            let content = data.message || '';

            if (type == 'coupon') {
                icon = 'ri-coupon-line';
                content += ` <small class="text-muted">(${data.coupon.code})</small>`;
            } else if (type == 'order') {
                icon = 'ri-shopping-basket-line';
                content += ` <small class="text-muted">(${data.order.code})</small>`;
            }

            return `
            <li class="notification-item" data-id="${data.id}">
                <p>
                    <i class="${icon} me-2 txt-primary"></i>
                    ${content}
                </p>
            </li>
        `;
        }

        // Định dạng tiền tệ
        function formatCurrency(amount) {
            if (!amount && amount !== 0) return '0 đ';
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        }

        // Render HTML cho thông báo trong offcanvas
        function renderNotificationOffcanvasItem(notifi, type) {
            console.log(notifi, type);
            let details = '';
            const readClass = notifi.read ? 'notification-read' : 'notification-unread';

            if (type === 'coupon') {
                const discount_type = notifi.coupon.discount_type == 0 ? 'Giá Cố Định' : 'Phần Trăm';
                details = `
                <div class="coupon-details mt-2">
                     <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Mã code:</small>
                            <p class="mb-1 fw-bold">${notifi.coupon.code}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Hết hạn:</small>
                            <p class="mb-1">
                                ${notifi.coupon.end_date ? new Date(notifi.coupon.end_date).toLocaleDateString() : 'Không'}
                            </p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Đã dùng:</small>
                            <p class="mb-1">${notifi.coupon.usage_count}/${notifi.coupon.usage_limit}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Loại:</small>
                            <p class="mb-1">${discount_type}</p>
                        </div>
                    </div>
                </div>
            `;
            } else if (type === 'order') {
                details = `
                <div class="order-details mt-2">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Mã đơn:</small>
                            <p class="mb-1 fw-bold">${notifi.order.code}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Tổng tiền:</small>
                            <p class="mb-1">${formatCurrency(notifi.order.total_amount)}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Người đặt:</small>
                            <p class="mb-1 fw-bold">${notifi.order.fullname}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Số Điện Thoại:</small>
                            <p class="mb-1">${notifi.order.phone_number}</p>
                        </div>
                    </div>
                </div>
            `;
            }

            return `
            <div class="notification-item mb-2 p-2 border rounded ${readClass}" data-id="${notifi.id}">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="mb-1">${notifi.message || ''}</p>
                        ${details}
                    </div>
                    <button class="btn btn-sm btn-danger delete-notifi" data-id="${notifi.id}">Xóa</button>
                </div>
            </div>
        `;
        }

        // Load danh sách thông báo từ API
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
                success: function(response) {
                    var notifications = response.notifications && response.notifications.data ?
                        response.notifications.data :
                        (Array.isArray(response) ? response : []);

                    console.log(notifications);

                    // Cập nhật số lượng thông báo chưa đọc
                    if (response.unread_count !== undefined) {
                        $('.unread-count').text(response.unread_count);
                        if (response.unread_count == 0) {
                            $('.unread-count').hide();
                        } else {
                            $('.unread-count').show();
                        }
                    }

                    var $notificationList = $('#notification-list');
                    // Xóa các thông báo cũ (giữ lại header và nút "Check All")
                    $notificationList.find('li.notification-item').remove();

                    // Thêm các thông báo mới
                    if (notifications.length > 0) {
                        for (var i = 0; i < notifications.length; i++) {
                            // Xác định kiểu thông báo dựa trên dữ liệu
                            var type = notifications[i].type == 0 ? 'coupon' : 'order';
                            var notificationHTML = renderNotificationItem(notifications[i], type);

                            // Thêm vào trước nút "Check All Notification"
                            var $checkAllBtn = $notificationList.find('li:last');
                            $(notificationHTML).insertBefore($checkAllBtn);
                        }
                    } else {
                        // Thêm thông báo "Không có thông báo" nếu danh sách trống
                        var $checkAllBtn = $notificationList.find('li:last');
                        $('<li class="notification-item"><p>Không có thông báo nào!</p></li>')
                            .insertBefore($checkAllBtn);
                    }
                    7
                },
                error: function(err) {
                    console.error('Error loading notifications:', err);
                }
            });
        }

        // Load danh sách thông báo cho offcanvas
        function loadNotificationsOffcanvas() {
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                data: {
                    user_id: window.currentUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    var notifications = response.notifications && response.notifications.data ?
                        response.notifications.data :
                        (Array.isArray(response) ? response : []);

                    var $offcanvasList = $('#notification-offcanvas-list');

                    if (notifications.length === 0) {
                        $offcanvasList.html('<p>Không có thông báo nào!</p>');
                    } else {
                        $offcanvasList.empty();
                        for (var i = 0; i < notifications.length; i++) {
                            // Xác định kiểu thông báo dựa trên dữ liệu
                            var type = notifications[i].type == 0 ? 'coupon' : 'order';
                            var offcanvasHTML = renderNotificationOffcanvasItem(notifications[i],
                                type);
                            $offcanvasList.append(offcanvasHTML);
                        }

                        // Gắn sự kiện xóa cho các nút xóa
                        $offcanvasList.find('.delete-notifi').on('click', function() {
                            var id = $(this).data('id');
                            deleteNotification(id);
                        });
                    }
                },
                error: function(err) {
                    console.error('Error loading offcanvas notifications:', err);
                }
            });
        }

        // Xóa thông báo
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
                success: function(response) {
                    loadNotifications();
                    loadNotificationsOffcanvas();
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Xóa Thành Công Thông Báo Này!',
                        timer: 2000
                    });
                },
                error: function(err) {
                    console.error("Error deleting notification:", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: 'Có lỗi xảy ra!',
                        timer: 2000
                    });
                }
            });
        }

        // Đánh dấu thông báo đã đọc
        function markNotificationAsRead(notificationId, $element) {
            $.ajax({
                url: '/api/notifications/' + notificationId + '/read',
                method: 'PATCH',
                data: {
                    user_id: window.currentUserId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $element.removeClass('notification-unread').addClass('notification-read');

                    if (response.unread_count !== undefined) {
                        $('.unread-count').text(response.unread_count);
                        if (response.unread_count == 0) {
                            $('.unread-count').hide();
                        }
                    }
                },
                error: function(err) {
                    console.error("Error marking notification as read:", err);
                }
            });
        }

        // Gọi load notifications ban đầu
        loadNotifications();

        // Mở offcanvas khi nhấn nút "Check All Notification"
        $('#open-notification-offcanvas').on('click', function(e) {
            e.preventDefault();
            loadNotificationsOffcanvas();
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById(
                'notificationOffcanvas'), {
                backdrop: false // Tắt backdrop
            });
            myOffcanvas.show();
        });

        // Sự kiện click vào thông báo
        $(document).on('click', '.notification-item', function() {
            const notificationId = $(this).data('id');
            if (notificationId) {
                markNotificationAsRead(notificationId, $(this));
            }
        });
    });
</script>
