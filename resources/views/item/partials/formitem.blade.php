		<div class="row">
			<div class="col-sm-12">
				<div class="box box-info none" id="panelbox">
					<!-- form start -->
					<form class="form-horizontal" role="form" id="formIDe">
						<div class="box-body none" id="noMember">
							<div class="form-group">
								<div  class="col-xs-10 "><label for="inputsm">Masukan Kode Barang</label></div>
								<div class="col-xs-12" >
									<input type="text" name="kdbarang" id="kdbarang" class="form-control input-sm" placeholder="Kode Barang...">
								</div>
							</div>
						</div>
						<div class="box-body none" id="Other">
							<div class="form-group" style="display:;" id="barisNama">
								<div  class="col-xs-10 "><label for="inputsm">Masukan Nama Barang</label></div>
								<div class="col-xs-12" >
									<input type="text" name="namabarang" id="namabarang" class="form-control input-sm" placeholder="Nama Barang...">
								</div>
							</div>

							<div class="form-group">
								<div class="col-xs-12" >
									<select name="suplier" id="pilih" class="form-control input-sm" style="width: 100%">
										<option selected value="">ALL Suplier</option>
										@foreach ($items as $item)
										<option value="{{$item->suplier}}">{{$item->suplier}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="box-body none" id="produsen">
							<div class="form-group">
								<div  class="col-xs-12"><label for="inputsm">Pilih Suplier</label></div>
								<div class="col-xs-12" >
									<select name="produsen" id="pilihprodusen" class="form-control input-sm" style="width: 100%">
										<option selected value="">ALL Suplier</option>
										@foreach ($items as $item)
										<option value="{{$item->suplier}}">{{$item->suplier}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="box-footer" id="foter">
							<button type="submit" class="btn btn-xs btn-tumblr col-xs-12" name="cari" id="buttonIDe" onClick="">
								<span class="fa fa-search" aria-hidden="true"></span> Cari
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="modal-loader" style="display: none; text-align: center;">
			Loading... 
		</div>