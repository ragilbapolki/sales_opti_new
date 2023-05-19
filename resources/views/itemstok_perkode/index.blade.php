@extends('layouts.master')

@section('title','CDI | Harga Barang')

@section('css')
    @include('css.datatables.full')
    @include('css.select2')
    <style> 
      .none { display:none; }, 
      .showDIV { display:block; } 
						#radioBtn .notActive{
							color: #3276b1;
							background-color: #fff;
						}
    </style>
@stop

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	    Cek Stok
	    <small>CDI</small>
	  </h1>

	</section>

	<!-- Main content -->
	<section class="content">
						<div class="row">
							<div class="col-md-4">
								<div class="box box-info" id="panelbox">
									<!-- form start -->
									<form class="form-horizontal" role="form" id="formIDe">
										<div class="box-body " id="Other">
											<div class="form-group" style="display:;" id="barisNama">
												<div  class="col-md-10 "><label for="inputsm">Masukan Nama Barang</label></div>
												<div class="col-md-12" >
					         <select name="kodebarang" id="kodebarang" class="form-control select2" required="">
					           <option value="">Nama Barang</option>
					         </select>
												</div>
											</div>
										</div>
										<div class="box-footer" id="foter">
											<button type="submit" class="btn btn-xs btn-tumblr col-md-5 col-md-offset-3" name="cari" id="buttonIDe" onClick="">
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
																	<table class="table table-striped">
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
																	     <td>Harga Jawa</td>
																	     <td><b><span id="header_hargajawa"></span></b></td>
																	   </tr>
																	   <tr>
																	     <td>Harga Luar Jawa</td>
																	     <td><b><span id="header_hargaluarjawa"></span></b></td>
																	   </tr>
																	   <tr>
																	     <td>Harga Batam</td>
																	     <td><b><span id="header_hargabatam"></span></b></td>
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
											<table id="databarang" class="display nowrap cell-border compact" cellspacing="0" width="100%">
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
  $(document).ready(function () {
    $('.daftarharga').addClass('active');
  });
</script>

<script type="text/javascript">
  $(function(){
   $('.select2').select2({
       minimumInputLength: 3,
       allowClear: true,
       placeholder: 'masukkan nama Barang',
       // width: '275px',
       width: '100%',
       ajax: {
          dataType: 'json',
          // url: 'daftarProvinsi.php',
          // url:'https://app.cobradental.co.id:1780/cdi_pos/api/v1/selectcustccc',
          url: '{{ route('selectitem') }}',
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


<script>
	$(document).ready(function(){
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
				document.getElementById("header_hargajawa").innerHTML = '';
				document.getElementById("header_hargaluarjawa").innerHTML = '';
				document.getElementById("header_hargabatam").innerHTML = '';
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
					url: '{!! route('data_cekstok_area') !!}',
					data: data,
					cache:false,
					success: function(data) {
						$('#modal-loader').hide();
      document.getElementById("header_kode").innerHTML = data.item['id'];
      document.getElementById("header_nama").innerHTML = data.item['nama'];
      document.getElementById("header_produsen").innerHTML = data.item['produsen'];
      document.getElementById("header_nie").innerHTML = data.item['nie'];
      document.getElementById("header_hargajawa").innerHTML = data.item['jawa'];
      document.getElementById("header_hargaluarjawa").innerHTML = data.item['luarjawa'];
      document.getElementById("header_hargabatam").innerHTML = data.item['batam'];
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
							cache:false,
							destroy: true,
							searching: false,
							paging: false,
							bInfo : false,
							bLengthChange: false,
							select:true,
							order: [[ 0, 'asc' ]],
							processing: true,
							// serverSide: true,
							data : data.data,
							columns: [
								{ data: 'kode', width: '18px' },
								{ data: 'alias', width: '18px' },
								{ data: 'kota', width: '18px' },
								{ data: 'stok', width: '200px' },
							]
						});
						// var table2 = $('#datagudang').DataTable({
						// 	"language": {
						// 		"emptyTable": "Data tidak ditemukan"
						// 	},

						// 	scrollX: true,
						// 	destroy: true,
						// 	cache:false,
						// 	destroy: true,
						// 	searching: false,
						// 	paging: false,
						// 	bInfo : false,
						// 	bLengthChange: false,
						// 	select:true,
						// 	order: [[ 0, 'asc' ]],
						// 	processing: true,
						// 	// serverSide: true,
						// 	data : data.gudang,
						// 	columns: [
						// 		{ data: 'kode_cabang', width: '18px' },
						// 		{ data: 'stok', width: '18px' },
						// 	]
						// });						
					}
				});
			}
		});
	});
</script>

@stop