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
	    Cek Harga
	    <small>ERP</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><i class="fa fa-book"></i> Daftar Harga</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div id="radioBtn" class="btn-group">
					<a class="btn btn-tumblr btn-sm notActive" data-toggle="fun" data-title="Y" onclick="showSatu()" style="margin-right: 3px;">By Kode </a>
					<a class="btn btn-tumblr btn-sm notActive" id="btnNama" data-toggle="fun" data-title="N" onclick="showDua()" style="margin-right: 3px;">By Nama</a>
					<a class="btn btn-tumblr btn-sm notActive" data-toggle="fun" data-title="Z" onclick="showTiga()" >By Suplier</a>
				</div>
			</div>
		</div>
		<br>

		@include('listharga.partials.formitem')
		@include('listharga.partials.resultitem')
		@include('listharga.partials.modal')

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
          processResults: function (data) {
              var data_array = [];
              data.data.forEach(function(value,key){
                  data_array.push({id:value.id,text:value.text})
              });
              
              return {
                results: data_array
              }
          }
      }
    }).on('select2:select', function (evt) {        
      $(".select2 option:selected").val();
    });

	$('.selectbycode').select2({
		minimumInputLength: 3,
       allowClear: true,
       placeholder: 'Masukkan Kode Barang',
       // width: '275px',
       width: '100%',
       ajax: {
          dataType: 'json',
          url: "{{ route('selectproductbycode.erp') }}",
		  delay: 300,
          data: function(params) {
            return {
              search: params.term
            }
          },
          processResults: function (data) {
              var data_array = [];
              data.data.forEach(function(value,key){
                  data_array.push({id:value.id,text:value.text})
              });
              
              return {
                results: data_array
              }
          }
      }
    }).on('select2:select', function (evt) {        
      $(".select2 option:selected").val();
    });


  });
</script>

	<script>
		$('#radioBtn a').on('click', function(){
			var sel = $(this).data('title');
			var tog = $(this).data('toggle');
			$('#'+tog).prop('value', sel);
			$('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
			$('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
		})
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#pilihprodusen,#pilih').select2();
			$("#pilihprodusen,#pilih").on('select2:open', function (e) {
				$('.select2-search input').prop('focus',false);
			});
		});
	</script>

	<script>
		function showSatu(){
			$("#hasil").addClass("none");
			$("#panelbox").removeClass("none");
			$("#noMember").removeClass("none");
			$("#noMember").addClass("showDIV");
			$("#foter").removeClass("none");
			$("#foter").addClass("showDIV");
			$("#pilih").select2("val",{placeholder: 'ALL Suplier'}); //set the value
			$("#pilihprodusen").select2("val",{placeholder: 'Pilih Suplier'}); //set the value
			document.getElementById("kdbarang").required = true
			document.getElementById("namabarang").required = false
			document.getElementById('kdbarang').value = '';
			document.getElementById('pilih').value = '';
			document.getElementById('namabarang').value = '';
			document.getElementById("pilihprodusen").required = false

			//Make sure bankDIV is not visible
			$("#Other").removeClass("showDIV");
			$("#Other").addClass("none");
			$("#produsen").removeClass("showDIV");
			$("#produsen").addClass("none");
		}
		function showDua(){
			$("#hasil").addClass("none");
			$("#panelbox").removeClass("none");
			$("#Other").removeClass("none");
			$("#Other").addClass("showDIV");
			$("#foter").removeClass("none");
			$("#foter").addClass("showDIV");
			$("#pilihprodusen").select2("val",{placeholder: 'Pilih Suplier'}); //set the value
			document.getElementById("namabarang").required = true
			document.getElementById("kdbarang").required = false
			document.getElementById('kdbarang').value = '';
			document.getElementById('pilihprodusen').value = '';
			document.getElementById("pilihprodusen").required = false
			//Make sure bankDIV is not visible
			$("#noMember").removeClass("showDIV");
			$("#noMember").addClass("none");
			$("#produsen").removeClass("showDIV");
			$("#produsen").addClass("none");
		}
		function showTiga(){
			document.getElementById('kdbarang').value = '';
			document.getElementById('pilih').value = '';
			$("#pilih").select2("val",{placeholder: 'ALL Suplier'}); //set the value
			document.getElementById('namabarang').value = '';
			$("#hasil").addClass("none");
			$("#panelbox").removeClass("none");
			$("#produsen").removeClass("none");
			$("#produsen").addClass("showDIV");
			$("#foter").removeClass("none");
			$("#foter").addClass("showDIV");
			document.getElementById("pilihprodusen").required = true
			//Make sure bankDIV is not visible
			$("#noMember").removeClass("showDIV");
			$("#noMember").addClass("none");
			$("#Other").removeClass("showDIV");
			$("#Other").addClass("none");
			document.getElementById("kdbarang").required = false
			document.getElementById("namabarang").required = false
		}
	</script>

