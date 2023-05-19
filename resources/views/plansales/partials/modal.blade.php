      <!-- modaal cekin -->
      <div class="modal fade" id="modal-cekin" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">Klik tombol CheckIN bila berada ditempat berikut</h5>
            </div>
            <div class="modal-body ">
                <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                <p class="text-muted">
                  <label id="customer"></label>
                </p>
                <hr>
                <strong><i class="fa fa-edit margin-r-5"></i> Note</strong>
                <p class="text-muted"> 
                  <label id="deskripsicust3"><small>Bila anda sudah berada di lokasi silahkan melanjutkan dengan klik tombol CeckIn</small></label>
                </p>
            </div>
            <div class="modal-footer">
              <input type="hidden" id='idplan'>
              <button type="button" class="btn bg-green" id="btnChekIn">CheckIn</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>

      <!-- modaal cekout -->
      <div class="modal fade" id="modal-cekout" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">Klik tombol CheckOut bila berada ditempat berikut</h5>
            </div>
            <form class="form-horizontal" role="form" id="formIDe">
            <div class="modal-body ">
                <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                <p class="text-muted">
                  <label id="customer2"></label>
                </p>
                <hr>
                <strong><i class="fa fa-folder-o margin-r-5"></i> Keperluan</strong>
                <p class="text-muted"> 
                  <label id="deskripsicust"></label>
                </p>
                <hr>
                <strong><i class="fa fa-edit margin-r-5"></i> Hasil Kunjungan*</strong>
                <p class="text-muted"> 
                  <textarea name="hasil" class="form-control" rows="3" placeholder="Silahkan tulis hasil dari kunjungan yang telah dilakukan" required=""></textarea>
                </p>
            </div>
            <div class="modal-footer">
              <input type="hidden" id='idplan2' name="idplan">
              <input type="hidden" name="lat" id="latitude" value="">
              <input type="hidden" name="long" id="longitude" value="">
              <button type="submit" class="btn btn-primary" id="btnChekOut">CheckOut</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modaal BatalCekin -->
      <div class="modal fade" id="modal-batalcekin" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">Batal CheckIN</h5>
            </div>
            <div class="modal-body ">
                <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                <p class="text-muted">
                  <label id="customer3"></label>
                </p>
                <hr>
                <strong><i class="fa fa-edit margin-r-5"></i> Note</strong>
                <p class="text-muted"> 
                  <label id="deskripsicust3"><small>Jika tombol Cancel CheckIn diklik maka anda membatalkan check in (Bukan menghapus Plan,jadi bisa check in kembali nanti)</small></label>
                </p>
            </div>
            <div class="modal-footer">
              <input type="hidden" id='idplan3'>
              <button type="button" class="btn bg-red" id="btnCancelChekIn">Cancel CheckIn</button>
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
      <!-- modal info masih cekin -->
      <div class="modal modal-info fade" id="modal-masihcekin">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <p id="pesanerror"></p>
              <!-- Anda Masih memiliki status CheckIn,silahkan Chekout atau Cancel chekin terlebih dahulu. -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline col-sm-2 col-sm-offset-5" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>