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
if($user_sec_lvl < 2){
	echo "<a href='../Login/login.php'>Login Page</a></br>";
	die("You don't have the privlages to view this site.");
}
// Get customer info
$customerSql = "SELECT c.customer_ID, c.customer_name
				FROM customer c";
$customerResult = mysqli_query($link, $customerSql);

if (!$customerResult) {
    $message  = 'Invalid query: ' . mysql_error();
    die($message);
}

$cust_ID_array = array();
$cust_name_array = array();
$cust_ID_array[0] .= 0;
$cust_name_array[0] .= 0;
while($row = mysqli_fetch_array($customerResult)){
	$cust_ID_array[] .= $row[0];
	$cust_name_array[] .= $row[1];
}
$custCount = count($cust_ID_array);
?>
<html>
<head>
	<link href='../css/bootstrap.min.css' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src='../js/bootstrap.min.js'></script>
	<script src="../js/Chart.js/Chart.js"></script>
</head>
<body>
	<?php include '../header.php'; ?>
	<!-- PHP loop this as often as customer_length -->
	<?php
		echo "<p id='cust_count' style='display: none;'>".$custCount."</p>";
		for ($i = 1; $i <= $custCount; $i++) { 
			echo "<div style='width: 50%' class='col-md-12 col-md-offset-3'>
				  	<h2>".$cust_name_array[$i]."</h2>
				  	<canvas id='canvas".$i."' height='450' width='600'></canvas>
				  </div>";
		}
	?>
	<?php
	for ($i=1; $i < $custCount; $i++) { 
	echo 
			"<script>
			setTimeout( function(){ 
				generateGraphs".$i."();
		 		 }  , 1000 );
			</script>";
	}
	?>
	<?php 
	$divCount = 0;
	for ($i=1; $i <= $custCount; $i++) { 
	echo "<script>
	function generateGraphs".$i."(){";

	echo "
				var mycompany = {
				labels : [";
							$poSql = "SELECT MONTHNAME(shipping_date), ROUND(SUM(p.final_price), 2)
									  FROM pos p, customer c
									  WHERE p.customer_ID = c.customer_ID
									  AND c.customer_ID = '$i'
									  AND po_ID NOT IN (SELECT po_ID
									  					FROM pos
									  					WHERE shipping_date IS NULL)
									  GROUP BY MONTH(shipping_date);";

							$poResult= mysqli_query($link, $poSql);
							while($row = mysqli_fetch_array($poResult)){
								echo '"'.$row[0].'",';
							}
						echo "],"; // Months
    echo "
				datasets : [
				{
					fillColor : 'rgba(151,187,205,0.2)',
					strokeColor : 'rgba(151,187,205,1)',
					pointColor : 'rgba(151,187,205,1)',
					pointStrokeColor : '#fff',
					pointHighlightFill : '#fff',
					pointHighlightStroke : 'rgba(151,187,205,1)',
					data : [";
								$poSql = "SELECT MONTHNAME(shipping_date), ROUND(SUM(p.final_price), 2)
										  FROM pos p, customer c
										  WHERE p.customer_ID = c.customer_ID
										  AND c.customer_ID = '$i'
										  AND po_ID NOT IN (SELECT po_ID
										  					FROM pos
										  					WHERE shipping_date IS NULL)
										  GROUP BY MONTH(shipping_date);";

								$poResult= mysqli_query($link, $poSql);
								while($row = mysqli_fetch_array($poResult)){
									echo '"'.$row[1].'",';
								}
    echo "				  ]
				},
				]
			}
	var myCtx;
		var rightID = 'canvas' + ".$i.";
	    myCtx = document.getElementById(rightID).getContext('2d');
	    window.myBar = new Chart(myCtx).Line(mycompany, {
	        responsive : true
	    });
};
</script>";
$divCount = $divCount + 1;
}
?>
</body>
</html>
