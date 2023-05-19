@extends('layouts.master')

@section('title', 'CDI | Pemesanan')
@section('minititle', 'Sales Pemesanan')

@section('css')
    @include('css.datatables.full')
    <style>
        .dataTables_info {
            display: none;
        }

        .invalid-feedback {
            color: #FF0000;
        }
    </style>
@stop

@section('content')
    <!-- Content Header (Page header) -->
    {{-- <section class="content-header">
        <h3>
            Sales <small>Pemesanan</small>
        </h3>
    </section> --}}
    <!-- Main content -->
    <section class="content">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"> </h4>

                    <form method="post" id="form_pesan">
                        <!-- row -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="box box-info">
                                    <div class="box-body">
                                        <!-- Date dd/mm/yyyy -->
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="tgl" class="form-control pull-right"
                                                    value="{{ date('Y/m/d') }}" data-inputmask="'alias': 'dd/mm/yyyy'"
                                                    data-mask id="Date" />
                                            </div><!-- /.input group -->
                                        </div><!-- /.form group -->
                                        {{-- <div class="form-group">
                    <label>Nama Sales</label> --}}
                                        <input type="hidden" name="sales" class="form-control"
                                            value="{{ Auth::user()->username }}" readonly />
                                        {{-- </div> --}}
                                        {{-- <div class="form-group"> 
                    <input type="button" class="btn btn-warning" value="Generate" name="generate" onClick="randomString();"/>
                    <span style="color:red">* Silahkan generate invoice untuk melanjutkan transaksi !</span>                             
                  </div> --}}
                                        <div class="form-group">
                                            <label>Invoice</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="nota" id="nota"
                                                    value="" readonly />
                                                <span class="input-group-btn">
                                                    <a class="btn btn-warning btn-flat" id="generate" name="generate"
                                                        type="button"><i class="fa fa-key"></i> Generate</a>
                                                </span>
                                            </div><!-- /input-group -->
                                            <span style="color:red;font-size: 10px;">* Silahkan generate invoice dahulu
                                                untuk
                                                melanjutkan transaksi !</span>
                                            <div class="invalid-feedback" id="kobarRequired" style="display:none;color:red">
                                            </div>
                                        </div>

                                        <!--                   <div class="form-group" id="dvcusum">
                                                                <input type="text" class="form-control" name="namacustumum" id="_namacust"/>
                                                              </div>   -->
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="namacustumum" id="_namacust"
                                                value="-" />
                                            <input type="hidden" class="form-control" name="tipecust" id="tipecust"
                                                value="UMUM" />
                                        </div>
                                        <div class="form-group" style="display" id="dvcus">
                                            <label>Nama Customer Lama</label>
                                            <select id="customer" name="namacustmember" class="form-control select2"
                                                style="width: 100%;" required="">
                                                <option value="">- Pilih Nama -</option>
                                            </select>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="chbtipecus" id="chkcus"
                                                        value="1" />
                                                    Customer Baru
                                                </label><br>
                                                <span id="notifnewcust"
                                                    style="display:none;color:red;font-size: 10px;">*Nama Customer
                                                    baru, inputkan pada keterangan !</span>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box box-warning">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="kobar" id="s_kobar"
                                                    readonly>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info btn-flat modalbarang" type="button"
                                                        id="btmodalbarang"><i class="bi bi-search"></i></i></button>
                                                </span>
                                            </div><!-- /input-group -->
                                            <div class="invalid-feedback" id="kobarRequired" style="display:none;color:red">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" class="form-control" name="nama" id="s_nama"
                                                readonly />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Harga</label>
                                                    <input type="text" class="form-control" name="harga"
                                                        id="s_harga" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="qty"
                                                        id="s_qty" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Diskon(%)</label>
                                                    <input type="number" class="form-control" name="diskon"
                                                        id="s_diskon" value="0" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a class="btn btn-primary" id="addRow" style="display: none"><i
                                                    class="fa fa-cart-plus"></i disabled> Add Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box box-success">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <h2><label class="pull-left" for="grandtotal">Rp. 0</label></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div>
                                                    <div class="form-group">
                                                        <a class="btn btn-sm btn-danger" id="deleterow"><i
                                                                class="fa fa-trash"></i>
                                                            Delete</a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="detail" class="display nowrap compact" cellspacing="0"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Diskon(%)</th>
                                                                <th>SubTotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="6" style="text-align:right">Total (Rp.):
                                                                </th>
                                                                <th class="total"></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div>
                                                    <span id="form_output"></span>
                                                    <div class="form-group">
                                                        <a class="btn btn-success modalbayar" id="btbayar"
                                                            style="display: none"><i class="fa fa-money"></i>
                                                            Pembayaran</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        {{-- {!! Form::close() !!} --}}
        @include('pemesanan.partials.modalbarang')
        @include('pemesanan.partials.modalbayar')
        </form>
    </section>
    <section>
        {{-- @include('panel.buttonhome') --}}
    </section>
