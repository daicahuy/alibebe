<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- START HEAD -->
@include('admin.layouts.partials.head')
<!-- END HEAD -->

<body class="light-only">

    <!-- START CONTENT -->
    <div class="container-fuild">
        @yield('content')
    </div>
    <!-- END CONTENT -->

    <!-- START FOOTER SCRIPT -->
    @include('admin.layouts.partials.footer-script')
    <!-- END FOOTER SCRIPT -->

    <!-- START ALERT -->
    @include('admin.layouts.partials.alert')
    <!-- END ALERT -->

</body>

</html>
