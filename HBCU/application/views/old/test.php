<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      .map {
        height: 50%;
        width: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <?php
for ($i=0; $i < 4; $i++) { 
?>
    <div class="map" id="map<?php echo $i; ?>"></div>
<?php }
    ?>
    <script>
      var points = [];
      var label='Source';
      var label1='destination';
      var directionsDisplay;
      var directionsService;

      function initMap() {
        for (var i = 0; i < 4; i++) {
          var myLatLng = {lat: -25.363+(i*10), lng: 131.044+(i*10)};
          var map = new google.maps.Map(document.getElementById('map'+i), {
            zoom: 4,
            center: myLatLng
          });

          directionsDisplay = new google.maps.DirectionsRenderer();
          directionsService = new google.maps.DirectionsService();
          directionsDisplay.setMap(map);
          var infoWindow = new google.maps.InfoWindow;

          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
          });
        };
      }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACSueOTI5iEZBVIu-G7ROeW2DiQn8tVGw&callback=initMap">
    </script>
  </body>
</html>