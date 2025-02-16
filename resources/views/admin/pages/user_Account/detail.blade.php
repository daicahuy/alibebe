@extends('admin.layouts.master')

@section('content')
    <div class="container-fuild">
        <div class="row m-0">

            <div class="col-xl-8 p-0 m-auto">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="title-header">
                                        <div class="d-flex align-items-center">
                                            <h5>Tài khoản của tôi</h5>
                                        </div>
                                    </div><!---->
                                    <div class="inside-horizontal-tabs mt-0">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <!-- Tab Thiết lập hồ sơ -->
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#profile" type="button" role="tab"
                                                    aria-controls="profile" aria-selected="true">
                                                    <i class="ri-account-pin-box-line"></i> Thiết lập hồ sơ
                                                </button>
                                            </li>

                                            <!-- Tab Thay đổi mật khẩu -->
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                                    data-bs-target="#password" type="button" role="tab"
                                                    aria-controls="password" aria-selected="false">
                                                    <i class="ri-phone-lock-line"></i> Thay đổi mật khẩu
                                                </button>
                                            </li>
                                        </ul>
                                        <div class="tab-content mt-3" id="myTabContent">
                                            <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                                aria-labelledby="profile-tab">
                                                <form
                                                    action="{{ route('admin.account.updateProvider', ['user' => $user->id]) }}"
                                                    method="POST"
                                                enctype="multipart/form-data"
                                                    class="theme-form theme-form-2 mega-form ng-untouched ng-pristine ng-valid">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row"><app-form-fields>
                                                            <div class="align-items-center g-2 mb-4 row"><label
                                                                    class="col-sm-2 form-label-title mb-0" for="avatar">
                                                                    Ảnh<!----></label>
                                                                <div class="col-sm-10">
                                                                    @if ($user->avatar)
                                                                    <img alt="avatar" class="tbl-image icon-image"
                                                                        src="{{ Storage::url($user->avatar) }}" style="width: 100px;height:100px;">
                                                                @else
                                                                    <img alt="image" class="tbl-image icon-image"
                                                                        src="{{ asset('/theme/admin/assets/images/categories/no-image.svg') }}">
                                                                @endif
                                                                    <input class="mt-1" type="file" name="avatar"
                                                                        class="form-control ng-untouched ng-pristine ng-valid">
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-fo>
                                                            <div class="align-items-center g-2 mb-4 row"><label
                                                                    class="col-sm-2 form-label-title mb-0" for="fullname">
                                                                    Họ và Tên<span
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div class="col-sm-10"><input type="text" name="fullname"
                                                                        class="form-control ng-untouched ng-pristine ng-valid @error('fullname') is-invalid @enderror"
                                                                        placeholder="Nhập Họ và Tên" 
                                                                        value="{{ $user->fullname }}"><!----> 
                                                                        @error('fullname')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                       
                                                            </div>
                                                            </app-form-fields><app-fo>
                                                                <div class="align-items-center g-2 mb-4 row"><label
                                                                        class="col-sm-2 form-label-title mb-0"
                                                                        for="email"> Email<span
                                                                            class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                    <div class="col-sm-10"><input type="text"
                                                                            name="email" 
                                                                            class="form-control ng-untouched ng-pristine ng-valid @error('email') is-invalid @enderror"
                                                                            placeholder="Nhập Email"
                                                                            value="{{ $user->email }}"
                                                                           ><!----><!---->   @error('email')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                        @enderror</div>
                                                                        
                                                                </div>
                                                                </app-form-fields><app-fo>
                                                                    <div class="align-items-center g-2 mb-4 row"><label
                                                                            class="col-sm-2 form-label-title mb-0"
                                                                            for="phone_number"> Số điện thoại<span
                                                                                class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                        <div class="col-sm-10">
                                                                            </select2><input type="number"
                                                                                placeholder="Nhập Số điện thoại"
                                                                                name="phone_number"
                                                                                value="{{ $user->phone_number }}"
                                                                                class="form-control ng-untouched ng-pristine ng-valid @error('phone_number') is-invalid @enderror"
                                                                                ><!----><!---->
                                                                                @error('phone_number')
                                                                                <span class="text-danger">{{ $message }}</span>
                                                                                @enderror
                                                                        </div>
                                                                    </div>
                                                                    </app-form-fields></div>

                                                    <app-button><button class="btn btn-theme ms-auto mt-4" id="profile_btn"
                                                            type="submit" fdprocessedid="yhhr32">
                                                            <div>Lưu</div>
                                                        </button></app-button>

                                                </form><!---->
                                            </div><!---->
                                            <div class="tab-pane fade" id="password" role="tabpanel"
                                                aria-labelledby="password-tab">
                                                <form
                                                    action="{{ route('admin.account.updatePassword', ['user' => $user->id]) }}"
                                                    method="POST"
                                                    class="theme-form theme-form-2 mega-form ng-untouched ng-pristine ng-invalid">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <app-form-fields>
                                                            <div class="align-items-center g-2 mb-4 row">
                                                                <label class="col-sm-2 form-label-title mb-0" for="current_password">
                                                                    Mật khẩu cũ<span class="theme-color ms-2 required-dot">*</span>
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input type="password" name="current_password"
                                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                                        placeholder="Nhập mật khẩu cũ">
                                                                        
                                                                    @error('current_password')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                        <app-form-fields>
                                                            <div class="align-items-center g-2 mb-4 row"><label
                                                                    class="col-sm-2 form-label-title mb-0"
                                                                    for="new_password">
                                                                    Mật khẩu mới<span
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div class="col-sm-10"><input type="password"
                                                                        name="new_password"
                                                                        class="form-control @error('new_password') is-invalid @enderror"
                                                                        placeholder="Nhập mật khẩu mới"><!----><!----><!---->
                                                                    @error('new_password')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </app-form-fields><app-form-fields>
                                                            <div class="align-items-center g-2 mb-4 row"><label
                                                                    class="col-sm-2 form-label-title mb-0"
                                                                    for="password_confirmation"> Xác nhận mật khẩu mới<span
                                                                        class="theme-color ms-2 required-dot">*</span><!----></label>
                                                                <div class="col-sm-10"><input type="password"
                                                                        name="password_confirmation"
                                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                        placeholder="Xác nhận mật khẩu mới"><!----><!----><!---->
                                                                    @error('password_confirmation')
                                                                        <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </app-form-fields>
                                                    </div><app-button><button class="btn btn-theme ms-auto mt-4"
                                                            id="password_btn" type="submit">
                                                            <div>Lưu</div>
                                                        </button></app-button>
                                                </form><!---->
                                            </div><!----><!---->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
<script>
    $(document).ready(function () {

        @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: "{{ session('success') }}",
                        timer: 1500,
                        showConfirmButton: true
                    });
        @endif
        


        let activeTab = localStorage.getItem('activeTab'); // Lấy tab đã lưu

        if (activeTab) {
            let tabElement = $(`#myTab button[data-bs-target="${activeTab}"]`);
            if (tabElement.length) {
                new bootstrap.Tab(tabElement[0]).show(); // Hiển thị tab đã lưu
            }
        }

        // Khi click vào tab, lưu lại trạng thái
        $('#myTab button[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
            let tabId = $(event.target).attr('data-bs-target');
            localStorage.setItem('activeTab', tabId);
        });
    });
</script>

@endpush
