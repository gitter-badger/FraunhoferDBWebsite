<?php
include 'connection.php';


$poid      = mysqli_real_escape_string($link, $_POST['POID']);


$sql = "DELETE FROM POS
		WHERE POID = '$poid'";
$result = mysqli_query($link, $sql);

//if($rtoolresult){
//  echo ("Data deleted successfully");
//} else{
//  echo("Something went wrong");
//}
//
//if($result){
//  echo ("Data deleted successfully");
//} else{
//  echo("Something went wrong");
//}
mysqli_close($link);
?>