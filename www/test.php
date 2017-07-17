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
    <div id="map"></div>
    <script>

      var locations = [
        ['1802kng', '-80.5260442', '43.4791858'],
        ['305lester', '-80.5325125', '43.4713316']
      ];
      function initMap() {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position, plotLocation) {
            var currPos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
      var plotLocation = function() {
        var map, infoWindow;
        map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(currPos.lat, currPos.lng),
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        infoWindow = new google.maps.InfoWindow;

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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJCIwyI8OK5-gWujsqqNHk6fVktg5PBzg&callback=initMap">
    </script>
  </body>
</html>
