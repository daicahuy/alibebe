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
            height: 40px;
        }

        .filter-container button {
            height: 40px;
            border-radius: 8px;
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
                <div class="title-header option-title">
                    <h5>Đánh Giá</h5>
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
                    <button class="btn btn-theme mt-4">Filter</button>

                    <!-- Reset Button -->
                    <button class="btn btn-secondary mt-4">Reset</button>
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
                                                <i class="ri-star-fill"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-fill"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                            <li>
                                                <i class="ri-star-line"></i>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>45</td>
                                    <td>
                                        <ul>
                                            <li><a href="{{ route('admin.reviews.show', ['product' => 1]) }}"><i class="ri-eye-line"></i></a>
                                            </li>
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
