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
      $query = "
        SELECT *, ROUND(AVG(rev.rating)) as avg_rtg
        FROM washrooms as wash
        LEFT JOIN reviews as rev
        on wash.id = rev.wid
        group by wash.id;
      ";

      $results = $mysqli->query($query);

      while ($row = $results->fetch_assoc()) {
        // echo 'in loop';
        $washroom = new Washroom(
          $row['latitude'],
          $row['longitude'],
          $row['building'],
          $row['room_num'],
          $row['description'],
          $row['gender'],
          $row['avg_rtg']
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

    <a href="newwashroom.php"> Add a washroom </a>
  </div>
  </div>
  </div>
  </div>
  </body>
</html>
