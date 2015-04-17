<!-- This file should find the right run_ID and delete from that info -->
<?php
include '../connection.php';

$po_ID         = mysqli_real_escape_string($link, $_POST['po_ID']);
$run_number	   = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM run 
		WHERE po_ID = '$po_ID'
		AND run_number = '$run_number'";
$result = mysqli_query($link, $sql);


/*
if($result){
  echo ("Data deleted successfully");
} else{
  echo("Something went wrong");
}
*/
mysqli_close($link);
?>
