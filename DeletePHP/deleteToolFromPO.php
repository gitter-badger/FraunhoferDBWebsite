<!-- this file needs to be changed 100% -->
<?php
include '../connection.php';

$po_ID      = mysqli_real_escape_string($link, $_POST['po_ID']);
$line_item = mysqli_real_escape_string($link, $_POST['line']);

$sql = "DELETE FROM POTools 
		WHERE po_ID = '$po_ID'
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
