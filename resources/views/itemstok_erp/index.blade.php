@extends('layouts.master')

@section('title', 'CDI | Stock Filter')

@section('minititle', 'Cek Stock ERP')

@section('css')
    @include('css.datatables.full')
    @include('css.select2')
    <style>
        .none {
            display: none;
        }

        ,
        .showDIV {
            display: block;
        }

        #radioBtn .notActive {
            color: #3276b1;
            background-color: #fff;
        }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"></h4>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="box box-info" id="panelbox">
                                <!-- form start -->
                                <form class="form-horizontal" role="form" id="formIDe">
                                    <div class="box-body " id="Other">
                                        <div class="form-group" style="display:;" id="barisNama">
                                            <div class="col-md-10 "><label for="inputsm">Masukan Nama Barang</label></div>
                                            <br>
                                            <div class="col-md-12">
                                                <select name="kodebarang" id="kodebarang" class="form-control select2"
                                                    required="">
                                                    <option value="">Nama Barang</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="box-footer" id="foter">
                                        <button type="submit" class="btn btn-outline-primary" name="cari" id="buttonIDe"
                                            onClick="">
                                            <span class="fa fa-search" aria-hidden="true"></span> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-sm-4 none" id="hasilpanel">
                            <div class="box box-primary" id="datacustomer">
                                <div class="box-body">
                                    <div class="col-sm-12">
                                        <table class="table table-sm table-striped">
                                            <tr>
                                                <td>Kode Barang</td>
                                                <td><b><span id="header_kode"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Barang</td>
                                                <td><b><span id="header_nama"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td>Produsen</td>
                                                <td><b><span id="header_produsen"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td>NIE</td>
                                                <td><b><span id="header_nie"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td>Harga</td>
                                                <td><b><span id="header_hargappn"></span></b></td>
                                            </tr>
                                            <tr>
                                                <td>Harga Luar</td>
                                                <td><b><span id="header_hargappnluar"></span></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="modal-loader" style="display: none; text-align: left;">
                        Loading...
                    </div>

                    <div class="row">
                        <div class="col-xs-12 none" id="hasil">
                            <div class="box box-primary">
                                <div class="box-header with-border bg-warning">
                                    <i class="fa fa-info-circle"></i>
                                    <h4 class="box-title"> Harga Sudah Termasuk PPN.</h4>
                                </div>
                                <div class="box-body table-responsive no-padding">
                                    <div class="col-xs-12 ">
                                        <table id="databarang" class="display nowrap cell-border compact" cellspacing="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Cabang</th>
                                                    <th>Nama</th>
                                                    <th>Kota</th>
                                                    <th>Stok</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Cabang</th>
                                                    <th>Nama</th>
                                                    <th>Kota</th>
                                                    <th>Stok</th>
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
                    <!-- 						<div class="row">
                               <div class="col-xs-12 none" id="hasilgudang">
                                <div class="box box-primary">
                                 <div class="box-header with-border bg-warning">
                                  <i class="fa fa-info-circle"></i>
                                  <h4 class="box-title"> Harga Sudah Termasuk PPN.</h4>
                                 </div>
                                 <div class="box-body table-responsive no-padding">
                                  <div class="col-xs-12 ">
                                   <table id="datagudang" class="display nowrap cell-border compact" cellspacing="0" width="100%">
                                    <thead>
                                     <tr>
                                      <th>Gudang</th>
                                      <th>Nama</th>
                                      <th>Kota</th>
                                      <th>Stok</th>
                                     </tr>
                                    </thead>
                                    <tfoot>
                                     <tr>
                                      <th>Gudang</th>
                                      <th>Nama</th>
                                      <th>Kota</th>
                                      <th>Stok</th>
                                     </tr>
                                    </tfoot>
                                   </table>
                                  </div>
                                 </div>
                                 <div class="box-footer">
                                 </div>
                                </div>
                               </div>
                              </div>	 -->

                </div>
            </div>
        </div>
        <br>
        @include('panel.buttonhome')
    </section>
    <!-- /.content -->
@endsection

@section('javascript')
    @include('js.datatables.full')
    @include('js.select2')
@stop

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.daftarharga').addClass('active');
        });
    </script>

    <script>
        $(document).ready(function() {

            $('.select2').select2({
                minimumInputLength: 3,
                allowClear: true,
                placeholder: 'Masukkan Nama Barang',
                // width: '275px',
                width: '100%',
                ajax: {
                    dataType: 'json',
                    url: "{{ route('selectproduct.erp') }}",
                    delay: 300,
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(data) {
                        var data_array = [];
                        data.data.forEach(function(value, key) {
                            data_array.push({
                                id: value.id,
                                text: value.text
                            })
                        });

                        return {
                            results: data_array
                        }
                    }
                }
            }).on('select2:select', function(evt) {
                $(".select2 option:selected").val();
            });


            $('#buttonIDe').on('click', function(event) {
                var isvalidate = $("#formIDe")[0].checkValidity();
                if (isvalidate) {
                    event.preventDefault();
                    $('#modal-loader').show();
                    $("#buttonIDe").addClass("none");
                    $("#hasilpanel").addClass("none");
                    $("#hasil").addClass("none");
                    // $("#hasilgudang").addClass("none");				
                    document.getElementById("header_kode").innerHTML = '';
                    document.getElementById("header_nama").innerHTML = '';
                    document.getElementById("header_produsen").innerHTML = '';
                    document.getElementById("header_nie").innerHTML = '';
                    document.getElementById("header_hargappn").innerHTML = '';
                    document.getElementById("header_hargappnluar").innerHTML = '';
                    var data = $('.form-horizontal').serialize();
                    // console.log(data);
                    var table = $('#databarang').DataTable();
                    $('#databarang').empty();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'post',
                        url: "{{ route('data_stock_peritems') }}",
                        data: data,
                        cache: false,
                        success: function(data) {
                            $('#modal-loader').hide();
                            document.getElementById("header_kode").innerHTML = data.item['id'];
                            document.getElementById("header_nama").innerHTML = data.item[
                                'nama'];
                            document.getElementById("header_produsen").innerHTML = data.item[
                                'produsen'];
                            document.getElementById("header_nie").innerHTML = data.item['nie'];
                            document.getElementById("header_hargappn").innerHTML = parseInt(data
                                .item['hrgppn']);
                            document.getElementById("header_hargappnluar").innerHTML = parseInt(
                                data.item['hrgluarjawappn']);
                            // console.log(data);
                            $("#hasilpanel").removeClass("none");
                            $("#hasil").removeClass("none");
                            // $("#hasilgudang").addClass("none");							
                            $("#buttonIDe").removeClass("none");
                            var table = $('#databarang').DataTable({
                                "language": {
                                    "emptyTable": "Data tidak ditemukan"
                                },

                                scrollX: true,
                                destroy: true,
                                cache: false,
                                destroy: true,
                                searching: false,
                                paging: false,
                                bInfo: false,
                                bLengthChange: false,
                                select: true,
                                order: [
                                    [0, 'asc']
                                ],
                                processing: true,
                                // serverSide: true,
                                data: data.data,
                                columns: [{
                                        data: 'kode',
                                        className: "text-center",
                                        width: '18px'
                                    },
                                    {
                                        data: 'alias',
                                        width: '18px'
                                    },
                                    {
                                        data: 'kota',
                                        width: '18px'
                                    },
                                    {
                                        data: 'stok',
                                        className: "text-center",
                                        width: '200px'
                                    },
                                ]
                            });

                        }
                    });
                }
            });
        });
    </script>

@stop
