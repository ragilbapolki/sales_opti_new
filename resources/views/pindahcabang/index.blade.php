@extends('layouts.master')

@section('title','CDI | Pindah Cabang')

@section('css')
    @include('css.datatables.full')
    @include('css.select2')
    <style>
    .dataTables_filter, .dataTables_info { display: none; }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customer
        <small>cobra dental</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Edit</a></li>
        <li class="active">Customer</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-info"></i> Note!</h4>
             * Jika Terdapat data Cust yg double(Nama & Alamat), dimohon untuk memakai data yang transaksi terakhirnya paling baru. kemudian Customer lainnya dihapus cabang agar tidak dipilih sales saat membuat plan .
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="datacust" class="display nowrap compact" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Tool</th>
                          <th>ID</th>
                          <th>Cabang</th>
                          <th>Nama</th>
                          <th>Titel</th>
                          <th>Alamat</th>
                          <th>Kota</th>
                          <th>transaksiTerakhir</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th></th>
                          <th>ID</th>
                          <th>Cabang</th>
                          <th>Nama</th>
                          <th></th>
                          <th>Alamat</th>
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
      @include('pindahcabang.partials.modal')
      @include('panel.buttonhome')
    </section>
@endsection

@section('javascript')
    @include('js.datatables.full')
    @include('js.select2')
@stop


@section('page-script')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#tocabang').select2();
      // $("#tocabang").on('select2:open', function (e) {
      //   $('.select2-search input').prop('focus',false);
      // });
    });
  </script>

<script>
$(document).ready(function(){ 
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Setup - add a text input to each footer cell
    $('#datacust tfoot th').each( function () {
      var title = $(this).text();
      if (title=='ID') {
        $(this).html( '<input type="text" placeholder="Filter ID" style="color: #aa001e;" />' );
      }else if(title=='Cabang'){
        $(this).html('<input type="text" placeholder="Filter Cabang" style="color: #aa001e; width:77px;">');
      }else if(title=='Nama'){
        $(this).html('<input type="text" placeholder="Filter Nama" style="color: #aa001e;">');
      }else if(title=='Alamat'){
        $(this).html('<input type="text" placeholder="Filter Alamat" style="color: #aa001e; width:177px;">');
      }
    } );


    var table = $('#datacust').DataTable({
      dom: 'Bfrtip',
      buttons: ['pageLength',
      {
        extend: 'excelHtml5',
        exportOptions: { orthogonal: 'export',columns: [ 1,2,3,4,5,6,7] },
        title: 'Data Customer'
      },
      // {
      //   extend: 'colvis',text: 'Sembunyikan Kolom',
      //   columnText: function ( dt, idx, title ) {
      //     return (idx+1)+': '+title;
      //   }
      // } 
            //'print'
            ],
      "language": {
        "emptyTable": "Data tidak ditemukan"
      },
      scrollX: true,
      destroy: true,
      cache:false,
      destroy: true,
      // searching: false,
      processing: true,
      serverSide: true,
      responsive: true,
      // bFilter: false,
      // paging: false,
      // bInfo : false,
      // bLengthChange: false,
      select:true, 
      // lengthMenu: [[17, 27, 99, 3000], [17, 27, 99, 3000]],
      lengthMenu: [[10, 50, 999], [10, 50, 999]],
      // fixedColumns:   {   leftColumns: 1  },
      order: [[ 1, 'asc' ]],
      ajax: {
        url: '{{ route('data_customer') }}',
        method: 'POST'
      },
      columns: [
      {
        "targets": -1,
        "data": null,
        "defaultContent": "<button class='btn bg-green btn-xs editstatus' ><i class='fa fa-edit'></i> Edit </button>",
      },
      { data: 'id',name:'id'},
      { data: 'update_cabang',name:'update_cabang'},
      { data: 'name',name:'name'},
      { data: 'titel',name:'titel'},
      { data: 'alamat',name:'alamat'},
      { data: 'kota',name:'kota'},
      { data: 'last_transaksi',name:'last_transaksi'}
      ]
    });

    //Filter event handler
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    ///// edit Status Member
    table.on('click', '.editstatus', function() {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      var status = data['ccc_aktif'];
      $('#modal-editstatus').modal('show');
      $("#tocabang").val("").trigger("change.select2");
      $("#nama").attr('readonly', 'readonly');
      document.getElementById('nama').value =data['name'];
      document.getElementById('alamat').value =data['alamat'];
      document.getElementById('kota').value =data['kota'];
      document.getElementById('cabangnow').value =data['update_cabang'];
      document.getElementById('regulerid').value =data['id'];
    });

  });
</script>

<script>
  $(document).ready(function(){
    $("#tmbSuplier").click(function(event){
      var isvalidate = $('.form-horizontal')[0].checkValidity();
      if (isvalidate) {
        event.preventDefault();
        kirim();
      }
    });
  });

  function kirim(){
    var data = $('.form-horizontal').serialize();
    $('#modal-editstatus').modal('hide');
    $.ajax({
      type: 'POST',
      url: '{{ route('updatecabang') }}',
      data: data,
      cache:false,
      success: function(response) {
        // var response = JSON.parse(data);
        // var response = data;
        // console.log(data.status);
        if(response.status == 'success'){
          $(".form-horizontal").trigger('reset');
          $('#modal-editstatus').modal('hide');
          $('#datacust').DataTable().ajax.reload();
          // tblsuplier();
        }
      }
    });
  };
</script>
@stop