<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <title>{{ $general_setting->site_name }}</title>

    <link href="{{ asset('3d/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('3d/css/example.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('finaldesign/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')    
                </div>
            </div>
        </div>

        <flash-message message="{{ session('flash') }}" />
    </div>

    <script src="{{ asset('3d/js/three.min.js') }}"></script>
    <script src="{{ asset('3d/js/blueprint3d.js') }}"></script>
    <script src="{{ asset('3d/js/jquery.js') }}"></script>
    <script src="{{ asset('3d/js/bootstrap.js') }}"></script>
    <script src="{{ asset('3d/js/example.js') }}"></script>


    <script src="{{ asset('demo_admin_assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/data-table.js') }}"></script>


    <script src="{{ asset('finaldesign/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('finaldesign/jquery-toast-plugin/toastr.min.js') }}"></script>

    @yield('script')
</body>
</html>
