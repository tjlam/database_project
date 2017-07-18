<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
  include_once 'washroomclass.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nearby - Yelp for Washrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- YO KEVIN! this is styling for the map. make it look nice lol  -->
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
    <div class = "col">
    <div class = "row justify-content-center">
    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">NEARBY</h1>
      </center>
      <hr class="my-4">
    <?php
      $currentLat = NULL;
      $currentLong = NULL;
      if(isset($_POST['latitude'])) {
        $currentLat = $_POST['latitude'];
        $currentLong = $_POST['longitude'];
        $gdr = $_POST['gender'];
      }
      ?>
      <? echo "Your longitude: " . $currentLong . '<br>';
      echo "Your latitude: " . $currentLat;
      ?>
      <hr class="my-4">


      <!-- function calculates distance given two lat, long -->

      <?php function getDistance($lat1, $long1, $lat2, $long2) {
        $y1 = deg2rad($long1);
        $y2 = deg2rad($long2);
        $x1 = deg2rad($lat1);
        $x2 = deg2rad($lat2);
        $x = ($x2-$x1)*cos(($y1+$y2)/2);
        $y = $y2-$y1;
        $R = 6371;
        $distance = $R*(sqrt(pow($x,2) + pow($y,2)));
        return round(1000*$distance);
      }
      // list all washrooms in the washrooms database in closest to farthest order
      $mysqli = get_mysqli_conn();
      $washrooms = array();
      // retrieve washrooms
      $query = "
        SELECT wash.id, wash.latitude, wash.longitude, wash.building, wash.room_num,
        wash.description, wash.gender, ROUND(AVG(rev.rating)) as avg_rtg
        FROM washrooms as wash
        LEFT JOIN reviews as rev
        on wash.id = rev.wid
        GROUP BY wash.id
        HAVING gender = ?
        LIMIT 10;
      ";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('s', $gdr);
      $stmt->execute();
      $stmt->bind_result($id, $lat, $lng, $bld, $room, $desc, $gdr, $rtg);
      //array stores the location data to be used by google maps
      $locations = array();
      //loop through results and create washroom object
      while ($stmt->fetch()) {
        $washroom = new Washroom($lat, $lng, $bld, $room, $desc, $gdr, $rtg );
        // var_dump($washroom);
        //calculate and set distance from current loc. to washroom
        $washroom->distance = getDistance(
          $currentLat,
          $currentLong,
          $lat,
          $lng
        );
        // echo $washroom->distance;
        $washrooms[] = $washroom;
        // add to locations array
        array_push($locations, (array($id, $lat, $lng)));
      }
      //convert locations array to json
      $myJSON = json_encode($locations);
      // var_dump($myJSON);
      // function compares two washroom objects by distance
      function cmpDistance ($a, $b) {
        return ($a->distance) - ($b->distance);
      }
      //sort washrooms array by distance
      usort($washrooms, "cmpDistance");
      // var_dump($washrooms);
      // print out all washrooms
      foreach ($washrooms as $w) {
        echo  $w->print_washroom();
        ?>
        <form class="see-reviews" action="review.php" method="post">
          <input type="hidden" name="wid" value=<?php echo $w->id ?>>
          <center><input type="submit" value="See Reviews"></center>
        </form>
        <hr class="my-4">
        <?php
      }

      $mysqli->close();
    ?>

    <center><a href="newwashroom.php"> Add a washroom </a></center>
  </div>
  </div>
  </div>
  </div>
  <div id="map"></div>

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
      //mark current location
      var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
      var currMark = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        icon: image
      });
      //populate the map
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
