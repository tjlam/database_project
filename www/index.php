<!-- <?php
  include_once 'accesscontrol.php';
?> -->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="main.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
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
      <div class="jumbotron">
        <h1 class="display-3">    <?php
            echo "Welcome " , $username;
            ?></h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <p class="lead">
          <form id="location" class="location" action="nearby.php" method="post">
            <input id="long" type="hidden" name="longitude" value="">
            <input id="lat" type="hidden" name="latitude" value="">
            <input type="submit" value="Find me a washroom">
          </form>
        </p>
      </div>
    </div>

  </body>
</html>
