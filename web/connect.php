<?php
// Function to obtain mysqli connection.
  function get_mysqli_conn()
  {
    $dev_env = False;
    $prod_env = True;
    if ($dev_env) {
      $dbhost = 'localhost:8889';
      $dbuser = 'root';
      $dbpassword = 'root';
      $dbname = 'testdb';
      $mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
    }
    if ($prod_env) {
      $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
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
