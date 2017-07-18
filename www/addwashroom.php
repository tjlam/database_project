<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
  include_once 'washroomclass.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <title>Add Washroom - Yelp for Washrooms</title>
  </head>
  <body>
    <div class = "col">
    <div class = "row justify-content-center">
    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">ADD <br> WASHROOM</h1>
      </center>
      <hr class="my-4">

    <?php
      $mysqli = get_mysqli_conn();

      // get washroom info from params
      $latitude = round($_POST['latitude'], 7);
      $longitude = round($_POST['longitude'], 7);
      $building = $_POST['building'];
      $room_num = $_POST['roomnum'];
      $description = $_POST['description'];
      $gender = $_POST['gender'];
      $rating = NULL;
      if ($room_num == '') {
        $room_num = 0;
      }
      $id = $building . $room_num;

      // define new washroom object
      // $washroom = new Washroom($latitude, $longitude, $building, $room_num, $description, $gender);

      // var_dump($washroom);
      // Check if washroom has already been added
      $query = "SELECT COUNT(*) FROM washrooms WHERE id = ?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->bind_result($result);
      $stmt->fetch();
      $stmt = NULL;

      if ($result) {
        echo "Washroom has already been added";
      }
      else
      {
        // add washroom to database
        $query = "
          INSERT INTO `washrooms` (id, latitude, longitude, building, room_num, description, gender)
          VALUES (?, ?, ?, ?, ?, ?, ?);
        ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sddssss', $id, $latitude, $longitude, $building, $room_num, $description, $gender);

        if ($stmt->execute()) {
          echo 'successfully added washroom';
          // give user +10 points for adding washroom
          $stmt = NULL;
          $query = "UPDATE users SET points = points + 10 WHERE id = ?";
          $stmt = $mysqli->prepare($query);
          $stmt->bind_param('i', $userid);
          $stmt->execute();
        } else {
          echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
      }

      $mysqli->close();
    ?>

    <h1><a href="index.php"> Return Home </a></h1>
  </div>
</div>
</div>
  </body>
</html>
