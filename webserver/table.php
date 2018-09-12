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
<th>Driver_ID</th>
<th>Bus_ID</th>   
<th>Latitude</th>
<th>Longitude</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['driver_id'] . "</td>";
echo "<td>" . $row['bus_id'] . "</td>";
echo "<td>" . $row['lat'] . "</td>";
echo "<td>" . $row['lng'] . "</td>";
echo "</tr>";
}
echo "</table>";


mysqli_close($con);


?>
<html>
<style>
.btn-group button {
    background-color: #4CAF50; 
    border: 1px solid green; 
    color: black; 
    padding: 10px 24px; 
    cursor: pointer; 
    width: 20%; 
    display: block; 
}

.btn-group button:not(:last-child) {
    border-bottom: none;
}


.btn-group button:hover {
    background-color: #3e8e41;
}
</style>
<body>

<h1>Location</h1>

<div class="btn-group">
  <button><a href="map_1.php">location for A001</button>
  <button><a href="map_2.php">location for A002</button>
  <button><a href="#">location for A003</button>
</div>

</body>
</html>

<html>
    <head>
        <title>Map Table</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="btn_group">
                <a href="map_2.php" class="btn_two">
                    <span>MAP for A002</span>
                    <div class="btn_bg"></div>
                </a>
                <a href="map_1.php" class="btn_one">MAP for A001</a>
            </div>
        </div>
    </body>
</html>



