<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - HRMS - {{ !empty($company) && !empty($company->company_name) ? $company->company_name : 'Local Government Unit of Cuyapo' }}</title>
    <!-- Favicon -->
    @php
    use App\Models\CompanySettings;
    $company = CompanySettings::first();
    @endphp

    @if (!empty($company) && !empty($company->logo))
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/' . $company->logo) }}">
    @else
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">
    @endif
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/font-awesome.min.css') }}">
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/line-awesome.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/select2.min.css') }}">
    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!--Calendar CSS -->
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

    <!-- jQuery (necessary for FullCalendar and some interactions) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>





    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">

    {{-- message toastr --}}
</head>

<body>
    @yield('style')
    <style>
        .invalid-feedback {
            font-size: 14px;
        }

        .error {
            color: red;
        }

    </style>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Loader -->
        <div id="loader-wrapper">
            <div id="loader">
                <div class="loader-ellips">
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                    <span class="loader-ellips__dot"></span>
                </div>
            </div>
        </div>
        <!-- /Loader -->

        <!-- Header -->
        <div class="header">
            <!-- Logo -->
            <div class="header-left">
                <a href="{{ Auth::user()->role_name === 'Admin' || Auth::user()->role_name === 'Super Admin' ? route('home') : route('em/dashboard') }}" class="logo">
                    @if (!empty($company) && !empty($company->logo))
                    <img src="{{ asset('assets/images/' . $company->logo) }}" width="40" height="40" alt="">
                    @else
                    <img src="{{ asset('assets/img/logo.png') }}" width="40" height="40" alt="">
                    @endif
                </a>
            </div>
            <!-- /Logo -->
            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!-- Header Title -->
            <div class="page-title-box">
                <h3>Hi, {{ Auth::user()->name }}</h3>
            </div>
            <!-- /Header Title -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
            <!-- Header Menu -->
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{ URL::to('/assets/images/'. Auth::user()->avatar) }}" alt="">
                            <span class="status online"></span></span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('profile_user') }}">My Profile</a>
                        @if(Auth::user()->role_name === 'Admin' || Auth::user()->role_name === 'Super Admin')
                        <a class="dropdown-item" href="{{ route('company/settings/page') }}">Settings</a>
                        @else
                        <a class="dropdown-item" href="{{ route('change/password') }}">Settings</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('profile_user') }}">My Profile</a>
                    @if(Auth::user()->role_name === 'Admin' || Auth::user()->role_name === 'Super Admin')
                    <a class="dropdown-item" href="{{ route('company/settings/page') }}">Settings</a>
                    @else
                    <a class="dropdown-item" href="{{ route('change/password') }}">Settings</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
            <!-- /Mobile Menu -->

        </div>
        <!-- /Header -->
        <!-- Sidebar -->
        @include('sidebar.sidebar')
        <!-- /Sidebar -->
        <!-- Page Wrapper -->
        @yield('content')
        <!-- /Page Wrapper -->
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::to('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
    <script src="{{ URL::to('assets/js/popper.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ URL::to('assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ URL::to('assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/chart.js') }}"></script>
    <script src="{{ URL::to('assets/js/Chart.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/line-chart.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ URL::to('assets/js/jquery.slimscroll.min.js') }}"></script>
    <!-- Select2 JS -->
    <script src="{{ URL::to('assets/js/select2.min.js') }}"></script>
    <!-- Datetimepicker JS -->
    <script src="{{ URL::to('assets/js/moment.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Datatable JS -->
    <script src="{{ URL::to('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Multiselect JS -->
    <script src="{{ URL::to('assets/js/multiselect.min.js') }}"></script>
    <!-- validation-->
    <script src="{{ URL::to('assets/js/jquery.validate.js') }}"></script>
    <!-- Custom JS -->
    <script src="{{ URL::to('assets/js/app.js') }}"></script>
    @yield('script')
</body>
</html>
