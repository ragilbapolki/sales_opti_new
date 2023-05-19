@extends('layouts.master')

@section('title','CDI | Plan')
<style>
  .none { display:none; },
  .showDIV { display:block; }
.box.box-pending {
  background: #ffffff;
  border-top-color: #dc3545;
}
.box.box-approve {
  background: #ffffff;
  border-top-color: #ffc107;
}
.box.box-cekin {
  background: #ffffff;
  border-top-color: #28a745;
}
.box.box-selesai {
  background: #ffffff;
  border-top-color: #130f40;
}
.box.box-selesaitanpaapprove {
  background: #ffffff;
  border-top-color: #800080;
}
.box.box-ditolak {
  background: #ffffff;
  border-top-color: blue;
}
hr.divider { 
  margin: 0em;
  border-width: 1px;
  padding: 3px;
} 
p {
  margin: 0;
  padding: 0; 
}
</style>
@section('content')

    <section class="content">
      <div class="row">
      	<div class="col-sm-12">
      		<h3>{{ $tanggal }} 
            <a class="btn btn-tumblr btn-sm" href="{{route('plan_per_tgl_sales2', ['id' => $days[0]['pre']])}}" role="button" title="{{ $days[0]['pre']}}" ><i class="fa fa-chevron-left"></i></a>
            <a class="btn btn-tumblr btn-sm" href="{{route('plan_per_tgl_sales2', ['id' => $days[0]['next']])}}" role="button" title="{{ $days[0]['next']}}"><i class="fa fa-chevron-right"></i></a>
          </h3>
      	</div>
        <div class="col-sm-12">
          <div class="alert alert-info">
            <p id="demo"></p>
          </div>
        </div>
        <div class="col-sm-12">
          @if (session('danger'))
            <div class="alert alert-danger">
            {{ session('danger') }}
            </div>
          @endif
       </div>


				@forelse ($responses as $response)
					<div class="col-sm-6">
						<div class="box {{ $response->colorbox }}">
							<div class="box-header with-border">
									<h5 class="box-title">status : {{ $response->status }}</h5>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
							</div>
							<div class="box-body">
                <strong class="text-muted"><i class="fa fa-book margin-r-5"></i> Customer</strong>
                <p >
                  <label>{{ $response->name }}</label>
                </p>
                <hr class="divider"/>
                <strong class="text-muted"><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                <p> 
                  <label>{{ $response->alamat }}</label>
                </p>
                <hr class="divider"/>
                @if ($response->status === 'Ditolak')
                  <strong class="text-muted"><i class="fa fa-folder-o margin-r-5"></i> Keperluan</strong>
                  <p> 
                    <label>{{ $response->tujuan }}</label>
                  </p>
                  <strong class="text-muted"><i class="fa fa-edit margin-r-5"></i> Alasan Tolak</strong>
                  <p class="text-muted"> 
                    <label>{{ $response->ket_tolak }}</label>
                  </p>
                @elseif ($response->status === 'Selesai')
                  <strong class="text-muted"><i class="fa fa-folder-o margin-r-5"></i> Keperluan</strong>
                  <p> 
                    <label>{{ $response->tujuan }}</label>
                  </p>
                  <strong class="text-muted"><i class="fa fa-edit margin-r-5"></i> Hasil Kunjungan</strong>
                  <p> 
                    <label>{{ $response->hasil }}</label>
                  </p>
                @else
                  <strong class="text-muted"><i class="fa fa-folder-o margin-r-5"></i> Keperluan</strong>
                  <p> 
                    <label>{{ $response->tujuan }}</label>
                  </p>
                @endif
							</div>
              <div class="box-footer {{ $response->footer }}">
                @if ($response->status === 'Pending')
                  <a href="{{ route('page_plan_cekin', [$response->idplan]) }}" class=" btn btn-sm bg-green"><i class="fa fa-play"></i> Cek Inn</a>
                  <!-- <button type="submit" class=" btn btn-sm bg-green" onclick="btncekin('{{ $response->idplan }}','{{ $response->name }}')"><i class="fa fa-play"></i> Cek Inn</button>  -->
                @elseif ($response->status === 'Approve')
                  <a href="{{ route('page_plan_cekin', [$response->idplan]) }}" class="btn btn-sm bg-green"><i class="fa fa-play"></i> Cek Inn</a>
                  <!-- <button type="submit" class=" btn btn-sm bg-green" onclick="btncekin('{{ $response->idplan }}','{{ $response->name }}')"><i class="fa fa-play"></i> Cek In</button>  -->
                @elseif ($response->status === 'CekIn')
                  <a href="{{ route('page_plan_cekout', [$response->idplan]) }}" class="btn btn-sm btn-warning"><i class="fa fa-stop"></i> Cek Out</a>               
                  <!-- <button type="submit" class=" btn btn-sm btn-warning" onclick="btncekout('{{ $response->idplan }}','{{ $response->name }}','{{ $response->tujuan }}')"><i class="fa fa-stop"></i> Cek Out</button>  -->
                  <button type="submit" class=" btn btn-sm btn-danger" onclick="btncancelcekin('{{ $response->idplan }}','{{ $response->name }}')"><i class="fa fa-close"></i> Cancel CekIn</button> 
                  <a href="{{ route('page_plan_pesan', [$response->idplan]) }}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-cart-arrow-down"></i> Pemesanan</a>                     
                @else
                I don't have any records!
                @endif
              </div>
						</div>
					</div>
				@empty
				  
				@endforelse
      </div>

      @include('plansales.partials.modal')
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
  function btncekin(id,name) {
    $('#modal-cekin').modal('show');
    $('#customer').html(name);
    document.getElementById('idplan').value =id;
  }
  function btncekout(id,name,deskripsi) {
    $('#modal-cekout').modal('show');
    $('#customer2').html(name);
    $('#deskripsicust').html(deskripsi);
    document.getElementById('idplan2').value =id;
  }
  function btncancelcekin(id,name) {
    $('#modal-batalcekin').modal('show');
    $('#customer3').html(name);
    document.getElementById('idplan3').value =id;
  }
