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

    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/jquery-toast-plugin/jquery.toast.min.css') }}">

    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/jquery-bar-rating/bootstrap-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/jquery-bar-rating/fontawesome-stars-o.css') }}">
    <link rel="stylesheet" href="{{ asset('demo_admin_assets/vendors/jquery-bar-rating/fontawesome-stars.css') }}">

    <script src="{{ asset('demo_admin_assets/js/jquery-1.11.2.min.js') }}"></script>
</head>
<body>
    <div class="container-scroller">
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style='height: auto!important;'>
                        <!-- website logo -->
                        <a class="navbar-brand brand-logo" href="{{ route('home') }}" referrerpolicy="origin"><img style="height: 75px!important;" src="{{ asset('images/logo1.png') }}" alt="logo"/></a>

                        <!-- mobile logo -->
                         <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}"><img src="{{ asset('images/logo1.png') }}" alt="logo"/></a>
                    </div>
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item dropdown d-inline-flex align-items-center user-dropdown">
                                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                    @if(auth()->user()->Role('admin'))
                                        <span class="d-none d-md-inline"> Admin </span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                                    @guest
                                    @else
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="dropdown-item-icon icon-power text-primary"></i>
                                            {{ __('Logout') }}({{ Auth::user()->username }})
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endguest
                                </div>
                            </li>
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                            <span class="icon-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <nav class="bottom-navbar">
                <div class="container">
                    <ul class="nav page-navigation">
                        <li class="nav-item <?= ($menu == 'models' || $menu == 'add_model') ? "active" : "" ?>">
                            <a href="#" class="nav-link">
                                <i class="fa fa-shopping-cart menu-icon"></i>
                                <span class="menu-title">Models</span>
                                <i class="menu-arrow"></i></a>
                            <div class="submenu">
                                <ul class="submenu-item">
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'add_model') ? "active" : "" ?>" href="{{ route('models.create') }}">Add New Model</a></li>
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'models') ? "active" : "" ?>" href="{{ route('models.index') }}">Manage Models</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item <?= ($menu == 'wallpapers' || $menu == 'add_wallpaper') ? "active" : "" ?>">
                            <a href="#" class="nav-link">
                                <i class="fa fa-shopping-cart menu-icon"></i>
                                <span class="menu-title">Wallpapers</span>
                                <i class="menu-arrow"></i></a>
                            <div class="submenu">
                                <ul class="submenu-item">
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'add_wallpaper') ? "active" : "" ?>" href="{{ route('wallpapers.create') }}">Add New Wallpaper</a></li>
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'wallpapers') ? "active" : "" ?>" href="{{ route('wallpapers.index') }}">Manage Wallpapers</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item <?= ($menu == 'users') ? "active" : "" ?>">
                            <a href="#" class="nav-link">
                                <i class="fa fa-users menu-icon"></i>
                                <span class="menu-title">Users</span>
                                <i class="menu-arrow"></i></a>
                            <div class="submenu">
                                <ul class="submenu-item">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item <?= ($menu == 'orders') ? "active" : "" ?>">
                            <a href="#" class="nav-link">
                                <i class="fa fa-users menu-icon"></i>
                                <span class="menu-title">Orders</span>
                                <i class="menu-arrow"></i></a>
                            <div class="submenu">
                                <ul class="submenu-item">
                                    <li class="nav-item"><a class="nav-link" href="{{ route('orderlists.index') }}">Manage Orders</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item <?= ($menu == 'local_settings' || $menu == 'general_settings') ? "active" : "" ?>">
                            <a href="#" class="nav-link">
                                <i class="fa fa-briefcase menu-icon"></i>
                                <span class="menu-title">Settings</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="submenu">
                                <ul class="submenu-item">
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'local_settings') ? "active" : "" ?>" href="{{ route('admin.localizationsetting') }}">Localization Settings</a></li>
                                    <li class="nav-item"><a class="nav-link <?= ($menu == 'general_settings') ? "active" : "" ?>" href="{{ route('admin.generalsetting') }}">General Settings</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')    
                </div>
            </div>
            @include('component.footer')
        </div>

        <flash-message message="{{ session('flash') }}" />
    </div>

    <script src="{{ asset('demo_admin_assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/data-table.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/customFunction.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/profile.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/vendors/jquery.avgrund/jquery.avgrund.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/alerts.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/avgrund.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/misc.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/settings.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/todolist.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/jquery.blockui.min.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/toastDemo.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/desktop-notification.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/file-upload.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/typeahead.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/select2.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/form-validation.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/bt-maxLength.js') }}"></script>

    <script src="{{ asset('demo_admin_assets/js/formpickers.js') }}"></script>
    <script src="{{ asset('demo_admin_assets/js/form-addons.js') }}"></script>
    
    <script src="{{ asset('js/myFunction.js') }}"></script>

    @yield('script')
</body>
</html>
