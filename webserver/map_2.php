<?php

$con=mysqli_connect("localhost","root","");

	if (!$con)
	{
		die('connection error:'. mysqli_connect_error);
	}

	$connectdb=mysqli_select_db($con,'bustalk');

	$result = mysqli_query($con,"SELECT * FROM bus WHERE bus_id = 'A002'");

while ($row=mysqli_fetch_array($result))
{
?>
<?php 
		$latitude = $row['lat'];
		$logitude = $row['lng'];
?>	
<?php
}
?>


<html>
<head>
<meta charset=utf-8 />
<script src='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.js'></script>
<link href='https://api.mapbox.com/mapbox.js/v3.1.1/mapbox.css' rel='stylesheet' />
<style>
  body { margin:0; padding:0; }
  #map { position:absolute; top:0; bottom:0; width:100%; } 
</style>
<meta http-equiv="refresh"content="2">           
</head>
<body>
	<div id="map"></div>
	<script>
	    var latitude = <?php echo $latitude; ?>;
		var longitude = <?php echo $logitude; ?>;
		
		console.log(latitude);
		console.log(longitude);
		
		L.mapbox.accessToken = 'pk.eyJ1Ijoia3NydW1ibGUiLCJhIjoiY2pscW1qNWZ4MHNkczNxbnZyYW54eHRsNCJ9.8fI188HV4CmtuFJ3gsdwyQ';
		var map = L.mapbox.map('map', 'mapbox.streets')
		.setView([latitude, longitude], 100);
		
		// L.marker is a low-level marker constructor in Leaflet.
		L.marker([latitude,longitude], {
		icon: L.mapbox.marker.icon({
		'marker-size': 'large',
		'marker-symbol': 'bus',
		'marker-color': '#fa0'
			})
		}).addTo(map);
		
	</script>

</body>
</html>