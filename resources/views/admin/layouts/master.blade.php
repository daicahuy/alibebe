<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- START HEAD -->
@include('admin.layouts.partials.head')
<!-- END HEAD -->

<body class="light-only">

<div id="pageWrapper" class="page-wrapper compact-wrapper">

    <!-- START HEADER -->
    @include('admin.layouts.partials.header')
    <!-- END HEADER -->

    <div class="page-body-wrapper">

        <!-- START SIDEBAR -->
        @include('admin.layouts.partials.sidebar')
        <!-- END SIDEBAR -->

        <!-- START BODY -->
        <div class="page-body">

            <!-- START CONTENT -->
            <div class="container-fuild">
                @yield('content')
            </div>
            <!-- END CONTENT -->


            <!-- START FOOTER -->
            @include('admin.layouts.partials.footer')
            <!-- END FOOTER -->
        </div>
        <!-- END BODY -->

    </div>
</div>

<!-- START FOOTER SCRIPT -->
@include('admin.layouts.partials.footer-script')
<!-- END FOOTER SCRIPT -->

</body>

</html>
