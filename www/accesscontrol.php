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
    <title> Please Log In for Access </title>
    <meta http-equiv="Content-Type"
      content="text/html; charset=iso-8859-1" />
  </head>
  <body>
  <h1> Login Required </h1>
  <p>You must log in to access this area of the site. If you are
     not a registered user, <a href="signup.php">click here</a>
     to sign up for instant access!</p>
  <p><form method="post" action="">
    User ID: <input type="text" name="uid" size="8" /><br />
    Password: <input type="password" name="pwd" SIZE="8" /><br />
    <input type="submit" value="Log in" />
  </form></p>
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
