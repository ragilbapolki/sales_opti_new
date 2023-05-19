@extends('layouts.master')

@section('title', 'CDI | Pemesanan')
@section('minititle', 'History Pemesanan')

@section('css')
    @include('css.datatables.full')
    <style>
        .dataTables_filter {
            display: none;
        }

        td.details-control {
            background: url('{{ URL::asset('dist/img/details_open.png') }}') no-repeat center center;
            cursor: pointer;
        }

        tr.details td.details-control {
            background: url('{{ URL::asset('dist/img/details_close.png') }}') no-repeat center center;
        }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
        <h1>
            Pemesanan
        </h1>
    </section> --}}
    <!-- Main content -->
    <section class="content">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> </h4>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info alert-dismissible">
                                {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                                <h4><i class="icon fa fa-info"></i> Perhatian!</h4>
                                * Data Pemesanan adalah tabel untuk melakukan perubahan status "Deal". <br>
                                * History Pemesanan (khusus KATO) adalah tabel data history pemesanan untuk export data
                                Excel.
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span id="form_output"></span>
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <i class="fa fa-list-alt"></i>
                                    <h3 class="box-title">Data Pemesanan</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="historipesan" class="display nowrap compact" cellspacing="0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <!--                           <th>Auto ID</th>  -->
                                                        <th>Nota</th>
                                                        <th>Tanggal</th>
                                                        <th>Total</th>
                                                        <th>terbayar</th>
                                                        <th>Kembali</th>
                                                        <th>Kurang</th>
                                                        <th>Pembayaran</th>
                                                        <th>Sales</th>
                                                        <th>Customer</th>
                                                        <th>Tipe Cust</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <!--                           <th></th> -->
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <div class="form-group">
                                                <input type="hidden" name="jabatan" id="jabatan" class="form-control"
                                                    value="{{ Auth::user()->jabatan }}" readonly />
                                            </div>
                                            <script id="details-template" type="text/x-handlebars-template">
                        <div class="label label-info">Detail Pemesanan @{{ nota }}</div>
                        <table class="table details-table" id="@{{nota}}">
                            <thead>
                                <tr>
                                    <th>Nota</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th> 
                                    <th>Diskon</th>  
                                    <th>Harga</th> 
                                    <th>QTY</th>
                                </tr>
                            </thead>
                        </table>
                    </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col-12 -->
                        <div class="col-md-12" id="divexportexcel" style="display: none;">
                            <span id="form_output"></span>
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <i class="fa fa-list-alt"></i>
                                    <h3 class="box-title">History Pemesanan</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-4">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h4><i class="fa fa-search"></i> Filter Tanggal </h4>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Tgl. Awal</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" readonly name="tglawal"
                                                                        class="form-control pull-right" id="dateawal" />
                                                                </div>
                                                            </div>
                                                        </div><!-- /.col-lg-6 -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Tgl. Akhir</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                    <input type="text" readonly name="tglakhir"
                                                                        class="form-control pull-right" id="dateakhir" />
                                                                </div>
                                                            </div>
                                                        </div><!-- /.col-lg-6 -->
                                                    </div><!-- /.row -->
                                                    <div></div>
                                                    <div class="form-group" align="center">
                                                        <button type="button" name="filter" id="filter"
                                                            class="btn btn-info">Filter</button>
                                                        <button type="button" name="reset" id="reset"
                                                            class="btn btn-default">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <table id="export" class="display nowrap compact" cellspacing="0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nota</th>
                                                        <th>Tanggal</th>
                                                        <th>Sales</th>
                                                        <th>Customer</th>
                                                        <th>TipeCust</th>
                                                        <th>Ko.Bar</th>
                                                        <th>NamaBarang</th>
                                                        <th>Diskon</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Keterangan</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col-12 -->

                    </div>

                </div>
            </div>
        </div>
        {{-- @include('panel.buttonhome') --}}
    </section>
@endsection

@section('javascript')
    @include('js.datatables.full')
@stop


@section('page-script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#dateawal').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#dateakhir').datepicker({
                format: 'yyyy-mm-dd'
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function initTable(tableId, data) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#' + tableId).DataTable({
                    processing: true,
                    serverSide: true,
                    bInfo: false,
                    bPaginate: false,
                    bLengthChange: false,
                    bFilter: false,
                    ajax: data.details_url,
                    columns: [
                        // { data: 'auto_id', name: 'auto_id' },
                        {
                            data: 'nota',
                            name: 'nota'
                        },
                        {
                            data: 'kobar',
                            name: 'kobar'
                        },
                        {
                            data: 'namabarang',
                            name: 'namabarang'
                        },
                        {
                            data: 'diskon',
                            name: 'diskon'
                        },
                        {
                            data: 'harga',
                            name: 'harga'
                        },
                        {
                            data: 'qty',
                            name: 'qty'
                        }
                    ]
                })
            }

            // $('#historipesan tfoot th').each( function () {
            //     var title = $(this).text();
            //               if (title=='Customer') {
            //                   $(this).html( '<input type="text" class="form-control" placeholder="Filter Customer" style="color: #aa001e;" />' );
            //               }
            // } );

            var jabatan = $("#jabatan").val();
            var template = Handlebars.compile($("#details-template").html());
            var table = $('#historipesan').DataTable({

                scrollX: true,
                scrollY: true,
                destroy: true,
                cache: false,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                destroy: true,
                order: [
                    [1, 'asc']
                ],
                ajax: '{{ url('historypemesanan/master') }}',

                columns: [{
                        "className": 'details-control',
                        "orderable": false,
                        "searchable": false,
                        "data": null,
                        "defaultContent": ''
                    },
                    // { data: 'auto_id', name: 'auto_id'},
                    {
                        data: 'nota',
                        name: 'nota'
                    },
                    {
                        data: 'tgl',
                        name: 'tgl'
                    },
                    {
                        data: 'totalpenjualan',
                        name: 'total',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    },
                    {
                        data: 'terbayar',
                        name: 'bayar',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    },
                    {
                        data: 'kembali',
                        name: 'kembali',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    },
                    {
                        data: 'kekurangan',
                        name: 'kekurangan',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    },
                    {
                        data: 'type',
                        name: 'pembayaran'
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: null,
                        name: 'nama',
                        render: function(data, type, full, meta) {
                            return full['customer'] + " " + full['name'];
                        }
                    },
                    {
                        data: 'type_cust',
                        name: 'type_cust'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (jabatan == 'Sales') {
                                return data == 1 ?
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" checked data-toggle="toggle" data-size="mini" disabled/>' :
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" data-toggle="toggle" data-size="mini" disabled/>'
                            } else if (jabatan == 'Kepala Toko') {
                                return data == 1 ?
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" checked data-toggle="toggle" data-size="mini"/>' :
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" data-toggle="toggle" data-size="mini"/>'
                            } else if (jabatan == 'Manager Area') {
                                return data == 1 ?
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" checked data-toggle="toggle" data-size="mini" disabled/>' :
                                    '<input type="checkbox" class="toggle-demo" name="statushist" id="statushist" data-toggle="toggle" data-size="mini" disabled/>'
                            }
                        }
                    }
                ],
                "fnDrawCallback": function() {
                    $('.toggle-demo').bootstrapToggle({
                        on: 'Deal',
                        off: 'Cancel',
                        onstyle: 'success',
                        offstyle: 'danger'
                    });
                }
            });

            //Filter event handler
            // table.columns().every( function () {
            //     var that = this;
            //     $( 'input', this.footer() ).on( 'keyup change', function () {
            //         if ( that.search() !== this.value ) {
            //             that
            //                 .search( this.value )
            //                 .draw();
            //         }
            //     } );
            // } );

            // Add event listener for opening and closing details
            $('#historipesan tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var tableId = row.data().nota;


                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('details');
                } else {
                    // Open this row                      
                    row.child(template(row.data())).show();
                    initTable(tableId, row.data());
                    tr.addClass('details');
                    tr.next().find('td').addClass('no-padding bg-gray');
                }
            });

            table.on('change', '.toggle-demo', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                var id = data['auto_id'];
                var status = $(this).prop('checked') == true ? 1 : 0;
                swal.fire({
                        title: "Apa anda yakin merubah data ?",
                        text: "Data akan mengalami perubahan !",
                        type: "error",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Ya",
                        cancelButtonText: "Batal",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: false
                    })
                    .then((willDelete) => {
                        if (willDelete.value) {
                            $.ajax({
                                type: "GET",
                                dataType: "json",
                                url: '{{ route('changestatus') }}',
                                data: {
                                    'status': status,
                                    'id': id
                                },
                                // processData: false,
                                // contentType: false,
                                success: function(data) {
                                    table.ajax.reload();
                                    texport();
                                    swal.fire("Done !", data.konfirm, "success");
                                }
                            });
                        } else {
                            table.ajax.reload();
                            texport();
                            swal.fire("Canceled !", "Data aman !", "success");
                        }
                    }); // swal fire
            });



            if (jabatan == "Kepala Toko") {
                $("#divexportexcel").show();
            }


            texport();

            function texport(dateawal = '', dateakhir = '') {

                // $('#export tfoot th').each( function () {
                //     var judul = $(this).text();
                //               if (judul=='NamaCustomer') {
                //                   $(this).html( '<input type="text" class="form-control" placeholder="Filter Customer" style="color: #aa001e;" />' );
                //               }
                // } );

                var texport = $('#export').DataTable({
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        // customize: function( xlsx ) {
                        //     var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        //     $('row g[r^="G"]', sheet).attr( 's', '50' );
                        // },            
                        title: 'Data History Pemesanan',
                        text: 'Export <i class="icon fa fa-file-excel-o"></i>'
                    }],
                    scrollX: true,
                    scrollY: true,
                    destroy: true,
                    cache: false,
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    destroy: true,
                    order: [
                        [1, 'asc']
                    ],
                    ajax: {
                        url: '{{ route('export_historypesan') }}',
                        method: 'GET',
                        data: {
                            dateawal: dateawal,
                            dateakhir: dateakhir
                        }
                    },
                    columns: [{
                            data: 'DT_Row_Index',
                            name: 'DT_Row_Index',
                            width: '3%'
                        },
                        {
                            data: 'nota',
                            name: 'nota',
                            width: '13%'
                        },
                        {
                            data: 'tgl',
                            name: 'tgl',
                            width: '10%'
                        },
                        {
                            data: 'sales',
                            name: 'sales',
                            width: '10%'
                        },
                        {
                            data: null,
                            name: 'nama',
                            width: '15%',
                            render: function(data, type, full, meta) {
                                return full['customer'] + " / " + full['name'];
                            }
                        },
                        {
                            data: 'type_cust',
                            name: 'type_cust',
                            width: '7%'
                        },
                        {
                            data: 'kobar',
                            name: 'kobar',
                            width: '7%',
                            render: $.fn.dataTable.render.text()
                        },
                        {
                            data: 'namabarang',
                            name: 'type_cust',
                            width: '15%'
                        },
                        {
                            data: 'diskon',
                            name: 'diskon',
                            width: '5%'
                        },
                        {
                            data: 'harga',
                            name: 'harga',
                            width: '10%'
                        },
                        {
                            data: 'qty',
                            name: 'qty',
                            width: '10%'
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
                            width: '10%'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            width: '5%',
                            render: function(data, type, row) {
                                if (jabatan == 'Sales') {
                                    return data == 0 ?
                                        '<span class="label label-danger">Cancel</span>' :
                                        '<span class="label label-success">Deal</span>'
                                } else if (jabatan == 'Kepala Toko') {
                                    return data == 0 ?
                                        '<span class="label label-danger">Cancel</span>' :
                                        '<span class="label label-success">Deal</span>'
                                } else if (jabatan == 'Manager Area') {
                                    return data == 0 ?
                                        '<span class="label label-danger">Cancel</span>' :
                                        '<span class="label label-success">Deal</span>'
                                }
                            }
                        }
                    ],
                });

                //Filter event handler
                // texport.columns().every( function () {
                //     var that_is = this;
                //     $( 'input', this.footer() ).on( 'keyup change', function () {
                //         if ( that_is.search() !== this.value ) {
                //             that_is
                //                 .search( this.value )
                //                 .draw();
                //         }
                //     } );
                // } );


            } //function




            $('#filter').click(function() {
                var dateawal = $('#dateawal').val();
                var dateakhir = $('#dateakhir').val();

                if (dateawal != '' && dateakhir != '') {
                    $('#export').DataTable().destroy();
                    texport(dateawal, dateakhir);
                } else {
                    swal.fire("Error!", 'Kedua tanggal diperlukan !', "error");
                }
            });

            $('#reset').click(function() {
                $('#dateawal').val('');
                $('#dateakhir').val('');
                $('#export').DataTable().destroy();
                texport();
            });


        }); //doc
    </script>
@stop
