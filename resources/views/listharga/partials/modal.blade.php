  <div class="modal modal-default fade" id="modal-viewdetail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" role="form" id="formEditStatus">
          <div class="modal-body">
												<div class="form-group">
													 <label for="inputsm" class="col-sm-3 control-label">Nama</label>
												  <div class="col-sm-9" >
												    <input name="nabar" id="nabar" class="form-control input-sm" autocomplete="off"  readonly="">
												  </div>
												</div>
												<div class="form-group">
													 <label for="inputsm" class="col-sm-3 control-label">Stok <small id="tglstok"></small></label>
												  <div class="col-sm-9" >
												    <input name="stokbar" id="stokbar" class="form-control input-sm" autocomplete="off"  readonly="">
												  </div>
												</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-tumblr btn-xs col-xs-12" data-dismiss="modal" onclick="document.getElementById('formEditStatus').reset();">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>