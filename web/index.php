<?php
  include 'accesscontrol.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>YELP for Washrooms</title>
    <!-- jquery for ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </script>
  </head>
  <body>
    <script type="text/javascript">
      getLocation();
      window.onload = function () {
        document.getElementById("all").style.display = "none";
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
        document.getElementById("all").style.display = "block";
        lo.value = position.coords.latitude;
        la.value = position.coords.longitude;
      }
    </script>

    <div style= "display: block" id="all">
      <?php
        echo "Welcome " . $username;
      ?>
      <p>Click the button to find nearby washrooms.</p>

      <form id="location" class="location" action="nearby.php" method="post">
        <input id="long" type="hidden" name="longitude" value="">
        <input id="lat" type="hidden" name="latitude" value="">
        <input type="submit" value="Find me a washroom">
      </form>
    </div>
  </body>
</html>
