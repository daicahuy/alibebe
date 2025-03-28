@extends('admin.layouts.master')

@push('css_library')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('css')
@endpush


@section('content')
    <div class="container-fuild">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>{{ __('form.inventory_history') }}</h5>
                            </div>
                            <div class="d-flex">
                                {{--  --}}
                            </div>
                        </div>

                        <!-- HEADER TABLE -->
                        <form action="{{ route('admin.inventory.history') }}" method="GET" id="filterForm">

                            <div class="show-box">
                                {{-- perpage --}}
                                <div class="selection-box">

                                    <label for="perPageSelect">{{ __('message.show') }} :</label>
                                    <select id="perPageSelect" class="form-control" name="per_page"
                                        onchange="document.querySelector('#filterForm').submit()">
                                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                        <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                                        <option value="45" {{ $perPage == 45 ? 'selected' : '' }}>45</option>
                                    </select>

                                    <label>{{ __('message.items_per_page') }}</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="me-4">
                                        <select name="stock_movement_type" class="form-select"
                                            onchange="document.querySelector('#filterForm').submit()">
                                            <option value="" {{ $stockMovementStatus === null ? 'selected' : '' }}>
                                                {{ __('form.stock_movements_type_all') }}</option>
                                            @foreach (App\Enums\StockMovementType::getValues() as $type)
                                                <option value="{{ $type }}"
                                                    {{ $stockMovementStatus == $type && $stockMovementStatus != null ? 'selected' : '' }}>
                                                    @php
                                                        switch ($type) {
                                                            case App\Enums\StockMovementType::IMPORT:
                                                                echo __('form.stock_movement.import');
                                                                break;
                                                            case App\Enums\StockMovementType::EXPORT:
                                                                echo __('form.stock_movement.export');
                                                                break;
                                                            case App\Enums\StockMovementType::ADJUSTMENT:
                                                                echo __('form.stock_movement.adjustment');
                                                                break;
                                                            default:
                                                                echo __('form.stock_movement.import');
                                                                break;
                                                        }
                                                    @endphp</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- search --}}
                                    <div class="table-search">
                                        <label for="role-search" class="form-label">{{ __('message.search') }} :</label>
                                        <input type="search" class="form-control" name="_keyword"
                                            placeholder="{{ __('form.stock_movements_search_place_holder') }}"
                                            value="{{ $keyword }}">
                                        <button type="submit" class="btn btn-primary">{{ __('message.search') }}</button>
                                    </div>

                                </div>
                                {{-- stock movement type --}}
                            </div>
                        </form>

                        <!-- END HEADER TABLE -->



                        <!-- START TABLE -->
                        <div>
                            <div class="table-responsive datatable-wrapper border-table">

                                <table class="table all-package theme-table no-footer">
                                    <thead>
                                        <tr>
                                            <th class="sm-width"> {{ __('form.stock_movement.created_at') }}</th>
                                            <th class="sm-width"> {{ __('form.stock_movement.code_number') }}</th>
                                            <th class="sm-width"> {{ __('form.stock_movement.type') }}</th>
                                            <th class="sm-width"> {{ __('form.stock_movement.user') }}</th>
                                            <th class="sm-width"> {{ __('form.action') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockMovements as $stockMovement)
                                            <tr>
                                                <td class="cursor-pointer sm-width">{{ $stockMovement->created_at }}</td>
                                                <td class="cursor-pointer sm-width">{{ $stockMovement->code_number }}</td>
                                                <td class="cursor-pointer sm-width">@php
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
                                                @endphp</td>
                                                <td class="cursor-pointer sm-width">{{ $stockMovement->user->fullname }}
                                                </td>
                                                <td class="cursor-pointer sm-width">
                                                    <a href="{{ route('admin.inventory.detail', $stockMovement->id) }}"><i
                                                            class="ri-eye-line"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($stockMovements->isEmpty())
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <p>Không có biến động nào</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END TABLE -->


                        <!-- START PAGINATION -->
                        <div class="custom-pagination">
                            {{ $stockMovements->links() }}
                        </div>
                        <!-- END PAGINATIOn -->

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_library')
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
