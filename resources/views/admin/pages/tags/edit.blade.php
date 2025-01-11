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
                                                href="{{ route('admin.tags.index') }}">{{ __('form.tags') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ __('message.edit') }}

                                        </h5>
                                    </div>
                                    <form action="{{ route('admin.tags.store') }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate>
                                        @csrf

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.tag.name') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" id="name"
                                                    class="form-control is-invalid"
                                                    placeholder="{{ __('form.enter_tag_name') }}">
                                                <div class="invalid-feedback">Vui lòng nhập tên thẻ</div>
                                            </div>
                                        </div>

                                        <button class="btn btn-theme ms-auto mt-4" type="submit">
                                            {{ __('message.update') }}
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
