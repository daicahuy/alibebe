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
                                                href="{{ route('admin.attributes.index') }}">{{ __('form.attributes') }}</a>
                                            <span class="fs-6 fw-light">></span> {{ __('message.edit') }}

                                        </h5>
                                    </div>
                                    <form action="{{ route('admin.attributes.update',$attribute->id) }}" method="POST" class="theme-form theme-form-2 mega-form mt-4"
                                        novalidate>
                                        @csrf
                                        @method('PUT')
                                        {{-- Name --}}
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0" for="name">
                                                {{ __('form.attribute.name') }}
                                                <span class="theme-color ms-2 required-dot ">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" id="name"
                                                    class="form-control @error('name') is-invalid @enderror" value="{{$attribute->name}}"
                                                    placeholder="{{ __('form.enter_attribute_name') }}">
                                                    @error('name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                            </div>
                                        </div>
                                        {{-- Is_variant --}}
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.attribute.is_variant') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_variant" value="1" {{ $attribute->is_variant ? 'checked' : '' }}>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Is_active --}}
                                        <div class="align-items-center g-2 mb-4 row">
                                            <label class="col-sm-3 form-label-title mb-0">
                                                {{ __('form.attribute.is_active') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-switch ps-0">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_active" value="1" {{ $attribute->is_active ? 'checked' : '' }}>
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Button  --}}
                                        <button class="btn btn-theme ms-auto mt-4" type="submit">
                                            {{ __('message.edit') }}
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
            @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: "{{ session('success') }}",
                        timer: 1500,
                        showConfirmButton: true
                    });
            @endif

            @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: "{{ session('error') }}",
                        showConfirmButton: true
                    });
            @endif
            
            $("#name").on("blur", function() {
                let name = $(this).val().trim(); // Lấy giá trị nhập vào

                if (name === "") {
                    $(this).removeClass("is-invalid"); // Xóa class lỗi
                    $(".invalid-feedback").hide(); // Ẩn thông báo lỗi
                }
            });

            $("#name").on("click", function() {
                if ($(this).hasClass("is-invalid")) {
                    $(".invalid-feedback").show(); // Nếu có lỗi, giữ nguyên thông báo
                }
            });
        });
    </script>
@endpush
