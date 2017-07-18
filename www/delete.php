<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';

  if ($username == "admin") {
    $wid = $_POST['wid'];
    $rid = $_POST['rid'];
    $mysqli = get_mysqli_conn();

    //delete reviews
    $query = "DELETE FROM reviews WHERE wid = ? and rid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $wid, $rid);
    if ($stmt->execute()) {
      echo "review successfully deleted";
    } else {
      echo "error deleting";
    }

  } else {
    echo "This page is only available for admin users";
  }
?>
<a href="admin.php"> back </a>
