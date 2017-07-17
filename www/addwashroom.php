<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
  include_once 'washroomclass.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a</title>
  </head>
  <body>
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

    <a href="index.php"> Home </a>
  </body>
</html>