</script>
<script>
  $("#btnChekIn").click(function(){
      var idplan = $('#idplan').attr("value");
      var a= $("#latitude").val();
      var b= $("#longitude").val();
      $.ajax({
        type: 'POST',
        url: '{{ route('plan_cekin') }}',
        data: {"_token": "{{ csrf_token() }}","id": idplan,"lat":a,"long":b},
        cache:false,
        success: function(response) {
          // console.log(response)
          $('#modal-cekin').modal('hide');
          location.reload();
          // $('#modal-cekin').modal('hide');
          // $('#dataplan').DataTable().ajax.reload();
        },
        error: function (request, status, error) {
            console.log(request.responseJSON.error);
            $('#modal-cekin').modal('hide');
            $('#modal-masihcekin').modal('show');
            document.getElementById("pesanerror").innerHTML = request.responseJSON.error;
            // $('#pesanerror').html(request.responseJSON.errors.password);
        }
      });
  });
  
  $('#btnChekOut').on('click', function(event) {
    var isvalidate = $("#formIDe")[0].checkValidity();
    if (isvalidate) {
      event.preventDefault();
      var datacekout = $('.form-horizontal').serialize();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        type: 'post',
        url: '{{ route('plan_cekout') }}',
        data: datacekout,
        cache:false,
        success: function(data) {
          $('#modal-cekout').modal('hide');
          location.reload();
          // $('#dataplan').DataTable().ajax.reload();
        }
      });
    }
  });
  $("#btnCancelChekIn").click(function(){
      var idplan3 = $('#idplan3').attr("value");
      $.ajax({
        type: 'POST',
        url: '{{ route('plan_cancel_cekin') }}',
        data: {"_token": "{{ csrf_token() }}","id": idplan3},
        cache:false,
        success: function() {
          // location.reload();
          $('#modal-batalcekin').modal('hide');
          location.reload();
        }
      });
  });
</script>
@stop