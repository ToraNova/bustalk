<?php
$dbName="bustalk";
$con=mysqli_connect("localhost","root","");								//Establish connection with server
	if (mysqli_connect_errno()){									//If cannot connect to database display error
		echo ('9.9'); //error
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){								//If database not found display error 
		exit('<p>Database not found!:(</p>');
	}else{
	}
?>
<?php													//Get driver rating from server through driver ID
	if(isset($_GET['drvid'])){
		$drvid = $_GET['drvid'];
		$queryString = "select avg(bus_rating) as rating from bus_rating join driver on bus_rating.bus_id = driver.bus_id
		where driver_id = " . $drvid . " group by driver.bus_id";
		$query_result = mysqli_query($con,$queryString);
		echo mysqli_fetch_array($query_result)['rating'];
	}
	mysqli_close($con);										//Close connection with server
	//http://localhost/get_rating.php?drvid=1234567890
?>