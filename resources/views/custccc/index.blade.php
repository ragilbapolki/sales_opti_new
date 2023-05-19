@extends('layouts.master')

@section('title', 'CDI | Cust CCC')
@section('minititle', 'Cust CCC')

@section('css')
    @include('css.datatables.simple')
    <style>
        #radioBtn .notActive {
            color: #3276b1;
            background-color: #fff;
        }

        #lightgreen {
            color: #3276b1;
            background-color: #92CD00;
        }

        .box.box-hijau {
            border-top-color: #92CD00;
        }
    </style>
@stop

@section('content')
    <section class="content">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> </h4>

                    <div class="row">
                        <div class="col-xs-12" id="hasil">
                            <div class="box box-hijau">
                                <div class="box-header">
                                    <i class="fa fa-users"></i>
                                    {{-- <h3 class="box-title">Cust CCC</h3> --}}
                                    <!-- <input type="hidden" id="tahun" value="2019"> -->
                                    <!-- tools box -->
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body table-bordered no-padding">
                                    <div class="col-xs-12">
                                        <table id="dataccc" class="display nowrap compact" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>CCC</th>
                                                    <th>Cabang</th>
                                                    <th>Status</th>
                                                    <th>Level</th>
                                                    <th>Tgl.Daftar</th>
                                                    <th>Balace</th>
                                                    <th>Tot.Poin</th>
                                                    <th>Transaksi Terakhir</th>
                                                    <th>Nama</th>
                                                    <th>Tgl.Lahir</th>
                                                    <th>Titel</th>
                                                    <th>Alamat</th>
                                                    <th>Kota</th>
                                                    <th>Telp</th>
                                                    <th>HP</th>
                                                    <th>KodePos</th>
                                                    <th>Email</th>
                                                    <th>Voucher</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th>CCC</th>
                                                    <th>Cabang</th>
                                                    <th></th>
                                                    <th>Level</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Nama</th>
                                                    <th>Tgl.Lahir</th>
                                                    <th></th>
                                                    <th>Alamat</th>
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
                    </div>

                </div>
            </div>
        </div>
        {{-- @include('panel.buttonhome') --}}
    </section>
@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop

@section('page-script')

    <script>
        $(document).ready(function() {
            $('.custranking').addClass('active');
        });
    </script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Setup - add a text input to each footer cell
            $('#dataccc tfoot th').each(function() {
                var title = $(this).text();
                if (title == 'Level') {
                    $(this).html(
                        '<input type="text" placeholder="Filter Level" style="color: #aa001e;" />');
                } else if (title == 'Tgl.Lahir') {
                    $(this).html(
                        '<input type="text" placeholder="Filter Tgl.Lahir" style="color: #aa001e;" />');
                } else if (title == 'Cabang') {
                    $(this).html('<input type="text" placeholder="Filter Cabang" style="color: #aa001e;">');
                } else if (title == 'Nama') {
                    $(this).html('<input type="text" placeholder="Filter Nama" style="color: #aa001e;">');
                } else if (title == 'Alamat') {
                    $(this).html('<input type="text" placeholder="Filter Alamat" style="color: #aa001e;">');
                } else if (title == 'CCC') {
                    $(this).html('<input type="text" placeholder="Filter ID CCC" style="color: #aa001e;">');
                }
            });

            var table = $('#dataccc').DataTable({
                dom: 'Bfrtip',
                buttons: ['pageLength',
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            orthogonal: 'export',
                            columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17]
                        },
                        title: 'Data Member CCC'
                    },
                    // {
                    //   extend: 'colvis',text: 'Sembunyikan Kolom',
                    //   columnText: function ( dt, idx, title ) {
                    //     return (idx+1)+': '+title;
                    //   }
                    // } 
                    //'print'
                ],
                responsive: true,
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },
                scrollX: true,
                destroy: true,
                cache: false,
                destroy: true,
                // searching: false,
                processing: true,
                serverSide: true,
                responsive: true,
                // bFilter: false,
                // paging: false,
                // bInfo : false,
                // bLengthChange: false,
                select: true,
                // lengthMenu: [[17, 27, 99, 3000], [17, 27, 99, 3000]],
                lengthMenu: [
                    [10, 50, 99, 3000],
                    [10, 50, 99, 3000]
                ],
                order: [
                    [1, 'asc']
                ],
                ajax: {
                    url: '{{ route('data_cust_ccc') }}',
                    method: 'POST'
                },

                // type : "get",
                //   ajax: '/customerccc/data',

                columns: [{
                        data: 'cust_autonumber',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'cust_reward_id',
                        name: 'cust_reward_id'
                    },
                    {
                        data: 'cabang_reg_ccc',
                        name: 'cabang_reg_ccc'
                    },
                    // { data: 'ccc_aktif',name:'ccc_aktif'},
                    {
                        data: 'ccc_aktif',
                        name: 'ccc_aktif',
                        render: function(data, type, row) {
                            return data == 1 ? 'Aktif' : 'Non Aktif'
                        }
                    },
                    {
                        data: 'cust_reward_level',
                        name: 'cust_reward_level'
                    },
                    {
                        data: 'tgldaftar',
                        name: 'tgldaftar'
                    },
                    {
                        data: 'ccc_poin_balance',
                        name: 'ccc_poin_balance'
                    },
                    {
                        data: 'ccc_poin',
                        name: 'ccc_poin'
                    },
                    {
                        data: 'last_transaction',
                        name: 'last_transaction'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'birthdate',
                        name: 'birthdate',
                        "sClass": "text-center"
                    },
                    {
                        data: 'titel',
                        name: 'titel'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'kota',
                        name: 'kota'
                    },
                    {
                        data: 'telp',
                        name: 'telp'
                    },
                    {
                        data: 'hp',
                        name: 'hp'
                    },
                    {
                        data: 'kodepos',
                        name: 'kodepos'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'voucher',
                        name: 'voucher'
                    }
                ]
            });

            // table.on( 'order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();

            //Filter event handler
            table.columns().every(function() {
                var that = this;
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });

        });
    </script>

@stop
