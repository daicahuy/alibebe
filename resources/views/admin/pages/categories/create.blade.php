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
                                                href="{{ route('admin.categories.index') }}">{{ __('form.categories') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ __('message.add_new') }}

                                        </h5>
                                    </div>



                                    {{-- @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show"
                                            role="alert">
                                            <strong>{{ __('message.error') }}</strong> {{ __('message.error_message') }}
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>
                                                        <span>{{ $error }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif --}}


                                    <form action="{{ route('admin.categories.store') }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate
                                        enctype="multipart/form-data">
                                        @csrf

                                        {{-- <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.category.icon') }}
                                            </label>
                                            <div class="col-sm-9">
                                                @if ($request->icon)
                                                        <img alt="image" class="tbl-image icon-image"
                                                            src="{{ Storage::url($request->icon) }}">
                                                    @else
                                                        <img alt="image" class="tbl-image icon-image"
                                                            src="{{ asset('/theme/admin/assets/images/categories/no-image.svg') }}">
                                                    @endif
                                            </div>
                                        </div> --}}


                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="icon">
                                                {{ __('form.select_icon') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="file" name="icon" id="icon"
                                                    class="form-control @error('icton') is-invalid @enderror">
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.category.name') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name') }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="{{ __('form.enter_name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="ordinal">
                                                {{ __('form.category.ordinal') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="number" name="ordinal" id="ordinal"
                                                    value="{{ old('ordinal') }}"
                                                    class="form-control @error('ordinal') is-invalid @enderror"
                                                    placeholder="{{ __('form.enter_ordinal') }}">
                                                @error('ordinal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.categories_parent') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <select name="parent_id" class="form-select">
                                                    <option value="">Chọn danh mục cha</option>
                                                    @foreach ($parent as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.category.is_active') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_active" value="1" checked
                                                            id="isActive">
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
            // $('#isActive').change(function() {
            //     if ($(this).is(':checked')) {
            //         $(this).val(1);
            //     } else {
            //         $(this).val(0);
            //     }
            // });
            
        });
    </script>
@endpush
