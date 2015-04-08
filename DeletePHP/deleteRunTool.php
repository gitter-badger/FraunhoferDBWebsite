<?php
include '../connection.php';

$poid      = mysqli_real_escape_string($link, $_POST['POID']);
$lineItem = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM RunPOS 
		WHERE POID = '$poid'
		AND line_item = '$lineItem'";
$result = mysqli_query($link, $sql);


if($result){
	 echo ("DATA SAVED SUCCESSFULLY");
} else{
	 echo("Input data is fail".mysqli_error($link));
}
mysqli_close($link);
?>
