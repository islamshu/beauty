<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>{{ get_general_value('website_name') }} - @yield('title')</title>

    <link rel="apple-touch-icon" href="{{ asset('uploads/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
        rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- BEGIN VENDOR CSS-->

    <!-- END MODERN CSS-->
    <!-- BEGIN Page Level CSS-->
    @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/vendors.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css-rtl/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style-rtl.css') }}">
        <style>
            .margin-right {
                margin-right: 60%
            }

            .required {
                color: red;
            }
            #clientResults a {
        padding: 10px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    #clientResults a:hover {
        background-color: #f0f0f0;
    }
        </style>
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/vendors.css') }}">
        <!-- END VENDOR CSS-->
        <!-- BEGIN MODERN CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/css/custom.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css"
            href="{{ asset('backend/app-assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/assets/css/style.css') }}">
        <style>
            .margin-right {
                margin-left: 60%
            }
        </style>
    @endif
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/selects/selectivity-full.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/forms/tags/tagging.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/fonts/simple-line-icons/style.css') }}">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/plugins/forms/wizard.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/plugins/pickers/daterange/daterange.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend/app-assets/vendors/css/cryptocoins/cryptocoins.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>

    <style>
        .select2-container {
            width: 100% !important;
        }
        .cke_notifications_area{
            display: none !important;
        }
    </style>
    @yield('style')
    @livewireStyles

    <!-- END Page Level CSS-->

    <!-- END Custom CSS-->
</head>
