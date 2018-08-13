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
	<h3>Google Map Test demo</h3>
	<!--The div element for the map -->
	<div id="map"></div>
	<script>
		// Initialize and add the map
		function initMap() {
		var lat = <?php echo $_GET['lat']?>;
		var lng = <?php echo $_GET['lgn']?>;

		var targetLocation = {lat: lat, lng: lng};
		// The map, centered at ????????
		var map = new google.maps.Map(
		document.getElementById('map'), {zoom: 4, center: targetLocation});
		// The marker, positioned at ???????
		var marker = new google.maps.Marker({position: targetLocation, map: map});
		}
		</script>

		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCf2GeFMnnWZ2bPmmxfmFdmlcFwRv_3x_E&callback=initMap">
	</script>
</body>
</html>