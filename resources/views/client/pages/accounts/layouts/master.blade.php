@extends('client.layouts.master')

@section('content')
    @include('client.pages.accounts.layouts.partials.breadcrumb')
    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                @include('client.pages.accounts.layouts.partials.sidebar')
                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu</button>
                    <div class="dashboard-right-sidebar">
                        @yield('content_account')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- User Dashboard Section End -->
    <!-- Bg overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Bg overlay End -->
@endsection

@section('modal')
    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add-address" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" id="fname" placeholder="Enter First Name">
                            <label for="fname">First Name</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name">
                            <label for="lname">Last Name</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                            <label for="email">Email Address</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="address" style="height: 100px"></textarea>
                            <label for="address">Enter Address</label>
                        </div>
                    </form>

                    <form>
                        <div class="form-floating mb-4 theme-form-floating">
                            <input type="email" class="form-control" id="pin" placeholder="Enter Pin Code">
                            <label for="pin">Pin Code</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn theme-bg-color btn-md text-white" data-bs-dismiss="modal">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->

    <!-- Edit Profile Start -->
    <div class="modal fade theme-modal" id="editProfile" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="pname" value="Jack Jennas">
                                    <label for="pname">Full Name</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="email" class="form-control" id="email1" value="vicki.pope@gmail.com">
                                    <label for="email1">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-6">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input class="form-control" type="tel" value="4567891234" name="mobile"
                                        id="mobile" maxlength="10"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                    <label for="mobile">Email address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address1"
                                        value="8424 James Lane South San Francisco">
                                    <label for="address1">Add Address</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-12">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address2" value="CA 94080">
                                    <label for="address2">Add Address 2</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect1">
                                        <option selected>Choose Your Country</option>
                                        <option value="kingdom">United Kingdom</option>
                                        <option value="states">United States</option>
                                        <option value="fra">France</option>
                                        <option value="china">China</option>
                                        <option value="spain">Spain</option>
                                        <option value="italy">Italy</option>
                                        <option value="turkey">Turkey</option>
                                        <option value="germany">Germany</option>
                                        <option value="russian">Russian Federation</option>
                                        <option value="malay">Malaysia</option>
                                        <option value="mexico">Mexico</option>
                                        <option value="austria">Austria</option>
                                        <option value="hong">Hong Kong SAR, China</option>
                                        <option value="ukraine">Ukraine</option>
                                        <option value="thailand">Thailand</option>
                                        <option value="saudi">Saudi Arabia</option>
                                        <option value="canada">Canada</option>
                                        <option value="singa">Singapore</option>
                                    </select>
                                    <label for="floatingSelect">Country</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <select class="form-select" id="floatingSelect">
                                        <option selected>Choose Your City</option>
                                        <option value="kingdom">India</option>
                                        <option value="states">Canada</option>
                                        <option value="fra">Dubai</option>
                                        <option value="china">Los Angeles</option>
                                        <option value="spain">Thailand</option>
                                    </select>
                                    <label for="floatingSelect">City</label>
                                </div>
                            </form>
                        </div>

                        <div class="col-xxl-4">
                            <form>
                                <div class="form-floating theme-form-floating">
                                    <input type="text" class="form-control" id="address3" value="94080">
                                    <label for="address3">Pin Code</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" data-bs-dismiss="modal"
                        class="btn theme-bg-color btn-md fw-bold text-light">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile End -->

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