<script>
	$(document).ready(function(){
		$('#buttonIDe').on('click', function(event) {
			var isvalidate = $("#formIDe")[0].checkValidity();
			if (isvalidate) {
				event.preventDefault();
				$('#modal-loader').show();
				$("#buttonIDe").addClass("none");
				var data = $('.form-horizontal').serialize();
				// console.log(data);
				var table = $('#databarang').DataTable();
				// table.destroy();
				$('#databarang').empty();
				// tblJabatan(data);
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					type: 'POST',
					url: "{{ route('data_list_harga') }}",
					data: data,
					cache:false,
					success: function(data) {
						$('#modal-loader').hide();
						// console.log(data);
						$("#hasil").removeClass("none");
						$("#buttonIDe").removeClass("none");
						var table = $('#databarang').DataTable({
							"language": {
								"emptyTable": "Data tidak ditemukan"
							},
							dom: 'Bfrtip',
							buttons: [

								{
									extend: 'colvis',
									text: '<i class="fa fa-eye-slash" aria-hidden="true"></i> Sembunyikan Kolom',
									className:'btn btn-info btn-sm',
					                init: function(api, node, config) {
					                  $(node).removeClass('dt-button ui-button ui-state-default')
					                },
									columnText: function ( dt, idx, title ) {
									    return (idx+1)+': '+title;
									}
									
								},
					            {
					                extend: 'excelHtml5',
					                customizeData: function ( data ) {
					                  // console.log(data.footer[6]);
					                    for (var i=0; i<data.body.length; i++){
					                        for (var j=0; j<data.body[i].length; j++ ){
					                        	data.body[i][0] = '\u200C' + data.body[i][0];
					                            data.body[i][2] = data.body[i][2].replace(/\./g,""); //
					                            // data.body[i][3] = data.body[i][3].replace(/\./g,""); //
					                            // data.body[i][4] = data.body[i][4].replace(/\./g,""); //
												// data.body[i][5] = data.body[i][5].replace(/\./g,"");
					                        }
					                    }
					                    // data.footer[5] = data.footer[5].replace(/\./g,"");
					                },
					                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
					                className:'btn btn-success btn-sm',
					                init: function(api, node, config) {
					                  // $(node).removeClass('dt-button')
					                  $(node).removeClass('dt-button ui-button ui-state-default')
					                },
					                exportOptions: {
					                    columns: ':visible',
					                    columns: [ 0,1,2,3,4]
					                },
					                footer: true
					            },

							],
							scrollX: true,
							destroy: true,
							cache:false,
							destroy: true,
							searching: false,
							paging: false,
							bInfo : false,
							bLengthChange: false,
							select:true,
							order: [[ 1, 'asc' ]],
							processing: true,
							// serverSide: true,
							data : data.data,
							columns: [
								{ data: 'code', width: '18px' },
								{ data: 'deskripsi', width: '200px' },
								{ data: 'hrgppn', width: '20px', "render": $.fn.dataTable.render.number( '.', ',', 0 ),"sClass": "text-right" },
								{ data: 'supplier', width: '400px' },
								{
									"data": null,
									"defaultContent": '<button class="btn btn-primary btn-xs viewdetail" ><i class="fa  fa-search"></i> View</button>' 
								}
							]
						});
						table.on( 'click', '.viewdetail', function () {
								$tr = $(this).closest('tr');
								var data = table.row($tr).data();
								// alert(data.name +"'s salary is: "+ data.username);
								$('#modal-viewdetail').modal('show');
								document.getElementById('nabar').value =data.deskripsi;
								var idbarang =data.id;
								$.ajax({
									type: 'POST',
									url: 'list-harga/'+idbarang,
									data: {"_token": "{{ csrf_token() }}","id": idbarang,"_method":"post"},
									cache:false,
									success: function(detail) {
										// console.log(detail);
										// $('#tglstok').html(detail.tanggal);
										document.getElementById('stokbar').value= (detail.stok== null)?0:detail.stok;
									}
								});
						});
					}
				});
			}
		});
	});
</script>

@stop