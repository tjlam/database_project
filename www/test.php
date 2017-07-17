<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>

    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 50%;
        width: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map" style="width: 500px; height: 400px;"></div>

    <script type="text/javascript">

      //use html5 to get location
      var lat,lng;
      getLocation();
      function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            // initMap();
        } else {
            alert("Geolocation is not supported by this browser.");
        }
      }
      function showPosition(position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;
        console.log(lat);
        initMap();
      }

      //create map
      function initMap() {
        var locations = [
          ['Bondi Beach', -33.890542, 151.274856],
          ['Coogee Beach', -33.923036, 151.259052],
          ['Cronulla Beach', -34.028249, 151.157507],
          ['Manly Beach', -33.80010128657071, 151.28747820854187],
          ['Maroubra Beach', -33.950198, 151.259302]
        ];
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: new google.maps.LatLng(-33.92, 151.25),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
          });

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }
      }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJCIwyI8OK5-gWujsqqNHk6fVktg5PBzg">
    </script>
  </body>
</html>
