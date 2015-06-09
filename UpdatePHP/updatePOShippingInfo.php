<?php
include '../connection.php';

$po_ID   = mysqli_real_escape_string($link, $_POST['po_ID']);
$shipping_info   = mysqli_real_escape_string($link, $_POST['shipping_info']);


$sql = "UPDATE pos
        SET shipping_info = '$shipping_info'
        WHERE po_ID = '$po_ID'";   
$result = mysqli_query($link, $sql);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error();
}
mysqli_close($link);
?>