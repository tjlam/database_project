<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a</title>
  </head>
  <body>
    <?php
      include 'connect.php';
      $mysqli = get_mysqli_conn();

      // get washroom info from params
      $latitude = round($_POST['latitude'], 7);
      $longitude = round($_POST['longitude'], 7);
      $building = $_POST['building'];
      $room_num = $_POST['roomnum'];
      $description = $_POST['description'];
      $gender = $_POST['gender'];
      $rating = $_POST['rating'];
      $id = $building . $room_num;
      echo $id;

      // define new washroom object
      include 'washroomclass.php';
      $washroom = new Washroom($latitude, $longitude, $building, $room_num, $description, $gender, $rating);

      // var_dump($washroom);

      // add washroom to database
      $query = "
        INSERT INTO `washrooms` (id, latitude, longitude, building, room_num, description, gender, rating)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?);
      ";

      $stmt = $mysqli->prepare($query);

      $stmt->bind_param('sddssssi', $id, $latitude, $longitude, $building, $room_num, $description, $gender, $rating);

      if ($stmt->execute()) {
        echo 'successfully added washroom';
      } else {
        echo 'error occured';
      }
      $mysqli->close();
    ?>

    <a href="index.php"> Home </a>
  </body>
</html>
