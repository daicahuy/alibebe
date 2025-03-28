@extends('admin.layouts.master')


{{-- ================================== --}}
{{--                 CSS                --}}
{{-- ================================== --}}

@push('css_library')
@endpush

@push('css')
@endpush



{{-- ================================== --}}
{{--                 CONTENT            --}}
{{-- ================================== --}}

@section('content')
    <div class="container-fuild">
        <div class="row m-0">

            <div class="col-xl-8 p-0 m-auto">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header option-title">
                                        <h5>
                                            <a class="link"
                                                href="{{ route('admin.inventory.history') }}">{{ __('form.inventory_history') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ $stockMovement->code_number }}

                                        </h5>
                                    </div>
                                    <div class="mt-4">
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.stock_movement.created_at') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $stockMovement->created_at }}"
                                                    class="form-control disabled" disabled>
                                                <div class="invalid-feedback" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.stock_movement.user') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" value="{{ $stockMovement->user->fullname }}"
                                                    class="form-control disabled" disabled>
                                                <div class="invalid-feedback" style="display: none;"></div>
                                            </div>
                                        </div>
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.stock_movement.type') }}
                                            </label>
                                            <div class="col-sm-9">
                                                @php
                                                    switch ($stockMovement->type) {
                                                        case App\Enums\StockMovementType::IMPORT:
                                                            $importText = __('form.stock_movement.import');
                                                            echo "<div class='status-success'>
                                                                <span>$importText</span>
                                                            </div>";
                                                            break;
                                                        case App\Enums\StockMovementType::EXPORT:
                                                            $exportText = __('form.stock_movement.export');
                                                            echo "<div class='status-danger'>
                                                                <span>$exportText</span>
                                                            </div>";
                                                            break;
                                                        case App\Enums\StockMovementType::ADJUSTMENT:
                                                            $adjustmentText = __('form.stock_movement.adjustment');
                                                            echo "<div class='status-pending'>
                                                                <span>$adjustmentText</span>
                                                            </div>";
                                                            break;
                                                        default:
                                                            $importText = __('form.stock_movement.import');
                                                            echo "<div class='status-success'>
                                                                <span>$importText</span>
                                                            </div>";
                                                            break;
                                                    }
                                                @endphp
                                                <div class="invalid-feedback" style="display: none;"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="fw-bolder">Thông tin sản phẩm</h3>
                                    <div class="mt-4">
                                        @foreach ($stockMovement->stockMovementDetail as $stockMovementDetail)
                                            @if ($stockMovementDetail->product)
                                                <div class="py-3 px-2">
                                                    <div class="border">
                                                        <div class="form-group align-items-center g-3 p-3 row">
                                                            <div class="form-group col-1">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Ảnh:
                                                                </label>
                                                                <div class="text-start">
                                                                    <img alt="image" class="tbl-image"
                                                                        src="http://127.0.0.1:8000/storage/{{ $stockMovementDetail->product->thumbnail }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-5">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Tên sản phẩm:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->product->name }}"
                                                                        disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Biến thể:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled" value="Không có" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    SKU:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->product->sku }}"
                                                                        disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Số lượng:
                                                                </label>
                                                                <div>
                                                                    <input type="number" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->quantity }}" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    $nameVariant = '';
                                                    foreach ($stockMovementDetail->productVariant->attributeValues as $attributeValue) {
                                                        $nameVariant .= $attributeValue->value . ' | ';
                                                    }
                                                    $nameVariant = substr($nameVariant, 0, -2);
                                                @endphp
                                                <div class="py-3 px-2">
                                                    <div class="border">
                                                        <div class="form-group align-items-center g-3 p-3 row">
                                                            <div class="form-group col-1">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Ảnh:
                                                                </label>
                                                                <div class="text-start">
                                                                    <img alt="image" class="tbl-image"
                                                                        src="http://127.0.0.1:8000/storage/{{ $stockMovementDetail->productVariant->thumbnail }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-5">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Tên sản phẩm:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->productVariant->product->name }}" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Biến thể:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled" value="{{ $nameVariant }}" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    SKU:
                                                                </label>
                                                                <div>
                                                                    <input type="text" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->productVariant->sku }}" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-2">
                                                                <label class="form-label-title mb-0 w-100"
                                                                    style="text-align: left;">
                                                                    Số lượng:
                                                                </label>
                                                                <div>
                                                                    <input type="number" class="form-control disabled"
                                                                        value="{{ $stockMovementDetail->quantity }}" disabled>
                                                                    <div class="invalid-feedback text-start"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                $(document).ready(function() {

                });
            </script>
        @endpush
