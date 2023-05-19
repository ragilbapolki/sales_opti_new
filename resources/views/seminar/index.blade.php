@extends('layouts.master')

@section('title','CDI | Seminar')

@section('css')
    @include('css.datatables.simple')
    @include('css.select2')
    <style> 
      .none { display:none; }, 
      .showDIV { display:block; } 
      #radioBtn .notActive{
        color: #3276b1;
        background-color: #fff;
      }
      #lightgreen{
        color: #3276b1;
        background-color: #92CD00;
      }
      .box.box-hijau {
        border-top-color: #92CD00;
      }
      td.details-control {
        background: url('{{ URL::asset('dist/img/details_open.png') }}') no-repeat center center;
        cursor: pointer;
      }
      tr.shown td.details-control {
        background: url('{{ URL::asset('dist/img/details_close.png') }}') no-repeat center center;
      }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Seminar
        <small>CobraDental</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('home', 'cdi') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-6">
          <div class="box box-hijau" id="panelbox">
            <form class="form-horizontal" method="post" role="form" id="formIDe" action="{{ route('seminar.store') }}">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Customer</label>
                  <div class="col-sm-9" >
                    <select name="customer_id" id="customer_id" class="form-control select2" required>
                      <option value="">- Nama Customer -</option>
                    </select>
                  </div>
                </div>
                <div class="form-group {{$errors->first('ccc') ? 'has-error' : ''}}">
                  <label for="inputsm" class="col-sm-2 control-label">CCC</label>
                  <div class="col-sm-9" >
                    <input type="text" class="form-control" name="ccc" id="ccc" value="{{ old('ccc') }}" autocomplete="off" required readonly >
                    @if ($errors->has('ccc'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ccc') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Level</label>
                  <div class="col-sm-9" >
                    <input type="text" class="form-control" name="level" id="level" autocomplete="off" required readonly >
                    @if ($errors->has('level'))
                        <span class="help-block">
                            <strong>{{ $errors->first('level') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Tgl</label>
                  <div class="col-sm-9" >
                    {!! Form::date('tgl', null, ['class' => 'form-control', 'id' => 'tgl_penjualan','required']) !!}
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">NamaSeminar</label>
                  <div class="col-sm-9" >
                    <input type="text" class="form-control" name="seminar" id="seminar" autocomplete="off" required>
                    @if ($errors->has('seminar'))
                        <span class="help-block">
                            <strong>{{ $errors->first('seminar') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

              </div>
              <div class="box-footer" id="foter">
                <button type="submit" class="btn btn-xs btn-tumblr col-sm-3 col-sm-offset-4" name="cari" id="buttonIDe" onClick="">
                 Daftarkan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <div class="row">
        <div class="col-md-12">
          <div class="box box-danger">

            <div class="box-body pad table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tgl</th>
                          <th>NamaSeminar</th>
                          <th>CCC</th>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Hp</th>
                          <th>InputBy</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                    </table>
            </div>
            <!-- /.box -->
          </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.simple')
    @include('js.select2')
@stop

@section('page-script')

<script>
  $(document).ready(function () {
    $('.custaktivitas').addClass('active');
  });
</script>


<script type="text/javascript">
  $(function(){
   $('.select2').select2({
       minimumInputLength: 3,
       allowClear: true,
       placeholder: 'Tuliskan nama Customer',
       // width: '275px',
       width: '100%',
       ajax: {
          dataType: 'json',
          // url: 'daftarProvinsi.php',
          url: '{{ route('selectcustccc') }}',
          delay: 800,
          data: function(params) {
            return {
              search: params.term
            }
          },
          processResults: function (data, page) {
          return {
            results: data
          };
        },
      }
    }).on('select2:select', function (evt) {
                var datane = evt.params.data;
                console.log(datane.id);
  var form = $('#panelbox form');
  form.find('.help-block').remove();
  form.find('.form-group').removeClass('has-error');

                $("#ccc").val(datane.ccc);
                $("#level").val(datane.level);


        // $(".select2 option:selected").text();
       // var data = $(".select2 option:selected").id();
       // alert("Data yang dipilih adalah "+data);
    });
  });
</script>
  <script>
      $('#datatable').DataTable({
          responsive: true,
          processing: true,
          serverSide: true,
          select: true,
          info:false,
          searching:true,
          paging:false,
          order: [[ 1, 'desc' ]],
          // ajax: "{{ route('seminar.table') }}",
            ajax: {
              url: '{{ route('seminar.table') }}',
              method: 'post',
              data: {"_token": "{{ csrf_token() }}"},
            },

          
          columns: [
              {data: 'DT_Row_Index', name: 'id',"width": "5%"},
              {data: 'tgl', name: 'tgl'},
              {data: 'name', name: 'name'},
              {data: 'customer.ccc', name: 'customer.ccc'},
              {data: 'customer.name', name: 'customer.name'},
              {data: 'customer.alamat', name: 'customer.alamat'},
              {data: 'customer.telp', name: 'customer.telp'},
              // {data: 'user.name', name: 'user.name'},
              {data: "user", name:"user.name",render: function ( data, type, row ) {
                return  data.name+' - '+data.kode_cabang }},
              // {data: 'action', name: 'action',"width": "5%"}
          ]
      });
  </script>
@stop