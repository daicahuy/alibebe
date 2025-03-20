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

        .review-section {
            flex: 3;
        }

        .review-header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .review-header-section h5 {
            margin: 0;
        }

        .review-header-section select {
            margin-left: 10px;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .review-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .review-header {
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
    color: gold; /* Khi click sẽ đổi màu */
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
            <form method="GET" action="{{ route('admin.reviews.show', $product->slug) }}" id="reviewFilterForm">
                <div class="mb-3">
                    <label for="searchReviews" class="form-label">Tìm kiếm đáng giá</label>
                    <input type="text" name="search" class="form-control" id="searchReviews"
                        placeholder="Nhập từ khóa" value="{{ request('search') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Đánh giá</label>
                    <div id="ratingStars" style="color: yellow">
                        <input type="hidden" name="rating" id="ratingInput" value="{{ request('rating') }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <a href="#" onclick="setRating({{ $i }}, event)">
                                <i class="ri-star-line star" data-value="{{ $i }}"></i>
                            </a>
                        @endfor
                    </div>
                    
                </div>

                <div class="mb-3">
                    <label for="dateRange" class="form-label">Khoảng thời gian</label>
                    <input type="date" name="date_from" class="form-control mb-2" id="dateRangeFrom"
                        value="{{ request('date_from') }}">
                    <input type="date" name="date_to" class="form-control" id="dateRangeTo"
                        value="{{ request('date_to') }}">
                </div>

                <div class="d-flex justify-content-between">
                    <div>
                        <button type="submit" class="btn btn-primary">Áp dụng bộ lọc</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Review Section -->
        <div class="review-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div>
                        <h3 class="title-header option-title fw-bold pb-0">{{ $totalReviews }} Đánh Giá</h3>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="me-3">
                        <select class="form-select" name="sort" id="sortSelect" onchange="applySort()">
                            <option value="">Sắp xếp theo ngày</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        </select>
                    </div>
                    
                </div>
            </div>
            @foreach ($reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div>
                            <h5>{{ $review->user->fullname }} | <small>Địa chỉ</small></h5>
                        </div>
                        <span
                            class="flex justify-content-end">{{ date('d/m/Y H:i', strtotime($review->created_at)) }}</span>
                    </div>

                    <div class="mt-2">
                        <h4 class="mt-2">
                            @for ($i = 0; $i < $review->rating; $i++)
                                <a href="" style="color: yellow"><i class="ri-star-fill"></i></a>
                            @endfor
                        </h4>
                    </div>

                    <h6 class="mt-3 fst-italic">
                        {{ $review->review_text ?? 'No comment added' }}
                    </h6>

                    <a href="#" class="text-primary flex justify-content-end"
                        onclick="showReview(event, 'review{{ $review->id }}')">Xem ảnh & video</a>
                </div>

                <div id="review{{ $review->id }}" class="review-card hidden border border-primary p-3">
                    <div class="review-header flex justify-content-end">
                        <a href="#" onclick="return confirm('')" class="btn-dg "><i class="fa-solid fa-trash"></i></a>
                    </div>

                    <div class="mt-2">
                        <h5 class="fw-bold">Ảnh & Video :</h5>
                    </div>

                    <div class="flex items-center gap-2 mb-4 mt-3 ">
                        @foreach ($review->reviewMultimedia as $media)
                            @if ($media->file_type == 'video')
                                <video controls
                                    class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 cursor-pointer border"
                                    onclick="openModal('{{ Storage::url($media->file) }}')">
                                    <source src="{{ Storage::url($media->file) }}" type="video/mp4">
                                </video>
                            @else
                                <img src="{{ Storage::url($media->file) }}" alt="Ảnh đánh giá"
                                    class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border">
                            @endif
                        @endforeach
                    </div>
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
    <script>
        function showReview(event, reviewId) {
            event.preventDefault();
            $('#' + reviewId).toggleClass('hidden');
        }

        function openModal(videoUrl, originalVideoId) {
            $('#' + originalVideoId)[0]?.pause();
            $('#modalVideoSource').attr('src', videoUrl);
            const modalPlayer = $('#modalVideoPlayer')[0];
            modalPlayer.load();
            modalPlayer.play();
            $('#videoModal').removeClass('hidden');
        }

        function closeModal() {
            const modalPlayer = $('#modalVideoPlayer')[0];
            $('#videoModal').addClass('hidden');
            modalPlayer.pause();
            modalPlayer.currentTime = 0;
        }

        function setRating(value, event) {
    event.preventDefault(); // Ngăn chặn reload trang

    let ratingInput = document.getElementById('ratingInput');
    ratingInput.value = value; // Gán giá trị rating vào input

    console.log("Rating selected:", value); // Debug

    // Cập nhật giao diện các sao
    let stars = document.querySelectorAll('.star');
    stars.forEach(star => {
        let starValue = parseInt(star.getAttribute('data-value'));

        if (starValue <= value) {
            star.classList.remove('ri-star-line');
            star.classList.add('ri-star-fill', 'filled');
        } else {
            star.classList.remove('ri-star-fill', 'filled');
            star.classList.add('ri-star-line');
        }
    });

    // Tự động submit form sau khi chọn rating
    document.getElementById('reviewFilterForm').submit();
}

// Xử lý giữ trạng thái rating khi reload trang
document.addEventListener('DOMContentLoaded', function () {
    let savedRating = parseInt(document.getElementById('ratingInput').value) || 0;
    let stars = document.querySelectorAll('.star');

    stars.forEach(star => {
        let starValue = parseInt(star.getAttribute('data-value'));

        if (starValue <= savedRating) {
            star.classList.remove('ri-star-line');
            star.classList.add('ri-star-fill', 'filled');
        } else {
            star.classList.remove('ri-star-fill', 'filled');
            star.classList.add('ri-star-line');
        }
    });
});



        function applySort() {
            let sortValue = document.getElementById('sortSelect').value;
            let url = new URL(window.location.href);
            url.searchParams.set('sort', sortValue);
            window.location.href = url.toString();
        }
    </script>
@endpush
