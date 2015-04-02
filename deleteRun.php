<?php
include 'connection.php';

$poid      = mysqli_real_escape_string($link, $_POST['POID']);
$RID	   = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM Runs 
		WHERE POID = '$poid'
		AND run_number = '$RID'";
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
