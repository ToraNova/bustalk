<html>
<head>
	<title>This is a test</title>
</head>

<body>
	<p>Testing</p>
<?php
	$dbconn = mysqli_connect('localhost','root','');
	if(!$dbconn){
		echo('<p>Unable to connect to database</p>');
		exit();
	}
	if(!mysqli_select_db($dbconn,'bustalk_r1')){
		exit('<p>Database not found!</p>');
	}else{
		echo('<p>Database connection successful</p>');
	}
?>
<br>
<?php
	if(isset($_GET['push'])):
	echo('<p>Push detected</p>');
	
	
	if(isset($_GET['lat']) and isset($_GET['busid']) ){
		//echo '<p>busid = '. htmlspecialchars($_GET['busid']);
		$insertion_query = 'UPDATE BUS SET latitude = '.($_GET['lat']).' WHERE BUSID = \''.$_GET['busid'] .'\'';
		echo ($insertion_query);
		if(!mysqli_query($dbconn,$insertion_query)){
				echo ('<p>SQL error</p>');
		}
		else{
				echo ('<p> OK </p>');
		}
	}
?>

<?php else:
	echo('<p>Pull detected</p>');
	
	endif;
?>
</body>
</html>