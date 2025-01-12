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

        .rating {
            color: #f39c12;
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
            <div class="mb-3">
                <label for="searchReviews" class="form-label">Search reviews</label>
                <input type="text" class="form-control" id="searchReviews" placeholder="Enter keywords">
            </div>
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div style="color: yellow">
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                </div>
            </div>
            <div class="mb-3">
                <label for="dateRange" class="form-label">Date range</label>
                <input type="date" class="form-control mb-2" id="dateRangeFrom" placeholder="From">
                <input type="date" class="form-control" id="dateRangeTo" placeholder="To">
            </div>
            <div class="mb-3">
                <label for="locations" class="form-label">Locations</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location1">
                    <label class="form-check-label" for="location1">
                        Lattmate
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location2">
                    <label class="form-check-label" for="location2">
                        Kicha king
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location3">
                    <label class="form-check-label" for="location3">
                        Yo sushi
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location4">
                    <label class="form-check-label" for="location4">
                        Panda express
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location5">
                    <label class="form-check-label" for="location5">
                        Drink & go
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="location6">
                    <label class="form-check-label" for="location6">
                        Burgors best
                    </label>
                </div>
            </div>
        </div>

        <!-- Review Section -->
        <div class="review-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="title-header option-title fw-bold pb-0">44 Đánh Giá</h3>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="me-3">
                        <select class="form-select">
                            <option>Sort by date</option>
                            <option>Newest first</option>
                            <option>Oldest first</option>
                        </select>
                    </div>
                    <div>
                        <select class="form-select">
                            <option>Export</option>
                            <option>CSV</option>
                            <option>PDF</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-header">
                    <div>
                        <h5>Hiệp Đen HN | <small>City Walk, Dubai, UAE</small></h5>
                    </div>
                    <span class="flex justify-content-end">29/12/2024 22:04 pm</span>

                </div>
                <div class="mt-2">
                    <h4 class="mt-2">Sohaib Bismal
                        <a href="" style="color: yellow"><i class="ri-star-fill"></i></a>
                        <a href=""style="color: yellow"><i class="ri-star-fill"></i></a>
                        <a href=""style="color: yellow"><i class="ri-star-fill"></i></a>
                        <a href=""style="color: yellow"><i class="ri-star-fill"></i></a>
                        <a href=""style="color: yellow"><i class="ri-star-fill"></i></a>
                    </h4>

                </div>
                <h6 class="mt-3 fst-italic">No comment added</h6>
                <a href="#" class="text-primary flex justify-content-end"
                    onclick="showReview(event, 'review1')">Detail</a>
            </div>

            <div id="review1" class="review-card hidden border border-primary p-3">
                <div class="review-header flex justify-content-end">
                    <a href="#" onclick="return confirm('')" class="btn-dg "><i class="fa-solid fa-trash"></i></a>
                </div>

                <div class="mt-2">
                    <h5 class="fw-bold">Image & Video :</h5>
                </div>

                <div class="flex items-center gap-2 mb-4 mt-3 ">

                    <!-- Hình ảnh thumbnail cho video -->
                    <video controls
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 cursor-pointer border"
                        onclick="openModal('https://www.w3schools.com/html/mov_bbb.mp4')">
                        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                    </video>
                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 1"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border">

                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 2"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border">

                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 3"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border">

                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyO5yRs3gQPNWOxgjOua8N9-hsjUI6sFX17Q&s"
                        alt="Ảnh 4"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border">


                </div>
                <!-- Modal Video -->
                <div id="videoModal"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-4">
                        <div class="flex justify-end">
                            <button onclick="closeModal()"
                                class="text-gray-600 hover:text-gray-900 font-bold text-xl">×</button>
                        </div>
                        <video id="modalVideoPlayer" class="w-full h-64" controls>
                            <source id="modalVideoSource" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="mt-3">
                    <h5 class="fw-bold">Reviw Comment:</h5>
                    <span class="mt-3 fst-italic">" Nhiều thằng cứ nhờn với thầy sản phẩm mà hỏng dách việc với bố nhớ chưa
                        nhớ chưa
                        nhớ chưa nhớ chưa
                        nhớ chưa nhớ chưa nhớ chưa nhớ chưa nhớ chưa "</span>
                </div>
                <div class="mt-3">
                    <span><strong>Category : </strong> Laptop</span>
                </div>

            </div>

            <div class="review-card">
                <div class="review-header">
                    <div>
                        <h6>Drink & Go</h6>
                        <small>Marina Walk, Dubai, UAE</small>
                    </div>
                </div>
                <p class="mt-2">John Doe</p>
                <small>Great service and ambiance.</small>
                <a href="#" class="text-primary flex justify-content-end"
                    onclick="showReview(event, 'review2')">Detail</a>
            </div>

            <div id="review2" class="review-card hidden">
                <div class="review-header">
                    <div>
                        <h5 class="fw-bold">Rating :</h5>
                    </div>
                    <a href="#" class="btn-dg"><i class="fa-solid fa-trash"></i></a>

                </div>
                <div class="mt-2" style="color: yellow">
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                    <a href=""><i class="ri-star-fill"></i></a>
                </div>
                <div class="mt-2">
                    <h5 class="fw-bold">Image & Video :</h5>
                </div>

                <div class="flex items-center gap-2 mb-4 mt-2">

                    <!-- Hình ảnh thumbnail cho video -->
                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 1"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border"
                        onclick="openModal('https://www.w3schools.com/html/mov_bbb.mp4')">

                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 2"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border"
                        onclick="openModal('https://www.w3schools.com/html/mov_bbb.mp4')">

                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 3"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border"
                        onclick="openModal('https://www.w3schools.com/html/mov_bbb.mp4')">

                    <img src="https://adoreyou.vn/wp-content/uploads/khanh-sky-se-thay-the-khabanh-de-phat-1-kieu-toc-tro-thanh-trend-86d4f8.jpg"
                        alt="Ảnh 4"
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 object-contain cursor-pointer border"
                        onclick="openModal('https://www.w3schools.com/html/mov_bbb.mp4')">
                </div>

                <div>
                    <video controls
                        class="rounded-lg shadow-md hover:scale-105 transition-transform duration-300 h-32 w-32 cursor-pointer"
                        onclick="openModal('video-modal-url.mp4', 'originalVideoId');">
                        <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                    </video>
                </div>
                <!-- Modal Video -->
                <div id="videoModal"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 p-4">
                        <div class="flex justify-end">
                            <button onclick="closeModal()"
                                class="text-gray-600 hover:text-gray-900 font-bold text-xl">×</button>
                        </div>
                        <video id="modalVideoPlayer" class="w-full h-64" controls>
                            <source id="modalVideoSource" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="mt-3">
                    <h5 class="fw-bold">Reviw Comment:</h5>
                    <span class="mt-3">Nhiều thằng cứ nhờn với thầy sản phẩm mà hỏng dách việc với bố nhớ chưa nhớ chưa
                        nhớ chưa nhớ chưa
                        nhớ chưa nhớ chưa nhớ chưa nhớ chưa nhớ chưa </span>
                </div>
            </div>
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
    </script>
@endpush
