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
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title-header">
                            <div class="d-flex align-items-center">
                                <h5>{{ __('form.users') }}</h5>
                            </div>

                        </div>
                        {{-- @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif --}}
                        <!-- HEADER TABLE -->
                        <div class="show-box">
                            <div class="selection-box"><label>{{ __('message.show') }} :</label>
                                <form action="{{ route('admin.comments.index') }}" method="GET" id="filter-form">
                                    <select class="form-control" name="limit" id="limit-select">
                                        <option value="15" {{ request('limit') == 15 ? 'selected' : '' }}>15</option>
                                        <option value="30" {{ request('limit') == 30 ? 'selected' : '' }}>30</option>
                                        <option value="45" {{ request('limit') == 45 ? 'selected' : '' }}>45</option>
                                    </select>
                                </form>
                               
                            </div>
                            <div class="datepicker-wrap">

                            </div>

                            <form action="{{ route('admin.comments.index') }}" method="GET">
                                <div class="table-search">
                                    <label class="form-label">{{ __('message.search') }} :</label>
                                    <input type="search" class="form-control" name="_keyword"
                                           value="{{ $keyword ?? '' }}" placeholder ="Tìm kiếm sản phẩm...">  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                </div>
                            </form>


                        </div>
                        <!-- END HEADER TABLE -->



                        <!-- START TABLE -->
                        <div>
                            <div class="table-responsive datatable-wrapper border-table">

                                <table class="table all-package theme-table no-footer">
                                    <thead>
                                        <tr>
                                           
                                            <th class="sm-width">{{ __('form.comment.stt') }}</th>
                                            <th>{{ __('form.product.name') }}</th>
                                            {{-- <th class="cursor-pointer" id="sort-fullname" data-order="asc"> --}}
                                            {{-- {{ __('form.user.fullname') }} --}}
                                            {{-- <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div> --}}
                                            {{-- </th> --}}

                                            <th class="cursor-pointer"> {{ __('form.comment.sum_cm') }}
                                                {{-- <div class="filter-arrow">
                                                    <div><i class="ri-arrow-up-s-fill"></i></div>
                                                </div> --}}
                                            </th>

                                            <th>{{ __('form.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listComment as $index => $item)
                                            @php
                                                $page = request('page') ?? 1;
                                                $index = $limit * ($page - 1) + $index + 1;
                                            @endphp
                                            <tr>
                                               
                                                <td>{{ $index }}</td>
                                                <td class="cursor-pointer">
                                                    {{ $item->product_name }}
                                                </td>
                                                <td class="cursor-pointer">{{$item->total_comments }}</td>
                                               
                                                <td>
                                                    <ul id="actions">
                                                        <li>
                                                            <a href="{{ route('admin.comments.show', $item->product->slug) }}"
                                                                class="btn-detail">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </li>
                                                        
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END TABLE -->


                        <!-- START PAGINATION -->
                        <div class="custom-pagination">
                            {{ $listComment->links() }}
                        </div>
                        <!-- END PAGINATIOn -->

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
        document.addEventListener('DOMContentLoaded', function() {
        const limitSelect = document.getElementById('limit-select');
        const filterForm = document.getElementById('filter-form');

        limitSelect.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    </script>
@endpush
