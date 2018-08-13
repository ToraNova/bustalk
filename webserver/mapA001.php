<?php

$con=mysqli_connect("localhost","root","");

	if (!$con)
	{
		die('connection error:'. mysqli_connect_error);
	}

	$connectdb=mysqli_select_db($con,'bustalk');

	$result = mysqli_query($con,"SELECT * FROM bus WHERE bus_id = 'A001'");

while ($row=mysqli_fetch_array($result))
{
?>
<?php 
		$latitude = $row['lat'];
		$logitude = $row['lng'];
?>	
	<?php echo $latitude; ?><br>
	<?php echo $logitude; ?>

<?php
}
?>
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
	<h1>Here i am : latitude is <?php echo $latitude; ?> </h1><br/> 
	<h1>Here i am : logitude is <?php echo $logitude; ?> </h1>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
	var lat = <?php $latitude ?>;                                      
	var lng = <?php $logitude ?>;
  // The location of Uluru
  var uluru = {lat: lat, lng: lng};
  // The map, centered at whereever
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at whereever
  var marker = new google.maps.Marker({position: uluru, map: map});
}
    </script>
	
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDESpQyuAaxxvJNeSrO10vsScxjZ2nObQo&callback=initMap">        // Google API = AIzaSyDESpQyuAaxxvJNeSrO10vsScxjZ2nObQo
    </script>
  </body>
</html>
