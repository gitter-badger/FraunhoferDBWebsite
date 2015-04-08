<?php
include '../connection.php';
 
// Escape user inputs for security
$eName        = mysqli_real_escape_string($link, $_POST['eName']);
$eEmail       = mysqli_real_escape_string($link, $_POST['eEmail']);
$ePass        = mysqli_real_escape_string($link, $_POST['ePass']);
$ePassAgain   = mysqli_real_escape_string($link, $_POST['ePassAgain']);
$ePhoneNumber = mysqli_real_escape_string($link, $_POST['ePhoneNumber']);
$sec_lvl      = mysqli_real_escape_string($link, $_POST['sec_lvl']);

echo $sec_lvl;
echo $eName;
var_dump($eName);
var_dump($sec_lvl);
 if($eName == ""){
 	echo"Employee needs a name!";
 }
 if($ePass != $ePassAgain){
 	die("The passwords do not match!" . mysqli_error($link));
 }
// attempt insert query execution
$sql = "INSERT INTO Employees(pass, ename, eEmail, ePhoneNumber, sec_lvl) 
		VALUES ('$ePass', '$eName', '$eEmail', '$ePhoneNumber', '$sec_lvl')";
$result = mysqli_query($link, $sql);
if($result){
    echo ("DATA SAVED SUCCESSFULLY");
} else{
    echo("Input data is fail");
}
 
// close connection
mysqli_close($link);
?>
