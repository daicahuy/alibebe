@extends('client.pages.accounts.layouts.master')

@section('content_account')
    <div class="dashboard-profile">
        <div class="title">
            <h2>My Profile</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="https://themes.pixelstrap.com/fastkart/assets/svg/leaf.svg#leaf">
                    </use>
                </svg>
            </span>
        </div>

        <div class="profile-detail dashboard-bg-box">
            <div class="dashboard-title">
                <h3>Profile Name</h3>
            </div>
            <div class="profile-name-detail">
                <div class="d-sm-flex align-items-center d-block">
                    <h3>Vicki E. Pope</h3>
                    <div class="product-rating profile-rating">
                        <ul class="rating">
                            <li>
                                <i data-feather="star" class="fill"></i>
                            </li>
                            <li>
                                <i data-feather="star" class="fill"></i>
                            </li>
                            <li>
                                <i data-feather="star" class="fill"></i>
                            </li>
                            <li>
                                <i data-feather="star"></i>
                            </li>
                            <li>
                                <i data-feather="star"></i>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#editProfile">Edit</a>
            </div>

            <div class="location-profile">
                <ul>
                    <li>
                        <div class="location-box">
                            <i data-feather="map-pin"></i>
                            <h6>Downers Grove, IL</h6>
                        </div>
                    </li>

                    <li>
                        <div class="location-box">
                            <i data-feather="mail"></i>
                            <h6>vicki.pope@gmail.com</h6>
                        </div>
                    </li>

                    <li>
                        <div class="location-box">
                            <i data-feather="check-square"></i>
                            <h6>Licensed for 2 years</h6>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="profile-description">
                <p>Residences can be classified by and how they are connected to
                    neighbouring residences and land. Different types of housing tenure can
                    be used for the same physical type.</p>
            </div>
        </div>

        <div class="profile-about dashboard-bg-box">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="dashboard-title mb-3">
                        <h3>Profile About</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Gender :</td>
                                    <td>Female</td>
                                </tr>
                                <tr>
                                    <td>Birthday :</td>
                                    <td>21/05/1997</td>
                                </tr>
                                <tr>
                                    <td>Phone Number :</td>
                                    <td>
                                        <a href="javascript:void(0)"> +91 846 - 547 -
                                            210</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address :</td>
                                    <td>549 Sulphur Springs Road, Downers, IL</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="dashboard-title mb-3">
                        <h3>Login Details</h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Email :</td>
                                    <td>
                                        <a href="javascript:void(0)">vicki.pope@gmail.com
                                            <span data-bs-toggle="modal" data-bs-target="#editProfile">Edit</span></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Password :</td>
                                    <td>
                                        <a href="javascript:void(0)">●●●●●●
                                            <span data-bs-toggle="modal" data-bs-target="#editProfile">Edit</span></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-xxl-5">
                    <div class="profile-image">
                        <img src="../assets/images/inner-page/dashboard-profile.png" class="img-fluid blur-up lazyload"
                            alt="">
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
