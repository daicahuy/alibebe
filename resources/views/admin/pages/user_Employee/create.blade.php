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
                                                href="{{ route('admin.users.employee.index') }}">{{ __('form.user_employee') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ __('message.add_new') }}

                                        </h5>

                                    </div>
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.users.employee.store') }}" method="POST"
                                        class="theme-form theme-form-2 mega-form mt-4" novalidate>
                                        @csrf

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="fullname">
                                                {{ __('form.user.fullname') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="fullname" id="fullname"
                                                    class="form-control @error('fullname') is-invalid @enderror"
                                                    placeholder="{{ __('form.enter_name') }}" value="{{ old('fullname') }}">
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
                                                    placeholder="{{ __('form.enter_phone_number') }}"
                                                    value="{{ old('phone_number') }}">
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
                                                    placeholder="{{ __('form.enter_email') }}"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="password">
                                                {{ __('form.user.password') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" name="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="{{ __('form.enter_password') }}">
                                                    <span class="input-group-text toggle-password" toggle="#password">
                                                        <i class="ri-eye-off-line toggle-icon"></i>
                                                    </span>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="password_confirmation">
                                                {{ __('form.user.confirm_password') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation"
                                                        id="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        placeholder="{{ __('form.enter_confirm_password') }}">
                                                    <span class="input-group-text toggle-password"
                                                        toggle="#password_confirmation">
                                                        <i class="ri-eye-off-line toggle-icon"></i>
                                                    </span>
                                                </div>
                                                @error('password_confirmation')
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
                                                <select name="role"
                                                    class="form-select @error('role') is-invalid @enderror">
                                                    @foreach ($roles as $key => $label)
                                                        <option value="{{ $key }}">
                                                            {{ $label }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <button class="btn btn-theme ms-auto mt-4"
                                            type="submit">{{ __('message.add_new') }}</button>
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
            document.querySelectorAll('.toggle-password').forEach(item => {
                item.addEventListener('click', function() {
                    const input = document.querySelector(this.getAttribute('toggle'));
                    const icon = this.querySelector('i');
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove('ri-eye-off-line');
                        icon.classList.add('ri-eye-line');
                    } else {
                        input.type = "password";
                        icon.classList.remove('ri-eye-line');
                        icon.classList.add('ri-eye-off-line');
                    }
                });
            });
        });
    </script>
@endpush
