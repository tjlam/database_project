<?php include_once 'accesscontrol.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add New Washroom</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

    <div id="all">
      <form id="washroom-form" action="addwashroom.php" method="post">
        <input id="long" type="hidden" name="longitude" value="">
        <input id="lat" type="hidden" name="latitude" value="">
        <label for="building">Building</label>
        <input id="building" type="text" name="building" value="">
        <label for="room-number">Room Number</label>
        <input id="room-number" type="text" name="roomnum" value="">
        <label for="description">Describe the location</label>
        <input id="description" type="text" name="description" value="">
        <label for="gender">Gender (M/F/O)</label>
        <input id="gender" type="text" name="gender" value="">
        <input type="submit" value="Add Washroom">
      </form>
    </div>

  </body>
</html>
