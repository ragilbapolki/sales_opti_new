  {{-- <div class="row"> --}}
  {{-- <div class="col-sm-12"> --}}
  <div class="box box-info none" id="panelbox">
      <!-- form start -->
      <form class="form-horizontal" method="POST" role="form" id="formIDe">
          <div class="box-body none" id="noMember">
              <div class="form-group">
                  <label>Masukan Kode Barang</label>
                  {{-- <div class="col-xs-12"> --}}
                  {{-- <input type="text" name="kdbarang" id="kdbarang" class="form-control input-sm" placeholder="Kode Barang..."> --}}
                  <select name="kdbarang" id="kdbarang" class="js-example-basic-single w-100" required>
                      <option value="">Kode Barang</option>
                  </select>

              </div>
          </div>
          {{-- </div> --}}
          <div class="box-body none" id="Other">
              <div class="form-group" style="display:;" id="barisNama">
                  <div class="col-xs-10 "><label for="inputsm">Masukan Nama Barang</label></div>
                  <div class="col-xs-12">
                      {{-- <input type="text" name="namabarang" id="namabarang" class="form-control input-sm" placeholder="Nama Barang..."> --}}
                      <select name="namabarang" id="namabarang" class="form-control select2" required="">
                          <option value="">Nama Barang</option>
                      </select>
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-xs-12">
                      <select name="suplier" id="pilih" class="form-control input-sm" style="width: 100%">
                          <option selected value="">ALL Suplier</option>
                          @foreach ($items as $item)
                              <option value="{{ $item->id_mitra }}">{{ $item->nama_perusahaan }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>

          <div class="box-body none" id="produsen">
              <div class="form-group">
                  <div class="col-xs-12"><label for="inputsm">Pilih Suplier</label></div>
                  <div class="col-xs-12">
                      <select name="produsen" id="pilihprodusen" class="form-control input-sm" style="width: 100%">
                          <option selected value="">ALL Suplier</option>
                          @foreach ($items as $item)
                              <option value="{{ $item->id_mitra }}">{{ $item->nama_perusahaan }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>

          <br>

          <div class="box-footer" id="foter">
              <button type="submit" class="btn btn-outline-primary" name="cari" id="buttonIDe" onClick="">
                  <span class="fa fa-search" aria-hidden="true"></span> Cari
              </button>
          </div>

          <br>
      </form>
  </div>
  {{-- </div> --}}
  {{-- </div> --}}
  <div id="modal-loader" style="display: none; text-align: center;">
      Loading...
  </div>
