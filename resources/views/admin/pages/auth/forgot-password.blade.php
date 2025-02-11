@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To Fastkart</h3>
                            <h4>Forgot Password</h4>
                        </div>
                        <div class="input-box">
                            <form action="{{ route('auth.admin.showFormOtp') }}" novalidate="" class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" id="email" class="form-control" placeholder="Email Address">
                                        <label for="email">Enter Email Address</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-theme justify-content-center w-100" id="forgot_btn" type="submit">
                                        <div> Send </div>
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
