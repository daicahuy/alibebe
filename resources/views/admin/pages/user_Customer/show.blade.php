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

                                            @if ($ShowUser->status == 1)
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.index') }}">{{ __('form.users') }}</a>
                                                <span class="fs-6 fw-light">></span> {{ __('message.detail') }}
                                            @else
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.index') }}">{{ __('form.users') }}</a>
                                                <span class="fs-6 fw-light">></span>
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.lock') }}">{{ __('message.lock_list') }}</a>
                                                <span class="fs-6 fw-light">></span> {{ __('message.detail') }}
                                            @endif

                                        </h5>
                                    </div>

                                    <form action="{{ route('admin.users.customer.store') }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate>
                                        @csrf

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="fullname">
                                                {{ __('form.user.fullname') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="fullname" id="fullname" class="form-control"
                                                    value="{{ $ShowUser->fullname }}" disabled>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="phone_number">
                                                {{ __('form.user.phone_number') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="phone_number" id="phone_number"
                                                    class="form-control" value="{{ $ShowUser->phone_number }}" disabled>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="email">
                                                {{ __('form.user.email') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="email" name="email" id="email" class="form-control"
                                                    value="{{ $ShowUser->email }}" disabled>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.user.role') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="role" id="role" class="form-control"
                                                    value="{{ $roleLabel }}" disabled>
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.user.status') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch">
                                                        <input type="checkbox" name="status" value=""
                                                            {{ in_array($ShowUser->status, [1, 2]) ? 'checked' : '' }}
                                                            disabled>
                                                        <span class="switch-state"></span>
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
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
