<?php
$dbName="bustalk";
$con=mysqli_connect("localhost","root","");
	if (mysqli_connect_errno()){								//Connection to database. If there is an error, display error.	
		echo ('2'); //error
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){						// Display if database bnot connected
		exit('<p>Database not found!:(</p>');
	}else{
		//do nothing here
	}
	if(isset($_GET['drvid']) and isset($_GET['busid']) ){		// GET data about the driver ID and the bus ID
		$drvQ = "select * from driver where driver_id = '". $_GET['drvid'] ."'";		
		$busQ = "select * from bus where bus_id = '" . $_GET['busid'] . "'";
		#$queryString = "select * from bus join driver on bus.bus_id = driver.bus_id where driver_id = '". $drvid . "' and bus.bus_id = '" . $busid . "'";
		$resultD = mysqli_query($con,$drvQ);
		$resultB = mysqli_query($con,$busQ);
		$rowcountB = mysqli_num_rows($resultB);
		$rowcountD = mysqli_num_rows($resultD);
		if( $rowcountB == 1 and $rowcountD == 1){
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