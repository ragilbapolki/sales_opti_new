@extends('layouts.master')

@section('title','CDI | TargetPresensiArea')

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
    </style>
@stop

@section('content')
  <section class="content">
    @include('layouts.alerts')
<!--     <div class="row"> -->
<!--       <div class="col-sm-5 col-sm-push-7">
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
                        @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Target Kunjungan *</label>
                        <input type="text" class="form-control" id="kunjungan" name="kunjungan" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off" placeholder="harus diisi" value="{{ old('kunjungan') }}" required>
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
                    <input name="periode" type="hidden" value="{{ $tahun[0]['now']}}">
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="col-sm-3 col-sm-offset-5 btn btn-tumblr" id="tmbSales" >Simpan</button> 
                  </div>
              </form>
            </div>
          </div>
      </div> -->
    <div class="row">
      <div class="col-sm-9" id="hasil">
        <div class="box box-hijau">
          <div class="box-header">
            <h3 class="box-title">Target Visit bln {{ $tahun[0]['judul']}}</h3>
            <input type="hidden" name="bulan" id="bulan" value="{{ $tahun[0]['now']}}">
            <!-- tools box -->
            <div class="pull-right box-tools">
                @if($tahun[0]['pre']=='2012')
                 <a class="btn btn-default btn-sm" role="button"><i class="fa fa-chevron-left"></i></a>
                @else
                  <a class="btn btn-tumblr btn-sm" href="{{route('page_target2area', ['id' => $tahun[0]['pre']])}}" role="button" title="{{ $tahun[0]['pre']}}"><i class="fa fa-chevron-left"></i></a>
                @endif

                @if($tahun[0]['next']==date("Y")+1)
                  <!-- <a class="btn btn-default btn-sm" role="button"><i class="fa fa-chevron-right"></i></a> -->
                  <a class="btn btn-tumblr btn-sm" href="{{route('page_target2area', ['id' => $tahun[0]['next']])}}" role="button" title="{{ $tahun[0]['next']}}"><i class="fa fa-chevron-right"></i></a>
                @else
                  <a class="btn btn-tumblr btn-sm" href="{{route('page_target2area', ['id' => $tahun[0]['next']])}}" role="button" title="{{ $tahun[0]['next']}}"><i class="fa fa-chevron-right"></i></a>
                @endif
            </div>
            <!-- /. tools -->
          </div>
          <div class="box-body table-bordered no-padding">
              <div class="col-xs-12">
                    <table id="custrank" class="display compact nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
<!--                           <th>No.</th> -->
                          <th>Nama</th>
                          <th>Kode Cabang</th>
                          <th>Target Visit</th>
                          <th>Jml Visit</th>
                          <th>%</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
<!--                           <th></th> -->
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
      <div class="col-sm-3">
        <div class="box box-hijau">
          <div class="box-header">
            <h3 class="box-title">Filter Bulan</h3>
          </div>
          <div class="box-body">
            <div class="form-group">
                <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control pull-right bulanfilter" name="bulanfilter" id="bulanfilter"/>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
          <div class="form-group" align="right">
            <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
            <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
          </div>                                            
          </div>          
        </div>
      </div>              
  </div>      

<!--     </div> -->
    @include('panel.buttonhome')
  </section>
@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop

@section('page-script')

<script>
  $(document).ready(function () {
    $('.targetpresensi').addClass('active');
  });
</script>

<script>
$(document).ready(function(){
    var bulan = document.getElementById("bulan").value;
    var bulanfilter = document.getElementById("bulanfilter").value; 
       
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

  function tbltarget(bulan, bulanfilter) {    

    var table = $('#custrank').DataTable({
        scrollY:        true,
        scrollX:        true,
        scrollCollapse: true,
      	destroy: true,        
        paging:         false,
        columnDefs: [{ 
          width: '20%', targets: 0,
          width: '20%', targets: 1,
          width: '15%', targets: 2,
          width: '15%', targets: 3,
          width: '10%', targets: 4, 
          width: '20%', targets: 5,                                       
          }],
        fixedColumns:   {
            leftColumns: 1
        },
      // responsive: true,
              searching: false,
      //         paging: false,
              bInfo : false,
      //         bLengthChange: false,
              select:true,
      // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
      order: [[1, 'desc']],
      "language": {
        "emptyTable": "Data tidak ditemukan"
      },

      ajax: {
        url: '{{ route('target_showarea') }}',
        data:{ bulan:bulan
          ,bulanfilter:bulanfilter 
        },
        method: 'POST'
      },
      columns: [
      // { data: 'DT_RowIndex', name:'DT_RowIndex', width:'10%' },
      { data: 'name',name:'name'},
      { data: 'kode_cabang', name:'kode_cabang'},
      { data: 'target_kunjungan',name:'target_kunjungan',"sClass": "text-center"},
      { data: 'jml_kunjungan',name:'jml_kunjungan',"sClass": "text-right"},
      { data: 'prosentase',name:'prosentase',"sClass": "text-right"},
      { data: 'keterangan',name:'keterangan'},
      ]
    });
} //function

    $('#filter').click(function(){
        var bulanfilter = $('#bulanfilter').val();
        var bulan = $('#bulan').val();

        if(bulanfilter != '')
        {
            tbltarget(bulan,bulanfilter);
            bulan = $('#bulan').val('');
        }
        else
        {
            swal.fire("Error!", 'bulan tidak boleh kosong !', "error");          
        }
    });

    $('#reset').click(function(){
		var now = new Date();
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month) ;

		$('#bulan').val(today);
        $('#bulanfilter').val('');
        // $('#custrank').DataTable().destroy();
        tbltarget(bulan, bulanfilter='');
    });

    tbltarget(bulan, bulanfilter='');

  });
</script>

<script type="text/javascript">

$("#bulanfilter").datepicker({
    format: "yyyy-mm",
    viewMode: "months", 
    minViewMode: "months"
});  

</script>
@stop