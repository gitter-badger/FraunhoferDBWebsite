<?php

include '../connection.php';

$CID      = mysqli_real_escape_string($link, $_POST['CID']);
$cContact = mysqli_real_escape_string($link, $_POST['cContact']);

$sql =  "UPDATE customer 
	 	 SET customer_contact = '$cContact'
	 	 WHERE customer_ID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>
