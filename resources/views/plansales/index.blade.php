@extends('layouts.master')

@section('title', 'CDI | Plan PerTanggal')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $data['tglview'] }}
            <small><input type="hidden" id="tgl" value="{{ $data['tgl'] }}"></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('page_plan') }}"><i class="fa fa-calendar"></i> Rencana Kunjungan s</a></li>
            <li class="active">PlanPerTanggal </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="dataplan" class="display nowrap compact" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th>Alamat</th>
                                            <th>Tujuan</th>
                                            <th>Hasil</th>
                                            <th>Ket Tolak</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Customer</th>
                                            <th>Alamat</th>
                                            <th>Tujuan</th>
                                            <th>Hasil</th>
                                            <th>Ket Tolak</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p id="demo"></p>
        <!-- modaal cekin -->
        <div class="modal fade" id="modal-cekin" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Klik tombol CheckIN bila berada ditempat berikut</h5>
                    </div>
                    <div class="modal-body ">
                        <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                        <p class="text-muted">
                            <label id="customer"></label>
                        </p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                        <p class="text-muted">
                            <label id="alamatcust"></label>
                        </p>
                        <hr>
                        <strong><i class="fa fa-edit margin-r-5"></i> Keperluan</strong>
                        <p class="text-muted">
                            <label id="deskripsicust"></label>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id='idplan'>
                        <button type="button" class="btn bg-green" id="btnChekIn">CheckIn</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modaal cekout -->
        <div class="modal fade" id="modal-cekout" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Klik tombol CheckOut bila berada ditempat berikut</h5>
                    </div>
                    <form class="form-horizontal" role="form" id="formIDe">
                        <div class="modal-body ">
                            <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                            <p class="text-muted">
                                <label id="customer2"></label>
                            </p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                            <p class="text-muted">
                                <label id="alamatcust2"></label>
                            </p>
                            <hr>
                            <strong><i class="fa fa-edit margin-r-5"></i> Hasil Kunjungan*</strong>
                            <p class="text-muted">
                                <!-- <label id="deskripsicust2"></label> -->
                                <textarea name="hasil" class="form-control" rows="3"
                                    placeholder="Silahkan tulis hasil dari kunjungan yang telah dilakukan" required=""></textarea>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id='idplan2' name="idplan">
                            <input type="hidden" name="lat" id="latitude" value="">
                            <input type="hidden" name="long" id="longitude" value="">
                            <button type="submit" class="btn btn-primary" id="btnChekOut">CheckOut</button>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- modaal BatalCekin -->
        <div class="modal fade" id="modal-batalcekin" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Batal CheckIN</h5>
                    </div>
                    <div class="modal-body ">
                        <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                        <p class="text-muted">
                            <label id="customer3"></label>
                        </p>
                        <hr>
                        <strong><i class="fa fa-edit margin-r-5"></i> Note</strong>
                        <p class="text-muted">
                            <label id="deskripsicust3">Jika tombol Cancel CheckIn diklik maka anda membatalkan check in
                                (Bukan menghapus Plan,jadi bisa check in kembali nanti)</label>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id='idplan3'>
                        <button type="button" class="btn bg-red" id="btnCancelChekIn">Cancel CheckIn</button>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.buttonbackplan')
    </section>
    <!-- /.content -->
@endsection

