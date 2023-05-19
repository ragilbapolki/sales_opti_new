@extends('layouts.master')

@section('title','CDI | Home')

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      {{-- <a class="btn btn-app bg-aqua" href="{{ route('page_item') }}" target="_self">
        <i class="fa fa-dollar"></i> List Harga
      </a> --}}
      <a class="btn btn-app bg-olive" href="{{ route('page_listharga_erp') }}" target="_self">
        <i class="fa fa-dollar"></i> Price List 
      </a>

@if (Auth::user()->role_id == 3)
      {{-- <a class="btn btn-app bg-aqua" href="{{ route('page_item_stok') }}" target="_self">
        <i class="fa fa-cubes"></i> Stok Barang
      </a> --}}
      <a class="btn btn-app bg-olive" href="{{ route('pagesales_stok_erp') }}" target="_self">
        <i class="fa fa-cubes"></i> Stok ERP
      </a>
      <a class="btn btn-app bg-purple" href="{{ route('page_pemesanan') }}" target="_self">
        <i class="fa fa-cart-arrow-down"></i> Pemesanan
      </a> 
      <a class="btn btn-app bg-purple" href="{{ route('page_historypesan') }}" target="_self">
        <i class="fa fa-list-alt"></i> History Pesan
      </a>         
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_aktivitas') }}" target="_self">
        <i class="fa fa-user-md"></i> Customer
      </a>
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_ccc') }}" target="_self">
        <i class="fa fa-users"></i> Data CCC
      </a>      
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_rank') }}" target="_self">
        <i class="fa fa-signal"></i> Cust Rank
      </a>
      @if (Auth::user()->jabatan_id == 6)
      <a class="btn btn-app bg-red" href="{{ route('page_plan') }}" target="_self">
        <i class="fa fa-calendar"></i> Plan visit
      </a>
      <a class="btn btn-app bg-red" href="{{ route('sales_page_visit') }}" target="_self">
        <i class="fa fa-history"></i> His.Visit
      </a>
      <a class="btn btn-app bg-red" href="{{ route('page_presensi') }}" target="_self">
        <i class="fa fa-user"></i> Presensi
      </a>
      @endif
      <a class="btn btn-app bg-aqua" href="{{ route('page_materiproduk') }}" target="_self">
        <i class="fa fa-map"></i> MateriProduk
      </a>
@elseif (Auth::user()->role_id == 2)
      {{-- <a class="btn btn-app bg-aqua" href="{{ route('page_item_stok') }}" target="_self">
        <i class="fa fa-cubes"></i> Stok Barang
      </a> --}}
      {{-- <a class="btn btn-app bg-aqua" href="{{ route('page_cekstok_kato') }}" target="_self">
        <i class="fa fa-book"></i> Stok PerItem
      </a>    --}}
      <a class="btn btn-app bg-olive" href="{{ route('pagesales_stok_erp') }}" target="_self">
        <i class="fa fa-cubes"></i> Stok ERP
      </a>
      <a class="btn btn-app bg-olive" href="{{ route('page_peritems_erp') }}" target="_self">
        <i class="fa fa-th-list"></i> Stok Item
      </a>   
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_aktivitas') }}" target="_self">
        <i class="fa fa-user-md"></i> Customer
      </a>
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_ccc') }}" target="_self">
        <i class="fa fa-user-md"></i> Cust. CCC
      </a>
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_rank') }}" target="_self">
        <i class="fa fa-signal"></i> Cust Rank
      </a>
      <a class="btn btn-app bg-red" href="{{ route('page_plan') }}" target="_self">
        <i class="fa fa-calendar"></i> Plan visit
      </a>
      <a class="btn btn-app bg-red" href="{{ route('page_target') }}" target="_self">
        <i class="fa fa-users"></i> Target Pres.
      </a>
      <a class="btn btn-app bg-yellow" href="{!! route('DataSales') !!}" target="_self">
        <i class="fa fa-user"></i> Data Sales
      </a>
      <a class="btn btn-app bg-aqua" href="{{ route('page_materiproduk') }}" target="_self">
        <i class="fa fa-map"></i> Mtri. Produk
      </a>
      <a class="btn btn-app bg-purple" href="{{ route('page_historypesan') }}" target="_self">
        <i class="fa fa-list-alt"></i> Hist. Pesan
      </a>      
<!--       <a class="btn btn-app btn-facebook" href="{{ route('seminar.index') }}" target="_self">
        <i class="fa fa-star"></i> Daftar Seminar
      </a> -->

<!-- <div class="row">
  <div class="col-md-4">
    <div class="box box-warning direct-chat direct-chat-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Informasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="direct-chat-messages">
          <div class="direct-chat-msg ">
            <img class="direct-chat-img" src="{{ URL::asset('dist/img/pincobra.png') }}" alt="message user image">
            <div class="direct-chat-text">
              Terima Kasih Atas kerjasamanya mengirimkan no hp, data tersebut telah kami masukan kedalam sistem. 
            </div>
          </div>
          <div class="direct-chat-msg ">
            <div class="direct-chat-text">
              Silahkan cek pada menu data sales. mohon tambahkan atau edit apabila ada kekeliruan.<br> Terima Kasih
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->


      @if(Auth::user()->updated_at == NULL)
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Note!</h4>
             Mohon untuk mengganti password, karena password anda masih default.
          </div>
        </div>
      </div>
      @endif
