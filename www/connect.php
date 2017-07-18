<?php
// Function to obtain mysqli connection.
  function get_mysqli_conn()
  {
    $dev_env = False;
    $prod_env = False;
    if (!$dev_env) { $prod_env = True; }
    if ($dev_env) {
      $dbhost = 'localhost:8889';
      $dbuser = 'root';
      $dbpassword = 'root';
      $dbname = 'testdb';
      $mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
    }
    if ($prod_env) {
      $url = parse_url("mysql://b125c08244761a:bc51fa78@us-cdbr-iron-east-03.cleardb.net/heroku_75c2aa09bc6052d?reconnect=true");
      $dbhost = $url["host"];
      $dbuser = $url["user"];
      $dbpassword = $url["pass"];
      $dbname = substr($url["path"], 1);
      $mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
    }
    if ($mysqli->connect_errno)
    {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
    }
    return $mysqli;
  }
?>
