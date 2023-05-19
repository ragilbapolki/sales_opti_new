      <!-- modal hapus Sales -->
      <div class="modal fade" id="modal-hpssales" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><label id="namasales"></label></h4>
                  </div>
                  <div class="modal-body ">
                      <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                      <p class="text-muted">
                          <label id="customer"></label>
                      </p>
                      <hr>
                      <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                      <p class="text-muted">
                          <label id="alamatcust"></label>
                      </p>
                      <hr>
                      <strong><i class="fa fa-edit margin-r-5"></i> Keperluan</strong>
                      <p class="text-muted">
                          <label id="deskripsicust"></label>
                      </p>
                  </div>
                  <div class="modal-footer">
                      <input type="hidden" id='idplan'>
                      <!-- <button type="button" class="btn btn-purple btn-outline" id="hpsstoremanager">Ok,fine&hellip;</button> -->
                      <button type="button" class="btn btn-success" id="hpsstoremanager">Approve</button>
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                      <!-- <button type="button" class="btn bg-maroon btn-outline pull-left" data-dismiss="modal">Batal</button> -->
                  </div>
              </div>
          </div>
      </div>

      <!-- modal Tolak -->
      <div class="modal fade" id="modal-hpssales2" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><label id="namasales2"></label></h4>
                  </div>
                  <form class="form-horizontal" role="form" id="formIDe">
                      <div class="modal-body ">
                          <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                          <p class="text-muted">
                              <label id="customer2"></label>
                          </p>
                          <hr>
                          <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                          <p class="text-muted">
                              <label id="alamatcust2"></label>
                          </p>
                          <hr>
                          <strong><i class="fa fa-edit margin-r-5"></i> Keperluan</strong>
                          <p class="text-muted">
                              <label id="deskripsicust2"></label>
                          </p>
                          <hr>
                          <strong><i class="fa fa-edit margin-r-5"></i> Alasan Menolak*</strong>
                          <p class="text-muted">
                              <!-- <label id="deskripsicust2"></label> -->
                              <textarea name="kettolak" id="kettolak" class="form-control" rows="3" placeholder="Silahkan tulis Alasan menolak"
                                  required=""></textarea>
                          </p>
                      </div>
                      <div class="modal-footer">
                          <input type="hidden" name="idplan2" id='idplan2'>
                          <!-- <button type="button" class="btn btn-purple btn-outline" id="hpsstoremanager">Ok,fine&hellip;</button> -->
                          <button type="submit" class="btn btn-danger" id="tolakplan">Tolak</button>
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                          <!-- <button type="button" class="btn bg-maroon btn-outline pull-left" data-dismiss="modal">Batal</button> -->
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <!-- modal Edit -->
      <div class="modal fade" id="modal-editplan" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title"><label id="namasales3"></label></h4>
                  </div>
                  <form class="form-horizontal" role="form" id="formEdit">
                      <div class="modal-body ">
                          <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                          <p class="text-muted">
                              <label id="customer3"></label>
                          </p>
                          <hr>
                          <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                          <p class="text-muted">
                              <label id="alamatcust3"></label>
                          </p>
                          <hr>
                          <strong><i class="fa fa-edit margin-r-5"></i> Keperluan</strong>
                          <p class="text-muted">
                              <textarea name="ket_edit" id="ket_edit" class="form-control" rows="3" required=""></textarea>
                          </p>
                      </div>
                      <div class="modal-footer">
                          <input type="hidden" name="idplan3" id='idplan3'>
                          <button type="submit" class="btn btn-primary" id="editplan">Simpan</button>
                          <button type="button" class="btn btn-default pull-left"
                              data-dismiss="modal">Batal</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
