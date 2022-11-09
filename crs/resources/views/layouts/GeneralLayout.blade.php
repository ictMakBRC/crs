<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta content="LabPlus is an online application for Laboratory test requests" name="description">
    <meta content="MUH" name="Makerere University Hospital"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CRS') }}</title>
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

<body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        @include('layouts.navigation')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                @include('layouts.topbar')
                @include('layouts.messages')

                 <!-- Start Content-->
                 <div class="container-fluid ">
                    {{ $slot }}
                 </div>


            </div> <!-- content -->
            @include('layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->
    <!-- bundle -->
    <script src="{{asset('assets/js/vendor.min.js')}}"></script>
    <script src="{{asset('assets/js/app.min.js')}}"></script>
    <script src="{{asset('js/JsBarcode.all.min.js')}}"></script>
    @stack('scripts')

    <!-- third party js -->
    <script src="{{asset('assets/js/vendor/Chart.bundle.min.js')}}"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{asset('assets/js/pages/demo.dashboard-projects.js')}}"></script>
    <!-- end demo js-->
    <!-- third party js -->
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
    <script>
      $(document).ready(function(){
        $('.myselect').select2();
      });
    </script>
    <script>
        $(function () {
          $("#datableButtons").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#datableButtons_wrapper .col-md-6:eq(0)');

          $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
      @stack('scripts')
</body>
</html>
