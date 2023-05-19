@extends('layouts.master')

@section('title','CDI | Plan PerTanggal')

@section('css')
    @include('css.datatables.simple')
<!-- <style>
  .btn-circle.btn-lg {
    position: fixed;
    width: 40px;
    height: 40px;
    background-color: rgb(53, 70, 92);
    color: #ffffff;
    padding: 9px 9px;
    font-size: 18px;
    line-height: 1.33;
    border-radius: 20px;
    bottom: 2em;
    right: 1em;
  }
  .btn-circle.btn-lg:hover {
    background-color: #3f679a;
    color: #ffff33;
  }
</style> -->
@stop

@section('content')
    <!-- Content Header (Page header) -->
<!--     <section class="content-header">
      <h1>
        {{$data['tglview']}}
        <small><input type="hidden" id="tgl" value="{{$data['tgl']}}"></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('page_plan') }}"><i class="fa fa-calendar"></i> Rencana Kunjungan</a></li>
        <li class="active">PlanPerTanggal</li>
      </ol>
    </section> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <h3>
            <a class="btn btn-tumblr btn-xs" href="{{route('plan_per_tgl', $data['prevday'])}}" role="button" title="{{ $data['prevday']}}"><i class="fa fa-chevron-left"></i></a>
            {{$data['tglview']}} 
            <a class="btn btn-tumblr btn-xs" href="{{route('plan_per_tgl', $data['nextday'])}}" role="button" title="{{ $data['nextday']}}"><i class="fa fa-chevron-right"></i></a>
          </h3>
          <small><input type="hidden" id="tgl" value="{{$data['tgl']}}"></small>
              
              
        </div>
        <div class="col-md-12">
          <div class="box box-info">
          <div class="box-header">
            <!-- tools box --> 

            <!-- /. tools -->
          </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="dataplan" class="display cell-border compact" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Action</th>
                          <th>Jam</th>
                          <th>Sales</th>
                          <th>Customer</th>
                          <th>Alamat</th>
                          <th>Tujuan</th>
                          <th>Hasil</th>
                          <th>DurasiVisit</th>
                          <th>Lokasi</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Action</th>
                          <th>Jam</th>
                          <th>Sales</th>
                          <th>Customer</th>
                          <th>Alamat</th>
                          <th>Tujuan</th>
                          <th>Hasil</th>
                          <th>DurasiVisit</th>
                          <th>Lokasi</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      @include('planadmin.partials.modalpending')
      @include('panel.buttonbackplan')
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop


@section('page-script')
<script>
  $(document).ready(function(){
    var tgl = $("#tgl").val();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var table = $('#dataplan').DataTable({
      processing: true,
      serverSide: true,
      scrollX: true,
      paging: false,
      bInfo : false,
      bLengthChange: false,
      order: [[ 1, 'asc' ]],
      ajax: {
        url: '{{ route('plan_per_tgl_show') }}/'+tgl,
          error : function (xhr) {
              var res = xhr.responseJSON;
              console.log(res);
          }
      },
      columns: [
        { data: 'action',name:'action'},
        { data: 'jam', name: 'jam',render: function ( data, type, row ) {return data == null ? '' : data } },
        { data: 'sales',name:'sales'},
        { data: 'name',name:'name'},
        { data: 'alamat',name:'alamat'},
        { data: 'tujuan',name:'tujuan'},
        { data: 'hasil', name: 'hasil',render: function ( data, type, row ) {return data == null ? row.tolak : data } },
        { data: null,render: function ( data, type, row ) {
                  // return data == 1 ? '<button class="btn bg-green btn-xs delsales" ><i class="fa fa-play"></i>  </button>' : '' 
                  if (data == null) {
                    var durasi = '';
                  } else{
                    var datang = data.created_at;
                    var pulang = data.updated_at;
                    if(pulang == null){
                     return '';
                   }else{
                    var date1 = new Date(datang);
                    var date2 = new Date(pulang);
                    var diff = date2.getTime() - date1.getTime();
                    var msec = diff;
                    var hh = Math.floor(msec / 1000 / 60 / 60);
                    msec -= hh * 1000 * 60 * 60;
                    var mm = Math.floor(msec / 1000 / 60);
                    msec -= mm * 1000 * 60;
                    var ss = Math.floor(msec / 1000);
                    msec -= ss * 1000;
                  }
                }
                return data == null ? '' : hh + ":" + mm + ":" + ss
              },"sClass": "text-right","searchable": false, "orderable": false,
            },
        { data: 'jam', name: 'jam',render: function ( data, type, row ) {return data == null ? '' : '<a href="../lokasi/'+row.id+'" target="_blank">Lokasi</a>' } },
      ]
    });
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
          success: function (response) {
              $('#modal-body').html(response);
          }
      });
      $('#modal').modal('show');
  });

  $('#modal-btn-save').click(function (event) {
      event.preventDefault();
      var form = $('#modal-body form'),
          url = form.attr('action'),
          method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';


      form.find('.help-block').remove();
      form.find('.form-group').removeClass('has-error');

      $.ajax({
          url : url,
          method: method,
          data : form.serialize(),
          success: function (response) {
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
          error : function (xhr) {
              var res = xhr.responseJSON;
              console.log(res);
              if ($.isEmptyObject(res) == false) {
                  $.each(res.errors, function (key, value) {
                      $('#' + key)
                          .closest('.form-group')
                          .addClass('has-error')
                          .append('<span class="help-block"><strong>' + value + '</strong></span>');
                  });
              }
          }
      })
  });
</script>
@stop