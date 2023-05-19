  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <!--{{-- <li class="daftarharga"><a href="{{ route('page_item') }}"><i class="fa fa-book"></i> <span>Daftar Harga</span></a></li> --}}-->
        <li class="daftarharga"><a href="{{ route('page_listharga_erp') }}"><i class="fa fa-dollar"></i> <span>Price List</span></a></li>
        <li class="custranking"><a href="{{ route('page_cust_rank') }}"><i class="fa fa-signal"></i> <span>Cust Rank</span></a></li>
        <li class="custaktivitas"><a href="{{ route('page_cust_aktivitas') }}"><i class="fa fa-user-md"></i> <span>Cust</span></a></li>
        <li class="pindah"><a href="{{ route('pindahcabang') }}"><i class="fa fa-exchange"></i> <span>Pindah Cabang</span></a></li>
        <li class="rencana"><a href="{{ route('page_plan') }}"><i class="fa fa-calendar"></i> <span>Rencana Kunjungan</span></a></li>
        

        <li class="logs"><a href="{{ route('super_page_logs') }}"><i class="fa fa-paw"></i> <span>Logs</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
