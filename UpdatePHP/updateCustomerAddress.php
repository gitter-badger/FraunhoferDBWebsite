<?php
/*
	Updates the customer address
	Get the user input and use the customer_ID 
	to find the right customer
*/
include '../connection.php';

$customer_ID      = mysqli_real_escape_string($link, $_POST['CID']);
$cAddress = mysqli_real_escape_string($link, $_POST['cAddress']);

$sql = "UPDATE customer 
		SET customer_address = '$cAddress'
		WHERE customer_ID = $customer_ID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>