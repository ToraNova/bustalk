<html lang="en" dir="ltr">
	<?php
	$dbName="bustalk";
	$con=mysqli_connect("localhost","root","");
	if (mysqli_connect_errno()){
		echo ('9.9'); //error
		//echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	if(!mysqli_select_db($con,$dbName)){
		exit('<p>Database not found!:(</p>');
	}else{

	}
	?>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
		<style>
		.star-rating {
		direction: rtl;
		display: inline-block;
		padding: 20px
		}

		.star-rating input[type=radio] {
		display: none
		}

		.star-rating label {
		color: #bbb;
		font-size: 18px;
		padding: 0;
		cursor: pointer;
		-webkit-transition: all .3s ease-in-out;
		transition: all .3s ease-in-out
		}

		.star-rating label:hover,
		.star-rating label:hover ~ label,
		.star-rating input[type=radio]:checked ~ label {
		color: #f2b600
		}
		</style>
	</head>
	<body>
		<div class="row">
		<br/>
		<br/>
		<br/>
		</div>
		<div class="row">
		<div class="col-xs-4 col-sm-4"></div>
		<div class="col-xs-3 col-sm-3">
			<div class="panel panel-warning">
			<div class="panel-heading">
			<?php
			if(isset($_GET['bus_id'])){
				$busid = $_GET['bus_id'];
				$queryString = "select avg(bus_rating) as rating from bus_rating where bus_id = '". $busid . "'";
				$query_result = mysqli_query($con,$queryString);
				echo ('The current rating is '. mysqli_fetch_array($query_result)['rating'] .' out of 5');
				mysqli_close($con);
			}
			else{
				mysqli_close($con);
				header("Location: ../index.php");
				die();
			}
		
			//http://localhost/get_rating.php?drvid=1234567890
			?>
			</div>
				<div class="panel-body">
					<form id="rating_form">
						<div class="star-rating">
							<input id="star-5" type="radio" name="rating" value="star-5">
							<label for="star-5" title="5 stars">
									<i class="active fa fa-star" aria-hidden="true"></i>
							</label>
							<input id="star-4" type="radio" name="rating" value="star-4">
							<label for="star-4" title="4 stars">
									<i class="active fa fa-star" aria-hidden="true"></i>
							</label>
							<input id="star-3" type="radio" name="rating" value="star-3">
							<label for="star-3" title="3 stars">
									<i class="active fa fa-star" aria-hidden="true"></i>
							</label>
							<input id="star-2" type="radio" name="rating" value="star-2">
							<label for="star-2" title="2 stars">
									<i class="active fa fa-star" aria-hidden="true"></i>
							</label>
							<input id="star-1" type="radio" name="rating" value="star-1">
							<label for="star-1" title="1 star">
									<i class="active fa fa-star" aria-hidden="true"></i>
							</label>
						</div>
						<!<input id="submit_rating" type="click" class="btn btn-success" value="Submit Rating">
					</form>
				</div>
			</div>
		</div>
		<div class="class col-xs-5 col-sm-5"></div>
		</div>
	</body>
	
	<script> 
		var i;
		var starArr = [];
		var ele = document.getElementById("rating_form");
		var busid = '<?php echo $busid; ?>';
		if(ele.addEventListener){
			ele.addEventListener("click", submit_callback, false);  //Modern browsers
		}else if(ele.attachEvent){
			ele.attachEvent('onclick', submit_callback);            //Old IE
		}
		
		function getStarRate(){
			var out = 0;
			for( i=0; i < 5 ; i++ ){
				if( document.getElementById("star-"+String(i+1)).checked){
						out = i+1;
				}
			}
			console.log(out);
			console.log("obtaining rating");
			return out;
		}
		
		function submit_callback() {
			console.log("submission detected");
			var rating = getStarRate();
			
			window.setTimeout(function(){

			window.location.href = "/../server_mobile.php?bus_id="+busid+"&rating="+String(rating);

			}, 1000);
		}
		
	</script>
</html>


