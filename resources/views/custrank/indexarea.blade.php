@extends('layouts.master')

@section('title', 'CDI | Cust Ranking')


@section('css')
    @include('css.datatables.full')
    <style>
        .dataTables_filter,
        .dataTables_info {
            display: none;
        }
    </style>
    <style>
        .none {
            display: none;
        }

        ,
        .showDIV {
            display: block;
        }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            CustRank
            <small>cobra dental</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route($nameroute) }}"><i class="fa fa-user"></i> Customer</a></li>
            <li class="active">CustRank</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row" id="formcari">
            <div class="col-sm-6">
                <div class="box box-primary" id="panelbox">
                    <form class="form-horizontal" role="form" id="formIDe">
                        <div class="box-body" id="formtiga">
                            <div class="form-group">
                                <label for="inputsm" class="col-sm-2 control-label">Cabang</label>
                                <div class="col-sm-9">
                                    <select name="cabang" id="cabang" class="form-control select3" style="width: 100%"
                                        required="">
                                        <option value="" selected>Semua Cabang</option>
                                        @foreach ($cabangs as $key => $val)
                                            <option value="{{ $val['kode'] }}">{{ $val['kode'] }} - {{ $val['alias'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputsm" class="col-sm-2 control-label">Tanggal</label>
                                <div class="col-sm-4">
                                    <input name="f2tglAwal" id="f2tglAwal" class="form-control input-sm" autocomplete="off"
                                        placeholder="Tgl Awal" required>
                                </div>
                                <label for="inputsm" class="col-sm-1 control-label">s.d</label>
                                <div class="col-sm-4">
                                    <input name="f2tglAkhir" id="f2tglAkhir" class="form-control input-sm"
                                        autocomplete="off" placeholder="Tgl Akhir" required>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer" id="foter">
                            <button type="submit" class="btn btn-xs btn-info col-sm-3 col-sm-offset-4" name="cari"
                                id="buttonIDe" onClick="">
                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 none" id="hasil">
                <div class="box box-hijau">
                    <div class="box-header">
                        <i class="fa fa-signal"></i>
                        <h3 class="box-title">Cust Rank Th.</h3>
                    </div>
                    <div class="box-body table-bordered no-padding">
                        <div class="col-xs-12">
                            <table id="custrank" class="display nowrap compact" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Cabang</th>
                                        <th>Nama</th>
                                        <th>Titel</th>
                                        <th>Lev CCC</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        <th>Telp</th>
                                        <th>Hp</th>
                                        <th>Jml Nota</th>
                                        <th>Total Belanja</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Cabang</th>
                                        <th>Nama</th>
                                        <th>Titel</th>
                                        <th>Lev CCC</th>
                                        <th>Alamat</th>
                                        <th>Kota</th>
                                        <th>Telp</th>
                                        <th>Hp</th>
                                        <th>Jml Nota</th>
                                        <th>Total Belanja</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.buttonhome')
    </section>
@endsection

@section('javascript')
    @include('js.datatables.full')
@stop

@section('page-script')
    <script>
        $(function() {
            $("#f1tglAwal, #f1tglAkhir,#f2tglAwal, #f2tglAkhir").datepicker({
                dateFormat: 'dd MM yy',
                changeMonth: true,
                changeYear: false,
                onSelect: function(selectedDate) {
                    var startDate = new Date(selectedDate);
                    var selectedYear = startDate.getFullYear(); // selected year
                    var maksidate = selectedYear + "-12-31";
                    if (this.id == "f1tglAwal") {
                        $("#f1tglAkhir").datepicker("option", "minDate", selectedDate);
                    } else if (this.id == "f2tglAwal") {
                        $("#f2tglAkhir").datepicker("option", "minDate", selectedDate);
                        $("#f2tglAkhir").datepicker("option", "maxDate", new Date(maksidate));
                    } else {

                    }
                }
            });
        });
    </script>

    <!-- tabel hasil pencarian -->
    <script>
        $(document).ready(function() {
            $('#buttonIDe').on('click', function(event) {
                var isvalidate = $("#formIDe")[0].checkValidity();
                if (isvalidate) {
                    event.preventDefault();
                    var data = $('.form-horizontal').serialize();
                    console.log(data);
                    $("#hasil").addClass("none");
                    $('#custrank').dataTable().fnClearTable();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '{!! route('data_custrank_area') !!}',
                        data: data,
                        cache: false,
                        success: function(data) {
                            $("#hasil").removeClass("none");

                            // Setup - add a text input to each footer cell
                            $('#custrank tfoot th').each(function() {
                                var title = $(this).text();
                                if (title == 'Cabang') {
                                    $(this).html(
                                        '<input type="text" placeholder="Filter Cabang" style="color: #aa001e;" />'
                                    );
                                } else if (title == 'Nama') {
                                    $(this).html(
                                        '<input type="text" placeholder="Filter Nama" style="color: #aa001e;" />'
                                    );
                                } else if (title == 'Titel') {
                                    $(this).html(
                                        '<input type="text" placeholder="Filter Titel" style="color: #aa001e;" />'
                                    );
                                } else if (title == 'Kota') {
                                    $(this).html(
                                        '<input type="text" placeholder="Filter Kota" style="color: #aa001e;">'
                                    );
                                }
                            });
                            var table = $('#custrank').DataTable({
                                "language": {
                                    "emptyTable": "Data tidak ditemukan"
                                },
                                dom: 'Bfrtip',
                                buttons: ['pageLength',
                                    {
                                        extend: 'excelHtml5',
                                        exportOptions: {
                                            orthogonal: 'export'
                                        },
                                        title: 'Cust Rank'
                                    },
                                    //'print'
                                ],
                                scrollX: true,
                                destroy: true,
                                cache: false,
                                destroy: true,
                                // searching: false,
                                // paging: false,
                                // bInfo : false,
                                // bLengthChange: false,
                                select: true,
                                // order: [[ 1, 'asc' ]],
                                order: [
                                    [8, 'desc']
                                ],
                                lengthMenu: [
                                    [10, 50, 99, 3000],
                                    [10, 50, 99, 3000]
                                ],
                                // processing: true,
                                data: data.data,
                                columns: [{
                                        data: 'cabang',
                                        width: '18px'
                                    },
                                    {
                                        data: 'name',
                                        width: '200px'
                                    },
                                    {
                                        data: 'titel',
                                        width: '200px'
                                    },
                                    {
                                        data: 'ccc_level',
                                        width: '200px'
                                    },
                                    // { data: 'total', width: '20px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
                                    {
                                        data: 'alamat',
                                        width: '400px'
                                    },
                                    {
                                        data: 'kota',
                                        width: '400px'
                                    },
                                    {
                                        data: 'telp',
                                        width: '400px'
                                    },
                                    {
                                        data: 'hp',
                                        width: '400px'
                                    },
                                    {
                                        data: 'totalnota',
                                        width: '400px'
                                    },
                                    // { data: 'totalbelanja', width: '400px' },
                                    {
                                        data: 'totalbelanja',
                                        width: '20px',
                                        "render": $.fn.dataTable.render.number('.',
                                            ',', 0),
                                        "sClass": "text-right"
                                    },
                                    // { data: 'tgl_lahir', width: '400px' },
                                ]
                            });
                            //Filter event handler
                            table.columns().every(function() {
                                var that = this;
                                $('input', this.footer()).on('keyup change',
                                    function() {
                                        if (that.search() !== this.value) {
                                            that
                                                .search(this.value)
                                                .draw();
                                        }
                                    });
                            });
                        }
                    });

                }
            });
        });
    </script>

@stop
