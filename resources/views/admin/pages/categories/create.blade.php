@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        /* css upload file */
        /* Modal backdrop */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        /* Modal */
        #mediaModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            z-index: 1000;
            display: none;
            padding: 20px;
            width: 90%;
            max-width: 1300px;
            max-height: 100vh;
            overflow-y: auto;
        }

        /* Modal header */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Modal close button */
        .btn-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Tab navigation styles */
        .nav-tabs {
            margin-bottom: 15px;
        }

        .nav-link {
            cursor: pointer;
        }

        /* Content section */
        .content-section {
            margin-top: 10px;
        }

        /* Dropzone */
        .dropzone-label {
            display: flex;
            /* Kích hoạt Flexbox */
            flex-direction: column;
            /* Xếp chồng các phần tử theo chiều dọc */
            justify-content: center;
            /* Căn giữa nội dung theo chiều dọc */
            align-items: center;
            /* Căn giữa nội dung theo chiều ngang */
            margin-top: 10px;
            padding: 20px;
            border-radius: 8px;
            /* Góc bo tròn */
            cursor: pointer;
            background-color: #f9f9f9;
            height: 400px;
            /* Chiều cao cố định */
            width: 90%;
            /* Chiều rộng chiếm 90% khối cha */
            text-align: center;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            /* Hiệu ứng hover */
        }

        .dropzone-label h2 {
            color: #007bff;
            font-size: 1.2rem;
        }

        /* Image preview */
        #imagePreview img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .small-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 10px;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
        }

        .custom-pagination .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .custom-pagination .page-item {
            margin: 0 5px;
        }

        .custom-pagination .page-link {
            padding: 10px 15px;
            color: #0c9c8a;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #0c9c8a;
            color: white;
            border-color: #0c9c8a;
        }

        .custom-pagination .page-item.disabled .page-link {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #ddd;
            pointer-events: none;
        }

        .custom-pagination .page-item:hover .page-link {
            background-color: #e9ecef;
            border-color: #ddd;
        }

        .custom-pagination .page-link i {
            font-size: 16px;
        }


        /* Add Button */
        /* Plus symbol */
        .add-button::after {
            content: '+';
            /* Plus icon */
            font-size: 24px;
            /* Font size for the plus icon */
            color: #888;
            /* Grey color for the icon */
        }

        /* Hover effect */
        .add-button:hover {
            background-color: #f0f0f0;
            /* Slightly darker background on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            /* Stronger shadow on hover */
        }

        /* Active effect */
        .add-button:active {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            /* Reduced shadow for pressed effect */
            transform: scale(0.95);
            /* Slight shrink on click */
        }

        /* Add Button */

        .custom-upload {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 400px;
            border: 2px dashed #ccc;
            border-radius: 12px;
            cursor: pointer;
            background-color: #f9f9f9;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            position: relative;
        }

        .custom-upload:hover {
            background-color: #f0f0f0;
            border-color: #0da487;
        }

        .custom-upload h2 {
            font-size: 24px;
            color: #717386;
            margin: 0;
            margin-bottom: 10px;
        }

        .custom-upload i {
            font-size: 24px;
            color: #717386;
            margin-bottom: 8px;
        }

        .custom-upload input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Image preview container */
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Image container styling */
        .image-container {
            position: relative;
            width: 100px;
            /* Chiều rộng của mỗi ảnh */
            height: 100px;
            /* Chiều cao của mỗi ảnh */
            overflow: hidden;
            border: 2px solid #ccc;
            /* Viền cho ảnh */
            border-radius: 8px;
            /* Góc bo tròn */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Tạo hiệu ứng đổ bóng */
            transition: transform 0.3s ease;
        }

        .image-container:hover {
            transform: scale(1.05);
            /* Phóng to ảnh khi hover */
        }

        /* Image inside container */
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh luôn được căn chỉnh đẹp trong khung */
            border-radius: 8px;
            /* Bo tròn góc ảnh */
        }

        /* Delete button styling */
        .delete-btn {
            position: absolute;
            top: 5px;
            /* Điều chỉnh nút delete lên phía trên */
            right: 5px;
            /* Điều chỉnh nút delete về phía phải */
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            /* Tăng kích thước nút delete */
            height: 24px;
            font-size: 16px;
            line-height: 24px;
            /* Đảm bảo icon nằm giữa */
            text-align: center;
            /* Căn giữa nội dung nút delete */
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            /* Đổ bóng cho nút xóa */
            z-index: 10;
            /* Đảm bảo nút delete luôn nằm trên cùng */
        }

        .delete-btn:hover {
            background-color: #ff1a1a;
            /* Đổi màu khi hover */
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <!-- New Product Add Start -->

    <div class="row m-0">
        <div class="col-xl-12 p-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="title-header option-title">

                                    <h5>Create Category</h5>
                                    <form class="d-inline-flex">

                                        <a href="" class="align-items-center btn btn-theme d-flex">
                                            {{-- <i data-feather="plus-square"></i> --}}
                                            Back
                                        </a>
                                    </form>

                                </div><!---->
                                <form novalidate="" class="theme-form theme-form-2 mega-form   ">

                                    <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="name"> Name<span
                                                class="theme-color ms-2 required-dot ">*</span><!----></label>
                                        <div class="col-sm-10"><input type="text" formcontrolname="name"
                                                class="form-control   " placeholder="Enter Name"><!----></div>
                                    </div>

                                    {{-- <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="description">
                                            Description<!----></label>
                                        <div class="col-sm-10">
                                            <textarea formcontrolname="description" rows="3" class="form-control   " placeholder="Enter Description"></textarea>
                                        </div>
                                    </div> --}}


                                    {{-- <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="commission_rate">
                                            Commission Rate<!----></label>
                                        <div class="col-sm-10">
                                            <div class="input-group"><input id="commission_rate" type="number"
                                                    min="0" max="100"
                                                    oninput="if (value > 100) value = 100; if (value < 0) value = 0;"
                                                    placeholder="Enter Commision Rate" formcontrolname="commission_rate"
                                                    numbersonly="" class="form-control   "><span
                                                    class="input-group-text">%</span></div>
                                            <p class="help-text">*Define the
                                                percentage of earnings retained as commission.</p>
                                        </div>
                                    </div> --}}
                                    <!---->
                                    <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="category"> Select
                                            Parent<!----></label>
                                        <div class="col-sm-10">

                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div class="position-relative">
                                                                <!-- Select Option -->
                                                                <nav class="category-breadcrumb-select">
                                                                    <ol class="breadcrumb">
                                                                        <li class="breadcrumb-item">
                                                                            <a href="javascript:void(0)"
                                                                                class="toggle-dropdown">Select Option</a>
                                                                        </li>
                                                                    </ol>
                                                                </nav>

                                                                <!-- Close Button -->
                                                                <a class="cateogry-close-btn d-inline-block">
                                                                    <i class="ri-arrow-down-s-line down-arrow"></i>
                                                                    <i class="ri-close-line close-arrow"
                                                                        style="display: none;"></i>
                                                                </a>

                                                                <!-- Dropdown Box -->
                                                                <div class="select-category-box mt-2 dropdown-open show"
                                                                    style="bottom: auto; top: 100%; display:none"><input
                                                                        placeholder="Search here.."
                                                                        class="form-control search-input ng-untouched ng-pristine ng-valid">
                                                                    <div class="category-content">
                                                                        <nav aria-label="breadcrumb"
                                                                            class="category-breadcrumb">
                                                                            <ol class="breadcrumb"><!---->
                                                                                <li class="breadcrumb-item inserted">
                                                                                    <a href="javascript:void(0)">All</a>
                                                                                </li><!----><!---->

                                                                                {{-- <li class="breadcrumb-item inserted">
                                                                                    <a href="javascript:void(0)">Fashion</a>
                                                                                </li> --}}
                                                                            </ol>
                                                                        </nav>
                                                                        <div class="category-listing inserted">
                                                                            <ul>
                                                                                {{-- Danh mục con của fashsion --}}
                                                                                <app-dropdown-list class="inserted">
                                                                                    <li>Tops
                                                                                        <a href="javascript:void(0)"
                                                                                            class="select-btn"> Select
                                                                                        </a><!---->
                                                                                    </li>
                                                                                </app-dropdown-list>
                                                                                <app-dropdown-list class="inserted">
                                                                                    <li>Fashion
                                                                                        <a href="javascript:void(0)"
                                                                                            class="select-btn"> Select
                                                                                        </a>
                                                                                        <a href="javascript:void(0)"
                                                                                            class="right-arrow inserted">
                                                                                            <i
                                                                                                class="ri-arrow-right-s-line"></i>
                                                                                        </a><!---->
                                                                                    </li>
                                                                                </app-dropdown-list>
                                                                            </ul>
                                                                        </div><!---->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                    <!-- Add Image Section -->
                                    <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="image">Icon</label>
                                        <div class="col-sm-10 d-flex justify-content-center">
                                            <ul class="image-select-list cursor-pointer">
                                                <li class="choosefile-input" id="openModal1">
                                                    <div class="add-button"></div>
                                                </li>
                                            </ul>
                                            <div>
                                                <div class="ml-4 d-flex" id="image-area">

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="align-items-center g-2 mb-4 row">
                                        <label class="col-sm-2 form-label-title mb-0" for="status">
                                            Status<!----></label>
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch ps-0"><label class="switch"><input
                                                        type="checkbox" id="status" formcontrolname="status"
                                                        class="  "><span class="switch-state"></span></label></div>
                                        </div>
                                    </div>

                                    <app-button>
                                        <button class="btn btn-theme ms-auto mt-4" id="category_btn" type="submit">
                                            <div> Save Category </div>
                                        </button>
                                    </app-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Image -->
    <div class="modal-backdrop" id="modalBackdrop"></div>

    <div class="modal-content" id="mediaModal" style="display: none;">
        <div class="modal-header">
            <h2>Insert Media</h2>
            <button class="btn btn-close" id="media_close_btn" type="button">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="modal-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#" class="nav-link active" id="selectFileTab">Select File</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="uploadNewTab">Upload New</a>
                </li>
            </ul>
            <div class="tab-content mt-2">
                <!-- Select File Tab -->
                <div class="tab-pane fade active show" id="selectFilePanel">
                    <div class="select-top-panel d-flex">
                        <input type="text" class="form-control me-3" placeholder="Search your files">
                        <select class="form-select">
                            <option value="">Sort By desc</option>
                            <option value="newest">Sort By newest</option>
                            <option value="oldest">Sort By oldest</option>
                            <option value="smallest">Sort By smallest</option>
                            <option value="largest">Sort By largest</option>
                        </select>
                    </div>
                    <div class="content-section py-0">
                        <div
                            class="row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-sm-3 row-cols-2 g-sm-3 g-2 media-library-sec ratio_square ">
                            <div class="">
                                <div class="library-box"><input name="attachment" class="media-checkbox" type="radio"
                                        id="attachment-1470" value="1470"><label for="attachment-1470">
                                        <div class="ratio ratio-1x1"><img alt="attachment" class="img-fluid"
                                                src="https://laravel.pixelstrap.net/fastkart/storage/1470/01.jpg">
                                        </div>
                                    </label><!----><!----><!----></div>
                            </div>
                            <div class="">
                                <div class="library-box"><input name="attachment" class="media-checkbox" type="radio"
                                        id="attachment-1470" value="1470"><label for="attachment-1470">
                                        <div class="ratio ratio-1x1"><img alt="attachment" class="img-fluid"
                                                src="https://laravel.pixelstrap.net/fastkart/storage/1470/01.jpg">
                                        </div>
                                    </label><!----><!----><!----></div>
                            </div>
                        </div><!----><!---->
                        <nav class="custom-pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled"><a href="#" class="page-link"><i
                                            class="ri-arrow-left-s-line"></i></a></li>
                                <li class="page-item active"><a href="#" class="page-link">1</a></li>
                                <li class="page-item"><a href="#" class="page-link">2</a></li>
                                <li class="page-item"><a href="#" class="page-link">3</a></li>
                                <li class="page-item"><a href="#" class="page-link"><i
                                            class="ri-arrow-right-s-line"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Upload New Tab -->
                <div class="tab-pane fade" id="uploadNewPanel">
                    <div class="content-section drop-files-sec">
                        <div class="custom-upload">
                            <input type="file" id="fileUploadInput" multiple accept="image/*">
                            <div class="dropzone-label">
                                <i class="ri-upload-line justify-content-center"></i>
                                <h2>Drop Files Here or Click to Upload</h2>
                            </div>
                        </div>
                        <div id="imagePreview" class="image-preview">
                            <!-- Ảnh sẽ hiển thị ở đây sau khi tải lên -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-theme" id="media_btn" type="button">Insert Media</button>
        </div>
    </div>



    <!-- New Product Add End -->
@endsection



{{-- ================================== --}}
{{--                 JS                 --}}
{{-- ================================== --}}

@push('js_library')
@endpush

@push('js')
    <script>
        // upload file
        $(document).ready(function() {
            const $openModalButton = $('#openModal1');
            const $modal = $('#mediaModal');
            const $backdrop = $('#modalBackdrop');
            const $closeModalButton = $('#media_close_btn');
            const $fileUploadInput = $('#fileUploadInput');
            const $imagePreview = $('#imagePreview');
            const $imageArea = $('#image-area');
            const $mediaBtn = $('#media_btn');
            const $uploadNewTab = $('#uploadNewTab');
            const $selectFileTab = $('#selectFileTab');

            // Tabs Panels
            const $uploadNewPanel = $('#uploadNewPanel');
            const $selectFilePanel = $('#selectFilePanel');

            // Show modal and set default tab to "Select File"
            function showModal() {
                $modal.show();
                $backdrop.show();
                activateSelectFileTab(); // Set default tab to Select File
            }

            // Hide modal and backdrop
            function hideModal() {
                $modal.hide();
                $backdrop.hide();
            }

            // Event listeners for modal open/close
            $openModalButton.on('click', showModal);
            $closeModalButton.on('click', hideModal);
            $backdrop.on('click', hideModal);

            // Tab switching
            $uploadNewTab.on('click', function(e) {
                e.preventDefault();
                activateUploadTab();
            });

            $selectFileTab.on('click', function(e) {
                e.preventDefault();
                activateSelectFileTab();
            });

            // Activate "Upload New" tab
            function activateUploadTab() {
                $uploadNewTab.addClass('active');
                $selectFileTab.removeClass('active');
                $uploadNewPanel.addClass('show active');
                $selectFilePanel.removeClass('show active');
            }

            // Activate "Select File" tab
            function activateSelectFileTab() {
                $selectFileTab.addClass('active');
                $uploadNewTab.removeClass('active');
                $selectFilePanel.addClass('show active');
                $uploadNewPanel.removeClass('show active');
                resetFileInput(); // Reset file input when switching to "Select File" tab
            }

            // Reset file input when switching tabs
            function resetFileInput() {
                $fileUploadInput.val(''); // Clear file input
                $imagePreview.html(''); // Clear image preview
            }

            // File upload preview
            let selectedFiles = [];

            $fileUploadInput.on('change', function(e) {
                const files = e.target.files;

                // Đẩy các file mới vào mảng
                $.each(files, function(_, file) {
                    selectedFiles.push(file);
                });

                // Xóa preview cũ
                $imagePreview.html('');

                // Hiển thị preview các ảnh trong mảng
                $.each(selectedFiles, function(_, file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const $imgContainer = $('<div>').addClass('image-container');
                        const $img = $('<img>').attr('src', event.target.result);
                        const $deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        $deleteBtn.on('click', function() {
                            $imgContainer.remove();
                            // Cập nhật lại mảng selectedFiles khi xóa ảnh
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            displayImagesOutside(); // Cập nhật ảnh bên ngoài modal
                        });

                        $imgContainer.append($img).append($deleteBtn);
                        $imagePreview.append($imgContainer);
                    };
                    reader.readAsDataURL(file);
                });

                if ($mediaBtn) {
                    displayImagesOutside();
                } // Hiển thị ảnh bên ngoài modal
            });

            // Hiển thị ảnh ngoài modal
            function displayImagesOutside() {
                $imageArea.html(''); // Xóa ảnh cũ ngoài modal

                $.each(selectedFiles, function(_, file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const $imgContainer = $('<div>').addClass('image-container');
                        const $img = $('<img>').attr('src', event.target.result).attr('name',
                            'image[]');
                        const $deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        $deleteBtn.on('click', function() {
                            $imgContainer.remove();
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            displayImagesOutside(); // Cập nhật ảnh bên ngoài modal khi xóa
                        });

                        $imgContainer.append($img).append($deleteBtn);
                        $imageArea.append($imgContainer); // Thêm ảnh ngoài modal
                    };
                    reader.readAsDataURL(file);
                });
            }

            $('#save-btn').on('click', function() {
                $.notify('<i class="fas fa-bell"></i><strong>Save</strong> Completed', {
                    type: 'theme',
                    allow_dismiss: true,
                    delay: 1000,
                    showProgressbar: true,
                    timer: 300,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });
            });

            $mediaBtn.on('click', function() {
                // Show success notification
                $.notify(
                    '<i class="fas fa-bell"></i><strong>Media</strong> Action completed successfully', {
                        type: 'theme',
                        allow_dismiss: true,
                        delay: 1000,
                        showProgressbar: true,
                        timer: 300,
                        animate: {
                            enter: 'animated fadeInDown',
                            exit: 'animated fadeOutUp'
                        }
                    });

                // Close the modal after showing notification
                hideModal(); // Hide modal
            });


            // select option
            // Các elements chính
            const $toggleLink = $('.toggle-dropdown'); // Nút "Select Option"
            const $closeBtn = $('.cateogry-close-btn'); // Nút đóng/mở dropdown
            const $dropdownBox = $('.select-category-box'); // Box dropdown chính
            const $downArrow = $closeBtn.find('.down-arrow'); // Icon mũi tên xuống
            const $closeArrow = $closeBtn.find('.close-arrow'); // Icon close
            const $searchInput = $('.search-input'); // Input tìm kiếm
            const $selectOptionLink = $('.toggle-dropdown'); // Link "Select Option"
            const $breadcrumbContainer = $('.category-breadcrumb-select .breadcrumb'); // Container breadcrumb
            let selectedItem = null; // Lưu trữ item đang được chọn

            // Ẩn dropdown khi load trang
            hideDropdown();

            // Hàm hiển thị dropdown
            function showDropdown() {
                $dropdownBox.slideDown('fast');
                $downArrow.hide();
                $closeArrow.show();
            }

            // Hàm ẩn dropdown
            function hideDropdown() {
                $dropdownBox.slideUp('fast');
                $downArrow.show();
                $closeArrow.hide();
            }

            // Xử lý click vào mũi tên phải (chuyển đến danh mục con)
            $(document).on('click', '.right-arrow', function(e) {
                e.preventDefault();
                const categoryName = $(this).closest('li').contents().first().text().trim();

                // Kiểm tra xem đã tồn tại breadcrumb item cho category này chưa
                const existingItem = $('.category-breadcrumb .breadcrumb-item').filter(function() {
                    return $(this).text().trim() === categoryName;
                });

                // Chỉ thêm nếu chưa tồn tại
                if (existingItem.length === 0) {
                    const $newCategoryItem = $('<li>')
                        .addClass('breadcrumb-item inserted')
                        .html(`<a href="javascript:void(0)">${categoryName}</a>`);
                    $('.category-breadcrumb .breadcrumb').append($newCategoryItem);
                }

                // loadSubcategories(categoryName);
            });

            // Xử lý click vào "All" (quay lại danh mục gốc)
            $('.category-breadcrumb').on('click', 'a', function(e) {
                if ($(this).text().trim() === 'All') {
                    // Xóa tất cả breadcrumb items sau "All"
                    const $breadcrumbItems = $('.category-breadcrumb .breadcrumb-item');
                    $breadcrumbItems.each(function(index) {
                        if (index > $breadcrumbItems.length - 2) {
                            $(this).remove();
                        }
                    });

                    // loadMainCategories();
                }
            });

            // Toggle dropdown khi click vào "Select Option"
            $toggleLink.on('click', function(e) {
                e.preventDefault();
                $dropdownBox.is(':visible') ? hideDropdown() : showDropdown();
            });

            // Toggle dropdown khi click vào nút close
            $closeBtn.on('click', function(e) {
                e.stopPropagation();
                $dropdownBox.is(':visible') ? hideDropdown() : showDropdown();
            });

            // Đóng dropdown khi click ra ngoài
            $(document).on('click', function(e) {
                const $target = $(e.target);
                if (!$target.closest($dropdownBox).length &&
                    !$target.closest($toggleLink).length &&
                    !$target.closest($closeBtn).length) {
                    hideDropdown();
                }
            });

            // Xử lý click vào nút "Select"
            $(document).on('click', '.select-btn', function(e) {
                e.preventDefault();

                // Xóa item đã chọn trước đó (nếu có)
                if (selectedItem) {
                    $(selectedItem).removeClass('selected');
                    $breadcrumbContainer.find('.breadcrumb-pills').remove();
                }

                // Đánh dấu item mới được chọn
                $(this).addClass('selected');
                selectedItem = this;

                // Lấy tên danh mục được chọn
                const selectedText = $(this).closest('li').contents().first().text().trim();

                // Cập nhật giá trị vào input search
                $searchInput.val(selectedText);

                // Tạo và thêm breadcrumb pill
                const $breadcrumbPill = $('<li>')
                    .addClass('breadcrumb-pills inserted')
                    .html(`
                <span class="badge badge-pill badge-primary">
                    ${selectedText}
                    <i class="ri-close-line remove-pill"></i>
                </span>
            `);

                // Thêm pill vào breadcrumb và ẩn select option
                $breadcrumbContainer.prepend($breadcrumbPill);
                $selectOptionLink.hide();
                hideDropdown();

                // Xử lý xóa pill
                $breadcrumbPill.find('.remove-pill').on('click', function(e) {
                    e.stopPropagation();
                    $breadcrumbPill.remove();
                    $(selectedItem).removeClass('selected');
                    selectedItem = null;
                    $searchInput.val('');
                    $selectOptionLink.show();
                });
            });

            // Xử lý tìm kiếm
            $searchInput.on('input', function() {
                const searchText = $(this).val().toLowerCase();
                $('.category-listing li').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(searchText));
                });
            });

            // Xử lý xóa giá trị đã chọn khi clear input
            $searchInput.on('change', function() {
                if (!$(this).val()) {
                    if (selectedItem) {
                        $(selectedItem).removeClass('selected');
                        selectedItem = null;
                        $breadcrumbContainer.find('.breadcrumb-pills').remove();
                    }
                    $selectOptionLink.show();
                }
            });
        });
    </script>
@endpush
