                  //A simple example of how to display the google map
<html>
  <head>
    <style>
     
      #map {
        height: 400px; 
        width: 35%;  
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
	var lat = 31.1342;
	var lng = 121.2099;
  // The location of Uluru
  var uluru = {lat: lat, lng: lng};
  // The map, centered at ????????
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at ???????
  var marker = new google.maps.Marker({position: uluru, map: map});
}
    </script>
	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDESpQyuAaxxvJNeSrO10vsScxjZ2nObQo&callback=initMap">        // Google API = AIzaSyDESpQyuAaxxvJNeSrO10vsScxjZ2nObQo
    </script>
  </body>
</html>