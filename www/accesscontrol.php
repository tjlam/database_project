<?php // accesscontrol.php
include_once 'common.php';
include_once 'connect.php';

session_start();

$uid = isset($_POST['uid']) ? $_POST['uid'] : $_SESSION['uid'];
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : $_SESSION['pwd'];

if(!isset($uid)) {
  ?>

  <!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>

    <title> Login - Yelp for Washrooms </title>
    <meta http-equiv="Content-Type"
      content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </head>

  <body>
  <div class = "container">
  <div class = "row justify-content-center">
  <div class = "col-4">
  <div class="jumbotron">
    <center>
    <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
    <h1 class="display-3">LOGIN</h1>
    Are you new? <a href="signup.php">Sign up here!</a>
    </center>
    <hr class="my-4">
    <p class="lead">
      <center>
        <form method="post" action="">
        <table>
        <tr>
          <td align = "right"> <header>Username: </header></td>
          <td><input type="text" name="uid" size="8" /></td>
        </tr>

        <tr>
          <td align = "right"> <header>Password: </header></td>
          <td><input type="password" name="pwd" SIZE="8" /></td>
        </tr>
      </table>
        <input type="submit" value="Log in" />
      </center>
      </form>
    </p>
  </div>
   </div>
 </div>
  </div>
  </body>
  </html>
  <?php
  exit;
}

$_SESSION['uid'] = $uid;
$_SESSION['pwd'] = $pwd;
// var_dump($uid);
// var_dump($pwd);
$mysqli = get_mysqli_conn();

$query = "SELECT userid, ID FROM users WHERE
        userid = ? AND password = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ss', $uid, $pwd);

if (!($stmt->execute())) {
  echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
// $stmt->store_result();
$stmt->bind_result($uname, $id);
$stmt->fetch();
$stmt->close();
// var_dump($result);
// if (!$result) {
//   error('A database error occurred while checking your '.
//         'login details.\\nIf this error persists, please '.
//         'contact you@example.com.');
// }

if (!$uname) {
  unset($_SESSION['uid']);
  unset($_SESSION['pwd']);
  ?>
  <!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> Access Denied </title>
    <meta http-equiv="Content-Type"
      content="text/html; charset=iso-8859-1" />
  </head>
  <body>
  <h1> Access Denied </h1>
  <p>Your user ID or password is incorrect, or you are not a
     registered user on this site. To try logging in again, click
     <a href="<?=$_SERVER['PHP_SELF']?>">here</a>. To register for instant
     access, click <a href="signup.php">here</a>.</p>
  </body>
  </html>
  <?php
  exit;
}

$username = $uname;
$userid = $id;
?>
