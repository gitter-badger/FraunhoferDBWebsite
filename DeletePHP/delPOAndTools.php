<!-- this file needs to be changed 100% -->
<?php
include '../connection.php';


$poid      = mysqli_real_escape_string($link, $_POST['POID']);

$workedOnSql = "DELETE FROM WorkedOn 
				WHERE POID = '$poid'";
$workedonResult = mysqli_query($link, $workedOnSql);

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