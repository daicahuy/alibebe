@extends('admin.layouts.basic')

@section('content')
    <section class="log-in-section section-b-space">
        <div class="container w-100">
            <div class="row">
                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <form action="{{ route('auth.admin.showFormNewPassword') }}">
                            <div class="log-in-title">
                                <h3 class="text-content">Please enter the one time password to verify
                                    your account</h3>
                                <h5 class="text-content"> A code has been sent to <span>admin@example.com</span></h5>
                            </div>
                            <div id="otp" class="row d-flex row-cols-6 g-2 mb-5">
                                <div class="outer-otp">
                                    <div class="inner-otp">
                                        <input type="text" maxlength="5"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            onkeypress="if(this.value.length==5) return false;"
                                            class="ng-untouched ng-pristine ng-invalid">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-theme justify-content-center w-100" id="otp_btn" type="submit">
                                <div> Validate </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
