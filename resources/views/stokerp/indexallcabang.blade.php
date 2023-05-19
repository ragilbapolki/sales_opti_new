@extends('layouts.master')

@section('title','CDI | ERP Stok Barang')

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
              <div class="box-header with-border bg-warning">
                <i class="fa fa-info-circle"></i>
                <h4 class="box-title">Stok Barang {{$tgl}} {{$kodecabang}} <small>Harga Sudah Termasuk PPN.</small></h4>
              </div>
              <div class="box-body table-bordered no-padding">
                <div class="col-xs-12">
                      <!-- <table id="custrank" class="display nowrap compact" cellspacing="0" width="100%"> -->
                      <table id="itemstok" class="display cell-border compact" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Code/SKU</th>
                            <th>Product</th>
                            <th>Organisasi</th>
                            <th>Stok</th>
                            {{-- <th>Harga</th> --}}
                            <th>Wilayah</th>
                            {{-- <th>Harga Luar Jawa</th> --}}
                            <th>Harga</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th>Code/SKU</th>
                            <th>Product</th>
                            <th>Organisasi</th>
                            <th>Stok</th>
                            {{-- <th>Harga</th> --}}
                            <th>Wilayah</th>
                            {{-- <th>Harga Luar Jawa</th> --}}
                            <th>Harga</th>
                          </tr>
                        </tfoot>
                      </table>
                </div>
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

    $.fn.DataTable.ext.pager.numbers_length = 4;
    var table = $('#itemstok').DataTable({
        scrollY:        "533px",
        scrollX:        true,
        scrollCollapse: true,
        // processing: true,
        // serverSide: true,
        // columnDefs: [
        //     { width: '20%', targets: 0 }
        // ],
        responsive: true,
        bInfo : false,
        select:true,
        lengthChange: false,
        pageLength : 20, 
        order: [[1, 'asc']],
        "language": {
          "emptyTable": "Data tidak ditemukan"
        },

      ajax: {
        url: "{{ route('data_stok_erp') }}",
        method: 'POST'
      },
      columns: [
      { data: 'code',name:'code'},
      { data: 'deskripsi',name:'deskripsi'},
      { data: 'nama_perusahaan',name:'nama_perusahaan'},
      { data: 'qty',name:'qty', className: "text-center"},
      { data: 'price_category',name:'price_category', className: "text-center"},
      // { data: 'hrgppn', name: 'hrgppn', width: '10px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
      // { data: 'hrgluarjawappn', name: 'hrgluarjawappn', width: '10px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
      { data: 'fix_harga', name: 'fix_harga', width: '10px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
      ]
          //   drawCallback: function () {
          //     $('#itemstok_wrapper .col-md-7:eq(0)').addClass("d-flex justify-content-center justify-content-md-end");
          //     $('#itemstok_paginate').addClass("mt-3 mt-md-2");
          //     $('#itemstok_paginate ul.pagination').addClass("pagination-sm");
          // }
    });
  });
</script>



@stop