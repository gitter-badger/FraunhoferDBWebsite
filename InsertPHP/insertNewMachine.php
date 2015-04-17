<?php
include '../connection.php';
 
// Escape user inputs for security
$mName = mysqli_real_escape_string($link, $_POST['mname']);
$mAcro = mysqli_real_escape_string($link, $_POST['macro']);
// var_dump($mName);
//var_dump($mAcro);
/*
if(empty($mName) || empty($mAcro)){
	echo 'Missing info!';
	die("You have to fill out all the information")
}
*/
// attempt insert query execution
$sql = "INSERT INTO machine(machine_name, machine_acronym) VALUES ('$mName', '$mAcro')";
$result = mysqli_query($link, $sql);

if(!$result){
    die("Input data is fail" . mysqli_error($link));
}

 
// close connection
mysqli_close($link);
?>
