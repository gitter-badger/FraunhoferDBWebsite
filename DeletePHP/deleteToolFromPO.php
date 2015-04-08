<?php
include '../connection.php';

$poid      = mysqli_real_escape_string($link, $_POST['POID']);
$line_item = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM POTools 
		WHERE POID = '$poid'
		AND line_item = '$line_item'";
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
