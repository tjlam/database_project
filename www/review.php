<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reviews - Yelp for Washrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class = "col">
    <div class = "row justify-content-center">
    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">REVIEWS</h1>



    <?php
      $wid = $_POST['wid'];
      $mysqli = get_mysqli_conn();
?>

</center>
<hr class="my-4">
<center>
<?
      //retrieve info about the washroom
      $query = "
        SELECT id, latitude, longitude, building, room_num, description, gender, ROUND(AVG(rev.rating)) as avg_rtg
        FROM washrooms as wash
        LEFT JOIN reviews as rev
        on wash.id = rev.wid
        where id = ?;
      ";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('s', $wid);
      if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      $stmt->bind_result($w_id, $lat, $long, $building, $room_num, $description, $gender, $rating);
      $stmt->fetch();
      $stmt = NULL;

      if (!($rating == NULL)) {
        //print washroom info
        echo '<b>Building: </b>'. $building . '<br>' . '<b>Room Number: </b>' . $room_num . '<br>' . '<b>Description: </b>' . $description . '<br>' . '<b>Gender: </b>' . $gender . '<br>' . '<b>Average Rating: </b>' . $rating . "/5";
        echo '<br><br>';
        echo '<hr class="my-4">';
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
        while ($stmt->fetch()) {
          echo $timestamp ." | " . '<b>' . $user . '</b>' . " rated ". '<b>' . $rating . '/5 </b>' . '<br>' . $comment;
          echo '<br><hr class="my-3">';
        }
      } else {
        $rating = "No ratings yet";
        echo '<b>Building: </b>'. $building . '<br>' . '<b>Room Number: </b>' . $room_num . '<br>' . '<b>Description: </b>' . $description . '<br>' . '<b>Gender: </b>' . $gender . '<br>' . '<b>Average Rating: </b>' . $rating ;
        echo '<br><br>';
        echo '<hr class="my-4">';

        echo '<p><a href = "newreview.php">Be the first to add a review!</a></p>';
      }
    ?>
    <form class="add-review" action="newreview.php" method="post">
      <input type="hidden" name="wid" value=<?php echo $wid ?>>
      <input type="submit" value="Add a Review">
    </form>

  </body>
</html>
