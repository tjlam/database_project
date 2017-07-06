<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nearby Washrooms</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      $currentLat = NULL;
      $currentLong = NULL;
      if(isset($_POST['latitude'])) {
        $currentLat = $_POST['latitude'];
        $currentLong = $_POST['longitude'];
      }
      echo "Your longitude is: " . $currentLong . " and your latitude is: " . $currentLat;
      echo '<br>' . "List of washrooms: " . '<br>';
      //function calculates distance given two lat, long
      function getDistance($lat1, $long1, $lat2, $long2) {
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
      include 'connect.php';
      $mysqli = get_mysqli_conn();
      include 'washroomclass.php';
      $washrooms = array();

      $results = $mysqli->query("SELECT * FROM `washrooms`");

      while ($row = $results->fetch_assoc()) {
        // echo 'in loop';
        $washroom = new Washroom(
          $row['latitude'],
          $row['longitude'],
          $row['building'],
          $row['room_num'],
          $row['description'],
          $row['gender'],
          $row['rating']
        );
        // var_dump($washroom);
        //calculate and set distance from current loc. to washroom
        $washroom->distance = getDistance(
          $currentLat,
          $currentLong,
          $row['latitude'],
          $row['longitude']
        );
        // echo $washroom->distance;
        $washrooms[] = $washroom;
      }
      // function compares two washroom objects by distance
      function cmpDistance ($a, $b) {
        return ($a->distance) - ($b->distance);
      }
      //sort washrooms array by distance
      usort($washrooms, "cmpDistance");
      // var_dump($washrooms);
      // print out all washrooms

      foreach ($washrooms as $w) {
        echo $w->print_washroom();
      }

      $mysqli->close();
    ?>
    <a href="newwashroom.php"> Add a washroom </a>

  </body>
</html>
