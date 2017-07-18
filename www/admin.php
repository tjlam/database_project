<?php
  include_once "accesscontrol.php";
  include_once "connect.php";

  //only display page if user is an admin, admin login is admin, pass = 12345
  if ($username == "admin") {
    if (!isset($_POST['wid'])) {
    ?>
    <!-- form for selecting a washroom -->
    <form class="select-washroom" action="" method="post">
      <label for="washroom">Enter washroom id</label>
      <input id="washroom" type="text" name="wid" value="">
      <input type="submit" name="submit" value="submit">
    </form>
    <?php
    } else {
      // return reviews about washroom
      $mysqli = get_mysqli_conn();
      $wid = $_POST['wid'];
      $query = "
                SELECT usr.userid, review.rating, review.comment, review.timestamp, review.rid
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
      $stmt->bind_result($user, $rating, $comment, $timestamp, $rid);
      while ($stmt->fetch()) {
        echo $timestamp ." | " . $user  . " rated " . $rating . '/5 ' . $comment . '<br>';
        ?>
        <form class="delete" action="delete.php" method="post">
          <input type="hidden" name="rid" value="<?php echo $rid ?>">
          <input type="hidden" name="wid" value="<?php echo $wid ?>">
          <input type="submit" name="" value="Delete">
        </form>
        <?php
      }
    }
    ?>
    <?php
  } else {
    echo "This page is only available for admin users";
  }
?>
