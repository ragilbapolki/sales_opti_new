@extends('layouts.master')

@section('title', 'CDI | Presensi')
<style>
    hr.divider {
        margin: 0em;
        border-width: 1px;
        padding: 3px;
    }
</style>
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

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> </h4>

                    @include('layouts.alerts')
                    <div class="row">
                        <div class="col-sm-12" id="hasil">
                            <div class="box box-hijau">
                                <div class="box-header">
                                    <h3 class="box-title">Presensi {{ $tahun[0]['judul'] }}</h3>
                                    <input type="hidden" id="bulan" value="{{ $tahun[0]['now'] }}">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        @if ($tahun[0]['pre'] == '2012')
                                            <a class="btn btn-default btn-sm" role="button"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_presensi2', ['id' => $tahun[0]['pre']]) }}"
                                                role="button" title="{{ $tahun[0]['pre'] }}"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @endif

                                        @if ($tahun[0]['next'] == date('Y') + 1)
                                            <!-- <a class="btn btn-default btn-sm" role="button"><i class="fa fa-chevron-right"></i></a> -->
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_presensi2', ['id' => $tahun[0]['next']]) }}"
                                                role="button" title="{{ $tahun[0]['next'] }}"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_presensi2', ['id' => $tahun[0]['next']]) }}"
                                                role="button" title="{{ $tahun[0]['next'] }}"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @endif
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body table-bordered no-padding">
                                    <div class="col-xs-12">
                                        <table id="custrank" class="display nowrap cell-border compact" cellspacing="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <td>Target Visit</td>
                                                    <td>Jml Visit</td>
                                                    <td>Pencapaian</td>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
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
            $('.presensi').addClass('active');
        });
    </script>

    <script>
        $(document).ready(function() {
            var bulan = document.getElementById("bulan").value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#custrank').DataTable({
                scrollY: "533px",
                scrollX: true,
                scrollCollapse: true,
                // columnDefs: [
                //     { width: '20%', targets: 0 }
                // ],
                // fixedColumns:   {
                //     leftColumns: 1
                // },
                // responsive: true,
                searching: false,
                paging: false,
                bInfo: false,
                ordering: false,
                // bLengthChange: false,
                // select:true,
                // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
                // order: [[1, 'desc']],
                "language": {
                    "emptyTable": "Target Blm DiTentukan"
                },

                ajax: {
                    url: '{{ route('presensi_show') }}',
                    data: {
                        bulan: bulan
                    },
                    method: 'POST'
                },
                columns: [{
                        data: 'target_kunjungan',
                        name: 'target_kunjungan',
                        "sClass": "text-right"
                    },
                    {
                        data: 'jml_kunjungan',
                        name: 'jml_kunjungan',
                        "sClass": "text-right"
                    },
                    {
                        data: 'prosentase',
                        name: 'prosentase',
                        "sClass": "text-right"
                    },
                ]
            });
        });
    </script>
@stop
