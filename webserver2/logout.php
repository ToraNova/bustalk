<?php
$dbName="bustalk";
$con=mysqli_connect("localhost","root","");
	if (mysqli_connect_errno()){
		echo ('2'); //error
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){
		exit('<p>Database not found!:(</p>');
	}else{
		//do nothing here
	}

	if(isset($_GET['drvid']) and isset($_GET['busid']) ){
		$drvid = $_GET['drvid'];
		$busid = $_GET['busid'];
		$queryString = "select * from bus join driver on bus.bus_id = driver.bus_id where driver_id = '". $drvid . "' and bus.bus_id = '" . $busid . "'";
		$result = mysqli_query($con,$queryString);
		$rowcount = mysqli_num_rows($result);
		if( $rowcount == 1 ){
			echo ('0');
		}
		else{
			echo ('1');
		}
	}else{
		echo ('2');
	}
	mysqli_close($con);
	//http://localhost/verify.php?busid=000&drvid=1234567890
?>
