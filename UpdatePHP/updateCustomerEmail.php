<?php

include '../connection.php';

$CID    = mysqli_real_escape_string($link, $_POST['CID']);
$cEmail = mysqli_real_escape_string($link, $_POST['cEmail']);

$sql = "UPDATE customer
        SET customer_email = '$cEmail'
        WHERE customer_ID = $CID";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
    die($message);
}
mysqli_close($link);
?>