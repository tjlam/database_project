<?php include_once 'accesscontrol.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add Washroom - Yelp for Washrooms</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </head>
  <body>
    <script type="text/javascript">
      getLocation();
      // hide html elements until location is found
      window.onload = function () {
        document.getElementById("all").style.display = "none";
      }
      // get long and lat
      function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
      }
      // populate hidden input elements
      function showPosition(position) {
        var lo = document.getElementById('long');
        var la = document.getElementById('lat');
        // location has been calculated, show html elements
        document.getElementById("all").style.display = "block";
        lo.value = position.coords.latitude;
        la.value = position.coords.longitude;
      }
    </script>

    <div class = "col">
    <div class = "row justify-content-center">
    <div class="jumbotron">
      <center>
      <img src="https://vignette2.wikia.nocookie.net/tfbnebs/images/d/d5/Toilet.png/revision/latest?cb=20140712011831" height = 100px width = auto>
      <h1 class="display-3">ADD A WASHROOM</h1>
      </center>
      <hr class="my-4">
    <center>
    <table>
    <div id="all">
      <form id="washroom-form" action="addwashroom.php" method="post">
        <input id="long" type="hidden" name="longitude" value="">
        <input id="lat" type="hidden" name="latitude" value="">

      <tr>
          <td align = "right"><header>Building: </header></td>
          <td><input id="building" type="text" name="building" value=""></td>
      </tr>

      <tr>
        <td align = "right"><header>Room Number: </header></td>
        <td><input id="room-number" type="text" name="roomnum" value=""></td>
      </tr>

      <tr>
        <td align = "right"><header>Description: </header></td>
        <td><input id="description" type="text" name="description" value=""></td>
      </tr>

      <tr>
        <td align = "right"><header>Gender (M/F/U): </header></td>
        <td><input id="gender" type="text" name="gender" value=""></td>
      </tr>
      </table>
        <input type="submit" value="   Add Washroom   " />
      </form>

  </center>
    </div>
  </div>
</div>
</div>
  </body>
</html>
