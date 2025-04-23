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
                                            @if ($EditUser->status == 1)
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.index') }}">{{ __('form.users') }}</a>
                                                <span class="fs-6 fw-light">></span> {{ __('message.edit') }}
                                            @else
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.index') }}">{{ __('form.users') }}</a><span
                                                    class="fs-6 fw-light">></span>
                                                <a class="link"
                                                    href="{{ route('admin.users.customer.lock') }}">{{ __('message.lock_list') }}</a>
                                                <span class="fs-6 fw-light">></span> {{ __('message.detail') }}
                                            @endif

                                        </h5>
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

                                    <form action="{{ route('admin.users.customer.update', $EditUser->id) }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate>
                                        @csrf
                                        @method('PUT')

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="fullname">
                                                {{ __('form.user.fullname') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="fullname" id="fullname"
                                                    class="form-control @error('fullname') is-invalid @enderror"
                                                    value="{{ $EditUser->fullname }}">
                                                @error('fullname')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="phone_number">
                                                {{ __('form.user.phone_number') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="phone_number" id="phone_number"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    value="{{ $EditUser->phone_number }}">
                                                @error('phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="email">
                                                {{ __('form.user.email') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="email" name="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ $EditUser->email }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.user.role') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select name="role" class="form-select">
                                                    @foreach ($roles as $key => $label)
                                                        <option value="{{ $key }}"
                                                            {{ $EditUser->role == $key ? 'selected' : '' }}>
                                                            {{ $label }}</option>
                                                    @endforeach

                                                </select>
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
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: "{{ session('error') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
        });

        $(document).ready(function() {

        });
    </script>
@endpush
