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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">

  <!-- fullCalendar -->
  <!-- <link rel="stylesheet" href="https://3mdentalheroes.com/scripts/fullcalendar/fullcalendar.min.css" /> -->
  <!-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css"> -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.css') }}">
  <!-- <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print"> -->

  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">

  <!-- Datatables -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/buttons.jqueryui.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/dataTables.jqueryui.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/datatables/css/fixedColumns.dataTables.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
  <!-- Morris chart -->
  <!-- <link rel="stylesheet" href="bower_components/morris.js/morris.css"> -->
  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css"> -->
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

  <!-- bootstrap wysihtml5 - text editor -->
  <!-- <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
  <!-- Select2 -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="{{ URL::asset('bower_components/select/css/select2.min.css') }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
  <script src="{{ URL::asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- reload bila tidak aktif -->
  <script type="text/javascript">
      // var sto = 0;
      // // var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      // function reload() {
      //   $.ajaxSetup({
      //    headers: {
      //      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //    }
      //   });
      //   sto = setTimeout(function()
      //   { 
      //     $.ajax({
      //       url: '{!! route('logout') !!}',
      //       method: 'POST',
      //       // data: {_token: CSRF_TOKEN},
      //     })

      //     $('#modal-session').modal({backdrop: 'static',keyboard: true,show: true}); 
      //   }, 300000);//5menit
      // }
      // function canceltimer() {
      //  window.clearTimeout(sto);  // cancel the timer on each mousemove/click
      //  reload();  // and restart it
      // }
  </script>


</head>
<!-- <body class="hold-transition skin-blue sidebar-mini"  onmousemove="canceltimer()" onclick="canceltimer()"> -->
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" >
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    @if(!empty(Session::get('platformcdi'))) 
    <a href="{{route('home', Session::get('platformcdi')) }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>DI</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sales</b>CDI</span>
    </a>
    @else
    <a href="{{route('home', 'cdi') }}" class="logo">
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
              <img src="{{ URL::asset('dist/img/pincobra.png') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ URL::asset('dist/img/pincobra.png') }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->jabatan }}
                  <small>{{ Auth::user()->kode_cabang }}</small>
                </p>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                    <a href="{!! route('account_setting') !!}" class="btn btn-sm bg-navy">Account</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" class="btn btn-sm bg-maroon">Sign Out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
  @if(Auth::user()->role_id == 3)
    @include('layouts/menuuser')
  @elseif (Auth::user()->role_id == 2)
    @include('layouts/menuadmin')
  @elseif (Auth::user()->role_id == 1)
    @include('layouts/menusuper')
  @endif

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      PT.Cobra Dental Indonesia 
    </div>
    <b>Version</b> 2.0.7
  </footer>


</div>
<!-- ./wrapper -->
  <div class="modal modal-info fade" id="modal-session">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-body text-cente">
          <p class="col-sm-offset-3"><h4>Maaf waktu anda habis, Silahkan Login kembali.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-teal"  value="Refresh Page" onClick="window.location.reload()">Ok,fine&hellip;</button>
        </div>
      </div>
    </div>
  </div>
  
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('bower_components/chart.js/Chart.js') }}"></script>
<!-- Datatables 1.10.15-->
<script src="{{ URL::asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/dataTables.select.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/buttons.jqueryui.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables/js/dataTables.fixedColumns.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- FastClick -->
<script src="{{ URL::asset('bower_components/fastclick/lib/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>


<!-- fullCalendar -->
<!-- <script src="https://adminlte.io/themes/AdminLTE/bower_components/moment/moment.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js"></script> -->
<!-- <script src="{{ URL::asset('bower_components/moment/moment.js') }}"></script>
<script src="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script> -->

<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- Select2 -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
<script src="{{ URL::asset('bower_components/select/js/select2.full.min.js') }}"></script>

</body>
  @yield('page-script')
</html>
