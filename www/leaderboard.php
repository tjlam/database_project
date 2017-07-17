<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Leaderboard</title>
  </head>
  <body>
    <?php
      include_once "connect.php";
      include_once "accesscontrol.php";

      $mysqli = get_mysqli_conn();

      $query = "SELECT userid, points FROM users ORDER BY points DESC";
      $stmt = $mysqli->prepare($query);
      $stmt->execute();
      $stmt->bind_result($user, $points);

      while ($stmt->fetch()) {
        echo $user . " " . $points . '<br>';
      }
    ?>
  </body>
</html>
