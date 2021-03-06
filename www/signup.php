<?php // signup.php

include("common.php");
include_once "connect.php";

if (!isset($_POST['submitok'])):
    // Display the user signup form
    // echo $_POST['submitok'];
    ?>
<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" type="text/css" href="main.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <title> Sign Up - Yelp for Washrooms </title>
  <meta http-equiv="Content-Type"
    content="text/html; charset=iso-8859-1
</head>
<body>
  <div class = "container">
  <div class = "row justify-content-center">
  <div class = "col-4">
  <div class="jumbotron">
    <center>
    <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
    <h1 class="display-3">SIGN UP</h1>
    </center>
    <hr class="my-4">
    <p class="lead">
      <center>
        <form method="post" action="">
        <table>

          <tr>
            <td align = "right"><header>Name:</header></td>
            <td><input name="newname" type="text" maxlength="25" size="15" />
            <font color="orangered" size="+1"><tt><b>*</b></tt></font>
          </td>
          </tr>

        <tr>
          <td align = "right"> <header>Username: </header></td>
          <td>
            <input name="newid" type="text" maxlength="12" size="15" />
            <font color="orangered" size="+1"><tt><b>*</b></tt></font>
        </td>
        </tr>

        <tr>
          <td align = "right"> <header>Password: </header></td>
          <td><input name="newpass" type="password" maxlength="10" size="15" />
          <font color="orangered" size="+1"><tt><b>*</b></tt></font></td>
        </tr>
      </table>
        <input type="submit" name="submitok" value="   Sign up!   " />
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
else:

    // Process signup submission
    //check if all fields are filled
    if ($_POST['newid']=='' or $_POST['newname']==''
      or $_POST['newpass']=='') {
        error('One or more required fields were left blank.\n'.
              'Please fill them in and try again.');
    }

    // Check for existing user with the new id
    $mysqli = get_mysqli_conn();
    $query = "SELECT COUNT(*) FROM users WHERE userid = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('s', $_POST['newid']);
    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt = NULL;
    // var_dump($result);

    if ($result) {
        error('A user already exists with your chosen userid.\\n'.
              'Please try another.');
    }
    // insert new user into database
    $query = "INSERT INTO `users` (userid, password, fullname)
              VALUES (?, ?, ?);
              ";

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sss', $_POST['newid'], $_POST['newpass'], $_POST['newname']);
    if (!$stmt->execute()) {
      error('A database error occurred in processing your '.
            'submission.\\nIf this error persists, please '.
            'contact you@example.com.\\n' . mysql_error());
    }
    //if insert is successfull display registration page
    ?>
    <!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <title> Registration Complete - Yelp for Washrooms</title>
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
        <h1 class="display-3">SIGN UP</h1>
        </center>
        <hr class="my-4">
    <p><strong>User registration successful!</strong></p>
    <p>To log in,
       click <a href="index.php">here</a> to return to the login
       page, and enter your username and password.</p>
     </div>
   </div>
 </div>
 </div>
    </body>
    </html>
    <?php
endif;
?>
