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

            <div class="col-xl-12 p-0">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header option-title">
                                        <h5>
                                            <a class="link"
                                                href="{{ route('admin.products.index') }}">{{ __('form.products') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ __('message.add_new') }}

                                        </h5>
                                    </div>
                                    <form action="{{ route('admin.products.store') }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate>
                                        @csrf

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-2 form-label-title mb-0" for="icon">
                                                {{ __('form.category.select_icon') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="file" name="icon" id="icon" class="form-control">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-2 form-label-title mb-0" for="name">
                                                {{ __('form.category.name') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name"
                                                    class="form-control is-invalid"
                                                    placeholder="{{ __('form.enter_name') }}">
                                                <div class="invalid-feedback">Vui lòng nhập tên</div>
                                            </div>
                                        </div>


                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-2 form-label-title mb-0" for="ordinal">
                                                {{ __('form.category.ordinal') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" name="ordinal" id="ordinal" class="form-control"
                                                    placeholder="{{ __('form.enter_ordinal') }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-2 form-label-title mb-0">
                                                {{ __('form.products_parent') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <select name="parent_id" class="form-select">
                                                    <option value="AL">Điện thoại</option>
                                                    <option value="WY">Máy tính</option>
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-2 form-label-title mb-0">
                                                {{ __('form.category.is_active') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_active" value="1" checked>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-theme ms-auto mt-4" type="submit">
                                            {{ __('message.add_new') }}
                                        </button>
                                    </form>
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
