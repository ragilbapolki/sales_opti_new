<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <!-- Tell the browser to be responsive to screen width -->
    <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic"> -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('bower_components/datepicker/css/datepicker.css') }}">
    <!-- datatables -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/buttons.jqueryui.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/jquery-ui.css') }}">
    <!--   <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/dataTables.jqueryui.min.css') }}"> -->
    <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/fixedColumns.dataTables.min.css') }}">
    <!--   <link rel="stylesheet" href="//cdn.datatables.net/fixedcolumns/3.2.4/css/fixedColumns.dataTables.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet"
        href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/1.5.1/css/scroller.dataTables.min.css">
    <!-- sweetalert -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- bootstrap toogle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!--   <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-toggle-master/css/bootstrap-toggle.min.css') }}" > -->

    @yield('css')
    <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css') }}">

    <script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>




</head>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            @if (!empty(Session::get('platformcdi')))
            <a href="{{ route('home', Session::get('platformcdi')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>C</b>DI</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Sales</b>CDI</span>
            </a>
            @else
            <a href="{{ route('home', 'cdi') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>C</b>DI</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Sales</b>CDI</span>
            </a>
            @endif

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ URL::asset('dist/img/pincobra.png') }}" class="user-image"
                                    alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ URL::asset('dist/img/pincobra.png') }}" class="img-circle"
                                        alt="User Image">

                                    <p>
                                        <!-- {{ Auth::user()->jabatan }} -->
                                        <small>{{ Auth::user()->kode_cabang }}</small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{!! route('account_setting') !!}"
                                            class="btn btn-sm bg-navy">Account</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="btn btn-sm bg-maroon">Sign Out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        @if (Auth::user()->role_id == 3)
        @include('layouts/menuuser')
        @elseif (Auth::user()->role_id == 2)
        @include('layouts/menuadmin')
        @elseif (Auth::user()->role_id == 1)
        @include('layouts/menusuper')
        @elseif (Auth::user()->role_id == 4)
        @include('layouts/menuarea')
        @elseif (Auth::user()->role_id == 5)
        @include('layouts/menucustomer')
        @endif
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        @include('layouts._modal')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                PT.Cobra Dental Indonesia
            </div>
            <b>Version</b> 2.0.7
        </footer>
    </div>
    <!-- ./wrapper -->

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @yield('javascript')

    <!-- bootstrap-toggle-master -->
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- <script type="text/javascript"
        src="{{ URL::asset('bower_components/bootstrap-toggle-master/js/bootstrap-toggle.min.js') }}"></script>   -->
    <!-- Slimscroll -->
    <script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/handlebars.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ URL::asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- validate -->
    <script src="{{ URL::asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- datatables -->
    <script src="{{ URL::asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/dataTables.select.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/buttons.jqueryui.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/datatables/js/dataTables.fixedColumns.min.js') }}"></script>

    {{-- datepicker --}}
    <script src="{{ URL::asset('bower_components/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript">
    </script>

</body>
@yield('page-script')

</html>