<?php
    include_once 'accesscontrol.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <!-- jquery for ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <title>YELP for Washrooms</title>
  </head>
  <body>

    <script type="text/javascript">

      function validateForm() {
        var gdr = document.getElementById("refine").value.toLowerCase();
        if (gdr == 'u' || gdr == 'f' || gdr == 'm') {
          return true;
        }
        alert("Please enter a gender");
        return true;
      }

      getLocation();
      window.onload = function () {
        document.getElementById("submit-btn").disabled = true;
      }

      function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        var lo = document.getElementById('long');
        var la = document.getElementById('lat');
        document.getElementById("submit-btn").disabled = false;
        lo.value = position.coords.latitude;
        la.value = position.coords.longitude;
      }
    </script>

    <div class = "col">
    <div class = "row justify-content-center">
    <div style= "display: block" id="all">
      <div class="jumbotron">
        <center><img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
        <h1 class="display-3">SEARCH</h1>

        <hr class="my-4">
        <h1 class="display-5">    <?php
            echo "Hi " , $username ;
            ?></h1>
        <p class="lead">


          <form id="location" class="location" action="nearby.php" onsubmit="return validateForm()" method="get">
            <input id="long" type="hidden" name="longitude" value="">
            <input id="lat" type="hidden" name="latitude" value="">
            <H5><label for="refine"> What washroom are you looking for?</label><br></h5>
             <p><b>M</b> - Male, <b>F</b> - Female, <b>U</b> - Unisex </p>
            <input id="refine" type="text" name="gender" value="" maxlength = 1 size = 1 text-center><br><br>
            <h4><input id="submit-btn" type="submit" name="submitok" value="Find a washroom!"></h4>
          </form>
          <hr class="my-4">
          <img src = "https://maxcdn.icons8.com/Share/icon/Sports//trophy1600.png" height =50px width = auto><br><br>
        <a href = leaderboard.php><button type = "button">Leaderboard</button></a>
        </center>
        </p>


      </div>
    </div>
  </div>
</div>

  </body>
</html>
