@extends('layouts.master')

@section('title','CDI | StokBarang')

@section('css')
  @include('css.datatables.simple')
  <style>
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
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-xs-12" id="hasil">
            <div class="box box-hijau">
              <div class="box-header with-border">
                <h3 class="box-title">Stok Barang {{$tgl}}</h3>
              </div>
              @include('itemstok.partials.resultitemstok')
            </div>
          </div>
      </div>

      @include('panel.buttonhome')
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.simple')
@stop

@section('page-script')

<script>
  $(document).ready(function () {
    $('.stokbarang').addClass('active');
  });
</script>

<script>
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var table = $('#itemstok').DataTable({
        scrollY:        "533px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
      // processing: true,
      // serverSide: true,
        columnDefs: [
            { width: '20%', targets: 0 }
        ],
        // fixedColumns:   {
        //     leftColumns: 1
        // },
      responsive: true,
      //         searching: false,
      //         paging: false,
              bInfo : false,
      //         bLengthChange: false,
              select:true,
      // lengthMenu: [[10, 50, 99, 3000], [10, 50, 99, 3000]]
      order: [[1, 'asc']],
      "language": {
        "emptyTable": "Data tidak ditemukan"
      },

      ajax: {
        url: '{{ route('search_item_stok') }}',
        method: 'POST'
      },
      columns: [
      { data: 'kobar',name:'kobar'},
      { data: 'nama',name:'nama'},
      { data: 'stok',name:'stok'},
      { data: 'harga', width: '10px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
      ]
    });
  });
</script>



@stop