@elseif (Auth::user()->role_id == 4)
      {{-- <a class="btn btn-app bg-aqua" href="{{ route('page_cekstok_area') }}" target="_self">
        <i class="fa fa-book"></i> Stok PerItem
      </a> --}}
      <a class="btn btn-app bg-olive" href="{{ route('pageall_stok_erp') }}" target="_self">
        <i class="fa fa-cubes"></i> Stok ERP
      </a>
      <a class="btn btn-app bg-olive" href="{{ route('page_peritems_erp') }}" target="_self">
        <i class="fa fa-th-list"></i> Stok Item
      </a>
      <a class="btn btn-app bg-blue" href="{{ route('page_custrank_area') }}" target="_self">
        <i class="fa fa-signal"></i> Cust Rank
      </a>
<!--       <a class="btn btn-app btn-foursquare" href="{{ route('page_plan') }}" target="_self">
        <i class="fa fa-calendar"></i> Plan visit
      </a> -->
      <a class="btn btn-app bg-red" href="{{ route('page_targetarea') }}" target="_self">
        <i class="fa fa-users"></i> Target Presensi
      </a>
           <a class="btn btn-app btn-twitter" href="{{ route('pindahcabang') }}" target="_self">
        <i class="fa fa-exchange"></i> Pindah Cabang
      </a> 
<!--       <a class="btn btn-app btn-tumblr" href="{{ route('page_pemesanan') }}" target="_self">
        <i class="fa fa-cart-arrow-down"></i> Pemesanan
      </a> --> 
      <a class="btn btn-app bg-purple" href="{{ route('page_historypesan') }}" target="_self">
        <i class="fa fa-list-alt"></i> History Pesan
      </a> 
      
@elseif (Auth::user()->role_id == 5)

      <a class="btn btn-app bg-purple" href="{{ route('page_pemesanan_cust') }}" target="_self">
        <i class="fa fa-cart-arrow-down"></i> Pemesanan
      </a> 
      <a class="btn btn-app bg-purple" href="{{ route('page_historypesan_cust') }}" target="_self">
        <i class="fa fa-list-alt"></i> History Pesan
      </a>  

@else
      <a class="btn btn-app bg-blue" href="{{ route('page_custrank_area') }}" target="_self">
        <i class="fa fa-signal"></i> Cust Rank
      </a>
      <a class="btn btn-app bg-blue" href="{{ route('page_cust_aktivitas') }}" target="_self">
        <i class="fa fa-user-md"></i> Customer
      </a>
      <a class="btn btn-app bg-yellow" href="{!! route('pindahcabang') !!}" target="_self">
        <i class="fa fa-exchange"></i> Pindah Cabang
      </a>
      <a class="btn btn-app bg-red" href="{{ route('page_plan') }}" target="_self">
        <i class="fa fa-calendar"></i> Plan visit
      </a>
      <a class="btn btn-app btn-github" href="{!! route('report') !!}" target="_self">
        <i class="fa fa-pie-chart"></i> Report Sales
      </a>
      <a class="btn btn-app bg-yellow" href="{!! route('DataSales') !!}" target="_self">
        <i class="fa fa-user"></i> Data Sales
      </a>
      <a class="btn btn-app btn-foursquare" href="https://app.cobradental.co.id:1780/jajal/tolakplansistem.php" target="_self">
        <i class="fa fa-rocket"></i> runCron
      </a>
      <a class="btn btn-app btn-tumblr" href="{!! route('super_page_users') !!}" target="_self">
        <i class="fa fa-users"></i> DataUser
      </a>

      <a class="btn btn-app btn-facebook" href="{!! route('super_page_logs') !!}" target="_self">
        <i class="fa fa-paw"></i> Logs
      </a>
@endif
<!-- <div class="row">
  <div class="col-md-4">
    <div class="box box-warning direct-chat direct-chat-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Informasi</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="direct-chat-messages">
          <div class="direct-chat-msg ">
            <img class="direct-chat-img" src="{{ URL::asset('dist/img/pincobra.png') }}" alt="message user image">
            <div class="direct-chat-text">
              Ada menu baru untuk sales yaitu his.visit, untuk melihat histori kunjungan anda. 
            </div>
          </div>
          <div class="direct-chat-msg ">
            <div class="direct-chat-text">
              untuk pencarian bisa berdasarkan tanggal atau customer melalui form filter tgl/filter cust (contoh untuk menampilkan kunjungan dibulan januari silahkan ketikan 2019-01- ),silahkan isikan sesuai kebutuhan.<br> Terima Kasih
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->


    </section>
    <!-- /.content -->
@endsection