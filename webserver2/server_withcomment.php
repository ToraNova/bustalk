<!DOCTYPE html>
<html>
<head>
	<title>bustalk serverside api</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css">										<!--decarate the web server using CSS-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<?php
$dbName="bustalk";
$tableName="bus";
$query="SELECT * FROM " . $tableName;
$con=mysqli_connect("localhost","root","");			
	if (mysqli_connect_errno()){																//Connection to database. If there is an error, display error.																			
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){														//Inform the user when database is not connected				
		exit('<p>Database not found!:(</p>');
	}else{
		//echo('<p>Database connection successful. Thank god finally!  (╯°□°）╯︵ ┻━┻) </p>');
	}
$result = mysqli_query($con,$query);															//Displays the specific error. (Error 404)										
if (!$result) {									
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
?>

<?php
	if(isset($_GET['push'])):																	//Push bus latitude and longitude according to bus ID
	echo('<p>Push detected</p>');
	if(isset($_GET['lat']) and isset($_GET['lng']) and isset($_GET['bus_id']) ){				// Get data from the link provided
		$SQL = 'UPDATE bus SET lat = '.($_GET['lat']).', lng = '.($_GET['lng']).'  WHERE bus_id = \''.$_GET['bus_id'] .'\'';		//execute SQL "UPDATE bus SET lat = '',lng='',WHERE bus_id=''" in the localhost database
		echo $SQL;
		if(!mysqli_query($con,$SQL)){															//Check if push is successful
				echo ('<p>SQL error</p>');
		}
		else{
				echo ('<p> Update has been sucessfully executed </p>');
		}
	}
	mysqli_close($con);
?>

<?php else: ?>
<div class="row">
<br/>
<br/>
<br/>
</div>
<div class="row">
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
<?php
	echo('<p class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">Thank you for rating... Redirecting</p>');			// Display the rating part
	if(isset($_GET['bus_id']) and isset($_GET['rating']) and isset($_GET['ip']) ){ 									// Get data from the link provided				
		#select (case when (NOW()-rate_time > 3600) then 1 else 0 end) as allow from bus_rating where IPaddress = '127.0.0.1' order by rate_time desc limit 1;
		$chk = 'select (case when (NOW()-rate_time > 3600) then 1 else 0 end) as allow from bus_rating where IPaddress = \'' . $_GET['ip'] .'\' order by rate_time desc limit 1';
		$chkres = mysqli_query($con,$chk);
		$lastcheck = mysqli_fetch_array($chkres)['allow'];
		$rownum = mysqli_num_rows($chkres);
		if( $lastcheck == '1' or $rownum == 0){																		// Insert the rating of specific bus and the specific rating time into the database											
			$SQL = 'insert into bus_rating (bus_id, bus_rating, IPaddress, rate_time) values(\''.$_GET['bus_id'].'\','.$_GET['rating'].',\''.$_GET['ip'] .'\', NOW())';
			mysqli_query($con,$SQL);
		}
		else{
			#do nothing
		}
	}
	mysqli_close($con);
	header("Location: index.php");
	die();
	endif;
?>
</div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
</div>
</body>
</html>