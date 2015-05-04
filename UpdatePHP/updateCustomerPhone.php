<?php
/*
	Updates the customer phone number
	Get the user input and use the customer_ID 
	to find the right customer
*/
include '../connection.php';

$customer_ID    = mysqli_real_escape_string($link, $_POST['CID']);
$cPhone = mysqli_real_escape_string($link, $_POST['cPhone']);

$sql = "UPDATE customer 
        SET customer_phone = '$cPhone'
        WHERE customer_ID  = $customer_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
    die($message);
}
mysqli_close($link);
?>