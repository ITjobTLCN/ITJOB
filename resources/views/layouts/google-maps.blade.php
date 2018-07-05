<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <base href="{{asset('')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="favicon.png"/>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/comming-soon.css">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
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
    <div id="map"></div>

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/angular.min.js"></script>
    <script src="assets/angularjs/app.js"></script>
    <script src="assets/angularjs/controller/HomeController.js"></script>
    <script>
      function initMap(a, b) {
        var myLatLng = {lat: 10.8551339, lng: 106.7687899};

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Hello World!'
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9sAaN1DEbCDWLCHJuJ7XKKaOjYy9puUk&callback=initMap"
    async defer></script>
  </body>
</html>