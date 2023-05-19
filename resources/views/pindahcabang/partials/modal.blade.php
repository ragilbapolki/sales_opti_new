      <!-- modal form input -->
    <div class="modal modal-default fade" id="modal-editstatus" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i id="jdlmodal"></i> <i> Update Customer</i></h4>
          </div>
          <form  class="form-horizontal" method="post" action="{{ route('updatecabang') }}">
            {!! Form::hidden('hidden_id', 3, ['id' => 'hidden_id']); !!}
          <div class="modal-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="nama" onKeyUp="caps(this)" autocomplete="off" placeholder="Nama" required="" oninput="this.value=this.value.replace(/[^\w\-\.\ ]/gi,'');">
                <input type="hidden"  name="regulerid" id="regulerid">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Alamat</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Kota</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="kota" name="kota" autocomplete="off" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Cabang</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="cabangnow" name="cabangnow" autocomplete="off" readonly="">
              </div>
            </div>
            <div class="form-group">

            </div>

                <div class="form-group">
                  <label for="inputsm" class="col-sm-5 control-label">Pindahkan Ke Cabang</label>
                  <div class="col-sm-7" >
                    <select name="tocabang" id="tocabang" class="form-control select2" style="width: 100%" required>
                      <option value="" selected disabled="">Pilih Cabang</option>
                      <option value="kosong">Hapus Cabang</option>
                      @foreach ($cabangs as $key => $val)
                      <option value="{{$val['kode']}}">{{$val['kode']}} - {{$val['alias']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

          </div>
          <div class="modal-footer">
              <button type="button"  class="col-md-3 col-sm-offset-3 btn btn-danger" data-dismiss="modal">Batal</button>
              <button type="submit" class="col-sm-3  btn btn-warning " id="tmbSuplier" >Simpan</button>  
          </div>
          </form>
        </div>
      </div>
    </div>