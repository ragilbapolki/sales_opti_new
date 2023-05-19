@extends('layouts.master')

@section('title','CDI | Account')

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        @if(session()->has('message'))
          <div class="col-sm-12">
            <div class="alert alert-success">
              {{ session()->get('message') }}
            </div> 
          </div>
        @endif

        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Account Info</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form class="form-horizontal" method="POST" action="{{ route('editaccount') }}">
                    {{ csrf_field() }}
                      <div class="box-body">
                          <div class="form-group">
                              <label class="col-sm-3 control-label">Nama*</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="{{ Auth::user()->name }}" onKeyUp="caps(this)" autocomplete="off" required >
                                  @if ($errors->has('name'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label">WA / Hp *</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" id="hp" name="hp" maxlength="12" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off" placeholder="harus diisi" value="{{Auth::user()->hp}}" required="" pattern=".{10,12}">

                              @if ($errors->has('hp'))
                              <span class="help-block">
                                <strong>{{ $errors->first('hp') }}</strong>
                              </span>
                              @endif

                            </div>
                          </div>
                      </div>
                      <div class="box-footer">
                        <button type="submit" class="col-sm-3 col-sm-offset-5 btn btn-tumblr" >Update</button> 
                      </div>
                  </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form class="form-horizontal" method="POST" action="{{ route('editpassword') }}">
                    {{ csrf_field() }}
                      <div class="box-body">
                          <div class="form-group">
                              <label class="col-sm-4 control-label">New Password*</label>

                              <div class="col-sm-8">
                                  <input type="text" class="form-control" name="password" placeholder="Min 5 karakter" onKeyUp="caps(this)" autocomplete="off" required>
                                  @if ($errors->has('password'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="password-confirm" class="col-sm-4 control-label">Retype Password*</label>

                              <div class="col-sm-8">
                                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" onKeyUp="caps(this)" required>
                              </div>
                          </div>
                      </div>
                      <div class="box-footer">
                        <button type="submit" class="col-sm-3 col-sm-offset-5 btn btn-tumblr">Simpan</button> 
                      </div>
                  </form>
                </div>
            </div>
        </div>

        @if (Auth::user()->role_id == 1 OR Auth::user()->role_id == 4)
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Cabang</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form class="form-horizontal" method="POST" action="{{ route('super_editcabang') }}">
                    {{ csrf_field() }}
                      <div class="box-body">
<!--                           <div class="form-group">
                              <label class="col-sm-4 control-label">Cabang</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control" id="cabang" name="cabang" placeholder="Nama" value="{{ Auth::user()->kode_cabang }}" onKeyUp="caps(this)" autocomplete="off" required >
                              </div>
                          </div> -->
                          <div class="form-group">
                              <label class="col-sm-4 control-label">Cabang</label>
                              <div class="col-sm-8">
                                  <input type="text" class="form-control" id="cabangnew" name="cabang" value="{{ Auth::user()->kode_cabang }}" onKeyUp="caps(this)" autocomplete="off" required="">
                                  @if ($errors->has('cabang'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('cabang') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                      </div>
                      <div class="box-footer">
                        <button type="submit" class="col-sm-3 col-sm-offset-5 btn btn-tumblr">Simpan</button> 
                      </div>
                  </form>
                </div>
            </div>
        </div>
        @endif
      </div>

      @include('panel.buttonhome')
    </section>
    <!-- /.content -->
@endsection

@section('page-script')
<script>
  $(document).ready(function () {
    $('.datasales').addClass('active');
  });
</script>
<script>
  caps = function(element) {
    element.value = element.value.toLowerCase();
  }
</script>
@stop