@extends('layouts.master')

@section('title', 'CDI | TargetPresensi')
@section('minititle', 'Target Presensi')

@section('css')
    @include('css.datatables.simple')
    @include('css.select2')
    <style>
        .none {
            display: none;
        }

        ,
        .showDIV {
            display: block;
        }

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
        @include('layouts.alerts')

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>

                    <div class="row">
                        <div class="col-sm-5 col-sm-push-7">
                            <div class="box box-hijau">
                                <div class="box-header with-border">
                                    <i class="fa fa-crosshairs"></i>
                                    <h3 class="box-title">Input Target {{ strtoupper(Auth::user()->kode_cabang) }}</h3>
                                </div>
                                <div class="box-body">
                                    <form role="form" method="POST" action="{{ route('addtarget') }}">
                                        {{ csrf_field() }}
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Sales *</label>
                                                <select name="sales" id="sales" class="form-control select2" required>
                                                    <option value="" selected>Pilih Sales</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Target Kunjungan *</label>
                                                <input type="text" class="form-control" id="kunjungan" name="kunjungan"
                                                    maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                    autocomplete="off" placeholder="harus diisi"
                                                    value="{{ old('kunjungan') }}" required>
                                                @if ($errors->has('kunjungan'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('kunjungan') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="3" placeholder=""></textarea>
                                            </div>
                                            <input name="periode" type="hidden" value="{{ $tahun[0]['now'] }}">
                                        </div>
                                        <br>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-outline-primary"
                                                id="tmbSales">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-7 col-sm-pull-5" id="hasil">
                            <div class="box box-hijau">
                                <div class="box-header">
                                    <h3 class="box-title">Target Visit bln {{ $tahun[0]['judul'] }}</h3>
                                    <input type="hidden" id="bulan" value="{{ $tahun[0]['now'] }}">
                                    <!-- tools box -->
                                    <div class="pull-right box-tools">
                                        @if ($tahun[0]['pre'] == '2012')
                                            <a class="btn btn-default btn-sm" role="button"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_target2', ['id' => $tahun[0]['pre']]) }}"
                                                role="button" title="{{ $tahun[0]['pre'] }}"><i
                                                    class="fa fa-chevron-left"></i></a>
                                        @endif

                                        @if ($tahun[0]['next'] == date('Y') + 1)
                                            <!-- <a class="btn btn-default btn-sm" role="button"><i class="fa fa-chevron-right"></i></a> -->
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_target2', ['id' => $tahun[0]['next']]) }}"
                                                role="button" title="{{ $tahun[0]['next'] }}"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @else
                                            <a class="btn btn-tumblr btn-sm"
                                                href="{{ route('page_target2', ['id' => $tahun[0]['next']]) }}"
                                                role="button" title="{{ $tahun[0]['next'] }}"><i
                                                    class="fa fa-chevron-right"></i></a>
                                        @endif
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <div class="box-body table-bordered no-padding">
                                    <div class="col-xs-12 table-responsive">
                                        <table id="custrank" class="display nowrap compact" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Nama</th>
                                                    <th>Target Visit</th>
                                                    <th>Ket.</th>
                                                    <th>Jml Visit</th>
                                                    <th>(%)</th>
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
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-default fade" id="modal_edit" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form class="form-horizontal" role="form" id="formedit">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Target Sales <label id="id_cccstatus"
                                                class="pull-right"></label>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="inputsm" class="col-sm-3 control-label">Nama</label>
                                            <div class="col-sm-9">
                                                <input name="editnama" id="editnama" class="form-control input-sm"
                                                    readonly>
                                                <input type="hidden" name="editid" id="editid"
                                                    class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputsm" class="col-sm-3 control-label">Target</label>
                                            <div class="col-sm-9">
                                                <input name="edittarget" id="edittarget" class="form-control input-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="btn_editsales">Save
                                            Change</button>
                                        <button type="button" class="btn btn-danger pull-left"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
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
            $('.targetpresensi').addClass('active');
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
                paging: false,
                columnDefs: [{
                    width: '20%',
                    targets: 1
                }],
                // fixedColumns:   {
                //     leftColumns: 2
                // },
                // responsive: true,
                searching: false,
                //         paging: false,
                bInfo: false,
                //         bLengthChange: false,
                select: true,
                // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
                order: [
                    [1, 'desc']
                ],
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },

                ajax: {
                    url: '{{ route('target_show') }}',
                    data: {
                        bulan: bulan
                    },
                    method: 'POST'
                },
                columns: [{
                        "targets": 0,
                        "width": "10%",
                        "data": null,
                        // className: "center",
                        "defaultContent": '<button class="btn btn-primary btn-xs edittarget" ><i class="fa fa-edit"></i> Edit</button>'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: '20%'
                    },
                    {
                        data: 'target_kunjungan',
                        name: 'target_kunjungan',
                        "sClass": "text-right",
                        width: '15%'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        "sClass": "text-right",
                        width: '20%'
                    },
                    {
                        data: 'jml_kunjungan',
                        name: 'jml_kunjungan',
                        "sClass": "text-right",
                        width: '20%'
                    },
                    {
                        data: 'prosentase',
                        name: 'prosentase',
                        "sClass": "text-right",
                        width: '15%'
                    },
                ]
            });

            table.on('click', '.edittarget', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                // alert(data.name +"'s salary is: "+ data.username);
                $('#modal_edit').modal('show');
                // $('#hapuscabang').html(data.kode_cabang);
                // $('#hapusnama').html(data.name);
                document.getElementById('editnama').value = data.name;
                document.getElementById('editid').value = data.id;
                document.getElementById('edittarget').value = data.target_kunjungan;
                document.getElementById('editket').value = data.keterangan;
            });

            $('#formedit').on('submit', function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('edittarget') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(data) {
                        if (data.error) {
                            swal.fire("Error!", data.error, "error");
                            toastr.error(data.error);
                            table.ajax.reload();
                        } else if (data.success) {
                            $('#formedit')[0].reset();
                            $('#modal_edit').modal('hide');
                            swal.fire("Success!", data.success, "success");
                            table.ajax.reload();
                        }
                    },
                })
            });


        });
    </script>
@stop
