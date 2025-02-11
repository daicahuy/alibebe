@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Update Password</h3>
                            <h4>Please choose your password</h4>
                        </div>
                        <div class="input-box">
                            <form action="{{ route('auth.admin.showFormLogin') }}" novalidate="" class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input name="newPassword" formcontrolname="newPassword" id="email"
                                            class="form-control" placeholder="New Password" type="password">
                                        <label for="email">New Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input id="password" formcontrolname="confirmPassword" class="form-control"
                                            placeholder="Password" type="password">
                                        <label for="password">Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-theme justify-content-center w-100" id="pass_btn"
                                        type="submit">
                                        <div> Submit </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
