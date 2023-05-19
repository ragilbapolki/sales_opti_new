      <!-- modal form input -->
      <div class="modal fade bd-example-modal-lg" id="modalbayar" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"> Pembayaran</i></h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-12">
                      <div class="box box-danger">
                          <div class="box-body">                          
                          <div class="form-group">
                            <div class="checkbox">
                              <label for="chbtunai">
                                <input type="checkbox" name="chbtunai" id="chbtunai" value="1" checked/>
                                Tunai &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              </label>
                              <span style="color:red"><b><i>* unchecked</i></b> untuk kredit</span>
                            </div>
                          </div>                              
                            <div class="row" id="form1"> 
                                <div class="col-md-6">  
                                    <div class="form-group">
                                      <label>Grand Total(Rp)</label>
                                      <input type="text" readonly name="nominal" id="nominal" class=" form-control" onkeyup="kurang();"/>
                                      <input type="hidden" class="form-control" name="tipe1" value="TUNAI" id="tipe" readonly/>
                                    </div>                                  
                                    <div class="form-group">
                                      <label>Cash</label>
                                      <input type="number" class="form-control" name="bayar" id="bayar" onkeyup="kurang();"/>
                                  </div>                                     
                                </div>
                                <div class="col-md-6">                               
                                  <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="ket1" id="ket" style=" min-width:150px; max-width:100%;min-height:75px;height:100%;width:100%;"></textarea>
                                </div>
                                <div class="form-group">
                                  <label>Kembali</label>
                                  <h2 style="color:green"><label class="pull-right" for="kembali">Rp. 0</label></h2>                                      
                                  <input type="hidden" class="form-control" name="kembali" id="kembali" readonly/>
                              </div>                                                                                      
                              </div>                                                               
                            </div>
                            <div class="row" id="form2" style="display:none">
                              <div class="col-md-6">  
                                <div class="form-group">
                                  <label>Grand Total(Rp)</label>
                                  <input type="text" readonly name="nominal" id="nominal2" class=" form-control" onkeyup="kredit();"/>
                                  <input type="hidden" class="form-control" name="tipe2" value="KREDIT" id="tipe" readonly/>
                                </div> 
                                <div class="form-group">
                                  <label>Kredit</label>
                                  <input type="number" class="form-control" name="credit" id="credit" onkeyup="kredit();"/>
                              </div>                                   
                              </div> 
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Keterangan</label>
                                  <textarea name="ket2" id="ket" style=" min-width:150px; max-width:100%;min-height:75px;height:100%;width:100%;"></textarea>
                                </div>
                                <div class="form-group">
                                  <label>Kekurangan</label>
                                  <h2 style="color:red"><label class="pull-right" for="kekurangan">Rp. 0</label></h2>                                      
                                  <input type="hidden" class="form-control" name="kekurangan" id="kekurangan" readonly/>
                                </div>
                              </div>                                                      
                            </div>
                                                        
                          </div>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                <input type="hidden" name="button_action" id="button_action" value="insert" />                
                <input type="submit" id="action" value="Simpan" class="btn btn-info" />
              </div>
        </div>
      </div>