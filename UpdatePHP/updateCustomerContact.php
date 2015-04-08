<?php

include '../connection.php';

$CID           = mysqli_real_escape_string($link, $_POST['CID']);
$cContact      = mysqli_real_escape_string($link, $_POST['cContact']);

$sql =  "UPDATE Customers 
SET cContact = '$cContact'
WHERE CID = $CID";   
$result = mysqli_query($link, $sql);
mysqli_close($link);
?>