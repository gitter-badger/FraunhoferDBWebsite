<?php

include 'connection.php';

$CID         = mysqli_real_escape_string($link, $_POST['CID']);
$cPhone     = mysqli_real_escape_string($link, $_POST['cPhone']);

$sql = "UPDATE Customers 
         SET cPhone = '$cPhone'
         WHERE CID = $CID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
mysqli_close($link);
?>