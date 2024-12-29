@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
    <style>
        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-container input,
        .filter-container select {
            background-color: #f5f7f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 40px;
        }

        .filter-container button {
            height: 40px;
            border-radius: 8px;
        }

        .filter-container .btn-filter {
            background-color: #0da487;
            color: white;
            border: none;
        }

        .filter-container .btn-reset {
            background-color: #e9ecef;
            color: #6c757d;
            border: none;
        }

        .rating li {
            display: inline-block;
        }
    </style>
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <!-- Table Start -->
                {{-- <div class="card-body">
                    <div class="title-header option-title">
                        <h5>Product Reviews</h5>
                    </div>
                    <div class="filter-container p-3 d-flex align-items-center gap-3 bg-light rounded shadow-sm">
                        <div class="filter-item">
                            <label for="startDate" class="form-label fw-bold mb-0">Start Date</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>
                        <div class="filter-item">
                            <label for="endDate" class="form-label fw-bold mb-0">End Date</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>
                        <div class="filter-buttons d-flex align-items-center gap-2">
                            <button class="btn btn-success fw-bold px-4">Filter</button>
                            <button class="btn btn-outline-secondary fw-bold px-4">Reset</button>
                        </div>
                    </div>

                </div> --}}

                <div class="container my-4">
                    <div class="title-header option-title">
                        <h5>Product Reviews</h5>
                    </div>
                    <div class="filter-container">
                        <!-- Search Field -->
                        <input type="text" class="form-control mt-4" placeholder="Search Product">

                        <div>
                            <label for="startDate" class="form-label fw-bold mb-0">Start Date</label>
                            <input type="date" id="startDate" class="form-control">
                        </div>

                        <div>
                            <label for="endDate" class="form-label fw-bold mb-0">End Date</label>
                            <input type="date" id="endDate" class="form-control">
                        </div>


                        <!-- Filter Button -->
                        <button class="btn btn-filter mt-4">Filter</button>

                        <!-- Reset Button -->
                        <button class="btn btn-reset mt-4">Reset</button>
                    </div>
                </div>
                <div>
                    <div class="table-responsive mt-3">
                        <table class="user-table ticket-table review-table theme-table table" id="table_id">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Product Name</th>
                                    <th>Customer Name</th>
                                    <th>Rating</th>
                                    <th>Total Review</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>Maureen Biologist</td>
                                    <td>Outwear & Coats</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="{{ url('admin/reviews/detail') }}"><i class="ri-eye-line"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>02</td>
                                    <td>Caroline Harris</td>
                                    <td>Slim Fit Plastic Coat</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>03</td>
                                    <td>Lucy Morile</td>
                                    <td>Men's Sweatshirt</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>04</td>
                                    <td>Jennifer Straight</td>
                                    <td>Men's Hoodie t-shirt</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>05</td>
                                    <td>Kevin Millett</td>
                                    <td>Outwear & Coats</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>06</td>
                                    <td>czxc</td>
                                    <td>Slim Fit Plastic Coat</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>07</td>
                                    <td>Kevin Millett</td>
                                    <td>Men's Sweatshirt</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>08</td>
                                    <td>Dillon Bradshaw</td>
                                    <td>Men's Hoodie t-shirt</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>09</td>
                                    <td>Lorna Bonner</td>
                                    <td>Outwear & Coats</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>10</td>
                                    <td>Richard Johnson</td>
                                    <td>Slim Fit Plastic Coat </td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>

                                <tr>
                                    <td>11</td>
                                    <td>Lorraine McDowell</td>
                                    <td>Men's Sweatshirt</td>
                                    <td>
                                        <ul class="rating">
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star theme-color"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fas fa-star"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="#"><i class="ri-eye-line"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table End -->
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
@endpush
