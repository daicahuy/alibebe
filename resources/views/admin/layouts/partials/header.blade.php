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
                <a href="{{ route('admin.index') }}">
                    <img alt="header-logo" class="img-fluid"
                        src="{{ asset('theme/admin/assets/images/logo/1.png') }}">
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
                                style="
                                display: inline-block;
                                width: 100px; /* Điều chỉnh kích thước phù hợp */
                                white-space: nowrap;
                                overflow: hidden;
                                text-overflow: ellipsis;">
                                {{ $user->fullname }}
                            </span>

                            <p class="mb-0 font-roboto">
                                {{ $user->isAdmin() ? 'Admin' : 'Nhân Viên' }} <i class="middle ri-arrow-down-s-line"></i>
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
    Pusher.logToConsole = true;

    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').textContent
            }
        }
    });

    $(document).ready(function() {
        window.currentUserId = "{{ auth()->id() }}";

        const channel = pusher.subscribe('coupon-notification');
        console.log("===== Start Channel =====");
        console.log(channel);
        console.log("===== End Channel =====");

        // Xử lý sự kiện realtime từ Pusher
        channel.bind('event-coupon', function(data) {
            const currentCount = parseInt($('.unread-count').text()) || 0;
            $('.unread-count').text(currentCount + 1).show();

            if (data.coupon) {
                console.log("Coupon data received:", data.coupon);
            } else {
                console.warn("Coupon data is undefined");
            }

            // Thêm thông báo mới vào đầu danh sách
            const $notificationList = $('#notification-list');
            const newNotificationHTML = renderNotificationItem(data);
            $notificationList.find('li:first').after(newNotificationHTML);

            // Cập nhật offcanvas nếu đang mở
            if ($('#notificationOffcanvas').hasClass('show')) {
                const offcanvasHTML = renderNotificationOffcanvasItem(data);
                $('#notification-offcanvas-list').prepend(offcanvasHTML);
            }

            // Hiệu ứng thông báo
            showNewNotificationAlert(data);
        });

        // Hàm hiển thị thông báo dạng alert
        function showNewNotificationAlert(data) {
            Swal.fire({
                icon: 'info',
                title: 'Thông báo',
                text: data.message,
                showConfirmButton: false,
                timer: 5000,
                toast: true,
                position: 'top-end'
            });
        }


        // Hàm render HTML cho notification item
        function renderNotificationItem(data) {
            const discount_type = data.coupon?.discount_type === 0 ? 'Giá Cố Định' : 'Phần Trăm';
            return `
                <li class="notification-item" data-id="${data.id}">
                    <p>
                        <i class="ri-record-circle-line me-2 txt-primary"></i>
                        ${data.message}
                        ${data.coupon ? `<small class="text-muted">(${data.coupon.code})</small>` : ''}
                    </p>
                </li>
            `;
        }

        // Hàm render HTML cho thông báo trong offcanvas
        function renderNotificationOffcanvasItem(notifi) {
            const discount_type = notifi.coupon?.discount_type == 0 ? 'Giá Cố Định' : 'Phần Trăm';
            const couponInfo = notifi.coupon ? `
        <div class="coupon-details mt-2">
            <div class="row">
                <div class="col-6">
                    <small class="text-muted">Mã code:</small>
                    <p class="mb-1 fw-bold">${notifi.coupon.code}</p>
                </div>
                <div class="col-6">
                    <small class="text-muted">Hết hạn:</small>
                    <p class="mb-1">
                        ${ notifi.coupon.end_date ? new Date(notifi.coupon.end_date).toLocaleDateString() : 'Không' }
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
    ` : '';
            const readClass = notifi.read ? 'notification-read' : 'notification-unread';

            return `
        <div class="notification-item mb-2 p-2 border rounded ${readClass}" data-id="${notifi.id}">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <p class="mb-1">${notifi.message}</p>
                    ${couponInfo}
                </div>
                <button class="btn btn-sm btn-danger delete-notifi" data-id="${notifi.id}">Xóa</button>
            </div>
        </div>
    `;
        }

        // Hàm load danh sách thông báo từ API
        function loadNotifications() {
            console.log("Loading notifications for user:", window.currentUserId);
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                data: {
                    user_id: window.currentUserId
                },
                success: function(response) {
                    var notifications = response.notifications.data ? response.notifications.data :
                        response;

                    $('.unread-count').text(response.unread_count);
                    if (response.unread_count == 0) {
                        $('.unread-count').hide();
                    } else {
                        $('.unread-count').show();
                    }
                    var $notificationList = $('#notification-list');
                    // Xóa các phần tử thông báo cũ (ngoại trừ header và nút "Check All")
                    $notificationList.find('li.notification-item').remove();
                    // Tạo HTML cho tất cả thông báo
                    var notificationHTML = notifications.map(renderNotificationItem).join('');
                    // Thêm vào trước nút "Check All Notification"
                    var $checkAllBtn = $('#open-notification-offcanvas').parent();
                    $(notificationHTML).insertBefore($checkAllBtn);
                },
                error: function(err) {
                    console.error('Error loading notifications:', err);
                }
            });
        }

        // Hàm load danh sách thông báo cho offcanvas
        function loadNotificationsOffcanvas() {
            console.log("Loading offcanvas notifications for user:", window.currentUserId);
            $.ajax({
                url: '/api/notifications',
                method: 'GET',
                data: {
                    user_id: window.currentUserId
                },
                success: function(response) {
                    var notifications = response.notifications.data ? response.notifications.data :
                        response;
                    var $offcanvasList = $('#notification-offcanvas-list');

                    if (notifications.length === 0) {
                        $offcanvasList.html('<p>Không có thông báo nào!</p>');
                    } else {
                        var offcanvasHTML = notifications.map(renderNotificationOffcanvasItem).join(
                            '');
                        $offcanvasList.html(offcanvasHTML);

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

        // Hàm xóa thông báo
        function deleteNotification(id) {
            $.ajax({
                url: '/api/notifications/' + id,
                method: 'DELETE',
                data: {
                    user_id: window.currentUserId
                },
                success: function(response) {
                    loadNotifications();
                    loadNotificationsOffcanvas();
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Xóa Thành Công Thông Báo Này !',
                        timer: 2000
                    });
                },
                error: function(err) {
                    console.error("Error deleting notification:", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: 'Có lỗi xảy ra !',
                        timer: 2000
                    });
                }
            });
        }

        // Gọi load notifications ban đầu
        loadNotifications();

        // Mở offcanvas khi nhấn nút "Check All Notification"
        $('#open-notification-offcanvas').on('click', function(e) {
            e.preventDefault();
            loadNotificationsOffcanvas();
            let myOffcanvas = new bootstrap.Offcanvas(document.getElementById(
                'notificationOffcanvas'), {
                backdrop: false // Tắt backdrop
            });
            myOffcanvas.show();
        });

        $(document).on('click', '.notification-item', function() {
            const notificationId = $(this).data('id');
            markNotificationAsRead(notificationId, $(this));
        });

        function markNotificationAsRead(notificationId, $element) {
            $.ajax({
                url: '/api/notifications/' + notificationId + '/read',
                method: 'PATCH', // hoặc POST tùy API của bạn
                data: {
                    user_id: window.currentUserId
                },
                success: function(response) {
                    $element.removeClass('notification-unread').addClass('notification-read');
                    $('.unread-count').text(response.unread_count);
                    if (response.unread_count == 0) {
                        $('.unread-count').hide();
                    }
                },
                error: function(err) {
                    console.error("Error marking notification as read:", err);
                }
            });
        }
    });
</script>
