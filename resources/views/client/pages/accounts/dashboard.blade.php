@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-home">
        <div class="title">
            <h2>Trang Quản Trị</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>

        <div class="dashboard-user-name">
            <h6 class="text-content">Xin Chào, <b class="text-title">Vicki E. Pope</b></h6>
            <p class="text-content">Bạn sẽ thấy toàn bộ thông tin của bạn ở đây !!!</p>
        </div>

        <div class="total-box">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/order.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_order') }}</h5>
                            <h3>3658</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/pending.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_pending_order') }}</h5>
                            <h3>254</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                    <div class="total-contain">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/wishlist.svg"
                            class="img-1 blur-up lazyload" alt="">
                        <img src="https://themes.pixelstrap.com/fastkart/assets/images/svg/wishlist.svg"
                            class="blur-up lazyload" alt="">
                        <div class="total-detail">
                            <h5>{{ __('form.account.total_wishlist') }}</h5>
                            <h3>32158</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-title">
            <h3>
                {{ __('form.account.account_infomation') }}
            </h3>
        </div>

        <div class="row g-4">
            <div class="col-xxl-6">
                <div class="dashboard-content-title">
                    <h4>
                        {{ __('form.account.contact_infomation') }}
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editProfile">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                    </h4>
                </div>
                <div class="dashboard-detail">
                    <h6 class="text-content">MARK JECNO</h6>
                    <h6 class="text-content">vicki.pope@gmail.com</h6>
                    <a href="javascript:void(0)">Change Password</a>
                </div>
            </div>

            <div class="col-xxl-6">
                <div class="dashboard-content-title">
                    <h4>Rank - Cấp Bậc
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewRank">
                            <i class="fas fa-eye"></i>
                        </a>
                    </h4>
                </div>
                <div class="dashboard-detail">
                    <h6 class="text-content">Your current rank is: Bronze</h6>
                </div>
            </div>
            

            <div class="col-12">
                <div class="dashboard-content-title">
                    <h4>
                        {{__('form.account.address_book')}}
                        <a href="javascript:void(0)" data-bs-toggle="modal"
                            data-bs-target="#editProfile">
                            <i class="fa fa-pencil-alt"></i>
                        </a>
                        </h4>
                </div>

                <div class="row g-4">
                    <div class="col-xxl-6">
                        <div class="dashboard-detail">
                            <h6 class="text-content">Default Billing Address</h6>
                            <h6 class="text-content">You have not set a default billing
                                address.</h6>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editProfile">
                                <i class="fa fa-pencil-alt"></i>
                                Chỉnh sửa địa chỉ mặc định
                            </a>
                        </div>
                    </div>

                    <div class="col-xxl-6">
                        <div class="dashboard-detail">
                            <h6 class="text-content">Default Shipping Address</h6>
                            <h6 class="text-content">You have not set a default shipping
                                address.</h6>
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editProfile">
                                <i class="fa fa-pencil-alt"></i>
                                Chỉnh sửa địa chỉ giao hàng mặc định
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
