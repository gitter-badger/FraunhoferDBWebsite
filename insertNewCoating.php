Implement when you have more info.

<?php
include 'connection.php';
// Escape user inputs for security
$cName = mysqli_real_escape_string($link, $_POST['cName']);
$cAddress = mysqli_real_escape_string($link, $_POST['cAddress']);
$cEmail = mysqli_real_escape_string($link, $_POST['cEmail']);
$cPhone = mysqli_real_escape_string($link, $_POST['cPhone']);
$cFax = mysqli_real_escape_string($link, $_POST['nrOfLines']);
 
// attempt insert query execution
$sql = "INSERT INTO Customers(cName, cAddress, cEmail, cPhone, cFax, last_order, nr_of_active_pos) VALUES ('$cName', '$cAddress', '$cEmail', '$cPhone', '$cFax', null, 0)";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>


