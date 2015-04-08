<?php
include '../connection.php';
 
// Escape user inputs for security
$cName        = mysqli_real_escape_string($link, $_POST['cName']);
$cAddress     = mysqli_real_escape_string($link, $_POST['cAddress']);
$cEmail       = mysqli_real_escape_string($link, $_POST['cEmail']);
$cPhone       = mysqli_real_escape_string($link, $_POST['cPhone']);
$cFax         = mysqli_real_escape_string($link, $_POST['cFax']);
$cContact     = mysqli_real_escape_string($link, $_POST['cContact']);
$cNotes       = mysqli_real_escape_string($link, $_POST['cNotes']);


if($cName == ""){
 	echo"The company needs a name!";
 }
 else{
// attempt insert query execution
$sql = "INSERT INTO Customers(cName, cAddress, cEmail, cPhone, cFax, last_order, nr_of_active_pos, cContact, cNotes) 
        VALUES ('$cName', '$cAddress', '$cEmail', '$cPhone', '$cFax', null, 0, '$cContact', '$cNotes')";

$result = mysqli_query($link, $sql);

}
// close connection
mysqli_close($link);
?>


