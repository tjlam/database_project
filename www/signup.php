<?php // signup.php

include("common.php");
include("connect.php");

if (!isset($_POST['submitok'])):
    // Display the user signup form
    // echo 'kevin is a fegit';
    // echo $_POST['submitok'];
    ?>
<!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title> New User Registration </title>
  <meta http-equiv="Content-Type"
    content="text/html; charset=iso-8859-1
</head>
<body>

<h3>New User Registration Form</h3>
<p><font color="orangered" size="+1"><tt><b>*</b></tt></font>
   indicates a required field</p>
<form method="post" action="">
<table border="0" cellpadding="0" cellspacing="5">
    <tr>
        <td align="right">
            <p>Username</p>
        </td>
        <td>
            <input name="newid" type="text" maxlength="12" size="25" />
            <font color="orangered" size="+1"><tt><b>*</b></tt></font>
        </td>
    </tr>
    <tr>
        <td align="right">
            <p>Full Name</p>
        </td>
        <td>
            <input name="newname" type="text" maxlength="20" size="25" />
            <font color="orangered" size="+1"><tt><b>*</b></tt></font>
        </td>
    </tr>
    <tr>
        <td align="right">
            <p>Password</p>
        </td>
        <td>
            <input name="newpass" type="password" maxlength="10" size="25" />
            <font color="orangered" size="+1"><tt><b>*</b></tt></font>
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <hr noshade="noshade" />
            <input type="reset" value="Reset Form" />
            <input type="submit" name="submitok" value="   OK   " />
        </td>
    </tr>
</table>
</form>

</body>
</html>

    <?php
else:
    // print_r($_POST);
    $mysqli = get_mysqli_conn();
    // Process signup submission

    if ($_POST['newid']=='' or $_POST['newname']==''
      or $_POST['newpass']=='') {
        error('One or more required fields were left blank.\n'.
              'Please fill them in and try again.');
    }

    // Check for existing user with the new id
    // echo "start";
    $query = "SELECT COUNT(*) FROM users WHERE userid = ?;";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $_POST['newid']);
    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    $stmt->bind_result($result);
    $stmt = NULL;
    var_dump($result);

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
      <title> Registration Complete </title>
      <meta http-equiv="Content-Type"
        content="text/html; charset=iso-8859-1" />
    </head>
    <body>
    <p><strong>User registration successful!</strong></p>
    <p>Your userid and password have been emailed to
       <strong></strong>, the email address
       you just provided in your registration form. To log in,
       click <a href="index.php">here</a> to return to the login
       page, and enter your new personal userid and password.</p>
    </body>
    </html>
    <?php
endif;
?>
