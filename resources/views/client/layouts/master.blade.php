<!DOCTYPE html>
<html lang="en">

<!-- START HEAD -->
@include('client.layouts.partials.head')
<!-- END HEAD -->

<body class="bg-effect">

    <!-- Header Start -->
    @include('client.layouts.partials.header')
    <!-- Header End -->

    <!-- Mobile Fix Menu start -->
    @include('client.layouts.partials.mobile-fix-menu')
    <!-- Mobile Fix Menu end -->

    <!-- Content start -->
    @yield('content')
    <!-- Content end -->

    <!-- Footer start -->
    @include('client.layouts.partials.footer')
    <!-- Footer end -->

    <!-- Modal start -->
    @include('client.layouts.partials.modal')
    <!-- Modal end -->

    <!-- Tap to top and theme setting button start -->
    @include('client.layouts.partials.tap-to-top')
    <!-- Tap to top and theme setting button end -->

    <!-- JS start -->
    @include('client.layouts.partials.js')
    <!-- JS start -->
    
</body>

</html>
