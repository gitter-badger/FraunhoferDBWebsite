<?php

include '../connection.php';

$CID      = mysqli_real_escape_string($link, $_POST['CID']);
$cAddress = mysqli_real_escape_string($link, $_POST['cAddress']);

$sql = "UPDATE customer 
		SET customer_address = '$cAddress'
		WHERE customer_ID = $CID";   
$result = mysqli_query($link, $sql);

if (!$result) {
	$message  = 'Invalid query: ' . mysqli_error($link) . "\n";
	$message .= 'Whole query: ' . $query;
	die($message);
}

?>