@extends('layouts.master')

@section('title', 'CDI | Plan')
@section('minititle', 'Plan Visit')

@section('css')
    @include('css.fullcalendar')
    @include('css.select2')
    <style>
        .none {
            display: none;
        }

        ,
        .showDIV {
            display: block;
        }

        .box.box-calender {
            /*background: transparent;*/
            background: #ffffff;
            border-top-color: #92CD00;
        }

        td.fc-other-month .fc-day-number {
            display: none;
        }

        .fc-button {
            color: #ffffff;
            background: #2c4762;
        }

        .fc-button:hover {
            color: #ffffff;
            background: #1c2d3f;
        }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kode cabang {{ strtoupper(Auth::user()->kode_cabang) }}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-calendar"></i> Rencana Kunjungan</li>
        </ol>
    </section>

    <!-- Main content -->
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Data Kunjungan</h4> --}}

                <br>
                <div class="row">
                    {{-- <div class="col-sm-7">
                        <div class="box box-calender">
                            <div id="calendar"></div>
                        </div>
                    </div> --}}

                    <div class="col-sm-5">
                        @if (Auth::user()->role_id == 3)
                            <div class="box box-calender">
                                <div class="box-header with-border">
                                    <i class="fa fa-user-plus"></i>
                                    <h3 class="box-title">Tambah Rencara Kunjungan </h3>
                                </div>
                                <div class="box-body">
                                    <form role="form" method="POST" action="{{ route('addplan') }}">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Tanggal*</label>
                                                <input name="tanggal" class="form-control" type="date"
                                                    min="<?php print date('Y-m-d'); ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label>Customer*</label>
                                                <select name="customer" id="customer" class="form-control select2"
                                                    required="">
                                                    <option value="">- Nama Customer -</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Hasil Kemarin</label>
                                                <textarea name="hasil" id="hasil" class="form-control" rows="2" disabled=""></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan*</label>
                                                <textarea name="keterangan" class="form-control" rows="3"
                                                    placeholder="Tolong tulis barang yg akan ditawarkan atau hal yg akan diselesaikan" required=""></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-outline-primary"
                                                id="tmbSales">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- <div class="box box-calender"> --}}
                            <div class="row">

                                <!-- Sales Card -->
                                <div class="col-xxl-4 col-md-6">
                                    <div class="card info-card customers-card">
                                        <a href="{{ route('plan_pending') }}">
                                            <div class="card-body">
                                                <h5 class="card-title">Menunggu Persetujuan </h5>

                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-hourglass"></i>
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
                                <div class="col-xxl-4 col-md-6">
                                    <div class="card info-card revenue-card">
                                        <a href="{{ route('plan_approved') }}">
                                            <div class="card-body">
                                                <h5 class="card-title">Disetujui </h5>
                                                <br>

                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                        <i class="bi bi-card-checklist"></i>
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

                            </div>

                            <!-- /.box-header -->
                            {{-- <div class="box-body">
                                <a class="btn btn-app btn-tumblr" href="{{ route('plan_pending') }}" target="_self">
                                    <i class="glyphicon glyphicon-tag"></i> Menunggu Persetujuan
                                </a>
                                <a class="btn btn-app btn-tumblr" href="{{ route('plan_approved') }}" target="_self">
                                    <i class="glyphicon glyphicon-tags"></i>Disetujui
                                </a>
                            </div> --}}
                            {{-- </div> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('javascript')
        @include('js.select2')
        <script src="{{ URL::asset('bower_components/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    @stop

    @section('page-script')

        <script>
            $(document).ready(function() {
                $('.rencana').addClass('active');
            });
        </script>

        <script type="text/javascript">
            $(function() {
                $('.select2').select2({
                    minimumInputLength: 3,
                    allowClear: true,
                    placeholder: 'masukkan nama Customer',
                    // width: '275px',
                    width: '100%',
                    ajax: {
                        dataType: 'json',
                        // url: 'daftarProvinsi.php',
                        url: '{{ route('selectcust') }}',
                        delay: 800,
                        data: function(params) {
                            return {
                                search: params.term
                            }
                        },
                        processResults: function(data, page) {
                            return {
                                results: data
                            };
                        },
                    }
                }).on('select2:select', function(evt) {
                    var datane = evt.params.data;
                    console.log(datane.id);
                    $(".select2 option:selected").text();
                    hiscust(datane.id);
                    // var data = $(".select2 option:selected").text();
                    // alert("Data yang dipilih adalah "+data);
                });
            });

            function hiscust(x) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('hiscust') }}',
                    data: {
                        id: x
                    },
                    cache: false,
                    success: function(response) {
                        console.log(typeof response);
                        var data = jQuery.parseJSON(response);
                        $("#hasil").val(data.keterangan);
                    }
                });
            }
        </script>

        <script>
            $('body').on('click', 'button.fc-prev-button', function() {
                var view = $('#calendar').fullCalendar('getView');
                var myCalendar = $('#calendar');
                myCalendar.fullCalendar();
                myCalendar.fullCalendar('removeEvents')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{!! route('data_plan') !!}',
                    data: {
                        bulan: view.title
                    },
                    cache: false,
                    success: function(data) {
                        var objdata = JSON.parse(data);
                        var jajal = objdata;
                        myCalendar.fullCalendar('addEventSource', jajal)
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                    }
                });
            });

            $('body').on('click', 'button.fc-next-button', function() {
                var view = $('#calendar').fullCalendar('getView');
                var myCalendar = $('#calendar');
                myCalendar.fullCalendar();
                myCalendar.fullCalendar('removeEvents')
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{!! route('data_plan') !!}',
                    data: {
                        bulan: view.title
                    },
                    cache: false,
                    success: function(data) {
                        var objdata = JSON.parse(data);
                        var jajal = objdata;
                        myCalendar.fullCalendar('addEventSource', jajal)
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '{!! route('data_plan') !!}',
                    data: {
                        tanggal: 2
                    },
                    cache: false,
                    success: function(data) {
                        var objdata = JSON.parse(data);
                        var jajal = objdata;
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev next',
                                center: 'title',
                                right: 'prev next',
                            },
                            events: jajal
                        });
                    },
                    error: function(data) {
                        var errors = data.responseJSON;

                    }
                });
            })
        </script>

    @stop
