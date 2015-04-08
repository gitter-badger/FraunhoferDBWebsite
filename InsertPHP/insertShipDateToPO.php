<?php
include '../connection.php';
// Escape user inputs for security

$POID 	  = mysqli_real_escape_string($link, $_POST['POID']);
$date 	  = mysqli_real_escape_string($link, $_POST['date']);
$fInspect = mysqli_real_escape_string($link, $_POST['fInspect']);
// attempt insert query execution

$sumSql = "SELECT round(sum(t.tPrice * pot.quantity),2)
		   FROM tools t, POS p, POTools pot
		   WHERE p.POID = '$POID'
		   AND p.POID = pot.POID
		   AND pot.TID = t.TID
		   AND p.CID = t.CID;";
$sumResult = mysqli_query($link, $sumSql);

while($row = mysqli_fetch_array($sumResult)){
	$finalPrice = $row[0];	
}
var_dump($finalPrice);
$sql1 = "SET SQL_SAFE_UPDATES=0;";

$sql2 ="UPDATE POS SET shipping_date ='$date' WHERE POID='$POID'";
$sql3 ="UPDATE POS SET final_inspection = '$fInspect' WHERE POID='$POID'";
$sql4 ="UPDATE POS SET final_price = '$finalPrice' WHERE POID='$POID'";
$sql5 = "SQL_SAFE_UPDATES=1;";

$result1 = mysqli_query($link, $sql1);
$result2 = mysqli_query($link, $sql2);
$result3 = mysqli_query($link, $sql3);
$result4 = mysqli_query($link, $sql4);
$result5 = mysqli_query($link, $sql5);

if($result4){
	 echo ("DATA SAVED SUCCESSFULLY");
} else{
	 echo("Input data is fail".mysqli_error($link));
}
// close connection
mysqli_close($link);

?>


