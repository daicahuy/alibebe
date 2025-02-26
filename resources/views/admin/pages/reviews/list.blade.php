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
                    <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex justify-content-evenly align-items-end flex-wrap gap-3 w-100">
                        <!-- Search Field -->
                        <div class="flex-grow-1">
                            <label for="search" class="form-label fw-bold mb-0">Tìm Kiếm </label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm kiếm sản phẩm">
                        </div>
                
                        <!-- Start Date -->
                        <div class="flex-grow-1">
                            <label for="startDate" class="form-label fw-bold mb-0">Ngày bắt đầu</label>
                            <input type="date" id="startDate" name="startDate" value="{{ request('startDate') }}" class="form-control">
                        </div>
                
                        <!-- End Date -->
                        <div class="flex-grow-1">
                            <label for="endDate" class="form-label fw-bold mb-0">Ngày kết thúc</label>
                            <input type="date" id="endDate" name="endDate" value="{{ request('endDate') }}" class="form-control">
                        </div>
                
                        <!-- Filter & Reset Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-theme">Lọc</button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
                
                <div>
                    <div class="table-responsive mt-3">
                        <table class="user-table ticket-table review-table theme-table table" id="table_id">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Đánh giá</th>
                                    <th>Tổng số đánh giá</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $index = $reviewsWithProduct->total() - ($reviewsWithProduct->currentPage() - 1) * $reviewsWithProduct->perPage();
                                @endphp
                           
                                @foreach ($reviewsWithProduct as $review)
                                <tr>
                                    
                                    <td class="cursor-pointer sm-width">
                                        {{ $index-- }}
                                    </td>
                                    <td>{{$review->product->name ?? 'N/A'}}</td>
                                    <td>{{$review->user->name ?? 'Guest'}}</td>
                                    <td>
                                        <ul class="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <i data-feather="star"
                                                        class="{{ $i <= round($review->average_rating) ? 'fill text-warning' : '' }}"></i>
                                                </li>
                                            @endfor
                                        </ul>
                                    </td>
                                    <td>{{$review->total_reviews}}</td>
                                    <td>
                                        <ul>
                                            <li><a href="{{ route('admin.reviews.show', ['product' => $review->product->id]) }}"><i class="ri-eye-line"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>     
                </div>
                <!-- START PAGINATION -->
                <div class="custom-pagination">
                    {{ $reviewsWithProduct->appends(request()->query())->links() }}
                </div>
                <!-- END PAGINATIOn -->
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
