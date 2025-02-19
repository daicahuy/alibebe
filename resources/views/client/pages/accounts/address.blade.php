@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-address">
        <div class="title title-flex">
            <div>
                <h2>{{ __('form.account.address_book') }}</h2>
                <span class="title-leaf">
                    <svg class="icon-width bg-gray">
                        <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                        </use>
                    </svg>
                </span>
            </div>

            <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3" data-bs-toggle="modal"
                data-bs-target="#add-address"><i data-feather="plus" class="me-2"></i> Thêm Mới Địa Chỉ</button>
        </div>

        <div class="row g-sm-4 g-3">
            @foreach ($addresses as $address)
                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                    <div class="address-box">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="id_default" id="flexRadioDefault2"
                                    @if ($address->id_default === 1) checked @endif>
                            </div>

                            <div class="label">
                                <label>Nhà</label>
                            </div>

                            <div class="table-responsive address-table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">{{ __('form.user_addresses') }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('form.user_addresses') }} :</td>
                                            <td>
                                                <p>
                                                    {{ $address->address }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('form.user_address.created_at') }}</td>
                                            <td>
                                                {{ $address->created_at }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('form.user.phone_number') }} :</td>
                                            <td>{{ $address->user->phone_number }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="button-group">
                            <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                data-bs-target="#editProfile"><i data-feather="edit"></i>
                                Sửa</button>
                            <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                data-bs-target="#removeProfile">
                                <i data-feather="trash-2"></i>
                                Xóa</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('modal')
    <!-- Remove Profile Modal Start -->
    <div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box">
                        <p>The permission for the use/group, preview is inherited from the object, object will create a
                            new permission for this object</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                        data-bs-target="#removeAddress" data-bs-toggle="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <h4 class="text-content">It's Removed.</h4>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Remove Profile Modal End -->
@endsection
