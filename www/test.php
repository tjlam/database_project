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
    <?php
      include_once 'connect.php';

      $mysqli = get_mysqli_conn();

      $query = "SELECT id, latitude, longitude FROM washrooms";
      $stmt = $mysqli->prepare($query);
      $stmt->execute();
      $stmt->bind_result($wid, $latitude, $longitude);
      $locations = array();
      while ($stmt->fetch()) {
        array_push($locations, (array($wid, $latitude, $longitude)));
      }
      $myJSON = json_encode($locations);
      // var_dump($myJSON);
    ?>

    <script>
      var lat,lng;
      // Try HTML5 geolocation.
      getLocation();
      function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;
        console.log(lat);
        console.log(lng);
        plotLocation();
      }

      var plotLocation = function() {
        //import php locations array
        var locations = JSON.parse('<?php echo $myJSON ;?>');
        //create map
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: new google.maps.LatLng(lat, lng),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        //populate map
        var marker, i;

        for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][2], locations[i][1]),
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
