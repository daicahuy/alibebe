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
                data-bs-target="#add-address">
                <i data-feather="plus" class="me-2"></i>
                {{ __('message.add_new') }} {{ __('form.user_addresses') }}
            </button>
        </div>

        <div class="row g-sm-4 g-3">
            @foreach ($addresses as $key => $address)
                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                    <div class="address-box" data-id="{{ $address->id }}">
                        <!-- Nội dung bên trong address-box -->
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_default"
                                    id="is flexRadioDefault{{ $address->id }}" value="{{ $address->id }}"
                                    @if ($address->is_default === 1) checked @endif>
                            </div>

                            <div class="label">
                                <label for="flexRadioDefault{{ $address->id }}">Nhà</label>
                            </div>

                            <div class="table-responsive address-table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">{{ __('form.user_addresses') . ' ' . ($key + 1) }}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('form.user_addresses') }} :</td>
                                            <td>
                                                <p class="text-truncate d-inline-block" style="max-width: 150px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $address->address }}">
                                                    {{ $address->address }}
                                                </p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('form.user.fullname') }}</td>
                                            <td>
                                                {{ $address->fullname }}
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
                            <button class="btn btn-sm add-button w-100" data-bs-toggle="modal" data-bs-target="#editAddress"
                                data-id="{{ $address->id }}" data-address="{{ $address->address }}"
                                data-fullname="{{ $address->fullname }}" data-phone_number="{{ $address->phone_number }}"
                                data-default="{{ $address->is_default }}">
                                <i data-feather="edit"></i>
                                {{ __('message.edit') }}
                            </button>
                            <button class="btn btn-sm add-button w-100" data-bs-toggle="modal"
                                data-bs-target="#removeAddress" data-id="{{ $address->id }}"
                                data-address="{{ $address->address }}" data-id-default="{{ $address->is_default }}">
                                <i data-feather="trash-2"></i>
                                {{ __('message.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Hidden form for updating default address -->
    <form id="defaultAddressForm" method="POST" action="{{ route('account.update-default-address') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="address_id" id="defaultAddressId" value="">
    </form>

    <nav class="custom-pagination">
        {{ $addresses->links() }}
    </nav>
@endsection

@section('modal')
    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add-address" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('message.create') . ' ' . __('form.user_addresses') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form action="{{ route('account.store-address') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Mời Nhập {{ __('form.user_addresses') }}">
                            <label for="address">{{ __('form.user_addresses') }}</label>
                            <span></span>
                        </div>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="fullname" id="fullname"
                                placeholder="Mời Nhập {{ __('form.user.fullname') }}">
                            <label for="fullname">{{ __('form.user.fullname') }}</label>
                        </div>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                placeholder="Mời Nhập {{ __('form.user.phone_number') }}">
                            <label for="phone_number">{{ __('form.user.phone_number') }}</label>
                        </div>
                        <div class="form-group mb-4">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                    value="1">
                                <label class="form-check-label fw-bold" for="is_default">Đặt Làm Mặc Định</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">
                            {{ __('message.cancel') }}
                        </button>
                        <button type="submit" class="btn theme-bg-color btn-md text-white" data-bs-dismiss="modal">
                            {{ __('message.create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->
    <!-- Modal Edit Address -->
    <div class="modal fade" id="editAddress" tabindex="-1" aria-labelledby="editAddressLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressLabel">{{ __('message.edit') }}
                        {{ __('form.user_addresses') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('form.user_addresses') }}</label>
                            <input type="text" class="form-control" name="address" id="address">
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">{{ __('form.user.fullname') }}</label>
                            <input type="text" class="form-control" name="fullname" id="fullname">
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">{{ __('form.user.phone_number') }}</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number">
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="is_default" name="is_default"
                                value="1">
                            <label class="form-check-label fw-bold"
                                for="is_default">{{ __('form.user_address.is_default') }}</label>
                        </div>
                        <button type="submit" class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3">
                            {{ __('message.edit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Remove Profile Modal Start -->
    <div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Kiểm Tra Lại ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <h4 class="text-content">{{ __('message.confirm_delete_item') }}</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteAddressForm">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('message.cancel') }}
                            </button>
                            <button type="submit" class="btn theme-bg-color btn-md fw-bold text-light">
                                {{ __('message.delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Remove Profile Modal End -->
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('[data-bs-target="#removeAddress"]').click(function() {
                // Lấy id từ thuộc tính data-id
                const addressId = $(this).data('id');
                // Đặt id vào action của form trong modal
                $('#deleteAddressForm').attr('action', '/account/delete-address/' + addressId);
            });
        });

        // Xử lý khi nhấn vào nút Edit
        $('[data-bs-target="#editAddress"]').click(function() {
            // Lấy dữ liệu từ thuộc tính data-*
            const addressId = $(this).data('id');
            const address = $(this).data('address');
            const fullname = $(this).data('fullname');
            const phone_number = $(this).data('phone_number');
            const isDefault = $(this).data('default');
            console.log(address, fullname, phone_number);

            // Gán giá trị vào form trong modal
            $('#editAddress input[name="address"]').val(address);
            $('#editAddress input[name="fullname"]').val(fullname);
            $('#editAddress input[name="phone_number"]').val(phone_number);
            $('#editAddress input[name="is_default"]').prop('checked', isDefault === 1);

            // Thiết lập action cho form với ID của địa chỉ
            $('#editAddress form').attr('action', '/account/update-address/' + addressId);
        });

        $('.address-box').on('click', function(e) {
            if ($(e.target).is('button') || $(e.target).is('input') || $(e.target).closest('button').length || $(
                    '#is').is(':checked')) {
                return;
            }

            if ($(this).find('input[name="is_default"]').is(':checked')) {
                return;
            }

            const addressId = $(this).data('id');

            // Gán id này vào input ẩn
            $('#defaultAddressId').val(addressId);

            // Submit form
            $('#defaultAddressForm').submit();
        });
    </script>
@endpush
