@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To Fastkart</h3>
                            <h4>Log In Your Account</h4>
                        </div>
                        <div class="input-box">
                            <form novalidate="" class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" id="email" formcontrolname="email" class="form-control"
                                            placeholder="Email Address"><label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" id="password" formcontrolname="password"
                                            class="form-control" placeholder="Password "><label
                                            for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="forgot-box">
                                        <a class="forgot-password" href="{{ route('auth.admin.showFormForgotPassword') }}">Forgot Password?</a></div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-theme justify-content-center w-100" id="login_btn" type="submit">
                                        <div> Log In </div>
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
