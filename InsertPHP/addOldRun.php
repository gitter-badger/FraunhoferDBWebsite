<?php
/*
	This file inserts a connection between an already existing run
	and a PO.
	 We need to query the database to find witch run_number on the po it is.
*/

include '../connection.php';

$po_number = mysqli_real_escape_string($link, $_POST['POID']);
$run_ID	   = mysqli_real_escape_string($link, $_POST['old_run']);

//getting the right po_ID
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$po_number';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_ID = $row[0];
}
// find the next run number on po by selecting the highest one in the database
// and adding 1 to it

$runOnPoSql = "SELECT MAX(run_number_on_po)
			   FROM pos_run
			   WHERE po_ID = '$po_ID';";
$runOnPoResult = mysqli_query($link, $runOnPoSql);
while($row = mysqli_fetch_array($runOnPoResult)){
	$right_run_number = $row[0];
}

$right_run_number++;

$insertSql = "INSERT INTO pos_run VALUES('$run_ID', '$po_ID', '$right_run_number')";

$insertResult = mysqli_query($link, $insertSql);
if(!$insertResult){
  echo ("There was an error deleting the run" . mysql_error($link));
}
mysqli_close($link);
?>
