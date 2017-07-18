<?php
  include_once 'accesscontrol.php';
  include_once 'connect.php';
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add Review - Yelp for Washrooms</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </head>
  <body>
    <div class = "col">
    <div class = "row justify-content-center">
    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">ADD REVIEW</h1>


    <?php
      $wid = $_POST['wid'];
      //display form if no rating,comment has been posted
      if (!(isset($_POST['rating']) and isset($_POST['comment']))) {
        echo "Washroom: " . $wid;
     ?>

     <hr class="my-4">
  </center>

       <form id="review" class="review" action="" method="post">
         <input type="hidden" name="wid" value=<?php echo $wid ?>>
         <table>
         <tr>
         <td align = "right"><header><center>Rating (out of 5): </center></header>
       </td>
       <td>
         <input id="rating" type="number" name="rating" value="">
       </td>
       </tr>
       <tr>
         <td align = "right"> <header><center>Comments:</center></header></td>
       <td>
         <textarea id="comment" name="comment" form="review" rows="2" cols="23"></textarea>
       </td>
       </tr>
      </table>
      <br>
         <center>
           <input type="submit" value="  Submit  "><br>
           <hr class="my-4">

         <a href = index.php><button type = "button">Home</button></a>
       </center>
      </form>



     <?php
      }
      //add review to database
      else
      {
        echo '<hr class="my-4">';
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
          echo "Successfully added review!";
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
        <center><br><a href="index.php">Return Home</a></center>
        <?php
      }
     ?>
   </div>
 </div>
 </div>
  </body>
</html>
