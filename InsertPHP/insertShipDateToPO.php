<?php
include '../connection.php';
// Escape user inputs for security

$po_ID 	  = mysqli_real_escape_string($link, $_POST['POID']);
$date 	  = mysqli_real_escape_string($link, $_POST['date']);
$fInspect = mysqli_real_escape_string($link, $_POST['fInspect']);

//getting the right po_ID
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$po_ID';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_ID = $row[0];
}
// find the over all price of the PO
$sumSql = "SELECT round(sum(l.price * l.quantity),2)
		   FROM lineitem l
		   WHERE l.po_ID = '$po_ID';";
$sumResult = mysqli_query($link, $sumSql);

while($row = mysqli_fetch_array($sumResult)){
	$finalPrice = $row[0];	
}
// sets the sql safe update off so you can update tables.
$sql1 = "SET SQL_SAFE_UPDATES=0;";
$sql2 ="UPDATE pos SET shipping_date = '$date' WHERE po_ID = '$po_ID'";
$sql3 ="UPDATE pos SET final_inspection = '$fInspect' WHERE po_ID = '$po_ID'";
$sql4 ="UPDATE pos SET final_price = '$finalPrice' WHERE po_ID = '$po_ID'";
// turns the safe update feature back on
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


