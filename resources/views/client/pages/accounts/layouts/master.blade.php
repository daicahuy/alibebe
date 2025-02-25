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