@section('page-script')

    <script>
        $(document).ready(function() {
            var tgl = $("#tgl").val();
            var x = document.getElementById("demo");

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Maaf Browser tidak supported untuk Aplikasi ini";
            }

            function showPosition(position) {
                // x.innerHTML = "Latitude: " + position.coords.latitude + 
                // "<br>Longitude: " + position.coords.longitude;
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                showTable(latitude, longitude);
            }

            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        x.innerHTML = "<b>GPS DIBLOK BROSER ANDA,SILAHKAN AKTIFKAN ATAU HUB.IT."
                        break;
                    case error.POSITION_UNAVAILABLE:
                        x.innerHTML = "Location information is unavailable."
                        break;
                    case error.TIMEOUT:
                        x.innerHTML = "The request to get user location timed out."
                        break;
                    case error.UNKNOWN_ERROR:
                        x.innerHTML = "An unknown error occurred."
                        break;
                }
            }



            function showTable(a, b) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $('#dataplan').DataTable({
                    responsive: true,
                    "language": {
                        "emptyTable": "Data tidak ditemukan"
                    },
                    // searching: false,
                    paging: false,
                    bInfo: false,
                    bLengthChange: false,
                    scrollX: true,
                    destroy: true,
                    cache: false,
                    select: true,
                    order: [
                        [3, 'asc']
                    ],
                    ajax: {
                        method: 'POST',
                        url: '{!! route('plan_per_tgl_show') !!}',
                        data: {
                            'tgl': tgl
                        },
                    },
                    columnDefs: [{
                        "width": "3%",
                        "targets": 0
                    }],
                    columns: [{
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                // return data == 1 ? '<button class="btn bg-green btn-xs delsales" ><i class="fa fa-play"></i>  </button>' : '' 
                                if (data == 1) {
                                    return '<button class="btn bg-green btn-xs cekin" ><i class="fa fa-play"></i>  </button>';
                                } else if (data == 2) {
                                    return '<button class="btn btn-warning btn-xs cekout" ><i class="fa fa-stop"></i>  </button><button class="btn btn-danger btn-xs batalcekin"><i class="fa fa-close"></i> </button>';
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                // return data == 1 ? '<button class="btn bg-green btn-xs delsales" ><i class="fa fa-play"></i>  </button>' : '' 
                                if (data == 0) {
                                    return 'Pending';
                                } else if (data == 1) {
                                    return 'Disetujui';
                                } else if (data == 2) {
                                    return 'Sedang ChekIn';
                                } else if (data == 3) {
                                    return 'Selesai';
                                } else {
                                    return 'Ditolak';
                                }
                            }
                        },
                        {
                            data: 'tgl',
                            name: 'tgl'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'alamat'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan'
                        },
                        {
                            data: 'hasil',
                            name: 'hasil'
                        },
                        {
                            data: 'ket_tolak',
                            name: 'ket_tolak'
                        }
                    ]
                });

                var table = $("#dataplan").DataTable();

                table.on('click', '.cekin', function() {
                    $tr = $(this).closest('tr');
                    var data = table.row($tr).data();
                    // console.log(data);
                    // alert(data.name +"'s salary is: "+ data.username);
                    $('#modal-cekin').modal('show');
                    $('#customer').html(data.name);
                    $('#alamatcust').html(data.alamat);
                    $('#deskripsicust').html(data.keterangan);
                    document.getElementById('idplan').value = data.id;
                });

                table.on('click', '.cekout', function() {
                    $tr = $(this).closest('tr');
                    var data = table.row($tr).data();
                    // console.log(data);
                    // alert(data.name +"'s salary is: "+ data.username);
                    $('#modal-cekout').modal('show');
                    $('#customer2').html(data.name);
                    $('#alamatcust2').html(data.alamat);
                    $('#deskripsicust2').html(data.keterangan);
                    document.getElementById('idplan2').value = data.id;
                });

                table.on('click', '.batalcekin', function() {
                    $tr = $(this).closest('tr');
                    var data = table.row($tr).data();
                    console.log(data);
                    // alert(data.name +"'s salary is: "+ data.username);
                    $('#modal-batalcekin').modal('show');
                    $('#customer3').html(data.name);
                    // $('#alamatcust3').html(data.alamat);
                    document.getElementById('idplan3').value = data.id;
                });

                table.on('click', '.pemesanan', function() {
                    $tr = $(this).closest('tr');
                    var data = table.row($tr).data();
                    console.log(data);
                    $('#customer3').html(data.name);
                    document.getElementById('idplan3').value = data.id;
                });

                $("#btnChekIn").click(function() {
                    var idplan = $('#idplan').attr("value");
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('plan_cekin') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": idplan,
                            "lat": a,
                            "long": b
                        },
                        cache: false,
                        success: function() {
                            // location.reload();
                            $('#modal-cekin').modal('hide');
                            $('#dataplan').DataTable().ajax.reload();
                        }
                    });
                });

                // $("#btnChekOut").click(function(){
                //     var idplan = $('#idplan').attr("value");
                //     var keterangan = $('#idplan').attr("value");
                //     $.ajax({
                //       type: 'POST',
                //       url: '{{ route('plan_cekout') }}',
                //       data: {"_token": "{{ csrf_token() }}","id": idplan,"lat":a,"long":b},
                //       cache:false,
                //       success: function() {
                //         $('#modal-cekout').modal('hide');
                //         $('#dataplan').DataTable().ajax.reload();
                //       }
                //     });
                // });

                $('#btnChekOut').on('click', function(event) {
                    var isvalidate = $("#formIDe")[0].checkValidity();
                    if (isvalidate) {
                        event.preventDefault();
                        var datacekout = $('.form-horizontal').serialize();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'post',
                            url: '{{ route('plan_cekout') }}',
                            data: datacekout,
                            cache: false,
                            success: function(data) {
                                $('#modal-cekout').modal('hide');
                                $('#dataplan').DataTable().ajax.reload();
                            }
                        });
                    }
                });

                $("#btnCancelChekIn").click(function() {
                    var idplan3 = $('#idplan3').attr("value");
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('plan_cancel_cekin') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": idplan3
                        },
                        cache: false,
                        success: function() {
                            // location.reload();
                            $('#modal-batalcekin').modal('hide');
                            $('#dataplan').DataTable().ajax.reload();
                        }
                    });
                });

            }

        });
    </script>

@stop
