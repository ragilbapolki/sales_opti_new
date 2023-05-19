@extends('layouts.master')

@section('title', 'CDI | Materi Produk')
@section('minititle', 'Materi Produk')

@section('css')
    @include('css.datatables.simple')
@stop

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> </h4>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="itemstok" class="display nowrap cell-border compact" cellspacing="0"
                                                width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Brand</th>
                                                        <th>Judul</th>
                                                        <th>LinkURL</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Brand</th>
                                                        <th>Judul</th>
                                                        <th>LinkURL</th>
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
        </div>

        {{-- @include('panel.buttonhome') --}}
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop

@section('page-script')

    <script>
        $(document).ready(function() {
            $('.materi').addClass('active');
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#itemstok').DataTable({
                scrollY: "533px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                // processing: true,
                // serverSide: true,
                columnDefs: [{
                        width: '10%',
                        targets: 0
                    },
                    {
                        width: '10%',
                        targets: 1
                    },
                ],
                // fixedColumns:   {
                //     leftColumns: 1
                // },
                responsive: true,
                //         searching: false,
                //         paging: false,
                bInfo: false,
                //         bLengthChange: false,
                select: true,
                // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
                order: [
                    [1, 'asc']
                ],
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },

                ajax: {
                    url: '{{ route('data_materiproduk') }}',
                    method: 'POST'
                },
                columns: [{
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: "linkurl",
                        name: "linkurl",
                        render: function(data, type, row) {
                            return data == null ? '' : '<a href="' + data +
                                '" target="_blank">URL</a>'
                        }
                    }
                ]
            });
        });
    </script>



@stop
