<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- third party css -->
        <link href="{{ asset('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css">
        <!-- third party css end -->

        <!-- App css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style">
        <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style">
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
    </head>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

        <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        
                    @include('layouts.navigation')
             <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->

                     @include('layouts.topbar')
                @include('layouts.messages')
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    @yield('content')
                    <!-- container -->


                </div>
                <!-- content -->

                <!-- Footer Start -->
                   @include('layouts.footer')
                <!-- end Footer -->

            </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    <!-- third party js -->
    <script src="{{ asset('assets/js/vendor/Chart.bundle.min.js') }}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.dashboard-projects.js') }}"></script>
    <!-- end demo js-->
    <!-- third party js -->


    <!-- third party js ends -->
<script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- demo app -->
    <script src="{{ asset('assets/js/pages/demo.datatable-init.js') }}"></script>
    <script src="{{ asset('assets/sweetalert/sweetalert.min.js')}}"></script>
    <script>
        $(function () {
          $("#example2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

          $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>

<script type="text/javascript">
    $(document).ready(function() {
         $('.myselect').select2();
     });
     </script>

    <!-- end demo js-->
</body>
</html>
