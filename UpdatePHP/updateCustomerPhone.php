<?php

include '../connection.php';

$CID    = mysqli_real_escape_string($link, $_POST['CID']);
$cPhone = mysqli_real_escape_string($link, $_POST['cPhone']);

$sql = "UPDATE customer 
        SET customer_phone = '$cPhone'
        WHERE customer_ID  = $CID";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}
mysqli_close($link);
?>