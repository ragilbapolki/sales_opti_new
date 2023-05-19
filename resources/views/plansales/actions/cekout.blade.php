@extends('layouts.master')

@section('title','CDI | CekOut Plan')

@section('content')
    <section class="content">
      <div class="modal fade" id="modal-cekout" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Klik tombol CheckOut bila berada ditempat berikut</h5>
            </div>
            <form class="form-horizontal" role="form" id="formIDe" action="{{ route('plan_cekout') }}" method="POST">
            	{{ csrf_field() }}
            <div class="modal-body ">
                <strong><i class="fa fa-book margin-r-5"></i> Customer</strong>
                <p class="text-muted">
                  <label id="customer2">{{ $nama }}</label>
                </p>
                <hr>
                <strong><i class="fa fa-folder-o margin-r-5"></i> Keperluan</strong>
                <p class="text-muted"> 
                  <label id="deskripsicust">{{ $keperluan }}</label>
                </p>
                <hr>
                <strong><i class="fa fa-edit margin-r-5"></i> Hasil Kunjungan*</strong>
                <p class="text-muted"> 
                  <textarea name="hasil" id="hasil" class="form-control" rows="3" placeholder="Silahkan tulis hasil dari kunjungan yang telah dilakukan" required=""></textarea>
                </p>
                @if ($errors->has('hasil'))
                    <span class="help-block">
                        <strong>{{ $errors->first('hasil') }}</strong>
                    </span>
                @endif
            </div>
            <div class="modal-footer">
              <input type="hidden" id='idplan' name="idplan" value="{{ $idplan }}">
              <input type="hidden" id='tgl' name="tgl" value="{{ $tgl }}">
              <input type="hidden" name="lat" id="latitude" value="">
              <input type="hidden" name="long" id="longitude" value="">
              <button type="submit" class="btn btn-primary" id="btnChekOut">CheckOut</button>
              <a href="{{ url()->previous() }}" class="btn btn-default pull-left"> Batal</a>
              <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button> -->
            </div>
            </form>
          </div>
        </div>
      </div>
      @include('panel.buttonbackplan')
    </section>
@endsection

@section('page-script')

<script>
  $(document).ready(function(){
      var x = document.getElementById("demo");

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition,showError);
      } else { 
        x.innerHTML = "Maaf Browser tidak supported untuk Aplikasi ini";
      }

      function showPosition(position) {
        // x.innerHTML = "Latitude: " + position.coords.latitude + 
        // "<br>Longitude: " + position.coords.longitude;
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
      }

      function showError(error){
        switch(error.code) 
        {
          case error.PERMISSION_DENIED:
          x.innerHTML="<b>GPS DIBLOK BROSER ANDA,SILAHKAN AKTIFKAN ATAU HUB.IT."
          break;
          case error.POSITION_UNAVAILABLE:
          x.innerHTML="Location information is unavailable."
          break;
          case error.TIMEOUT:
          x.innerHTML="The request to get user location timed out."
          break;
          case error.UNKNOWN_ERROR:
          x.innerHTML="An unknown error occurred."
          break;
        }
      }
  });
</script>
<script>
  $(document).ready(function(){
    $('#modal-cekout').modal('show');
  });
</script>
@stop