<?php
/*
	This file deletes a lineitem from the linked run.
	I.e deletes a line in the lineitem_run table.
	We need to use the run_number here so we dont delete more than one
	line, since a tool might be coded more than once in some cases.
	If there is an error we let the user know with a mysqli_error message
	If there were no errors our jquery refreshes the table so the user sees the change
*/
include '../connection.php';
 
$po_ID      = mysqli_real_escape_string($link, $_POST['POID']);
$line_on_po = mysqli_real_escape_string($link, $_POST['lineitem']);
$run_number = mysqli_real_escape_string($link, $_POST['run_number']);

// getting the right po_ID
$po_IDSql = "SELECT p.po_ID
             FROM   pos p
             WHERE p.po_number = '$po_ID';";
$po_IDResult = mysqli_query($link, $po_IDSql);

while($row = mysqli_fetch_array($po_IDResult)){
    $po_ID = $row[0];
}

// find the right run_ID from the run_number
$runSql = "SELECT run_ID
		   FROM run
		   WHERE run_number = '$run_number';";
$runResult = mysqli_query($link, $runSql);
while($row = mysqli_fetch_array($runResult)){
	$run_ID = $row[0];
}
// now we need to find the lineitem_ID using the lineitem and po_ID we got from the user

$lineitemSql = "SELECT lineitem_ID
				FROM lineitem
				WHERE po_ID = '$po_ID'
				AND line_on_po = '$line_on_po'";

$lineitemResult = mysqli_query($link, $lineitemSql);

while($row = mysqli_fetch_array($lineitemResult)){
    $lineitem_ID = $row[0];
}

// now we have the two variables we need run_ID and lineitem_ID 
// we will use them to delete from the lineitem_run table
//var_dump($run_ID);
//var_dump($lineitem_ID);
$deleteSql = "DELETE FROM lineitem_run
			  WHERE run_ID = '$run_ID'
			  AND lineitem_ID = '$lineitem_ID';";

$deleteResult = mysqli_query($link, $deleteSql);

if(!$deleteResult){
	 echo ("Error deleting" . mysqli_error($link));
}
mysqli_close($link);
?>
