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
                                            <td>{{ $address->phone_number }}</td>
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
                    <!-- Trong file blade (modal thêm địa chỉ) -->
                    <div class="modal-body">
                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="province" name="province_id" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                            <label for="province">Tỉnh/Thành phố</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="district" name="district_id" required disabled>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            <label for="district">Quận/Huyện</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="ward" name="ward_id" required disabled>
                                <option value="">Chọn phường/xã</option>
                            </select>
                            <label for="ward">Phường/Xã</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="address_detail" id="address_detail"
                                placeholder="Nhập địa chỉ chi tiết">
                            <label for="address_detail">Địa chỉ chi tiết (Thôn , Số Nhà)</label>
                        </div>

                        <input type="hidden" name="address" id="address">
                        <input type="hidden" name="province_text" id="province_text">
                        <input type="hidden" name="district_text" id="district_text">
                        <input type="hidden" name="ward_text" id="ward_text">

                        <div class="form-floating mb-4 theme-form-floating"> <input type="text" class="form-control"
                                name="fullname" id="fullname" placeholder="Mời Nhập {{ __('form.user.fullname') }}">
                            <label for="fullname">{{ __('form.user.fullname') }}</label>
                        </div>
                        <div class="form-floating mb-4 theme-form-floating"> <input type="text" class="form-control"
                                name="phone_number" id="phone_number"
                                placeholder="Mời Nhập {{ __('form.user.phone_number') }}"> <label
                                for="phone_number">{{ __('form.user.phone_number') }}</label> </div>
                        <div class="form-group mb-4">
                            <div class="form-check form-switch"> <input type="checkbox" class="form-check-input"
                                    id="is_default" name="is_default" value="1"
                                    @if (
                                        !isset($addresses) ||
                                            $addresses->isEmpty() ||
                                            ($addresses->isNotEmpty() && !$addresses->where('is_default', 1)->count())) checked onclick="return false;" @endif> <label
                                    class="form-check-label fw-bold" for="is_default">Đặt Làm Mặc Định</label> </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">
                            {{ __('message.cancel') }}
                        </button>
                        <button type="submit" class="btn theme-bg-color btn-md text-white">
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
                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="edit_province" name="province_id" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                            <label for="edit_province">Tỉnh/Thành phố</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="edit_district" name="district_id" required>
                                <option value="">Chọn quận/huyện</option>
                            </select>
                            <label for="edit_district">Quận/Huyện</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <select class="form-control" id="edit_ward" name="ward_id" required>
                                <option value="">Chọn phường/xã</option>
                            </select>
                            <label for="edit_ward">Phường/Xã</label>
                        </div>

                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="address_detail" id="edit_address_detail"
                                placeholder="Nhập địa chỉ chi tiết">
                            <label for="edit_address_detail">Địa chỉ chi tiết (Thôn , Số Nhà)</label>
                        </div>

                        <input type="hidden" name="address" id="edit_address">
                        <input type="hidden" name="province_text" id="edit_province_text">
                        <input type="hidden" name="district_text" id="edit_district_text">
                        <input type="hidden" name="ward_text" id="edit_ward_text">

                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="fullname" id="edit_fullname">
                            <label for="edit_fullname">{{ __('form.user.fullname') }}</label>
                        </div>
                        
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" name="phone_number" id="edit_phone_number">
                            <label for="edit_phone_number">{{ __('form.user.phone_number') }}</label>
                        </div>
                        
                        <div class="form-check form-switch mb-4">
                            <input type="checkbox" class="form-check-input" id="edit_is_default" name="is_default"
                                value="1">
                            <label class="form-check-label fw-bold"
                                for="edit_is_default">{{ __('form.user_address.is_default') }}</label>
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
        // Trong file JavaScript
        $(document).ready(function() {
            // Biến toàn cục để lưu trữ dữ liệu tỉnh/thành phố
            let provinceData = [];

            // Load danh sách tỉnh từ API
            $.get('https://provinces.open-api.vn/api/p/', function(provinces) {
                provinceData = provinces;
                
                // Thêm vào select box tạo mới
                $('#province').empty().append('<option value="">Chọn tỉnh/thành phố</option>');
                $('#edit_province').empty().append('<option value="">Chọn tỉnh/thành phố</option>');
                
                provinces.forEach(function(province) {
                    $('#province').append($('<option>', {
                        value: province.code,
                        text: province.name
                    }));
                    
                    $('#edit_province').append($('<option>', {
                        value: province.code,
                        text: province.name
                    }));
                });
            });

            // Khi chọn tỉnh trong modal tạo mới
            $('#province').change(function() {
                var provinceCode = $(this).val();
                var provinceName = $('#province option:selected').text();
                $('#province_text').val(provinceName);
                
                if (provinceCode) {
                    $('#district').prop('disabled', false);
                    $.get(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`, function(province) {
                        $('#district').empty().append('<option value="">Chọn quận/huyện</option>');
                        province.districts.forEach(function(district) {
                            $('#district').append($('<option>', {
                                value: district.code,
                                text: district.name
                            }));
                        });
                    });
                } else {
                    $('#district, #ward').prop('disabled', true).empty().append(
                        '<option value="">Chọn...</option>');
                }
                updateAddress();
            });

            // Khi chọn huyện trong modal tạo mới
            $('#district').change(function() {
                var districtCode = $(this).val();
                var districtName = $('#district option:selected').text();
                $('#district_text').val(districtName);
                
                if (districtCode) {
                    $('#ward').prop('disabled', false);
                    $.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`, function(district) {
                        $('#ward').empty().append('<option value="">Chọn phường/xã</option>');
                        district.wards.forEach(function(ward) {
                            $('#ward').append($('<option>', {
                                value: ward.code,
                                text: ward.name
                            }));
                        });
                    });
                } else {
                    $('#ward').prop('disabled', true).empty().append(
                        '<option value="">Chọn phường/xã</option>');
                }
                updateAddress();
            });
            
            // Khi chọn xã trong modal tạo mới
            $('#ward').change(function() {
                var wardName = $('#ward option:selected').text();
                $('#ward_text').val(wardName);
                updateAddress();
            });

            // Cập nhật địa chỉ khi có thay đổi trong modal tạo mới
            $('#ward, #address_detail').on('change input', updateAddress);

            function updateAddress() {
                const province = $('#province option:selected').text() !== 'Chọn tỉnh/thành phố' ? $('#province option:selected').text() : '';
                const district = $('#district option:selected').text() !== 'Chọn quận/huyện' ? $('#district option:selected').text() : '';
                const ward = $('#ward option:selected').text() !== 'Chọn phường/xã' ? $('#ward option:selected').text() : '';
                
                // Thay thế dấu phẩy trong địa chỉ chi tiết bằng dấu chấm phẩy
                const detail = $('#address_detail').val().trim().replace(/,/g, ';');
                
                // Tạo địa chỉ đầy đủ
                const fullAddress = [detail, ward, district, province].filter(item => item && item !== '').join(', ');
                $('#address').val(fullAddress);
            }
            
            // Khi chọn tỉnh trong modal chỉnh sửa
            $('#edit_province').change(function() {
                var provinceCode = $(this).val();
                var provinceName = $('#edit_province option:selected').text();
                $('#edit_province_text').val(provinceName);
                
                if (provinceCode) {
                    $('#edit_district').prop('disabled', false);
                    $.get(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`, function(province) {
                        $('#edit_district').empty().append('<option value="">Chọn quận/huyện</option>');
                        province.districts.forEach(function(district) {
                            $('#edit_district').append($('<option>', {
                                value: district.code,
                                text: district.name
                            }));
                        });
                    });
                } else {
                    $('#edit_district, #edit_ward').prop('disabled', true).empty().append(
                        '<option value="">Chọn...</option>');
                }
                updateEditAddress();
            });

            // Khi chọn huyện trong modal chỉnh sửa
            $('#edit_district').change(function() {
                var districtCode = $(this).val();
                var districtName = $('#edit_district option:selected').text();
                $('#edit_district_text').val(districtName);
                
                if (districtCode) {
                    $('#edit_ward').prop('disabled', false);
                    $.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`, function(district) {
                        $('#edit_ward').empty().append('<option value="">Chọn phường/xã</option>');
                        district.wards.forEach(function(ward) {
                            $('#edit_ward').append($('<option>', {
                                value: ward.code,
                                text: ward.name
                            }));
                        });
                    });
                } else {
                    $('#edit_ward').prop('disabled', true).empty().append(
                        '<option value="">Chọn phường/xã</option>');
                }
                updateEditAddress();
            });
            
            // Khi chọn xã trong modal chỉnh sửa
            $('#edit_ward').change(function() {
                var wardName = $('#edit_ward option:selected').text();
                $('#edit_ward_text').val(wardName);
                updateEditAddress();
            });

            // Cập nhật địa chỉ khi có thay đổi trong modal chỉnh sửa
            $('#edit_ward, #edit_address_detail').on('change input', updateEditAddress);

            function updateEditAddress() {
                const province = $('#edit_province option:selected').text() !== 'Chọn tỉnh/thành phố' ? $('#edit_province option:selected').text() : '';
                const district = $('#edit_district option:selected').text() !== 'Chọn quận/huyện' ? $('#edit_district option:selected').text() : '';
                const ward = $('#edit_ward option:selected').text() !== 'Chọn phường/xã' ? $('#edit_ward option:selected').text() : '';
                
                // Thay thế dấu phẩy trong địa chỉ chi tiết bằng dấu chấm phẩy
                const detail = $('#edit_address_detail').val().trim().replace(/,/g, ';');
                
                // Tạo địa chỉ đầy đủ
                const fullAddress = [detail, ward, district, province].filter(item => item && item !== '').join(', ');
                $('#edit_address').val(fullAddress);
            }

            // Xử lý khi nhấn vào nút xóa
            $('[data-bs-target="#removeAddress"]').click(function() {
                // Lấy id từ thuộc tính data-id
                const addressId = $(this).data('id');
                // Đặt id vào action của form trong modal
                $('#deleteAddressForm').attr('action', '/account/delete-address/' + addressId);
            });

            // Xử lý khi nhấn vào nút Edit
            $('[data-bs-target="#editAddress"]').click(function() {
                // Lấy dữ liệu từ thuộc tính data-*
                const addressId = $(this).data('id');
                const address = $(this).data('address');
                const fullname = $(this).data('fullname');
                const phone_number = $(this).data('phone_number');
                const isDefault = $(this).data('default');
                
                // Phân tích địa chỉ để lấy các phần tử
                const addressParts = address.split(', ');
                
                // Giả sử địa chỉ có định dạng: chi tiết, phường/xã, quận/huyện, tỉnh/thành
                const provinceName = addressParts.length > 3 ? addressParts[addressParts.length - 1] : '';
                const districtName = addressParts.length > 2 ? addressParts[addressParts.length - 2] : '';
                const wardName = addressParts.length > 1 ? addressParts[addressParts.length - 3] : '';
                
                // Phần còn lại là địa chỉ chi tiết
                const detailAddress = addressParts.length > 3 ? 
                    addressParts.slice(0, addressParts.length - 3).join(', ') : 
                    (addressParts.length > 0 ? addressParts[0] : '');
                
                // Load danh sách tỉnh và chọn tỉnh phù hợp
                $('#edit_province option').each(function() {
                    if ($(this).text() === provinceName) {
                        $(this).prop('selected', true);
                        $('#edit_province').trigger('change');
                        
                        // Đặt timeout để đảm bảo API đã load danh sách quận/huyện
                        setTimeout(function() {
                            // Chọn quận/huyện phù hợp
                            $('#edit_district option').each(function() {
                                if ($(this).text() === districtName) {
                                    $(this).prop('selected', true);
                                    $('#edit_district').trigger('change');
                                    
                                    // Đặt timeout để đảm bảo API đã load danh sách phường/xã
                                    setTimeout(function() {
                                        // Chọn phường/xã phù hợp
                                        $('#edit_ward option').each(function() {
                                            if ($(this).text() === wardName) {
                                                $(this).prop('selected', true);
                                                $('#edit_ward').trigger('change');
                                            }
                                        });
                                    }, 500);
                                }
                            });
                        }, 500);
                    }
                });
                
                // Đặt giá trị địa chỉ chi tiết
                $('#edit_address_detail').val(detailAddress);
                
                // Gán giá trị khác vào form trong modal
                $('#edit_fullname').val(fullname);
                $('#edit_phone_number').val(phone_number);
                $('#edit_is_default').prop('checked', isDefault === 1);
                
                // Đặt giá trị ban đầu cho địa chỉ đầy đủ
                $('#edit_address').val(address);

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
        });
    </script>
@endpush