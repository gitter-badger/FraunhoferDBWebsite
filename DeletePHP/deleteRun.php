<?php
/*
	This file deletes a run on a POS tracksheet. I.e. removes the run from the pos_run table
	If this is the last PO that has this run on its tracksheet
	the run is also deleted from the run table
	we do this by calling a procedure in MySQL called check_delete_run found in procedures.sql
*/


/*
	TODO:
		1. Get the po_number from the user
		2. Generate the po_ID from the po_number
		3. Get the run_number from the user
		4. Generate the run_ID from the run_number
		5. Set the variables for the procedure call
		6. Call the check_delete_run procedure
		7. Alert the user if an error came up
		8. If no errors happened. Go have a beer.
		9. GOTO 8
*/
include '../connection.php';

$po_number     = mysqli_real_escape_string($link, $_POST['POID']);
$run_number	   = mysqli_real_escape_string($link, $_POST['line']);
//getting the right po_ID
$po_IDsql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$po_number';";
$po_IDresult = mysqli_query($link, $po_IDsql);

while($row = mysqli_fetch_array($po_IDresult)){
    $po_ID = $row[0];
}
$run_IDsql = "SELECT run_ID
			  FROM run
			  WHERE run_number = '$run_number';";
$run_IDresult = mysqli_query($link, $run_IDsql);
while($row = mysqli_fetch_array($run_IDresult)){
	$run_ID = $row[0];
}

$set_run_ID = "SET @run_ID = '$run_ID';";
$set_run_ID_result = mysqli_query($link, $set_run_ID);

$set_po_ID = "SET @po_ID = '$po_ID';";
$set_po_ID_result = mysqli_query($link, $set_po_ID);


$sql = "CALL check_delete_run(@po_ID, @run_ID);";
$result = mysqli_query($link, $sql);



if(!$result){
  echo ("There was an error deleting the run" . mysql_error($link));
}
mysqli_close($link);
?>
