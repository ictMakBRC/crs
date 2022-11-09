
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">

        <!-- third party css -->
        <link href="{{asset('assets/css/vendor/dataTables.bootstrap5.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/vendor/responsive.bootstrap5.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/vendor/buttons.bootstrap5.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/vendor/select.bootstrap5.css')}}" rel="stylesheet" type="text/css">
        <!-- third party css end -->

        <!-- App css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="light-style">
        <link href="{{asset('assets/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="dark-style">

    </head>

    <body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->

            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    @include('crs.layouts.topbar')
                    <!-- end Topbar -->
                    @include('crs.layouts.navigation')
                    @yield('content')
                    @include('layouts.footer')
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- /End-bar -->


        <!-- bundle -->

       <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
       <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <!-- third party js -->
       <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/buttons.html5.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/buttons.flash.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/buttons.print.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
       <script src="{{ asset('assets/js/vendor/dataTables.select.min.js') }}"></script>
        <!-- third party js ends -->

        <!-- demo app -->
       <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
       <script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
       <script src="{{asset('assets/js/pages/demo.dashboard-crm.js')}}"></script>
        <!-- end demo js-->

    </body>
</html>
