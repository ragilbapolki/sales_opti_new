<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {
        height: 400px;
        width: 77%;
       }
    </style>
  </head>
  <body>
    <h3>Lokasi Saat Cek In</h3>
    <input type="hidden" id="lat" value="{{ $lokasi->latitude}}">
    <input type="hidden" id="long" value="{{ $lokasi->longitude}}">
    <div id="map"></div>
    <script>
      function initMap() {
      	var lati = parseFloat(document.getElementById("lat").value);
      	var long = parseFloat(document.getElementById("long").value);
      	console.log( lati);
      	console.log(typeof lati);
        var uluru = {lat: lati, lng: long};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: uluru,
          mapTypeControl: false,
          navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_68Kvygx1_oxmdYEhCMYcGWRfmWx8iZo&callback=initMap">
    </script>
  </body>
</html>