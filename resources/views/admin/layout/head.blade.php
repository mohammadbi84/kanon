<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <title>پنل مدیریت سایت</title>

    <meta name="description" content="">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/rtl.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css') }}">

    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/flatpickr/flatpickr.css') }}">
    <!-- Row Group CSS -->
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    <link rel="stylesheet"
        href="{{ asset('admin/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}">

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>


    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}">


    {{-- datepicker --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/pickr/pickr-themes.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('head')
</head>
