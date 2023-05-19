@extends('layouts.master')

@section('title','CDI | His Visit')

@section('css')
    @include('css.datatables.full')
    <style>
        .dataTables_filter { display: none; }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History Visit
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
                          <th>Status</th>
                          <th>Tgl Visit</th>
                          <th>Customer</th>
                          <th>Alamat</th>
                          <th>Tujuan</th>
                          <th>Hasil</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th></th>
                          <th></th>
                          <th>Tgl Visit</th>
                          <th>Customer</th>
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
      </div>
      @include('panel.buttonhome')
    </section>
@endsection

@section('javascript')
    @include('js.datatables.full')
@stop


@section('page-script')
<script>
  $(document).ready(function () {
    $('.hisvisit').addClass('active');
  });
</script>

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
            if (title=='Tgl Visit') {
                $(this).html( '<input type="text" placeholder="Filter Tgl" style="color: #aa001e; width:100px;" />' );
            }else if(title=='Customer'){
                $(this).html('<input type="text" placeholder="Filter Cust" style="color: #aa001e; width:121px;" />');
            }
        } );

    var table = $('#datacust').DataTable({

      "language": {
        "emptyTable": "Data tidak ditemukan"
      },
          dom: 'Bfrtip',
              buttons: [ 'pageLength',
              {
                extend: 'colvis',text: 'Sembunyikan Kolom',
                columnText: function ( dt, idx, title ) {
                  return (idx+1)+': '+title;
                }
              } ],

      scrollX: true,
      destroy: true,
      cache:false,
      destroy: true,
      processing: true,
      serverSide: true,
      // responsive: true,
      select:true, 
      lengthMenu: [[10, 50, 333], [10, 50, 333]],
      // fixedColumns:   {   leftColumns: 1  },
						columnDefs: [ { "searchable": false, "orderable": false, "targets": 0 } ],
      order: [[ 2, 'desc' ]],
      ajax: {
        url: '{{ route('sales_data_visit') }}',
        method: 'POST'
      },
      columns: [
      { data: 'id', width: '1px'},
      { data: 'status', name: 'status',render: function ( data, type, row ) {return data == 3 ? 'Selesai' : 'Ditolak' } },
      { data: 'tgl',name:'tgl'},
      { data: 'name',name:'name'},
      { data: 'alamat',name:'alamat'},
      { data: 'keterangan',name:'keterangan', width: '50px'},
      { data: 'hasil',name:'hasil', width: '50px'},
      // { data: 'cekout', name: 'cekout',render: function ( data, type, row ) {return data == null ? '' : data.keterangan } },
      ]
    });
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