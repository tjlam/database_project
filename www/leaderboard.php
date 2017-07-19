<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Leaderboard - Yelp for Washrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    </head>
  <body>
    <div class = "row justify-content-center">
    <div class = "col-5">

    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">LEADERBOARD</h1>
      </center>
      <hr class="my-4">
      <center>
        <table>
    <?php
      include_once "connect.php";
      include_once "accesscontrol.php";

      $mysqli = get_mysqli_conn();

      $query = "SELECT userid, points FROM users ORDER BY points DESC";
      $stmt = $mysqli->prepare($query);
      $stmt->execute();
      $stmt->bind_result($user, $points);
      $x=1;

            while ($stmt->fetch()) {
          echo '<tr><td align ="left"><b>' . $x . ': </b>' . $user . '</td><td>&nbsp;&nbsp;&nbsp;&nbsp;<b>' . $points . '</b></td></tr>';
        $x=$x+1;
      }
    ?>
  </table>
  <hr class="my-4">

<a href = index.php><button type = "button">Home</button></a>
  </center>
  </div>
</div>
</div>
  </body>
</html>
