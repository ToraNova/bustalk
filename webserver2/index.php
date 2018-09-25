<! Display all the rows in the table on from the BUS table>
<!DOCTYPE html>
<html>
<head>
<title>Bustalk</title>
<link rel="stylesheet" href="/static/bootstrap/css/bootstrap.css">
<style>
th, td {
    padding: 30px;
	text-align: centre;
}
</style>

</head>
<?php
$dbName="bustalk";
$tableName="bus";

$queryString = "select bus.bus_id,lat,lng,avg(bus_rating) as rating, route from bus_rating join bus on
bus_rating.bus_id = bus.bus_id group by bus.bus_id";
$con=mysqli_connect("localhost","root","");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){
		exit('<p>Database not found!:(</p>');
	}else{
		//echo('<p>Database connection successful. Thank god finally!  (╯°□°）╯︵ ┻━┻) </p>');
	}
?>



<body style="background-image:url('/static/img/clouds2.jpg')">
<div class="row">
<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
<img src="/static/img/altf4.png" alt="altf4 logo" style="width:200px;height:100px;padding:10px;">
</div>
</div>
<div class="row">
	<br/>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"></div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<h1 class="text-info bg-warning">Bustalk tracking system</h1>
	</div>
	<br/>
</div>
<div class="row">
	<div class="col-xs-0 col-sm-0 col-md-2 col-lg-2"></div>
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<div class="panel panel-default">
		<div class="panel-heading">Active Bus Listings</div>
		<div class="panel-body">
			<table class="table-hover table-striped ">
			<tr class="info">
			<th>Bus ID</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Rating</th>
			<th>Tracking</th>
			<th>Show route map</th>
			<th>Rate this bus</th>
			</tr><!TODO: rate this bus.>

			<?php
			$query_result = mysqli_query($con,$queryString);
			if (!$query_result) {                                      //jst to checkk is there any fcking error grrrrrrrrrrr
				printf("Error: %s\n", mysqli_error($con));       //helps alot!
				exit();
			}
			while($row = mysqli_fetch_array($query_result))
			{
			echo "<tr class=\"success\">";
			echo "<td>" . $row['bus_id'] . "</td>";
			echo "<td>" . $row['lat'] . "</td>";
			echo "<td>" . $row['lng'] . "</td>";
			echo "<td>" . $row['rating'] . "</td>"; //show rating
			echo "<td><a type=\"button\" class=\"btn btn-info col-xs-12 col-sm-12 col-md-12 col-lg-12\" href=tracker.php?bus_id=" . $row['bus_id'] .
			">Track this bus</a></td>" ; //show bus location
			echo "<td><a type=\"button\" class=\"btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12\" href=bustalk_routes/route_disp_" . $row['route'] . ".html >".
			$row['route'] ."</a></td>"; //show route map
			echo "<td><a type=\"button\" class=\"btn btn-warning col-xs-12 col-sm-12 col-md-12 col-lg-12\" href=ratebus.php?bus_id=" . $row['bus_id'] .
			">Rate this bus</a></td>" ; //rate the bus
			echo "</tr>";
			}
			mysqli_close($con);
			?>
			</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>
