<!doctype html>
<?php
include '../connection.php';
session_start();
//find the current user
$user = $_SESSION["username"];
//find his level of security 
$secsql = "SELECT security_level
FROM employee
WHERE employee_name = '$user'";
$secResult = mysqli_query($link, $secsql);

while($row = mysqli_fetch_array($secResult)){
  $user_sec_lvl = $row[0];
}
if($user_sec_lvl < 4){
  echo "<a href='../Login/login.php'>Login Page</a></br>";
  die("You don't have the privlages to view this site.");
}
?>
<html>
	<head>
		  <link href='../css/bootstrap.min.css' rel='stylesheet'>
		  <link href='../css/main.css' rel='stylesheet'>
		  <script type="text/javascript" src='../js/passScript.js'></script>
		  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		  <script src='../js/bootstrap.min.js'></script>
		<script src="../js/Chart.js/Chart.js"></script>
	</head>
	<body>
		<?php include '../header.php'; ?>
		<h2>$Total$ for each company</h2>
		<div style="width: 50%">
			<canvas id="canvas" height="450" width="600"></canvas>
		</div>


	<script>
	var chartData = {
		labels : ["Jan", "Feb", "Mar", "April", "May", "June", "July", "Aug", "Sept", "Okt", "Nov", "Des"],
		datasets : [
			{
				label : "Company 1",
					fillColor : "rgba(55,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(11,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [4,1,3,4,6,3,8,2,1,2,6,7]	
			},
			{
					label : "Company 2",
					fillColor : "rgba(220,55,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(89,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [2,3,5,6,7,3,4,6,2,4,7,7]	
			},
			{
					label : "Company 3",
					fillColor : "rgba(220,220,55,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,7,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [7,1,7,2,3,4,9,8,4,5,3,1]	
			},
			{
					label : "Company 4",
					fillColor : "rgba(220,110,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,13,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [3,2,7,4,2,8,1,4,6,4,1,8]
			},
			
		]
				}

	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Line(chartData, {
			responsive : true
		});
	}

</script>
	</body>
</html>
