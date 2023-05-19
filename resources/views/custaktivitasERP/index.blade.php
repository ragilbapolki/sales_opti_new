@extends('layouts.master')

@section('title','CDI | Cust Aktivitas')

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
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-6">
          <div class="box box-hijau" id="panelbox">
            <form class="form-horizontal" method="post" role="form" id="formIDe">
              <div class="box-body" >
                <div class="form-group">
                  <label for="inputsm" class="col-sm-2 control-label">Customer</label>
                  <div class="col-sm-9" >
                    <select name="customer" id="customer" class="form-control select2" required>
                      <option value="">- Nama Customer -</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer" id="foter">
                <button type="submit" class="btn btn-xs btn-tumblr col-sm-3 col-sm-offset-4" name="cari" id="buttonIDe" onClick="">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="box box-hijau" id="datacustomer">
              <div class="box-header with-border">
                <h3 class="box-title">Data Customer</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>

              <div class="box-body">
                <div class="col-sm-12">
                  <p><b>Name : </b> <span id="header_nama"></span></p>
                  <p><b>Address : </b> <span id="header_alamat"></span></p>
                  <p><b>UlangTahun : </b> <span id="headerTglLahir"></span></p>
<!--                   <p><b>Dikunjungi oleh : </b> <span id="header_sales"></span></p>
                  <p><b>Hasil Pertemuan : </b> <span id="header_keterangan"></span></p> -->
                </div>
              </div>
          </div>
        </div>
      </div>

      <div id="modal-loader" style="display: none; text-align: center;">
        Harap Bersabar,sedang diproses... kurang lebih 3menit.
      </div>

      <div class="row">
          <div class="col-xs-12 none" id="hasilKunjungan">
            <div class="box box-hijau">
              <div class="box-header with-border">
                <h3 class="box-title">Data Kunjungan</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive no-padding">
                <div class="col-xs-12">
                      <table id="datakunjungan" class="display nowrap compact" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Tanggal</th>
                            <th>Hasil</th>
                          </tr>
                        </thead>

                      </table>
                </div>
              </div>
              <div class="box-footer">
              </div>
            </div>
          </div>
      </div>

      <div class="row">
          <div class="col-xs-12 none" id="hasil">
            <div class="box box-hijau">
              <div class="box-header with-border">
                <h3 class="box-title">Data Transaksi</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>

              <div class="box-body table-responsive no-padding">
                <div class="col-xs-12">
                      <table id="dataplan" class="display nowrap compact" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Detail</th>
                            <th>Tanggal</th>
                            <th>Nota</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Detail</th>
                            <th>Tanggal</th>
                            <th>Nota</th>
                            <th>Total</th>
                          </tr>
                        </tfoot>
                      </table>
                </div>
              </div>
              <div class="box-footer">
              </div>
            </div>
          </div>
      </div>

      @include('panel.buttonhome')
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
          url: "{{ route('selectcust_erp') }}",
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
        $(".select2 option:selected").text();
       // var data = $(".select2 option:selected").text();
       // alert("Data yang dipilih adalah "+data);
    });
  });
</script>

<!-- tabel hasil pencarian -->
<script>
  /* Formatting function for row details - modify as you need */
  function format ( d ) {
      var nota = d;
      var detailnota=nota.detail;
      // console.log(nota.detail);
      var nama = "";
      var qty = "";
      for (var i = 0; i < detailnota.length; i++){
        var obj = detailnota[i];
        // console.log(obj.id);
        nama += obj.nama_product+ "<br>";
        qty += obj.qty_product+ "<br>";
      }

      var jajal ='<table border=1>'+
                      '<tr>'+
                      '<td><b>Nama</b></td><td><b>Qty</b></td>'+
                      '</tr>'+
                      '<tr>'+
                      '<td>'+nama+'</td><td>'+qty+'</td>'+
                      '</tr>'+
                  '</table>' ;
      return jajal;
  }

  $(document).ready(function(){
    $('#buttonIDe').on('click', function(event) {
      var isvalidate = $("#formIDe")[0].checkValidity();
      if (isvalidate) {
        event.preventDefault();
        var idcust = $('.form-horizontal').serialize();
        $('#modal-loader').show();
        $("#hasilKunjungan").addClass("none");
        $("#hasil").addClass("none");
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: 'post',
          url: "{{ route('search_cust_aktivitas_erp') }}",
          data: idcust,
          cache:false,
          success: function(response) {
            var data = response.data;
            $('#modal-loader').hide();
            $("#hasilKunjungan").removeClass("none");
            $("#hasil").removeClass("none");

              var idcust=data.customer.id_member;
              var visit=data.plan;
              document.getElementById("header_nama").innerHTML = data.customer.nama_member;
              document.getElementById("header_alamat").innerHTML = data.customer.alamat_detail;
              document.getElementById("headerTglLahir").innerHTML = data.customer.tgl_lahir;
              showTable(visit);
              showTableTransaksi(idcust);
              /// Table Histori Kunjungan
              function showTable(a) {
                  $('#datakunjungan').DataTable( {
                    "language": {
                      "emptyTable": "Belum Pernah Dikunjungi"
                    },
                    "bDestroy": true,
                    searching: false,
                    paging: false,
                    bInfo : false,
                    order: [[ 0, 'desc' ]],
                    "aaData": a,
                    columnDefs: [
                      { targets: 0, type: 'date',format:'DD-MM-YYYY'}
                    ],
                    "aoColumns": [
                    { "mDataProp": "tgl","width": "3%",'type' :'date','format':'MM-DD-YYYY' },
                    { "mDataProp": "keterangan" },
                    ]
                  } );
              }
              /// Table Histori Transaksi
              function showTableTransaksi(a) {

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
                  searching: false,
                  // paging: false,
                  bInfo : false,
                  bLengthChange: false,
                  bSortable: false,
                  // scrollX: true,
                  destroy: true,
                  cache:false,
                  select:true, 
                  // order: [[ 0, 'desc' ]],
                  pageLength: 20,
                  ajax: {
                    type: 'POST',
                    url: "{!! route('tabel_show_aktivitas_erp') !!}",
                    data: {'idcust':a},
                  },
                      columnDefs: [
                        { "width": "3%", "targets": 0 },
                        { 'type' :'date',format:'MM-DD-YYYY', "targets": 0 }
                      ],
                      columns: [
                          {
                              "className":      'details-control',
                              "orderable":      false,
                              "data":           null,
                              "defaultContent": ''
                          },
                          { data: 'tgl'},
                          { data: 'nota',name:'keterangan'},
                          { data: 'total', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
                      ]
                });
                // Add event listener for opening and closing details
                $('#dataplan tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row( tr );
             
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( format(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } );
              } 
          }
        });
      }
    });
  });
</script>

@stop