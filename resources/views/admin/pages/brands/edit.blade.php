@extends('admin.layouts.master')

{{-- ================================== --}}
{{-- CSS                --}}
{{-- ================================== --}}

@push('css')
    <style>
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
{{-- CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <!-- Title Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Chỉnh Sửa Thương Hiệu</h5>
                        <a href="" class="btn btn-theme">
                            <i class="ri-arrow-left-line"></i> Danh Sách
                        </a>
                    </div>

                    <!-- Form -->
                    <form id="brand-form">
                        <div class="mb-3 row">
                            <label for="brand-name" class="col-md-3 col-form-label">Tên Thương Hiệu</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="brand-name" placeholder="Enter Brand Name">
                            </div>
                        </div>
                        <!-- Add Image Section -->
                        <div class="align-items-center g-2 mb-4 row">
                            <label class="col-sm-2 form-label-title mb-0" for="image">Image</label>
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

                        <div class="text-end">
                            <button type="button" id="save-btn" class="btn btn-primary">
                                <i class="ri-save-line"></i> Lưu
                            </button>
                        </div>
                    </form>
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
                    <a href="#" class="nav-link active" id="selectFileTab">Chọn Hình Ảnh</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="uploadNewTab">Thêm ảnh</a>
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
                        <div class="row row-cols-2 g-2 media-library-sec">
                            <div class="media-item col-2">
                                <input name="attachment" class="media-checkbox" type="radio" id="attachment-1470"
                                    value="1470">
                                <label for="attachment-1470">
                                    <div class="ratio ratio-1x1">
                                        <img alt="attachment" class="img-fluid" src="https://example.com/image.jpg">
                                    </div>
                                </label>
                            </div>
                            <div class="media-item col-2">
                                <input name="attachment" class="media-checkbox" type="radio" id="attachment-1471"
                                    value="1471">
                                <label for="attachment-1471">
                                    <div class="ratio ratio-1x1">
                                        <img alt="attachment" class="img-fluid" src="https://example.com/image.jpg">
                                    </div>
                                </label>
                            </div>
                        </div>
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
@endsection

{{-- ================================== --}}
{{-- JS                 --}}
{{-- ================================== --}}

@push('js')
    <script>
        $(document).ready(function() {
            var selectedFiles = [];

            // Show modal function
            function showModal() {
                $('#mediaModal').show();
                $('#modalBackdrop').show();
                activateSelectFileTab();
            }

            // Hide modal function
            function hideModal() {
                $('#mediaModal').hide();
                $('#modalBackdrop').hide();
            }

            // Reset file input
            function resetFileInput() {
                $('#fileUploadInput').val('');
                $('#imagePreview').html('');
            }

            // Activate upload tab
            function activateUploadTab() {
                $('#uploadNewTab').addClass('active');
                $('#selectFileTab').removeClass('active');
                $('#uploadNewPanel').addClass('show active');
                $('#selectFilePanel').removeClass('show active');
            }

            // Activate select file tab
            function activateSelectFileTab() {
                $('#selectFileTab').addClass('active');
                $('#uploadNewTab').removeClass('active');
                $('#selectFilePanel').addClass('show active');
                $('#uploadNewPanel').removeClass('show active');
                resetFileInput();
            }

            // Display images outside modal
            function displayImagesOutside() {
                $('#image-area').html('');

                $.each(selectedFiles, function(_, file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgContainer = $('<div>').addClass('image-container');
                        var img = $('<img>').attr('src', event.target.result).attr('name', 'image[]');
                        var deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        deleteBtn.on('click', function() {
                            imgContainer.remove();
                            selectedFiles = selectedFiles.filter(function(f) {
                                return f !== file;
                            });
                            displayImagesOutside();
                        });

                        imgContainer.append(img).append(deleteBtn);
                        $('#image-area').append(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Event bindings
            $('#openModal1').on('click', showModal);
            $('#media_close_btn').on('click', hideModal);
            $('#modalBackdrop').on('click', hideModal);

            $('#uploadNewTab').on('click', function(e) {
                e.preventDefault();
                activateUploadTab();
            });

            $('#selectFileTab').on('click', function(e) {
                e.preventDefault();
                activateSelectFileTab();
            });

            // File upload handling
            $('#fileUploadInput').on('change', function(e) {
                var files = e.target.files;

                $.each(files, function(_, file) {
                    selectedFiles.push(file);
                });

                $('#imagePreview').html('');

                $.each(selectedFiles, function(_, file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var imgContainer = $('<div>').addClass('image-container');
                        var img = $('<img>').attr('src', event.target.result);
                        var deleteBtn = $('<button>').addClass('delete-btn').html('&times;');

                        deleteBtn.on('click', function() {
                            imgContainer.remove();
                            selectedFiles = selectedFiles.filter(function(f) {
                                return f !== file;
                            });
                            displayImagesOutside();
                        });

                        imgContainer.append(img).append(deleteBtn);
                        $('#imagePreview').append(imgContainer);
                    };
                    reader.readAsDataURL(file);
                });

                if ($('#media_btn').length) {
                    displayImagesOutside();
                }
            });

            // Save button handler
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

            // Media button handler
            $('#media_btn').on('click', function() {
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
                hideModal();
            });
        });
    </script>
@endpush
