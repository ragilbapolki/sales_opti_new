@extends('layouts.master')

@section('title', 'CDI | Cust Ranking')

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
                    <h4 class="card-title"></h4>

                    <div class="row">
                        <div class="col-xs-12" id="hasil">
                            <div class="box box-hijau">
                                <div class="box-header">
                                    <i class="fa fa-signal"></i>
                                    <h3 class="box-title">Cust Rank Th.{{ $tahun[0]['now'] }}</h3>
                                    <input type="hidden" id="tahun" value="{{ $tahun[0]['now'] }}">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        @if ($tahun[0]['pre'] == '2012')
                                            <a class="btn btn-default btn-sm" role="button"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_cust_rank2', ['id' => $tahun[0]['pre']]) }}"
                                                role="button" title="{{ $tahun[0]['pre'] }}"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @endif

                                        @if ($tahun[0]['next'] == date('Y') + 1)
                                            <a class="btn btn-default btn-sm" role="button"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_cust_rank2', ['id' => $tahun[0]['next']]) }}"
                                                role="button" title="{{ $tahun[0]['next'] }}"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @endif
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body table-bordered no-padding">
                                    <div class="col-xs-12">
                                        <table id="custrank" class="display nowrap compact" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Cabang</th>
                                                    <th>Level</th>
                                                    <th>Titel</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
                                                    <th>Jml Nota</th>
                                                    <th>Total Belanja</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Cabang</th>
                                                    <th>Level</th>
                                                    <th>Titel</th>
                                                    <th>Nama</th>
                                                    <th>Alamat</th>
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

                </div>
            </div>
        </div>
        @include('panel.buttonhome')
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
        $(document).ready(function() {
            var tahun = document.getElementById("tahun").value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#custrank').DataTable({
                scrollY: "533px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                columnDefs: [{
                    width: '20%',
                    targets: 0
                }],
                fixedColumns: {
                    leftColumns: 1
                },
                // responsive: true,
                //         searching: false,
                //         paging: false,
                bInfo: false,
                //         bLengthChange: false,
                select: true,
                // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
                order: [
                    [6, 'desc']
                ],
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },

                ajax: {
                    url: '{{ route('tabel_show_custrank') }}',
                    data: {
                        tahun: tahun
                    },
                    method: 'POST'
                },
                columns: [{
                        data: 'cabang',
                        name: 'cabang'
                    },
                    {
                        data: 'ccc_level',
                        name: 'ccc_level'
                    },
                    {
                        data: 'titel',
                        name: 'titel'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'totalnota',
                        name: 'totalnota',
                        "sClass": "text-right"
                    },
                    {
                        data: 'totalbelanja',
                        name: 'totalbelanja',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    }
                ]
            });
        });
    </script>
@stop