@endsection

@section('javascript')
    @include('js.datatables.full')
    @include('js.select2')
@stop


@section('page-script')

    {{-- openmodalbarang --}}
    <script>
        $('.modalbarang').on('click', function(e) {
            $('#modalbarang').modal('show');
            $('#itemstok').DataTable().ajax.reload();
        });
    </script>

    {{-- openmodalbayar --}}
    <script>
        $('.modalbayar').on('click', function(e) {
            $('#modalbayar').modal('show');
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $("#chbtunai").click(function() {
                if ($(this).is(":checked")) {
                    $("#form1").show();
                    $("#form2").hide();
                } else {
                    $("#form1").hide();
                    $("#form2").show();
                }
            });

        });
    </script>

    <script>
        $(function() {
            $("#chkcus").click(function() {
                if ($(this).is(":checked")) {
                    $("#dvcus").hide();
                    // $("#dvcusum").show(); 
                    $('#tipecust').val('UMUM');
                    $('#chkcus').val('1');
                    $('#notifnewcust').show();
                } else {
                    $("#dvcus").show();
                    // $("#dvcusum").hide();
                    $('#tipecust').val('MEMBER');
                    $('#chkcus').val('0');
                    $('#notifnewcust').hide();
                }
            });
        });
    </script>
    <script>
        $('#Date').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function tblccc() {

            // $('#itemstok tfoot th').each( function () {
            //   var title = $(this).text();
            //   if (title=='Nama') {
            //     $(this).html( '<input type="text" placeholder="Filter Nama" style="color: #aa001e;" />' );
            //   }} );

            var table = $('#itemstok').DataTable({
                "language": {
                    "emptyTable": "Data tidak ditemukan"
                },
                scrollY: true,
                scrollX: true,
                filter: true,
                deferRender: true,
                processing: true,
                // destroy   : true,
                // cache     : false,
                // select    : true,
                serverSide: true,
                lengthMenu: [
                    [10, 50, 999],
                    [10, 50, 999]
                ],
                order: [
                    [1, 'asc']
                ],
                // type : "get",
                //   ajax: '/pemesanan/searchstok',
                ajax: {
                    url: '{{ route('stok_erp') }}',
                    method: 'POST'
                },
                columns: [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": "<a class='btn bg-primary btn-xs pilih' ><i class='fa fa-edit'></i> Pilih </a>",
                    },
                    {
                        data: 'kobar',
                        name: 'kobar'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        width: '10px',
                        "render": $.fn.dataTable.render.number('.', ',', 0),
                        "sClass": "text-right"
                    }
                ],
            });

            table.on('click', 'tr', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                $('#modalbarang').modal('hide');
                $("#s_kobar").val(data['kobar']);
                $("#s_nama").val(data['nama']);
                $("#s_harga").val(data['harga']);
                $('input[name=qty]').focus();
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#form_pesan').validate({
                rules: {
                    kobar: {
                        required: true,
                    },
                    qty: {
                        required: true,
                    },
                },
                messages: {
                    kobar: {
                        required: "Kode barang Wajib diisi !"
                    },
                    qty: {
                        required: "Wajib diisi !"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });


            var t = $('#detail').DataTable({
                bInfo: false,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        name: "no"
                    },
                    {
                        name: "kobar"
                    },
                    {
                        name: "nama"
                    },
                    {
                        name: "harga"
                    },
                    {
                        name: "qty"
                    },
                    {
                        name: "diskon"
                    },
                    {
                        name: "subtotal"
                    }
                ]
            });

            $('#addRow').on('click', function() {
                var IsValid = $("#form_pesan").valid();
                var _kobar = $("#s_kobar").val();
                var _nama = $("#s_nama").val();
                var _harga = $("#s_harga").val();
                var _diskon = $("#s_diskon").val();
                var _grandharga = _harga - (_diskon / 100 * _harga);
                var _qty = $("#s_qty").val();
                var _subtot = _grandharga * _qty;

                function total() {
                    var total = 0;
                    $('.amount').each(function(i, e) {
                        var amount = $(this).val() - 0;
                        total += amount;
                    })
                    $('.total').html(total.formatMoney(2, ',', '.'));
                    $("label[for='grandtotal']").html(total.formatMoney(2, ',', '.'));
                    $("input[name='nominal']").val(total);
                }
                Number.prototype.formatMoney = function(c, d, t, sym) {
                    var n = this,
                        c = isNaN(c = Math.abs(c)) ? 2 : c,
                        d = d == undefined ? "," : d,
                        t = t == undefined ? "." : t,
                        s = n < 0 ? "-" : "",
                        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                        j = (j = i.length) > 3 ? j % 3 : 0,
                        sym = sym == undefined ? "Rp." : sym;
                    return sym + s + (j ? i.substr(0, j) + d : "") + i.substr(j).replace(
                        /(\d{3})(?=\d)/g, "$1" + d) + (c ? t + Math.abs(n - i).toFixed(c).slice(2) :
                        "");
                };

                if (IsValid) {
                    t.row.add([
                        '',
                        '<input type="text" size="12" value="' + _kobar +
                        '" name="ajxkobar[]" id="ajxkobar" readonly/>',
                        '<input type="text" size="30" value="' + _nama +
                        '" name="ajxnama[]" id="ajxnama" readonly/>',
                        '<input type="text" size="12" value="' + _grandharga +
                        '" name="ajxgrandharga[]" id="ajxgrandharga" readonly/>',
                        '<input type="text" size="3" value="' + _qty +
                        '" name="ajxqty[]" id="ajxqty" readonly/>',
                        '<input type="text" size="5" value="' + _diskon +
                        '" name="ajxdiskon[]" id="ajxdiskon" readonly/>',
                        '<input type="text" class="amount" size="12" value="' + _subtot +
                        '" name="ajxsubtot[]" id="ajxsubtot" readonly/>'
                    ]);
                    //auto inc datatable
                    t.on('order.dt search.dt', function() {
                        t.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                    total();
                    document.getElementById('s_kobar').value = "";
                    document.getElementById('s_nama').value = "";
                    document.getElementById('s_harga').value = "";
                    document.getElementById('s_qty').value = "";
                    document.getElementById('s_diskon').value = "0";
                }
            });

            $('#detail tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    t.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#deleterow').click(function() {
                t.row('.selected').remove().draw(false);
            });
        });
    </script>



    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                minimumInputLength: 3,
                allowClear: true,
                placeholder: 'Tuliskan nama Customer',
                // width: '275px',
                width: '100%',
                ajax: {
                    dataType: 'json',
                    url: '{{ route('selectcustnama') }}',
                    delay: 800,
                    data: function(params) {
                        return {
                            search: params.term
                        }
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        };
                    },
                }
            }).on('select2:select', function(evt) {
                $(".select2 option:selected").val();
                // $("#namacustomer").val(namacust);
                // var data = $(".select2 option:selected").text();
                // alert("Data yang dipilih adalah "+data);
            });
        });
    </script>

    {{-- <script>
      $(function(){
         $('#_namacust').keyup(function(){
        $("#namacustomer").val($("#_namacust").val());
    });
  });
  </script> --}}

    <script type="text/javascript">
        function kurang() {
            var bayar = document.getElementById('bayar').value;
            var grandtotal = $("#nominal").val();
            var result = parseFloat(bayar) - parseFloat(grandtotal);
            if (!isNaN(result)) {
                document.getElementById('kembali').value = result;
                $("label[for='kembali']").html(result.formatMoney(2, ',', '.'));
            }
        }

        function kredit() {
            var credit = document.getElementById('credit').value;
            var grandtotal = $("#nominal2").val();
            var result = parseFloat(grandtotal) - parseFloat(credit);
            if (!isNaN(result)) {
                document.getElementById('kekurangan').value = result;
                $("label[for='kekurangan']").html(result.formatMoney(2, ',', '.'));
            }
        }
    </script>

    {{-- load autocode --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $("#generate").click(function() {
                invoice();
                $("#btbayar").show();
                $("#addRow").show();
            });

            function invoice() {
                $.getJSON("{{ route('codeinvoice') }}", function(data) {
                    $('#nota').val(data.invoice);
                })
            };
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form_pesan').on('submit', function(event) {
            event.preventDefault();
            var form_data = $(this).serialize();
            $.ajax({
                url: "{{ route('ajax.simpan') }}",
                method: "POST",
                data: form_data,
                dataType: "json",
                success: function(data) {
                    if (data.error.length > 0) {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++) {
                            error_html +=
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                data.error[count] +
                                '<button type="button" class="close" data dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                        }
                        $('#form_output').html(error_html);
                    } else {
                        swal.fire("Done !", data.success, "success");
                        // $('#form_output').html(data.success);
                        $('#form_pesan')[0].reset();
                        $('#button_action').val('insert');
                        $('#modalbayar').modal('hide');
                        $('#detail').dataTable().fnClearTable();
                        // $('#documentsTable tbody tfoot').empty();                                        
                        $("label[for='grandtotal']").html('Rp.0');
                        $('.total').html('');
                        $("#btbayar").hide();
                        $("#addRow").hide();
                    }
                }
            })
        });
    </script>
@stop
