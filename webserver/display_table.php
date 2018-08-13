<! Display all the rows in the table on from the BUS table>

<?php
$dbName="bustalk_r1";
$tableName="bus";
$query="SELECT * FROM " . $tableName;
$con=mysqli_connect("localhost","root","");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){
		exit('<p>Database not found!:(</p>');
	}else{
		echo('<p>Database connection successful. Thank god finally!  (╯°□°）╯︵ ┻━┻) </p>');
	}
$result = mysqli_query($con,$query);
if (!$result) {                                      //jst to checkk is there any fcking error grrrrrrrrrrr
    printf("Error: %s\n", mysqli_error($con));       //helps alot! 
    exit();
}

echo "<table border='10'>
<tr>
<th>Bus_ID</th>   
<th>Latitude</th>
<th>Longitude</th>
<th>Action</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['bus_id'] . "</td>";
echo "<td>" . $row['lat'] . "</td>";
echo "<td>" . $row['lng'] . "</td>";
echo "<td><a href=map_test.php?lgn=" . $row['lng'] . "&lat=" . $row['lat'] . ">Track this bus</a></td>" ;
echo "</tr>";
}
echo "</table>";
mysqli_close($con);

?>

<html>

</html>

