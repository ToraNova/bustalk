<?php
$con=mysqli_connect("localhost","root","");

	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	if(!mysqli_select_db($con,'bustalk')){
		exit('<p>Database not found!:(</p>');
	}else{
		echo('<p>Database connection successful. Thank god finally!  (╯°□°）╯︵ ┻━┻) </p>');
	}
	
$result = mysqli_query($con,"SELECT * FROM bus");

if (!$result) {                                      //jst to checkk is there any fcking error grrrrrrrrrrr
    printf("Error: %s\n", mysqli_error($con));       //helps alot! 
    exit();
}

echo "<table border='10'>
<tr>
<th>Bus_ID</th>   
<th>Latitude</th>
<th>Longitude</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['bus_id'] . "</td>";
echo "<td>" . $row['lat'] . "</td>";
echo "<td>" . $row['lng'] . "</td>";
echo "</tr>";
}
echo "</table>";


mysqli_close($con);


?>
<html>
<br>
<a href="mapA001.php">location for A001</a><br>
<a href="mapA002.php">location for A002</a><br>
<a href="mapA003.php">location for A003</a><br>
</html>

