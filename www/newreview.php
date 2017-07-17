<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a Review</title>
  </head>
  <body>
    <h1>Add a review to this washroom</h1>
    <?php
      $wid = $_POST['wid'];
      //display form if no rating,comment has been posted
      if (!(isset($_POST['rating']) and isset($_POST['comment']))) {
     ?>
       <form id="review" class="review" action="" method="post">
         <input type="hidden" name="wid" value=<?php echo $wid ?>>
         <label for="rating">Rating out of 5</label>
         <input id="rating" type="number" name="rating" value="">
         <label for="comment">Comments</label>
         <textarea id="comment" name="comment" form="review" rows="8" cols="80">
         </textarea>
         <input type="submit" value="submit review">
       </form>
     <?php
      }
      //add review to database
      else
      {
        $comment = $_POST['comment'];
        $rating = $_POST['rating'];
        $wid = $_POST['wid'];
        // echo $comment . $rating . $wid;
        $mysqli = get_mysqli_conn();
        $query = "INSERT INTO reviews (wid, uid, rating, comment)
                  VALUES (?, ?, ?, ?)
                ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('siis', $wid, $userid, $rating, $comment);
        if ($stmt->execute()) {
          echo "successfully added review";
          // add +5 points to user who added review
          $stmt = NULL;
          $query = "UPDATE users SET points = points + 5 WHERE id = ?";
          $stmt = $mysqli->prepare($query);
          $stmt->bind_param('i', $userid);
          $stmt->execute();
        } else {
          echo "error occured";
        }
        ?>
        <a href="index.php">Home</a>
        <?php
      }
     ?>

  </body>
</html>
