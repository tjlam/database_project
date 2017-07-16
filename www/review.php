<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Washroom Reviews</title>
  </head>
  <body>
    <?php
      $wid = $_POST['wid'];
      $mysqli = get_mysqli_conn();

      //print info about the washroom
      echo "washroom: ";
      $query = "SELECT * FROM `washrooms` WHERE id = ?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('s', $wid);
      if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->bind_result($w_id, $lat, $long, $building, $room_num, $description, $gender);
      $stmt->fetch();
      $stmt = NULL;
      echo $building . " " . $room_num . " " . $description . " " . $gender . " " . $rating;
      echo '<br>';
      //retrieve reviews of washroom
      $query = "
                SELECT usr.userid, review.rating, review.comment, review.timestamp
                FROM reviews as review
                INNER JOIN users as usr
                ON usr.ID = review.uid
                WHERE review.wid = ?
                ORDER BY review.timestamp DESC ;
              ";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('s', $wid);
      if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->bind_result($user, $rating, $comment, $timestamp);
      //print review of washroom
      echo "reviews: " . '<br>';
      while ($stmt->fetch()) {
        echo $user . $rating . $comment . $timestamp;
        echo '<br>';
      }

    ?>
    <form class="add-review" action="newreview.php" method="post">
      <input type="hidden" name="wid" value=<?php echo $wid ?>>
      <input type="submit" value="add a review">
    </form>

  </body>
</html>
