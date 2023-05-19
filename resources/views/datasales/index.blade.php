@extends('layouts.master')

@section('title', 'CDI | List Sales')
@section('minititle', 'List Sales')

@section('css')
    @include('css.datatables.full')
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
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> </h4>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible">
                                    {{-- <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">&times;</button> --}}
                                    <h4><i class="icon fa fa-info"></i> Perhatian! </h4>
                                    * Jika Sales lupa Password, silahkan klik Edit untuk mengubah password.<br>
                                    * Apabila sales telah resign, maka user yg bersangkutan wajib dihapus.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 col-sm-push-7">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <i class="fa fa-user-plus"></i>
                                        <h3 class="box-title">Tambahkan Akun Baru
                                            {{ strtoupper(Auth::user()->kode_cabang) }}</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="form-horizontal" method="POST" action="{{ route('registersales') }}">
                                            {{ csrf_field() }}
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Nama*</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Nama" value="{{ old('name') }}"
                                                            onKeyUp="caps(this)" autocomplete="off" required autofocus>

                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Username*</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="username"
                                                            placeholder="Min 5 karakter" value="{{ old('username') }}"
                                                            onKeyUp="fusername(this)" autocomplete="off" required>
                                                        @if ($errors->has('username'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('username') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Jabatan*</label>
                                                    <div class="col-sm-8">
                                                        <select name="jabatan" id="jabatan" class="form-control select2"
                                                            required>
                                                            <option value="" selected>Pilih Jabatan</option>
                                                            @foreach ($jabatans as $jabatan)
                                                                <option value="{{ $jabatan->id }}">{{ $jabatan->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">New Password*</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="password"
                                                            placeholder="Min 5 karakter" onKeyUp="caps(this)"
                                                            autocomplete="off" required>
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password-confirm" class="col-sm-4 control-label">Retype
                                                        Password*</label>

                                                    <div class="col-sm-8">
                                                        <input id="password-confirm" type="password" class="form-control"
                                                            name="password_confirmation" onKeyUp="caps(this)" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">WA / Hp *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="hp"
                                                            name="hp" maxlength="13"
                                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                            autocomplete="off" placeholder="harus diisi"
                                                            value="{{ old('hp') }}" required="" pattern=".{10,13}">

                                                        @if ($errors->has('hp'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('hp') }}</strong>
                                                            </span>
                                                        @endif

                                                    </div>
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
                            </div>

                            <div class="col-sm-7 col-sm-pull-5">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <i class="fa fa-users"></i>
                                        <h3 class="box-title">Data Sales</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="datasales" class="display nowrap compact" cellspacing="0"
                                                    width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>action</th>
                                                            <th>Nama</th>
                                                            <th>Username</th>
                                                            <th>Jabatan</th>
                                                            <th>No HP</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>action</th>
                                                            <th>Nama</th>
                                                            <th>Username</th>
                                                            <th>Jabatan</th>
                                                            <th>No HP</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('datasales.partials.modal')

                        {{-- @include('panel.buttonhome') --}}

                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.full')
@stop

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.datasales').addClass('active');
        });
    </script>
    <script>
        caps = function(element) {
            element.value = element.value.toLowerCase();
        }
        fusername = function(element) {
            var val = element.value;
            var pattern = new RegExp('[ ]+', 'g');
            val = val.replace(pattern, '');
            element.value = val.toLowerCase();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.form-control').bind("cut copy paste", function(e) {
                e.preventDefault();
                alert("Maaf, Mohon isi data dengan diketik");
                $('#textbox_id').bind("contextmenu", function(e) {
                    e.preventDefault();
                });
            });
        });
    </script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('#datasales').DataTable({
                responsive: true,
                "scrollX": true,
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },
                "searching": false,
                "ordering": false,
                "paging": false,
                "bInfo": false,
                "bLengthChange": false,
                "bSortClasses": false,
                // processing: true,
                // serverSide: true,
                // ajax: '{!! route('SearchSales') !!}', 
                ajax: {
                    url: '{!! route('SearchSales') !!}',
                    method: 'POST'
                },

                columns: [{
                        "targets": 0,
                        "width": "15%",
                        "data": null,
                        // className: "center",
                        "defaultContent": '<button class="btn btn-warning btn-xs delsales" ><i class="fa fa-trash"></i> Hapus</button> <button class="btn btn-primary btn-xs editsales" ><i class="fa fa-edit"></i> Edit</button>'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'hp'
                    }
                ]
            });
            var table = $('#datasales').DataTable();
            table.on('click', '.delsales', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                // alert(data.name +"'s salary is: "+ data.username);
                $('#modal-hpssales').modal('show');
                $('#hapusid').html(data.id);
                $('#hapuscabang').html(data.kode_cabang);
                $('#hapusnama').html(data.name);
                document.getElementById('recid').value = data.id;
            });
            //buton editsales
            table.on('click', '.editsales', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                // alert(data.name +"'s salary is: "+ data.username);
                $('#modal-editsales').modal('show');
                $('#pesanerror').html('');
                // $('#hapuscabang').html(data.kode_cabang);
                // $('#hapusnama').html(data.name);
                document.getElementById('editnama').value = data.name;
                document.getElementById('editusername').value = data.username;
                document.getElementById('editjabatan').value = data.jabatan_id;
                document.getElementById('edithp').value = data.hp;
                document.getElementById('editpassword').value = '';
                document.getElementById('editpassword_confirmation').value = '';
            });

        });

        $("#hpsstoremanager").click(function() {
            var idsales = $('#hapusid').text();
            // var username = $('#hapusnama').text();
            // var recid = $('#recid').attr("value");
            // var token = document.getElementById("token").value;
            // var del= 'delSales'	;
            $.ajax({
                type: 'POST',
                url: 'sales/' + idsales,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": idsales,
                    "_method": "put"
                },
                cache: false,
                success: function() {
                    // alert('sukses');
                    // window.location.href = "{!! route('DataSales') !!}";
                    $('#modal-hpssales').modal('hide');
                    $('#datasales').DataTable().ajax.reload();
                }
            });
        });

        $('#btn_editsales').on('click', function(event) {
            var isvalidate = $("#formEditStatus")[0].checkValidity();
            if (isvalidate) {
                event.preventDefault();
                var username = $("#editusername").val();
                var jabatan = $("#editjabatan").val();
                var hp = $("#edithp").val();
                var password = $("#editpassword").val();
                var password_confirmation = $("#editpassword_confirmation").val();
                // console.log(editpassword);
                // var ketstatus = $( "#ketstatus" ).val();
                // var actionstatus= 'Edit Status : '+ketstatus ;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('editpasswordsales') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        username,
                        jabatan,
                        hp,
                        password,
                        password_confirmation
                    },
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        $('#modal-editsales').modal('hide');
                        // alert('Edit Password Berhasil');
                        $('#datasales').DataTable().ajax.reload();
                        $('#modal-berhasiledit').modal('show');
                    },
                    error: function(request, status, error) {
                        console.log(request.responseJSON.errors.password);
                        $('#pesanerror').html(request.responseJSON.errors.password);
                    }
                });
            }
        });
    </script>
@stop
