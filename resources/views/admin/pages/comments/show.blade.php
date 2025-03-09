@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
    <script src="https://cdn.tailwindcss.com"></script>
@endpush

@push('css')
    <style>
        .content {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .filter-section {
            flex: 1;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 8px;
            height: fit-content;
        }

        .comment-section {
            flex: 3;
        }

        .comment-header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .comment-header-section h5 {
            margin: 0;
        }

        .comment-header-section select {
            margin-left: 10px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .comment-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .translated {
            color: #007bff;
            cursor: pointer;
        }

        .translated:hover {
            text-decoration: underline;
        }

        .status-tags span {
            background-color: #e9ecef;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 12px;
            margin-right: 5px;
        }

        .hidden {
            display: none;
        }

        .btn-dg {
            color: red
        }

        .star {
            font-size: 24px;
            color: white;
            text-shadow: 0px 0px 2px gold;
            cursor: pointer;
        }

        .star.filled {
            color: gold;
            /* Khi click sẽ đổi màu */
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="content">
        <!-- Filters Section -->
        <div class="filter-section">
            <div class="title-header option-title">
                <h5><i class="fa-solid fa-filter"></i>Lọc</h5>
            </div>
            <form method="GET" action="" id="commentFilterForm">
                <div class="mb-3">
                    <label for="searchReviews" class="form-label">Tìm kiếm bình luận</label>
                    <input type="text" name="search" class="form-control" id="searchReviews" placeholder="Nhập từ khóa"
                        value="{{ $search ?? '' }}">
                </div>

                <div class="mb-3">
                    <label for="dateRange" class="form-label">Khoảng thời gian</label>
                    <input type="date" name="date_from" class="form-control mb-2" id="dateRangeFrom"
                        value="{{ $dateFrom ?? '' }}">
                    <input type="date" name="date_to" class="form-control" id="dateRangeTo" value="{{ $dateTo ?? '' }}">
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <button type="submit" class="btn btn-primary">Áp dụng bộ lọc</button>

                    </div>
                </div>
            </form>

        </div>

        <!-- Review Section -->
        <div class="comment-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div>
                        <h3 class="title-header option-title fw-bold pb-0">Tổng {{ $totalCommentsAndReplies }} Bình luận</h3>
                    </div>
                </div>
                <form method="GET" action="" id="sortForm" class="mb-3 d-inline-block">
                    <div class="d-flex justify-content-start">
                        <div class="me-3">
                            <select class="form-select" name="sort" id="sortSelect"
                                onchange="document.getElementById('sortForm').submit();">
                                <option value="">Sắp xếp theo ngày</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            @foreach ($showComment as $item)
                <div class="comment-card">
                    <div class="comment-header">
                        <div>
                            <h5>{{ $item->user->fullname }} |
                                <small>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}</small>
                            </h5>
                        </div>
                        <div class="comment-header flex justify-content-end">
                            <a href="#" onclick="deleteComment(event, {{ $item->id }})" class="btn-dg ">
                                <i class="ri-delete-bin-5-line " style="color: red"></i>
                            </a>
                        </div>
                    </div>

                    <div class="mt-2">
                        <h4 class="mt-2 fst-italic">
                            {{ $item->content }}
                        </h4>
                    </div>

                    <a href="#" class="text-primary flex justify-content-end"
                        onclick="showCommetReply(event, 'comment{{ $item->id }}')">Chi
                        Tiết</a>
                </div>

                <div id="comment{{ $item->id }}" class="comment-card hidden border border-primary p-3 ">
                </div>
            @endforeach
        </div>

    </div>
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showCommetReply(event, commentId) {
            event.preventDefault();
            var commentReplyDiv = $('#' + commentId);

            if (commentReplyDiv.hasClass('hidden')) {
                commentReplyDiv.removeClass('hidden');


                if (!commentReplyDiv.data('loaded')) {
                    var comment_id = commentId.replace('comment', '');

                    $.ajax({
                        url: `/api/comments/${comment_id}/replies`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(replies) {
                            var repliesHtml = '';
                            if (replies.length > 0) {
                                $.each(replies, function(index, reply) {
                                    repliesHtml += `
                                <div>
                                    <div class="comment-header">
                                        <div>
                                            <h5> ${reply.user.fullname} | <small>${new Date(reply.created_at).toLocaleDateString('vi-VN', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}</small></h5>
                                        </div>
                                        <div class="comment-header flex justify-content-end">
                                            <a href="#" onclick="deleteReply(event, ${reply.id})" class="btn-dg ">
                                                <i class="ri-delete-bin-5-line " style="color: red"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mt-2">
                                        <p class="fst-italic">${reply.content}</p>
                                    </div>
                                </div>
                                <hr class="mt-2 mb-2 border-2">
                            `;
                                });
                            } else {
                                repliesHtml = '<p class="text-center">Không có phản hồi nào.</p>';
                            }
                            commentReplyDiv.html(repliesHtml);
                            commentReplyDiv.data('loaded', true);
                        },
                        error: function(error) {
                            console.error('Error fetching replies:', error);
                            commentReplyDiv.html(
                                '<p class="text-danger">Lỗi tải phản hồi.</p>');
                        }
                    });
                }


            } else {
                commentReplyDiv.addClass('hidden');
            }
        }

        function deleteComment(event, commentId) {
            event.preventDefault();

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa bình luận này?',
                text: "Hành động này không thể hoàn tác và sẽ xóa tất cả phản hồi của bình luận này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/api/comments/${commentId}`,
                        method: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Đã xóa!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(error) {
                            console.error('Lỗi xóa bình luận:', error);
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi khi xóa bình luận. Vui lòng thử lại sau.',
                                'error'
                            );
                        }
                    });
                }
            })
        }


        function deleteReply(event, replyId) {
            event.preventDefault();

            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa phản hồi này?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/api/comment-replies/${replyId}`,
                        method: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Đã xóa!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Lỗi!',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(error) {
                            console.error('Lỗi xóa phản hồi:', error);
                            Swal.fire(
                                'Lỗi!',
                                'Đã xảy ra lỗi khi xóa phản hồi. Vui lòng thử lại sau.',
                                'error'
                            );
                        }
                    });
                }
            })
        }
    </script>
@endpush
