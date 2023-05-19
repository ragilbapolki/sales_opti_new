@extends('layouts.master')

@section('title','CDI | LOG')

@section('css')
    @include('css.datatables.simple')
    <style>
    .dataTables_info { display: none; }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Logs
        <small>SalesApp</small>
      </h1>

    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
              <div class="box-body">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="datacust" class="display nowrap compact" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Cabang</th>
                          <th>Aktivitas</th>
                          <th>Device</th>
                          <th>IP</th>
                          <th>Time</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Cabang</th>
                          <th>Aktivitas</th>
                          <th>Device</th>
                          <th>IP</th>
                          <th>Time</th>
                        </tr>
                      </tfoot>
                    </table>
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
  $(function tblccc() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Setup - add a text input to each footer cell
    $('#datacust tfoot th').each( function () {
      var title = $(this).text();
      if (title=='Nama') {
        $(this).html( '<input type="text" placeholder="Filter Nama" style="color: #aa001e;" />' );
      }else if(title=='Cabang'){
        $(this).html('<input type="text" placeholder="cabang" style="color: #aa001e;">');
      }else if(title=='Aktivitas'){
        $(this).html('<input type="text" placeholder="Aktivitas" style="color: #aa001e; width:77px;">');
      }
    } );


    var table = $('#datacust').DataTable({
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
      lengthMenu: [[10, 50, 99], [10, 50, 99]],
      fixedColumns:   {   leftColumns: 1  },
      columnDefs: [ { "searchable": false, "orderable": false, "targets": 0 } ],
      order: [[ 6, 'desc' ]],
      ajax: {
        url: '{{ route('super_data_logs') }}',
        method: 'POST'
      },
      columns: [
      { data: 'id', width: '1px'},
      { data: 'user.name',name:'user.name'},
      { data: 'kode_cabang',name:'kode_cabang'},
      { data: 'aktivitas',name:'aktivitas'},
      { data: 'device',name:'device'},
      { data: 'ip',name:'ip'},
      { data: 'created_at',name:'created_at'}
      ]
    });
    /// untuk nomor urut
    table.on( 'draw.dt', function () {
       var info = table.page.info();
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1+info.start;
        } );
    } ).draw();
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


  });
</script>

@stop