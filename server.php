<html>
<head>
	<title>Test Server</title>
</head>

<body>
	<p>Welcome to Webserver</p>
<?php
	$link = mysqli_connect('localhost','root','');
	if(!$link){
		echo('<p>Unable to connect to database</p>');
		exit();
	}
	if(!mysqli_select_db($link,'bustalk')){
		exit('<p>Database not found!!!!!!!!!!  :(</p>');
	}else{
		echo('<p>Database connection successful. Thank god finally!  (╯°□°）╯︵ ┻━┻) </p>');
	}
?>
<br>
<?php
	if(isset($_GET['push'])):
	echo('<p>Push detected</p>');
	
	
	if(isset($_GET['lat']) and isset($_GET['lng']) and isset($_GET['bus_id']) ){
		
		$SQL = 'UPDATE bus SET lat = '.($_GET['lat']).', lng = '.($_GET['lng']).'  WHERE bus_id = \''.$_GET['bus_id'] .'\'';
		$str = <<<EOD
			The SQL comment is </br>
			$SQL</br></br>
EOD;
		echo $str;
		if(!mysqli_query($link,$SQL)){       
				echo ('<p>SQL error</p>');
		}
		else{
				echo ('<p> Update has been sucessfully executed </p>');
		}	
	}
?>

<?php else:
	echo('<p>Pull detected<	/p>');	
	endif;
?>
</body>
</html>
