@extends('layouts.master')

@section('title', 'CDI | Home')

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <!--{{-- <a class="btn btn-app bg-aqua" href="{{ route('page_item') }}" target="_self">
        <i class="fa fa-dollar"></i> List Harga
      </a> --}}-->
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
            <a class="btn btn-app bg-purple" href="{{ route('page_historypesan') }}" target="_self"
                style="font-size: 0.6em">
                <i class="fa fa-list-alt"></i> History Pesan
            </a>
            <a class="btn btn-app bg-maroon" href="{{ route('page_cust_aktivitas_erp') }}" target="_self"
                style="font-size: 0.6em">
                <i class="fa fa-user-md"></i> Customer ERP
            </a>
            <a class="btn btn-app bg-maroon" href="#" target="_self" style="font-size: 0.6em">
                <i class="fa fa-users"></i> Data CCC ERP
            </a>
            <a class="btn btn-app bg-maroon" href="#" target="_self" style="font-size: 0.6em">
                <i class="fa fa-signal"></i> Cust Rank ERP
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



            @if (Auth::user()->updated_at == null)
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Note!</h4>
                            Mohon untuk mengganti password, karena password anda masih default.
                        </div>
                    </div>
                </div>
            @endif
        @elseif (Auth::user()->role_id == 4)
            <a class="btn btn-app bg-olive" href="{{ route('pageall_stok_erp') }}" target="_self">
                <i class="fa fa-cubes"></i> Stok ERP
            </a>
            <a class="btn btn-app bg-olive" href="{{ route('page_peritems_erp') }}" target="_self">
                <i class="fa fa-th-list"></i> Stok Item
            </a>
            <a class="btn btn-app bg-blue" href="{{ route('page_custrank_area') }}" target="_self">
                <i class="fa fa-signal"></i> Cust Rank
            </a>

            <a class="btn btn-app bg-red" href="{{ route('page_targetarea') }}" target="_self">
                <i class="fa fa-users"></i> Target Presensi
            </a>
            <a class="btn btn-app btn-twitter" href="{{ route('pindahcabang') }}" target="_self">
                <i class="fa fa-exchange"></i> Pindah Cabang
            </a>

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
            <a class="btn btn-app btn-foursquare" href="https://app.cobradental.co.id:1780/jajal/tolakplansistem.php"
                target="_self">
                <i class="fa fa-rocket"></i> runCron
            </a>
            <a class="btn btn-app btn-tumblr" href="{!! route('super_page_users') !!}" target="_self">
                <i class="fa fa-users"></i> DataUser
            </a>

            <a class="btn btn-app btn-facebook" href="{!! route('super_page_logs') !!}" target="_self">
                <i class="fa fa-paw"></i> Logs
            </a>
        @endif



    </section>
    <!-- /.content -->
@endsection
