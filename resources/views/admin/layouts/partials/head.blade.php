<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Fastkart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Fastkart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="WIN">
    <link rel="icon" href="{{ asset('/theme/admin/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('/theme/admin/assets/images/favicon.png') }}" type="image/x-icon">

    <title>Fastkart - Dashboard</title>

    <!-- Remixicon CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/remixicon.css') }}">

    <!-- Feather Icon CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/vendors/feather-icon.css') }}">

    <!-- Sweat Alert 2 CSS -->
    <link rel="stylesheet" href="{{ asset('theme/admin/assets/css/sweetalert2.css') }}">

    <!-- JQUERY -->
    <script src="/theme/admin/assets/js/jquery-3.6.0.min.js"></script>



    @stack('css_library')

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/admin/assets/css/style2.css') }}">

    @stack('css')

</head>
