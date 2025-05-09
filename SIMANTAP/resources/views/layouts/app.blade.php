<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf_token" content="{{ csrf_token() }}" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/jti_polinema.ico">

        <!-- jquery.vectormap css -->
        <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        @vite([])

        <style>
            body {
                visibility: hidden;
            }

            .btn-success {
                background-color: #28a745;
                border-color: #28a745;
            }
        </style>
    </head>

    <body data-topbar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        @include('layouts.header')
        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            @include('layouts.sidebar')
            <!-- Left Sidebar End -->      
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                @yield('content')
                <!-- End Page-content -->
            </div>
            @include('layouts.footer')
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        
        @include('layouts.scripts')
        @stack('js')
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </body>

</html>