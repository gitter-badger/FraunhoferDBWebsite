<?php
include 'connection.php';
 
// Escape user inputs for security
$eName        = mysqli_real_escape_string($link, $_POST['eName']);
$eEmail       = mysqli_real_escape_string($link, $_POST['eEmail']);
$ePass        = mysqli_real_escape_string($link, $_POST['ePass']);
$ePassAgain   = mysqli_real_escape_string($link, $_POST['ePassAgain']);
$ePhoneNumber = mysqli_real_escape_string($link, $_POST['ePhoneNumber']);
 
 if($eName == ""){
 	echo"Employee needs a name!";
 }
 if($ePass != $ePassAgain){
 	die("The passwords do not match!" . mysqli_error($link));
 }
// attempt insert query execution
$sql = "INSERT INTO Employees(pass, ename, eEmail, ePhoneNumber) 
		VALUES ('$ePass', '$eName', '$eEmail', '$ePhoneNumber')";
$result = mysqli_query($link, $sql);
if($result){
    echo ("DATA SAVED SUCCESSFULLY");
} else{
    echo("Input data is fail");
}
 
// close connection
mysqli_close($link);
?>
