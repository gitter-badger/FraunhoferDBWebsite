<!-- This file needs to be changed 100%  -->

<?php
include '../connection.php';

$po_ID      = mysqli_real_escape_string($link, $_POST['po_ID']);
$lineItem = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM RunPOS 
		WHERE po_ID = '$po_ID'
		AND line_item = '$lineItem'";
$result = mysqli_query($link, $sql);


if($result){
	 echo ("DATA SAVED SUCCESSFULLY");
} else{
	 echo("Input data is fail".mysqli_error($link));
}
mysqli_close($link);
?>
