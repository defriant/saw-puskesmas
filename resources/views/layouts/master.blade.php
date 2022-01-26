<!doctype html>
<html lang="en">

<head>
    <title>Simple Additive Weighting</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/linearicons/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-pro-master/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
    <!-- Env Color -->
    <link rel="stylesheet" href="{{ asset('assets/css/envColor.css') }}">
    <script src="{{ asset('assets/scripts/envColor.js') }}"></script>
    {{-- Datatime picker --}}
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.datetimepicker.min.css') }}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/logo-puskesmas-1.png') }}">
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="brand">
                <a href="/"><img src="{{ asset('assets/img/logo-puskesmas-1.png') }}" class="img-responsive logo"></a>
            </div>
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                </div>
                <div id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                @if (Auth::user()->role == 'admin')
                                    <img src="{{ asset('assets/img/admin.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i>
                                @else
                                    @if (Auth::user()->karyawan->jenis_kelamin == "Laki-laki")
                                        <img src="{{ asset('assets/img/admin.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i>
                                    @else
                                        <img src="{{ asset('assets/img/user-female.png') }}" class="img-circle" alt="Avatar"> <span>{{ Auth::user()->name }}</span> <i class="icon-submenu lnr lnr-chevron-down"></i>
                                    @endif
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->role == "karyawan")
                                    <li><a href="#" data-toggle="modal" data-target="#modalChangePassword"><i class="fal fa-cog"></i> <span>Ganti Password</span></a></li>
                                @endif
                                <li><a href="/logout"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="sidebar-nav" class="sidebar">
            <div class="sidebar-scroll">
                <nav>
                    @if (Auth::user()->role == "admin")
                        <ul class="nav">
                            <li>
                                <a href="/dashboard" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="/data-karyawan" class="{{ Request::is('data-karyawan') ? 'active' : '' }}"><i class="fal fa-tasks"></i> <span>Data Karyawan</span></a>
                            </li>
                            <li>
                                <a href="/penilaian-kinerja" class="{{ Request::is('penilaian-kinerja') ? 'active' : '' }}"><i class="fal fa-chart-line"></i> <span>Penilaian Kinerja</span></a>
                            </li>
                        </ul>
                    @elseif(Auth::user()->role == "karyawan")
                        <ul class="nav">
                            <li>
                                <a href="/karyawan/dashboard" class="{{ Request::is('karyawan/dashboard') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li>
                                <a href="/karyawan/peringkat" class="{{ Request::is('karyawan/peringkat') ? 'active' : '' }}"><i class="fal fa-chart-bar"></i> <span>Peringkat</span></a>
                            </li>
                        </ul>
                    @endif
                </nav>
            </div>
        </div>
        
        <div class="main">
            <div class="main-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        @if (Auth::user()->role == "karyawan")
            <div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Ganti Password</h4>
                        </div>
                        <div class="modal-body">
                            <p>Password lama</p>
                            <input type="password" id="old-pass" class="form-control">
                            <br>
                            <p>Password baru</p>
                            <input type="password" id="new-pass" class="form-control">
                            <br>
                            <p>Konfirmasi password</p>
                            <input type="password" id="confirm-pass" class="form-control">
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-change-password">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="clearfix"></div>
        <footer>
            <div class="container-fluid">
                <p class="copyright">&copy; {{ date('Y') }}. All Rights Reserved.</p>
            </div>
        </footer>
    </div>
    
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/scripts/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/klorofil-common.js') }}"></script>
    <script src="{{ asset('assets/scripts/main.js') }}"></script>
    @if (Request::is('data-karyawan'))
        <script src="{{ asset('assets/scripts/karyawan.js') }}"></script>
    @elseif (Request::is('penilaian-kinerja'))
        <script src="{{ asset('assets/scripts/kriteria.js') }}"></script>
        <script src="{{ asset('assets/scripts/penilaian-karyawan.js') }}"></script>
        <script src="{{ asset('assets/scripts/saw.js') }}"></script>
    @elseif (Request::is('karyawan/dashboard'))
        <script src="{{ asset('assets/scripts/karyawan-dashboard.js') }}"></script>
    @elseif (Request::is('karyawan/peringkat'))
        <script src="{{ asset('assets/scripts/karyawan-peringkat.js') }}"></script>
    @endif
    @yield('scripts')
</body>

</html>
