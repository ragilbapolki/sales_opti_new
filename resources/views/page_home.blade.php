@extends('layouts.master')

@section('title', 'CDI | Home')

@section('minititle', 'Dashboard')

@section('content')



    {{-- Bataaaaaaaaaaaaaaaaaaaaaaaasssssssssssssssssssssssssssssss --}}



    <!-- Sales Card -->
    <div class="col-xxl-4 col-md-3">
        <div class="card info-card revenue-card">
            <a href="{{ route('page_listharga_erp') }}">
                <div class="card-body">
                    <h5 class="card-title">Price List </h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-currency-dollar"></i>
                        </div>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- End Sales Card -->
    @if (Auth::user()->role_id == 3)

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card revenue-card">
                <a href="{{ route('pagesales_stok_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Stok ERP </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-box"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_pemesanan') }}">
                    <div class="card-body">
                        <h5 class="card-title">Pemesanan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart-plus"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_historypesan') }}">
                    <div class="card-body">
                        <h5 class="card-title">History Pemesanan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-postcard-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card merah-card">
                <a href="{{ route('page_cust_aktivitas_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Customer ERP </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card merah-card">
                <a href="#">
                    <div class="card-body">
                        <h5 class="card-title">Data CCC ERP </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-database"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card merah-card">
                <a href="#">
                    <div class="card-body">
                        <h5 class="card-title">Cust Rank ERP </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wifi"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_aktivitas') }}">
                    <div class="card-body">
                        <h5 class="card-title">Customer </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_ccc') }}">
                    <div class="card-body">
                        <h5 class="card-title">Data CCC </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_rank') }}">
                    <div class="card-body">
                        <h5 class="card-title">Cust Rank </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wifi"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        @if (Auth::user()->jabatan_id == 6)
            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card merah-card">
                    <a href="{{ route('page_plan') }}">
                        <div class="card-body">
                            <h5 class="card-title">Plan Visit </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>145</h6>
                                    <span class="text-success small pt-1 fw-bold">12%</span> <span
                                        class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End Sales Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card sales-card">
                    <a href="{{ route('sales_page_visit') }}">
                        <div class="card-body">
                            <h5 class="card-title">His.Visit </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>145</h6>
                                    <span class="text-success small pt-1 fw-bold">12%</span> <span
                                        class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End Sales Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card sales-card">
                    <a href="{{ route('page_presensi') }}">
                        <div class="card-body">
                            <h5 class="card-title">Presensi </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-fingerprint"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>145</h6>
                                    <span class="text-success small pt-1 fw-bold">12%</span> <span
                                        class="text-muted small pt-2 ps-1">increase</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End Sales Card -->
        @endif

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card pink-card">
                <a href="{{ route('page_materiproduk') }}">
                    <div class="card-body">
                        <h5 class="card-title">Materi Produk </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-boxes"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->
    @elseif (Auth::user()->role_id == 2)
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('pagesales_stok_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Stok ERP </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-box"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_peritems_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Stok Item </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-diagram-2"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_aktivitas') }}">
                    <div class="card-body">
                        <h5 class="card-title">Customer </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_ccc') }}">
                    <div class="card-body">
                        <h5 class="card-title">Cust. CCC </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_rank') }}">
                    <div class="card-body">
                        <h5 class="card-title">Cust Rank </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wifi"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card merah-card">
                <a href="{{ route('page_plan') }}">
                    <div class="card-body">
                        <h5 class="card-title">Plan Visit </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_target') }}">
                    <div class="card-body">
                        <h5 class="card-title">Target Presensi </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-fingerprint"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card customers-card">
                <a href="{!! route('DataSales') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Data Sales </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card pink-card">
                <a href="{{ route('page_materiproduk') }}">
                    <div class="card-body">
                        <h5 class="card-title">Materi Produk </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-boxes"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_historypesan') }}">
                    <div class="card-body">
                        <h5 class="card-title">History Pesan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-postcard-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->
        {{-- 
        @if (Auth::user()->updated_at == null)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Note!</h4>
                        Mohon untuk mengganti password, karena password anda masih default.
                    </div>
                </div>
            </div>
        @endif --}}
    @elseif (Auth::user()->role_id == 4)
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('pageall_stok_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Stok Erp </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-box"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_peritems_erp') }}">
                    <div class="card-body">
                        <h5 class="card-title">Stok Item </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-diagram-2"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_custrank_area') }}">
                    <div class="card-body">
                        <h5 class="card-title">Cust Rank </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wifi"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_targetarea') }}">
                    <div class="card-body">
                        <h5 class="card-title">Target Presensi </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-fingerprint"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card customers-card">
                <a href="{{ route('pindahcabang') }}">
                    <div class="card-body">
                        <h5 class="card-title">Pindah Cabang </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_historypesan') }}">
                    <div class="card-body">
                        <h5 class="card-title">History Pesan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->
    @elseif (Auth::user()->role_id == 5)
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_pemesanan_cust') }}">
                    <div class="card-body">
                        <h5 class="card-title">Pemesanan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-view-list"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_historypesan_cust') }}">
                    <div class="card-body">
                        <h5 class="card-title">History Pesan </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->
    @else
        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_custrank_area') }}">
                    <div class="card-body">
                        <h5 class="card-title">Cust Rank </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wifi"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{{ route('page_cust_aktivitas') }}">
                    <div class="card-body">
                        <h5 class="card-title">Customer </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card customers-card">
                <a href="{!! route('pindahcabang') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Pindah Cabang </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card merah-card">
                <a href="{{ route('page_plan') }}">
                    <div class="card-body">
                        <h5 class="card-title">Plan Visit </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card coklat-card">
                <a href="{!! route('report') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Report Sales </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-clipboard-data"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card customers-card">
                <a href="{!! route('DataSales') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Data Sales </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card pink-card">
                <a href="https://app.cobradental.co.id:1780/jajal/tolakplansistem.php">
                    <div class="card-body">
                        <h5 class="card-title">runCorn </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card dongker-card">
                <a href="{!! route('super_page_users') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Data User </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-video3"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-3">
            <div class="card info-card sales-card">
                <a href="{!! route('super_page_logs') !!}">
                    <div class="card-body">
                        <h5 class="card-title">Logs </h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-egg"></i>
                            </div>
                            {{-- <div class="ps-3">
                                <h6>145</h6>
                                <span class="text-success small pt-1 fw-bold">12%</span> <span
                                    class="text-muted small pt-2 ps-1">increase</span>
                            </div> --}}
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Sales Card -->

    @endif

@endsection

</html>
