<?php
include '../connection.php';

$po_ID 	   = mysqli_real_escape_string($link, $_POST['po_ID']);
$line  	   = mysqli_real_escape_string($link, $_POST['line']);
$quantity  = mysqli_real_escape_string($link, $_POST['quantity']);

$sql = "UPDATE lineitem
        SET quantity = '$quantity'
        WHERE po_ID = $po_ID
        AND line_on_po = '$line'";   
$result = mysqli_query($link, $sql);
if (!$result) {
    $message  = 'Error: ' . mysql_error();
    die($message);
}
mysqli_close($link);
?>