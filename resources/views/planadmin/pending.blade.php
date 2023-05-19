@extends('layouts.master')

@section('title', 'CDI | Menunggu Persetujuan')
@section('minititle', 'Menunggu Persetujuan')

@section('css')
    @include('css.datatables.simple')
@stop

@section('content')
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
        <h1>
            Pending Plan
            <small>CDI</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('page_plan') }}"><i class="fa fa-calendar"></i> Rencana Kunjungan</a></li>
            <li class="active">Pending Plan</li>
        </ol>
    </section> --}}

    {{-- <section class="content"> --}}

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Kunjungan</h4>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="row"> --}}
                {{-- <div class="col-sm-12"> --}}
                <table id="dataplan" class="display nowrap compact" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Tgl Kunjungan</th>
                            <th>Sales</th>
                            <th>Customer</th>
                            <th>Alamat</th>
                            <th>Tujuan Kunjungan</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>Tgl Kunjungan</th>
                            <th>Sales</th>
                            <th>Customer</th>
                            <th>Alamat</th>
                            <th>Tujuan Kunjungan</th>
                        </tr>
                    </tfoot>
                </table>
                {{-- </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                {{-- </div> --}}

            </div>
        </div>
    </div>
    {{-- @include('panel.buttonbackplan')
    </section> --}}

@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop

@section('page-script')
    <script>
        $(document).ready(function() {

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
                // select:true, 
                order: [
                    [3, 'asc']
                ],
                ajax: {
                    url: '{{ route('plan_pendingshow') }}',
                    method: 'POST'
                },
                columns: [{
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'tgl',
                        name: 'tgl'
                    },
                    {
                        data: 'sales',
                        name: 'sales'
                    },
                    {
                        data: 'name',
                        name: 'customer'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    }
                ]
            });
            $('body').on('click', '.modal-show', function(event) {
                event.preventDefault();
                var me = $(this),
                    url = me.attr('href'),
                    sales = me.data('sales');
                btn = me.data('btn');
                $('#modal-title').text(sales);
                $('#modal-btn-save').text(btn);
                $.ajax({
                    url: url,
                    dataType: 'html',
                    success: function(response) {
                        $('#modal-body').html(response);
                    }
                });
                $('#modal').modal('show');
            });

            $('#modal-btn-save').click(function(event) {
                event.preventDefault();
                var form = $('#modal-body form'),
                    url = form.attr('action'),
                    method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';


                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');

                $.ajax({
                    url: url,
                    method: method,
                    data: form.serialize(),
                    success: function(response) {
                        // console.log(response);
                        form.trigger('reset');
                        $('#modal').modal('hide');
                        // location.reload()
                        $('#dataplan').DataTable().ajax.reload();

                        // swal({
                        //     type : 'success',
                        //     title : 'Success!',
                        //     text : 'Data has been saved!'
                        // });
                    },
                    error: function(xhr) {
                        var res = xhr.responseJSON;
                        console.log(res);
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function(key, value) {
                                $('#' + key)
                                    .closest('.form-group')
                                    .addClass('has-error')
                                    .append('<span class="help-block"><strong>' +
                                        value + '</strong></span>');
                            });
                        }
                    }
                })
            });

        });
    </script>
@stop
