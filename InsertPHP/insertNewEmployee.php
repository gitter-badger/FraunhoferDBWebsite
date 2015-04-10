<?php
include '../connection.php';
 
// Escape user inputs for security
$eName        = mysqli_real_escape_string($link, $_POST['eName']);
$eEmail       = mysqli_real_escape_string($link, $_POST['eEmail']);
$ePass        = mysqli_real_escape_string($link, $_POST['ePass']);
$ePassAgain   = mysqli_real_escape_string($link, $_POST['ePassAgain']);
$ePhoneNumber = mysqli_real_escape_string($link, $_POST['ePhoneNumber']);
$sec_lvl      = mysqli_real_escape_string($link, $_POST['sec_lvl']);

 if(empty($eName)){
 	exit(0);
 }
 if($ePass != $ePassAgain){
 	die("The passwords do not match!" . mysqli_error($link));
 }
// attempt insert query execution
$sql = "INSERT INTO Employees(pass, ename, eEmail, ePhoneNumber, sec_lvl) 
		VALUES ('$ePass', '$eName', '$eEmail', '$ePhoneNumber', '$sec_lvl')";
$result = mysqli_query($link, $sql);
if(!$result){
    echo("Input data is fail" . mysqli_error($link));
}
 
// close connection
mysqli_close($link);
?>
