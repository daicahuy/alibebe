@extends('admin.layouts.master')

{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}
@push('css')
@endpush

{{-- ================================== --}}
{{--               CONTENT              --}}
{{-- ================================== --}}
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Chi Tiết {{ __('form.coupons') }}</h5>
                </div>

                <div class="card-body">
                    {{-- Tab Navigation --}}
                    <ul class="nav nav-tabs" id="couponDetailsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                                type="button" role="tab" aria-controls="details" aria-selected="true">Chi Tiết</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="restriction" data-bs-toggle="tab" data-bs-target="#bindings"
                                type="button" role="tab" aria-controls="bindings" aria-selected="false">Ràng
                                Buộc</button>
                        </li>
                    </ul>

                    {{-- Tab Content --}}
                    <div class="tab-content" id="couponDetailsTabContent">
                        {{-- Tab 1: Chi Tiết Mã Giảm Giá --}}
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col-sm-6">
                                    <label for="coupon-code" class="form-label">{{ __('form.coupon.code') }}:</label>
                                    <input type="text" id="coupon-code" class="form-control" value="{{ $coupon->code }}"
                                        readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="coupon-title" class="form-label">{{ __('form.coupon.title') }}:</label>
                                    <input type="text" id="coupon-title" class="form-control"
                                        value="{{ $coupon->title }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <div class="col-sm-12">
                                    <label for="coupon-description">{{ __('form.coupon.description') }}</label>
                                    <textarea id="coupon-description" class="form-control" readonly>{{ $coupon->description }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="discount_type">{{ __('form.coupon.discount_type') }}:</label>
                                    <input type="text" id="discount_type" class="form-control"
                                        value="{{ $coupon->discount_type === 1 ? 'Giảm Theo Phần Trăm' : 'Giảm Theo Số Tiền Cố Định' }}"
                                        readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="discount" class="form-label">
                                        {{ $coupon->discount_type === 1 ? 'Phần Trăm Giảm:' : 'Tiền Giảm:' }}
                                    </label>
                                    <input type="text" id="discount" class="form-control"
                                        value="{{ $coupon->discount_value }} {{ $coupon->discount_type === 1 ? '%' : 'VND' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">{{ __('form.coupon.is_active') }}:</label>
                                    <input type="text" id="status" class="form-control"
                                        value="{{ $coupon->is_active ? 'Hoạt Động' : 'Không Hoạt Động' }}" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">{{ __('form.coupon.is_expired') }}:</label>
                                    <input type="text" id="status" class="form-control"
                                        value="{{ $coupon->is_active ? 'Có Thời Hạn' : 'Không' }}" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="start-date" class="form-label">{{ __('form.coupon.start_date') }}:</label>
                                    <input type="text" id="start-date" class="form-control"
                                        value=" {{ $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') : 'N/A' }}"
                                        readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="end-date" class="form-label">{{ __('form.coupon.end_date') }}:</label>
                                    <input type="text" id="end-date" class="form-control"
                                        value="{{ $coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->locale('vi')->timezone('Asia/Ho_Chi_Minh')->format('d M Y h:i A') : 'N/A' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label for="usage_limit">{{ __('form.coupon.usage_limit') }}</label>
                                    <input type="text" id="usage_limit" class="form-control"
                                        value="{{ $coupon->usage_limit > 0 ? $coupon->usage_limit : 'Không Giới Hạn' }}"
                                        readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label for="usage_count">{{ __('form.coupon.usage_count') }}</label>
                                    <input type="text" id="usage_count" class="form-control"
                                        value="{{ $coupon->usage_count > 0 ? $coupon->usage_count : 'Chưa Được Sử Dụng' }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="user_group">{{ __('form.coupon.user_group') }}</label>
                                    <input type="text" id="user_group" class="form-control"
                                        value="{{ \App\Enums\UserGroupType::getRankDescription($coupon->user_group) }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="d-flex">70up;. 
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                    class="btn btn-primary me-2">Chỉnh Sửa</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('{{ __('message.confirm_move_to_trash_item') }}')">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        {{-- Tab 2: Bảng Ràng Buộc --}}
                        @php
                            $fieldsMapping = [
                                'coupon_id' => 'Id Mã Giảm Giá',
                                'updated_at' => 'Cập Nhật Lần Cuối',
                                'deleted_at' => 'Đã Xóa',
                                'created_at' => 'Ngày Tạo',
                                'valid_categories' => 'Danh Mục Hợp Lệ',
                                'valid_products' => 'Sản Phẩm Hợp Lệ',
                                'max_discount_value' => 'Hạn Mức Tối Đa',
                                'min_order_value' => 'Giá Trị Đơn Hàng Tối Thiểu',
                            ];
                        @endphp

                        <div class="tab-pane fade" id="bindings" role="tabpanel" aria-labelledby="restriction">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-borderless align-middle">
                                    <thead class="table-light">
                                        <caption>Bảng Ràng Buộc Mã Giảm Giá</caption>
                                        <tr>
                                            <th>Trường</th>
                                            <th>Giá Trị</th>
                                        </tr>
                                    </thead>

                                    @foreach ($coupon->restriction->toArray() as $key => $value)
                                        <tbody class="table-light">
                                            <td>
                                                {{ $fieldsMapping[$key] ?? ucfirst(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td>
                                                @switch($key)
                                                    @case('updated_at')
                                                    @case('deleted_at')

                                                    @case('created_at')
                                                        {{ isset($value) ? $value : 'N/A' }}
                                                    @break

                                                    @case('valid_categories')
                                                        <ul>
                                                            @foreach ($coupon->categories as $category)
                                                                <li>{{ $category->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @break

                                                    @case('valid_products')
                                                        <ul>
                                                            @foreach ($coupon->products as $product)
                                                                <li>{{ $product->name }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @break

                                                    @default
                                                        {{ $value }}
                                                @endswitch
                                            </td>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div> {{-- End Tab Content --}}
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
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}',
                timer: 2000
            });
        @endif

        @if ($errors->has('message'))
            Swal.fire({
                icon: 'error',
                title: 'Có lỗi xảy ra',
                text: '{{ $errors->first('message') }}',
                showConfirmButton: true
            });
        @endif
    </script>
@endpush
